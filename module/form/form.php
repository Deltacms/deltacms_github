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
 
class form extends common {

	const VERSION = '6.2';
	const REALNAME = 'Formulaire';
	const DELETE = true;
	const UPDATE = '0.0';
	const DATADIRECTORY = '';

	public static $actions = [
		'config' => self::GROUP_EDITOR,
		'update' => self::GROUP_EDITOR,
		'data' => self::GROUP_MODERATOR,
		'delete' => self::GROUP_MODERATOR,
		'deleteall' => self::GROUP_MODERATOR,
		'index' => self::GROUP_VISITOR,
		'export2csv' => self::GROUP_MODERATOR,
		'texts' => self::GROUP_MODERATOR
	];

	public static $data = [];

	public static $pages = [];

	public static $pagination;


	// Objets
	const TYPE_MAIL = 'mail';
	const TYPE_SELECT = 'select';
	const TYPE_TEXT = 'text';
	const TYPE_TEXTAREA = 'textarea';
	const TYPE_DATETIME = 'date';
	const TYPE_CHECKBOX = 'checkbox';
	const TYPE_LABEL = 'label';
	const TYPE_FILE = 'file';
	const ITEMSPAGE = 10;

	public static $listUsers = [
	];
	
	public static $logoWidth = [
		'40' => '40%',
		'60' => '60%',
		'80' => '80%',
		'100' => '100%'
	];
	public static $maxSizeUpload = [
		'100000' => '100Ko',
		'200000' => '200Ko',
		'500000' => '500Ko',
		'1000000' => '1Mo',
		'2000000' => '2Mo',
		'5000000' => '5Mo'
	];
	
	/**
	 * Mise à jour du module
	 */
	private function update() {
		// Initialisation
		if( null===$this->getData(['module', $this->getUrl(0), 'config', 'versionData']) ) {
			$this->init();
		} else {		
			// mise à jour vers la version 4.1
			if ( version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '4.1', '<') ) {	
				$this->setData(['module', $this->getUrl(0), 'config', 'uploadJpg',true]);
				$this->setData(['module', $this->getUrl(0), 'config', 'uploadPng',false]);
				$this->setData(['module', $this->getUrl(0), 'config', 'uploadPdf',false]);
				$this->setData(['module', $this->getUrl(0), 'config', 'uploadZip',false]);
				$this->setData(['module', $this->getUrl(0), 'config', 'uploadTxt',false]);
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','4.1']);
			}
			if( version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '6.0', '<') ){
				// Déplacement des données de page de module.json 'data' vers data_module/nom_page.json 'data'
				$this->setData(['data_module', $this->getUrl(0), 'data', $this->getData(['module', $this->getUrl(0), 'data']) ]);
				$this->deleteData(['module', $this->getUrl(0), 'data']);
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData', '6.0']);
			}
			if( version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '6.2', '<') ){
				// Nouvelles variables pour internationalisation
				$param='';
				include('./module/form/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_form.php');
				$button = $this->getData(['module', $this->getUrl(0), 'config', 'button']) !== "" ? $this->getData(['module', $this->getUrl(0), 'config', 'button']) : $text['form_view']['index'][0];
				$this->setData(['module', $this->getUrl(0), 'texts',
					[
					'button' => $button,
					'wrongCaptcha' => $text['form']['init'][0],
					'formSubmitted' => $text['form']['init'][3],
					'notImage' => $text['form']['init'][4],
					'sizeExceeds' => $text['form']['init'][6],
					'notAllowed' => $text['form']['init'][7],
					'errorUploading' => $text['form']['init'][8],
					'notPdf' => $text['form']['init'][10],
					'notZip' => $text['form']['init'][11],
					'fillCaptcha' => $text['form']['init'][12]	
					]
				]);
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData', '6.2']);
			}
		}
	}
	
	/**
	 * Initialisation à la création
	 */
	private function init() {
		$param='';
		include('./module/form/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_form.php');
		$this->setData([
			'module',
			$this->getUrl(0),
			'config',
			[
				'captcha' => true,
				'group' => 4,
				'user' => '',
				'mail' => '',
				'pageId' => '',
				'subject' => '',
				'replyto' => false,
				'signature' => "text",
				'logoUrl' => '',
				'logoWidth' => '40',
				'maxSizeUpload' => "500000",
				'versionData' => self::VERSION,
				'uploadJpg' => false,
				'uploadPng' => false,
				'uploadPdf' => false,
				'uploadZip' => false,
				'uploadTxt' => false,
				'rgpdCheck' => false,
			],
		]);
		$this->setData([
			'module',
			$this->getUrl(0),		
			'texts',
			[
				'button' => $text['form_view']['index'][0],	
				'wrongCaptcha' => $text['form']['init'][0],
				'formSubmitted' => $text['form']['init'][3],
				'notImage' => $text['form']['init'][4],
				'sizeExceeds' => $text['form']['init'][6],
				'notAllowed' => $text['form']['init'][7],
				'errorUploading' => $text['form']['init'][8],
				'notPdf' => $text['form']['init'][10],
				'notZip' => $text['form']['init'][11],
				'fillCaptcha' => $text['form']['init'][12]				
			]
		]);
	}
	
	/**
	 * Configuration
	 */
	public function config() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < form::$actions['config'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = '';
			include('./module/form/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_form.php');
			// Liste des utilisateurs
			$userIdsFirstnames = helper::arrayCollumn($this->getData(['user']), 'firstname');
			ksort($userIdsFirstnames);
			self::$listUsers [] = '';
			foreach($userIdsFirstnames as $userId => $userFirstname) {
				self::$listUsers [] =  $userId;
			}
			// Soumission du formulaire
			if($this->isPost()) {
				// Configuration
				$this->setData([
					'module',
					$this->getUrl(0),
					'config',
					[	'captcha' => $this->getInput('formConfigCaptcha', helper::FILTER_BOOLEAN),
						'group' => $this->getInput('formConfigGroup', helper::FILTER_INT),
						'user' =>  self::$listUsers [$this->getInput('formConfigUser', helper::FILTER_INT)],
						'mail' => $this->getInput('formConfigMail') ,
						'pageId' => $this->getInput('formConfigPageIdToggle', helper::FILTER_BOOLEAN) === true ? $this->getInput('formConfigPageId', helper::FILTER_ID) : '',
						'subject' => $this->getInput('formConfigSubject'),
						'replyto' => $this->getInput('formConfigMailReplyTo', helper::FILTER_BOOLEAN),
						'signature' => $this->getInput('formConfigSignature'),
						'logoUrl' => $this->getInput('formConfigLogo'),
						'logoWidth' => $this->getInput('formConfigLogoWidth'),
						'maxSizeUpload' => $this->getInput('formConfigMaxSize'),
						'versionData' => self::VERSION,
						'uploadJpg' => $this->getInput('formConfigUploadJpg', helper::FILTER_BOOLEAN),
						'uploadPng' => $this->getInput('formConfigUploadPng', helper::FILTER_BOOLEAN),
						'uploadPdf' => $this->getInput('formConfigUploadPdf', helper::FILTER_BOOLEAN),
						'uploadZip' => $this->getInput('formConfigUploadZip', helper::FILTER_BOOLEAN),
						'uploadTxt' => $this->getInput('formConfigUploadTxt', helper::FILTER_BOOLEAN),
						'rgpdCheck' => $this->getInput('formConfigRgpdCheck', helper::FILTER_BOOLEAN)
					]
				]);
				// Génération des données vides
				if ($this->getData(['data_module', $this->getUrl(0), 'data']) === null) {
					$this->setData(['data_module', $this->getUrl(0), 'data', []]);
				}
				// Génération des champs
				$inputs = [];
				foreach($this->getInput('formConfigPosition', null) as $index => $position) {
					$inputs[] = [
						'name' => htmlspecialchars_decode($this->getInput('formConfigName[' . $index . ']'),ENT_QUOTES),
						'position' => helper::filter($position, helper::FILTER_INT),
						'required' => $this->getInput('formConfigRequired[' . $index . ']', helper::FILTER_BOOLEAN),
						'type' => $this->getInput('formConfigType[' . $index . ']'),
						'values' => $this->getInput('formConfigValues[' . $index . ']')
					];
				}
				$this->setData(['module', $this->getUrl(0), 'input', $inputs]);
				// Valeurs en sortie
				$this->addOutput([
					'notification' => $text['form']['config'][0],
					'redirect' => helper::baseUrl() . $this->getUrl(),
					'state' => true
				]);
			}
			// Liste des pages
			foreach($this->getHierarchy(null, false) as $parentPageId => $childrenPageIds) {
				self::$pages[$parentPageId] = $this->getData(['page', $parentPageId, 'title']);
				foreach($childrenPageIds as $childKey) {
					self::$pages[$childKey] = '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->getData(['page', $childKey, 'title']);
				}
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['form']['config'][1],
				'vendor' => [
					'html-sortable',
					'flatpickr'
				],
				'view' => 'config'
			]);
		}
	}
	
	/**
	 * Textes pour internationalisation
	 */
	public function texts() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < form::$actions['texts'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = '';
			include('./module/form/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_form.php');
			// Soumission du formulaire
			if($this->isPost()) {
				$this->setData(['module', $this->getUrl(0), 'texts',[
					'button' => $this->getInput('formTextsButton',helper::FILTER_STRING_SHORT),
					'wrongCaptcha' => $this->getInput('formTextsWrongCaptcha',helper::FILTER_STRING_SHORT),
					'formSubmitted' => $this->getInput('formTextsFormSubmitted',helper::FILTER_STRING_SHORT),
					'notImage' => $this->getInput('formTextsNotImage',helper::FILTER_STRING_SHORT),
					'sizeExceeds' => $this->getInput('formTextsSizeExceeds',helper::FILTER_STRING_SHORT),
					'notAllowed' => $this->getInput('formTextsNotAllowed',helper::FILTER_STRING_SHORT),
					'errorUploading' => $this->getInput('formTextsErrorUploading',helper::FILTER_STRING_SHORT),
					'notPdf' => $this->getInput('formTextsNotPdf',helper::FILTER_STRING_SHORT),
					'notZip' => $this->getInput('formTextsNotZip',helper::FILTER_STRING_SHORT),
					'fillCaptcha' => $this->getInput('formTextsFillCaptcha',helper::FILTER_STRING_SHORT)
				]]);
			
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['form']['texts'][1],
					'state' => true
				]);
				
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['form']['texts'][0],
				'vendor' => [
					'html-sortable',
					'flatpickr'
				],
				'view' => 'texts'
			]);
		}
	}

	/**
	 * Données enregistrées
	 */
	public function data() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < form::$actions['data'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = '';
			include('./module/form/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_form.php');
			$data = $this->getData(['data_module', $this->getUrl(0), 'data']);
			if($data) {
				// Pagination
				$pagination = helper::pagination($data, $this->getUrl(),self::ITEMSPAGE);
				// Liste des pages
				self::$pages = $pagination['pages'];
				// Inverse l'ordre du tableau
				$dataIds = array_reverse(array_keys($data));
				$data = array_reverse($data);
				// Données en fonction de la pagination
				for($i = $pagination['first']; $i < $pagination['last']; $i++) {
					$content = '';
					foreach($data[$i] as $input => $value) {
						$content .= $input . ' : ' . $value . '<br>';
					}
					self::$data[] = [
						$content,
						template::button('formDataDelete' . $dataIds[$i], [
							'class' => 'formDataDelete buttonRed',
							'href' => helper::baseUrl() . $this->getUrl(0) . '/delete/' . $dataIds[$i]  . '/' . $_SESSION['csrf'],
							'value' => template::ico('cancel')
						])
					];
				}
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['form']['data'][0],
				'view' => 'data'
			]);
		}
	}

	/**
	 * Export CSV
	 */
	public function export2csv() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < form::$actions['export2csv'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = '';
			include('./module/form/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_form.php');	
			// Jeton incorrect
			if ($this->getUrl(2) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . $this->getUrl(0) . '/data',
					'notification' => $text['form']['export2csv'][0]
				]);
			} else {
				$data = $this->getData(['data_module', $this->getUrl(0), 'data']);
				if ($data !== []) {
					$csvfilename = 'data-'.date('dmY').'-'.date('Hi').'-'.rand(10,99).'.csv';
					if (!file_exists(self::FILE_DIR.'source/data')) {
						mkdir(self::FILE_DIR.'source/data', 0755);
					}
					$fp = fopen(self::FILE_DIR.'source/data/'.$csvfilename, 'w');
					// Récupérer les bonnes clefs
					foreach($data as $key=>$value){
						$tabdata = array_keys($data[$key]);
						break;
					}
					fputcsv($fp, $tabdata, ';','"');
					foreach ($data as $fields) {
						fputcsv($fp, $fields, ';','"');
					}
					fclose($fp);
					// Valeurs en sortie
					$this->addOutput([
						'notification' => $text['form']['export2csv'][1].$csvfilename,
						'redirect' => helper::baseUrl() . $this->getUrl(0) .'/data',
						'state' => true
					]);
				} else {
					$this->addOutput([
						'notification' => $text['form']['export2csv'][2],
						'redirect' => helper::baseUrl() . $this->getUrl(0) .'/data'
					]);
				}
			}
		}
	}


	/**
	 * Suppression
	 */
	public function deleteall() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < form::$actions['deleteall'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = '';
			include('./module/form/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_form.php');
			// Jeton incorrect
			if ($this->getUrl(2) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . $this->getUrl(0) . '/data',
					'notification' => $text['form']['deleteall'][0]
				]);
			} else {
				$data = ($this->getData(['data_module', $this->getUrl(0), 'data']));
				if (count($data) > 0 ) {
					// Suppression multiple
					$this->setData(['data_module', $this->getUrl(0), 'data', [] ]);
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl() . $this->getUrl(0) . '/data',
						'notification' => $text['form']['deleteall'][1],
						'state' => true
					]);
				} else {
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl() . $this->getUrl(0) . '/data',
						'notification' => $text['form']['deleteall'][2]
					]);
				}
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
		if( $group < form::$actions['delete'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = '';
			include('./module/form/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_form.php');
			// Jeton incorrect
			if ($this->getUrl(3) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . $this->getUrl(0) . '/data',
					'notification' => $text['form']['delete'][0]
				]);
			} else {
				// La donnée n'existe pas
				if($this->getData(['data_module', $this->getUrl(0), 'data', $this->getUrl(2)]) === null) {
					// Valeurs en sortie
					$this->addOutput([
						'access' => false
					]);
				}
				// Suppression
				else {
					$this->deleteData(['data_module', $this->getUrl(0), 'data', $this->getUrl(2)]);
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl() . $this->getUrl(0) . '/data',
						'notification' => $text['form']['delete'][1],
						'state' => true
					]);
				}
			}
		}
	}




	/**
	 * Accueil
	 */
	public function index() {
		// Mise à jour du module
		if( null === $this->getData(['module', $this->getUrl(0), 'config', 'versionData']) ||  version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), self::VERSION, '<') ) $this->update();
		// Lexique
		$param = '';
		$detectBot ='';
		include('./module/form/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_form.php');
		// Création du brouillon s'il n'existe pas
		if( !isset($_SESSION['draft'])){
			$_SESSION['draft'] = [];
			$_SESSION['draft']['mail'] = "";
			$_SESSION['draft']['textarea'] = "";
			$_SESSION['draft']['datetime'] = null;
			$_SESSION['draft']['checkbox'] = [];
			$_SESSION['draft']['select'] = [];
			$_SESSION['draft']['text'] = [];
			$_SESSION['draft']['file'] = "";			
		}
		// Soumission du formulaire
		if($this->isPost()) {
			// $notice concerne la pièce jointe et le captcha
			$notice = '';
			$code = isset($_REQUEST['codeCaptcha'] ) ? strtoupper($_REQUEST['codeCaptcha']) : '';
			// Captcha demandée
			if(	$this->getData(['module', $this->getUrl(0), 'config', 'captcha'])){
				// option de détection de robot en premier cochée et $_SESSION['humanBot']==='human'
				if(	$_SESSION['humanBot']==='human' && $this->getData(['config', 'connect', 'captchaBot'])=== true ) {
					// Présence des 6 cookies et checkbox cochée ?
					$detectBot ='bot';
					if ( isset ($_COOKIE['evtC']) && isset ($_COOKIE['evtO']) && isset ($_COOKIE['evtV']) && isset ($_COOKIE['evtH']) 
						&& isset ($_COOKIE['evtS']) && isset ($_COOKIE['evtA']) && $this->getInput('formHumanCheck', helper::FILTER_BOOLEAN) === true ) {
						// Calcul des intervals de temps
						$time1 = $_COOKIE['evtC'] - $_COOKIE['evtO']; // temps entre fin de saisie et ouverture de la page
						$time2 = $_COOKIE['evtH'] - $_COOKIE['evtO']; // temps entre click checkbox et ouverture de la page
						$time3 = $_COOKIE['evtV'] - $_COOKIE['evtH']; // temps entre validation formulaire et click checkbox
						$time4 = $_COOKIE['evtS'] - $_COOKIE['evtA']; // temps passé sur la checkbox
						if( $time1 >= 5000 && $time2 >= 1000 && $time3 >=300 && $time4 >=100 
							&& $this->getInput('formInputBlue')==='' ) $detectBot = 'human';
					}
					// Bot présumé
					if( $detectBot === 'bot') $_SESSION['humanBot']='bot';
				}
				// $_SESSION['humanBot']==='bot' ou option 'Pas de Captcha pour un humain' non validée
				elseif( md5($code) !== $_SESSION['captcha'] ) {
					$notice = $this->getData(['module', $this->getUrl(0), 'texts', 'wrongCaptcha']);
				}
			}
			
			// Mise à jour du brouillon
			$textIndex = 0; $selectIndex=0; $checkboxIndex=0;
			for( $index = 0; $index <= count($this->getData(['module', $this->getUrl(0), 'input'])); $index++){
				switch ($this->getData(['module', $this->getUrl(0), 'input', $index, 'type'])){
					case self::TYPE_MAIL:
						$_SESSION['draft']['mail'] = $this->getInput('formInput[' . $index . ']',helper::FILTER_MAIL);
						break;
					case self::TYPE_TEXTAREA:
						$_SESSION['draft']['textarea'] = $this->getInput('formInput[' . $index . ']',helper::FILTER_STRING_LONG_NOSTRIP);
						break;
					case self::TYPE_DATETIME:
						$dateTime = time();
						if( $this->getInput('formInput[' . $index . ']') !== "" && $this->getInput('formInput[' . $index . ']') !== null) $dateTime = $this->getInput('formInput[' . $index . ']',helper::FILTER_DATETIME, true);
						$_SESSION['draft']['datetime'] = $dateTime;
						break;
					case self::TYPE_CHECKBOX:
						$_SESSION['draft']['checkbox'][$checkboxIndex] = $this->getInput('formInput[' . $index . ']',helper::FILTER_BOOLEAN);
						$checkboxIndex++;
						break;
					case self::TYPE_SELECT:
						$_SESSION['draft']['select'][$selectIndex] = $this->getInput('formInput[' . $index . ']');
						$selectIndex++;
						break;
					case self::TYPE_TEXT:
						$_SESSION['draft']['text'][$textIndex] = $this->getInput('formInput[' . $index . ']');
						$textIndex++;
						break;
					case self::TYPE_FILE:
						$_SESSION['draft']['file'] = basename($_FILES["fileToUpload"]["name"]);
						break;
					default:
						$filter = helper::FILTER_STRING_SHORT;						
				}
			}
			
			// Ajout d'une notice sur la case à cocher d'acceptation des conditions si elle est utilisée et non cochée 
			if(	$this->getData(['module', $this->getUrl(0), 'config', 'rgpdCheck'])) $rgpdCheckbox = $this->getInput('formRgpdCheck', helper::FILTER_BOOLEAN,true);
			
			// Préparation du contenu du mail
			$data = [];
			$replyTo = null;
			$content = '';
			$file_name = '';			
			foreach($this->getData(['module', $this->getUrl(0), 'input']) as $index => $input) {

				$filter = helper::FILTER_STRING_SHORT;
				if( $input['type'] === 'textarea') $filter = helper::FILTER_STRING_LONG_NOSTRIP;
				
				$value = $this->getInput('formInput[' . $index . ']', $filter, $input['required']) === true ? 'X' : $this->getInput('formInput[' . $index . ']', $filter, $input['required']);
				//  premier champ email ajouté au mail en reply si option active
				if ($this->getData(['module', $this->getUrl(0), 'config', 'replyto']) === true &&
					$input['type'] === 'mail') {
					$replyTo = $value;
                }
				
				// Traitement de la pièce jointe, fichier avec extension valide de taille maximum $sizeMax
				// Fichier chargé dans site/file/uploads/ et effacé après l'envoi du mail
				if( $input['type'] === 'file'){
					$target_dir = self::FILE_DIR.'uploads';
					$sizeMax = $this->getData(['module', $this->getUrl(0), 'config', 'maxSizeUpload']);
					$extensions_valides = [];
					if( $this->getData(['module', $this->getUrl(0), 'config', 'uploadJpg']) === true ) $extensions_valides = array_merge( $extensions_valides, array('jpg', 'jpeg')); 
					if( $this->getData(['module', $this->getUrl(0), 'config', 'uploadPng']) === true ) $extensions_valides = array_merge( $extensions_valides, array('png'));
					if( $this->getData(['module', $this->getUrl(0), 'config', 'uploadPdf']) === true ) $extensions_valides = array_merge( $extensions_valides, array('pdf'));
					if( $this->getData(['module', $this->getUrl(0), 'config', 'uploadZip']) === true ) $extensions_valides = array_merge( $extensions_valides, array('zip'));
					if( $this->getData(['module', $this->getUrl(0), 'config', 'uploadTxt']) === true ) $extensions_valides = array_merge( $extensions_valides, array('txt'));										
					$extensions_images = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
					$file_name = basename($_FILES["fileToUpload"]["name"]);
					if( $_FILES["fileToUpload"]["error"] === 0){
						if($file_name !== '' && $file_name !== null){
							if( ! is_dir( $target_dir )) mkdir( $target_dir, 0744);
							// Copie du fichier .htaccess depuis module/form/ressource
							copy('./module/form/ressource/.htaccess', $target_dir.'/.htaccess');
							$target_file = $target_dir .'/'. $file_name;
							$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

							// Vérification que la pièce jointe est une image quand son extension est celle d'une image
							if( $_FILES["fileToUpload"]["tmp_name"] !== '' && $_FILES["fileToUpload"]["tmp_name"] !== null
								&& in_array($imageFileType,$extensions_images)){
								$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
								if($check === false) $notice = $this->getData(['module', $this->getUrl(0), 'texts', 'notImage']);
							}
							
							// Vérification que la pièce jointe est un fichier pdf quand son extension est pdf
							if( $_FILES["fileToUpload"]["tmp_name"] !== '' && $_FILES["fileToUpload"]["tmp_name"] !== null
								&& $imageFileType === 'pdf'){
								$check = true;
								$signature_pdf = array( '%PDF-', 'startxref', '%%EOF');
								$filepdf = file_get_contents( $_FILES["fileToUpload"]["tmp_name"]);
								foreach( $signature_pdf as $key=>$value){
									if( strpos( $filepdf, $value) === false){
										$check = false;
										break;
									}
								}
								if($check === false) $notice = $this->getData(['module', $this->getUrl(0), 'texts', 'notPdf']);
							}
							
							// Vérification que la pièce jointe est un fichier zip quand son extension est zip
							if( $_FILES["fileToUpload"]["tmp_name"] !== '' && $_FILES["fileToUpload"]["tmp_name"] !== null
								&& $imageFileType === 'zip'){
								$zip = new ZipArchive;
								$res = $zip->open($_FILES["fileToUpload"]["tmp_name"]);
								if ($res !== true) $notice = $this->getData(['module', $this->getUrl(0), 'texts', 'notZip']);
							}							

							// Vérification de la taille du fichier
							if ($_FILES["fileToUpload"]["size"] > $sizeMax) $notice = $this->getData(['module', $this->getUrl(0), 'texts', 'sizeExceeds']).' '.intval($sizeMax/1000).' Ko';

							// Vérification des types de fichiers autorisés
							if( ! in_array($imageFileType,$extensions_valides) ) $notice = $this->getData(['module', $this->getUrl(0), 'texts', 'notAllowed']);

							// Upload du fichier
							if ($notice === '') {
							  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
								$value = $file_name;
							  } else {
								$notice = $this->getData(['module', $this->getUrl(0), 'texts', 'errorUploading']);
							  }
							}
						}
					} else {
						switch($_FILES["fileToUpload"]["error"]) {
							case 2 :
								$notice = $this->getData(['module', $this->getUrl(0), 'texts', 'sizeExceeds']).' MAX_FILE_SIZE : 5Mo';
								break;
						}
					}
				}
								
				// Préparation des données pour la création dans la base
				$data[$this->getData(['module', $this->getUrl(0), 'input', $index, 'name'])] = $value;
				// Préparation des données pour le mail
				if( $value !== '') $content .= '<strong>' . $this->getData(['module', $this->getUrl(0), 'input', $index, 'name']) . ' :</strong> ' . $value . '<br>';
			}
			
			// Bot présumé, la page sera actualisée avec l'affichage du captcha
			if( $detectBot === 'bot' ) $notice = $this->getData(['module', $this->getUrl(0), 'texts', 'fillCaptcha']);
			
			// Si absence d'erreur sur la pièce jointe
			$sent = true;
			if( $notice === ''){
				// Crée les données
				if( null !== $this->getData(['data_module', $this->getUrl(0), 'data']) ) {
					$this->setData(['data_module', $this->getUrl(0), 'data', helper::increment(1, $this->getData(['data_module', $this->getUrl(0), 'data'])), $data]);
				} else {
					$this->setData(['data_module', $this->getUrl(0), 'data', 1, $data]);
				}
				// Emission du mail
				// Rechercher l'adresse en fonction du mail
				$singleuser = $this->getData(['user',
											  $this->getData(['module', $this->getUrl(0), 'config', 'user']),
											  'mail']);
				$singlemail = $this->getData(['module', $this->getUrl(0), 'config', 'mail']);
				$group = $this->getData(['module', $this->getUrl(0), 'config', 'group']);
				// Verification si le mail peut être envoyé
				if(
					self::$inputNotices === [] && (
						$group > 0 ||
						$singleuser !== '' ||
						$singlemail !== '' )
				) {
					// Utilisateurs dans le groupe
					$to = [];
					if ($group > 0){
						foreach($this->getData(['user']) as $userId => $user) {
							if($user['group'] >= $group) {
								$to[] = $user['mail'];
							}
						}
					}
					// Utilisateur désigné
					if (!empty($singleuser)) {
						$to[] = $singleuser;
					}
					// Mail désigné
					if (!empty($singlemail)) {
						$to[] = $singlemail;
					}
					if($to) {
						// Sujet du mail
						$subject = $this->getData(['module', $this->getUrl(0), 'config', 'subject']);
						if($subject === '') {
							$subject = $text['form']['index'][1];
						}
						// Envoi le mail
						$sent = $this->sendMail(
							$to,
							$subject,
							$text['form']['index'][2] . $this->getData(['page', $this->getUrl(0), 'title']) . '" :<br><br>' .
							$content,
							$replyTo,
							$file_name
						);
					}
				}
				// Nettoyage du dossier self::FILE_DIR.uploads
				$FilesUpload = glob( self::FILE_DIR.'uploads/*'); 
				foreach($FilesUpload as $file) {   
					if(is_file($file)) unlink($file); 
				}
				// Redirection
				$redirect = helper::baseUrl() . $this->getUrl(0);
				if ( $this->getData(['module', $this->getUrl(0), 'config', 'pageId']) !== '') $redirect = helper::baseUrl() . $this->getData(['module', $this->getUrl(0), 'config', 'pageId']);
				// Effacement des données provisoires
				if( self::$inputNotices === [] ){
					$_SESSION['draft'] = [];
					$_SESSION['draft']['mail'] = "";
					$_SESSION['draft']['textarea'] = "";
					$_SESSION['draft']['datetime'] = null;
					$_SESSION['draft']['checkbox'] = [];
					$_SESSION['draft']['select'] = [];
					$_SESSION['draft']['text'] = [];
					$_SESSION['draft']['file'] = "";					
				}
			} else {
				$sent = false;	
			}
				
			// Valeurs en sortie
			if( $sent !== true) {
				$_SESSION['humanBot']='bot';
				$redirect = helper::baseUrl() . $this->getUrl(0);
			}
			$this->addOutput([
				'notification' => ($sent === true ? $this->getData(['module', $this->getUrl(0), 'texts', 'formSubmitted']) : $notice),
				'redirect' => $redirect,
				'state' => ($sent === true ? true : false),
				'vendor' => [
					'flatpickr',
					'tinymce'
				]
			]);
		}
		
		// Valeurs en sortie
		$this->addOutput([
			'showBarEditButton' => true,
			'showPageContent' => true,
			'view' => 'index',
			'vendor' => [
				'flatpickr',
				'tinymce'
			],
		]);
	}
}
