<?php

/**
 * This file is part of DeltaCMS.
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 * @author Sylvain Lelièvre <lelievresylvain@free.fr>
 * @copyright Copyright (C) 2021, Sylvain Lelièvre
 * @license GNU General Public License, version 3
 * @link https://deltacms.fr/
 *
 * Delta was created from version 11.2.00.24 of ZwiiCMS
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2018, Rémi Jean
 * @author Frédéric Tempez <frederic.tempez@outlook.com>
 * @copyright Copyright (C) 2018-2021, Frédéric Tempez
 */

class news extends common {

	const VERSION = '5.2';
	const REALNAME = 'News';
	const DELETE = true;
	const UPDATE = '0.0';
	const DATADIRECTORY =  self::DATA_DIR . 'news/';

	public static $actions = [
		'add' => self::GROUP_EDITOR,
		'config' => self::GROUP_EDITOR,
		'delete' => self::GROUP_MODERATOR,
		'edit' => self::GROUP_EDITOR,
		'index' => self::GROUP_VISITOR,
		'rss' => self::GROUP_VISITOR
	];

	public static $news = [];

	public static $comments = [];

	public static $pages;

	public static $users = [];

	// Nombre d'objets par page
	public static $itemsList = [
		4 => '4 articles',
		8 => '8 articles',
		12 => '12 articles',
		16 => '16 articles',
		22 => '22 articles'
	];

	public static $nbrCol = 1;

	// Signature de l'article
	public static $articleSignature = '';


	/**
	 * Flux RSS
	 */
	public function rss() {
		// Inclure les classes
		include_once 'module/news/vendor/FeedWriter/Item.php';
		include_once 'module/news/vendor/FeedWriter/Feed.php';
		include_once 'module/news/vendor/FeedWriter/RSS2.php';
		include_once 'module/news/vendor/FeedWriter/InvalidOperationException.php';

		date_default_timezone_set('UTC');

		$feeds = new \FeedWriter\RSS2();

		// En-tête
		$feeds->setTitle($this->getData (['page', $this->getUrl(0),'title']));
		$feeds->setLink(helper::baseUrl() . $this->getUrl(0));
		$feeds->setDescription($this->getData (['page', $this->getUrl(0), 'metaDescription']));
		$feeds->setChannelElement('language', 'fr-FR');
		$feeds->setDate(date('r',time()));
		$feeds->addGenerator();
		// Corps des articles
		$newsIdsPublishedOns = helper::arrayCollumn($this->getData(['data_module', $this->getUrl(0), 'posts']), 'publishedOn', 'SORT_DESC');
		$newsIdsStates = helper::arrayCollumn($this->getData(['data_module', $this->getUrl(0), 'posts']), 'state', 'SORT_DESC');
		foreach($newsIdsPublishedOns as $newsId => $newsPublishedOn) {
			if($newsPublishedOn <= time() AND $newsIdsStates[$newsId]) {
				$newsArticle = $feeds->createNewItem();
				$author = $this->signature($this->getData(['data_module', $this->getUrl(0),  'posts', $newsId, 'userId']));
				$newsArticle->addElementArray([
					'title' 		=> $this->getData(['data_module', $this->getUrl(0),'posts', $newsId, 'title']),
					'link' 			=> helper::baseUrl() . $this->getUrl(0) . '/' . $newsId . '#' . $newsId,
					'description' 	=> $this->getData(['data_module', $this->getUrl(0),'posts', $newsId, 'content'])
				]);
				$newsArticle->setAuthor($author,'no@mail.com');
				$newsArticle->setId(helper::baseUrl() .$this->getUrl(0) . '/' . $newsId . '#' . $newsId);
				$newsArticle->setDate(date('r', $this->getData(['data_module', $this->getUrl(0), 'posts', $newsId, 'publishedOn'])));
				$feeds->addItem($newsArticle);
			}
		}

		// Valeurs en sortie
		$this->addOutput([
			'display' => self::DISPLAY_RSS,
			'content' => $feeds->generateFeed(),
			'view' => 'rss'
		]);
	}

	/**
	 * Ajout d'un article
	 */
	public function add() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < news::$actions['add'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/news/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_news.php');
			// Soumission du formulaire
			if($this->isPost()) {
				// Crée la news
				$newsId = helper::increment($this->getInput('newsAddTitle', helper::FILTER_ID), (array) $this->getData(['data_module', $this->getUrl(0), 'posts']));
				$publishedOn = $this->getInput('newsAddPublishedOn', helper::FILTER_DATETIME, true);
				$publishedOff = $this->getInput('newsAddPublishedOff' ) ? $this->getInput('newsAddPublishedOff', helper::FILTER_DATETIME) : '';
				$this->setData(['data_module', $this->getUrl(0),'posts', $newsId, [
					'content' => $this->getInput('newsAddContent', null),
					'publishedOn' => $publishedOn,
					'publishedOff' => $publishedOff,
					'state' => $this->getInput('newsAddState', helper::FILTER_BOOLEAN),
					'title' => $this->getInput('newsAddTitle', helper::FILTER_STRING_SHORT, true),
					'userId' => $this->getInput('newsAddUserId', helper::FILTER_ID, true)
				]]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['news']['add'][0],
					'state' => true
				]);
			}
			// Mise à jour ou création du fichier site/data/news/themeNews.css
			$style =  '.editorWysiwyg{';
			$style .= 'background-color:' . $this->getData(['module', $this->getUrl(0), 'theme', 'backgroundColor']) . ';';
			$style .= '}';
			$style .= '.editorWysiwyg a{ color:'. $this->getData(['module', $this->getUrl(0), 'theme', 'linkColor']) .'}';
			$style .= 'p{ color:'. $this->getData(['module', $this->getUrl(0), 'theme', 'textColor']) .'}';
			$style .= 'h1, h2, h3, h4, h5, h6{ color:'. $this->getData(['module', $this->getUrl(0), 'theme', 'titleColor']) .'}';
			file_put_contents(self::DATADIRECTORY . 'themeNews.css', $style );

			// Liste des utilisateurs
			self::$users = helper::arrayCollumn($this->getData(['user']), 'firstname');
			ksort(self::$users);
			foreach(self::$users as $userId => &$userFirstname) {
				$userFirstname = $userFirstname . ' ' . $this->getData(['user', $userId, 'lastname']);
			}
			unset($userFirstname);
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['news']['add'][1],
				'vendor' => [
					'flatpickr',
					'tinymce'
				],
				'view' => 'add'
			]);
		}
	}

	/**
	 * Configuration
	 */
	public function config() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < news::$actions['config'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/news/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_news.php');
			// Soumission du formulaire
			if($this->isPost()) {

				// Générer la feuille de CSS
				$style =  '.newsFrame {';
				$style .= 'border: solid ' . $this->getInput('newsThemeBorderColor')  . ' ' . $this->getInput('newsThemeBorderWidth',helper::FILTER_STRING_SHORT) . ';';
				$style .= 'border-radius:' . $this->getInput('newsBorderRadius',helper::FILTER_STRING_SHORT).';';
				$style .= 'box-shadow:' . $this->getInput('newsBorderShadows',helper::FILTER_STRING_SHORT).';';
				$style .= 'background-color:' . $this->getInput('newsThemeBackgroundColor') . ';';
				$style .= 'color:' . $this->getInput('newsThemeTextColor') . ';';
				$style .= '}';
				$style .= '.newsFrame a{ color:'. $this->getInput('newsThemeLinkColor') .'}';
				$style .= '.newsFrame h1,.newsFrame h2,.newsFrame h3,.newsFrame h4,.newsFrame h5,.newsFrame h6{ color:'. $this->getInput('newsThemeTitleColor') .'}';
				$style .= '.newsSignature { color:' . $this->getInput('newsThemeSignatureColor') . ';';
				// Générer la feuille de CSS avec les couleurs inverses
				$style_invert =  '.newsFrame {';
				$style_invert .= 'border: solid ' . helper::invertColor($this->getInput('newsThemeBorderColor'))  . ' ' . $this->getInput('newsThemeBorderWidth',helper::FILTER_STRING_SHORT) . ';';
				$style_invert .= 'border-radius:' . $this->getInput('newsBorderRadius',helper::FILTER_STRING_SHORT).';';
				$style_invert .= 'box-shadow:' . $this->getInput('newsBorderShadows',helper::FILTER_STRING_SHORT).';';
				$style_invert .= 'background-color:' . helper::invertColor($this->getInput('newsThemeBackgroundColor')) . ';';
				$style_invert .= 'color:' . helper::invertColor($this->getInput('newsThemeTextColor')) . ';';
				$style_invert .= '}';
				$style_invert .= '.newsFrame a{ color:'. helper::invertColor($this->getInput('newsThemeLinkColor')) .'}';
				$style_invert .= '.newsFrame h1,.newsFrame h2,.newsFrame h3,.newsFrame h4,.newsFrame h5,.newsFrame h6{ color:'. helper::invertColor($this->getInput('newsThemeTitleColor')) .'}';
				$style_invert .= '.newsSignature { color:' . helper::invertColor($this->getInput('newsThemeSignatureColor')) . ';';				
				// Dossier de l'instance
				$dircss = self::DATA_DIR.self::$i18n.'/data_module/news/'. $this->getUrl(0);
				if( !is_dir($dircss)) mkdir($dircss, 0755, true);
				$success = file_put_contents($dircss . '/theme.css', $style );
				$success = file_put_contents($dircss . '/theme_invert.css', $style_invert );				
				// Fin feuille de style

				$this->setData(['module', $this->getUrl(0), 'theme',[
					'style'       => $success ? $dircss . '/theme.css' : '',
					'style_invert' => $success ? $dircss . '/theme_invert.css' : '', 
					'borderColor' => $this->getInput('newsThemeBorderColor'),
					'borderWidth'	  => $this->getInput('newsThemeBorderWidth',helper::FILTER_STRING_SHORT),
					'backgroundColor' => $this->getInput('newsThemeBackgroundColor'),
					'textColor' => $this->getInput('newsThemeTextColor'),
					'titleColor' => $this->getInput('newsThemeTitleColor'),
					'linkColor' => $this->getInput('newsThemeLinkColor'),
					'signatureColor' => $this->getInput('newsThemeSignatureColor'),
					'borderRadius' => $this->getInput('newsBorderRadius',helper::FILTER_STRING_SHORT),
					'borderShadows' => $this->getInput('newsBorderShadows',helper::FILTER_STRING_SHORT)
				]]);

				$this->setData(['module', $this->getUrl(0), 'config',[
					'feeds' 	 => $this->getInput('newsConfigShowFeeds',helper::FILTER_BOOLEAN),
					'feedsLabel' => $this->getInput('newsConfigFeedslabel',helper::FILTER_STRING_SHORT),
					'itemsperPage' => $this->getInput('newsConfigItemsperPage', helper::FILTER_INT,true),
					'itemsperCol' => $this->getInput('newsConfigItemsperCol', helper::FILTER_INT,true),
					'height' => $this->getInput('newsConfigHeight', helper::FILTER_INT,true),
					'versionData' => $this->getData(['module', $this->getUrl(0), 'config', 'versionData']),
					'hiddeTitle' => $this->getInput('newsThemeTitle',helper::FILTER_BOOLEAN),
					'hideMedia' => $this->getInput('newsThemeMedia',helper::FILTER_BOOLEAN),
					'sameHeight' => $this->getInput('newsThemeSameHeight',helper::FILTER_BOOLEAN),
					'noMargin' => $this->getInput('newsThemeNoMargin',helper::FILTER_BOOLEAN)
				]]);
				$this->setData(['module', $this->getUrl(0), 'config', 'texts',[
					'readmore' => $this->getInput('newsConfigTextsReadmore',helper::FILTER_STRING_SHORT),
					'back' => $this->getInput('newsConfigTextsBack',helper::FILTER_STRING_SHORT),
					'noNews' => $this->getInput('newsConfigTextsNoNews',helper::FILTER_STRING_SHORT)
				]]);

				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['news']['config'][0],
					'state' => true
				]);
			} else {
				// Ids des news par ordre de publication
				$newsIds = array_keys(helper::arrayCollumn($this->getData(['data_module', $this->getUrl(0), 'posts']), 'publishedOn', 'SORT_DESC'));
				// Pagination
				$pagination = helper::pagination($newsIds, $this->getUrl(),$this->getData(['module', $this->getUrl(0), 'config', 'itemsperPage']) );
				// Liste des pages
				self::$pages = $pagination['pages'];
				// News en fonction de la pagination
				// Pour les dates suivant la langue d'administration
				if( function_exists('datefmt_create') && function_exists('datefmt_create') && extension_loaded('intl') ){
					$lang = $text['news']['config'][4]; 
					$zone = $text['news']['config'][5];
					$fmt = datefmt_create(
						$lang,
						IntlDateFormatter::LONG,
						IntlDateFormatter::SHORT,
						$zone,
						IntlDateFormatter::GREGORIAN
					);
				}
				for($i = $pagination['first']; $i < $pagination['last']; $i++) {
					// Met en forme le tableau
					if( function_exists('datefmt_create') && function_exists('datefmt_create') && extension_loaded('intl') ){
						$dateOn = datefmt_format($fmt, strtotime( date('Y/m/d H:i:s',$this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'publishedOn']))));
					} else {
						$dateOn = mb_detect_encoding(date('d/m/Y',  $this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'publishedOn'])), 'UTF-8', true)
								? date('d/m/Y', $this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'publishedOn']))
								: helper::utf8Encode(date('d/m/Y', $this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'publishedOn'])));
						$dateOn .= $text['news']['config'][3];
						$dateOn .= mb_detect_encoding(date('H:i',  $this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'publishedOn'])), 'UTF-8', true)
								? date('H:i', $this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'publishedOn']))
								: helper::utf8Encode(date('H:i', $this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'publishedOn'])));
					}
					if ($this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'publishedOff'])) {
						if( function_exists('datefmt_create') && function_exists('datefmt_create') && extension_loaded('intl') ){
							$dateOff = datefmt_format($fmt, strtotime( date('Y/m/d H:i:s',$this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'publishedOff']))));
						} else {
							$dateOff = mb_detect_encoding(date('d/m/Y',  $this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'publishedOff'])), 'UTF-8', true)
								? date('d/m/Y', $this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'publishedOff']))
								: helper::utf8Encode(date('d/m/Y', $this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'publishedOff'])));
							$dateOff .=	$text['news']['config'][3];
							$dateOff .= mb_detect_encoding(date('H:i',  $this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'publishedOff'])), 'UTF-8', true)
								? date('H:i', $this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'publishedOff']))
								: helper::utf8Encode(date('H:i', $this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'publishedOff'])));						
						}
					} else {
						$dateOff = $text['news']['config'][1];
					}
					self::$news[] = [
						$this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'title']),
						$dateOn,
						$dateOff,
						$states[$this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i], 'state'])],
						template::button('newsConfigEdit' . $newsIds[$i], [
							'href' => helper::baseUrl() . $this->getUrl(0) . '/edit/' . $newsIds[$i]. '/' . $_SESSION['csrf'],
							'value' => template::ico('pencil')
						]),
						template::button('newsConfigDelete' . $newsIds[$i], [
							'class' => 'newsConfigDelete buttonRed',
							'href' => helper::baseUrl() . $this->getUrl(0) . '/delete/' . $newsIds[$i] . '/' . $_SESSION['csrf'],
							'value' => template::ico('cancel'),
							'disabled' => $this->getUser('group') >= self::GROUP_MODERATOR ? false : true
						])
					];
				}
				// Valeurs en sortie
				$this->addOutput([
					'title' => $text['news']['config'][2],
					'view' => 'config',
					'vendor' => [
						'tinycolorpicker'
					]
				]);
			}
		}
	}

	/**
	 * Suppression
	 */
	public function delete() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < news::$actions['delete'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/news/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_news.php');		
			// La news n'existe pas
			if($this->getData(['data_module', $this->getUrl(0),'posts', $this->getUrl(2)]) === null) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			}
			// Jeton incorrect
			elseif ($this->getUrl(3) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . $this->getUrl(0) . '/config',
					'notification' => $text['news']['delete'][0]
				]);
			}
			// Suppression
			else {
				$this->deleteData(['data_module', $this->getUrl(0),'posts', $this->getUrl(2)]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['news']['delete'][1],
					'state' => true
				]);
			}
		}
	}

	/**
	 * Édition
	 */
	public function edit() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < news::$actions['edit'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/news/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_news.php');	
			// Jeton incorrect
			if ($this->getUrl(3) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['news']['edit'][0]
				]);
			}
			// La news n'existe pas
			if($this->getData(['data_module', $this->getUrl(0),'posts', $this->getUrl(2)]) === null) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			}
			// La news existe
			else {
				// Soumission du formulaire
				if($this->isPost()) {
					// Si l'id a changée
					$newsId = $this->getInput('newsEditTitle', helper::FILTER_ID, true);
					if($newsId !== $this->getUrl(2)) {
						// Incrémente le nouvel id de la news
						$newsId = helper::increment($newsId, $this->getData(['data_module', $this->getUrl(0), 'posts']));
						// Supprime l'ancien news
						$this->deleteData(['data_module', $this->getUrl(0),'posts', $this->getUrl(2)]);
					}
					$publishedOn = $this->getInput('newsEditPublishedOn', helper::FILTER_DATETIME, true);
					$publishedOff = $this->getInput('newsEditPublishedOff' ) ? $this->getInput('newsEditPublishedOff', helper::FILTER_DATETIME) : '';
					$this->setData(['data_module', $this->getUrl(0),'posts', $newsId, [
						'content' => $this->getInput('newsEditContent', null),
						'publishedOn' => $publishedOn,
						'publishedOff' => $publishedOff < $publishedOn ? '' : $publishedOff,
						'state' => $this->getInput('newsEditState', helper::FILTER_BOOLEAN),
						'title' => $this->getInput('newsEditTitle', helper::FILTER_STRING_SHORT, true),
						'userId' => $this->getInput('newsEditUserId', helper::FILTER_ID, true)
					]]);
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
						'notification' => $text['news']['edit'][1],
						'state' => true
					]);
				}
				// Mise à jour ou création du fichier site/data/news/themeNews.css destiné à tinymce
				$style =  '.editorWysiwyg{';
				$style .= 'background-color:' . $this->getData(['module', $this->getUrl(0), 'theme', 'backgroundColor']) . ';';
				$style .= '}';
				$style .= '.editorWysiwyg a{ color:'. $this->getData(['module', $this->getUrl(0), 'theme', 'linkColor']) .'}';
				$style .= 'p{ color:'. $this->getData(['module', $this->getUrl(0), 'theme', 'textColor']) .'}';
				$style .= 'h1, h2, h3, h4, h5, h6{ color:'. $this->getData(['module', $this->getUrl(0), 'theme', 'titleColor']) .'}';
				file_put_contents(self::DATADIRECTORY . 'themeNews.css', $style );
				// Liste des utilisateurs
				self::$users = helper::arrayCollumn($this->getData(['user']), 'firstname');
				ksort(self::$users);
				foreach(self::$users as $userId => &$userFirstname) {
					$userFirstname = $userFirstname . ' ' . $this->getData(['user', $userId, 'lastname']);
				}
				unset($userFirstname);
				// Valeurs en sortie
				$this->addOutput([
					'title' => $this->getData(['data_module', $this->getUrl(0),'posts', $this->getUrl(2), 'title']),
					'vendor' => [
						'flatpickr',
						'tinymce'
					],
					'view' => 'edit'
				]);
			}
		}
	}

	/**
	 * Accueil
	 */
	public function index() {
		// Lexique
		include('./module/news/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_news.php');

		// Mise à jour des données de module ou initialisation à la création de la page
		if( null === $this->getData(['module', $this->getUrl(0), 'config', 'versionData']) || version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), self::VERSION, '<') ) $this->update();

		// Affichage d'un article
		if(
			$this->getUrl(1)
			// Protection pour la pagination, un ID ne peut pas être un entier, une page oui
			AND intval($this->getUrl(1)) === 0
		) {
			// L'article n'existe pas
			if($this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(1)]) === null) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			}
			// L'article existe
			else {
				self::$articleSignature = $this->signature($this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(1), 'userId']));
				// Valeurs en sortie
				$this->addOutput([
					'showBarEditButton' => true,
					'title' => $this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(1), 'title']),
					'view' => 'article'
				]);

			}
		} else {
			// Affichage index
			// Ids des news par ordre de publication
			$newsIdsPublishedOns = helper::arrayCollumn($this->getData(['data_module', $this->getUrl(0), 'posts']), 'publishedOn', 'SORT_DESC');
			$newsIdsStates = helper::arrayCollumn($this->getData(['data_module', $this->getUrl(0), 'posts']), 'state', 'SORT_DESC');
			$newsIds = [];
			foreach($newsIdsPublishedOns as $newsId => $newsPublishedOn) {
				$newsIdsPublishedOff = $this->getData(['data_module', $this->getUrl(0), 'posts', $newsId, 'publishedOff']);
				if(   $newsPublishedOn <= time() AND
				      $newsIdsStates[$newsId] AND
					  	// date de péremption tenant des champs non définis
						(!is_integer($newsIdsPublishedOff) OR
							$newsIdsPublishedOff > time()
						)
					) {
					$newsIds[] = $newsId;
				}
			}
			// Pagination
			//$pagination = helper::pagination($newsIds, $this->getUrl(),$this->getData(['config','itemsperPage']));
			$pagination = helper::pagination($newsIds, $this->getUrl(),$this->getData(['module', $this->getUrl(0),'config', 'itemsperPage']));
			// Nombre de colonnes
			self::$nbrCol = $this->getData(['module', $this->getUrl(0),'config', 'itemsperCol']);
			// Liste des pages
			self::$pages = $pagination['pages'];
			// News en fonction de la pagination
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				self::$news[$newsIds[$i]] = $this->getData(['data_module', $this->getUrl(0),'posts', $newsIds[$i]]);
				// Longueur de la news affichée en ne découpant que les paragraphes <p...</p>
				$content = $this->getData(['data_module', $this->getUrl(0), 'posts', $newsIds[$i], 'content']);
				$content = str_replace('<p','*-_-*<p', $content);
				$content = str_replace('</p>','</p>*-_-*', $content);
				$arrayContent = explode('*-_-*', $content);
				// Suppression des contenus inutiles
				foreach($arrayContent as $key=>$value){
					if( strlen($value) < 6 ) unset($arrayContent[$key]);
				}
				$arrayContent = array_merge($arrayContent);
				$arrayType = array();
				// Détermination du type IM : image , IF : iframe, V: video, P : paragraphe avec balises <p></p>, A : autre
				foreach($arrayContent as $key=>$value){
					// Type de contenu pour les paragraphes
					if( strpos($value, '<img') !== false && strpos($value, '/>') !== false){
						$arrayType[$key] = 'IM';
					} elseif( strpos($value, '<iframe') !== false && strpos($value, '</iframe>') !== false) {
						$arrayType[$key] = 'IF';
					}  elseif( strpos($value, '<video') !== false && strpos($value, '</video>') !== false) {
						$arrayType[$key] = 'V';
					} elseif( strpos($value, '<figure') !== false && strpos($value, '</figure>') !== false) {
						$arrayType[$key] = 'F';
					} elseif( strpos($value, '<p') !== false && strpos($value, '</p>') !== false ){
						$arrayType[$key] = 'P';
					} else {
						$arrayType[$key] = 'A';	
					}
				}				
				self::$news[$newsIds[$i]]['content'] = '';
				$charDisplay = 0; $mediaDisplay=0;
				for( $key=0; $key<count($arrayContent); $key++){
					//Paragraphe avec media autorisé ( img, iframe, video, figure)
					if( ($arrayType[$key] === 'IM' || $arrayType[$key] === 'IF' || $arrayType[$key] === 'V'  || $arrayType[$key] === 'F' ) 
						&& ( $mediaDisplay === 0 || $this->getData(['module', $this->getUrl(0), 'config', 'height']) === -1) && $this->getData(['module', $this->getUrl(0), 'config', 'hideMedia']) === false ){
						// Modification des balises pour supprimer les marges
						if( $this->getData(['module', $this->getUrl(0), 'config', 'noMargin']) === true){
							$arrayContent[$key] = str_replace('</p>', '', $arrayContent[$key]); 
							if( strpos( $arrayContent[$key], '<p>') !== false){
								$arrayContent[$key] = str_replace('<p>', '', $arrayContent[$key]);
							} elseif( strpos( $arrayContent[$key], 'figure class=') === false) {
								$posfin = strpos( $arrayContent[$key], '>');
								$substring = substr( $arrayContent[$key],0 , $posfin+1);
								$arrayContent[$key] = str_replace( $substring, '', $arrayContent[$key]);
							}else{
									$arrayContent[$key] = str_replace( 'figure class="image"', 'figure class="image" style="margin:0"', $arrayContent[$key]);
									$arrayContent[$key] = str_replace( 'figure class="image align-left"', 'figure class="image" style="margin:0"', $arrayContent[$key]);
									$arrayContent[$key] = str_replace( 'figure class="image align-right"', 'figure class="image" style="margin:0"', $arrayContent[$key]);
									$arrayContent[$key] = str_replace( 'figure class="image align-center"', 'figure class="image" style="margin:0"', $arrayContent[$key]);
							}
						}
						self::$news[$newsIds[$i]]['content'] .= $arrayContent[$key];
						$mediaDisplay++;
					} elseif( $arrayType[$key] === 'P') {
						//Paragraphe à abréger
						if ( $this->getData(['module', $this->getUrl(0), 'config', 'height']) !== -1){	
							$charRemain = $this->getData(['module', $this->getUrl(0), 'config', 'height']) - $charDisplay;
							if( $charRemain > 0){
								if ( strlen( $arrayContent[$key] ) >= $charRemain ) {
									// paragraphe trop long à abréger
									$arrayContent[$key] = strip_tags($arrayContent[$key]);
									$arrayContent[$key] = '<p>'.substr( $arrayContent[$key], 0, $charRemain).'</p>';
									$arrayContent[$key] .= '<p> ... <a href="'. helper::baseUrl(true) . $this->getUrl(0) . '/' . $newsIds[$i] . '"><span class="newsSuite">'.$this->getData(['module', $this->getUrl(0), 'config','texts', 'readmore']).'</span></a></p>' ;
									$charDisplay = $charDisplay + 1000;
								} 
								self::$news[$newsIds[$i]]['content'] .= $arrayContent[$key];
								$charDisplay = $charDisplay + strlen( strip_tags( $arrayContent[$key]) );						
							}
						} else {
							self::$news[$newsIds[$i]]['content'] .= $arrayContent[$key];
						}	 
					} elseif ( $arrayType[$key] === 'A' && $this->getData(['module', $this->getUrl(0), 'config', 'height']) === -1) {
						self::$news[$newsIds[$i]]['content'] .= $arrayContent[$key];
					}
				}

				// Mise en forme de la signature
				self::$news[$newsIds[$i]]['userId'] = $this->signature($this->getData(['data_module', $this->getUrl(0), 'posts', $newsIds[$i], 'userId']));
			}
			if( isset( $_COOKIE['DELTA_COOKIE_INVERTCOLOR'] ) && $_COOKIE['DELTA_COOKIE_INVERTCOLOR'] === 'true' ) { 
				$style = 'style_invert';
			} else {
				$style = 'style';
			} 
			// Valeurs en sortie
			$this->addOutput([
				'showBarEditButton' => true,
				'showPageContent' => true,
				'view' => 'index',
				'style' => $this->getData(['module', $this->getUrl(0),'theme', $style ])
			]);

		}
	}

	/**
	 * Retourne la signature d'un utilisateur
	 */
	private function signature($userId) {
		switch ($this->getData(['user', $userId, 'signature'])){
			case 1:
				return $userId;
				break;
			case 2:
				return $this->getData(['user', $userId, 'pseudo']);
				break;
			case 3:
				return $this->getData(['user', $userId, 'firstname']) . ' ' . $this->getData(['user', $userId, 'lastname']);
				break;
			case 4:
				return $this->getData(['user', $userId, 'lastname']) . ' ' . $this->getData(['user', $userId, 'firstname']);
				break;
			default:
				return $this->getData(['user', $userId, 'firstname']);
		}
	}

	/**
	 * Mise à jour du module
	 * Appelée par les fonctions index et config
	 */
	private function update() {
		// Lexique
		include('./module/news/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_news.php');

		$versionData = $this->getData(['module',$this->getUrl(0),'config', 'versionData' ]);

		// le module n'est pas initialisé
		if ($versionData === null || !file_exists(self::DATA_DIR . self::$i18n . '/data_module/news/' . $this->getUrl(0)  . '/theme.css')) {
			$this->init();
		} else {
			// Mise à jour 4.1
			if (version_compare($versionData, '4.1', '<') ) {
				// Mettre à jour la version
				$this->setData(['module',$this->getUrl(0),'config', 'hiddeTitle', false ]);
				$this->setData(['module',$this->getUrl(0),'config', 'sameHeight', false ]);
				$this->setData(['module',$this->getUrl(0),'theme', 'borderRadius', '0px' ]);
				$this->setData(['module',$this->getUrl(0),'theme', 'borderShadows', '0px 0px 0px' ]);
				$this->deleteData(['module',$this->getUrl(0),'theme', 'borderStyle' ]);
				$this->setData(['module',$this->getUrl(0),'config', 'versionData', '4.1' ]);	
			}
			// Mise à jour 4.2
			if (version_compare($versionData, '4.2', '<') ) {
				// Mettre à jour la version
				$this->setData(['module',$this->getUrl(0),'config', 'noMargin', true ]);
				$this->setData(['module',$this->getUrl(0),'config', 'versionData', '4.2' ]);	
			}
			// Mise à jour 4.5
			if (version_compare($versionData, '4.5', '<') ) {
				// Mettre à jour la version
				$this->setData(['module',$this->getUrl(0),'config', 'hideMedia', false ]);
				$this->setData(['module',$this->getUrl(0),'config', 'versionData', '4.5' ]);	
			}
			// Mise à jour 4.8
			if (version_compare($versionData, '4.8', '<') ) {
				// Nouvelles couleurs par défaut en configuration
				$this->setData(['module', $this->getUrl(0), 'theme','textColor', $this->getData(['theme', 'text', 'textColor' ]) ]);
				$this->setData(['module', $this->getUrl(0), 'theme','linkColor', $this->getData(['theme', 'text', 'linkColor' ]) ]);
				$this->setData(['module', $this->getUrl(0), 'theme','titleColor', $this->getData(['theme', 'title', 'textColor' ]) ]);
				$this->setData(['module', $this->getUrl(0), 'theme','signatureColor', $this->getData(['theme', 'text', 'textColor' ]) ]);
				// Mettre à jour la version
				$this->setData(['module',$this->getUrl(0),'config', 'versionData', '4.8' ]);	
			}
			// Mise à jour 5.0
			if (version_compare($versionData, '5.0', '<') ) {
				// Déplacement des 'posts' de module.json vers data_module/nomdelapage.json		
				$this->setData(['data_module', $this->getUrl(0), 'posts', $this->getData(['module', $this->getUrl(0), 'posts']) ]);
				$this->deleteData(['module', $this->getUrl(0), 'posts']);
				// Mettre à jour la version
				$this->setData(['module',$this->getUrl(0),'config', 'versionData', '5.0' ]);	
			}
			// Mise à jour 5.2
			if (version_compare($versionData, '5.2', '<') ) {
				// Déplacement des dossiers des fichiers theme.css et theme_invert.css
				if( is_dir( self::DATA_DIR.'/news')){
					// Pour toutes les langues du site
					foreach( $this->getData(['config', 'i18n' ]) as $lang=>$state ){
						if( $state === 'site') $this->copyDir( self::DATA_DIR.'news', self::DATA_DIR.$lang.'/data_module/news');						
					}
					$this->copyDir( self::DATA_DIR.'news', self::DATA_DIR.'base/data_module/news');
				}
				// Initialisation de nouvelles variables
				$this->setData(['module', $this->getUrl(0), 'config', 'texts', 'readmore', $text['news_view']['config'][41] ]);
				$this->setData(['module', $this->getUrl(0), 'config', 'texts', 'back', $text['news_view']['config'][42] ]);
				$this->setData(['module', $this->getUrl(0), 'config', 'texts', 'noNews', $text['news_view']['config'][43] ]);
				// Mettre à jour la version
				$this->setData(['module',$this->getUrl(0),'config', 'versionData', '5.2' ]);	
			}
		}
	}

	/**
	 * Initialisation du thème d'un nouveau module
	 */
	private function init() {
		
		// Lexique
		include('./module/news/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_news.php');
		
		$dircss = self::DATA_DIR . self::$i18n . '/data_module/news/' . $this->getUrl(0);
		// Création du dossier pour le thème associé à tinymce
		if( !is_dir( self::DATADIRECTORY  )) mkdir( self::DATADIRECTORY, 0755, true );
		
		// Données du module absentes
		require_once('module/news/ressource/defaultdata.php');
		if ($this->getData(['module', $this->getUrl(0), 'config' ]) === null) {
			$this->setData(['module', $this->getUrl(0), 'config', init::$defaultData]);
		}
		if ($this->getData(['module', $this->getUrl(0), 'theme' ]) === null) {
			// Données de thème
			$this->setData(['module', $this->getUrl(0), 'theme', init::$defaultTheme]);
			$this->setData(['module', $this->getUrl(0), 'theme', 'style', $dircss . '/theme.css' ]);
		}
		
		// Couleurs initialisées à celles du site
		$this->setData(['module', $this->getUrl(0), 'theme', 'backgroundColor', $this->getData(['theme', 'site', 'backgroundColor' ]) ]);
		$this->setData(['module', $this->getUrl(0), 'theme', 'textColor', $this->getData(['theme', 'text', 'textColor' ]) ]);
		$this->setData(['module', $this->getUrl(0), 'theme', 'linkColor', $this->getData(['theme', 'text', 'linkColor' ]) ]);
		$this->setData(['module', $this->getUrl(0), 'theme', 'titleColor', $this->getData(['theme', 'title', 'textColor' ]) ]);
		$this->setData(['module', $this->getUrl(0), 'theme', 'signatureColor', $this->getData(['theme', 'text', 'textColor' ]) ]);

		// Dossier de l'instance
		if (!is_dir($dircss )) mkdir ($dircss, 0755, true);

		// Check la présence de la feuille de style
		if ( !file_exists( $dircss . '/theme.css')) {
			// Générer la feuille de CSS
			$style =  '.newsFrame {';
			$style .= 'border:' .  $this->getData(['module', $this->getUrl(0), 'theme', 'borderStyle' ]) . ' ' .$this->getData(['module', $this->getUrl(0), 'theme', 'borderColor' ])  . ' ' . $this->getData(['module', $this->getUrl(0), 'theme', 'borderWidth' ]) . ';';
			$style .= 'background-color:' . $this->getData(['module', $this->getUrl(0), 'theme', 'backgroundColor' ]) . ';';
			$style .= 'color:' . $this->getData(['module', $this->getUrl(0), 'theme','textColor']) . ';';
			$style .= '}';
			$style .= '.newsFrame a{ color:'. $this->getData(['module', $this->getUrl(0), 'theme', 'linkColor' ]) .'}';
			$style .= '.newsFrame h1,.newsFrame h2,.newsFrame h3,.newsFrame h4,.newsFrame h5,.newsFrame h6{ color:'. $this->getData(['module', $this->getUrl(0), 'theme', 'titleColor' ]) .'}';
			$style .= '.newsSignature { color:' . $this->getData(['module', $this->getUrl(0), 'theme', 'signatureColor' ]) . ';';
			
			// Sauver la feuille de style
			file_put_contents( $dircss. '/theme.css' , $style );
			// Stocker le nom de la feuille de style
			$this->setData(['module',  $this->getUrl(0), 'theme', 'style', $dircss . '/theme.css']);
		}
		
		// Textes initialisés dans la langue d'administration
		$this->setData(['module', $this->getUrl(0), 'config', 'texts', 'readmore', $text['news_view']['config'][41] ]);
		$this->setData(['module', $this->getUrl(0), 'config', 'texts', 'back', $text['news_view']['config'][42] ]);
		$this->setData(['module', $this->getUrl(0), 'config', 'texts', 'noNews', $text['news_view']['config'][43] ]);
	}
}
