<?php

/**
 * This file is part of DeltaCMS.
 * @author Sylvain Lelièvre
 * @copyright 2023 © Sylvain Lelièvre
 * @author Lionel Croquefer
 * @copyright 2023 © Lionel Croquefer
 * @license GNU General Public License, version 3
 * @link https://deltacms.fr/
 * @contact https://deltacms.fr/contact
 */

class guestbook extends common {

	const VERSION = '2.6';
	const REALNAME = 'Livre d\'or';
	const DELETE = true;
	const UPDATE = '0.0';
	const DATADIRECTORY = ''; // Dossier pour les données du module communes à toutes les pages l'utilisant

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
	const TYPE_TEXT = 'text';
	const TYPE_TEXTAREA = 'textarea';
	const TYPE_DATETIME = 'date';
	const ITEMSPAGE = 10;

	public static $listUsers = [
	];

	public static $logoWidth = [
		'40' => '40%',
		'60' => '60%',
		'80' => '80%',
		'100' => '100%'
	];

	/**
	 * Mise à jour ou initialisation du module
	 */
	private function update() {
		if( null === $this->getData(['module', $this->getUrl(0), 'config', 'versionData'] )) {
			$this->init();
		} else {
			// Lexique
			$param = '';
			include('./module/guestbook/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_guestbook.php');
			if( version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '2.0', '<') ){
				// Déplacement des 'data' de module.json à .../data_module/nomdelapage.json 'data'
				$this->setData(['data_module', $this->getUrl(0), 'data', $this->getData(['module', $this->getUrl(0), 'data']) ]);
				$this->deleteData(['module', $this->getUrl(0), 'data']);			
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData', '2.0']);
			}
			if( version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '2.2', '<') ){	
				$this->setData([
					'module',
					$this->getUrl(0),
					'texts',
					[
						'send' => $this->getData(['module', $this->getUrl(0), 'config', 'button']) !== '' ? $this->getData(['module', $this->getUrl(0), 'config', 'button']) : $text['guestbook_view']['index'][0],
						'noFields' => $text['guestbook_view']['index'][1],
						'noMessage' => $text['guestbook_view']['index'][3],
						'wrongCaptcha' => $text['guestbook']['index'][0],
						'formSubmitted' => $text['guestbook']['index'][3],
						'failure' => $text['guestbook']['index'][9],
						'date' => $text['guestbook']['index'][10],
						'fillCaptcha' => $text['guestbook']['index'][12],
						'display' => $text['guestbook']['index'][13]
					]
				]);			
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData', '2.2']);
			}
			if( version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '2.4', '<') ){
				if(is_file('./module/guestbook/view/index/index.css')) unlink('./module/guestbook/view/index/index.css');				
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData', '2.4']);
			}
			if( version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '2.5', '<') ){
				$this->setData(['module', $this->getUrl(0), 'config', 'signature', 'text']);
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData', '2.5']);
			}
			if( version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '2.6', '<') ){
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData', '2.6']);
			}			
		}
	}
	
	/**
	 * Initialisation
	 */
	private function init() {
		// Lexique
		$param = '';
		include('./module/guestbook/lang/'. helper::lexlang($this->getData(['config', 'i18n', 'langBase']) , $this->getData(['config', 'i18n', 'langAdmin'])) . '/lex_guestbook.php');
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
				'versionData' => self::VERSION,
				'rgpdCheck' => false
			]
		]);
		$this->setData([
			'module',
			$this->getUrl(0),
			'texts',
			[
				'send' => $text['guestbook_view']['index'][0],
				'noFields' => $text['guestbook_view']['index'][1],
				'noMessage' => $text['guestbook_view']['index'][3],
				'wrongCaptcha' => $text['guestbook']['index'][0],
				'formSubmitted' => $text['guestbook']['index'][3],
				'failure' => $text['guestbook']['index'][9],
				'date' => $text['guestbook']['index'][10],
				'fillCaptcha' => $text['guestbook']['index'][12],
				'display' => $text['guestbook']['index'][13]
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
		if( $group < guestbook::$actions['config'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		} else {
			// Lexique
			$param = '';
			include('./module/guestbook/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_guestbook.php');
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
					[
						'captcha' => $this->getInput('formConfigCaptcha', helper::FILTER_BOOLEAN),
						'group' => $this->getInput('formConfigGroup', helper::FILTER_INT),
						'user' =>  self::$listUsers [$this->getInput('formConfigUser', helper::FILTER_INT)],
						'mail' => $this->getInput('formConfigMail') ,
						'pageId' => $this->getInput('formConfigPageIdToggle', helper::FILTER_BOOLEAN) === true ? $this->getInput('formConfigPageId', helper::FILTER_ID) : '',
						'subject' => $this->getInput('formConfigSubject'),
						'replyto' => $this->getInput('formConfigMailReplyTo', helper::FILTER_BOOLEAN),
						'signature' => $this->getInput('formConfigSignature'),
						'logoUrl' => $this->getInput('formConfigLogo'),
						'logoWidth' => $this->getInput('formConfigLogoWidth'),
						'versionData' => self::VERSION,
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
					'notification' => $text['guestbook']['config'][0],
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
				'title' => $text['guestbook']['config'][1],
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
		if( $group < guestbook::$actions['texts'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			$param = '';
			include('./module/guestbook/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_guestbook.php');
			// Soumission du formulaire
			if($this->isPost()) {
				$this->setData(['module', $this->getUrl(0), 'texts',[
					'send' => $this->getInput('guestbookTextsSend', helper::FILTER_STRING_SHORT),
					'noFields' => $this->getInput('guestbookTextsNoFields', helper::FILTER_STRING_SHORT),
					'wrongCaptcha' => $this->getInput('guestbookTextsWrongCaptcha', helper::FILTER_STRING_SHORT),
					'formSubmitted' => $this->getInput('guestbookTextsFormSubmitted', helper::FILTER_STRING_SHORT),
					'noMessage' => $this->getInput('guestbookTextsNoMessage', helper::FILTER_STRING_SHORT),
					'fillCaptcha' => $this->getInput('guestbookTextsFillCaptcha', helper::FILTER_STRING_SHORT),
					'date' => $this->getInput('guestbookTextsDate', helper::FILTER_STRING_SHORT),
					'failure' => $this->getInput('guestbookTextsFailure', helper::FILTER_STRING_SHORT),
					'display' => $this->getInput('guestbookTextsDisplay', helper::FILTER_STRING_SHORT)
				]]);
			
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['guestbook']['texts'][1],
					'state' => true
				]);
				
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['guestbook']['texts'][0],
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
		if( $group < guestbook::$actions['data'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		} else {
			// Lexique
			$param = '';
			include('./module/guestbook/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_guestbook.php');
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
						$value = str_replace('Д','',$value);
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
				'title' => $text['guestbook']['data'][0],
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
		if( $group < guestbook::$actions['export2csv'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		} else {
			// Lexique
			$param = '';
			include('./module/guestbook/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_guestbook.php');
			// Jeton incorrect
			if ($this->getUrl(2) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . $this->getUrl(0) . '/data',
					'notification' => $text['guestbook']['export2csv'][0]
				]);
			} else {
				$data = $this->getData(['data_module', $this->getUrl(0), 'data']);
				foreach( $data as $key=>$value){
					$data[$key] = str_replace('Д ','',$value);
				}
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
						'notification' => $text['guestbook']['export2csv'][1].$csvfilename,
						'redirect' => helper::baseUrl() . $this->getUrl(0) .'/data',
						'state' => true
					]);
				} else {
					$this->addOutput([
						'notification' => $text['guestbook']['export2csv'][2],
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
		if( $group < guestbook::$actions['deleteall'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		} else {
			// Lexique
			$param = '';
			include('./module/guestbook/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_guestbook.php');
			// Jeton incorrect
			if ($this->getUrl(2) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . $this->getUrl(0) . '/data',
					'notification' => $text['guestbook']['deleteall'][0]
				]);
			} else {
				$data = ($this->getData(['data_module', $this->getUrl(0), 'data']));
				if (count($data) > 0 ) {
					// Suppression multiple
					foreach( $data as $key=>$value ){
						$this->deleteData(['data_module', $this->getUrl(0), 'data', $key]);
					}
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl() . $this->getUrl(0) . '/data',
						'notification' => $text['guestbook']['deleteall'][1],
						'state' => true
					]);
				} else {
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl() . $this->getUrl(0) . '/data',
						'notification' => $text['guestbook']['deleteall'][2]
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
		if( $group < guestbook::$actions['delete'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		} else {
			// Lexique
			$param = '';
			include('./module/guestbook/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_guestbook.php');
			// Jeton incorrect
			if ($this->getUrl(3) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . $this->getUrl(0) . '/data',
					'notification' => $text['guestbook']['delete'][0]
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
						'notification' => $text['guestbook']['delete'][1],
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
		if( null === $this->getData(['module', $this->getUrl(0), 'config', 'versionData']) || version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), self::VERSION, '<') ) $this->update();	
		// Lexique
		$param = '';
		$detectBot ='';
		include('./module/guestbook/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_guestbook.php');
		// Création du brouillon s'il n'existe pas
		if( !isset($_SESSION['draftG'])){
			$_SESSION['draftG'] = [];
			$_SESSION['draftG']['mail'] = "";
			$_SESSION['draftG']['textarea'] = "";
			$_SESSION['draftG']['text'] = [];
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
						if( $time1 >= 5000 && $time2 >= 1000 && $time3 >=300 && $time4 >=300
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
			$textIndex = 0;
			for( $index = 0; $index <= count($this->getData(['module', $this->getUrl(0), 'input'])); $index++){
				switch ($this->getData(['module', $this->getUrl(0), 'input', $index, 'type'])){
					case self::TYPE_MAIL:
						$_SESSION['draftG']['mail'] = $this->getInput('formInput[' . $index . ']',helper::FILTER_MAIL);
						break;
					case self::TYPE_TEXTAREA:
						$_SESSION['draftG']['textarea'] = $this->getInput('formInput[' . $index . ']',helper::FILTER_STRING_LONG_NOSTRIP);
						break;
					case self::TYPE_TEXT:
						$_SESSION['draftG']['text'][$textIndex] = $this->getInput('formInput[' . $index . ']');
						$textIndex++;
						break;
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
				// Préparation des données pour le mail
				if( $value !== '') $content .= '<strong>' . $this->getData(['module', $this->getUrl(0), 'input', $index, 'name']) . ' :</strong> ' . $value . '<br>';
				// Préparation des données pour la création dans la base
				if( $input['type'] === 'mail') $value = 'Д'.' '.$value;
				$data[$this->getData(['module', $this->getUrl(0), 'input', $index, 'name'])] = $value;
			}

			// Bot présumé, la page sera actualisée avec l'affichage du captcha
			if( $detectBot === 'bot') $notice = $this->getData(['module', $this->getUrl(0), 'texts', 'fillCaptcha']);

			// Si absence d'erreur sur la pièce jointe
			$sent = true;
			if( $notice === ''){
				// Crée les données, l'indice des messages est la date unix
				$id = time();
				$this->setData(['data_module', $this->getUrl(0), 'data', $id , $data]);
				// Ajout de la date en clair pour les données dans le json
				if( $this->getData(['config', 'i18n', 'langAdmin']) === 'en' ){
					$dateMessage = date('m/d/Y H:i', $id);
				} else {
					$dateMessage = date('d/m/Y H:i', $id);
				}
				$this->setData(['data_module', $this->getUrl(0), 'data', $id , $this->getData(['module', $this->getUrl(0), 'texts', 'date']) , $dateMessage ]);
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
							$subject = $text['guestbook']['index'][1];
						}
						// Envoi le mail
						$sent = $this->sendMail(
							$to,
							$subject,
							$text['guestbook']['index'][2] . $this->getData(['page', $this->getUrl(0), 'title']) . '" :<br><br>' .
							$content,
							$replyTo
						);
					}
				}

				// Redirection
				$redirect = helper::baseUrl() . $this->getUrl(0);
				if ( $this->getData(['module', $this->getUrl(0), 'config', 'pageId']) !== '') $redirect = helper::baseUrl() . $this->getData(['module', $this->getUrl(0), 'config', 'pageId']);
				// Effacement des données provisoires
				if( self::$inputNotices === [] ){
					$_SESSION['draftG'] = [];
					$_SESSION['draftG']['mail'] = "";
					$_SESSION['draftG']['textarea'] = "";
					$_SESSION['draftG']['text'] = [];
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
		// Préparation de la liste paginée des commentaires
		$data = $this->getData(['data_module', $this->getUrl(0), 'data']);
		if ( NULL !== $data && is_array($data) && $data !== [] ) {
			// Pagination
			$pagination = helper::pagination($data, $this->getUrl(),self::ITEMSPAGE);
			// Liste des pages
			self::$pages = $pagination['pages'];
			// Inverse l'ordre du tableau
			$dataIds = array_reverse(array_keys($data));
			$data = array_reverse($data);
			// Données en fonction de la pagination et suppression des adresses e-mail
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				$content = '';
				foreach($data[$i] as $input => $value) {
					if (!empty($value) && strpos($value, 'Д') === false) $content .= '<div class=\'clef\'>' . $input . '</div> : <div class=\'valeur\'>' . $value . '</div>';
				}
				$horizontalRule = '';
				if( $i < $pagination['last'] - 1) : $horizontalRule = '<hr>';
				else : $horizontalRule = '<br>';
				endif;
				self::$data[] = [
					$content.$horizontalRule
				];
			}
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
