<?php

/**
 * This file is part of DeltaCMS.
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 * @author Sylvain Lelièvre
 * @copyright 2021 © Sylvain Lelièvre
 * @author Lionel Croquefer
 * @copyright 2022 © Lionel Croquefer
 * @license GNU General Public License, version 3
 * @link https://deltacms.fr/
 * @contact https://deltacms.fr/contact
 *
 * Delta was created from version 11.2.00.24 of ZwiiCMS
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright 2008-2018 © Rémi Jean
 * @author Frédéric Tempez <frederic.tempez@outlook.com>
 * @copyright 2018-2021 © Frédéric Tempez
 */

class blog extends common {

	const VERSION = '7.6';
	const REALNAME = 'Blog';
	const DELETE = true;
	const UPDATE = '0.0';
	const DATADIRECTORY = '';

	const EDIT_OWNER = 'owner';
	const EDIT_GROUP = 'group';
	const EDIT_ALL = 'all';

	public static $actions = [
		'add' => self::GROUP_EDITOR,
		'comment' => self::GROUP_EDITOR,
		'commentApprove' => self::GROUP_MODERATOR,
		'commentEdit' => self::GROUP_MODERATOR,
		'commentDelete' => self::GROUP_MODERATOR,
		'commentDeleteAll' => self::GROUP_MODERATOR,
		'config' => self::GROUP_EDITOR,
		'texts' => self::GROUP_MODERATOR,
		'delete' => self::GROUP_MODERATOR,
		'edit' => self::GROUP_EDITOR,
		'index' => self::GROUP_VISITOR,
		'rss' => self::GROUP_VISITOR
	];

	public static $articles = [];

	// Signature de l'article
	public static $articleSignature = '';

	// Signature du commentaire
	public static $editCommentSignature = '';
	public static $comments = [];
	public static $nbCommentsApproved = 0;
	public static $commentsDelete;

	// Signatures des commentaires déjà saisis
	public static $commentsSignature = [];
	public static $pages;
	public static $users = [];
	
	// Boutons suivant et précédent dans les articles
	public static $urlPreviousArticle = '';
	public static $urlNextArticle = '';

	/**
	 * Mise à jour du module
	 * Appelée par les fonctions index et config
	 */
	private function update() {	
	
		if( null === $this->getData(['module', $this->getUrl(0), 'config', 'versionData']) ) {
			$this->init();
		} else {
			// Lexique
			$param = 'blog';
			include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');		
			// Version 5.0
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '5.0', '<') ) {
				$this->setData(['module', $this->getUrl(0), 'config', 'itemsperPage', 6]);
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','5.0']);
			}
			// Version 6.0
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '6.0', '<') ) {
				if( $this->getData(['config', 'i18n', 'langAdmin']) === 'en'){
					$this->setData(['module', $this->getUrl(0), 'texts',[
						'NoComment'  => 'No comment yet',
						'Write'  => 'Write a comment',
						'Name'  => 'Name',
						'Maxi'  => 'Comment with maximum',
						'Cara'  => 'characters',
						'Comment'  => 'comment',
						'CommentOK'  => 'Comment filed',
						'Waiting'  => 'Comment submitted pending approval',
						'ArticleNoComment' => 'This article does not receive comments',
						'Connection' => 'Login',
						'Edit' => 'Edit',
						'Cancel' => 'Cancel',
						'Send' => 'Send',
						'TinymceMaxi' => 'You have reached the maximum of',
						'TinymceCara' => 'characters left',
						'TinymceExceed' => 'You were about to exceed the maximum of '
					]]);			
				}
				else{
					$this->setData(['module', $this->getUrl(0), 'texts',[
						'NoComment'  => 'Pas encore de commentaire',
						'Write'  => 'Ecrire un commentaire',
						'Name'  => 'Nom',
						'Maxi'  => 'Commentaire avec maximum',
						'Cara'  => 'caractères',
						'Comment'  => 'commentaire',
						'CommentOK'  => 'Commentaire déposé',
						'Waiting'  => 'Commentaire déposé en attente d\'approbation',
						'ArticleNoComment' => 'Cet article ne reçoit pas de commentaire',
						'Connection' => 'Connexion',
						'Edit' => 'Editer',
						'Cancel' => 'Annuler',
						'Send' => 'Envoyer',
						'TinymceMaxi' => 'Vous avez atteint le maximum de',
						'TinymceCara' => 'caractères restants',
						'TinymceExceed' => 'Vous alliez dépasser le maximum de '
					]]);
				}
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','6.0']);
			}
			// Version 6.3
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '6.3', '<') ) {
				$this->setData(['module', $this->getUrl(0), 'texts', 'ReadMore', $text['blog']['index'][26] ]);
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','6.3']);
			}
			// Version 7.0
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '7.0', '<') ) {
				$this->setData(['data_module', $this->getUrl(0), 'posts', $this->getData(['module', $this->getUrl(0), 'posts']) ]);
				$this->deleteData(['module', $this->getUrl(0), 'posts']);
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','7.0']);
			}
			// Version 7.2
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '7.2', '<') ) {
				$this->setData(['module', $this->getUrl(0), 'texts', 'Comments', $text['blog']['index'][28] ]);
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','7.2']);
			}
			// Version 7.4
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '7.4', '<') ) {
				$this->setData(['module', $this->getUrl(0), 'config', 'previewSize', 400]);
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','7.4']);
			}
			// Version 7.5
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '7.5', '<') ) {
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','7.5']);
			}
		}
	}

	/**
	 * Initialisation
	 */
	private function init(){
		// Lexique
		$param = 'blog';
		include('./module/blog/lang/'. helper::lexlang($this->getData(['config', 'i18n', 'langBase']) , $this->getData(['config', 'i18n', 'langAdmin'])) . '/lex_blog.php');
		$this->setData(['module', $this->getUrl(0), 'config',[
			'feeds' 	 => false,
			'feedsLabel' => '',
			'itemsperPage' => 4,
			'previewSize' => 400,
			'versionData' => self::VERSION
		]]);
		$this->setData(['module', $this->getUrl(0), 'texts',[
			'NoComment'  => $text['blog']['index'][8],
			'Write'  => $text['blog']['index'][9],
			'Name'  => $text['blog']['index'][10],
			'Maxi'  => $text['blog']['index'][11],
			'Cara'  => $text['blog']['index'][12],
			'Comment'  => $text['blog']['index'][13],
			'CommentOK'  => $text['blog']['index'][14],
			'Waiting'  => $text['blog']['index'][15],
			'ArticleNoComment' => $text['blog']['index'][16],
			'Connection' => $text['blog']['index'][17],
			'Edit' => $text['blog']['index'][18],
			'Cancel' => $text['blog']['index'][19],
			'Send' => $text['blog']['index'][20],
			'TinymceMaxi' => $text['blog']['index'][21],
			'TinymceCara' => $text['blog']['index'][22],
			'TinymceExceed' => $text['blog']['index'][23],
			'ReadMore' => $text['blog']['index'][26],
			'Back' => $text['blog']['index'][27],
			'Comments' => $text['blog']['index'][28]
		]]);	
	}

	/**
	 * Flux RSS
	 */
	public function rss() {
		// Inclure les classes
		include_once 'module/blog/vendor/FeedWriter/Item.php';
		include_once 'module/blog/vendor/FeedWriter/Feed.php';
		include_once 'module/blog/vendor/FeedWriter/RSS2.php';
		include_once 'module/blog/vendor/FeedWriter/InvalidOperationException.php';

		date_default_timezone_set('UTC');
		$feeds = new \FeedWriter\RSS2();

		// En-tête
		$feeds->setTitle($this->getData (['page', $this->getUrl(0), 'title']));
		$feeds->setLink(helper::baseUrl() . $this->getUrl(0));
		$feeds->setDescription($this->getData (['page', $this->getUrl(0), 'metaDescription']));
		$feeds->setChannelElement('language', 'fr-FR');
		$feeds->setDate(date('r',time()));
		$feeds->addGenerator();
		// Corps des articles
		$articleIdsPublishedOns = helper::arrayCollumn($this->getData(['data_module', $this->getUrl(0), 'posts']), 'publishedOn', 'SORT_DESC');
		$articleIdsStates = helper::arrayCollumn($this->getData(['data_module', $this->getUrl(0),'posts']), 'state', 'SORT_DESC');
		foreach( $articleIdsPublishedOns as $articleId => $articlePublishedOn ) {
			if( $articlePublishedOn <= time() AND $articleIdsStates[$articleId]			 ) {
				// Miniature
				$parts = explode('/',$this->getData(['data_module', $this->getUrl(0), 'posts', $articleId, 'picture']));
				$thumb = str_replace ($parts[(count($parts)-1)],'mini_' . $parts[(count($parts)-1)], $this->getData(['data_module', $this->getUrl(0), 'posts', $articleId, 'picture']));
				// Créer les articles du flux
				$newsArticle = $feeds->createNewItem();
				// Signature de l'article
				$author = $this->signature($this->getData(['data_module', $this->getUrl(0),  'posts', $articleId, 'userId']));
				$newsArticle->addElementArray([
					'title' 		=> $this->getData(['data_module', $this->getUrl(0), 'posts', $articleId, 'title']),
					'link' 			=> helper::baseUrl() .$this->getUrl(0) . '/' . $articleId,
					'description' 	=> '<img src="' . helper::baseUrl() . self::FILE_DIR . $thumb
									 . '" alt="' . $this->getData(['data_module', $this->getUrl(0), 'posts', $articleId, 'title'])
									 . '" title="' . $this->getData(['data_module', $this->getUrl(0), 'posts', $articleId, 'title'])
									 . '" />' .
									 $this->getData(['data_module', $this->getUrl(0), 'posts', $articleId, 'content']),
				]);
				$newsArticle->setAuthor($author,'no@mail.com');
				$newsArticle->setId(helper::baseUrl() .$this->getUrl(0) . '/' . $articleId);
				$newsArticle->setDate(date('r', $this->getData(['data_module', $this->getUrl(0), 'posts', $articleId, 'publishedOn'])));
				if ( file_exists($this->getData(['data_module', $this->getUrl(0), 'posts', $articleId, 'picture'])) ) {
					$imageData = getimagesize(helper::baseUrl(false) .  self::FILE_DIR . 'thumb/' .  $thumb);
				$newsArticle->addEnclosure( helper::baseUrl(false) . self::FILE_DIR . 'thumb/'  . $thumb,
											$imageData[0] * $imageData[1],
											$imageData['mime']
					);
				}
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
	 * Configuration des textes visibles par l'utiliateur
	 */
	public function texts() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < blog::$actions['texts'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {		
			// Lexique
			$param = 'blog';
			include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');

			// Soumission du formulaire
			if($this->isPost()) {	
				$this->setData(['module', $this->getUrl(0), 'texts',[
					'NoComment'  => $this->getInput('blogTextsNoComment',helper::FILTER_STRING_SHORT),
					'Write'  => $this->getInput('blogTextsWrite',helper::FILTER_STRING_SHORT),
					'Name'  => $this->getInput('blogTextsName',helper::FILTER_STRING_SHORT),
					'Maxi'  => $this->getInput('blogTextsMaxi',helper::FILTER_STRING_SHORT),
					'Cara'  => $this->getInput('blogTextsCara',helper::FILTER_STRING_SHORT),
					'Comment'  => $this->getInput('blogTextsComment',helper::FILTER_STRING_SHORT),
					'CommentOK'  => $this->getInput('blogTextsCommentOK',helper::FILTER_STRING_SHORT),
					'Waiting'  => $this->getInput('blogTextsWaiting',helper::FILTER_STRING_SHORT),
					'ArticleNoComment' => $this->getInput('blogTextsArticleNoComment',helper::FILTER_STRING_SHORT),
					'Connection' => $this->getInput('blogTextsConnection',helper::FILTER_STRING_SHORT),
					'Edit' => $this->getInput('blogTextsEdit',helper::FILTER_STRING_SHORT),
					'Cancel' => $this->getInput('blogTextsCancel',helper::FILTER_STRING_SHORT),
					'Send' => $this->getInput('blogTextsSend',helper::FILTER_STRING_SHORT),
					'TinymceMaxi' => $this->getInput('blogTextsTinymceMaxi',helper::FILTER_STRING_SHORT),
					'TinymceCara' => $this->getInput('blogTextsTinymceCara',helper::FILTER_STRING_SHORT),
					'TinymceExceed' => $this->getInput('blogTextsTinymceExceed',helper::FILTER_STRING_SHORT),
					'ReadMore' => $this->getInput('blogTextsReadMore',helper::FILTER_STRING_SHORT),
					'Back' => $this->getInput('blogTextsBack',helper::FILTER_STRING_SHORT),
					'Comments' => $this->getInput('blogTextsComments',helper::FILTER_STRING_SHORT)
				]]);
			
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['blog']['texts'][1],
					'state' => true
				]);
			}
			
			$this->addOutput([
				'title' => $text['blog']['texts'][2],
				'view' => 'texts',
			]);
		}
	}
	/**
	 * Édition
	 */
	public function add() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < blog::$actions['add'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = 'blog';
			include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');

			// Soumission du formulaire
			if($this->isPost()) {
				// Modification de l'userId
				if($this->getUser('group') === self::GROUP_ADMIN){
					$newuserid = $this->getInput('blogAddUserId', helper::FILTER_STRING_SHORT, true);
				}
				else{
					$newuserid = $this->getUser('id');
				}
				// Incrémente l'id de l'article
				$articleId = helper::increment($this->getInput('blogAddTitle', helper::FILTER_ID), $this->getData(['page']));
				$articleId = helper::increment($articleId, (array) $this->getData(['data_module', $this->getUrl(0), 'posts']));
				$articleId = helper::increment($articleId, array_keys(self::$actions));
				// Crée l'article
				$this->setData(['data_module',
					$this->getUrl(0),
					'posts',
					$articleId, [
						'comment' => $this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(2), 'comment']),
						'content' => $this->getInput('blogAddContent', null),
						'picture' => $this->getInput('blogAddPicture', helper::FILTER_STRING_SHORT),
						'hidePicture' => $this->getInput('blogAddHidePicture', helper::FILTER_BOOLEAN),
						'pictureSize' => $this->getInput('blogAddPictureSize', helper::FILTER_STRING_SHORT),
						'picturePosition' => $this->getInput('blogAddPicturePosition', helper::FILTER_STRING_SHORT),
						'publishedOn' => $this->getInput('blogAddPublishedOn', helper::FILTER_DATETIME, true),
						'state' => $this->getInput('blogAddState', helper::FILTER_BOOLEAN),
						'title' => $this->getInput('blogAddTitle', helper::FILTER_STRING_SHORT, true),
						'userId' => $newuserid,
						'editConsent' =>  $this->getInput('blogAddConsent') === self::EDIT_GROUP ? $this->getUser('group') : $this->getInput('blogAddConsent'),
						'commentMaxlength' => $this->getInput('blogAddCommentMaxlength'),
						'commentApproved' => $this->getInput('blogAddCommentApproved', helper::FILTER_BOOLEAN),
						'commentClose' => $this->getInput('blogAddCommentClose', helper::FILTER_BOOLEAN),
						'commentNotification'  => $this->getInput('blogAddCommentNotification', helper::FILTER_BOOLEAN),
						'commentGroupNotification' => $this->getInput('blogAddCommentGroupNotification', helper::FILTER_INT),
					]
				]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['blog']['add'][0],
					'state' => true
				]);
			}
			// Liste des utilisateurs
			self::$users = helper::arrayCollumn($this->getData(['user']), 'firstname');
			ksort(self::$users);
			foreach(self::$users as $userId => &$userFirstname) {
				$userFirstname = $userFirstname . ' ' . $this->getData(['user', $userId, 'lastname']);
			}
			unset($userFirstname);
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['blog']['add'][1],
				'vendor' => [
					'flatpickr',
					'tinymce'
				],
				'view' => 'add'
			]);
		}
	}

	/**
	 * Liste des commentaires
	 */
	public function comment() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < blog::$actions['comment'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = 'blog';
			include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');

			$comments = $this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2),'comment']);
			self::$commentsDelete =	template::button('blogCommentDeleteAll', [
						'class' => 'blogCommentDeleteAll buttonRed',
						'href' => helper::baseUrl() . $this->getUrl(0) . '/commentDeleteAll/' . $this->getUrl(2).'/' . $_SESSION['csrf'] ,
						'ico' => 'cancel',
						'value' => $text['blog']['comment'][0],
						'disabled' => $this->getUser('group') >= self::GROUP_MODERATOR ? false : true
			]);
			// Dates suivant la langue d'administration
			// Ids des commentaires par ordre de création
			$commentIds = array_keys(helper::arrayCollumn($comments, 'createdOn', 'SORT_DESC'));
			// Mémorisation de la pagination
			$_SESSION['pageBlogComment'] = null !== $this->getUrl(3) ? $this->getUrl(3) : '1';
			// Pagination
			$pagination = helper::pagination($commentIds, $this->getUrl(),$this->getData(['module', $this->getUrl(0), 'config', 'itemsperPage']) );
			// Liste des pages
			self::$pages = $pagination['pages'];
			// Commentaires en fonction de la pagination	
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				// Met en forme le tableau
				$comment = $comments[$commentIds[$i]];
				// Bouton d'approbation
				$buttonApproval = '';
				// Compatibilité avec les commentaires des versions précédentes, les valider
				$comment['approval'] = array_key_exists('approval', $comment) === false ? true : $comment['approval'] ;
				if ( $this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(2),'commentApproved']) === true) {
					$buttonApproval = template::button('blogCommentApproved' . $commentIds[$i], [
						'class' => $comment['approval'] === true ? 'blogCommentRejected buttonGreen' : 'blogCommentApproved buttonRed' ,
						'href' => helper::baseUrl() . $this->getUrl(0) . '/commentApprove/' . $this->getUrl(2) . '/' . $commentIds[$i] . '/' . $_SESSION['csrf'] ,
						'value' => $comment['approval'] === true ? 'A' : 'R',
						'disabled' => $this->getUser('group') >= self::GROUP_MODERATOR ? false : true
					]);
				}
				self::$comments[] = [
					mb_detect_encoding(date('d\/m\/Y\ \-\ H\:i', $comment['createdOn']), 'UTF-8', true)
					? date('d\/m\/Y\ \-\ H\:i', $comment['createdOn'])
					: helper::utf8Encode(date('d\/m\/Y\ \-\ H\:i', $comment['createdOn'])),
					$comment['content'],
					$comment['userId'] ? $this->getData(['user', $comment['userId'], 'firstname']) . ' ' . $this->getData(['user', $comment['userId'], 'lastname']) : $comment['author'],
					$buttonApproval,
					template::button('blogCommentEdit' . $commentIds[$i], [
						'href' => helper::baseUrl() . $this->getUrl(0) . '/commentEdit/' . $this->getUrl(2) . '/' . $commentIds[$i] . '/' . $_SESSION['csrf'] ,
						'value' => template::ico('pencil'),
						'disabled' => $this->getUser('group') >= self::GROUP_MODERATOR ? false : true
					]),
					template::button('blogCommentDelete' . $commentIds[$i], [
						'class' => 'blogCommentDelete buttonRed',
						'href' => helper::baseUrl() . $this->getUrl(0) . '/commentDelete/' . $this->getUrl(2) . '/' . $commentIds[$i] . '/' . $_SESSION['csrf'] ,
						'value' => template::ico('cancel'),
						'disabled' => $this->getUser('group') >= self::GROUP_MODERATOR ? false : true
					])
				];
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['blog']['comment'][1]. $this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(2), 'title']),
				'view' => 'comment'
			]);
		}
	}

	/**
	 * Edition de commentaire
	 */
	public function commentEdit() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < blog::$actions['commentEdit'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = 'blog';
			include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');

			// Le commentaire n'existe pas
			if($this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2), 'comment', $this->getUrl(3)]) === null) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			}
			// Jeton incorrect
			elseif ($this->getUrl(4) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . $this->getUrl(0) . '/config',
					'notification' => $text['blog']['commentEdit'][2]
				]);
			}
			// Edition
			else {
				if($this->isPost()) {
					// Lecture du commentaire
					$content = empty($this->getInput('blogCommentEditContent', null)) ? '<p></p>' : str_replace('<p></p>', '<p>&nbsp;</p>', $this->getInput('blogCommentEditContent', null));
					// Enregistrement
					$this->setData(['data_module',$this->getUrl(0), 'posts', $this->getUrl(2), 'comment', $this->getUrl(3), 'content', $content ]);
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl()  . 'blog/comment/' . $this->getUrl(2).'/'.$_SESSION['pageBlogComment'],
						'notification' => $text['blog']['commentEdit'][0],
						'state' => true
					]);
				}
				// Valeurs en sortie
				$identity = $this->getData(['data_module',$this->getUrl(0), 'posts', $this->getUrl(2), 'comment', $this->getUrl(3), 'userId' ]) === '' ?
					$this->getData(['data_module',$this->getUrl(0), 'posts', $this->getUrl(2), 'comment', $this->getUrl(3), 'author' ]) :
					$this->getData(['data_module',$this->getUrl(0), 'posts', $this->getUrl(2), 'comment', $this->getUrl(3), 'userId' ]);
				$this->addOutput([
					'title' => $text['blog']['commentEdit'][1]. $this->getUrl(2). $text['blog']['commentEdit'][3] .$identity,
					'vendor' => [
						'flatpickr',
						'tinymce'
					],
					'view' => 'commentedit'
				]);
			}
		}
	}

	/**
	 * Suppression de commentaire
	 */
	public function commentDelete() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < blog::$actions['commentDelete'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = 'blog';
			include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');

			// Le commentaire n'existe pas
			if($this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2), 'comment', $this->getUrl(3)]) === null) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			}
			// Jeton incorrect
			elseif ($this->getUrl(4) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . $this->getUrl(0) . '/config',
					'notification' => $text['blog']['commentDelete'][0]
				]);
			}
			// Suppression
			else {
				$this->deleteData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2), 'comment', $this->getUrl(3)]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/comment/'.$this->getUrl(2),
					'notification' => $text['blog']['commentDelete'][1],
					'state' => true
				]);
			}
		}
	}

	/**
	 * Suppression de tous les commentaires de l'article $this->getUrl(2)
	 */
	public function commentDeleteAll() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < blog::$actions['commentDeleteAll'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = 'blog';
			include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');

			// Jeton incorrect
			if ($this->getUrl(3) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . $this->getUrl(0) . '/config',
					'notification' => $text['blog']['commentDeleteAll'][0]
				]);
			}
			// Suppression
			else {
				$this->setData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(2), 'comment',[] ]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/comment',
					'notification' => $text['blog']['commentDeleteAll'][1],
					'state' => true
				]);
			}
		}
	}

	/**
	 * Approbation oou désapprobation de commentaire
	 */
	public function commentApprove() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < blog::$actions['commentApprove'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = 'blog';
			include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');

			// Le commentaire n'existe pas
			if($this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(2), 'comment', $this->getUrl(3)]) === null) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			}
			// Jeton incorrect
			elseif ($this->getUrl(4) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . $this->getUrl(0) . '/config',
					'notification' => $text['blog']['commentApprove'][0]
				]);
			}
			// Inversion du statut
			else {
				$approved = !$this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(2), 'comment', $this->getUrl(3), 'approval']) ;
				$this->setData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(2), 'comment', $this->getUrl(3), [
					'author' => $this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(2), 'comment', $this->getUrl(3), 'author']),
					'content' => $this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(2), 'comment', $this->getUrl(3), 'content']),
					'createdOn' => $this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(2), 'comment', $this->getUrl(3), 'createdOn']),
					'userId' => $this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(2), 'comment', $this->getUrl(3), 'userId']),
					'approval' => $approved
				]]);

				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/comment/'.$this->getUrl(2),
					'notification' =>  $approved ?  $text['blog']['commentApprove'][1] : $text['blog']['commentApprove'][2],
					'state' => $approved
				]);
			}
		}
	}

	/**
	 * Configuration
	 */
	public function config() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < blog::$actions['config'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = 'blog';
			include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');
			// Soumission du formulaire
			if($this->isPost()) {
				$this->setData(['module', $this->getUrl(0), 'config',[
					'feeds' 	 => $this->getInput('blogConfigShowFeeds',helper::FILTER_BOOLEAN),
					'feedsLabel' => $this->getInput('blogConfigFeedslabel',helper::FILTER_STRING_SHORT),
					'itemsperPage' => $this->getInput('blogConfigItemsperPage', helper::FILTER_INT,true),
					'previewSize' => $this->getInput('blogConfigPreviewSize', helper::FILTER_INT,true),
					'versionData' => self::VERSION,
					'blogBorder' => $this->getInput('blogBorder', helper::FILTER_BOOLEAN)
				]]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['blog']['config'][0],
					'state' => true
				]);
			} else {
				// Dates suivant la langue d'administration
				// Ids des articles par ordre de publication
				$articleIds = array_keys(helper::arrayCollumn($this->getData(['data_module', $this->getUrl(0), 'posts']), 'publishedOn', 'SORT_DESC'));
				// Gestion des droits d'accès
				$filterData=[];
				foreach ($articleIds as $key => $value) {
					if (
						(  // Propriétaire
							$this->getData(['data_module',  $this->getUrl(0), 'posts', $value,'editConsent']) === self::EDIT_OWNER
							AND ( $this->getData(['data_module',  $this->getUrl(0), 'posts', $value,'userId']) === $this->getUser('id')
							OR $this->getUser('group') === self::GROUP_ADMIN )
						)

						OR (
							// Groupe
							$this->getData(['data_module',  $this->getUrl(0), 'posts',  $value,'editConsent']) !== self::EDIT_OWNER
							AND $this->getUser('group') >=  $this->getData(['data_module',$this->getUrl(0), 'posts', $value,'editConsent'])
						)
						OR (
							// Tout le monde
							$this->getData(['data_module',  $this->getUrl(0), 'posts',  $value,'editConsent']) === self::EDIT_ALL
						)
					) {
						$filterData[] = $value;
					}
				}
				$articleIds = $filterData;
				// Pagination
				$pagination = helper::pagination($articleIds, $this->getUrl(),$this->getData(['module', $this->getUrl(0),'config', 'itemsperPage']));
				// Liste des pages
				self::$pages = $pagination['pages'];
				// Articles en fonction de la pagination
				for($i = $pagination['first']; $i < $pagination['last']; $i++) {
					// Nombre de commentaires à approuver et approuvés
					$approvals = helper::arrayCollumn($this->getData(['data_module', $this->getUrl(0), 'posts',  $articleIds[$i], 'comment' ]),'approval', 'SORT_DESC');
					if ( is_array($approvals) ) {
						$a = array_values($approvals);
						$toApprove = count(array_keys($a,false));
						$approved = count(array_keys($a,true));
					} else {
						$toApprove = 0;
						$approved = count($this->getData(['data_module', $this->getUrl(0), 'posts', $articleIds[$i],'comment']));
					}
					// Met en forme le tableau
					$date = mb_detect_encoding(date('d\/m\/Y', $this->getData(['data_module', $this->getUrl(0),  'posts', $articleIds[$i], 'publishedOn'])), 'UTF-8', true)
						? date('d\/m\/Y', $this->getData(['data_module', $this->getUrl(0), 'posts', $articleIds[$i], 'publishedOn']))
						: helper::utf8Encode(date('d\/m\/Y', $this->getData(['data_module', $this->getUrl(0), 'posts', $articleIds[$i], 'publishedOn'])));
					$heure =   mb_detect_encoding(date('H\:i', $this->getData(['data_module', $this->getUrl(0), 'posts', $articleIds[$i], 'publishedOn'])), 'UTF-8', true)
					? date('H\:i', $this->getData(['data_module', $this->getUrl(0), 'posts', $articleIds[$i], 'publishedOn']))
					: helper::utf8Encode(date('H\:i', $this->getData(['data_module', $this->getUrl(0), 'posts', $articleIds[$i], 'publishedOn'])));
					self::$articles[] = [
						'<a href="' . helper::baseurl() . $this->getUrl(0) . '/' . $articleIds[$i] . '" target="_blank" >' .
						$this->getData(['data_module', $this->getUrl(0),  'posts', $articleIds[$i], 'title']) .
						'</a>',
						$date .$text['blog']['config'][2]. $heure,
						$states[$this->getData(['data_module', $this->getUrl(0), 'posts', $articleIds[$i], 'state'])],
						// Bouton pour afficher les commentaires de l'article
						template::button('blogConfigComment' . $articleIds[$i], [
							'class' => ($toApprove || $approved ) > 0 ?  '' : 'buttonGrey' ,
							'href' => ($toApprove || $approved ) > 0 ? helper::baseUrl() . $this->getUrl(0) . '/comment/' . $articleIds[$i] : '',
							'value' => $toApprove > 0 ? $toApprove . '/' . $approved : $approved
						]),
						template::button('blogConfigEdit' . $articleIds[$i], [
							'href' => helper::baseUrl() . $this->getUrl(0) . '/edit/' . $articleIds[$i] . '/' . $_SESSION['csrf'],
							'value' => template::ico('pencil')
						]),
						template::button('blogConfigDelete' . $articleIds[$i], [
							'class' => 'blogConfigDelete buttonRed',
							'href' => helper::baseUrl() . $this->getUrl(0) . '/delete/' . $articleIds[$i] . '/' . $_SESSION['csrf'],
							'value' => template::ico('cancel'),
							'disabled' => $this->getUser('group') >= self::GROUP_MODERATOR ? false : true
						])
					];
				}
				// Valeurs en sortie
				$this->addOutput([
					'title' => $text['blog']['config'][1],
					'view' => 'config'
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
		if( $group < blog::$actions['delete'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = 'blog';
			include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');

			if($this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2)]) === null) {
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
					'notification' => $text['blog']['delete'][0]
				]);
			}
			// Suppression
			else {
				$this->deleteData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2)]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['blog']['delete'][1],
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
		if( $group < blog::$actions['edit'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = 'blog';
			include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');
			
			// Jeton incorrect
			if ($this->getUrl(3) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['blog']['edit'][0]
				]);
			}
			// L'article n'existe pas
			if($this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2)]) === null) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			}
			// L'article existe
			else {
				// Soumission du formulaire
				if($this->isPost()) {
					if($this->getUser('group') === self::GROUP_ADMIN){
						$newuserid = $this->getInput('blogEditUserId', helper::FILTER_STRING_SHORT, true);
					}
					else{
						$newuserid = $this->getUser('id');
					}
					$articleId = $this->getInput('blogEditTitle', helper::FILTER_ID, true);
					// Incrémente le nouvel id de l'article
					if($articleId !== $this->getUrl(2)) {
						$articleId = helper::increment($articleId, $this->getData(['page']));
						$articleId = helper::increment($articleId, $this->getData(['data_module', $this->getUrl(0),'posts']));
						$articleId = helper::increment($articleId, array_keys(self::$actions));
					}
					$this->setData(['data_module',
						$this->getUrl(0),
						'posts',
						$articleId, [
							'comment' => $this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(2), 'comment']),
							'content' => $this->getInput('blogEditContent', null),
							'picture' => $this->getInput('blogEditPicture', helper::FILTER_STRING_SHORT),
							'hidePicture' => $this->getInput('blogEditHidePicture', helper::FILTER_BOOLEAN),
							'pictureSize' => $this->getInput('blogEditPictureSize', helper::FILTER_STRING_SHORT),
							'picturePosition' => $this->getInput('blogEditPicturePosition', helper::FILTER_STRING_SHORT),
							'publishedOn' => $this->getInput('blogEditPublishedOn', helper::FILTER_DATETIME, true),
							'state' => $this->getInput('blogEditState', helper::FILTER_BOOLEAN),
							'title' => $this->getInput('blogEditTitle', helper::FILTER_STRING_SHORT, true),
							'userId' => $newuserid,
							'editConsent' => $this->getInput('blogEditConsent') === self::EDIT_GROUP ? $this->getUser('group') : $this->getInput('blogEditConsent'),
							'commentMaxlength' => $this->getInput('blogEditCommentMaxlength'),
							'commentApproved' => $this->getInput('blogEditCommentApproved', helper::FILTER_BOOLEAN),
							'commentClose' => $this->getInput('blogEditCommentClose', helper::FILTER_BOOLEAN),
							'commentNotification'  => $this->getInput('blogEditCommentNotification', helper::FILTER_BOOLEAN),
							'commentGroupNotification' => $this->getInput('blogEditCommentGroupNotification', helper::FILTER_INT)
						]
					]);
					// Supprime l'ancien article
					if($articleId !== $this->getUrl(2)) {
						$this->deleteData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2)]);
					}
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
						'notification' => $text['blog']['edit'][1],
						'state' => true
					]);
				}
				// Liste des utilisateurs
				self::$users = helper::arrayCollumn($this->getData(['user']), 'firstname');
				ksort(self::$users);
				foreach(self::$users as $userId => &$userFirstname) {
				// Les membres ne sont pas éditeurs, les exclure de la liste
					if ( $this->getData(['user', $userId, 'group']) < self::GROUP_MODERATOR) {
						unset(self::$users[$userId]);
					}
					$userFirstname = $userFirstname . ' ' . $this->getData(['user', $userId, 'lastname']) . ' (' .  $groupEdits[$this->getData(['user', $userId, 'group'])] . ')';
				}
				unset($userFirstname);
				// Valeurs en sortie
				$this->addOutput([
					'title' => $this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2), 'title']),
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
	 * Accueil (deux affichages en un pour éviter une url à rallonge)
	 */
	public function index() {
		// Lexique
		$param = 'blog';
		include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');
		// Installation ou mise à jour
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
				// Soumission du formulaire
				if($this->isPost()) {
				
					// Sauve le contenu dans un brouillon
					// $this->setData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(1), 'comment', $commentId, 'draft', 'content', $this->getInput('blogArticleContent', false) ]);
					$_SESSION['commentAuthor'] = $this->getInput('blogArticleAuthor', false);
					$_SESSION['commentContent'] = $this->getInput('blogArticleContent', false);
					$detectBot ='';
					// Check la captcha
					if(	$this->getUser('password') !== $this->getInput('DELTA_USER_PASSWORD') ){
						$code='';
						if( isset($_REQUEST['codeCaptcha'])) $code = strtoupper($_REQUEST['codeCaptcha']);
						// option de détection de robot en premier cochée et $_SESSION['humanBot']==='human'
						if(	$_SESSION['humanBot']==='human' && $this->getData(['config', 'connect', 'captchaBot'])=== true ) {
							// Présence des 6 cookies et checkbox cochée ?
							$detectBot ='bot';
							if ( isset ($_COOKIE['evtC']) && isset ($_COOKIE['evtO']) && isset ($_COOKIE['evtV']) && isset ($_COOKIE['evtA'])
								&& isset ($_COOKIE['evtH']) && isset ($_COOKIE['evtS']) && $this->getInput('blogHumanCheck', helper::FILTER_BOOLEAN) === true ) {
								// Calcul des intervals de temps
								$time1 = $_COOKIE['evtC'] - $_COOKIE['evtO']; // temps entre fin de saisie et ouverture de la page
								$time2 = $_COOKIE['evtH'] - $_COOKIE['evtO']; // temps entre click checkbox et ouverture de la page
								$time3 = $_COOKIE['evtV'] - $_COOKIE['evtH']; // temps entre validation formulaire et click checkbox
								$time4 = $_COOKIE['evtS'] - $_COOKIE['evtA']; // temps passé sur la checkbox
								if( $time1 >= 5000 && $time2 >= 1000 && $time3 >=300 
									&& $time4 >=100 && $this->getInput('blogInputBlue')==='' ) $detectBot = 'human';
							}
							// Bot présumé
							if( $detectBot === 'bot') $_SESSION['humanBot']='bot';
						}
						// $_SESSION['humanBot']==='bot' ou option 'Pas de Captcha pour un humain' non validée
						elseif( md5($code) !== $_SESSION['captcha'] )
						{
							self::$inputNotices['blogArticleCaptcha'] = $text['blog']['index'][24];
						}
					}
					if( $detectBot !== 'bot' ){
						// Crée le commentaire
						$key = $this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(1), 'comment']);
						if( $key === null ) $key=array();
						$commentId = helper::increment(uniqid(), $key);
						$content = $this->getInput('blogArticleContent', false);
						$this->setData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(1), 'comment', $commentId, [
							'author' => $this->getInput('blogArticleAuthor', helper::FILTER_STRING_SHORT, empty($this->getInput('blogArticleUserId')) ? TRUE : FALSE),
							'content' => $content,
							'createdOn' => time(),
							'userId' => $this->getInput('blogArticleUserId'),
							'approval' => !$this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(1), 'commentApproved']) // true commentaire publié false en attente de publication
						]]);
						// Envoi d'une notification aux administrateurs
						// Init tableau
						$to = [];
						// Liste des destinataires
						foreach($this->getData(['user']) as $userId => $user) {
							if ($user['group'] >= $this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(1), 'commentGroupNotification']) ) {
								$to[] = $user['mail'];
								$firstname[] = $user['firstname'];
								$lastname[] = $user['lastname'];
							}
						}
						// Envoi du mail $sent code d'erreur ou de réussite
						$notification = $this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(1), 'commentApproved']) === true ? $this->getData(['module', $this->getUrl(0), 'texts', 'Waiting']): $this->getData(['module', $this->getUrl(0), 'texts', 'CommentOK']);
						if ($this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(1), 'commentNotification']) === true) {
							$error = 0;
							foreach($to as $key => $adress){
								$sent = $this->sendMail(
									$adress,
									$text['blog']['index'][4],
									$text['blog']['index'][5] . ' <strong>' . $firstname[$key] . ' ' . $lastname[$key] . '</strong>,<br><br>' .
									$text['blog']['index'][6].'<a href="' . helper::baseUrl() . $this->getUrl(0) . '/	' . $this->getUrl(1) . '">' . $this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(1), 'title']) . '</a>'.$text['blog']['index'][7].'<br><br>',
									''
								);
								if( $sent === false) $error++;
							}
							// Valeurs en sortie
							$this->addOutput([
								'redirect' => helper::baseUrl() . $this->getUrl() . '#comment',
								'notification' => ($error === 0 ? $notification . $text['blog']['index'][0] : $notification . $text['blog']['index'][1] . $sent),
								'state' => ($sent === true ? true : null)
							]);

						} else {
							// Valeurs en sortie
							$this->addOutput([
								'redirect' => helper::baseUrl() . $this->getUrl() . '#comment',
								'notification' => $notification,
								'state' => true
							]);
						}
						$_SESSION['commentContent'] = '';
					} else {
						// Valeurs en sortie
						$this->addOutput([
							'redirect' => helper::baseUrl() . $this->getUrl() . '#comment',
							'notification' => $text['blog']['index'][25],
							'state' => false
						]);					
					}
				}
				// Ids des commentaires approuvés par ordre de publication
				$commentsApproved = $this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(1), 'comment']);
				if ($commentsApproved) {
					foreach( $commentsApproved as $key => $value){
						if($value['approval']===false) unset($commentsApproved[$key]);
					}
					// Ligne suivante si affichage du nombre total de commentaires approuvés sous l'article
					self::$nbCommentsApproved = count($commentsApproved);
				}
				$commentIds = array_keys(helper::arrayCollumn($commentsApproved, 'createdOn', 'SORT_DESC'));
				// Pagination
				$pagination = helper::pagination($commentIds, $this->getUrl(), $this->getData(['module', $this->getUrl(0),'config', 'itemsperPage']),'#comment');
				// Liste des pages
				self::$pages = $pagination['pages'];
				// Signature de l'article
				self::$articleSignature = $this->signature($this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(1), 'userId']));
				// Signature du commentaire édité
				if($this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')) {
					self::$editCommentSignature = $this->signature($this->getUser('id'));
				}
				// Commentaires en fonction de la pagination
				for($i = $pagination['first']; $i < $pagination['last']; $i++) {
					// Signatures des commentaires
					$e = $this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(1), 'comment', $commentIds[$i],'userId']);
					if ($e) {
						self::$commentsSignature[$commentIds[$i]] = $this->signature($e);
					} else {
						self::$commentsSignature[$commentIds[$i]] = $this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(1), 'comment', $commentIds[$i],'author']);
					}
					// Données du commentaire si approuvé
					if ($this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(1), 'comment', $commentIds[$i],'approval']) === true ) {
						self::$comments[$commentIds[$i]] = $this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(1), 'comment', $commentIds[$i]]);
					}
				}
				
				// Boutons précédent et suivant par ordre de parution
				// Ids des articles par ordre de publication
				$articleIds = $this->listPublishedArticles();
				// Liste classée avec insertion d'une clef numérique et numéro de l'article visionné
				$orderedListArticles = []; 
				$numberArticle = '';
				foreach( $articleIds as $key=>$title ){
				  $orderedListArticles[$key][$title] = $this->getData(['data_module', $this->getUrl(0), 'posts', $title ]);
				  if($title === $this->getUrl(1)) $numberArticle = $key;
				}
				// Bouton article précédent
				if( $numberArticle!=='' && $numberArticle > 0 ) self::$urlPreviousArticle = helper::baseUrl().$this->getUrl(0).'/'.key($orderedListArticles[$numberArticle -1]);
				// Bouton article suivant
				if( $numberArticle!=='' && $numberArticle < count ($articleIds) -1 ) self::$urlNextArticle = helper::baseUrl().$this->getUrl(0).'/'.key($orderedListArticles[$numberArticle + 1]); 			
				
				// Valeurs en sortie (activation de tinymce déporté dans article.php)
				$this->addOutput([
					'showBarEditButton' => true,
					'title' => $this->getData(['data_module', $this->getUrl(0),  'posts', $this->getUrl(1), 'title']),
					'vendor' => ['tinymce'],
					'view' => 'article'
				]);
			}

		}
		// Liste des articles
		else {
			// Ids des articles par ordre de publication
			$articleIds = $this->listPublishedArticles();
			// Pagination
			$pagination = helper::pagination($articleIds, $this->getUrl(), $this->getData(['module', $this->getUrl(0),'config', 'itemsperPage']));
			// Liste des pages
			self::$pages = $pagination['pages'];
			// Articles en fonction de la pagination
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				self::$articles[$articleIds[$i]] = $this->getData(['data_module', $this->getUrl(0), 'posts', $articleIds[$i]]);
			}
			// Valeurs en sortie
			$this->addOutput([
				'showBarEditButton' => true,
				'showPageContent' => true,
				'view' => 'index'
			]);
		}
	}

	/**
	 * Retourne la liste des articles publiés par ordre de publication
	 */
	private function listPublishedArticles(){
		$articleIdsPublishedOns = helper::arrayCollumn($this->getData(['data_module', $this->getUrl(0),'posts']), 'publishedOn', 'SORT_DESC');
		$articleIdsStates = helper::arrayCollumn($this->getData(['data_module', $this->getUrl(0), 'posts']), 'state', 'SORT_DESC');
		$articleIds = [];
		foreach($articleIdsPublishedOns as $articleId => $articlePublishedOn) {
			if($articlePublishedOn <= time() AND $articleIdsStates[$articleId]) {
				$articleIds[] = $articleId;
			}
		}
		return $articleIds;
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
}
