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

class search extends common {

	const VERSION = '3.5';
	const REALNAME = 'Recherche';
	const DELETE = true;
	const UPDATE = '0.0';
	const DATADIRECTORY = self::DATA_DIR . 'search/';

	public static $actions = [
		'index' => self::GROUP_VISITOR,
		'config' => self::GROUP_EDITOR
	];

	// Variables pour l'affichage des résultats
	public static $resultList = '';
	public static $resultError = '';
	public static $resultTitle = '';

	// Variables pour le dialogue avec le formulaire
	public static $motclef = '';
	public static $motentier = true;
	public static $previewLength = [
		100 => '100',
		200 => '200',
		300 => '300',
		400 => '400',
	];


	/**
	 * Mise à jour du module
	 * Appelée par les fonctions index et config
	 */
	private function update() {


		$versionData = $this->getData(['module',$this->getUrl(0),'config', 'versionData' ]);

		// le module n'est pas initialisé
		if ($versionData === NULL || !file_exists(self::DATADIRECTORY . $this->getUrl(0)  . '/theme.css')){
			$this->init();
		}
		
		$versionData = $this->getData(['module',$this->getUrl(0),'config', 'versionData' ]);
		
		// Mise à jour 2.2
		if (version_compare($versionData, '2.2', '<') ) {
			if (is_dir(self::DATADIRECTORY . 'pages/')) {
				// Déplacer les données du dossier Pages
				$this->copyDir(self::DATADIRECTORY . 'pages/' . $this->getUrl(0), self::DATADIRECTORY . $this->getUrl(0));
				$this->removeDir(self::DATADIRECTORY . 'pages/');
			}
			// Mettre à jour la version
			$this->setData(['module',$this->getUrl(0),'config', 'versionData', '2.2' ]);
		}
		// Mise à jour 3.0
		if (version_compare($versionData, '3.0', '<') ) {
			// Nouveaux paramètres
			$this->setData(['module', $this->getUrl(0), 'config', 'nearWordText', 'Mots approchants' ]);
			$this->setData(['module', $this->getUrl(0), 'config', 'successTitle', 'Résultat de votre recherche' ]);
			$this->setData(['module', $this->getUrl(0), 'config', 'failureTitle', 'Aucun résultat' ]);
			$this->setData(['module', $this->getUrl(0), 'config', 'commentFailureTitle', 'Avez-vous pensé aux accents' ]);
			// Mettre à jour la version
			$this->setData(['module',$this->getUrl(0),'config', 'versionData', '3.0' ]);
		}
		// Mise à jour 3.2
		if (version_compare($versionData, '3.2', '<') ) {
			// Mettre à jour la version
			if(is_dir('./module/search/ressource/')) $this->removeDir('./module/search/ressource/');
			$this->setData(['module',$this->getUrl(0),'config', 'versionData', '3.2' ]);
		}
		// Mise à jour 3.4
		if (version_compare($versionData, '3.5', '<') ) {
			// Mettre à jour la version
			$this->setData(['module',$this->getUrl(0),'config', 'versionData', '3.5' ]);
		}
	}

	/**
	 * Initialisation du module
	 */
	private function init(){
		include('./module/search/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_search.php');

		$fileCSS = self::DATADIRECTORY . $this->getUrl(0) . '/theme.css' ;

		if ( null === $this->getData(['module', $this->getUrl(0)]) ) {
			// Données du module
			$this->setData(['module', $this->getUrl(0), 'config',[
			        'previewLength'      => intval($text['search']['init'][0]),
					'resultHideContent'  => boolval($text['search']['init'][1]),
					'placeHolder'        => $text['search']['init'][2],
					'submitText'         => $text['search']['init'][3],
					'versionData'        => self::VERSION,
					'nearWordText'		 => $text['search']['init'][5],
					'successTitle'		 => $text['search']['init'][6],
					'failureTitle'		 => $text['search']['init'][7],
					'commentFailureTitle' => $text['search']['init'][8]
			]]);
			// Données de thème
			$this->setData(['module', $this->getUrl(0), 'theme','keywordColor','rgba(229, 229, 1, 1)']);
			$this->setData(['module', $this->getUrl(0), 'theme', 'style', self::DATADIRECTORY . $this->getUrl(0) . '/theme.css' ]);
			// Recharger la page pour éviter une config vide
			//header("Refresh:0");
		}

		// Dossier de l'instance
		if (!is_dir(self::DATADIRECTORY . $this->getUrl(0))) {
			mkdir (self::DATADIRECTORY . $this->getUrl(0), 0755, true);
		}

		// Check la présence de la feuille de style
		if ( !file_exists(self::DATADIRECTORY . $this->getUrl(0) . '/theme.css')) {
			// Générer la feuille de CSS
			$style = '.keywordColor {background: ' . $this->getData([ 'module', $this->getUrl(0), 'theme', 'keywordColor'  ]) . ';}';
			// Sauver la feuille de style
			file_put_contents(self::DATADIRECTORY . $this->getUrl(0) . '/theme.css', $style );
			// Stocker le nom de la feuille de style
			$this->setData(['module', $this->getUrl(0) , 'theme', 'style', $fileCSS]);
		}

	}


	// Configuration vide
	public function config() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < search::$actions['config'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/search/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_search.php');

			// Mise à jour des données de module
			$this->update();

			if($this->isPost())  {

				// Générer la feuille de CSS
				$style = '.keywordColor {background:' . $this->getInput('searchKeywordColor') . ';}';
				$success = file_put_contents(self::DATADIRECTORY . $this->getUrl(0) . '/theme.css' , $style );
				// Fin feuille de style

				// Soumission du formulaire
				$this->setData(['module', $this->getUrl(0), 'config',[
					'submitText' => $this->getInput('searchSubmitText'),
					'placeHolder' => $this->getInput('searchPlaceHolder'),
					'resultHideContent' => $this->getInput('searchResultHideContent',helper::FILTER_BOOLEAN),
					'previewLength' => $this->getInput('searchPreviewLength',helper::FILTER_INT),
					'versionData' => $this->getData(['module', $this->getUrl(0), 'config', 'versionData']),
					'nearWordText' => $this->getInput('searchNearWordText'),
					'successTitle' => $this->getInput('searchSuccessTitle'),
					'failureTitle' => $this->getInput('searchFailureTitle'),
					'commentFailureTitle'=> $this->getInput('searchCommentFailureTitle')
				]]);
				$this->setData(['module', $this->getUrl(0), 'theme',[
					'keywordColor' => $this->getInput('searchKeywordColor'),
					'style' => $success ? self::DATADIRECTORY . $this->getUrl(0) . '/theme.css' : '',
				]]);


				// Valeurs en sortie, affichage du formulaire
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(),
					'notification' => $success !== FALSE ? $text['search']['config'][0] : $text['search']['config'][1],
					'state' => $success !== FALSE
				]);

			}
			// Valeurs en sortie, affichage du formulaire
			$this->addOutput([
				'title' => $text['search']['config'][2],
				'view' => 'config',
				'vendor' => [
					'tinycolorpicker'
				]
			]);
		}
	}

	public function index() {

		// Mise à jour des données de module
		$this->update();

		if($this->isPost())  {
			//Initialisations variables
			$success = true;
			$result = [];
			$notification = '';
			$total='';

			// Récupération du mot clef passé par le formulaire de ...view/index.php, avec caractères accentués
			self::$motclef=$this->getInput('searchMotphraseclef');
			// Variable de travail, on conserve la variable globale pour l'affichage du résultat
			$motclef = self::$motclef;

			// Traduction du mot clé si le script Google Trad est actif
			// Le multi langue est sélectionné
			if (  $this->getData(['config','i18n','scriptGoogle']) === true
			AND
				// et la traduction de la langue courante est automatique
				(   isset($_COOKIE['googtrans'])
					AND ( $this->getData(['config','i18n', substr($_COOKIE['googtrans'],4,2)]) === 'script'
					// Ou traduction automatique
						OR 	$this->getData(['config','i18n','autoDetect']) === true )
				)
			// Cas des pages d'administration
			// Pas connecté
			AND ( $this->getUser('password') !== $this->getInput('DELTA_USER_PASSWORD')
				// Ou connecté avec option active
				OR ($this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')
					AND $this->getData(['config','i18n','admin']) === true
					)
				)
			AND !isset($_COOKIE['DELTA_I18N_SITE'])
			)
			{
				// Découper la chaîne
				$f = str_getcsv($motclef, ' ');
				// Supprimer les espaces et les guillemets
				$f = str_replace(' ','',$f);
				$f = str_replace('"','',$f);
				// Lire le cookie GoogTrans et déterminer les langues cibles
				$language['origin'] = substr($_COOKIE['googtrans'],4,2);
				$language['target'] = substr($_COOKIE['googtrans'],1,2);
				if ($language['target'] !== $language['origin']) {
					foreach ($f as $key => $value) {
						$e = $this->translate($language['origin'],$language['target'],$value);
						$motclef = str_replace($value,$e,$motclef);
					}
				}
			}

			// Suppression des mots < 3  caractères et des articles > 2 caractères de la chaîne $motclef
			$arraymotclef = explode(' ', $motclef);
			$motclef = '';
			foreach($arraymotclef as $key=>$value){
				if( strlen($value)>2 && $value!=='les' && $value!=='des' && $value!=='une' && $value!=='aux') $motclef.=$value.' ';
			}
			// Suppression du dernier ' '
			if($motclef !== '') $motclef = substr($motclef,0, strlen($motclef)-1);

			// Récupération de l'état de l'option mot entier passé par le même formulaire
			self::$motentier=$this->getInput('searchMotentier', helper::FILTER_BOOLEAN);

			if ($motclef !== '' ) {
				foreach($this->getHierarchy(null,false,null) as $parentId => $childIds) {
					if ($this->getData(['page', $parentId, 'disable']) === false  &&
                        $this->getUser('group') >= $this->getData(['page', $parentId, 'group']) &&
                        $this->getData(['page', $parentId, 'block']) !== 'bar') 	{
						$url = $parentId;
						$titre = $this->getData(['page', $parentId, 'title']);
						//$content = file_get_contents(self::DATA_DIR . self::$i18n . '/content/' . $this->getData(['page', $parentId, 'content']));
						$content = $this->getPage($parentId, self::$i18n);
						$content =   $titre . ' ' . $content ;
						// Pages sauf pages filles et articles de blog
						$tempData  = $this->occurrence($url, $titre, $content, $motclef, self::$motentier);
						if (is_array($tempData) ) {
							$result [] = $tempData;
						}
					}

					foreach($childIds as $childId) {
							// Sous page
							if ($this->getData(['page', $childId, 'disable']) === false &&
                                $this->getUser('group') >= $this->getData(['page', $parentId, 'group']) &&
                                $this->getData(['page', $parentId, 'block']) !== 'bar') 	{
                                    $url = $childId;
                                    $titre = $this->getData(['page', $childId, 'title']);
									//$content = file_get_contents(self::DATA_DIR . self::$i18n . '/content/' . $this->getData(['page', $childId, 'content']));
									$content = $this->getPage($childId, self::$i18n);
									$content =   $titre . ' ' . $content ;
                                    //Pages filles
									$tempData  = $this->occurrence($url, $titre, $content, $motclef, self::$motentier);
									if (is_array($tempData) ) {
										$result [] = $tempData;
									}
							}

							// Articles d'une sous-page blog ou de news
							if (($this->getData(['page', $childId, 'moduleId']) === 'blog' || $this->getData(['page', $childId, 'moduleId']) === 'news')
							 && $this->getData(['data_module',$childId,'posts']) )
							{
								foreach($this->getData(['data_module',$childId,'posts']) as $articleId => $article) {
									if($this->getData(['data_module',$childId,'posts',$articleId,'state']) === true)  {
										$url = $childId . '/' . $articleId;
										$titre = $article['title'];
										$contenu = ' ' . $titre . ' ' . $article['content'];
										// Articles de sous-page de type blog
										$tempData  = $this->occurrence($url, $titre, $contenu, $motclef, self::$motentier);
										if (is_array($tempData) ) {
											$result [] = $tempData;
										}
									}
                                }
							}
                    }

					// Articles d'un blog ou de news
					if ( ($this->getData(['page', $parentId, 'moduleId']) === 'blog' || $this->getData(['page', $parentId, 'moduleId']) === 'news')
						 && $this->getData(['data_module',$parentId,'posts']) ) {
						foreach($this->getData(['data_module',$parentId,'posts']) as $articleId => $article) {
							if($this->getData(['data_module',$parentId,'posts',$articleId,'state']) === true)
							{
								$url = $parentId. '/' . $articleId;
								$titre = $article['title'];
								$contenu = ' ' . $titre . ' ' . $article['content'];
								$tempData  = $this->occurrence($url, $titre, $contenu, $motclef, self::$motentier);
								if (is_array($tempData) ) {
									$result [] = $tempData;
								}
							}
                        }
					}
				}

				// Message de synthèse de la recherche
				if (count($result) === 0) 	{
					self::$resultTitle = $this->getData(['module', $this->getUrl(0), 'config', 'failureTitle']);
					self::$resultError = $this->getData(['module', $this->getUrl(0), 'config', 'commentFailureTitle']);
				} else  {
					self::$resultError = '';
					self::$resultTitle = $this->getData(['module', $this->getUrl(0), 'config', 'successTitle']);
					rsort($result);
					foreach ($result as $key => $value) {
						$r [] = $value['preview'];
					}
					// Générer une chaine de caractères
					self::$resultList= implode("", $r);
				}
			}

			// Valeurs en sortie, affichage du résultat
			$this->addOutput([
				'view' => 'index',
				'showBarEditButton' => true,
				'showPageContent' => !$this->getData(['module', $this->getUrl(0), 'config', 'resultHideContent']),
				'style' => $this->getData(['module', $this->getUrl(0), 'theme', 'style'])
			]);
		} else {
			// Valeurs en sortie, affichage du formulaire
			$this->addOutput([
				'view' => 'index',
				'showBarEditButton' => true,
				'showPageContent' => true
			]);
		}
	}


	// Fonction de recherche des occurrences dans $contenu
	// Renvoie le résultat sous forme de chaîne
	private function occurrence($url, $titre, $contenu, $motclef, $motentier) {
		// Lexique
		include('./module/search/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_search.php');

		// Nettoyage de $contenu : on enlève tout ce qui est inclus entre < et >
		$contenu = preg_replace ('/<[^>]*>/', ' ', $contenu);
		// Accentuation
		$contenu = html_entity_decode($contenu);

		// Découper le chaîne en tenant compte des quillemets
		$a = str_getcsv(html_entity_decode($motclef), ' ');

		// Construire la clé de recherche selon options de recherche
		$keywords = '/(';

		foreach ($a as $key => $value) {

			$keywords .= $motentier === true ? $value . '|' : '\b' . $value . '\b|' ;
		}
		$keywords = substr($keywords,0,strlen($keywords) - 1);
		$keywords .= ')/i';
		$keywords = str_replace ('+', ' ',$keywords);

		// Rechercher
		$valid = preg_match_all($keywords,$contenu,$matches,PREG_OFFSET_CAPTURE);
		if ($valid > 0 ) {
			if (($matches[0][0][1]) > 0) {
				$resultat = '<h2><a  href="./?'.$url.'" target="_blank" rel="noopener">' . $titre .  '</a></h2>';
				// Création de l'aperçu. Eviter de découper avec une valeur négative
				$d = $matches[0][0][1] - 50 < 0 ? 1 : $matches[0][0][1] - 50;
				// Rechercher l'espace le plus proche
				$d = $d >= 1 ? strpos($contenu,' ',$d) : $d;
				// Découper l'aperçu
				$t = substr($contenu, $d ,$this->getData(['module',$this->getUrl(0), 'config', 'previewLength']));
				// Applique une mise en évidence
				$t = preg_replace($keywords, '<span class= "keywordColor">\1</span>',$t);
				// Sauver résultat
				$resultat .= '<p class="searchResult">'.$t.'...</p>';
				$resultat .= '<p class="searchTitle">' . count($matches[0]) . (count($matches[0]) === 1 ? $text['search']['occurence'][0].'<p>' : $text['search']['occurence'][1].'<p>');
				//}
				return ([
					'matches' => count($matches[0]),
					'preview' => $resultat
				]);
			}
		}
	}

	// Requête de traduction avec le script Google
	private function translate($from_lan, $to_lan, $text) {
		$arrayjson = json_decode(file_get_contents('https://translate.googleapis.com/translate_a/single?client=gtx&sl='.$from_lan.'&tl=fr&dt=t&q='.$text),true);
		return $arrayjson[0][0][0];
	}
}
