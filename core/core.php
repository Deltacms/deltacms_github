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

class common {

	const DISPLAY_RAW = 0;
	const DISPLAY_JSON = 1;
	const DISPLAY_RSS = 2;
	const DISPLAY_LAYOUT_BLANK = 3;
	const DISPLAY_LAYOUT_MAIN = 4;
	const DISPLAY_LAYOUT_LIGHT = 5;
	const GROUP_BANNED = -1;
	const GROUP_VISITOR = 0;
	const GROUP_MEMBER = 1;
	const GROUP_EDITOR = 2;
	const GROUP_MODERATOR = 3;
	const GROUP_ADMIN = 4;
	const SIGNATURE_ID = 1;
	const SIGNATURE_PSEUDO = 2;
	const SIGNATURE_FIRSTLASTNAME = 3;
	const SIGNATURE_LASTFIRSTNAME = 4;
	// Dossier de travail
	const BACKUP_DIR = 'site/backup/';
	const DATA_DIR = 'site/data/';
	const FILE_DIR = 'site/file/';
	const TEMP_DIR = 'site/tmp/';

	// Miniatures de la galerie
	const THUMBS_SEPARATOR = 'mini_';
	const THUMBS_WIDTH = 640;

	// Contrôle d'édition temps maxi en secondes avant déconnexion 30 minutes
	const ACCESS_TIMER = 1800;

	// Numéro de version
	const DELTA_UPDATE_URL = 'https://update.deltacms.fr/master/';
	const DELTA_VERSION = '5.1.00';
	const DELTA_UPDATE_CHANNEL = "v5";

	public static $actions = [];
	public static $coreModuleIds = [
		'config',
		'install',
		'maintenance',
		'page',
		'sitemap',
		'theme',
		'user',
		'translate',
		'addon'
	];
	public static $accessList = [
		'user',
		'theme',
		'config',
		'edit',
		'config',
		'translate'
	];
	public static $accessExclude = [
		'login',
		'logout'
	];
	private $data = [];
	private $hierarchy = [
		'all' => [],
		'visible' => [],
		'bar' => []
	];
	private $input = [
		'_COOKIE' => [],
		'_POST' => []
	];
	public static $inputBefore = [];
	public static $inputNotices = [];
	public static $importNotices = [];
	public static $captchaNotices = [];
	public static $coreNotices = [];
	public $output = [
		'access' => true,
		'content' => '',
		'contentLeft' => '',
		'contentRight' => '',
		'display' => self::DISPLAY_LAYOUT_MAIN,
		'metaDescription' => '',
		'metaTitle' => '',
		'notification' => '',
		'redirect' => '',
		'script' => '',
		'showBarEditButton' => false,
		'showPageContent' => false,
		'state' => false,
		'style' => '',
		'title' => null, // Null car un titre peut être vide
		// chargement des scripts et des styles dans head
		'vendor' => [
			'jquery',
			//'normalize', chargé par main.php avant common.css
			'lity',
			'filemanager',
			'tippy',
			'delta-ico',
			'imagemap',
			'simplelightbox',
			'swiper'
		],
		// chargement des styles dans head
		'vendorCss' => [],
		// chargement des scripts dans body
		'vendorJsBody' => [],
		'view' => ''
	];
	// Tableaux dynamiques des vendor triés
	public static	$cssVendorPath = [];
	public static	$jsHeadVendorPath = [];
	public static	$jsBodyVendorPath = [];
	// Langues proposées, conserver ces 5 variables $i18nList...
	public static $i18nList = [
		'fr'	=> 'Français (fr)',
		'de' 	=> 'Allemand (de)',
		'en'	=> 'Anglais (en)',
		'da'	=> 'Danois (da)',
		'es'	=> 'Espagnol (es)',
		'fi'	=> 'Finnois (fi)',
		'el' 	=> 'Grec (el)',
		'it'	=> 'Italien (it)',
		'ga'	=> 'Irlandais (ga)',
		'nl' 	=> 'Néerlandais (nl)',
		'pt'	=> 'Portugais (pt)',
		'sv'	=> 'Suédois (sv)',
		'br'	=> 'Breton (br)',
		'ca'	=> 'Catalan (ca)',
		'co'	=> 'Corse (co)',
		'eu'	=> 'Basque (eu)',
		'none'	=> 'Autre langue'
	];
	public static $i18nList_es = [
		'fr' => 'Francés (fr)',
		'de' => 'Alemán (de)',
		'en' => 'Inglés (en)',
		'da' => 'Danés (da)',
		'es' => 'Español (es)',
		'fi' => 'Finés (fi)',
		'el' => 'Griego (el)',
		'it' => 'Italiano (it)',
		'ga' => 'Irlandés (ga)',
		'nl' => 'Holandés (nl)',
		'pt' => 'Portugués (pt)',
		'sv' => 'Sueco (sv)',
		'br' => 'Bretón (br)',
		'ca' => 'Catalán (ca)',
		'co' => 'Córcega (co)',
		'eu' => 'Euskera (eu)',
		'none' => 'Otro idioma'
	];
	public static $i18nList_en = [
		'en'	=> 'English (en)',
		'fr'	=> 'French (fr)',
		'de'	=> 'German (de)',
		'es'	=> 'Spanish (es)',
		'da'	=> 'Danish (da)',
		'fi'	=> 'Finnish (fi)',
		'el'	=> 'Greek (el)',
		'it'	=> 'Italian (it)',
		'ga'	=> 'Irish (ga)',
		'nl'	=> 'Dutch (nl)',
		'pt'	=> 'Portuguese (pt)',
		'sv' 	=> 'Swedish (sv)',
		'br'	=> 'Breton (br)',
		'ca'	=> 'Catalan (ca)',
		'co'	=> 'Corsican (co)',
		'eu'	=> 'Basque (eu)',
		'none'	=> 'Other language'
	];
	public static $i18nList_admin	= [
		'fr'	=> 'Français (fr)',
		'en'	=> 'English (en)',
		'es'	=> 'Español (es)'
	];
	public static $i18nList_int = [
		'fr'	=> 'Français (fr)',
		'da'	=> 'Dansk (da)',
		'de' 	=> 'Deutsch (de)',
		'el' 	=> 'Ελληνική (el)',
		'en'	=> 'English (en)',
		'es'	=> 'Español (es)',
		'ga'	=> 'Gaeilge (ga)',
		'it'	=> 'Italiano (it)',
		'nl' 	=> 'Nederlands (nl)',
		'pt'	=> 'Português (pt)',
		'fi'	=> 'Suomalainen (fi)',
		'sv'	=> 'Svenska (sv)',
		'br'	=> 'Brezhoneg (br)',
		'ca'	=> 'Català (ca)',
		'co'	=> 'Corsu (co)',
		'eu'	=> 'Euskara (eu)',
		'none'	=> 'Other language (?)'
	];
	// Langues non prises en charge par la traduction automatique
	public static $i18nListSiteOnly = [
		'br'	=> 'Breton (br)'
	];
	// Langue courante
	public static $i18n;
	public static $timezone;
	private $url = '';
	// Données de site
	private $user = [];
	private $core = [];
	private $config = [];
	private $fonts =[];
	// Dossier localisé
	private $page = [];
	private $module = [];
	private $locale = [];
	private $comment = [];

	// Descripteur de données Entrées / Sorties
	// Liste ici tous les fichiers de données
	private $dataFiles = [
		'config' => '',
		'page' => '',
		'module' => '',
		'core' => '',
		'user' => '',
		'theme' => '',
		'admin' => '',
		'blacklist' => '',
		'locale' => '',
		'fonts' => '',
		'session' =>'',
		'comment' =>''
	];

	/**
	 * Constructeur commun
	 */
	public function __construct() {

		// Extraction des données http
		if(isset($_POST)) {
			$this->input['_POST'] = $_POST;
		}
		if(isset($_COOKIE)) {
			$this->input['_COOKIE'] = $_COOKIE;
		}

		// Déterminer la langue sélectionnée pour le chargement des fichiers de données
		if (isset($this->input['_COOKIE']['DELTA_I18N_SITE'])
		) {
			self::$i18n = $this->input['_COOKIE']['DELTA_I18N_SITE'];
			setlocale (LC_TIME, self::$i18n . '_' . strtoupper (self::$i18n) );

		} else  {
			self::$i18n = 'base';
		}

		// Instanciation de la classe des entrées / sorties
		// Récupère les descripteurs
		foreach ($this->dataFiles as $keys => $value) {
			// Constructeur  JsonDB
			$this->dataFiles[$keys] = new \Prowebcraft\JsonDb([
				'name' => $keys . '.json',
				'dir' => $this->dataPath ($keys, self::$i18n),
				'backup' => file_exists('site/data/.backup')
			]);;
		}


		// Installation fraîche, initialisation des modules manquants
		// La langue d'installation par défaut est base
		foreach ($this->dataFiles as $stageId => $item) {
			$folder = $this->dataPath ($stageId, self::$i18n);
			if (file_exists($folder . $stageId .'.json') === false) {
				$this->initData($stageId, self::$i18n);
				common::$coreNotices [] = $stageId ;
			}
		}

		// Utilisateur connecté
		if($this->user === []) {
			$this->user = $this->getData(['user', $this->getInput('DELTA_USER_ID')]);
		}

		/**
		 * Discrimination humain robot pour shuntage des Captchas
		 * Initialisation à 'bot' ou 'human' en fonction des données $_SERVER : à développer !
		 */
		if( !isset( $_SESSION['humanBot'] )){
			$_SESSION['humanBot'] = 'bot';
			if( !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ) $_SESSION['humanBot'] = 'human';
		}

		// Construit la liste des pages parents/enfants
		if($this->hierarchy['all'] === []) {
			$pages = helper::arrayCollumn($this->getData(['page']), 'position', 'SORT_ASC');
			// Parents
			foreach($pages as $pageId => $pagePosition) {
				if(
					// Page parent
					$this->getData(['page', $pageId, 'parentPageId']) === ""
					// Ignore les pages dont l'utilisateur n'a pas accès
					AND (
						$this->getData(['page', $pageId, 'group']) === self::GROUP_VISITOR
						OR (
							$this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')
							AND $this->getUser('group') >= $this->getData(['page', $pageId, 'group'])
						)
					)
				) {
					if($pagePosition !== 0) {
						$this->hierarchy['visible'][$pageId] = [];
					}
					if($this->getData(['page', $pageId, 'block']) === 'bar') {
						$this->hierarchy['bar'][$pageId] = [];
					}
					$this->hierarchy['all'][$pageId] = [];
				}
			}
			// Enfants
			foreach($pages as $pageId => $pagePosition) {
				if(
					// Page parent
					$parentId = $this->getData(['page', $pageId, 'parentPageId'])
					// Ignore les pages dont l'utilisateur n'a pas accès
					AND (
						(
							$this->getData(['page', $pageId, 'group']) === self::GROUP_VISITOR
							AND $this->getData(['page', $parentId, 'group']) === self::GROUP_VISITOR
						)
						OR (
							$this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')
							AND $this->getUser('group') >= $this->getData(['page', $parentId, 'group'])
							AND $this->getUser('group') >= $this->getData(['page', $pageId, 'group'])
						)
					)
				) {
					if($pagePosition !== 0) {
						$this->hierarchy['visible'][$parentId][] = $pageId;
					}
					if($this->getData(['page', $pageId, 'block']) === 'bar') {
						$this->hierarchy['bar'][$pageId] = [];
					}
					$this->hierarchy['all'][$parentId][] = $pageId;
				}
			}
		}
		// Construit l'url
		if($this->url === '') {
			if($url = $_SERVER['QUERY_STRING']) {
				$this->url = $url;
			}
			else {
				if( null !== $this->getData(['page', $this->getData(['locale', 'homePageId']) ]) ){
					$this->url = $this->getData(['locale', 'homePageId']);
				} else {
					$pages = array_keys($this->getData(['page']));
					$this->url = $pages[0];
				}
			}
		}

		// Mise à jour des données core
		if( $this->getData(['core', 'dataVersion']) !== intval(str_replace('.','',self::DELTA_VERSION))) include( 'core/include/update.inc.php');

		// Données de proxy
		$proxy = $this->getData(['config','proxyType']) . $this->getData(['config','proxyUrl']) . ':' . $this->getData(['config','proxyPort']);
		if (!empty($this->getData(['config','proxyUrl'])) &&
			!empty($this->getData(['config','proxyPort'])) )  {
			$context = array(
				'http' => array(
					'proxy' => $proxy,
					'request_fulluri' => true,
					'verify_peer'      => false,
					'verify_peer_name' => false,
				),
				"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false
				)
			);
			stream_context_set_default($context);
		}

	}

	/**
	 * Ajoute les valeurs en sortie
	 * @param array $output Valeurs en sortie
	 */
	public function addOutput($output) {
		$this->output = array_merge($this->output, $output);
	}

	/**
	 * Ajoute une notice de champ obligatoire
	 * @param string $key Clef du champ
	 */
	public function addRequiredInputNotices($key) {
		// Lexique
		include('./core/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_core.php');
		// La clef est un tableau
		if(preg_match('#\[(.*)\]#', $key, $secondKey)) {
			$firstKey = explode('[', $key)[0];
			$secondKey = $secondKey[1];
			if(empty($this->input['_POST'][$firstKey][$secondKey])) {
				common::$inputNotices[$firstKey . '_' . $secondKey] = $text['core']['addRequiredInputNotices'][0];
			}
		}
		// La clef est une chaine
		elseif(empty($this->input['_POST'][$key])) {
			common::$inputNotices[$key] = $text['core']['addRequiredInputNotices'][0];
		}
	}

	/**
	 * Check du token CSRF (true = bo
	 */
	public function checkCSRF() {
		return ((empty($_POST['csrf']) OR hash_equals($_SESSION['csrf'], $_POST['csrf']) === false) === false);
	}

	/**
	 * Supprime des données
	 * @param array $keys Clé(s) des données
	 */
	public function deleteData($keys) {
		// Instanciation si $keys[0]='data_module' avec $keys[1]= nomdelapage et $keys[2] présent
		if( $keys[0] === 'data_module' && count($keys) >= 3 ){
				// Constructeur  JsonDB
				$this->dataFiles[$keys[2]] = new \Prowebcraft\JsonDb([
					'name' => $keys[1]. '.json',
					'dir' => self::DATA_DIR. self::$i18n.'/data_module/',
					'backup' => file_exists('site/data/.backup')
				]);
				unset($keys[0]);
				unset($keys[1]);
				$keys = array_values($keys);
				
		}
		// Descripteur
		$db = $this->dataFiles[$keys[0]];
		// Aiguillage
		switch(count($keys)) {
			case 1:
				$db->delete($keys[0], true);
				break;
			case 2:
				$db->delete($keys[0].'.'.$keys[1],true);
				break;
			case 3:
				$db->delete($keys[0].'.'.$keys[1].'.'.$keys[2], true);
				break;
			case 4:
				$db->delete($keys[0].'.'.$keys[1].'.'.$keys[2].'.'.$keys[3], true);
				break;
			case 5:
				$db->delete($keys[0].'.'.$keys[1].'.'.$keys[2].'.'.$keys[3].'.'.$keys[4], true);
				break;
			case 6:
				$db->delete($keys[0].'.'.$keys[1].'.'.$keys[2].'.'.$keys[3].'.'.$keys[4].'.'.$keys[5], true);
				break;
			case 7:
				$db->delete($keys[0].'.'.$keys[1].'.'.$keys[2].'.'.$keys[3].'.'.$keys[4].'.'.$keys[5].'.'.$keys[6], true);
				break;
		}
	}

	/**
	 * Accède aux données
	 * @param array $keys Clé(s) des données
	 * @return mixed
	 */
	public function getData($keys = []) {

		if (count($keys) >= 1) {
			/**
			 * Lecture directe
			*/
			// Instanciation si $keys[0]='data_module' avec $keys[1]= nomdelapage et $keys[2] présent
			if( $keys[0] === 'data_module' && count($keys) >= 3 ){
					// Constructeur  JsonDB
					$this->dataFiles[$keys[2]] = new \Prowebcraft\JsonDb([
						'name' => $keys[1]. '.json',
						'dir' => self::DATA_DIR. self::$i18n.'/data_module/',
						'backup' => file_exists('site/data/.backup')
					]);
					unset($keys[0]);
					unset($keys[1]);
					$keys = array_values($keys);
					
			}
			// Descripteur
			$db = $this->dataFiles[$keys[0]];
			switch(count($keys)) {
				case 1:
					$tempData = $db->get($keys[0]);
					break;
				case 2:
					$tempData = $db->get($keys[0].'.'.$keys[1]);
					break;
				case 3:
					$tempData = $db->get($keys[0].'.'.$keys[1].'.'.$keys[2]);
					break;
				case 4:
					$tempData = $db->get($keys[0].'.'.$keys[1].'.'.$keys[2].'.'.$keys[3]);
					break;
				case 5:
					$tempData = $db->get($keys[0].'.'.$keys[1].'.'.$keys[2].'.'.$keys[3].'.'.$keys[4]);
					break;
				case 6:
					$tempData = $db->get($keys[0].'.'.$keys[1].'.'.$keys[2].'.'.$keys[3].'.'.$keys[4].'.'.$keys[5]);
					break;
				case 7:
					$tempData = $db->get($keys[0].'.'.$keys[1].'.'.$keys[2].'.'.$keys[3].'.'.$keys[4].'.'.$keys[5].'.'.$keys[6]);
					break;
				case 8:
					$tempData = $db->get($keys[0].'.'.$keys[1].'.'.$keys[2].'.'.$keys[3].'.'.$keys[4].'.'.$keys[5].'.'.$keys[6].'.'.$keys[7]);
					break;
			}
			return $tempData;
		}
	}

	/**
	 * Lire les données de la page
	 * @param string pageId
	 * @param string langue
	 * @param return contenu de la page
	 */
	public function getPage($page, $lang) {

		// Le nom de la ressource et le fichier de contenu sont définis :
		if (
				$this->getData(['page', $page, 'content']) !== ''
				&& file_exists(self::DATA_DIR . $lang . '/content/' . $this->getData(['page', $page, 'content']))
				&& is_file(self::DATA_DIR . $lang . '/content/' . $this->getData(['page', $page, 'content']))
			) {
				return file_get_contents(self::DATA_DIR . $lang . '/content/' . $this->getData(['page', $page, 'content']));
			} else {
				return 'Aucun contenu trouvé.';
		}

	}

	/**
	 * Ecrire les données de la page
	 * @param string pageId
	 * @param string contenu de la page
	 * @param return nombre d'octets écrits ou erreur
	 */
	public function setPage($page, $value, $lang) {

		return file_put_contents(self::DATA_DIR . $lang . '/content/' . $page . '.html', $value);

	}

	/**
	 * Effacer les données de la page
	 * @param string pageId
	 * @param return statut de l'effacement
	 */
	public function deletePage($page, $lang) {

			return unlink(self::DATA_DIR . $lang . '/content/' . $this->getData(['page', $page, 'content']));

			}

	/**
	 * Sauvegarde des données
	 * @param array $keys Clé(s) des données
	 */
	public function setData($keys = []) {
		// Pas d'enregistrement lorsqu'une notice est présente ou tableau transmis vide
		if (!empty(self::$inputNotices)
			OR empty($keys)) {
			return false;
		}

		// Empêcher la sauvegarde d'une donnée nulle.
		if (gettype($keys[count($keys) -1]) === NULL) {
			return false;
		}

		// Instanciation si $keys[0]='data_module' avec $keys[1]= nomdelapage et $keys[2] présent
		if( $keys[0] === 'data_module' && count($keys) >= 3 ){
				// Constructeur  JsonDB
				$this->dataFiles[$keys[2]] = new \Prowebcraft\JsonDb([
					'name' => $keys[1]. '.json',
					'dir' => self::DATA_DIR. self::$i18n.'/data_module/',
					'backup' => file_exists('site/data/.backup')
				]);
				unset($keys[0]);
				unset($keys[1]);
				$keys = array_values($keys);
				
		}
		// Descripteur
		$db = $this->dataFiles[$keys[0]];
		// Aiguillage
		switch(count($keys)) {
			case 2:
				$db->set($keys[0],$keys[1], true);
				break;
			case 3:
				$db->set($keys[0].'.'.$keys[1],$keys[2], true);
				break;
			case 4:
				$db->set($keys[0].'.'.$keys[1].'.'.$keys[2],$keys[3], true);
				break;
			case 5:
				$db->set($keys[0].'.'.$keys[1].'.'.$keys[2].'.'.$keys[3],$keys[4], true);
				break;
			case 6:
				$db->set($keys[0].'.'.$keys[1].'.'.$keys[2].'.'.$keys[3].'.'.$keys[4],$keys[5], true);
				break;
			case 7:
				$db->set($keys[0].'.'.$keys[1].'.'.$keys[2].'.'.$keys[3].'.'.$keys[4].'.'.$keys[5],$keys[6], true);
				break;
			case 8:
				$db->set($keys[0].'.'.$keys[1].'.'.$keys[2].'.'.$keys[3].'.'.$keys[4].'.'.$keys[5].'.'.$keys[6],$keys[7], true );
				break;
		}
		return true;
	}

	/**
	 * Initialisation des données
	 * @param array $module : nom du module à générer
	 * choix valides :  core config user theme page module
	 */
	public function initData($module, $lang = 'base', $sampleSite = false) {

		// Tableau avec les données vierges
		require_once('core/module/install/ressource/defaultdata.php');

		// Stockage dans un sous-dossier localisé
		if (!file_exists(self::DATA_DIR .  $lang)) {
			mkdir (self::DATA_DIR .$lang, 0755);
		}
		$db = $this->dataFiles[$module];
		if ($sampleSite === true) {
			$db->set($module,init::$siteData[$module]);
		} else {
			$db->set($module,init::$defaultData[$module]);
		}
		$db->save;

		// Dossier des pages
		if (!is_dir(self::DATA_DIR . $lang . '/content')) {
			mkdir(self::DATA_DIR . $lang . '/content', 0755);
		}
		
		// Dossier des données de page
		if (!is_dir(self::DATA_DIR . $lang . '/data_module')) {
			mkdir(self::DATA_DIR . $lang . '/data_module', 0755);
		}
		
		// Créer le jeu de pages du site de test
		if ($module === 'page' ) {
			// Site de test ou page simple
			if ($sampleSite === true) {
				foreach(init::$siteContent as $key => $value) {
					// Creation du contenu de la page
					if (!empty($this->getData(['page', $key, 'content'])) ) {
						file_put_contents(self::DATA_DIR . $lang . '/content/' . $this->getData(['page', $key, 'content']), $value);
					}
				}
			} else {
				// Créer la page d'accueil
				file_put_contents(self::DATA_DIR . $lang . '/content/' . 'accueil.html', '<p>Contenu de votre nouvelle page.</p>');
			}
		}
	}

	/*
	* Dummy function
	* Compatibilité des modules avec v8 et v9
	*/
	public function saveData() {
		return;
	}

	/**
	 * Accède à la liste des pages parents et de leurs enfants
	 * @param int $parentId Id de la page parent
	 * @param bool $onlyVisible Affiche seulement les pages visibles
	 * @param bool $onlyBlock Affiche seulement les pages de type barre
	 * @return array
	 */
	public function getHierarchy($parentId = null, $onlyVisible = true, $onlyBlock = false) {
		$hierarchy = $onlyVisible ? $this->hierarchy['visible'] : $this->hierarchy['all'];
		$hierarchy = $onlyBlock ? $this->hierarchy['bar'] : $hierarchy;
		// Enfants d'un parent
		if($parentId) {
			if(array_key_exists($parentId, $hierarchy)) {
				return $hierarchy[$parentId];
			}
			else {
				return [];
			}
		}
		// Parents et leurs enfants
		else {
			return $hierarchy;
		}
	}

	/**
	 * Accède à une valeur des variables http (ordre de recherche en l'absence de type : _COOKIE, _POST)
	 * @param string $key Clé de la valeur
	 * @param int $filter Filtre à appliquer à la valeur
	 * @param bool $required Champ requis
	 * @return mixed
	 */
	public function getInput($key, $filter = helper::FILTER_STRING_SHORT, $required = false) {
		// La clef est un tableau
		if(preg_match('#\[(.*)\]#', $key, $secondKey)) {
			$firstKey = explode('[', $key)[0];
			$secondKey = $secondKey[1];
			foreach($this->input as $type => $values) {
				// Champ obligatoire
				if($required) {
					$this->addRequiredInputNotices($key);
				}
				// Check de l'existence
				// Également utile pour les checkbox qui ne retournent rien lorsqu'elles ne sont pas cochées
				if(
					array_key_exists($firstKey, $values)
					AND array_key_exists($secondKey, $values[$firstKey])
				) {
					// Retourne la valeur filtrée
					if($filter) {
						return helper::filter($this->input[$type][$firstKey][$secondKey], $filter);
					}
					// Retourne la valeur
					else {
						return $this->input[$type][$firstKey][$secondKey];
					}
				}
			}
		}
		// La clef est une chaîne
		else {
			foreach($this->input as $type => $values) {
				// Champ obligatoire
				if($required) {
					$this->addRequiredInputNotices($key);
				}
				// Check de l'existence
				// Également utile pour les checkbox qui ne retournent rien lorsqu'elles ne sont pas cochées
				if(array_key_exists($key, $values)) {
					// Retourne la valeur filtrée
					if($filter) {
						return helper::filter($this->input[$type][$key], $filter);
					}
					// Retourne la valeur
					else {
						return $this->input[$type][$key];
					}
				}
			}
		}
		// Sinon retourne null
		return helper::filter(null, $filter);
	}

	/**
	 * Accède à une partie l'url ou à l'url complète
	 * @param int $key Clé de l'url
	 * @return string|null
	 */
	public function getUrl($key = null) {
		// Url complète
		if($key === null) {
			return $this->url;
		}
		// Une partie de l'url
		else {
			$url = explode('/', $this->url);
			return array_key_exists($key, $url) ? $url[$key] : null;
		}
	}

	/**
	 * Accède à l'utilisateur connecté
	 * @param int $key Clé de la valeur
	 * @return string|null
	 */
	public function getUser($key) {
		if(is_array($this->user) === false) {
			return false;
		}
		elseif($key === 'id') {
			return $this->getInput('DELTA_USER_ID');
		}
		elseif(array_key_exists($key, $this->user)) {
			return $this->user[$key];
		}
		else {
			return false;
		}
	}

	/**
	 * Check qu'une valeur est transmise par la méthode _POST
	 * @return bool
	 */
	public function isPost() {
		return ($this->checkCSRF() AND $this->input['_POST'] !== []);
	}


	/**
	 * Génère un fichier json avec la liste des pages
	 *
	*/
    public function pages2Json() {
    // Sauve la liste des pages pour TinyMCE
		$parents = [];
        $rewrite = (helper::checkRewrite()) ? '' : '?';
        // Boucle de recherche des pages actives
		foreach($this->getHierarchy(null,false,false) as $parentId => $childIds) {
			$children = [];
			// Exclure les barres
			if ($this->getData(['page', $parentId, 'block']) !== 'bar' ) {
				// Boucler sur les enfants et récupérer le tableau children avec la liste des enfants
				foreach($childIds as $childId) {
					$children [] = [ 'title' => ' » '. html_entity_decode($this->getData(['page', $childId, 'shortTitle']), ENT_QUOTES) ,
								'value'=> $rewrite.$childId
					];
				}
				// Traitement
				if (empty($childIds)) {
					// Pas d'enfant, uniquement l'entrée du parent
					$parents [] = ['title' =>   html_entity_decode($this->getData(['page', $parentId, 'shortTitle']), ENT_QUOTES) ,
									'value'=> $rewrite.$parentId
					];
				} else {
					// Des enfants, on ajoute la page parent en premier
					array_unshift ($children ,  ['title' => html_entity_decode($this->getData(['page', $parentId, 'shortTitle']), ENT_QUOTES) ,
									'value'=> $rewrite.$parentId
					]);
					// puis on ajoute les enfants au parent
					$parents [] = ['title' => html_entity_decode($this->getData(['page', $parentId, 'shortTitle']), ENT_QUOTES) ,
									'value'=> $rewrite.$parentId ,
									'menu' => $children
					];
				}
			}
		}
        // Sitemap et Search
        $children = [];
        $children [] = ['title'=>'Rechercher dans le site',
           'value'=>$rewrite.'search'
          ];
        $children [] = ['title'=>'Plan du site',
           'value'=>$rewrite.'sitemap'
          ];
        $parents [] = ['title' => 'Pages spéciales',
                      'value' => '#',
                      'menu' => $children
                      ];

		// Enregistrement : 3 tentatives
		for($i = 0; $i < 3; $i++) {
			if (file_put_contents ('core/vendor/tinymce/link_list.json', json_encode($parents), LOCK_EX) !== false) {
				break;
			}
			// Pause de 10 millisecondes
			usleep(10000);
		}
	}

	/**
	 * Retourne un chemin localisé pour l'enregistrement des données
	 * @param $stageId nom du module
	 * @param $lang langue des pages
	 * @return string du dossier à créer
	 */
	public function dataPath($id, $lang) {
		// Sauf pour les pages et les modules
		if ($id === 'page' ||
			$id === 'module'  ||
			$id === 'locale' ||
			$id === 'comment') {
				$folder = self::DATA_DIR . $lang . '/' ;
		} else {
			$folder = self::DATA_DIR;
		}
		return ($folder);
	}


	/**
	 * Génère un fichier sitemap.xml
	 * https://github.com/icamys/php-sitemap-generator
	 * $command valeurs possible
	 * all : génère un site map complet
	 * Sinon contient id de la page à créer
	*/

	public function createSitemap($command = "all") {

		//require_once "core/vendor/sitemap/SitemapGenerator.php";

		$timezone = $this->getData(['config','timezone']);
		$outputDir = getcwd();
		$sitemap = new \Icamys\SitemapGenerator\SitemapGenerator(helper::baseurl(false),$outputDir);

		// will create also compressed (gzipped) sitemap : option buguée
		// $sitemap->enableCompression();

		// determine how many urls should be put into one file
		// according to standard protocol 50000 is maximum value (see http://www.sitemaps.org/protocol.html)
		$sitemap->setMaxUrlsPerSitemap(50000);

		// sitemap file name
		$sitemap->setSitemapFileName( 'sitemap.xml') ;


		// Set the sitemap index file name
		$sitemap->setSitemapIndexFileName( 'sitemap-index.xml');

		$datetime = new DateTime(date('c'));
		$datetime->format(DateTime::ATOM); // Updated ISO8601

		if ($this->getData(['config','seo', 'robots']) === true) {
			foreach($this->getHierarchy(null, null, null) as $parentPageId => $childrenPageIds) {
				// Exclure les barres,les pages non publiques et les pages orphelines
				if ($this->getData(['page',$parentPageId,'group']) !== 0  ||
					$this->getData(['page', $parentPageId, 'block']) === 'bar' ||
					$this->getData(['page', $parentPageId, 'position']) === 0 )  {
					continue;
				}
				// Page désactivée, traiter les sous-pages sans prendre en compte la page parente.
				if ($this->getData(['page', $parentPageId, 'disable']) !== true ) {
					// Cas de la page d'accueil ne pas dupliquer l'URL
					$pageId = ($parentPageId !== $this->getData(['locale', 'homePageId'])) ? $parentPageId : '';
					$sitemap->addUrl ('/' . $pageId, $datetime);
				}
				// Articles du blog
				if ($this->getData(['page', $parentPageId, 'moduleId']) === 'blog' &&
					!empty($this->getData(['module',$parentPageId])) ) {
					foreach($this->getData(['module',$parentPageId,'posts']) as $articleId => $article) {
						if($this->getData(['module',$parentPageId,'posts',$articleId,'state']) === true) {
							$date = $this->getData(['module',$parentPageId,'posts',$articleId,'publishedOn']);
							$sitemap->addUrl('/' .  $parentPageId . '/' . $articleId , new DateTime("@{$date}",new DateTimeZone($timezone)));
						}
					}
				}
				// Sous-pages
				foreach($childrenPageIds as $childKey) {
					if ($this->getData(['page',$childKey,'group']) !== 0 || $this->getData(['page', $childKey, 'disable']) === true)  {
						continue;
					}
					// Cas de la page d'accueil ne pas dupliquer l'URL
					$pageId = ($childKey !== $this->getData(['locale', 'homePageId'])) ? $childKey : '';
					$sitemap->addUrl('/' . $childKey,$datetime);

					// La sous-page est un blog
					if ($this->getData(['page', $childKey, 'moduleId']) === 'blog' &&
					   !empty($this->getData(['module',$childKey])) ) {
						foreach($this->getData(['module',$childKey,'posts']) as $articleId => $article) {
							if($this->getData(['module',$childKey,'posts',$articleId,'state']) === true) {
								$date = $this->getData(['module',$childKey,'posts',$articleId,'publishedOn']);
								$sitemap->addUrl( '/' . $childKey . '/' . $articleId , new DateTime("@{$date}",new DateTimeZone($timezone)));
							}
						}
					}
				}

			}
		}
		else{
			$sitemap->addUrl ('/', $datetime);
		}

		// Flush all stored urls from memory to the disk and close all necessary tags.
		$sitemap->flush();

		// Move flushed files to their final location. Compress if the option is enabled.
		$sitemap->finalize();

		// Update robots.txt file in output directory

		if ($this->getData(['config','seo', 'robots']) === true) {
			if(file_exists('robots.txt')) unlink('robots.txt');
			$sitemap->updateRobots();
		} else {
			file_put_contents('robots.txt','User-agent: *' .  PHP_EOL . 'Disallow: /');
		}

		// Submit your sitemaps
		if (empty ($this->getData(['config','proxyType']) . $this->getData(['config','proxyUrl']) . ':' . $this->getData(['config','proxyPort'])) ) {
			$sitemap->submitSitemap();
		}

		return(file_exists('sitemap.xml') && file_exists('robots.txt'));

	}

	/*
	* Création d'une miniature
	* Fonction utilisée lors de la mise à jour d'une version 9 à une version 10
	* @param string $src image source
	* @param string $dest image destination
	* @param integer $desired_width largeur demandée
	*/
	function makeThumb($src, $dest, $desired_width) {
		// Vérifier l'existence du dossier de destination.
		$fileInfo = pathinfo($dest);
		if (!is_dir($fileInfo['dirname'])) {
			mkdir($fileInfo['dirname'], 0755, true);
		}
		$source_image = '';
		// Type d'image
		switch(	$fileInfo['extension']) {
			case 'jpeg':
			case 'jpg':
				$source_image = imagecreatefromjpeg($src);
				break;
			case 'png':
				$source_image = imagecreatefrompng($src);
				break;
			case 'gif':
				$source_image = imagecreatefromgif($src);
				break;
			case 'webp':
				$source_image = imagecreatefromwebp($src);
				break;
		}
		// Image valide
		if ($source_image) {
			$width = imagesx($source_image);
			$height = imagesy($source_image);
			/* find the "desired height" of this thumbnail, relative to the desired width  */
			$desired_height = floor($height * ($desired_width / $width));
			/* create a new, "virtual" image */
			$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
			/* copy source image at a resized size */
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
			switch(mime_content_type($src) ) {
				case 'image/jpeg':
					return (imagejpeg($virtual_image, $dest));
					break;
				case 'image/png':
					return (imagepng($virtual_image, $dest));
					break;
				case 'image/gif':
					return (imagegif($virtual_image, $dest));
					break;
				case 'image/webp':
					return (imagewebp($virtual_image, $dest));
					break;
			}
		} else {
			return (false);
		}
	}


	/**
	 * Envoi un mail
	 * @param string|array $to Destinataire
	 * @param string $subject Sujet
	 * @param string $content Contenu
	 * @return bool
	 */
	public function sendMail($to, $subject, $content, $replyTo = null, $file_name = '') {
		// Layout
		ob_start();
		include 'core/layout/mail.php';
		$layout = ob_get_clean();
		$mail = new PHPMailer\PHPMailer\PHPMailer;
		$mail->CharSet = 'UTF-8';
		// Langage par défaut : en
		if( $this->getData(['config', 'i18n', 'langAdmin']) === 'fr')$mail->setLanguage('fr', 'core/class/phpmailer/phpmailer.lang-fr.php');
		// Mail
		try{
			// Paramètres SMTP
			if ($this->getdata(['config','smtp','enable'])) {
				//$mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
				$mail->isSMTP();
				$mail->SMTPAutoTLS = false;
				$mail->Host = $this->getdata(['config','smtp','host']);
				$mail->Port = (int) $this->getdata(['config','smtp','port']);
				if ($this->getData(['config','smtp','auth'])) {
					$mail->Username = $this->getData(['config','smtp','username']);
					$mail->Password = helper::decrypt($this->getData(['config','smtp','username']),$this->getData(['config','smtp','password']));
					$mail->SMTPAuth = $this->getData(['config','smtp','auth']);
					$mail->SMTPSecure = $this->getData(['config','smtp','secure']);
					$mail->setFrom($this->getData(['config','smtp','username']));
					if (is_null($replyTo)) {
						$mail->addReplyTo($this->getData(['config','smtp','username']));
					} else {
						$mail->addReplyTo($replyTo);
					}
				}
			// Fin SMTP
			} else {
				$host = str_replace('www.', '', $_SERVER['HTTP_HOST']);
				$mail->setFrom('no-reply@' . $host, $this->getData(['locale', 'title']));
				if (is_null($replyTo)) {
					$mail->addReplyTo('no-reply@' . $host, $this->getData(['locale', 'title']));
				} else {
					$mail->addReplyTo($replyTo);
				}
			}
			if(is_array($to)) {
					foreach($to as $userMail) {
							$mail->addAddress($userMail);
					}
			}
			else {
					$mail->addAddress($to);
			}
			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body = $layout;
			$mail->AltBody = strip_tags($content);
			if($file_name !== '') $mail->addAttachment( self::FILE_DIR.'uploads/'.$file_name);

			if($mail->send()) {
					return true;
			}
			else {
					return $mail->ErrorInfo;
			}
		} catch (Exception $e) {
			echo $e->errorMessage();
		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}



	/**
	* Effacer un dossier non vide.
	* @param string URL du dossier à supprimer
	*/
	public function removeDir ( $path ) {
		foreach ( new DirectoryIterator($path) as $item ) {
			if ( $item->isFile() ) @unlink($item->getRealPath());
			if ( !$item->isDot() && $item->isDir() ) $this->removeDir($item->getRealPath());
		}
		return ( rmdir($path) );
	}


	/*
	* Copie récursive de dossiers
	* @param string $src dossier source
	* @param string $dst dossier destination
	* @return bool
	*/
	public function copyDir($src, $dst) {
		// Ouvrir le dossier source
		$dir = opendir($src);
		// Créer le dossier de destination
		if (!is_dir($dst))
			$success = mkdir($dst, 0755, true);
		else
			$success = true;

		// Boucler dans le dossier source en l'absence d'échec de lecture écriture
		while( $success
			   AND $file = readdir($dir) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				if ( is_dir($src . '/' . $file) ){
					// Appel récursif des sous-dossiers
					$success = $this->copyDir($src . '/' . $file, $dst . '/' . $file);
				}
				else {
					$success = copy($src . '/' . $file, $dst . '/' . $file);
				}
			}
		}
		closedir($dir);
		return $success;
	}


	/**
	 * Génère une archive d'un dossier et des sous-dossiers
	 * @param string fileName path et nom de l'archive
	 * @param string folder path à zipper
	 * @param array filter dossiers à exclure
	 */
	public function makeZip ($fileName, $folder, $filter ) {
		$zip = new ZipArchive();
		$zip->open($fileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
		//$directory = 'site/';
		$files =  new RecursiveIteratorIterator(
			new RecursiveCallbackFilterIterator(
			new RecursiveDirectoryIterator(
				$folder,
				RecursiveDirectoryIterator::SKIP_DOTS
			),
			function ($fileInfo, $key, $iterator) use ($filter) {
				return $fileInfo->isFile() || !in_array($fileInfo->getBaseName(), $filter);
			}
			)
		);
		foreach ($files as $name => $file) 	{
			if (!$file->isDir()) 	{
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen(realpath($folder)) + 1);
				$zip->addFile($filePath, $relativePath);
			}
		}
		$zip->close();
	}


	/**
	 * Affiche le consentement aux cookies
	 */
	public function showCookies() {

		// Gestion des cookies intégrée
		if ($this->getData(['config', 'cookieConsent']) === true )
			{
			// Détermine si le bloc doit être affiché selon la validité du cookie
			// L'URL du serveur faut TRUE
			$item  = '<div id="cookieConsent"';
			$item .= $this->getInput('DELTA_COOKIE_CONSENT') !==  'true' ? '>' : ' class="displayNone">';
			// Image titre et bouton de fermeture
			$item .= '<div class="cookieTop">';
			$item .= '<div class="cookieImage"><img src="site/file/source/icones/cookie.gif" alt="cookie"></div>';
			$item .= '<div class="cookieTitle">'.$this->getData(['locale', 'cookies', 'cookiesTitleText']) . '</div>';
			$item .= '<div class="cookieClose">'. template::ico('cancel') .'</div>';
			$item .= '</div>';
			// Texte de la popup
			$item .= '<p>' . $this->getData(['locale', 'cookies', 'cookiesDeltaText']) . '</p>';
			// Formulaire de réponse
			$item .= '<form method="POST" id="cookieForm">';
			$cookieExt = $this->getData(['locale', 'cookies', 'cookiesExtText']);
			$stateCookieExt = $this->getInput('DELTA_COOKIE_EXT_CONSENT') ===  'true' ? 'checked="checked"' : '';
			if( $cookieExt !== null AND $cookieExt !== '' ) {
				$item .= '<p>' . $this->getData(['locale', 'cookies', 'cookiesExtText']) . '</p>';
				$item .= '<input type="checkbox" id="cookiesExt" name="cookiesExt" value="CE" ' . $stateCookieExt . '>';
				$item .= '<label for="cookiesExt">' . $this->getData(['locale', 'cookies', 'cookiesCheckboxExtText']) . '</label>';
			}
			$item .= '<br>';
			$item .= '<input type="submit" id="cookieConsentConfirm" value="' . $this->getData(['locale', 'cookies', 'cookiesButtonText']) . '">';
			$item .= '</form>';
			// mentions légales si la page est définie
			$legalPage = $this->getData(['locale', 'legalPageId']);
			if ($legalPage !== 'none')  {
				$item .= '<p><a href="' . helper::baseUrl() . $legalPage . '">' . $this->getData(['locale', 'cookies', 'cookiesLinkMlText']) . '</a></p>';
			}
			$item .= '</div>';
			echo $item;
		}

	}

	/**
	 * Formate le contenu de la page selon les gabarits
	 * @param Page par defaut
	 */
	public function showSection() {
		echo '<section>';
		// Récupérer la config de la page courante
		$blocks = [];
		if( null !== $this->getData(['page',$this->getUrl(0),'block'])) $blocks = explode('-',$this->getData(['page',$this->getUrl(0),'block']));
		// Initialiser
		$content = "";
		$blockleft=$blockright="";
		switch (sizeof($blocks)) {
			case 1 :  // une colonne
				$content    = 'col'. $blocks[0] ;
				break;
			case 2 :  // 2 blocs
				if ($blocks[0] < $blocks[1]) { // détermine la position de la colonne
					$blockleft = 'col'. $blocks[0];
					$content    = 'col'. $blocks[1] ;
				} else {
					$content    = 'col' . $blocks[0];
					$blockright  = 'col' . $blocks[1];
				}
			break;
			case 3 :  // 3 blocs
					$blockleft  = 'col' . $blocks[0];
					$content    = 'col' . $blocks[1];
					$blockright = 'col' . $blocks[2];
		}
		// Page pleine pour la configuration des modules et l'édition des pages sauf l'affichage d'un article de blog
		$pattern = ['config','edit','add','comment','data'];
		if ((sizeof($blocks) === 1 || in_array($this->getUrl(1),$pattern)  ) ) { 
				// Pleine page en mode configuration
				$this->showContent();
				$strlenUrl1 = 0;
				if( $this->getUrl(1) !== null) $strlenUrl1 = strlen($this->getUrl(1));
				if( $this->getData(['page', $this->getUrl(0), 'commentEnable']) === true &&  $strlenUrl1 < 3  ) $this->showComment();
				if (file_exists(self::DATA_DIR . 'body.inc.php')) {
					include( self::DATA_DIR . 'body.inc.php');
				}
				if($this->getData(['config', 'statislite', 'enable'])){
					if(is_dir("./module/statislite")) include "./module/statislite/include/stat.php";
				}
		} else {
			echo '<div class="row siteContainer">';
				/**
				 * Barre gauche
				 */
				if ($blockleft !== "")  {
					echo '<div class="'. $blockleft . '" id="contentLeft"><aside>' ;
					// Détermine si le menu est présent
					if ($this->getData(['page',$this->getData(['page',$this->getUrl(0),'barLeft']),'displayMenu']) === 'none') {
						// Pas de menu
						echo $this->output['contentLeft'];
					} else {
						// $mark contient 0 le menu est positionné à la fin du contenu
						$contentLeft = str_replace ('[]','[MENU]',$this->output['contentLeft']);
						$contentLeft = str_replace ('[menu]','[MENU]',$contentLeft);
						$mark = strrpos($contentLeft,'[MENU]')  !== false ? strrpos($contentLeft,'[MENU]') : strlen($contentLeft);
						echo substr($contentLeft,0,$mark);
						echo '<div id="menuSideLeft">';
						echo $this->showMenuSide($this->getData(['page',$this->getData(['page',$this->getUrl(0),'barLeft']),'displayMenu']) === 'parents' ? false : true);
						echo '</div>';
						echo substr($contentLeft,$mark+6,strlen($contentLeft));
					}
					echo  "</aside></div>";
				}
				/**
				 * Contenu de page
				 */
				echo '<div class="'. $content . '" id="contentSite">';
				$this->showContent();
				$strlenUrl1 = 0;
				if( $this->getUrl(1) !== null) $strlenUrl1 = strlen($this->getUrl(1));
				if( $this->getData(['page', $this->getUrl(0), 'commentEnable']) === true &&  $strlenUrl1 < 3  ) $this->showComment();
				if (file_exists(self::DATA_DIR . 'body.inc.php')) {
						include(self::DATA_DIR . 'body.inc.php');
				}
				if($this->getData(['config', 'statislite', 'enable'])){
					if(is_dir("./module/statislite")) include "./module/statislite/include/stat.php";
				}
				echo '</div>';
				/**
				 * Barre droite
				 */
				if ($blockright !== "") {
					echo '<div class="' . $blockright . '" id="contentRight"><aside>';
					// Détermine si le menu est présent
					if ($this->getData(['page',$this->getData(['page',$this->getUrl(0),'barRight']),'displayMenu']) === 'none') {
						// Pas de menu
						echo $this->output['contentRight'];
					} else {
						// $mark contient 0 le menu est positionné à la fin du contenu
						$contentRight = str_replace ('[]','[MENU]',$this->output['contentRight']);
						$contentRight = str_replace ('[menu]','[MENU]',$contentRight);
						$mark = strrpos($contentRight,'[MENU]')  !== false ? strrpos($contentRight,'[MENU]') : strlen($contentRight);
						echo substr($contentRight,0,$mark);
						echo '<div id="menuSideRight">';
						echo $this->showMenuSide($this->getData(['page',$this->getData(['page',$this->getUrl(0),'barRight']),'displayMenu']) === 'parents' ? false : true);
						echo '</div>';
						echo substr($contentRight,$mark+6,strlen($contentRight));
					}
					echo '</aside></div>';
				}
			echo '</div>';
		}
		echo '</section>';
	}

	/**
	 * Affiche le contenu
	 * @param Page par défaut
	 */
	public function showContent() {
		if(
			$this->output['title']
			AND (
				$this->getData(['page', $this->getUrl(0)]) === null
				OR $this->getData(['page', $this->getUrl(0), 'hideTitle']) === false
				OR $this->getUrl(1) === 'config'
			)
		) {
			echo '<h1 id="sectionTitle">' . $this->output['title'] . '</h1>';
		}

		echo $this->output['content'];
	}
	
	/**
	 * Affiche les commentaires de page quand ils sont autorisés
	 * 
	 */
	public function showComment() {	
		// Si la page est accessible
		if(	$this->getData(['page', $this->getUrl(0), 'group']) === self::GROUP_VISITOR
			OR (
				$this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')
				AND $this->getUser('group') >= $this->getData(['page', $this->getUrl(0), 'group'])
			)
		) {
			include('./core/include/comment.inc.php');
		}	
	}	

	/**
	 * Affiche le pied de page
	 */
	public function showFooter () {
		// Déterminer la position
		$positionFixed = '';
		if (
			$this->getData(['theme', 'footer', 'position']) === 'site'
			// Affiche toujours le pied de page pour l'édition du thème
			OR (
				$this->getData(['theme', 'footer', 'position']) === 'hide'
				AND $this->getUrl(0) === 'theme'
			)
			) {
				$position = 'site';
			} else {
					$position = 'body';
					if ( $this->getData(['theme', 'footer', 'fixed']) === true) {
						$positionFixed = ' footerbodyFixed';
					}
					// Sortir de la division précédente
					echo '</div>';
		}

		echo $this->getData(['theme', 'footer', 'position']) === 'hide' ? '<footer class="displayNone">' : '<footer>';
		echo ($position === 'site') ? '<div class="container"><div class="row" id="footersite">' : '<div class="container-large'.  $positionFixed . '"><div class="row" id="footerbody">';
		/**
		 * Calcule la dimension des blocs selon la configuration
		 */
		switch($this->getData(['theme', 'footer', 'template'])) {
			case '1' :
				$class['left'] 	 = "displayNone";
				$class['center'] = "col12";
				$class['right']  = "displayNone";
				break;
			case '2' :
				$class['left'] 	 = "col6";
				$class['center'] = "displayNone";
				$class['right']  = "col6";
				break;
			case '3' :
				$class['left'] 	 = "col4";
				$class['center'] = "col4";
				$class['right']  = "col4";
				break;
			case '4' :
				$class['left'] 	 = "col12";
				$class['center'] = "col12";
				$class['right']  = "col12";
				break;
		}
		/**
		 * Affiche les blocs
		 */
		echo '<div class="' . $class['left'] . '" id="footer' .  $position . 'Left">';
		if($this->getData(['theme', 'footer', 'textPosition']) === 'left') { $this->showFooterText(true); }
		if($this->getData(['theme', 'footer', 'socialsPosition']) === 'left') {	$this->showSocials(true); }
		if($this->getData(['theme', 'footer', 'copyrightPosition']) === 'left') {$this->showCopyright(true); }
		echo '</div>';
		echo '<div class="' .$class['center'] . '" id="footer' . $position . 'Center">';
		if($this->getData(['theme', 'footer', 'textPosition']) === 'mcenter') { $this->showFooterText(true); }
		if($this->getData(['theme', 'footer', 'socialsPosition']) === 'mcenter') { $this->showSocials(true); }
		if($this->getData(['theme', 'footer', 'copyrightPosition']) === 'mcenter') { $this->showCopyright(true); }
		echo '</div>';
		echo '<div class="' . $class['right'] . '" id="footer' . $position .'Right">';
		if($this->getData(['theme', 'footer', 'textPosition']) === 'right') { $this->showFooterText(true); }
		if($this->getData(['theme', 'footer', 'socialsPosition']) === 'right') { $this->showSocials(true); }
		if($this->getData(['theme', 'footer', 'copyrightPosition']) === 'right') { $this->showCopyright(true); }
		echo '</div>';


		if($this->getData(['theme', 'footer', 'textPosition']) === 'hide') { $this->showFooterText(false); }
		if($this->getData(['theme', 'footer', 'socialsPosition']) === 'hide') { $this->showSocials(false); }
		if($this->getData(['theme', 'footer', 'copyrightPosition']) === 'hide') { $this->showCopyright(false); }

		// Fermeture du contenaire
		echo '</div></div>';
		echo '</footer>';
	}

	/**
	 * Affiche le texte du footer
	 */
	private function showFooterText($visibility) {
		if($footerText = $this->getData(['theme', 'footer', 'text']) OR $this->getUrl(0) === 'theme') {
			$style = '';
			if( $visibility === false ) $style = 'style="display: none;"';
			echo '<div id="footerText" ' . $style . '>' . $footerText . '</div>';
		}
	}

     /**
     * Affiche le copyright
     */
    private function showCopyright($visibility) {
		$style = '';
		if( $visibility === false ) $style = 'style="display: none;"';
		// Ouverture Bloc copyright
		$items = '<div id="footerCopyright" '.$style.'>';
		$items .= '<span id="footerFontCopyright">';
		// Affichage de motorisé par
		$items .= '<span id="footerDisplayCopyright" ';
		$items .= $this->getData(['theme','footer','displayCopyright']) === false ? 'class="displayNone"' : '';
		$items .= '>Motorisé&nbsp;par&nbsp;</span>';
		// Toujours afficher le nom du CMS
		$items .= '<span id="footerDeltaCMS">';
		$items .= '<a href="https://deltacms.fr/" onclick="window.open(this.href);return false" >DeltaCMS</a>';
		$items .= '</span>';
		// Affichage du numéro de version
		$items .= '<span id="footerDisplayVersion"';
		$items .= $this->getData(['theme','footer','displayVersion']) === false ? ' class="displayNone"' : '';
		$items .= '><wbr>&nbsp;'. common::DELTA_VERSION ;
		$items .= '</span>';
		// Affichage du sitemap
		$items .= '<span id="footerDisplaySiteMap"';
		$items .= $this->getData(['theme','footer','displaySiteMap']) ===  false ? ' class="displayNone"' : '';
		$label = empty($this->getData(['locale','sitemapPageLabel'])) ? 'Plan du site' : $this->getData(['locale','sitemapPageLabel']);
		$items .=  '><wbr>&nbsp;|&nbsp;<a href="' . helper::baseUrl() .  'sitemap"  >' . $label . '</a>';
		$items .= '</span>';
        // Affichage du module de recherche
 		$items .= '<span id="footerDisplaySearch"';
		$items .= $this->getData(['theme','footer','displaySearch']) ===  false ? ' class="displayNone" >' : '>';
		$label = empty($this->getData(['locale','searchPageLabel'])) ? 'Rechercher' : $this->getData(['locale','searchPageLabel']);
		if ($this->getData(['locale','searchPageId']) !== 'none') {
			$items .=  '<wbr>&nbsp;|&nbsp;<a href="' . helper::baseUrl() . $this->getData(['locale','searchPageId']) . '"  >' . $label .'</a>';
		}
		$items .= '</span>';
		// Affichage des mentions légales
		$items .= '<span id="footerDisplayLegal"';
		$items .= $this->getData(['theme','footer','displayLegal']) ===  false ? ' class="displayNone" >' : '>';
		$label = empty($this->getData(['locale','legalPageLabel'])) ? 'Mentions Légales' : $this->getData(['locale','legalPageLabel']);
		if ($this->getData(['locale','legalPageId']) !== 'none') {
			$items .=  '<wbr>&nbsp;|&nbsp;<a href="' . helper::baseUrl() . $this->getData(['locale','legalPageId']) . '"  >' . $label .'</a>';
		}
		$items .= '</span>';
		// Affichage de la gestion des cookies
		$items .= '<span id="footerDisplayCookie"';
		$items .= ($this->getData(['config', 'cookieConsent']) === true && $this->getData(['theme', 'footer', 'displayCookie']) === true) ? '>' : ' class="displayNone" >';
		$label  = empty($this->getData(['locale', 'cookies', 'cookiesFooterText'])) ? 'Cookies' : $this->getData(['locale', 'cookies', 'cookiesFooterText']) ;
		$items .= '<wbr>&nbsp;|&nbsp;<a href="javascript:void(0)" class="skiptranslate" id="footerLinkCookie">'. $label .'</a>';
		$items .= '</span>';
		// Enregistrement et affichage des personnes en ligne
		if( $this->getData(['theme', 'footer', 'displayWhois']) === true ){
			if( ! file_exists(self::DATA_DIR . 'session.json'))	file_put_contents(self::DATA_DIR . 'session.json', '{}');
			$user_type = $this->getUser('id') ? $this->getData(['user', $this->getUser('id'), 'group']) : 0 ;
			$this->setData(['session', session_id(), 'user_type', $user_type ]);
			$this->setData(['session', session_id(), 'time', time() ]);
			// Tableau $groupWhoIs
			$groupWhoIs = [ 0 => $this->getData(['locale', 'visitorLabel']), 1 => $this->getData(['locale', 'memberLabel']),
			2 => $this->getData(['locale', 'editorLabel']), 3 => $this->getData(['locale', 'moderatorLabel']), 4 => $this->getData(['locale', 'administratorLabel'])];
			$file = file_get_contents('site/data/session.json');
			$session_tab = json_decode( $file, true);
			$whoIs = [0 => 0,1 => 0,2 => 0, 3 => 0,4=> 0];
			foreach( $session_tab as $key1=>$session_id){
				foreach($session_id as $key2=>$value){
					// Temps d'inactivité réglé à 60 secondes
					if( time() >  $value["time"] + 60){
						$session_tab[$key1]=[];
					} else {
						$whoIs[$value['user_type']]++;
					}
				}
			}
			$file = json_encode( $session_tab);
			file_put_contents('site/data/session.json', $file);
			//	Affichage
			$textWhoIs ='';
			foreach( $whoIs as $key=>$value ){
				if( $value !== 0){
					$textWhoIs .= ' '.$groupWhoIs[$key].'=>'.$value.' ';
				}
			}
			$items .= ' | '.$textWhoIs;
		}
		// Affichage du lien de connexion
		if(
            (
                $this->getData(['theme', 'footer', 'loginLink'])
                AND $this->getUser('password') !== $this->getInput('DELTA_USER_PASSWORD')
            )
            OR $this->getUrl(0) === 'theme'
        ) {
			$items .= '<span id="footerLoginLink" ' .
			($this->getUrl(0) === 'theme' ? 'class="displayNone"' : '') .
			'><wbr>&nbsp;|&nbsp;<a href="' . helper::baseUrl() . 'user/login/' .
			strip_tags(str_replace('/', '_', $this->getUrl())) .
			'" rel="nofollow">' . template::ico('login') .'</a></span>';
		}
		// Affichage de la barre de membre simple
		if ( $this->getUser('group') === self::GROUP_MEMBER
			 && $this->getData(['theme','footer','displayMemberBar']) === true
			) {
				$items .= '<span id="footerDisplayMemberAccount"';
				$items .= $this->getData(['theme','footer','displaymemberAccount']) ===  false ? ' class="displayNone"' : '';
				$items .=  '><wbr>&nbsp;|&nbsp;<a href="' . helper::baseUrl() . 'user/edit/' . $this->getUser('id'). '/' . $_SESSION['csrf'] .  '"  >' . template::ico('user', 'all') . '</a>';
				if( $this->getData(['user', $this->getUser('id') , 'files']) === true) $items .= '<wbr><a href="' . helper::baseUrl(false) . 'core/vendor/filemanager/dialog.php?type=0&akey=' . md5_file(self::DATA_DIR.'core.json') .'"  data-lity>' . template::ico('folder') . '</a>';
				$items .= '<wbr><a id="barLogout" href="' . helper::baseUrl() . 'user/logout" >' . template::ico('logout','left') . '</a>';
				$items .= '</span>';
		}
		// Fermeture du bloc copyright
        $items .= '</span></div>';
        echo $items;
	}


	/**
	 * Affiche les réseaux sociaux
	 */
	private function showSocials($visibility) {
		$socials = '';
		foreach($this->getData(['config', 'social']) as $socialName => $socialId) {
			switch($socialName) {
				case 'facebookId':
					$socialUrl = 'https://www.facebook.com/';
					$title = 'Facebook';
					break;
				case 'linkedinId':
					$socialUrl = 'https://fr.linkedin.com/in/';
					$title = 'Linkedin';
					break;
				case 'instagramId':
					$socialUrl = 'https://www.instagram.com/';
					$title = 'Instagram';
					break;
				case 'pinterestId':
					$socialUrl = 'https://pinterest.com/';
					$title = 'Pinterest';
					break;
				case 'twitterId':
					$socialUrl = 'https://twitter.com/';
					$title = 'Twitter';
					break;
				case 'youtubeId':
					$socialUrl = 'https://www.youtube.com/channel/';
					$title = 'Chaîne YouTube';
					break;
				case 'youtubeUserId':
					$socialUrl = 'https://www.youtube.com/user/';
					$title = 'YouTube';
					break;
				case 'githubId':
					$socialUrl = 'https://www.github.com/';
					$title = 'Github';
					break;
				default:
					$socialUrl = '';
			}
			if($socialId !== '' && is_string($socialName)  && is_string($socialUrl)  && is_string($socialId) ) {
				$socials .= '<a href="' . $socialUrl . $socialId . '" onclick="window.open(this.href);return false" data-tippy-content="' . $title . '">' . template::ico(substr(str_replace('User','',$socialName), 0, -2)) . '</a>';
			}
		}
		if($socials !== '') {
			$style = '';
			if( $visibility === false ) $style = 'style="display: none;"';
			echo '<div id="footerSocials" ' . $style . '>' . $socials . '</div>';
		}
	}

	/**
	 * Affiche le favicon
	 */
	public function showFavicon() {
		// Light scheme
		$favicon = $this->getData(['config', 'favicon']);
		if($favicon &&
			file_exists(self::FILE_DIR.'source/' . $favicon)
			) {
			echo '<link rel="icon" media="(prefers-color-scheme:light)" href="' . self::FILE_DIR.'source/' . $favicon . '">';
		} else {
			echo '<link rel="icon" media="(prefers-color-scheme:light)"  href="core/vendor/delta-ico/ico/favicon.ico">';
		}
		// Dark scheme
		$faviconDark = $this->getData(['config', 'faviconDark']);
		if(!empty($faviconDark) &&
		file_exists(self::FILE_DIR.'source/' . $faviconDark)
		) {
			echo '<link rel="icon" media="(prefers-color-scheme:dark)" href="' . self::FILE_DIR.'source/' . $faviconDark . '">';
			echo '<script src="core/vendor/favicon-switcher/favicon-switcher.js" crossorigin="anonymous"></script>';
		}
	}

	/**
	 * Affiche le menu
	 */
	public function showMenu( $position ='') {
		// Lexique
		include('./core/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_core.php');
		$menuClass = ''; $burgerclass =''; $burgerclassshort ='';
		// Groupe du client connecté (1, 2, 3, 4) ou non connecté (0)
		$groupUser = $this->getUser('group') === false ? 0 : $this->getUser('group');
		// Ajout de la class navfixedburgerconnected ou navfixedburgerlogout si le bandeau (texte ou logo + icône burger) du menu burger est fixe
		if( $this->getData(['theme', 'menu', 'burgerFixed']) === true ){
			if( $groupUser >= 2 && $this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')) {
				$burgerclass = 'class="navfixedburgerconnected"';
				$burgerclassshort = 'navfixedburgerconnected';
			} else {
				$burgerclass = 'class="navfixedburgerlogout"';
				$burgerclassshort = 'navfixedburgerlogout';
			}
		} else {
			if( $groupUser >= 2 && $this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')) {
				$burgerclass = 'class="navburgerconnected"';
				$burgerclassshort = 'navburgerconnected';
			}
		}
		switch ($position) {
			case 'top':
				// Détermine si le menu est fixe en haut de page lorsque l'utilisateur n'est pas connecté
				if ( $this->getData(['theme', 'menu', 'position']) === 'top' AND $this->getData(['theme', 'menu', 'fixed']) === true ){
					if( $groupUser >= 2 && $this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')) {
						echo '<nav id="navfixedconnected" '.$burgerclass.'>';
					} else {
						echo '<nav id="navfixedlogout" '.$burgerclass.'>';
					}
				} else {
					echo '<nav '.$burgerclass.'>';
				}
				$menuClass = $this->getData(['theme', 'menu', 'wide']) === 'none' ? 'class="container-large"'  : 'class="container"';
			break;
			case 'body-first' :
				// Limitation de la largeur du bandeau menu pour une bannière body et container
				$navStyle = $this->getData(['theme', 'header', 'wide'])==='container'?  $navStyle = 'class="container '.$burgerclassshort.'"' : '';
				echo '<nav '.$navStyle.'>';
				$menuClass = $this->getData(['theme', 'menu', 'wide']) === 'none' ? 'class="container-large"'  : 'class="container"';
			break;
			case 'body-second' :
				$navStyle = $this->getData(['theme', 'header', 'wide'])==='container'?  $navStyle = 'class="container '.$burgerclassshort.'"' : '';
				echo '<nav '.$navStyle.'>';
				$menuClass = $this->getData(['theme', 'menu', 'wide']) === 'none' ? 'class="container-large"'  : 'class="container"';
			break;
			case 'site-first' :
				echo '<nav '.$burgerclass.'>';
			break;
			case 'site-second' :
				echo '<nav '.$burgerclass.'>';
			break;
			case 'site' :
				echo '<nav '.$burgerclass.'>';
			break;
			case 'hide' :
				?> <nav <?php if($this->getData(['theme', 'menu', 'position']) === 'hide'): ?> class="displayNone" <?php endif; ?> > <?php
			break;
		}

		// Adaptation automatique de la hauteur des icônes du menu à la hauteur du menu pour tous les écrans
		$fontsize = (int) str_replace('px', '', $this->getData(['theme', 'text', 'fontSize']));
		$height = $this->getData(['theme', 'menu', 'height']);
		$pospx = strpos($height, 'px');
		$height = (int) substr( $height, 0, $pospx);
		$coef = str_replace('em', '', $this->getData(['theme', 'menu', 'fontSize']));
		$heightLogo = (int) ($height + $fontsize*$coef - 5); // icônes des menus
		$heightLogoBurger = $heightLogo + 5; // icônes dans le bandeau du menu burger
		// Pour le décalage du header ou de la section, par core.js.php en petit écran, transmision de la hauteur du bandeau du menu = 2* taille du texte (icône burger) + 2 * padding-topbottom défini par $this->getData(['theme', 'menu', 'height']);
		$bannerHeight = 2 * $height + 2 * $fontsize;
		?><script>var bannerMenuHeight = (<?php echo $bannerHeight;?>).toString() + "px";var bannerMenuHeightSection= (<?php echo $bannerHeight + 10;?>).toString() + "px";  </script><?php

		//Menu burger
		$fileIcon1 = './site/file/source/'. $this->getData(['theme', 'menu', 'burgerIcon1']);
		$fileIcon2 = './site/file/source/'. $this->getData(['theme', 'menu', 'burgerIcon2']);
		$iconLink1 = helper::baseUrl().$this->getData(['locale', 'menuBurger','burgerLeftIconLink']);
		$iconLink2 = helper::baseUrl().$this->getData(['locale', 'menuBurger','burgerCenterIconLink']);
		echo '<div id="toggle">';
			switch( $this->getData(['theme','menu','burgerContent']) ){
				case 'none' :
					echo '<div id="burgerText"></div>';
				break;
				case 'title' :
					echo '<div class="notranslate" id="burgerText">' . $this->getData(['locale', 'title']) . '</div>';
				break;
				case 'oneIcon' :
					echo '<div id="burgerIcon1"><a href="'.$iconLink1.'"><img src="'. $fileIcon1 .'" style="height:'.$heightLogoBurger.'px; width:auto;" alt=""></a></div>';
					echo '<div id="burgerIcon2"></div>';
				break;
				case 'twoIcon' :
					echo '<div id="burgerIcon1"><a href="'.$iconLink1.'"><img src="'. $fileIcon1 .'" style="height:'.$heightLogoBurger.'px; width:auto;" alt=""></a></div>';
					echo '<div id="burgerIcon2"><a href="'.$iconLink2.'"><img src="'. $fileIcon2 .'" style="height:'.$heightLogoBurger.'px; width:auto;" alt=""></a></div>';
				break;
			}?>
			<div id="burgerIcon"><?php echo template::ico('menu',null,null,'2em'); ?></div>
		</div>

		<div id="menu" <?php echo $menuClass; ?> > <?php
		// Met en forme les items du menu
		$itemsLeft = '';
		$currentPageId = $this->getData(['page', $this->getUrl(0)]) ? $this->getUrl(0) : $this->getUrl(2);
		// Tableaux des pages parent et de toutes les pages utilisés par core.js.php pour régler la largeur minimale des onglets et la largeur des sous-menus
		?>
		<script> var parentPage=[]; var allPage=[];	<?php foreach($this->getHierarchy() as $parentPageId => $childrenPageIds) {	if( $childrenPageIds !== [] ){ ?> parentPage.push('<?php echo $parentPageId; ?>');	<?php } ?> allPage.push('<?php echo $parentPageId; ?>'); <?php } ?> </script>
		<?php
		foreach($this->getHierarchy() as $parentPageId => $childrenPageIds) {
			// Propriétés de l'item
			$active = ($parentPageId === $currentPageId OR in_array($currentPageId, $childrenPageIds)) ? 'active ' : '';
			$targetBlank = $this->getData(['page', $parentPageId, 'targetBlank']) ? ' target="_blank"' : '';
			// Cas où les pages enfants enfant sont toutes desactivées dans le menu, ne pas afficher de symbole lorsqu'il n'y a rien à afficher et que le client est < éditeur
			$totalChild = 0;
			$disableChild = 0;
			foreach($childrenPageIds as $childKey) {
				$totalChild += 1;
				if( $this->getData(['page', $childKey, 'disable']) === true ) $disableChild +=1;
			}
			$iconSubExistLargeScreen='';
			$iconSubExistSmallScreen='';
			if($childrenPageIds && ( $disableChild !== $totalChild || $groupUser >= 2 ) && $this->getdata(['page',$parentPageId,'hideMenuChildren']) === false) {
				$iconSubExistLargeScreen= '<span class="delta-ico-down iconSubExistLargeScreen" style="font-size:1em"><!----></span>';
				$iconSubExistSmallScreen= '<span class="delta-ico-plus iconSubExistSmallScreen" style="font-size:1em"><!----></span>';

			}
			// Si la page est désactivée et sans sous-page active et client < éditeur => elle n'est pas affichée
			if ( $this->getData(['page',$parentPageId,'disable']) && (empty($childrenPageIds) ||  $disableChild === $totalChild) && $groupUser < 2){
				continue;
			} else {
				// Mise en page de l'item
				$itemsLeft .= '<li>';
				$pageDesactived = false;
				if (  $this->getData(['page',$parentPageId,'disable']) === true && $groupUser < 2 ){
					$pageUrl = ($this->getData(['locale', 'homePageId']) === $this->getUrl(0)) ? helper::baseUrl(false)  :  helper::baseUrl() . $this->getUrl(0);
					$itemsLeft .= '<div id="'.$parentPageId.'" class="box" style="display:flex; justify-content:space-between;"><div><a class="A ' . $active . $parentPageId . ' disabled-link">';
					$pageDesactived = true;
				} else {
					$pageUrl = ($this->getData(['locale', 'homePageId']) === $parentPageId) ? helper::baseUrl(false)  :  helper::baseUrl() . $parentPageId;
					$itemsLeft .= '<div id="'.$parentPageId.'" class="box '.$active.'" style="display:flex; justify-content:space-between;"><div><a class="B ' . $active . $parentPageId . '" href="' . $pageUrl . '"' . $targetBlank . '>';
				}
				$fileLogo = './site/file/source/'. $this->getData(['page', $parentPageId, 'iconUrl']);
				switch ($this->getData(['page', $parentPageId, 'typeMenu'])) {
					case '' :
						$itemsLeft .= $this->getData(['page', $parentPageId, 'shortTitle']);
						break;
					case 'text' :
						$itemsLeft .= $this->getData(['page', $parentPageId, 'shortTitle']);
						break;
					case 'icon' :
						if ($this->getData(['page', $parentPageId, 'iconUrl']) != "") {
							$itemsLeft .= '<img alt="'.$this->getData(['page', $parentPageId, 'shortTitle']).'" src="'. $fileLogo.'" style="height:'.$heightLogo.'px; width:auto;">';
						} else {
						$itemsLeft .= $this->getData(['page', $parentPageId, 'shortTitle']);
						}
						break;
					case 'icontitle' :
						if ($this->getData(['page', $parentPageId, 'iconUrl']) != "") {
							$itemsLeft .= '<img alt="'.$this->getData(['page', $parentPageId, 'titlshortTitlee']).'" src="'. $fileLogo.'" style="height:'.$heightLogo.'px; width:auto;" data-tippy-content="';
							$itemsLeft .= $this->getData(['page', $parentPageId, 'shortTitle']).'">';
						} else {
							$itemsLeft .= $this->getData(['page', $parentPageId, 'shortTitle']);
						}
						break;
				}
				$itemsLeft .= $iconSubExistLargeScreen;
				$itemsLeft .= '</a>';
				$itemsLeft .= '</div>';
				$itemsLeft .= $iconSubExistSmallScreen;
				$itemsLeft .= '</div>';
				if ($this->getdata(['page',$parentPageId,'hideMenuChildren']) === true ||
					empty($childrenPageIds)) {
					continue;
				}
				$itemsLeft .= '<ul id="_'.$parentPageId.'" class="navSub">';
				foreach($childrenPageIds as $childKey) {
					// Propriétés de l'item
					$active = ($childKey === $currentPageId) ? 'active ' : '';
					$targetBlank = $this->getData(['page', $childKey, 'targetBlank']) ? ' target="_blank"' : '';
					//Si la sous-page est désactivée et que le client est < éditeur on ne l'affiche pas
					if( $this->getData(['page',$childKey,'disable']) === true && $groupUser < 2 ){
						continue;
					} else {
						// Mise en page du sous-item
						$itemsLeft .= '<li>';
						$pageDesactived = false;
						if ( $this->getData(['page',$childKey,'disable']) === true && $groupUser < 2 ){
							$pageUrl = ($this->getData(['locale', 'homePageId']) === $this->getUrl(0)) ? helper::baseUrl(false)  :  helper::baseUrl() . $this->getUrl(0);
							$itemsLeft .= '<a class="disabled-link">';
							$pageDesactived = true;
						} else {
							$pageUrl = ($this->getData(['locale', 'homePageId']) === $childKey) ? helper::baseUrl(false)  :  helper::baseUrl() . $childKey;
							$itemsLeft .= '<a class="' . $active . $parentPageId . '" href="' .  $pageUrl . '"' . $targetBlank  . '>';
						}
						switch ($this->getData(['page', $childKey, 'typeMenu'])) {
							case '' :
								$itemsLeft .= $this->getData(['page', $childKey, 'shortTitle']);
								break;
							case 'text' :
								$itemsLeft .= $this->getData(['page', $childKey, 'shortTitle']);
								break;
							case 'icon' :
								if ($this->getData(['page', $childKey, 'iconUrl']) != "") {
								$itemsLeft .= '<img alt="'.$this->getData(['page', $parentPageId, 'shortTitle']).'" src="'. helper::baseUrl(false) .self::FILE_DIR.'source/'.$this->getData(['page', $childKey, 'iconUrl']).'" style="height:'.$heightLogo.'px; width:auto;">';
								} else {
								$itemsLeft .= $this->getData(['page', $parentPageId, 'shortTitle']);
								}
								break;
							case 'icontitle' :
								if ($this->getData(['page', $childKey, 'iconUrl']) != "") {
								$itemsLeft .= '<img alt="'.$this->getData(['page', $parentPageId, 'shortTitle']).'" src="'. helper::baseUrl(false) .self::FILE_DIR.'source/'.$this->getData(['page', $childKey, 'iconUrl']).'" style="height:'.$heightLogo.'px; width:auto;" data-tippy-content="';
								$itemsLeft .= $this->getData(['page', $childKey, 'shortTitle']).'">';
								} else {
								$itemsLeft .= $this->getData(['page', $childKey, 'shortTitle']);
								}
								break;
							case 'icontext' :
								if ($this->getData(['page', $childKey, 'iconUrl']) != "") {
								$itemsLeft .= '<img alt="'.$this->getData(['page', $parentPageId, 'shortTitle']).'" src="'. helper::baseUrl(false) .self::FILE_DIR.'source/'.$this->getData(['page', $childKey, 'iconUrl']).'" style="height:'.$heightLogo.'px; width:auto;">';
								$itemsLeft .= $this->getData(['page', $childKey, 'shortTitle']);
								} else {
								$itemsLeft .= $this->getData(['page', $childKey, 'shortTitle']);
								}
								break;
						}
						$itemsLeft .= '</a></li>';
					}
				}
				$itemsLeft .= '</ul>';
			}
		}
		// Lien de connexion
		$itemsRight = '';
		$spaceMenu = '<li id="menuSpace"> </li>';
		if(
			(
				$this->getData(['theme', 'menu', 'loginLink'])
				AND $this->getUser('password') !== $this->getInput('DELTA_USER_PASSWORD')
			)
			OR $this->getUrl(0) === 'theme'
		) {
			$itemsRight .= '<li ' .
			($this->getUrl(0) === 'theme' ? 'class="displayNone"' : 'class="smallScreenInline"') .
			'><a href="' . helper::baseUrl() . 'user/login/' .
			strip_tags(str_replace('/', '_', $this->getUrl())) .
			'">' . template::ico('login') .'</a></li>';
		}
		// Commandes pour les membres simples
		if($this->getUser('group') == self::GROUP_MEMBER
			&& ( $this->getData(['theme','menu','memberBar']) === true
				|| $this->getData(['theme','footer','displayMemberBar']) === false
				)
		) {
			if( $this->getData(['user', $this->getUser('id') , 'files']) === true) $itemsRight .= '<li class="smallScreenInline"><a href="' . helper::baseUrl(false) . 'core/vendor/filemanager/dialog.php?type=0&akey=' . md5_file(self::DATA_DIR.'core.json') .'" data-tippy-content="'.$text['core']['showmenu'][0].'" data-lity>' . template::ico('folder') . '</a></li>';
			$itemsRight .= '<li class="smallScreenInline"><a href="' . helper::baseUrl() . 'user/edit/' . $this->getUser('id'). '/' . $_SESSION['csrf'] . '" data-tippy-content="'.$text['core']['showmenu'][1].'">' . template::ico('user', 'right') . '</a></li>';
			$itemsRight .= '<li class="smallScreenInline"><a id="barLogout" href="' . helper::baseUrl() . 'user/logout" data-tippy-content="'.$text['core']['showmenu'][2].'">' . template::ico('logout') . '</a></li>';
		}

		// Affichage du menu
		// En commençant par lien de connexion, barre de membre et les drapeaux uniquement en petit écran
		echo '<ul class="smallScreenFlags">' .  $itemsRight;
		if($this->getData(['config', 'i18n', 'enable']) === true) {
			echo $this->showi18n();
		}
		echo '</ul>';
		if( $itemsRight === '') $spaceMenu ='';
		echo '<ul class="navMain" id="menuLeft">' . $itemsLeft  . $spaceMenu . $itemsRight ;
		if($this->getData(['config', 'i18n', 'enable']) === true) {
			$flagVisible = false;
			foreach (self::$i18nList as $key => $value) {
				if( $this->getData(['config', 'i18n', $key]) === 'site' || $this->getData(['config', 'i18n', $key]) === 'script' ){
					$flagVisible = true;
					continue;
				}
			}
			if( $itemsRight === '' && $flagVisible === true ) echo $spaceMenu;
			if( $flagVisible === true) echo $this->showi18n();
		}
		echo '</ul></div></nav>';
	}

	/**
	 * Générer un menu pour la barre latérale
	 * Uniquement texte
	 * @param onlyChildren n'affiche les sous-pages de la page actuelle
	 */
	private function showMenuSide($onlyChildren = null) {
		// Met en forme les items du menu
		$items = '';
		// Nom de la page courante
		$currentPageId = $this->getData(['page', $this->getUrl(0)]) ? $this->getUrl(0) : $this->getUrl(2);
		// Nom de la page parente
		$currentParentPageId = $this->getData(['page',$currentPageId,'parentPageId']);
		// Détermine si on affiche uniquement le parent et les enfants
		// Filtre contient le nom de la page parente

		if ($onlyChildren === true) {
			if (empty($currentParentPageId)) {
				$filterCurrentPageId = $currentPageId;
			} else {
				$filterCurrentPageId = $currentParentPageId;
			}
		} else {
			$items .= '<ul class="menuSide">';
		}
		// Groupe du client connecté (1, 2, 3, 4) ou non connecté (0)
		$groupUser = $this->getUser('group') === false ? 0 : $this->getUser('group');
		foreach($this->getHierarchy() as $parentPageId => $childrenPageIds) {
			// Cas où les pages enfants enfant sont toutes desactivées dans le menu
			$totalChild = 0;
			$disableChild = 0;
			foreach($childrenPageIds as $childKey) {
				$totalChild += 1;
				if( $this->getData(['page', $childKey, 'disable']) === true ) $disableChild +=1;
			}
			// Ne pas afficher les pages masquées dans le menu latéral ou les pages désactivées sans sous-page active pour les clients < éditeur
			if ($this->getData(['page',$parentPageId,'hideMenuSide']) === true || ( $this->getData(['page',$parentPageId,'disable']) && (empty($childrenPageIds) ||  $disableChild === $totalChild) && $groupUser < 2 ) ) {
				continue;
			}
			// Filtre actif et nom de la page parente courante différente, on sort de la boucle
			if ($onlyChildren === true && $parentPageId !== $filterCurrentPageId) {
				continue;
			}
			// Propriétés de l'item
			$active = ($parentPageId === $currentPageId OR in_array($currentPageId, $childrenPageIds)) ? ' class="active"' : '';
			$targetBlank = $this->getData(['page', $parentPageId, 'targetBlank']) ? ' target="_blank" ' : '';
			// Mise en page de l'item;
			// Ne pas afficher le parent d'une sous-page quand l'option est sélectionnée.
			if ($onlyChildren === false) {
				$items .= '<li class="menuSideChild">';
				if ( $this->getData(['page',$parentPageId,'disable']) === true
					AND $this->getUser('password') !== $this->getInput('DELTA_USER_PASSWORD')	) {
						$items .= '<a class="disabled-link">';
						//$items .= '<a href="'.$this->getUrl(1).'">';
				} else {
						$items .= '<a href="'. helper::baseUrl() . $parentPageId . '"' . $targetBlank .  $active .'>';
				}
				$items .= $this->getData(['page', $parentPageId, 'shortTitle']);
				$items .= '</a>';
			}
			$itemsChildren = '';
			foreach($childrenPageIds as $childKey) {
				// Passer les sous-pages masquées ou désactivées si client < éditeur
				if ($this->getData(['page',$childKey,'hideMenuSide']) === true || ( $this->getData(['page',$childKey,'disable']) === true && $groupUser < 2)) {
					continue;
				}

				// Propriétés de l'item
				$active = ($childKey === $currentPageId) ? ' class="active"' : '';
				$targetBlank = $this->getData(['page', $childKey, 'targetBlank']) ? ' target="_blank"' : '';
				// Mise en page du sous-item
				$itemsChildren .= '<li class="menuSideChild">';

				if ( $this->getData(['page',$childKey,'disable']) === true
					AND $this->getUser('password') !== $this->getInput('DELTA_USER_PASSWORD')	) {
						$itemsChildren .= '<a href="'.$this->getUrl(1).'">';
				} else {
					$itemsChildren .= '<a href="' . helper::baseUrl() . $childKey . '"' . $targetBlank . $active . '>';
				}

				$itemsChildren .= $this->getData(['page', $childKey, 'shortTitle']);
				$itemsChildren .= '</a></li>';
			}
			// Concatène les items enfants
			if (!empty($itemsChildren)) {
				$items .= '<ul class="menuSideChild">';
				$items .= $itemsChildren;
				$items .= '</ul>';
			} else {
				$items .= '</li>';
			}

		}
		if ($onlyChildren === false) {
			$items .= '</ul>';
		}
		// Retourne les items du menu
		echo  $items;
	}

	/**
    * Affiche les balises title et meta name
    */
    public function showMetaTitle() {
        echo '<title>' . $this->output['metaTitle'] . '</title>' . PHP_EOL;
        echo '<meta name="description" content="' . $this->output['metaDescription'] . '">' . PHP_EOL;
        echo '<link rel="canonical" href="'. helper::baseUrl(true).$this->getUrl() .'">' . PHP_EOL;
    }

    /**
    * Affiche les balises meta property propres à Facebook
    */
    public function showMetaPropertyFacebook() {
        echo '<meta property="og:title" content="' . $this->output['metaTitle'] . '">' . PHP_EOL;
        echo '<meta property="og:description" content="' . $this->output['metaDescription'] . '">' . PHP_EOL;
        echo '<meta property="og:type" content="website">' . PHP_EOL;
        echo '<meta property="og:image" content="' . helper::baseUrl() .self::FILE_DIR.'source/screenshot.jpg">' . PHP_EOL;
    }

	/**
	 * Affiche la notification
	 */
	public function showNotification() {
		// Lexique
		include('./core/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_core.php');

		if (common::$importNotices) {
			$notification = common::$importNotices [0];
			$notificationClass = 'notificationSuccess';
		}
		if(common::$inputNotices) {
			$notification = $text['core']['showNotification'][0];
			$notificationClass = 'notificationError';
		}
		if (common::$coreNotices) {
			$notification = $text['core']['showNotification'][1].'<p> | ';
			foreach (common::$coreNotices as $item) $notification .= $item . ' | ';
			$notificationClass = 'notificationError';
		}
		elseif(empty($_SESSION['DELTA_NOTIFICATION_SUCCESS']) === false) {
			$notification = $_SESSION['DELTA_NOTIFICATION_SUCCESS'];
			$notificationClass = 'notificationSuccess';
			unset($_SESSION['DELTA_NOTIFICATION_SUCCESS']);
		}
		elseif(empty($_SESSION['DELTA_NOTIFICATION_ERROR']) === false) {
			$notification = $_SESSION['DELTA_NOTIFICATION_ERROR'];
			$notificationClass = 'notificationError';
			unset($_SESSION['DELTA_NOTIFICATION_ERROR']);
		}
		elseif(empty($_SESSION['DELTA_NOTIFICATION_OTHER']) === false) {
			$notification = $_SESSION['DELTA_NOTIFICATION_OTHER'];
			$notificationClass = 'notificationOther';
			unset($_SESSION['DELTA_NOTIFICATION_OTHER']);
		}
		if(isset($notification) AND isset($notificationClass)) {
			echo '<div id="notification" class="' . $notificationClass . '">' . $notification . '<span id="notificationClose">' . template::ico('cancel') . '<!----></span><div id="notificationProgress"></div></div>';
		}
	}

	/**
	 * Affiche la barre de membre
	 */
	public function showBar() {
		// Lexique
		include('./core/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_core.php');

		if($this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')) {
			// Items de gauche
			$leftItems = '';
			if($this->getUser('group') >= self::GROUP_EDITOR) {
				$leftItems .= '<li><select id="barSelectPage">';
				$leftItems .= '<option value="">'.$text['core']['showBar'][0].'</option>';
				$leftItems .= '<optgroup label="'.$text['core']['showBar'][1].'">';
				$orpheline = true ;
				$currentPageId = $this->getData(['page', $this->getUrl(0)]) ? $this->getUrl(0) : $this->getUrl(2);
				foreach($this->getHierarchy(null,false) as $parentPageId => $childrenPageIds) {
					if ($this->getData(['page', $parentPageId, 'position']) !== 0  &&
						$orpheline ) {
							$orpheline = false;
							$leftItems .= '<optgroup label="'.$text['core']['showBar'][2].'">';
					}
					// Exclure les barres
					if ($this->getData(['page', $parentPageId, 'block']) !== 'bar') {
						$leftItems .= '<option value="' .
									helper::baseUrl() .
									$parentPageId . '"' .
									($parentPageId === $currentPageId ? ' selected' : false) .
									' class="' .
									($this->getData(['page', $parentPageId, 'disable']) === true ? 'pageInactive' : '') .
									($this->getData(['page', $parentPageId, 'position']) === 0 ? ' pageHidden' : '') .
									'">' .
									$this->getData(['page', $parentPageId, 'shortTitle']) .
									'</option>';
						foreach($childrenPageIds as $childKey) {
							$leftItems .= '<option value="' .
											helper::baseUrl() .
											$childKey . '"' .
											($childKey === $currentPageId ? ' selected' : false) .
											' class="' .
											($this->getData(['page', $childKey, 'disable']) === true ? 'pageInactive' : '') .
											($this->getData(['page', $childKey, 'position']) === 0 ? ' pageHidden' : '') .
											'">&nbsp;&nbsp;&nbsp;&nbsp;' .
											$this->getData(['page', $childKey, 'shortTitle']) .
											'</option>';
						}
					}
				}
				$leftItems .= '</optgroup'>
				// Afficher les barres
				$leftItems .= '<optgroup label="'.$text['core']['showBar'][3].'">';
				foreach($this->getHierarchy(null, false,true) as $parentPageId => $childrenPageIds) {
					$leftItems .= '<option value="' . helper::baseUrl() . $parentPageId . '"' . ($parentPageId === $currentPageId ? ' selected' : false) . '>' . $this->getData(['page', $parentPageId, 'shortTitle']) . '</option>';
					foreach($childrenPageIds as $childKey) {
						$leftItems .= '<option value="' . helper::baseUrl() . $childKey . '"' . ($childKey === $currentPageId ? ' selected' : false) . '>&nbsp;&nbsp;&nbsp;&nbsp;' . $this->getData(['page', $childKey, 'shortTitle']) . '</option>';
					}
				}
				$leftItems .= '</optgroup>';
				$leftItems .= '</select></li>';
				if($this->getUser('group') >= self::GROUP_MODERATOR) $leftItems .= '<li><a href="' . helper::baseUrl() . 'page/add" data-tippy-content="'.$text['core']['showBar'][4] .'">'. template::ico('plus') . '</a></li>';
				if(
					// Sur un module de page qui autorise le bouton de modification de la page
					$this->output['showBarEditButton']
					// Sur une page sans module
					OR $this->getData(['page', $this->getUrl(0), 'moduleId']) === ''
					// Sur une page d'accueil
					OR $this->getUrl(0) === ''
				) {
					// Droits d'édition et de configuration du module ?
					if( null == $this->getData(['page', $this->getUrl(0), 'groupEdit']) || $this->getUser('group') >= $this->getData(['page', $this->getUrl(0), 'groupEdit'])){
						$leftItems .= '<li><a href="' . helper::baseUrl() . 'page/edit/' . $this->getUrl(0) . '" data-tippy-content="'.$text['core']['showBar'][5].'">' . template::ico('pencil') . '</a></li>';
						if ($this->getData(['page', $this->getUrl(0),'moduleId'])) {
							$leftItems .= '<li><a href="' . helper::baseUrl() . $this->getUrl(0) . '/config' . '" data-tippy-content="'.$text['core']['showBar'][6].'">' . template::ico('gear') . '</a></li>';
						}
					}
					//	Droits pour dupliquer ou effacer ?
					if( null == $this->getData(['page', $this->getUrl(0), 'groupEdit']) || $this->getUser('group') >= $this->getData(['page', $this->getUrl(0), 'groupEdit'])){
						if($this->getUser('group') >= self::GROUP_MODERATOR) {
							$leftItems .= '<li><a id="pageDuplicate" href="' . helper::baseUrl() . 'page/duplicate/' . $this->getUrl(0) . '&csrf=' . $_SESSION['csrf'] . '" data-tippy-content="'.$text['core']['showBar'][7].'">' . template::ico('clone') . '</a></li>';
							$leftItems .= '<li><a id="pageDelete" href="' . helper::baseUrl() . 'page/delete/' . $this->getUrl(0) . '&csrf=' . $_SESSION['csrf'] . '" data-tippy-content="'.$text['core']['showBar'][8].'">' . template::ico('trash') . '</a></li>';
						}
					}
				}
			}
			// Items de droite
			$rightItems = '';
			if($this->getUser('group') >= self::GROUP_EDITOR) {
				$rightItems .= '<li><a href="' . helper::baseUrl(false) . 'core/vendor/filemanager/dialog.php?type=0&akey=' . md5_file(self::DATA_DIR.'core.json') .'" data-tippy-content="'.$text['core']['showBar'][9] .'" data-lity>' . template::ico('folder') . '</a></li>';
			}
			if($this->getUser('group') >= self::GROUP_ADMIN) {
				$rightItems .= '<li><a href="' . helper::baseUrl() . 'theme" data-tippy-content="'.$text['core']['showBar'][10] .'">' . template::ico('brush') . '</a></li>';
				$rightItems .= '<li><a href="' . helper::baseUrl() . 'addon" data-tippy-content="'.$text['core']['showBar'][11].'">' . template::ico('puzzle') . '</a></li>';
				if ($this->getData(['config', 'i18n', 'enable']) === true) {
					$rightItems .= '<li><a href="' . helper::baseUrl() . 'translate" data-tippy-content="'.$text['core']['showBar'][12].'">' . template::ico('flag') . '</a></li>';
				}
				$rightItems .= '<li><a href="' . helper::baseUrl() . 'config" data-tippy-content="'.$text['core']['showBar'][13].'">' . template::ico('cog-alt') . '</a></li>';
				$rightItems .= '<li><a href="' . helper::baseUrl() . 'user" data-tippy-content="'.$text['core']['showBar'][14].'">' . template::ico('users') . '</a></li>';
				// Mise à jour automatique
				$today = time();
				// Une mise à jour est disponible : recherche auto activée et ( 1 jour de délai ou page config ) et version non encore lue dans la session
				if ( $this->getData(['config','autoUpdate']) === true
					&& ( $today > $this->getData(['core','lastAutoUpdate']) + 86400 || $this->getUrl(0) === 'config' )
					&& !isset($_SESSION['versionNumberRead']) ) {
						$version = helper::getOnlineVersion();
						$_SESSION['versionNumberRead'] = $version;
						if( $version === false){
							// Le serveur ne supporte pas la mise à jour automatique
							$this->setData(['config','autoUpdate',false]);
						} else {
							$this->setData(['core','updateAvailable', false]);
							if ( version_compare(common::DELTA_VERSION,$version) === -1 ) {
								$this->setData(['core','updateAvailable', true]);
								$this->setData(['core','lastAutoUpdate',$today]);
							}
						}
				}
				// Afficher le bouton : Mise à jour détectée + activée
				if ( $this->getData(['core','updateAvailable']) === true &&
					$this->getData(['config','autoUpdate']) === true  ) {
					$rightItems .= '<li><a id="barUpdate" href="' . helper::baseUrl() . 'install/update" data-tippy-content="'.$text['core']['showBar'][15]. common::DELTA_VERSION .' vers '. helper::getOnlineVersion() .'">' . template::ico('update colorRed') . '</a></li>';
				}
			}
			if($this->getUser('group') >= self::GROUP_EDITOR) {
				$rightItems .= '<li><a href="' . helper::baseUrl() . 'user/edit/' . $this->getUser('id'). '/' . $_SESSION['csrf'] . '" data-tippy-content="'.$text['core']['showBar'][16].'">' . template::ico('user', 'right') . '<span id="displayUsername">' .  $this->getUser('firstname') . ' ' . $this->getUser('lastname') . '</span></a></li>';
			}
			$rightItems .= '<li><a id="barLogout" href="' . helper::baseUrl() . 'user/logout" data-tippy-content="'.$text['core']['showBar'][17].'">' . template::ico('logout') . '</a></li>';
			// Barre de membre
			echo '<div id="bar"><div class="container"><ul id="barLeft">' . $leftItems . '</ul><ul id="barRight">' . $rightItems . '</ul></div></div>';
		}
	}

	/**
	 * Affiche la bannière
	 */
	public function showHeader( $position = ''){

		$homePageOnly = false;
		if( $this->getUrl(0) !== 'theme' ){
			if( $this->getUrl(0) !== $this->getData(['locale', 'homePageId' ]) && $this->getData(['theme','header','homePageOnly']) === true) $homePageOnly = true;
		}
		$headerClass =  ($this->getData(['theme', 'header', 'position']) === 'hide' || $homePageOnly === true) ? 'displayNone ' : '';
		$headerClass .= $this->getData(['theme', 'header', 'tinyHidden']) ? ' bannerDisplay ' : '';
		switch ($position){
			case 'body' :
				$headerClass .= $this->getData(['theme', 'header', 'wide']) === 'none' ? '' : 'container';
			break;
			case 'site' :
			break;
		}

		?><header <?php echo empty($headerClass) ? '' : 'class="' . $headerClass . '"'; ?> >
			<?php if ($this->getData(['theme','header','feature']) === 'wallpaper' ) {
				echo '<div id="wallPaper">';
				echo ($this->getData(['theme','header','linkHomePage']) ) ?  '<a class="headertitle" href="' . helper::baseUrl(false) . '">' : '';
				if(
					$this->getData(['theme', 'header', 'textHide']) === false
					// Affiche toujours le titre de la bannière pour l'édition du thème
					OR ($this->getUrl(0) === 'theme' AND $this->getUrl(1) === 'header')
				): ?>
						<span class="notranslate" id="themeHeaderTitle"><?php echo $this->getData(['locale', 'title']); ?></span>
				<?php else: ?>
						<span id="themeHeaderTitle">&nbsp;</span>
				<?php endif;
				 echo ( $this->getData(['theme','header','linkHomePage']) ) ? '</a>' : '';
				 echo '</div>';
			 } elseif( $this->getData(['theme','header','feature']) === 'feature') { ?>
				<div id="featureContent">
					<?php echo $this->getData(['theme','header','featureContent']);?>
				</div>
			<?php } else {
				// Swiper avec défilement vertical ? Pour adaptation à la largeur de l'écran client
				if( $this->getData(['theme','header','feature'])=== 'swiper' && $this->getData(['theme','header','swiperEffects']) === 'vertical'){
					$iterator = new DirectoryIterator('./'.$this->getData(['theme', 'header', 'swiperImagesDir' ]));
					$imageFile = [];
					foreach($iterator as $key=>$fileInfos) {
					  if($fileInfos->isDot() === false AND $fileInfos->isFile() AND @getimagesize($fileInfos->getPathname())) {
						$imageFile[$key] = $fileInfos->getPathname();
					  }
					}
					sort($imageFile);
					$size = getimagesize($imageFile[0]);
					$heightMod = 0;
					if( isset( $_COOKIE["DELTA_COOKIE_INNERWIDTH"] ) ){
						$wclient = $_COOKIE["DELTA_COOKIE_INNERWIDTH"];
					} else {
						$wclient = 1500;
					}
					$widthMod  = $wclient;
					if( $this->getData(['theme', 'site', 'width' ]) !== '100%' && ( ( $this->getData(['theme', 'header', 'wide' ]) === 'container' && $this->getData(['theme', 'header', 'position' ]) === 'body')
						|| $this->getData(['theme', 'header', 'position' ]) === 'site' ) ){
						switch ( $this->getData(['theme', 'site', 'width' ]) )
						{
							case "75vw":
							$widthMod = 0.75 * $wclient;
							break;
							case "85vw":
							$widthMod  = 0.85 * $wclient;
							break;
							case "95vw":
							$widthMod  = 0.95 * $wclient;
							break;
							default:
							$widthMod  = $wclient;
						}
						$heightMod = $size[1] * ( $widthMod / $size[0]);
						$replace = '<div class="swiper mySwiper" style="width: '. (int)$widthMod . 'px; height:'.(int)$heightMod.'px">';
					} else {
						$heightMod = $size[1] * ( $wclient / $size[0]);
						$replace = '<div class="swiper mySwiper" style="width: 100%; height:'.(int)$heightMod.'px">';
					}
					$string =  $this->getData(['theme','header','swiperContent']);
					$start = strpos( $string, '<div class="swiper mySwiper" style="');
					$end = strpos($string,'>', $start);
					$search = substr( $string, $start, $end - $start + 1 );
					$string = str_replace( $search, $replace, $string );
					$this->setData(['theme','header','swiperContent', $string]);
				}
				if( ! $homePageOnly ) echo $this->getData(['theme','header','swiperContent']);
			} ?>
		</header> <?php
	}

	/**
	 * Affiche le script
	 */
	public function showScript() {
		// Lexique
		include('./core/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_core.php');
		?><script>var textUpdating = <?php echo '"'.$text['core_js'][0].'"'; ?>; var textSelectFile = <?php echo '"'.$text['core_js'][1].'"'; ?>; var textLogout = <?php echo '"'.$text['core_js'][2].'"'; ?>; var textCheckMail = <?php echo '"'.$text['core_js'][3].'"'; ?>; var textPageDelete = <?php echo '"'.$text['core_js'][4].'"'; ?>; var textConfirmYes = <?php echo '"'.$text['core_js'][5].'"'; ?>; var textConfirmNo = <?php echo '"'.$text['core_js'][6].'"'; ?>; </script><?php
		ob_start();
		require 'core/core.js.php';
		$coreScript = ob_get_clean();
		echo '<script>' . helper::minifyJs($coreScript . $this->output['script']) . '</script>';
	}

	/**
	 * Affiche le style
	 */
	public function showStyle() {
		if($this->output['style']) {
			if (strpos($this->output['style'], 'admin.css') >= 1 ) {
				echo '<link rel="stylesheet" href="' . self::DATA_DIR . 'admin.css' . '">'.PHP_EOL;
			}
			echo '<style>' . helper::minifyCss($this->output['style']) . '</style>';
		}
	}
	/**
	* Affiche les variables partagées
	*/
	public function showSharedVariables() {
		// Variables partagées
		$vars = 'var baseUrl = ' . json_encode(helper::baseUrl(false)) . ';';
		$vars .= 'var baseUrlQs = ' . json_encode(helper::baseUrl()) . ';';
		if(
			$this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')
			AND $this->getUser('group') >= self::GROUP_EDITOR
		) {
			$vars .= 'var privateKey = ' . json_encode(md5_file(self::DATA_DIR.'core.json')) . ';';
		}
		echo '<script>' . helper::minifyJs($vars) . '</script>';
	}
	/*
	 * Tri le tableau output['vendor']
	 */
	public function sortVendor() {
		$moduleId = $this->getData(['page', $this->getUrl(0), 'moduleId']);
		foreach($this->output['vendor'] as $vendorName) {
		  // Coeur
		  if(file_exists('core/vendor/' . $vendorName . '/css.inc.json'))  self::$cssVendorPath[] = 'core/vendor/' . $vendorName . '/';
		  if(file_exists('core/vendor/' . $vendorName . '/jshead.inc.json'))  self::$jsHeadVendorPath[] = 'core/vendor/' . $vendorName . '/';
		  if(file_exists('core/vendor/' . $vendorName . '/jsbody.inc.json'))  self::$jsBodyVendorPath[] = 'core/vendor/' . $vendorName . '/';
		  // Modules
		  if(	$moduleId  AND in_array($moduleId, self::$coreModuleIds) === false){
			if( file_exists('module/' . $moduleId . '/vendor/' . $vendorName . '/css.inc.json') ) self::$cssVendorPath[] = 'module/' . $moduleId . '/vendor/' . $vendorName . '/';
			if( file_exists('module/' . $moduleId . '/vendor/' . $vendorName . '/jshead.inc.json') ) self::$jsHeadVendorPath[] = 'module/' . $moduleId . '/vendor/' . $vendorName . '/';
			if( file_exists('module/' . $moduleId . '/vendor/' . $vendorName . '/jsbody.inc.json') ) self::$jsBodyVendorPath[] = 'module/' . $moduleId . '/vendor/' . $vendorName . '/';
		  }
		}
	}
	/**
	 * Affiche les scripts et les styles dans le head ou le body
	 */
	public function showVendor($type) {
		// Pour bannière animée verticale
		if( $type === 'jshead' && $this->getData(['theme','header','feature'])=== 'swiper' && $this->getData(['theme','header','swiperEffects']) === 'vertical' ){
			?>	<script>var wclient = window.innerWidth;  document.cookie = "DELTA_COOKIE_INNERWIDTH =" + wclient + "; samesite=lax;" ; </script> <?php
			if( !isset(  $_COOKIE["DELTA_COOKIE_INNERWIDTH"]) && !isset( $_SESSION["innerWidth"] ) ){
				$protocol = helper::isHttps() === true ? 'https://' : 'http://';
				$url = $protocol . $_SERVER[ 'HTTP_HOST' ];
				?>	<script>window.location.replace(" <?php echo $url  ?>");</script> <?php
				$_SESSION["innerWidth"] = 'done';
			}
		}
		// Pour capture d'écran
		if( $type === 'jshead' && isset($_SESSION['screenshot'] ) && $_SESSION['screenshot'] === 'on' ){
			?> <script src="core/vendor/screenshot/html2canvas.min.js"></script> <?php
		}
		switch ($type) {
			case 'css' :
				$vendorPath = self::$cssVendorPath;
				$incName = 'css.inc.json';
				break;
			case 'jshead' :
				$vendorPath = self::$jsHeadVendorPath;
				$incName = 'jshead.inc.json';
				break;
			case 'jsbody' :
				$vendorPath = self::$jsBodyVendorPath;
				$incName = 'jsbody.inc.json';
				break;

		}
		foreach($vendorPath as $vendorName) {

			$vendorFiles = json_decode(file_get_contents($vendorName . $incName));
			foreach($vendorFiles as $vendorFile) {
				if( pathinfo($vendorFile, PATHINFO_EXTENSION) === 'js') {
					echo '<script src="' . $vendorName . $vendorFile . '"></script>';
				}
				if(pathinfo($vendorFile, PATHINFO_EXTENSION) === 'css') {
					echo '<link rel="stylesheet" href="' . $vendorName . $vendorFile . '">';
				}
			}
		}
	}
	/**
	 * Affiche le cadre avec les drapeaux sélectionnés
	 */
	public function showi18n() {
		foreach (self::$i18nList as $key => $value) {

			if ($this->getData(['config', 'i18n', $key]) === 'site') {
				if ( isset($_COOKIE['DELTA_I18N_SITE'] ) AND $_COOKIE['DELTA_I18N_SITE'] === $key ) {
					   $select = ' class="i18nFlagSelected" ';
				   } else {
					   $select = ' class="i18nFlag flag" ';
				   }

					echo '<li class="smallScreenInline">';
					echo '<a href="' . helper::baseUrl() . 'translate/i18n/' . $key . '/' . $this->getData(['config', 'i18n',$key]) . '/' . $this->getUrl(0) . '"><img ' . $select . ' alt="' .  $value . '" src="' . helper::baseUrl(false) . 'core/vendor/i18n/png/' . $key . '.png"></a>';
					echo '</li>';
			}
		}
	}
}

class core extends common {

	/**
	 * Constructeur du coeur
	 */
	public function __construct() {
		parent::__construct();
		// Token CSRF
		if(empty($_SESSION['csrf'])) {
			$_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
		}

		// Fuseau horaire
		self::$timezone = $this->getData(['config', 'timezone']); // Utile pour transmettre le timezone à la classe helper
		date_default_timezone_set(self::$timezone);
		// Supprime les fichiers temporaires
		$lastClearTmp = mktime(0, 0, 0);
		if($lastClearTmp > $this->getData(['core', 'lastClearTmp']) + 86400) {
			$iterator = new DirectoryIterator(self::TEMP_DIR);
			foreach($iterator as $fileInfos) {
				if( $fileInfos->isFile() &&
					$fileInfos->getBasename() !== '.htaccess' &&
					$fileInfos->getBasename() !== '.gitkeep'
				) {
					@unlink($fileInfos->getPathname());
				}
			}
			// Date de la dernière suppression
			$this->setData(['core', 'lastClearTmp', $lastClearTmp]);
			// Enregistre les données
			//$this->SaveData();
		}
		// Backup automatique des données
		$lastBackup = mktime(0, 0, 0);
		if(
			$this->getData(['config', 'autoBackup'])
			AND $lastBackup > $this->getData(['core', 'lastBackup']) + 86400
			AND $this->getData(['user']) // Pas de backup pendant l'installation
		) {
			// Copie des fichier de données
			helper::autoBackup(self::BACKUP_DIR,['backup','tmp','file']);
			// Date du dernier backup
			$this->setData(['core', 'lastBackup', $lastBackup]);
			// Supprime les backups de plus de 30 jours
			$iterator = new DirectoryIterator(self::BACKUP_DIR);
			foreach($iterator as $fileInfos) {
				if(
					$fileInfos->isFile()
					AND $fileInfos->getBasename() !== '.htaccess'
					AND $fileInfos->getMTime() + (86400 * 30) < time()
				) {
					@unlink($fileInfos->getPathname());
				}
			}
		}
		// Crée le fichier de personnalisation avancée
		if(file_exists(self::DATA_DIR.'custom.css') === false) {
			file_put_contents(self::DATA_DIR.'custom.css', file_get_contents('core/module/theme/resource/custom.css'));
			chmod(self::DATA_DIR.'custom.css', 0755);
		}
		// Crée le fichier de personnalisation
		if(file_exists(self::DATA_DIR.'theme.css') === false) {
			file_put_contents(self::DATA_DIR.'theme.css', '');
			chmod(self::DATA_DIR.'theme.css', 0755);
		}
		// Crée le fichier de personnalisation de l'administration
		if(file_exists(self::DATA_DIR.'admin.css') === false) {
			file_put_contents(self::DATA_DIR.'admin.css', '');
			chmod(self::DATA_DIR.'admin.css', 0755);
		}
		// Check la version rafraichissement du theme
		$cssVersion = preg_split('/\*+/', file_get_contents(self::DATA_DIR.'theme.css'));
		if(empty($cssVersion[1]) OR $cssVersion[1] !== md5(json_encode($this->getData(['theme']))) OR $this->getData([ 'theme', 'update']) === true) {
			// Version
			$css = '/*' . md5(json_encode($this->getData(['theme']))) . '*/';
			// Déclaration des polices
			$tab=[];
			$tab[0] = $this->getData(['theme', 'text', 'font']);
			$tab[1] = $this->getData(['theme', 'title', 'font']);
			$tab[2] = $this->getData(['theme', 'menu', 'font']);
			$tab[3] = $this->getData(['theme', 'header', 'font']);
			$tab[4] = $this->getData(['theme', 'footer', 'font']);
			// Suppression des doubons
			$tab = array_unique($tab);
			foreach( $tab as $key=>$value){
				if( $this->getData(['fonts', $value, 'type' ]) === 'file'){
					$file = $this->getData(['fonts', $value, 'file' ]);
					$format ='';
					switch (pathinfo($file, PATHINFO_EXTENSION)){
						case 'ttf':
							$format = 'truetype';
							break;
						case 'otf':
							$format = 'opentype';
							break;
						case 'eot':
							$format = 'embedded-opentype';
							break;
						case 'woff':
							$format = 'woff';
							break;
						case 'woff2':
							$format = 'woff2';
							break;
					}
					$css .= '@font-face{ font-family: "'. $this->getData(['fonts', $value, 'name' ]) .'"; src: url("../file/source/fonts/' . $file;
					$css .= '") format("'. $format . '");  font-weight: normal;  font-style: normal;}';
					$css .= ' ';
				}

			}
			// Fond du body
			$colors = helper::colorVariants($this->getData(['theme', 'body', 'backgroundColor']));
			// Body
			$css .= 'body{font-family:"' . $this->getData(['fonts', $this->getData(['theme', 'text', 'font']), 'name']) . '",sans-serif}';
			if($themeBodyImage = $this->getData(['theme', 'body', 'image'])) {
				// Image dans html pour éviter les déformations.
				$css .= 'html {background-image:url("../file/source/' . $themeBodyImage . '");background-position:' . $this->getData(['theme', 'body', 'imagePosition']) . ';background-attachment:' . $this->getData(['theme', 'body', 'imageAttachment']) . ';background-size:' . $this->getData(['theme', 'body', 'imageSize']) . ';background-repeat:' . $this->getData(['theme', 'body', 'imageRepeat']) . '}';
				// Couleur du body transparente
				$css .= 'body {background-color: rgba(0,0,0,0)}';
			} else {
				// Pas d'image couleur du body
				$css .= 'html {background-color:' . $colors['normal'] . ';}';
				// Même couleur dans le fond de l'éditeur
				//$css .= '{background-color:' . $colors['normal'] . ' !important}';
			}
			// Icône BacktoTop
			$css .= '#backToTop {background-color:' .$this->getData(['theme', 'body', 'toTopbackgroundColor']). ';color:'.$this->getData(['theme', 'body', 'toTopColor']).';}';
			// Site
			$colors = helper::colorVariants($this->getData(['theme', 'text', 'linkColor']));
			$css .= 'a{color:' . $colors['normal'] . '}';
			// Couleurs de site dans TinyMCe
			$css .= 'div.mce-edit-area {font-family:"' . $this->getData(['fonts', $this->getData(['theme', 'text', 'font']), 'name']) . '",sans-serif}';
			// Site dans TinyMCE pour la class ajoutée par init.js dans l'iframe
			$css .= '.editorWysiwyg {background-color:' . $this->getData(['theme', 'site', 'backgroundColor']) . '; margin:0 !important; padding-top: 10px;}';
			$css .= '.editorWysiwygHeader {background-color:' . $this->getData(['theme', 'header', 'backgroundColor']) . '; color:' . $this->getData(['theme', 'header', 'textColor']) . '; margin:0 !important; padding-top: 10px;}';
			$css .= 'span.mce-text{background-color: unset !important;}';
			//$css .= 'a:hover:not(.inputFile, button){color:' . $colors['darken'] . '}';
			$css .= 'body,.row > div{font-size:' . $this->getData(['theme', 'text', 'fontSize']) . '}';
			$css .= 'body{color:' . $this->getData(['theme', 'text', 'textColor']) . '}';
			$css .= 'select,input[type=\'password\'],input[type=\'email\'],input[type=\'text\'],.inputFile,select,textarea{color:' . $this->getData(['theme', 'text', 'textColor']) .';background-color:'.$this->getData(['theme', 'site', 'backgroundColor']).';border-color:'.$this->getData(['theme', 'block', 'borderColor']).';}';
			$css .= 'select:focus-visible,input[type=\'password\']:focus-visible,input[type=\'email\']:focus-visible,input[type=\'text\']:focus-visible,.inputFile:focus-visible,textarea:focus-visible{border-color:'.$this->getData(['theme', 'block', 'borderColor']).';}';
			$css .= 'select:hover,input[type=\'password\']:hover,input[type=\'email\']:hover,input[type=\'text\']:hover,.inputFile:hover,textarea:hover{border-color:'.$this->getData(['theme', 'block', 'borderColor']).';}';
			// spécifiques au module de blog
			$css .= '.blogDate {color:' . $this->getData(['theme', 'text', 'textColor']) . ';}.blogPicture img{border:1px solid ' . $this->getData(['theme', 'text', 'textColor']) . '; box-shadow: 1px 1px 5px ' . $this->getData(['theme', 'text', 'textColor']) . ';}';
			// Couleur fixée dans admin.css
			//$css .= '.button.buttonGrey,.button.buttonGrey:hover{color:' . $this->getData(['theme', 'text', 'textColor']) . '}';
			$css .= '.container, .helpDisplayContent{max-width:' . $this->getData(['theme', 'site', 'width']) . '}';
			$margin = $this->getData(['theme', 'site', 'margin']) ? '0' : '20px';
			// Marge supplémentaire lorsque le pied de page est fixe
			if ( $this->getData(['theme', 'footer', 'fixed']) === true &&
			$this->getData(['theme', 'footer', 'position']) === 'body') {
				$marginBottomLarge = ((str_replace ('px', '', $this->getData(['theme', 'footer', 'height']) ) * 2 ) + 31 ) . 'px';
				$marginBottomSmall = ((str_replace ('px', '', $this->getData(['theme', 'footer', 'height']) ) * 2 ) + 93 ) . 'px';
			} else {
				$marginBottomSmall = $margin;
				$marginBottomLarge = $margin;
			}
			// Site overflow visible si le menu est dans le site ou avant ou après la bannière dans le site
			$overflowSite = 'hidden';
			if( $this->getData(['theme', 'menu', 'position'])==='site' || ( $this->getData(['theme', 'header', 'position'])==='site' &&
			( $this->getData(['theme', 'menu', 'position'])==='site-first' || $this->getData(['theme', 'menu', 'position'])==='site-second' ))) $overflowSite = 'visible';
			$css .= '@media screen and (min-width: 800px) { #site { overflow: '.$overflowSite.'; } }';
			$css .= '@media screen and (max-width: 799px) { .container { max-width: 100vw; } }';
			$css .= $this->getData(['theme', 'site', 'width']) === '100%'
					? '@media (min-width: 800px) {#site{margin:0 auto ' . $marginBottomLarge . ' 0 !important;}}@media (max-width: 799px) {#site{margin:0 auto ' . $marginBottomSmall . ' 0 !important;}}#site.light{margin:5% auto !important;} body{margin:0 auto !important;}  #bar{margin:0 auto !important;} body > header{margin:0 auto !important;} body > nav {margin: 0 auto !important;} body > footer {margin:0 auto !important;}'
					: '@media (min-width: 800px) {#site{margin: ' . $margin . ' auto ' . $marginBottomLarge .  ' auto !important;}}@media (max-width: 799px) {#site{margin:0 auto ' . $marginBottomSmall .  ' auto !important;}}#site.light{margin: 5% auto !important;} body{margin:0px 10px;}  #bar{margin: 0 -10px;} body > header{margin: 0 -10px;} body > nav {margin: 0 -10px;} body > footer {margin: 0 -10px;} ';
			$css .= $this->getData(['theme', 'site', 'width']) === '75vw'
					? '.button, button{font-size:0.8em;}'
					: '';
			$css .= '@media (min-width: 800px) { #site{background-color:' . $this->getData(['theme', 'site', 'backgroundColor']) . ';border-radius:' . $this->getData(['theme', 'site', 'radius']) . ';box-shadow:' . $this->getData(['theme', 'site', 'shadow']) . ' #212223;} }';
			$css .= '@media (max-width: 799px) { #site{background-color:' . $this->getData(['theme', 'site', 'backgroundColor']) . ';border-radius: 0px; box-shadow: none;} }';
			$colors = helper::colorVariants($this->getData(['theme', 'button', 'backgroundColor']));
			$css .= '.speechBubble,.button,.button:hover,button[type=\'submit\'],.pagination a,.pagination a:hover,input[type=\'checkbox\']:checked + label:before,input[type=\'radio\']:checked + label:before,.helpContent{background-color:' . $colors['normal'] . ';color:' . $colors['text'] . '}';
			$css .= '.helpButton span{color:' . $colors['normal'] . '}';
			$css .= '.speechBubble:before{border-color:' . $colors['normal'] . ' transparent transparent transparent}';
			$css .= '.button:hover,button[type=\'submit\']:hover,.pagination a:hover,input[type=\'checkbox\']:not(:active):checked:hover + label:before,input[type=\'checkbox\']:active + label:before,input[type=\'radio\']:checked:hover + label:before,input[type=\'radio\']:not(:checked):active + label:before{background-color:' . $colors['darken'] . '}';
			$css .= '.helpButton span:hover{color:' . $colors['darken'] . '}';
			$css .= '.button:active,button[type=\'submit\']:active,.pagination a:active{background-color:' . $colors['veryDarken'] . '}';
			$colors = helper::colorVariants($this->getData(['theme', 'title', 'textColor']));
			$css .= 'h1,h2,h3,h4,h5,h6,h1 a,h2 a,h3 a,h4 a,h5 a,h6 a,.blockTitle,.accordion-title{color:' . $colors['normal'] . ';font-family:"' . $this->getData(['fonts', $this->getData(['theme', 'title', 'font']), 'name']) . '",sans-serif;font-weight:' . $this->getData(['theme', 'title', 'fontWeight']) . ';text-transform:' . $this->getData(['theme', 'title', 'textTransform']) . '}';
			$css .= 'h1 a:hover,h2 a:hover,h3 a:hover,h4 a:hover,h5 a:hover,h6 a:hover{color:' . $colors['darken'] . '}';
			// Les blocs
			$colors = helper::colorVariants($this->getData(['theme', 'block', 'backgroundTitleColor']));
			$css .= '.block {border: 1px solid ' . $this->getdata(['theme','block','borderColor']) .  ';background-color: ' . $this->getdata(['theme','block','backgroundColor']) .';border-radius: ' . $this->getdata(['theme','block','blockBorderRadius']) . ';box-shadow :' . $this->getdata(['theme','block','blockBorderShadow']) . ' ' . $this->getdata(['theme','block','borderColor']) . ';}';
			$css .= '.block > h4, .blockTitle {background-color:'. $colors['normal'] . ';color:' . $colors['text'] .';border-radius: ' . $this->getdata(['theme','block','blockBorderRadius']) . ' ' . $this->getdata(['theme','block','blockBorderRadius']) . ' 0px 0px;}';
			//Tinymce option titre sous une image valeurs par défaut modifiables dans custom.css
			$css .= 'figure.image { border-color: ' . $this->getdata(['theme','block','borderColor']) . '; background-color: ' . $this->getdata(['theme','block','backgroundColor']).'}';

			// Bannière

			// Eléments communs
			if($this->getData(['theme', 'header', 'margin'])) {
				if($this->getData(['theme', 'menu', 'position']) === 'site-first') {
					$css .= 'header{margin:0 20px}';
				}
				else {
					$css .= 'header{margin:20px 20px 0 20px}';
				}
			}
			$colors = helper::colorVariants($this->getData(['theme', 'header', 'backgroundColor']));
			$css .= 'header{background-color:' . $colors['normal'] . '; color:' . $this->getData(['theme', 'header', 'textColor']) . ';}';
			// Calcul de la hauteur du bandeau du menu burger utilisé dans plusieurs cas
			$fontsize = (int) str_replace('px', '', $this->getData(['theme', 'text', 'fontSize']));
			$height = $this->getData(['theme', 'menu', 'height']);
			$pospx = strpos($height, 'px');
			$height = (int) substr( $height, 0, $pospx);
			$bannerHeight = 2 * $height + 2 * $fontsize;	// 2*height imposé par l'icône burger

			// Bannière de type papier peint
			if ($this->getData(['theme','header','feature']) === 'wallpaper' ) {
				$css .= 'header #wallPaper{background-size:' . $this->getData(['theme','header','imageContainer']).'}';
				$css .= 'header #wallPaper{background-color:' . $colors['normal'];

				// Valeur de hauteur traditionnelle
				$css .= ';height:' . $this->getData(['theme', 'header', 'height']) . ';line-height:' . $this->getData(['theme', 'header', 'height']) ;

				$css .=  ';text-align:' . $this->getData(['theme', 'header', 'textAlign']) . '}';
				if($themeHeaderImage = $this->getData(['theme', 'header', 'image'])) {
					$css .= 'header #wallPaper{background-image:url("../file/source/' . $themeHeaderImage . '");background-position:' . $this->getData(['theme', 'header', 'imagePosition']) . ';background-repeat:' . $this->getData(['theme', 'header', 'imageRepeat']) . '}';
				}
				$colors = helper::colorVariants($this->getData(['theme', 'header', 'textColor']));
				$css .= 'header #wallPaper span{color:' . $colors['normal'] . ';font-family:"' . $this->getData(['fonts', $this->getData(['theme', 'header', 'font']), 'name']) . '",sans-serif;font-weight:' . $this->getData(['theme', 'header', 'fontWeight']) . ';font-size:' . $this->getData(['theme', 'header', 'fontSize']) . ';text-transform:' . $this->getData(['theme', 'header', 'textTransform']) . '}';
				// En petit écran pour s'adapter à des textes longs
				$search ='em';
				if( $this->getData(['theme', 'header', 'fontSize']) === '2.4vmax' ) $search = 'vmax';
				$titleLineHeight = str_replace(',','.',(str_replace(',','.',str_replace($search,'',$this->getData(['theme', 'header', 'fontSize']))/2)+0.2)).'em';
				//Si menu burger fixe et superposé à la bannière
				if( $this->getData(['theme', 'menu', 'burgerFixed']) && $this->getData(['theme', 'menu', 'burgerOverlay'])) {
					$titleMarginTop = strval($bannerHeight - 5).'px';
				} else {
					$titleMarginTop	= ((int) str_replace('px','', $this->getData(['theme', 'header', 'height'])))/2 - $fontsize * ( str_replace($search,'', $this->getData(['theme', 'header', 'fontSize'])));
					$titleMarginTop = strval((int)$titleMarginTop).'px';
				}
				$css .= '@media (max-width: 799px) { header #themeHeaderTitle{ margin-top:'.$titleMarginTop.'; line-height:'.$titleLineHeight.';}}';
			}

			// Bannière au contenu personnalisé
			if ($this->getData(['theme','header','feature']) === 'feature' ) {
				// Hauteur de la taille du contenu perso
				// $css .= 'header {height:'. $this->getData(['theme', 'header', 'height'])  . '; min-height:' . $this->getData(['theme', 'header', 'height'])  .  ';overflow: hidden;}';
				$css .= 'header {height:'. $this->getData(['theme', 'header', 'height'])  . '; min-height:20px;overflow: hidden;}';
				//$css .= '.bannerDisplay img { width: auto;max-height:' . $this->getData(['theme', 'header', 'height']) . ';}';

			}

			// Pour le décalage de la bannière ou de la section, en petit écran burger fixe, calcul de la hauteur du bandeau du menu
			$css .= '@media (max-width: 799px) {';
			$bannerHeight = $bannerHeight + 10;
			// Décalage de la bannière en petit écran et burger fixe et bannière visible et non superposée
			if( $this->getData(['theme', 'menu', 'position']) !== 'hide' && $this->getData(['theme', 'menu', 'burgerFixed']) === true
				&& $this->getData(['theme', 'header', 'tinyHidden']) === false && $this->getData(['theme', 'menu', 'burgerOverlay']) === false){
				$css .= '#site.container header, header.container { padding-top:'.$bannerHeight.'px;}';
			} else {
				$css .= '#site.container header, header.container { padding-top: 0;}';
			}
			$css .= '}';

			// Menu écran large couleurs
			$css .= '@media (min-width: 800px) {';
				$colors = helper::colorVariants($this->getData(['theme', 'menu', 'backgroundColor']));
				$css .= 'nav,nav.navMain a{background-color:' . $colors['normal'] . '}';
				$css .= 'nav a,nav #toggle span,nav a:hover{color:' . $this->getData(['theme', 'menu', 'textColor']) . '}';
				$css .= 'nav ul li span{color:' . $this->getData(['theme', 'menu', 'textColor']) .'}';
				$css .= 'nav a:hover{background-color:' . $colors['darken'] . '}';
				$css .= 'nav a.active{color:' . $this->getData(['theme','menu','activeTextColor']) . ';}';
				if ($this->getData(['theme','menu','activeColorAuto']) === true) {
					$css .= 'nav a.active{background-color:' . $colors['veryDarken'] . '}';
				} else {
					$css .= 'nav a.active{background-color:' . $this->getData(['theme','menu','activeColor']) . '}';
				}
				// Sous menu
				$colors = helper::colorVariants($this->getData(['theme', 'menu', 'backgroundColorSub']));
				$css .= 'nav .navSub a{background-color:' . $colors['normal'] . '}';
			$css .= '}';

			// Menu burger couleurs
			// Valeurs par défaut si chargement d'un thème < 4501
			if(is_null($this->getData(['theme', 'menu', 'burgerBackgroundColor'])) || $this->getData(['theme', 'menu', 'burgerBackgroundColor']) === '') $this->setData(['theme', 'menu', 'burgerBackgroundColor', $this->getData(['theme', 'menu', 'backgroundColor']) ]);
			if(is_null($this->getData(['theme', 'menu', 'burgerBackgroundColorSub'])) || $this->getData(['theme', 'menu', 'burgerBackgroundColorSub']) === '') $this->setData(['theme', 'menu', 'burgerBackgroundColorSub', $this->getData(['theme', 'menu', 'backgroundColorSub']) ]);
			$css .= '@media (max-width: 799px) {';
				$colors = helper::colorVariants($this->getData(['theme', 'menu', 'burgerBackgroundColor']));
				$css .= 'nav #toggle { background-color:'.$this->getData(['theme', 'menu', 'burgerBannerColor']).';}';
				$css .= 'nav #toggle span.delta-ico-menu::before, nav #toggle span.delta-ico-cancel::before{ background-color:'.$this->getData(['theme', 'menu', 'burgerIconBgColor']).';}';
				$css .= 'nav #toggle span{color:'.$this->getData(['theme', 'menu', 'burgerIconColor']).';}';
				$css .= 'nav ul li span{color:' . $this->getData(['theme', 'menu', 'burgerTextMenuColor']) .'}';
				$css .= 'nav #menu,nav.navMain a{background-color:' . $colors['normal'] .'}';
				$css .= 'nav #menu a,nav #menu a:hover{color:' . $this->getData(['theme', 'menu', 'burgerTextMenuColor']) . '}';
				$css .= 'nav #menu a:hover{background-color:' . $colors['darken'] . '}';
				$css .= 'nav #menu .active{color:' . $this->getData(['theme', 'menu', 'burgerActiveTextColor']) . ';}';
				// Couleur du body à la couleur de la page
				$css .= 'body {background-color:'.$this->getData(['theme', 'site', 'backgroundColor']).'}';
				if ($this->getData(['theme','menu','burgerActiveColorAuto']) === true) {
					$css .= 'nav #menu .active{background-color:' . $colors['veryDarken'] . '}';
				} else {
					$css .= 'nav #menu .active{background-color:' . $this->getData(['theme','menu','burgerActiveColor']) . '}';
				}
				$css .= 'nav #burgerText{color:' .  $this->getData(['theme','menu','burgerTextColor']) .';font-size:'.$this->getData(['theme','menu','burgerFontSize']) .';}';
				// Sous menu
				$colors = helper::colorVariants($this->getData(['theme', 'menu', 'burgerBackgroundColorSub']));
				$css .= 'nav #menu .navSub a{background-color:' . $colors['normal'] . '}';

				// Décalage de la section en menu burger fixe et non caché et bannière masquée ou cachée
				if( $this->getData(['theme', 'menu', 'position']) !== 'hide' && $this->getData(['theme', 'menu', 'burgerFixed']) === true
					&& ( $this->getData(['theme', 'header', 'tinyHidden']) === true || $this->getData(['theme', 'header', 'position']) === 'hide')){
					$css .= 'section { padding-top:'.$bannerHeight.'px;}';
				} else {
					$css .= 'section { padding-top: 10px;}';
				}
			$css .= '}';

			// Partie commune aux 2 types d'écran
			// Appliquer au menu les réglages de largeur minimale suivant l'option tous ou pages parent uniquement
			foreach($this->getHierarchy() as $parentPageId => $childrenPageIds) {
				if( $this->getData(['theme', 'menu', 'minWidthParentOrAll']) === true || $childrenPageIds !== [] ){
					$css .= 'nav li .' . $parentPageId . '{ min-width : '. $this->getData(['theme', 'menu', 'minWidthTab'])  .';}';
				}
			}
			$css .= 'nav .navMain a.active {border-radius:' . $this->getData(['theme', 'menu', 'radius']) . '}';
			$css .= '#menu{text-align:' . $this->getData(['theme', 'menu', 'textAlign']) . '}';
			if($this->getData(['theme', 'menu', 'margin'])) {
				if(
					$this->getData(['theme', 'menu', 'position']) === 'site-first'
					OR $this->getData(['theme', 'menu', 'position']) === 'site-second'
				) {
					$css .= 'nav{padding:10px 10px 0 10px;}';
				}
				else {
					$css .= 'nav{padding:0 10px}';
				}
			} else {
				$css .= 'nav{margin:0}';
			}
			if(
				$this->getData(['theme', 'menu', 'position']) === 'top'
				) {
					$css .= 'nav{padding:0 10px;}';
			}
			$css .= '#toggle span,#menu a{padding:' . $this->getData(['theme', 'menu', 'height']) .';font-family:"' . $this->getData(['fonts', $this->getData(['theme', 'menu', 'font']), 'name']) . '",sans-serif;font-weight:' . $this->getData(['theme', 'menu', 'fontWeight']) . ';font-size:' . $this->getData(['theme', 'menu', 'fontSize']) . ';text-transform:' . $this->getData(['theme', 'menu', 'textTransform']) . '}';

			// Pied de page
			$colors = helper::colorVariants($this->getData(['theme', 'footer', 'backgroundColor']));
			if($this->getData(['theme', 'footer', 'margin'])) {
				$css .= 'footer{padding:0 20px;}';
			} else {
				$css .= 'footer{padding:0}';
			}

			$css .= 'footer span, #footerText > p {color:' . $this->getData(['theme', 'footer', 'textColor']) . ';font-family:"' . $this->getData(['fonts', $this->getData(['theme', 'footer', 'font']), 'name']) . '",sans-serif;font-weight:' . $this->getData(['theme', 'footer', 'fontWeight']) . ';font-size:' . $this->getData(['theme', 'footer', 'fontSize']) . ';text-transform:' . $this->getData(['theme', 'footer', 'textTransform']) . '}';
			$css .= 'footer {background-color:' . $colors['normal'] . ';color:' . $this->getData(['theme', 'footer', 'textColor']) . '}';
			$css .= 'footer a{color:' . $this->getData(['theme', 'footer', 'textColor']) . '}';
			$css .= 'footer #footersite > div {margin:' . $this->getData(['theme', 'footer', 'height']) . ' 0}';

			$css .= 'footer #footerbody > div  {margin:' . $this->getData(['theme', 'footer', 'height']) . ' 0}';
			$css .= '@media (max-width: 799px) {footer #footerbody > div { padding: 2px }}';
			$css .= '#footerSocials{text-align:' . $this->getData(['theme', 'footer', 'socialsAlign']) . '}';
			$css .= '#footerText > p {text-align:' . $this->getData(['theme', 'footer', 'textAlign']) . '}';
			$css .= '#footerCopyright{text-align:' . $this->getData(['theme', 'footer', 'copyrightAlign']) . '}';

			// Panneau de consentement aux cookies, d'autres paramètres CSS sont gérés dans common.css
			$colorRgba = $this->getdata(['theme','block','backgroundColor']);
			// Suppression de l'opacité pour le panneau cookies
			preg_match( '/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i', $colorRgba, $by_color );
			$colorbg = sprintf( '#%02x%02x%02x', $by_color[1], $by_color[2], $by_color[3] );
			$css .= '#cookieConsent{ color: '. $this->getData(['theme', 'text', 'textColor']).' ; }';
			$css .= '#cookieConsent{border: 1px solid ' . $this->getdata(['theme','block','borderColor']) .  ';background-color: ' . $colorbg .';border-radius: ' . $this->getdata(['theme','block','blockBorderRadius']) . ';box-shadow :' . $this->getdata(['theme','block','blockBorderShadow']) . ' ' . $this->getdata(['theme','block','borderColor']) . ';}';
			$colors = helper::colorVariants($this->getData(['theme', 'button', 'backgroundColor']));
			$css .= '#cookieConsentConfirm{ background-color: '. $colors['normal'].' ; color: '. $colors['text'] .'; }';

			// Enregistre la personnalisation
			$this->setData([ 'theme', 'update', false]);
			file_put_contents(self::DATA_DIR.'theme.css', $css);
			// Effacer le cache pour tenir compte de la couleur de fond TinyMCE
			header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
		}

		// Check la mise à jour du theme admin
		if( $this-> getData(['admin', 'maj']) === true){
			// Version
			$css = '/*' . md5(json_encode($this->getData(['admin']))) . '*/';
			$this-> setData(['admin', 'maj', false]);
			// Chargement des polices
			if( is_file(self::DATA_DIR . 'fonts.json') ){
				$json = file_get_contents( self::DATA_DIR . 'fonts.json');
				$tab = json_decode($json, true);
				foreach( $tab as $key=>$liste){
					foreach ( $liste as $key=>$value ){
						if( $value['type'] === 'file' ){
							$format ='';
							switch (pathinfo($value['file'], PATHINFO_EXTENSION)){
								case 'ttf':
									$format = 'truetype';
									break;
								case 'otf':
									$format = 'opentype';
									break;
								case 'eot':
									$format = 'embedded-opentype';
									break;
								case 'woff':
									$format = 'woff';
									break;
								case 'woff2':
									$format = 'woff2';
									break;
							}
							$css .= '@font-face{ font-family: "'. $value['name'] .'"; src: url("../file/source/fonts/' . $value['file'];
							$css .= '") format("'. $format . '");  font-weight: normal;  font-style: normal;}';
							$css .= ' ';
						}
					}
				}
			}
			$colors = helper::colorVariants($this->getData(['admin','backgroundColor']));
			$css .= '#site{background-color:' . $colors['normal']. ';}';
			$css .= '.row > div {font:' . $this->getData(['admin','fontSize']) . ' "' . $this->getData(['fonts', $this->getData(['admin', 'fontText']), 'name']) . '", sans-serif;}';
			$css .= 'body h1, h2, h3, .block > h4, .blockTitle, h5, h6 {font-family:' .   $this->getData(['fonts', $this->getData(['admin', 'fontTitle']), 'name']) . ', sans-serif;color:' . $this->getData(['admin','colorTitle' ]) . ';}';

			// TinyMCE
			$css .= 'body:not(.editorWysiwyg),span .delta-ico-help {color:' . $this->getData(['admin','colorText']) . ';}';
			$css .= 'table thead tr, table thead tr .delta-ico-help{ background-color:'.$this->getData(['admin','colorText']).'; color:'.$colors['normal'].';}';
			$colors = helper::colorVariants($this->getData(['admin','backgroundColorButton']));
			$css .= 'input[type="checkbox"]:checked + label::before,.speechBubble{background-color:' . $colors['normal'] . ';color:' .  $colors['text'] . ';}';
			$css .= '.speechBubble::before {border-color:' . $colors['normal'] . ' transparent transparent transparent;}';
			$css .= '.button {background-color:' . $colors['normal'] . ';color:' . $colors['text']   . ';}.button:hover {background-color:' . $colors['darken'] . ';color:' . $colors['text']  . ';}.button:active {background-color:' . $colors['veryDarken'] . ';color:' . $colors['text']  . ';}';
			$css .= '.buttonPreview {background-color:' . $colors['normal'] . '!important;color:' . $colors['text']   . '!important;}.buttonPreview:hover {background-color:' . $colors['darken'] . '!important;color:' . $colors['text']  . '!important;}.buttonPreview:active {background-color:' . $colors['veryDarken'] . '!important;color:' . $colors['text']  . '!important;}';
			$colors = helper::colorVariants($this->getData(['admin','backgroundColorButtonGrey']));
			$css .= '.button.buttonGrey {background-color: ' . $colors['normal'] . ';color: ' . $colors['text']  . ';}.button.buttonGrey:hover {background-color:' . $colors['darken']  . ';color:' . $colors['text']  .  ';}.button.buttonGrey:active {background-color:' . $colors['veryDarken'] . ';color:' . $colors['text']  . ';}';
			$colors = helper::colorVariants($this->getData(['admin','backgroundColorButtonRed']));
			$css .= '.button.buttonRed {background-color: ' . $colors['normal'] . ';color: ' . $colors['text']   . ';}.button.buttonRed:hover {background-color:' . $colors['darken'] . ';color:' . $colors['text']  . ';}.button.buttonRed:active {background-color:' . $colors['veryDarken'] . ';color:' . $colors['text']  . ';}';
			$colors = helper::colorVariants($this->getData(['admin','backgroundColorButtonHelp']));
			$css .= '.button.buttonHelp {background-color: ' . $colors['normal'] . ';color: ' . $colors['text']   . ';}.button.buttonHelp:hover {background-color:' . $colors['darken'] . ';color:' . $colors['text']  . ';}.button.buttonHelp:active {background-color:' . $colors['veryDarken'] . ';color:' . $colors['text']  . ';}';
			$colors = helper::colorVariants($this->getData(['admin','backgroundColorButtonGreen']));
			$css .= '.button.buttonGreen, button[type=submit] {background-color: ' . $colors['normal'] . ';color: ' . $colors['text'] . ';}.button.buttonGreen:hover, button[type=submit]:hover {background-color: ' . $colors['darken'] . ';color: ' . $colors['text']  .';}.button.buttonGreen:active, button[type=submit]:active {background-color: ' . $colors['darken'] . ';color: ' .$colors['text']   .';}';
			$colors = helper::colorVariants($this->getData(['admin','backgroundBlockColor']));
			$css .= '.block {border: 1px solid ' . $this->getData(['admin','borderBlockColor']) . ';}.block > h4, .blockTitle {background-color: ' . $colors['normal'] . ';color:' . $colors['text'] . ';}';

			// en admin la couleur de fond du block est la couleur de la page admin, on supprime l'ombre et le radius du block définis pour le theme
			$css .= '.block {border-radius: 0px;box-shadow: none;}.block > h4, .blockTitle {border-radius: 0px;}';
			$css .= '.block {background-color: ' . $this->getData(['admin','backgroundColor']) . ';}';
			$css .= 'table tr,input[type=email],input[type=text],input[type=password],select:not(#barSelectPage),textarea:not(.editorWysiwyg),.inputFile{background-color: ' . $colors['normal'] . ';color:' . $colors['text'] . ';border: 1px solid ' . $this->getData(['admin','borderBlockColor']) . ';}';
			// Bordure du contour TinyMCE
			$css .= '.mce-tinymce{border: 1px solid '. $this->getData(['admin','borderBlockColor']) . '!important;}';
			// Enregistre la personnalisation
			file_put_contents(self::DATA_DIR.'admin.css', $css);
		}
	}
	/**
	 * Auto-chargement des classes
	 * @param string $className Nom de la classe à charger
	 */
	public static function autoload($className) {

		$classPath = strtolower($className) . '/' . strtolower($className) . '.php';
		// Module du coeur
		if(is_readable('core/module/' . $classPath)) {
			require 'core/module/' . $classPath;
		}
		// Module
		elseif(is_readable('module/' . $classPath)) {
			require 'module/' . $classPath;
		}
		// Librairie
		elseif(is_readable('core/vendor/' . $classPath)) {
			require 'core/vendor/' . $classPath;
		}

	}

	/**
	 * Routage des modules
	 */
	public function router() {
		// Installation
		if(
			$this->getData(['user']) === []
			AND $this->getUrl(0) !== 'install'
		) {
			http_response_code(302);
			header('Location:' . helper::baseUrl() . 'install');
			exit();
		}
		// Journalisation
		if ($this->getData(['config','connect','log'])) {
			$time = time();
			$dataLog = mb_detect_encoding(date('d\/m\/y',$time), 'UTF-8', true)
						? date('d\/m\/y',$time) . ';' . date('H\:i',$time) . ';'
						: utf8_encode(date('d\/m\/y',$time)) . ';' . utf8_encode(date('H\:i',$time)) . ';' ;
			$dataLog .= helper::getIp($this->getData(['config','connect','anonymousIp'])) . ';';
			$dataLog .= $this->getUser('id') ? $this->getUser('id') . ';' : 'anonyme' . ';';
			$dataLog .= $this->getUrl();
			$dataLog .= PHP_EOL;
			file_put_contents(self::DATA_DIR . 'journal.log', $dataLog, FILE_APPEND);
		}
		// Force la déconnexion des membres bannis ou d'une seconde session
		if (
			$this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')
			AND ( $this->getUser('group') === self::GROUP_BANNED
				  OR ( $_SESSION['csrf'] !== $this->getData(['user',$this->getUser('id'),'accessCsrf'])
					  AND $this->getData(['config','connect', 'autoDisconnect']) === true)
			    )
		) {
			$user = new user;
			$user->logout();
		}
		// Mode maintenance
		if(
			$this->getData(['config', 'maintenance'])
			AND in_array($this->getUrl(0), ['maintenance', 'user']) === false
			AND $this->getUrl(1) !== 'login'
			AND (
				$this->getUser('password') !== $this->getInput('DELTA_USER_PASSWORD')
				OR (
					$this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')
					AND $this->getUser('group') < self::GROUP_ADMIN
				)
			)
		) {
			// Déconnexion
			$user = new user;
			$user->logout();
			// Redirection
			http_response_code(302);
			header('Location:' . helper::baseUrl() . 'maintenance');
			exit();
		}
		// Check l'accès à la page
		$access = null;
		$accessInfo['userName'] = '';
		$accessInfo['pageId'] = '';
		if($this->getData(['page', $this->getUrl(0)]) !== null) {
			if(
				$this->getData(['page', $this->getUrl(0), 'group']) === self::GROUP_VISITOR
				OR (
					$this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')
					AND $this->getUser('group') >= $this->getData(['page', $this->getUrl(0), 'group'])
				)
			) {
				$access = true;
			}
			else {
				if($this->getUrl(0) === $this->getData(['locale', 'homePageId'])) {
					$access = 'login';
				}
				else {
					$access = false;
				}
			}
			// Empêcher l'accès aux pages désactivées par URL directe
			if ( ( $this->getData(['page', $this->getUrl(0),'disable']) === true
					AND $this->getUser('password') !== $this->getInput('DELTA_USER_PASSWORD')
				) OR (
				$this->getData(['page', $this->getUrl(0),'disable']) === true
					AND $this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')
					AND $this->getUser('group') < self::GROUP_EDITOR
				)
			){
				$access = false;
			}
		}

		/**
		 * Contrôle si la page demandée est en édition ou accès à la gestion du site
		 * conditions de blocage :
		 * - Les deux utilisateurs qui accèdent à la même page sont différents
		 * - les URLS sont identiques
		 * - Une partie de l'URL fait partie  de la liste de filtrage (édition d'un module etc..)
		 * - L'édition est ouverte depuis un temps dépassé, on considère que la page est restée ouverte et qu'elle ne sera pas validée
		 */
		foreach($this->getData(['user']) as $userId => $userIds){
			$t = [];
			if( null !== $this->getData(['user', $userId, 'accessUrl'])) $t = explode('/',$this->getData(['user', $userId, 'accessUrl']));
			if ( $this->getUser('id') &&
				$userId !== $this->getUser('id') &&
				$this->getData(['user', $userId,'accessUrl']) === $this->getUrl() &&
				array_intersect($t,self::$accessList)  &&
				array_intersect($t,self::$accessExclude) !== false	 &&
				time() < $this->getData(['user', $userId,'accessTimer']) + self::ACCESS_TIMER
			) {
					$access = false;
					$accessInfo['userName']	= $this->getData(['user', $userId, 'lastname']) . ' ' . $this->getData(['user', $userId, 'firstname']);
					$accessInfo['pageId'] = end($t);
			}
		}
		// Accès concurrent stocke la page visitée
		if ($this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')
			AND $this->getUser('id') ) {
			$this->setData(['user',$this->getUser('id'),'accessUrl',$this->getUrl()]);
			$this->setData(['user',$this->getUser('id'),'accessTimer',time()]);
		}
		// Breadcrumb
		$title = $this->getData(['page', $this->getUrl(0), 'title']);
		if (!empty($this->getData(['page', $this->getUrl(0), 'parentPageId'])) &&
				$this->getData(['page', $this->getUrl(0), 'breadCrumb'])) {
				$title = '<a href="' . helper::baseUrl() .
						$this->getData(['page', $this->getUrl(0), 'parentPageId']) .
						'">' .
						ucfirst($this->getData(['page',$this->getData(['page', $this->getUrl(0), 'parentPageId']), 'title'])) .
						'</a> &#8250; '.
						$this->getData(['page', $this->getUrl(0), 'title']);
		}
		// Importe la page
		if(
			$this->getData(['page', $this->getUrl(0)]) !== null
			AND $this->getData(['page', $this->getUrl(0), 'moduleId']) === ''
			AND $access
		) {
			$this->addOutput([
				'title' => $title,
				//'content' => file_get_contents(self::DATA_DIR . self::$i18n . '/content/' . $this->getData(['page', $this->getUrl(0), 'content'])),
				'content' => $this->getPage($this->getUrl(0), self::$i18n),
				'metaDescription' => $this->getData(['page', $this->getUrl(0), 'metaDescription']),
				'metaTitle' => $this->getData(['page', $this->getUrl(0), 'metaTitle']),
				'typeMenu' => $this->getData(['page', $this->getUrl(0), 'typeMenu']),
				'iconUrl' => $this->getData(['page', $this->getUrl(0), 'iconUrl']),
				'disable' => $this->getData(['page', $this->getUrl(0), 'disable']),
				'contentRight' => $this->getData(['page',$this->getUrl(0),'barRight'])
									//file_get_contents(self::DATA_DIR . self::$i18n . '/content/' . $this->getData(['page', $this->getData(['page',$this->getUrl(0),'barRight']), 'content']))
									? $this->getPage($this->getData(['page',$this->getUrl(0),'barRight']), self::$i18n)
									: '',
				'contentLeft'  => $this->getData(['page',$this->getUrl(0),'barLeft'])
									//file_get_contents(self::DATA_DIR . self::$i18n . '/content/' . $this->getData(['page', $this->getData(['page',$this->getUrl(0),'barLeft']), 'content']))
									? $this->getPage($this->getData(['page',$this->getUrl(0),'barLeft']), self::$i18n)
									: '',
			]);
		}
		// Importe le module
		else {
			// Id du module, et valeurs en sortie de la page si il s'agit d'un module de page

			if($access AND $this->getData(['page', $this->getUrl(0), 'moduleId'])) {
				$moduleId = $this->getData(['page', $this->getUrl(0), 'moduleId']);
				if( null === $this->getData(['module',$this->getUrl(0),'posts',$this->getUrl(1),'content'])){
					$sub = '';
				} else {
					$sub = substr($this->getData(['module',$this->getUrl(0),'posts',$this->getUrl(1),'content']) ,0,159);
				}
				$this->addOutput([
					'title' => $title,
					// Meta description = 160 premiers caractères de l'article
					'metaDescription' => $this->getData(['page',$this->getUrl(0),'moduleId']) === 'blog' && !empty($this->getUrl(1))
										? strip_tags($sub)
										: $this->getData(['page', $this->getUrl(0), 'metaDescription']),
					'metaTitle' => $this->getData(['page', $this->getUrl(0), 'metaTitle']),
					'typeMenu' => $this->getData(['page', $this->getUrl(0), 'typeMenu']),
					'iconUrl' => $this->getData(['page', $this->getUrl(0), 'iconUrl']),
					'disable' => $this->getData(['page', $this->getUrl(0), 'disable']),
					'contentRight' => $this->getData(['page',$this->getUrl(0),'barRight'])
										//file_get_contents(self::DATA_DIR . self::$i18n . '/content/' . $this->getData(['page', $this->getData(['page',$this->getUrl(0),'barRight']), 'content']))
										//? $this->getPage($this->getData(['page',$this->getUrl(0),'barRight']))
										? $this->getPage($this->getData(['page',$this->getUrl(0),'barRight']), self::$i18n)
										: '',
					'contentLeft'  => $this->getData(['page',$this->getUrl(0),'barLeft'])
										// ? file_get_contents(self::DATA_DIR . self::$i18n . '/content/' . $this->getData(['page', $this->getData(['page',$this->getUrl(0),'barLeft']), 'content']))
										? $this->getPage($this->getData(['page',$this->getUrl(0),'barLeft']), self::$i18n)
										: '',
				]);
				//$pageContent = file_get_contents(self::DATA_DIR . self::$i18n . '/content/' . $this->getData(['page', $this->getUrl(0), 'content']));
				$pageContent = $this->getPage($this->getUrl(0), self::$i18n);
			}
			else {
				$moduleId = $this->getUrl(0);
				$pageContent = '';
			}
			// Check l'existence du module
			if(class_exists($moduleId)) {
				/** @var common $module */
				$module = new $moduleId;

				// Check l'existence de l'action
				$action = '';
				$ignore = true;
				if( null !== $this->getUrl(1)){
					foreach(explode('-', $this->getUrl(1)) as $actionPart) {
						if($ignore) {
							$action .= $actionPart;
							$ignore = false;
						}
						else {
							$action .= ucfirst($actionPart);
						}
					}
				}
				$action = array_key_exists($action, $module::$actions) ? $action : 'index';
				if(array_key_exists($action, $module::$actions)) {
					$module->$action();
					$output = $module->output;
					// Check le groupe de l'utilisateur
					if(
						(
							$module::$actions[$action] === self::GROUP_VISITOR
							OR (
								$this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')
								AND $this->getUser('group') >= $module::$actions[$action]
							)
						)
						AND $output['access'] === true
					) {
						// Enregistrement du contenu de la méthode POST lorsqu'une notice est présente
						if(common::$inputNotices) {
							foreach($_POST as $postId => $postValue) {
								if(is_array($postValue)) {
									foreach($postValue as $subPostId => $subPostValue) {
										self::$inputBefore[$postId . '_' . $subPostId] = $subPostValue;
									}
								}
								else {
									self::$inputBefore[$postId] = $postValue;
								}
							}
						}
						// Sinon traitement des données de sortie qui requiert qu'aucune notice ne soit présente
						else {
							// Notification
							if($output['notification']) {
								if($output['state'] === true) {
									$notification = 'DELTA_NOTIFICATION_SUCCESS';
								}
								elseif($output['state'] === false) {
									$notification = 'DELTA_NOTIFICATION_ERROR';
								}
								else {
									$notification = 'DELTA_NOTIFICATION_OTHER';
								}
								$_SESSION[$notification] = $output['notification'];
							}
							// Redirection
							if($output['redirect']) {
								http_response_code(301);
								header('Location:' . $output['redirect']);
								exit();
							}
						}
						// Données en sortie applicables même lorsqu'une notice est présente
						// Affichage
						if($output['display']) {
							$this->addOutput([
								'display' => $output['display']
							]);
						}
						// Contenu brut
						if($output['content']) {
							$this->addOutput([
								'content' => $output['content']
							]);
						}
						// Contenu par vue
						elseif($output['view']) {
							// Chemin en fonction d'un module du coeur ou d'un module
							$modulePath = in_array($moduleId, self::$coreModuleIds) ? 'core/' : '';
							// CSS
							$stylePath = $modulePath . 'module/' . $moduleId . '/view/' . $output['view'] . '/' . $output['view'] . '.css';
							if(file_exists($stylePath)) {
								$this->addOutput([
									'style' => file_get_contents($stylePath)
								]);
							}
							if ($output['style']) {
								$this->addOutput([
									'style' => $this->output['style'] . file_get_contents($output['style'])
								]);
							}
							// JS
							$scriptPath = $modulePath . 'module/' . $moduleId . '/view/' . $output['view'] . '/' . $output['view'] . '.js.php';
							if(file_exists($scriptPath)) {
								ob_start();
								include $scriptPath;
								$this->addOutput([
									'script' => ob_get_clean()
								]);
							}
							// Vue
							$viewPath = $modulePath . 'module/' . $moduleId . '/view/' . $output['view'] . '/' . $output['view'] . '.php';
							if(file_exists($viewPath)) {
								ob_start();
								include $viewPath;
								$modpos = $this->getData(['page', $this->getUrl(0), 'modulePosition']);
								if ($modpos === 'top') {
									$this->addOutput([
									'content' => ob_get_clean() . ($output['showPageContent'] ? $pageContent : '')]);
								}
								else if ($modpos === 'free') {
									if ( strstr($pageContent, '[MODULE]', true) === false)  {
										$begin = strstr($pageContent, '[]', true); } else {
										$begin = strstr($pageContent, '[MODULE]', true);
									}
									if (  strstr($pageContent, '[MODULE]') === false ) {
										$end = strstr($pageContent, '[]');} else {
										$end = strstr($pageContent, '[MODULE]');
										}
									$cut=8;
									$end=substr($end,-strlen($end)+$cut);
									$this->addOutput([
									'content' => ($output['showPageContent'] ? $begin : '') . ob_get_clean() . ($output['showPageContent'] ? $end : '')]);								}
								else {
									$this->addOutput([
									'content' => ($output['showPageContent'] ? $pageContent : '') . ob_get_clean()]);
								}
							}
						}
						// Librairies
						if($output['vendor'] !== $this->output['vendor']) {
							$this->addOutput([
								'vendor' => array_merge($this->output['vendor'], $output['vendor'])
							]);
						}

						if($output['title'] !== null) {
							$this->addOutput([
								'title' => $output['title']
							]);
						}
						// Affiche le bouton d'édition de la page dans la barre de membre
						if($output['showBarEditButton']) {
							$this->addOutput([
								'showBarEditButton' => $output['showBarEditButton']
							]);
						}
					}
					// Erreur 403
					else {
						$access = false;
					}
				}
			}
		}

		// Erreurs
		// Lexique
		include('./core/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_core.php');

		if($access === 'login') {
			http_response_code(302);
			header('Location:' . helper::baseUrl() . 'user/login/');
			exit();
		}
		if($access === false) {
			if ($accessInfo['userName']) {
				http_response_code(409);
				$this->addOutput([
					'title' => $text['core']['router'][0],
					'content' => template::speech( $text['core']['router'][1] . '<strong>' . $accessInfo['pageId'] . '</strong>'. $text['core']['router'][2] .'<strong>' . $accessInfo['userName'] . '</strong>')
				]);
			} else {
				http_response_code(403);
				$_SESSION['humanBot'] = 'bot';
				if ( $this->getData(['locale','page403']) !== 'none'
					AND $this->getData(['page',$this->getData(['locale','page403'])]))
				{
					header('Location:' . helper::baseUrl() . $this->getData(['locale','page403']));
				} else {
					$this->addOutput([
						'title' => $text['core']['router'][3],
						'content' => template::speech( $text['core']['router'][4] )
					]);
				}
			}
		} elseif ($this->output['content'] === '') {
			http_response_code(404);
			$_SESSION['humanBot'] = 'bot';
			if ( $this->getData(['locale','page404']) !== 'none'
				AND $this->getData(['page',$this->getData(['locale','page404'])]))
			{
				header('Location:' . helper::baseUrl() . $this->getData(['locale','page404']));
			} else {
				$this->addOutput([
					'title' => $text['core']['router'][5],
					'content' => template::speech( $text['core']['router'][6] )
				]);
			}
		}
		// Mise en forme des métas
		if($this->output['metaTitle'] === '') {
			if($this->output['title']) {
				$this->addOutput([
					'metaTitle' => strip_tags($this->output['title']) . ' - ' . $this->getData(['locale', 'title'])
				]);
			}
			else {
				$this->addOutput([
					'metaTitle' => $this->getData(['locale', 'title'])
				]);
			}
		}
		if($this->output['metaDescription'] === '') {
			$this->addOutput([
				'metaDescription' => $this->getData(['locale', 'metaDescription'])
			]);
		};
		switch($this->output['display']) {
			// Layout brut
			case self::DISPLAY_RAW:
				echo $this->output['content'];
				break;
			// Layout vide
			case self::DISPLAY_LAYOUT_BLANK:
				require 'core/layout/blank.php';
				break;
			// Affichage en JSON
			case self::DISPLAY_JSON:
				header('Content-Type: application/json');
				echo json_encode($this->output['content']);
				break;
			// RSS feed
			case self::DISPLAY_RSS:
				header('Content-type: application/rss+xml; charset=UTF-8');
				echo $this->output['content'];
				break;
			// Layout allégé
			case self::DISPLAY_LAYOUT_LIGHT:
				require 'core/layout/light.php';
				break;
			// Layout principal
			case self::DISPLAY_LAYOUT_MAIN:
				require 'core/layout/main.php';
				break;
		}
	}
}
