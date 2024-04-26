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
 *
 * Module StatisLite, un analyseur d'audience léger
 * @author Sylvain Lelièvre <lelievresylvain@free.fr>
 * @copyright Copyright (C) 2020, Sylvain Lelièvre
 */

class statislite extends common {

	public static $actions = [
		'config' => self::GROUP_EDITOR,
		'advanced' => self::GROUP_EDITOR,
		'initJson' => self::GROUP_EDITOR,
		'initDownload' => self::GROUP_EDITOR,
		'sauveJson' => self::GROUP_EDITOR,
		'index' => self::GROUP_VISITOR,
		'conversionTime' => self::GROUP_VISITOR
	];
	
	const VERSION = '5.0';	
	const REALNAME = 'Statislite';
	const DELETE = true;
	const UPDATE = '2.6';
	const DATADIRECTORY = self::DATA_DIR.'statislite/';
	
	// Dossier des données externes à module.json
	const DATAMODULE = self::DATA_DIR.'statislite/module';

	// Variables transmises à view/index/index.php
	public static $datedebut;
	public static $comptepages = 0;
	public static $comptevisite = 0;
	public static $dureevisites = 0;
	public static $comptepagestotal = 0;
	public static $comptevisitetotal = 0;
	public static $dureevisitestotal = 0;
	public static $dureevisitemoyenne = 0;
	public static $pagesvuesaffi = [];
	public static $scoremax = 0;
	public static $languesaffi = [];
	public static $scoremaxlangues = 0;
	public static $navigateursaffi = [];
	public static $scoremaxnavi = 0;	
	public static $systemesaffi = [];
	public static $scoremaxse = 0;
	public static $chronoaffi = [];
	public static $affidetaille = [];
	// Initialisation des 3 dossiers json déclarés dans index.php car incluant self::$i18n
	public static $fichiers_json = '';
	public static $json_sauve = '';
	public static $tmp = '';
	public static $base = self::DATAMODULE.'/';
	public static $downloadLink = self::DATAMODULE.'/download_counter/';
	public static $filtres_primaires = self::DATAMODULE.'/filtres_primaires/';
	public static $filesSaved = [];
	
	// Variables transmises à view/advanced/advanced.php
	public static $listeIP = '';
	public static $listeQS = '';
	public static $listeBot = '';
	public static $listePages = [];
	public static $yourIP = '';
	
	// Temps entre 2 mises à jour de cumul.json et chrono.json (11 minutes)
	public static $timemaj = 660;
	
	/**
	 * Mise à jour du module
	 * Appelée par les fonctions index et config
	*/
	private function update() {

		// Installation ou mise à jour vers la version 4.4
		if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '4.4', '<') ) {		
			if( file_exists("./site/data/statislite/module/json/.htaccess") ) unlink("./site/data/statislite/module/json/.htaccess");
			if( file_exists("./site/data/statislite/module/json_sauve/.htaccess") ) unlink("./site/data/statislite/module/json_sauve/.htaccess");
			copy('./module/statislite/ressource/tmp/.htaccess', self::DATAMODULE.'/tmp/.htaccess');
			$this->setData(['module', $this->getUrl(0), 'config', 'versionData','4.4']);
		}
		// Version 4.7
		if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '4.7', '<') ) {	
			if( !is_dir( self::DATAMODULE.'/download_counter' ))mkdir( self::DATAMODULE.'/download_counter', 0755);
			copy('./module/statislite/ressource/download_counter/download_counter.php', self::DATAMODULE.'/download_counter/download_counter.php');
			$this->setData(['module', $this->getUrl(0), 'config', 'versionData','4.7']);
		}
		// Version 4.9
		if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '4.9', '<') ) {	
			if( !is_dir( self::DATAMODULE.'/download_counter' ))mkdir( self::DATAMODULE.'/download_counter', 0755);
			copy('./module/statislite/ressource/download_counter/download_counter.php', self::DATAMODULE.'/download_counter/download_counter.php');
			$this->setData(['module', $this->getUrl(0), 'config', 'versionData','4.9']);
		}
		// Version 5.0
		if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '5.0', '<') ) {	
			// copier les 3 dossiers json, json_sauve et tmp de site/data/statislite/module/ vers site/data/base/data_module/statislite/
			if( !is_dir('./site/data/base/data_module/statislite')) mkdir('./site/data/base/data_module/statislite');
			$this->custom_copy('site/data/statislite/module/json', 'site/data/base/data_module/statislite/json');
			$this->custom_copy('site/data/statislite/module/json_sauve', 'site/data/base/data_module/statislite/json_sauve');
			$this->custom_copy('site/data/statislite/module/tmp', 'site/data/base/data_module/statislite/tmp');
			$this->removeDir('site/data/statislite/module/json');
			$this->removeDir('site/data/statislite/module/json_sauve');
			$this->removeDir('site/data/statislite/module/tmp');
			$this->setData(['module', $this->getUrl(0), 'config', 'versionData','5.0']);
		}
	}
	
	/**
	 * Configuration
	 */
	public function config() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < statislite::$actions['config'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/statislite/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_statislite.php');
			// Initialisations des dossiers des json
			self::$fichiers_json = self::DATA_DIR.self::$i18n.'/data_module/statislite/json/';
			self::$tmp = self::DATA_DIR.self::$i18n.'/data_module/statislite/tmp/';
			self::$json_sauve = self::DATA_DIR.self::$i18n.'/data_module/statislite/json_sauve/';	
			// Détection d'un changement de nom de la page statistique pour mettre à jour listeQS
			if( is_file( self::$fichiers_json.'filtre_primaire.json')){
				$json = file_get_contents(self::$fichiers_json.'filtre_primaire.json');
				$fp = json_decode($json, true);
				$PageStat = 0;
				if(isset( $fp['listeQS'])){
					if( ! empty($fp['listeQS'])){
						foreach( $fp['listeQS'] as $key=>$PageQS){
							if( $PageQS == $this->getUrl(0) ) $PageStat = 1;
						}
					}
					if( $PageStat === 0 ){
						$fp['listeQS'][count($fp['listeQS'])] = $this->getUrl(0);
						// Suppression des pages inconnues de la listeQS
						$i=0;
						foreach($this->getData(['page']) as $key=>$page){
							self::$listePages[$i] = $this->getData(['page', $key, 'title']);
							$i++;
						}
						foreach( $fp['listeQS'] as $keyQS=>$PageQS){
							$noexist = true;
							foreach( self::$listePages as $keyPage=>$Page){
								$Pagemod = strtolower(str_replace(' ','-',$Page));
								if( $PageQS === $Pagemod) $noexist = false;
							}
							if( $noexist ) unset( $fp['listeQS'][$keyQS]);
						}
					}
				}
			}
			else{
				$json = '{}';
				$fp= json_decode($json, true);
				$fp['robots'] = array( 'ua' => 0, 'ip'=> 0);
				$fp['listeIP'] = [];
				$fp['listeQS'] = array( 0 => $this->getUrl(0));
				$fp['listeBot'] = [];			
			}
			$json = json_encode($fp);
			file_put_contents(self::$fichiers_json.'filtre_primaire.json',$json);	
			
			// Soumission du formulaire
			if($this->isPost()) {
				$this->setData(['module', $this->getUrl(0), 'config',[
					'timeVisiteMini' => $this->getInput('statisliteConfigTimeVisiteMini', helper::FILTER_STRING_SHORT, true),
					'timePageMini' => $this->getInput('statisliteConfigTimePageMini', helper::FILTER_STRING_SHORT, true),
					'nbPageMini' => $this->getInput('statisliteConfigNbPageMini', helper::FILTER_STRING_SHORT, true),
					'usersExclus' => $this->getInput('statisliteConfigUsersExclus', helper::FILTER_STRING_SHORT, true),
					'nbEnregSession' => $this->getInput('statisliteConfigNbEnregSession', helper::FILTER_STRING_SHORT, true),
					'geolocalisation' => $this->getInput('statisliteConfigGeolocalisation', helper::FILTER_BOOLEAN),
					'nbaffipagesvues' => $this->getInput('statisliteConfigNbAffiPagesVues'), 
					'nbaffilangues' => $this->getInput('statisliteConfigNbAffiLangues'), 
					'nbaffinavigateurs' => $this->getInput('statisliteConfigNbAffiNavigateurs'),
					'nbaffise' => $this->getInput('statisliteConfigNbAffiSe'),
					'nbaffipays' => $this->getInput('statisliteConfigNbAffiPays'),
					'nbaffidates' => $this->getInput('statisLiteConfigNbAffiDates'),
					'config' => true,
					'versionData' => $this->getData(['module', $this->getUrl(0), 'config', 'versionData'])
				]]);
				// Validation des statistiques
				$this->setData(['config', 'statislite', 'enable', true]);
				
				// Mise à jour forcée des fichiers navigateurs.txt, systemes.txt et langages.txt
				$majForce = $this->getInput('statisliteConfigMajForce', helper::FILTER_BOOLEAN);
				if( $majForce === true ){
					copy( './module/statislite/ressource/navigateurs.txt', self::$base.'navigateurs.txt');
					copy( './module/statislite/ressource/langages.txt', self::$base.'langages.txt');
					copy( './module/statislite/ressource/systemes.txt', self::$base.'systemes.txt');
				}

				// Restauration si le fichier sélectionné est un fichier cumul.json
				$file_cumul = $this->getInput('configRestoreJson', helper::FILTER_STRING_SHORT);
				if( strpos( $file_cumul, 'cumul.json' ) === 15){
					// Sauvegarde de sécurité des fichiers json
					$this->sauvegardeJson();
					$date = substr( $file_cumul, 0 , 15);
					$nameFile = [ '0'=>'cumul.json', '1'=>'affitampon.json', '2'=>'chrono.json', '3'=>'robots.json', '4'=>'sessionInvalide.json', '5'=>'sessionLog.json',   ];
					foreach( $nameFile as $key=>$file){
						if( is_file( self::$json_sauve.$date.$file )){
							file_put_contents(self::$fichiers_json.$file, file_get_contents(self::$json_sauve.$date.$file));
						}
					}
				}
			
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl().$this->getUrl(),
					'notification' => $text['statislite']['config'][1],
					'state' => true
				]);
			}
			else{
				// Liste des fichiers de sauvegarde
				if(is_dir( self::$json_sauve )) {
					$dir = self::$json_sauve;
					self::$filesSaved = scandir($dir);
					//Ne conserver que les fichiers xxxxxxxxx_cumul.json
					foreach( self::$filesSaved as $key=>$val){
						if( strpos($val, 'cumul.json') === false){
							unset( self::$filesSaved[$key]);
						}	
					}
					if (count(self::$filesSaved) === 0 ){
						self::$filesSaved = array(0 => $text['statislite']['config'][2]);
					}
					else{
						self::$filesSaved[0] = $text['statislite']['config'][0];
						// clef = valeur pour renvoyer le nom du fichier et non la clef de type numméro
						self::$filesSaved= array_combine(self::$filesSaved,self::$filesSaved);
					}
				}
				else {
					self::$filesSaved = array(0 => $text['statislite']['config'][3]);
				}
				// Valeurs en sortie
				$this->addOutput([
					'title' => $text['statislite']['config'][4],
					'view' => 'config'
				]);
			}
		}
	}
	
	/**
	 * Configuration avancée
	 */
	public function advanced() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < statislite::$actions['advanced'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/statislite/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_statislite.php');
			// Initialisations des dossiers des json
			self::$fichiers_json = self::DATA_DIR.self::$i18n.'/data_module/statislite/json/';
			self::$tmp = self::DATA_DIR.self::$i18n.'/data_module/statislite/tmp/';
			self::$json_sauve = self::DATA_DIR.self::$i18n.'/data_module/statislite/json_sauve/';
			// Liste des pages du site
			$i=0;
			foreach($this->getData(['page']) as $key=>$page){
				self::$listePages[$i] = $this->getData(['page', $key, 'title']);
				$i++;
			}

			// Retour de formulaire
			if($this->isPost()) {
				// Lecture des données postées bloc IP
				$addIP = $this->getInput('statisliteAddIp', helper::FILTER_BOOLEAN);
				$supIP = $this->getInput('statisliteSupIp', helper::FILTER_BOOLEAN);
				$addressIP = $this->getInput('statisliteEditIP', helper::FILTER_STRING_SHORT);
				// Bloc Pages
				$addQS = $this->getInput('statisliteAddQS', helper::FILTER_BOOLEAN);
				$supQS = $this->getInput('statisliteSupQS', helper::FILTER_BOOLEAN);
				$pageQS = self::$listePages[$this->getInput('statisliteEditQS', helper::FILTER_STRING_SHORT)];
				$pageQS = strtolower(str_replace(' ', '-', $pageQS));
				// Bloc robots
				$addBot = $this->getInput('statisliteAddBot', helper::FILTER_BOOLEAN);
				$supBot = $this->getInput('statisliteSupBot', helper::FILTER_BOOLEAN);
				$robot = $this->getInput('statisliteEditBot', helper::FILTER_STRING_SHORT);
				
				// Ouverture et décodage du fichier json
				$json = file_get_contents(self::$fichiers_json.'filtre_primaire.json');
				$fp = json_decode($json, true);
				
				// Ajout ou suppression d'adresses IP
				if ($addIP){
					// Ajout seulement si l'entrée n'existe pas
					$noexist =true;
					foreach( $fp['listeIP'] as $key=>$value){
						if($value === $addressIP){
							$noexist = false;
							break;
						}
					}
					if($noexist) $fp['listeIP'][ count($fp['listeIP'])] = $addressIP;
				}
				// Suppression si l'entrée existe
				elseif( $supIP ){
					foreach( $fp['listeIP'] as $key=>$value){
						if( $value === $addressIP){
							unset($fp['listeIP'][$key]);
							$fp['listeIP'] = array_values($fp['listeIP']);
							break;
						}
					}
				}
				
				// Ajout ou suppression de pages à exclure
				if ($addQS){
					// Ajout seulement si l'entrée n'existe pas
					$noexist =true;
					foreach( $fp['listeQS'] as $key=>$value){
						if($value === $pageQS){
							$noexist = false;
							break;
						}
					}
					if($noexist) $fp['listeQS'][ count($fp['listeQS'])] = $pageQS;
				}
				// Suppression si l'entrée existe
				elseif( $supQS ){
					foreach( $fp['listeQS'] as $key=>$value){
						if( $value === $pageQS){
							unset($fp['listeQS'][$key]);
							$fp['listeQS'] = array_values($fp['listeQS']);
							break;
						}
					}
				}
				// Ajout ou suppression de robots
				if ($addBot){
					// Ajout seulement si l'entrée n'existe pas
					$noexist =true;
					foreach( $fp['listeBot'] as $key=>$value){
						if($value === $robot){
							$noexist = false;
							break;
						}
					}
					if($noexist) $fp['listeBot'][ count($fp['listeBot'])] = $robot;
				}
				// Suppression si l'entrée existe
				elseif( $supBot ){
					foreach( $fp['listeBot'] as $key=>$value){
						if( $value === $robot){
							unset($fp['listeBot'][$key]);
							$fp['listeBot'] = array_values($fp['listeBot']);
							break;
						}
					}
				}
				
				// Encodage et fermeture du fichier json
				$json = json_encode($fp);
				file_put_contents(self::$fichiers_json.'filtre_primaire.json',$json);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl().$this->getUrl(),
					'notification' => $text['statislite']['advanced'][0],
					'state' => true
				]);
			}
			
			// Données de filtrage primaire dans filtre_primaire.json avec les clefs 'listeIP', 'listeBot', 'listeQS'	
			$json = file_get_contents(self::$fichiers_json.'filtre_primaire.json');
			$fp = json_decode($json, true);
			$tabListeIP = $fp['listeIP'];
			$tabListeQS = $fp['listeQS'];
			$tabListeBot = $fp['listeBot'];
			
			// Liste des IP filtrées
			foreach( $tabListeIP as $key=>$value){
				self::$listeIP .= $value."\r\n";
			}
			// Lecture de l'adresse IP
			// Si internet partagé
			self::$yourIP ='';
			if (isset($_SERVER['HTTP_CLIENT_IP'])) {
				self::$yourIP  = $_SERVER['HTTP_CLIENT_IP'];
			}
			// Si derrière un proxy
			elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				self::$yourIP  = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			// Sinon : IP normale
			else{
				if(isset($_SERVER['REMOTE_ADDR'])){
					self::$yourIP = $_SERVER['REMOTE_ADDR'];
				}
			}
			// Liste des pages filtrées
			foreach( $tabListeQS as $key=>$value){
				self::$listeQS .= $value."\r\n";
			}

			// Liste des robots
			foreach( $tabListeBot as $key=>$value){
				self::$listeBot .= $value."\r\n";
			}
		
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['statislite']['advanced'][1],
				'view' => 'advanced'
			]);
		}
	}


	/**
	 * Fonction initJson()
	 */
	public function initJson() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < statislite::$actions['initJson'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/statislite/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_statislite.php');
			// Initialisations des dossiers des json
			self::$fichiers_json = self::DATA_DIR.self::$i18n.'/data_module/statislite/json/';
			self::$tmp = self::DATA_DIR.self::$i18n.'/data_module/statislite/tmp/';
			self::$json_sauve = self::DATA_DIR.self::$i18n.'/data_module/statislite/json_sauve/';
			// Jeton incorrect
			if ($this->getUrl(2) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . $this->getUrl(0) . '/config',
					'notification' => $text['statislite']['initJson'][0]
				]);
			} else {
				// Sauvegarde de sécurité des fichiers json
				$this->sauvegardeJson();
				// Réinitialisation des fichiers json
				$this -> initcumul();
				$this -> initchrono();
				file_put_contents( self::$fichiers_json.'robots.json', '{}');
				file_put_contents( self::$fichiers_json.'sessionInvalide.json', '{}');
				file_put_contents( self::$fichiers_json.'affitampon.json', '{}');
				file_put_contents( self::$fichiers_json.'sessionLog.json', '{}');
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['statislite']['initJson'][1],
					'state' => true
				]);
				
			}
		}
	}

	
	/**
	 * Fonction sauveJson()
	 */
	public function sauveJson() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < statislite::$actions['sauveJson'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/statislite/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_statislite.php');
			// Initialisations des dossiers des json
			self::$fichiers_json = self::DATA_DIR.self::$i18n.'/data_module/statislite/json/';
			self::$tmp = self::DATA_DIR.self::$i18n.'/data_module/statislite/tmp/';
			self::$json_sauve = self::DATA_DIR.self::$i18n.'/data_module/statislite/json_sauve/';
			// Sauvegarde des fichiers json
			$this->sauvegardeJson();
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'notification' => $text['statislite']['sauveJson'][0],
				'state' => true
			]);
		}
	}

	/**
	 * Fonction initDownload()
	 */
	public function initDownload() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < statislite::$actions['initDownload'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/statislite/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_statislite.php');

			// Jeton incorrect
			if ($this->getUrl(2) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . $this->getUrl(0) . '/config',
					'notification' => $text['statislite']['initDownload'][0]
				]);
			} else {
				// Réinitialisation du compteur de liens cliqués
				file_put_contents( self::$downloadLink.'counter.json', '{}');
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['statislite']['initDownload'][1],
					'state' => true
				]);
			}
		}
	}	
	
	/**
	 * Fonction index()
	 */
	public function index() {
		// Lexique
		include('./module/statislite/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_statislite.php');
		// Initialisations des dossiers des json
		self::$fichiers_json = self::DATA_DIR.self::$i18n.'/data_module/statislite/json/';
		self::$tmp = self::DATA_DIR.self::$i18n.'/data_module/statislite/tmp/';
		self::$json_sauve = self::DATA_DIR.self::$i18n.'/data_module/statislite/json_sauve/';
		// Si le module n'existe pas, copie des ressources, on le crée avec des valeurs par défaut et on demande une validation de la configuration
		if( $this->getData(['module', $this->getUrl(0), 'config', 'config']) !== true){
			// Copie des fichiers de module/statislite/ressource/ vers self::DATAMODULE
			if( !is_dir( self::DATAMODULE)) mkdir( self::DATAMODULE, 0755, true);
			$this->custom_copy('./module/statislite/ressource', self::DATAMODULE);
			if( !is_dir(self::DATA_DIR.self::$i18n.'/data_module/statislite')) mkdir( self::DATA_DIR.self::$i18n.'/data_module/statislite' , 0755);
			if( !is_dir( self::$fichiers_json )) mkdir( self::$fichiers_json, 0755);
			if( !is_dir( self::$tmp ))mkdir( self::$tmp, 0755);
			if( !is_dir( self::$json_sauve ))mkdir( self::$json_sauve, 0755);
			copy('./module/statislite/ressource/tmp/.htaccess', self::$tmp.'.htaccess');
			
			$this->setData(['module', $this->getUrl(0), 'config',[
				'timeVisiteMini' => '30',
				'timePageMini' => '5',
				'nbPageMini' => '2',
				'usersExclus' => '4',
				'nbEnregSession' => '5',
				'geolocalisation' => false,
				'nbaffipagesvues' => '10',
				'nbaffilangues' => '5',
				'nbaffinavigateurs' => '5',
				'nbaffise' => '5',
				'nbaffipays' => '5',
				'nbaffidates' => '5',
				'config' => false,
				'versionData' => self::VERSION
			]]);
			// Initialisation de filtre_primaire.json qui contient les paramètres de la configuration avancée
			$this->init_fp();
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl().$this->getUrl(0).'/config',
				'notification' => $text['statislite']['index'][0],
				'state' => true
			]);
		}
		else{
			// Mise à jour des données de module
			$this->update();
			
			/* 
			 * Paramètres réglés en configuration du module
			*/
			// Temps minimum à passer sur le site en secondes pour valider une visite
			$timeVisiteMini = $this->getData(['module', $this->getUrl(0), 'config', 'timeVisiteMini' ]);
			// Temps minimum à passer sur une page pour la considérer comme vue
			$timePageMini = $this->getData(['module', $this->getUrl(0), 'config', 'timePageMini' ]);
			// Nombre de pages vues dans le site minimum
			$nbpagemini = $this->getData(['module', $this->getUrl(0), 'config', 'nbPageMini' ]);
			// Utilisateurs connectés à exclure des statistiques
			$usersExclus = $this->getData(['module', $this->getUrl(0), 'config', 'usersExclus' ]);
			// Affichage graphique : nombre de pages vues à afficher en commençant par la plus fréquente de 0 à toutes
			$nbaffipagesvues = $this->getData(['module', $this->getUrl(0), 'config', 'nbaffipagesvues']);
			// Affichage graphique : nombre de langues à afficher en commençant par la plus fréquente de 0 à toutes
			$nbaffilangues = $this->getData(['module', $this->getUrl(0), 'config', 'nbaffilangues']);
			// Affichage graphique : nombre de navigateurs à afficher en commençant par le plus fréquent de 0 à toutes
			$nbaffinavigateurs = $this->getData(['module', $this->getUrl(0), 'config', 'nbaffinavigateurs']);
			// Affichage graphique : nombre de systèmes d'exploitation à afficher en commençant par le plus fréquent de 0 à toutes
			$nbaffise = $this->getData(['module', $this->getUrl(0), 'config', 'nbaffise']);
			// Affichage graphique : nombre de pays à afficher en commençant par le plus fréquent de 0 à toutes
			$nbaffipays = $this->getData(['module', $this->getUrl(0), 'config', 'nbaffipays']);
			// Nombre de sessions affichées dans l'affichage détaillé
			$nbEnregSession = $this->getData(['module', $this->getUrl(0), 'config', 'nbEnregSession' ]);
			// Nombre de dates affichées dans l'affichage chronologique
			$nbAffiDates = $this->getData(['module', $this->getUrl(0), 'config', 'nbaffidates' ]);
			// option avec geolocalisation
			$geolocalisation = $this->getData(['module', $this->getUrl(0), 'config', 'geolocalisation' ]);
			
			// Initialisations variables
			self::$comptevisite = 0;
			self::$comptepages = 0;
			self::$dureevisites = 0;
			$datedebut = date('Y/m/d H:i:s');
			
			// Initialisation du fichier cumul.json et contrôle de cohérence
			if(! is_file(self::$fichiers_json.'cumul.json')){
				$this -> initcumul();
			} else{
				// Contrôle de cohérence du fichier cumul.json, sinon restauration du dernier fichier valide
				$json = file_get_contents(self::$fichiers_json.'cumul.json');
				$cumul = json_decode($json, true);
				if( ! isset($cumul['nb_clics']) || ! isset($cumul['nb_visites']) || ! isset($cumul['duree_visites']) || ! isset($cumul['clients'])
					|| ! isset($cumul['robots']) || ! isset($cumul['date_debut']) || ! isset($cumul['date_fin']) || ! isset($cumul['pages'])){
					if( is_file( self::$json_sauve.'cumul.json')) copy( self::$json_sauve.'cumul.json', self::$fichiers_json.'cumul.json');	
				}
			}
			
			
			// Initialisation du fichier chrono.json avec pour clef la date, pour valeurs le nombre visites, le nombre de pages vues, la durée totale
			if(! is_file(self::$fichiers_json.'chrono.json')){
				$this -> initchrono();
			}
			
			// Contrôle de cohérence du fichier filtre_primaire.json, sinon il est initialisé
			if( is_file(self::$fichiers_json.'filtre_primaire.json')){
				$json = file_get_contents(self::$fichiers_json.'filtre_primaire.json');
				$fp = json_decode($json, true);
				if( ! isset($fp['robots']) || ! isset($fp['listeIP']) || ! isset($fp['listeQS']) || ! isset($fp['listeBot'])){
					$this->init_fp();	
				}
			} else{
				$this->init_fp();
			}

			// Lecture et décodage du fichier sessionLog.json
			if( is_file(self::$fichiers_json.'sessionLog.json')){
				$json = file_get_contents(self::$fichiers_json.'sessionLog.json');
			}
			else{
				$json = '{}';
			}
			$log = json_decode($json, true);

			// Recherche de la première date dans le fichier sessionLog.json
			foreach($log as $numSession=>$values){
				$datedebut = substr($log[$numSession]['vues'][0], 0 , 19);
				break;
			}
			
			// Remplacement du nom de vue 'Page d'accueil' par le nom de la page d'accueil et nom raccourci pour la page employant agenda
			foreach($log as $numSession=>$values){
				foreach($values['vues'] as $key=>$value){
					if( substr($value, 22 , strlen($value)) == 'Page d\'accueil'){
						$log[$numSession]['vues'][$key] = substr($value, 0 , 19).' * '.$this->getData(['locale','homePageId']);
					}
					// agenda
					if( strpos( $value, 'vue:dayGrid')){
						$posSlash = strpos( $value, '/', 22);
						$log[$numSession]['vues'][$key] = substr($value, 0 , 19).' * '.substr( $value,22, $posSlash - 22).'/date';
					}					
				}
			}

			/*
			 * Filtrage des vues et des visites dans le fichier sessionLog.json
			 * vues invalidées si : temps passé sur une page < $timePageMini ou 2 pages consécutives de même nom (si au moins 2 pages vues)
			 * vues invalidées si : elles ne correspondent pas à une page existante (le nom de la vue doit commencer par le nom d'une page existante)
			 * visites invalidées si: nombre de pages vues < $nbpagemini ou temps de visite < $timeVisiteMini.
			 * visites invalidées si : utilisateur connecté exclu des statistiques
			 * Comptage des vues par session et des visites validées,
			 * Comptage des sessions invalidées par $nbpagemini, $timeVisiteMini ou $usersExclus.
			*/
			
			foreach($log as $numSession=>$values){
				$nbpageparsession = count($log[$numSession]['vues']);
				// Eliminer les vues dont le nom ne commence pas par un nom de page existante
				$pages = $this->getData(['page']);
				foreach($pages as $page => $pageId) {
					if ($this->getData(['page',$page,'block']) === 'bar' ||
					$this->getData(['page',$page,'disable']) === true) {
						unset($pages[$page]);
					}
				}
				$renum = false;
				foreach($log[$numSession]['vues'] as $key => $nom_vue){
					$nom = substr($nom_vue, 22);
					if(strpos($nom,'/') === false){
						$debut_nom = $nom;
					}
					else{
						$debut_nom = substr($nom, 0, strpos($nom,'/'));
					}
					$occurence = false;
					foreach($pages as $page => $pageId){
						if($debut_nom == $page){
							$occurence = true;
						}
					}
					if($occurence === false){
						unset($log[$numSession]['vues'][$key]);
						$renum = true;
					}
				}
				if($renum){
					$i = 0;
					$tableau[$numSession] =  array('vues' => array() );
					foreach($log[$numSession]['vues'] as $key=>$value){
						$tableau[$numSession]['vues'][$i] = $value;
						$i++;
					}
					$log[$numSession]['vues'] = $tableau[$numSession]['vues'];
					$nbpageparsession = count($log[$numSession]['vues']);
				}
				// Eliminer les vues dont la durée est inférieure à $timePageMini et les vues n portant le même nom que la vue n+1
				// si il y a au moins 2 pages vues dans la session
				$renum = false;
				if( $nbpageparsession > 1){
					for($i = 0; $i < $nbpageparsession - 1; $i++){
						if( strtotime(substr($log[$numSession]['vues'][$i + 1], 0 , 19)) - strtotime(substr($log[$numSession]['vues'][$i], 0 , 19)) < $timePageMini
							|| substr($log[$numSession]['vues'][$i+1], 22 , strlen($log[$numSession]['vues'][$i+1])) == substr($log[$numSession]['vues'][$i], 22 , strlen($log[$numSession]['vues'][$i]))){
							unset($log[$numSession]['vues'][$i]);
							$renum = true;
						}
					}
				}
				// Si nécessaire renuméroter les clefs du tableau $log[$numSession]['vues'] : 0,1,2 etc...
				if($renum){
					$i = 0;
					$tableau[$numSession] =  array('vues' => array() );
					foreach($log[$numSession]['vues'] as $key=>$value){
						$tableau[$numSession]['vues'][$i] = $value;
						$i++;
					}
					$log[$numSession]['vues'] = $tableau[$numSession]['vues'];
					$nbpageparsession = count($log[$numSession]['vues']);
				}
				if(isset($log[$numSession]['ip'])){
					$ip = $log[$numSession]['ip'];
				}
				$datetimei = time();
				if( $nbpageparsession > 0) $datetimei = strtotime(substr($log[$numSession]['vues'][0], 0 , 19));
				// Si $nbpageparsession <=1 on force la valeur de $datetimef
				if($nbpageparsession <= 1){ 
					$datetimef = $datetimei + $timeVisiteMini;
				}
				else{
					$datetimef = strtotime(substr($log[$numSession]['vues'][$nbpageparsession - 1], 0 , 19));
				}
				$dureesession = $datetimef - $datetimei;
				// Recherche du groupe (0,1,2,3) correspondant à l'utilisateur connecté
				$groupe_user_connected = 0;
				$user_connected = $log[$numSession]['user_id'];
				if( null !== $this->getData(['user', $user_connected,'group'])){
					if($user_connected != 'visiteur'){
						$groupe_user_connected = $this->getData(['user', $user_connected, 'group']);
					}
				}
				// Si le nombre de pages vues dans la session est >= $nbpagemini et si la durée de la session est >= $timeVisiteMini
				// et si l'utilisateur connecté n'est pas exclu des statistiques
				if( $nbpageparsession >= $nbpagemini && $dureesession >= $timeVisiteMini
					&& $groupe_user_connected < $usersExclus ){
						// Mises à jour des variables pour affichage des statistiques
						self::$comptepages = self::$comptepages + $nbpageparsession;
						self::$comptevisite++;
						self::$dureevisites = self::$dureevisites + $dureesession;
						// Modification des élèments null en ''
						if( is_null($log[$numSession]['referer'])){$log[$numSession]['referer'] = '';}
						if( is_null($log[$numSession]['langage'])){$log[$numSession]['langage'] = '';}
						if( is_null($log[$numSession]['userAgent'])){$log[$numSession]['userAgent'] = '';}
						// Recherche de $log[$numSession]['client'][0] : langage préféré
						$log[$numSession]['client'][0] = $this->langage($log[$numSession]['langage']);
						// Recherche de $log[$numSession]['client'][1] : navigateur
						$log[$numSession]['client'][1] = $this->navigateur($log[$numSession]['userAgent']);
						// Recherche de $log[$numSession]['client'][2] : système d'exploitation
						$log[$numSession]['client'][2] = $this->systeme($log[$numSession]['userAgent']);
						// Geolocalisation si elle n'a pas été faite et si l'IP n'est pas déjà détruite
						if(isset($log[$numSession]['ip'])){
							/*if($geolocalisation && ! isset($log[$numSession]['geolocalisation'])){
								$geo = $this->geolocalise($log[$numSession]['ip']);
								$log[$numSession]['geolocalisation'] = $geo['country_name'].' - '.$geo['city'];
							}*/
							// CNIL : ne pas mémoriser d'adresse IP
							unset($log[$numSession]['ip']);
						}
				}
				// Sinon on supprime cet enregistrement de sessionLog.json et on l'enregistre dans sessionInvalide.json
				// puis on enregistre dans cumul.json le résultat du filtrage par nombre de pages,temps de visite ou utilisateur exclu
				else{			
					// Lecture et décodage du fichier sessionInvalide.json
					if( is_file(self::$fichiers_json.'sessionInvalide.json') ){
						$json = file_get_contents(self::$fichiers_json.'sessionInvalide.json');
					}
					else{
						$json = '{}';
					}
					$poub = json_decode($json, true);
					$poub[$numSession] = $log[$numSession];
					// CNIL : même dans le fichier sessionInvalide.json on ne conserve pas d'IP
					unset($poub[$numSession]['ip']);
					unset($poub[$numSession]['client']);
					// Limitation de la taille du fichier sessionInvalide.json à 200 enregistrements
					if(count($poub) > 200){
						foreach($poub as $key=>$value){
							unset($poub[$key]);
							break;
						}
					}
					// Encodage et sauvegarde du fichier sessionInvalide.json
					$json = json_encode($poub);
					file_put_contents(self::$fichiers_json.'sessionInvalide.json',$json);
					// Suppression de la session
					unset($log[$numSession]);
					// Enregistrement dans cumul.json du résultat du filtrage
					// np + tv + ue >= nombre de sessionInvalide car une même session peut être éliminée plusieurs fois
					// A chaque fois np tv ou ue s'incrémente mais la sessionInvalide de même numéro de session est simplement modifiée
					if($nbpageparsession < $nbpagemini){
						$type = 'np';
					}
					elseif($dureesession < $timeVisiteMini){
						$type = 'tv';
					}
					else{
						$type = 'ue';
					}
					$json = file_get_contents(self::$fichiers_json.'cumul.json');
					$cumul = json_decode($json, true);
					$cumul['robots'][$type] = $cumul['robots'][$type] + 1;
					$json = json_encode($cumul);
					file_put_contents(self::$fichiers_json.'cumul.json',$json);
					// Sauvegarde de sécurité de cumul.json dans le dossier json_sauve après un contrôle de cohérence
					if( isset($cumul['nb_clics']) && isset($cumul['nb_visites']) && isset($cumul['duree_visites']) && isset($cumul['clients'])
						&& isset($cumul['robots']) && isset($cumul['date_debut']) && isset($cumul['date_fin']) && isset($cumul['pages'])){
						file_put_contents(self::$json_sauve.'cumul.json',$json);	
					}
				}
			}
			
			
			/*
			 * Mise à jour du dossier affitampon.json destiné à l'affichage détaillé 
			 *
			*/
			if( is_file(self::$fichiers_json.'affitampon.json')){
				$json = file_get_contents(self::$fichiers_json.'affitampon.json');
			}
			else{
				$json='{}';
			}
			$tampon = json_decode($json, true);
			foreach($log as $numSession=>$values){
				$tampon[$numSession] = $log[$numSession];			
			}
			// Fichier limité à 100 enregistrements
			if( count($tampon) > 100){
				foreach($tampon as $key=>$value){
					unset($tampon[$key]);
					if(count($tampon) <= 100){ break; }
				}
			}
			$json = json_encode($tampon);
			file_put_contents(self::$fichiers_json.'affitampon.json',$json);
			
			
			/* 
			 * Sauvegarde des données de sessionLog.json vers cumul.json et chrono.json
			 * Réalisée si le dernier clic pour chaque session de sessionLog.json date de plus de $timemaj >= 10 minutes
			 * Objectif conserver dans sessionLog.json les sessions qui sont encore peut être actives
			 * Sauvegarde des données de filtre_primaire.json vers cumul.json
			*/

			$json = file_get_contents(self::$fichiers_json.'cumul.json');
			$cumul = json_decode($json, true);
			
			// Sauvegarde des données de filtre_primaire.json vers cumul.json
			$json = file_get_contents(self::$fichiers_json.'filtre_primaire.json');
			$fp = json_decode($json, true);
			$cumul['robots']['ua'] = $cumul['robots']['ua'] + $fp['robots']['ua'];
			$cumul['robots']['ip'] = $cumul['robots']['ip'] + $fp['robots']['ip'];
			$fp['robots']['ua'] = 0;
			$fp['robots']['ip'] = 0;
			$json = json_encode($fp);
			file_put_contents(self::$fichiers_json.'filtre_primaire.json',$json);
			
			// Sauvegarde des données de sessionLog.json vers cumul.json et chrono.json
			foreach($log as $numSession=>$values){
				$nbpageparsession = count($log[$numSession]['vues']);
				$nbpagesvalides = $nbpageparsession;
				$tab = $log;
				if( (time() - strtotime(substr($log[$numSession]['vues'][$nbpageparsession -1], 0, 19))) > self::$timemaj){
					// Comptage du nombre de pages dans la session en ne comptant qu'une fois les pages de même nom 
					// $nbpagesvalides sera utilisé par cumul.json et chrono.json, $tab est utilisé pour la maj du tableau $cumul['pages']
					if($nbpageparsession >= 2){
						foreach($tab[$numSession]['vues'] as $key=>$value){
							$nom = substr($value, 22 , strlen($value)); 
							//$date = strtotime(substr($value, 0 , 19)); ajouter dans le if && ( strtotime(substr($tab[$numSession]['vues'][$i], 0 , 19)) - $date) < 60)
							for($i=$key + 1 ; $i < $nbpageparsession; $i++){
								if( isset ($tab[$numSession]['vues'][$i])){
									if( substr($tab[$numSession]['vues'][$i], 22 , strlen($tab[$numSession]['vues'][$i])) == $nom){
										unset($tab[$numSession]['vues'][$i]);
									}
								}
							}
						}
						$nbpagesvalides = count($tab[$numSession]['vues']);
					}
					// Mise à jour du tableau $cumul
					$cumul['nb_clics'] = $cumul['nb_clics']  + $nbpagesvalides;
					$cumul['nb_visites']++;
					$cumul['date_fin'] = substr( $log[$numSession]['vues'][$nbpageparsession - 1], 0, 19);
					$datetimei = strtotime(substr($log[$numSession]['vues'][0], 0 , 19));
					$datetimef = strtotime(substr($log[$numSession]['vues'][$nbpageparsession - 1], 0 , 19));
					$dureesession = $datetimef - $datetimei;
					$cumul['duree_visites'] = $cumul['duree_visites'] + $dureesession;
					
					//langage préféré
					if($log[$numSession]['client'][0] != 'fichier langages.txt absent'){
						$clefreconnue = false;
						foreach($cumul['clients']['langage'] as $key => $value){
							// Si la clef == l'enregistrement dans log de la langue préférée on incrémente la valeur
							if( $key == $log[$numSession]['client'][0]){
								$cumul['clients']['langage'][$key]++;
								$clefreconnue = true;
							}
						}
						// Si une clef valide n'a pas été trouvée on la crée avec une valeur initialisée à 1
						if(!$clefreconnue){
							$cumul['clients']['langage'][$log[$numSession]['client'][0]] = 1;
						}
					}
					
					// Navigateur
					if($log[$numSession]['client'][1] != 'fichier navigateurs.txt absent'){
						$clefreconnue = false;
						foreach($cumul['clients']['navigateur'] as $key => $value){
							// Si la clef == l'enregistrement dans log du navigateur on incrémente la valeur
							if( $key == $log[$numSession]['client'][1]){
								$cumul['clients']['navigateur'][$key]++;
								$clefreconnue = true;
							}
						}
						// Si une clef valide n'a pas été trouvée on la crée avec une valeur initialisée à 1
						if(!$clefreconnue){
							$cumul['clients']['navigateur'][$log[$numSession]['client'][1]] = 1;
						}
					}
					
					// Systèmes d'exploitation
					if($log[$numSession]['client'][2] != 'fichier systemes.txt absent'){
						$clefreconnue = false;
						foreach($cumul['clients']['systeme'] as $key => $value){
							// Si la clef == l'enregistrement dans log du systeme on incrémente la valeur
							if( $key == $log[$numSession]['client'][2]){
								$cumul['clients']['systeme'][$key]++;
								$clefreconnue = true;
							}
						}
						// Si une clef valide n'a pas été trouvée on la crée avec une valeur initialisée à 1
						if(!$clefreconnue){
							$cumul['clients']['systeme'][$log[$numSession]['client'][2]] = 1;
						}
					}
					
					// Mise à jour des variables liées au fichier sessionLog.json
					self::$comptepages = self::$comptepages - $nbpageparsession;
					self::$comptevisite--;
					self::$dureevisites = self::$dureevisites - ( $datetimef - $datetimei );
					
					// Enregistrement des pages vues dans $cumul à partir de $tab
					foreach($tab[$numSession]['vues'] as $vues=>$values){
						$page = substr($values, 22, strlen($values));
						if(isset($cumul['pages'][$page])){
							$cumul['pages'][$page] = $cumul['pages'][$page] + 1;
						}
						else{
							$cumul['pages'][$page] = 1;
						}
					}
					
					// Mise à jour du fichier chrono.json
					$dateclef = substr($log[$numSession]['vues'][0], 0 , 10);
					$json = file_get_contents(self::$fichiers_json.'chrono.json');
					$chrono = json_decode($json, true);
					if( ! isset($chrono[$dateclef])){
						$chrono[$dateclef] = array( 'nb_visites' => 0, 'nb_pages_vues' => 0, 'duree' =>0);
					}
					$chrono[$dateclef]['nb_visites']++;
					$chrono[$dateclef]['nb_pages_vues'] = $chrono[$dateclef]['nb_pages_vues'] + $nbpagesvalides;
					$chrono[$dateclef]['duree'] = $chrono[$dateclef]['duree'] + $dureesession;
					// Tri du tableau par clefs en commençant par la date la plus récente
					krsort($chrono);
					// Limitation aux 50 dernières dates
					if( count($chrono) > 50){
						$derniereclef = '';
						foreach($chrono as $key => $value){
							$derniereclef = $key;
						}
						unset($chrono[$derniereclef]);
					}
					// Encodage et sauvegarde de chrono.json
					$json = json_encode($chrono);
					file_put_contents(self::$fichiers_json.'chrono.json',$json);
					
					// Suppression des données sauvegardées
					unset($log[$numSession]);	
				}
			}
			
			// Mise à jour des fichiers sessionLog.json et cumul.json
			$json = json_encode($log);
			file_put_contents(self::$fichiers_json.'sessionLog.json',$json);
			$json = json_encode($cumul);
			file_put_contents(self::$fichiers_json.'cumul.json',$json);
			// Sauvegarde de sécurité de cumul.json dans le dossier json_sauve après un contrôle de cohérence
			if( isset($cumul['nb_clics']) && isset($cumul['nb_visites']) && isset($cumul['duree_visites']) && isset($cumul['clients'])
				&& isset($cumul['robots']) && isset($cumul['date_debut']) && isset($cumul['date_fin']) && isset($cumul['pages'])){
				file_put_contents(self::$json_sauve.'cumul.json',$json);	
			}
			
			// Comptage des visites
			self::$comptepagestotal = self::$comptepages + $cumul['nb_clics'];
			self::$comptevisitetotal = self::$comptevisite + $cumul['nb_visites'];
			self::$dureevisitestotal = self::$dureevisites + $cumul['duree_visites'];
			if(self::$comptevisitetotal != 0){
				self::$dureevisitemoyenne = self::conversionTime((int)(self::$dureevisitestotal / self::$comptevisitetotal));
			}
			else{
				self::$dureevisitemoyenne = 0;
			}
			self::$datedebut = $cumul['date_debut'];

			// Pour affichage des pages vues
			if($nbaffipagesvues != 0){
				self::$pagesvuesaffi = array();
				foreach($log as $numSession=>$val){
					foreach($log[$numSession]['vues'] as $vues=>$values){
						$page = substr($values, 22, strlen($values));
						if(isset(self::$pagesvuesaffi[$page])){
							self::$pagesvuesaffi[$page] = self::$pagesvuesaffi[$page] + 1;
						}
						else{
							self::$pagesvuesaffi[$page] = 1;
						}
					}
				}
				foreach($cumul['pages'] as $page=>$values){
					if(isset(self::$pagesvuesaffi[$page])){
						self::$pagesvuesaffi[$page] = self::$pagesvuesaffi[$page] + $values;
					}
					else{
						self::$pagesvuesaffi[$page] = $values;
					}
				}
				arsort(self::$pagesvuesaffi);
				if($nbaffipagesvues != 1000){
					self::$pagesvuesaffi = array_slice(self::$pagesvuesaffi, 0, $nbaffipagesvues, true);
				}
				foreach(self::$pagesvuesaffi as $key => $value){
					self::$scoremax = self::$pagesvuesaffi[$key];
					break;
				}
			}
			
			// Pour affichage des langues
			if($nbaffilangues != 0){
				self::$languesaffi = array();
				foreach($log as $numSession=>$val){
					$lang = $log[$numSession]['client'][0];
					if($log[$numSession]['client'][0] != 'fichier langages.txt absent'){
						if(isset(self::$languesaffi[$lang])){
							self::$languesaffi[$lang] = self::$languesaffi[$lang] + 1;
						}
						else{
							self::$languesaffi[$lang] = 1;
						}
					}
				}
				foreach($cumul['clients']['langage'] as $lang=>$values){
					if(isset(self::$languesaffi[$lang])){
						self::$languesaffi[$lang] = self::$languesaffi[$lang] + $values;
					}
					else{
						self::$languesaffi[$lang] = $values;
					}
				}
				arsort(self::$languesaffi);
				if($nbaffilangues != 1000){
					self::$languesaffi = array_slice(self::$languesaffi, 0, $nbaffilangues, true);
				}
				foreach(self::$languesaffi as $key => $value){
					self::$scoremaxlangues = self::$languesaffi[$key];
					break;
				}
			}
			
			// Pour affichage des navigateurs
			if($nbaffinavigateurs != 0){
				self::$navigateursaffi = array();
				foreach($log as $numSession=>$val){
					$nav = $log[$numSession]['client'][1];
					if($log[$numSession]['client'][1] != 'fichier navigateurs.txt absent'){
						if(isset(self::$navigateursaffi[$nav])){
							self::$navigateursaffi[$nav] = self::$navigateursaffi[$nav] + 1;
						}
						else{
							self::$navigateursaffi[$nav] = 1;
						}
					}
				}
				foreach($cumul['clients']['navigateur'] as $navig=>$values){
					if(isset(self::$navigateursaffi[$navig])){
						self::$navigateursaffi[$navig] = self::$navigateursaffi[$navig] + $values;
					}
					else{
						self::$navigateursaffi[$navig] = $values;
					}
				}
				arsort(self::$navigateursaffi);
				if($nbaffinavigateurs != 1000){
					self::$navigateursaffi = array_slice(self::$navigateursaffi, 0, $nbaffinavigateurs, true);
				}
				foreach(self::$navigateursaffi as $key => $value){
					self::$scoremaxnavi = self::$navigateursaffi[$key];
					break;
				}
			}
			
			// Pour affichage des sytèmes d'exploitation
			if($nbaffise != 0){
				self::$systemesaffi = array();
				foreach($log as $numSession=>$val){
					$syse = $log[$numSession]['client'][2];
					if($log[$numSession]['client'][2] != 'fichier systemes.txt absent'){
						if(isset(self::$systemesaffi[$syse])){
							self::$systemesaffi[$syse] = self::$systemesaffi[$syse] + 1;
						}
						else{
							self::$systemesaffi[$syse] = 1;
						}
					}
				}
				foreach($cumul['clients']['systeme'] as $syse=>$values){
					if(isset(self::$systemesaffi[$syse])){
						self::$systemesaffi[$syse] = self::$systemesaffi[$syse] + $values;
					}
					else{
						self::$systemesaffi[$syse] = $values;
					}
				}
				arsort(self::$systemesaffi);
				if($nbaffise != 1000){
					self::$systemesaffi = array_slice(self::$systemesaffi, 0, $nbaffise, true);
				}
				foreach(self::$systemesaffi as $key => $value){
					self::$scoremaxse = self::$systemesaffi[$key];
					break;
				}
			}
			
			// Pour affichage chronologique
			if( $nbAffiDates != 0){
				$json = file_get_contents(self::$fichiers_json.'chrono.json');
				self::$chronoaffi = json_decode($json, true);
				// Mise à jour sans sauvegarde en prenant en compte sessionLog.json
				foreach($log as $numSession=>$val){
					$datetimei = strtotime(substr($log[$numSession]['vues'][0], 0 , 19));
					$nbpageparsession = count($log[$numSession]['vues']);
					// Si $nbpageparsession <=1 on force la valeur de $datetimef
					if($nbpageparsession <= 1){ 
						$datetimef = $datetimei + $timeVisiteMini;
					}
					else{
						$datetimef = strtotime(substr($log[$numSession]['vues'][$nbpageparsession - 1], 0 , 19));
					}
					$dureesession = $datetimef - $datetimei;
					$dateclef = substr($log[$numSession]['vues'][0], 0 , 10);
					if( ! isset(self::$chronoaffi[$dateclef])){
						self::$chronoaffi[$dateclef] = array( 'nb_visites' => 0, 'nb_pages_vues' => 0, 'duree' =>0);
					}
					self::$chronoaffi[$dateclef]['nb_visites']++;
					self::$chronoaffi[$dateclef]['nb_pages_vues'] = self::$chronoaffi[$dateclef]['nb_pages_vues'] + $nbpageparsession;
					self::$chronoaffi[$dateclef]['duree'] = self::$chronoaffi[$dateclef]['duree'] + $dureesession;
				}
				// Tri du tableau par clefs en commençant par la date la plus récente
				krsort(self::$chronoaffi);
			}
			
			// Pour affichage détaillé
			$json = file_get_contents(self::$fichiers_json.'affitampon.json');
			$tampon = json_decode($json, true);
			// on change les clefs de $tampon : 0,1,2,3,...
			$i=0;
			$tableau = array();
			foreach($tampon as $key=>$value){
				$tableau[$i] = $value;
				$i++;
			}
			$tampon = $tableau;
			$nbsessiontampon = count($tampon);
			if( $nbsessiontampon > 0 ){
				for($i=0; $i < $nbEnregSession; $i++){
					self::$affidetaille[$i] = $tampon[$nbsessiontampon - 1 - $i];
					if($nbsessiontampon - 1 - $i === 0) break;
				}
			}
		
			// Valeurs en sortie
			$this->addOutput([
				'showBarEditButton' => true,
				'showPageContent' => true,
				'view' => 'index'
			]);
		}
	}
	
	
	/*
	 * Fonctions
	*/
	
	/* Recherche de la langue préférée*/
	private function langage($lang){
		$langsigle = strtolower(substr($lang, 0, 2));
		// Ouvrir le fichier langages.txt et le transformer en array()
		if(is_file(self::$base.'langages.txt')){
			$chaine = file_get_contents(self::$base.'langages.txt');
			// Suppression des lf
			$chaine1 = str_replace("\r", '', $chaine);
			$chaine = str_replace("\n", '', $chaine);
			$langues = explode('*', $chaine);
			foreach($langues as $souschaine){
				$tablang = explode(',' , $souschaine);
				if($tablang[0] == $langsigle){
					return $tablang[1];
				}
			}
			return 'non reconnu';	
		}
		else{
			return 'fichier langages.txt absent';
		}
	}
	
	/* Recherche du navigateur */
	private function navigateur($navig){
		$navig = strtolower($navig);
		// Ouvrir le fichier navigateurs.txt et le transformer en array()
		if(is_file(self::$base.'navigateurs.txt')){
			$chaine = file_get_contents(self::$base.'navigateurs.txt');
			// Suppression des cr lf
			$chaine1 = str_replace("\r", '', $chaine);
			$chaine = str_replace("\n", '', $chaine1);
			$navigateurs = explode('*', $chaine);
			foreach($navigateurs as $souschaine){
				$tabnavig = explode(',' , $souschaine);
				if(strpos($navig, $tabnavig[0]) !== false){
					return $tabnavig[1];
				}
			}
			return 'non reconnu';	
		}
		else{
			return 'fichier navigateurs.txt absent';
		}	
	}
	
	/* Recherche du système d'exploitation */
	private function systeme($se){
		$se = strtolower($se);
		// Ouvrir le fichier systemes.txt et le transformer en array()
		if(is_file(self::$base.'systemes.txt')){
			$chaine = file_get_contents(self::$base.'systemes.txt');
			// Suppression des cr lf
			$chaine1 = str_replace("\r", '', $chaine);
			$chaine = str_replace("\n", '', $chaine1);
			$systemes = explode('*', $chaine);
			foreach($systemes as $souschaine){
				$tabse = explode(',' , $souschaine);
				if(strpos($se, $tabse[0]) !== false){
					return $tabse[1];
				}
			}
			return 'non reconnu';	
		}
		else{
			return 'fichier systemes.txt absent';
		}	
	}
		
	/* Initialisation de cumul.json */
	private function initcumul(){
		$json = '{}';
		$cumul = json_decode($json, true);
		$cumul['nb_clics'] = 0;
		$cumul['nb_visites'] = 0;
		$cumul['duree_visites'] = 0;
		$cumul['clients'] = array( 'systeme' => array(), 'navigateur' => array(), 'langage' => array(), 'localisation' => array());
		// $cumul['robots'] comptabilise toutes les visites (sessions) exclues
		// 'ua' pour user agent de robot, 'ip' pour ip exclu, 'np' pour nombre de pages vues insuffisantes
		// 'tv' pour temps de visite trop court, 'ue' pour utilisateur exclu
		$cumul['robots'] = array( 'ua' => 0, 'ip'=> 0, 'np'=> 0, 'tv'=> 0, 'ue'=>0);
		// Si sessionLog.json existe et n'est pas vide date_debut sera sa première date sinon ce sera la date actuelle
		$cumul['date_debut'] = date('Y/m/d H:i:s');
		if(is_file(self::$fichiers_json.'sessionLog.json')){
			$json = file_get_contents(self::$fichiers_json.'sessionLog.json');
			$log = json_decode($json, true);
			foreach($log as $numSession=>$values){
				if(isset($log[$numSession]['vues'][0])){
					$cumul['date_debut'] = substr($log[$numSession]['vues'][0], 0 , 19);
				}
				break;
			}
		}
		$cumul['date_fin'] = date('Y/m/d H:i:s');
		$cumul['pages'] = array();
		$json = json_encode($cumul);
		file_put_contents(self::$fichiers_json.'cumul.json',$json);
	}
	
	/* Initilaisation de chrono.json */
	private function initchrono(){
		$json = '{}';
		$chrono = json_decode($json, true);
		$chrono[date('Y/m/d')] = array( 'nb_visites' => 0, 'nb_pages_vues' => 0, 'duree' =>0);
		$json = json_encode($chrono);
		file_put_contents(self::$fichiers_json.'chrono.json',$json);
	}

	/* Initialisation de filtre_primaire.son */
	private function init_fp(){
		$json = '{}';
		$fp= json_decode($json, true);
		$fp['robots'] = array( 'ua' => 0, 'ip'=> 0);
		$fp['listeIP'] = [];
		$fp['listeQS'] = array( 0 => $this->getUrl(0));
		$fp['listeBot'] = [];			
		$json = json_encode($fp);
		file_put_contents(self::$fichiers_json.'filtre_primaire.json',$json);
	}
	
	/* Sauvegarde des fichiers json */
	private function sauvegardeJson(){
		$date = date('YmdHis');
		if( is_file( self::$fichiers_json.'robots.json' )) copy( self::$fichiers_json.'robots.json', self::$json_sauve.$date.'_robots.json');
		if( is_file( self::$fichiers_json.'affitampon.json' )) copy( self::$fichiers_json.'affitampon.json', self::$json_sauve.$date.'_affitampon.json');
		if( is_file( self::$fichiers_json.'chrono.json' )) copy( self::$fichiers_json.'chrono.json', self::$json_sauve.$date.'_chrono.json');
		if( is_file( self::$fichiers_json.'sessionInvalide.json' )) copy( self::$fichiers_json.'sessionInvalide.json', self::$json_sauve.$date.'_sessionInvalide.json');
		if( is_file( self::$fichiers_json.'cumul.json' )) copy( self::$fichiers_json.'cumul.json', self::$json_sauve.$date.'_cumul.json');
		if( is_file( self::$fichiers_json.'sessionLog.json' )) copy( self::$fichiers_json.'sessionLog.json', self::$json_sauve.$date.'_sessionLog.json');
		
	}
	
	/*
	* Copie récursive de dossiers 
	*
	*/
	private function custom_copy($src, $dst) {  
		// open the source directory 
		$dir = opendir($src);  
		// Make the destination directory if not exist 
		@mkdir($dst);  
		// Loop through the files in source directory 
		while( $file = readdir($dir) ) {  
			if (( $file != '.' ) && ( $file != '..' )) {  
				if ( is_dir($src . '/' . $file) ){  
					// Recursively calling custom copy function 
					// for sub directory  
					$this -> custom_copy($src . '/' . $file, $dst . '/' . $file);  
				}  
				else {  
					copy($src . '/' . $file, $dst . '/' . $file);  
				}  
			}  
		}  
		closedir($dir); 
	}
	
	/* Conversion secondes en heures minutes secondes */

	public static function conversionTime($Seconde){
		$Heure = 0;
		$Minute = 0;
		while ($Seconde >= 3600)
		{$Heure = $Heure + 1; $Seconde = $Seconde - 3600;}
		while ($Seconde >= 60)
		{$Minute = $Minute + 1; $Seconde = $Seconde - 60;}
		if ($Heure > 0)
		{$Convert = $Heure.' h '.$Minute.' min '.$Seconde.' s'; return $Convert;}
		elseif ($Minute > 0)
		{$Convert = $Minute.' min '.$Seconde.' s'; return $Convert;}
		else
		{$Convert = $Seconde.' s'; return $Convert;}
	}
}

