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
 /** Module développé par Sylvain Lelièvre
 * Utilise le package Fullcalendar 
 * FullCalendar Core Package v4.3.1
 * Docs & License: https://fullcalendar.io/
 * (c) 2019 Adam Shaw
 */

class agenda extends common {

	public static $actions = [
		'creation' => self::GROUP_VISITOR,
		'edition' => self::GROUP_VISITOR,
		'config' => self::GROUP_EDITOR,
		'categories' => self::GROUP_EDITOR,
		'delete' => self::GROUP_VISITOR,
		'deleteEvent' => self::GROUP_VISITOR,
		'deleteall' => self::GROUP_MODERATOR,
		'categorieDelete' => self::GROUP_EDITOR,
		'index' => self::GROUP_VISITOR
	];

	const VERSION = '7.6';	
	const REALNAME = 'Agenda';
	const DELETE = true;
	const UPDATE = '4.1';
	const DATADIRECTORY = self::DATA_DIR.'agenda/';
	
	// Constantes utilisées pour les adresses des données externes
	const DATAMODULE = self::DATA_DIR.'agenda/module/';
	const DATAFILE ='./site/file/source/agenda/';
	
	// Gestion des catégories
	public static $tabCategories = [];
	public static $categorie = [];
	
	//Evenement
	public static $evenement = [
		'id' => 0,
		'datedebut' => '',
		'datefin' => '',
		'texte' => 'texte déclaration public static',
		'couleurfond' => 'black',
		'couleurtexte' => 'white',
		'groupe_lire' => 0,
		'groupe_mod' => 2
	];
	
	// Gestion des dates
	public static $datecreation = '';
	public static $time_unix_deb = '';
	public static $time_unix_fin = '';
	public static $annee;
	public static $jour;
	public static $mois;
	
	public static $sujet_mailing = '';
	
	public static $liste_adresses =[];
	
	// Fichiers sauvegardés
	public static $savedFiles = [];
	public static $icsFiles = [];
	public static $csvFiles = [];
	
	//Pour choix de l'affichage mois / semaine dans configuration de l'agenda
	public static $vue_agenda = [
		'dayGridMonth' => 'Vue par mois',
		'dayGridWeek' => 'Vue par semaine'
	];

	/**
	* Mise à jour du module
	* Appelée par les fonctions index et config
	*/
	private function update() {
		
		if ( null===$this->getData(['module', $this->getUrl(0), 'config', 'versionData']) ) {
			$this->setData(['module', $this->getUrl(0), 'config', 'versionData', self::VERSION ]);
			// le reste de l'initialisation, complexe, est réalisée par index()
		} else {
			// Mise à jour vers la version 4.7
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '4.7', '<') ) {	
				if(! is_dir(self::DATAMODULE.'data/'.$this->getUrl(0).'_affiche')) mkdir(self::DATAMODULE.'data/'.$this->getUrl(0).'_affiche');
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','4.7']);
			}	
			
			// Mise à jour vers la version 5.0
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '5.0', '<') ) {
				$this->setData(['module', $this->getUrl(0), 'texts',[
					'configTextButtonBack' => 'Retour',
					'configTextDateStart' => 'Début : ',
					'configTextDateEnd' =>'Fin : '
					]
				]);
				
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','5.0']);
			}
			// Mise à jour vers la version 5.2
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '5.2', '<') ) {	
				// Mise à jour des .htaccess avec Apache2.4
				copy( './module/agenda/ressource/data/agenda/module/adresses/.htaccess', './site/data/agenda/module/adresses/.htaccess');
				copy( './module/agenda/ressource/data/agenda/module/data/.htaccess', './site/data/agenda/module/data/.htaccess');
				copy( './module/agenda/ressource/file/source/agenda/adresses/.htaccess', './site/file/source/agenda/adresses/.htaccess');
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','5.2']);
			}
			// Mise à jour vers la version 6.0
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '6.0', '<') ) {	
				// Couleur de la grille
				$this->setData(['module', $this->getUrl(0),'config', 'gridColor', 'rgba(146, 52, 101, 1)']);
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','6.0']);
			}
			// Mise à jour vers la version 7.1
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '7.1', '<') ) {
				// Déplacement des fichiers htaccess une seule fois
				if(is_file(self::DATAMODULE.'data/.htaccess')){
					$listDir = scandir(self::DATAMODULE.'data');
					foreach($listDir as $element) {
						if($element != "." && $element != "..") {
							if(is_dir(self::DATAMODULE.'data/'. $element) && is_file(self::DATAMODULE.'data/.htaccess') ) {
								copy( self::DATAMODULE.'data/.htaccess', self::DATAMODULE.'data/'. $element.'/.htaccess' );
							}
						}
					}
					unlink( self::DATAMODULE.'data/.htaccess');
				}
				// Modification d'emplacement des dossiers de données des pages agenda dans la langue ciblée
				if(!is_dir(self::DATA_DIR. self::$i18n.'/data_module' ) ) mkdir(self::DATA_DIR. self::$i18n.'/data_module' );
				if(!is_dir(self::DATA_DIR. self::$i18n.'/data_module/agenda')) mkdir(self::DATA_DIR. self::$i18n.'/data_module/agenda');
				foreach( $this->getData(['page']) as $page => $value){
					if( $value['moduleId'] === 'agenda' )
						if( is_dir( self::DATAMODULE.'data/'.$page)) $this->custom_copy( self::DATAMODULE.'data/'.$page , self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$page);
						if( is_dir( self::DATAMODULE.'data/'.$page.'_sauve')) $this->custom_copy( self::DATAMODULE.'data/'.$page.'_sauve' , self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$page.'_sauve');
						if( is_dir( self::DATAMODULE.'data/'.$page.'_affiche')) $this->custom_copy( self::DATAMODULE.'data/'.$page.'_affiche' , self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$page.'_affiche');
						if( is_dir( self::DATAMODULE.'data/'.$page.'_visible')) $this->custom_copy( self::DATAMODULE.'data/'.$page.'_visible' , self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$page.'_visible');
				}
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','7.1']);
			}
			// Mise à jour vers la version 7.5
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '7.5', '<') ) {	
				if(is_file('./module/agenda/view/index/index.css')) unlink('./module/agenda/view/index/index.css');
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','7.5']);
			}
			// Mise à jour vers la version 7.6
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '7.6', '<') ) {	
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','7.6']);
			}
		}
	}
	
	/**
	 * Configuration Paramètrage
	 */
	public function config() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < agenda::$actions['config'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/agenda/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_agenda.php');
			// Soumission du formulaire
			if($this->isPost()) {
				$notification = $text['agenda']['config'][6];
				$state = true;
				$fichier_restaure = $this->getInput('config_restaure');
				$fichier_sauve = $this->getInput('config_sauve');
				$droit_creation = $this->getInput('config_droit_creation');
				$droit_limite = $this->getInput('config_droit_limite', helper::FILTER_BOOLEAN);
				$fichier_ics = $this->getInput('config_fichier_ics');
				$largeur_maxi = $this->getInput('config_MaxiWidth'); 
				$fichier_csv_txt = $this->getInput('config_fichier_csv_txt');
				$gridColor = $this->getInput('config_gridColor');
					
				//Sauvegarder l'agenda
				if ($fichier_sauve !=''){
					$json_sauve = file_get_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json');
					file_put_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_sauve/'.$fichier_sauve.'.json', $json_sauve);
				}
				
				//Charger un agenda sauvegardé
				if (strpos($fichier_restaure,'.json') !== false){
									
					//Remplacement par le fichier de restauration
					$json_restaure = file_get_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_sauve/'. $fichier_restaure);
					file_put_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json', $json_restaure);
					
					//Sauvegarde dans data_sauve de l'agenda chargé
					$this->sauve($json_restaure);
					
					//Valeurs en sortie après prise en compte du formulaire 
					$this->addOutput([
						'notification' => $text['agenda']['config'][7],
						'redirect' => helper::baseUrl() . $this->getUrl(0),
						'state' => true
					]);
				}
				
				//Ajouter des évènements contenus dans le fichier ics
				if (strpos($fichier_ics,'.ics') !== false){
					$tableau = $this->getIcsEventsAsArray(self::DATAFILE.'ics/'.$fichier_ics);
					foreach($tableau as $key=>$value){
						$evenement_texte = '';
						$date_debut = '';
						$date_fin = '';
						$begin = '';
						$end = '';
						$clef_fin ='';
						foreach($value as $key2=>$value2){
							if($key2 == "BEGIN"){
								$begin = $value2;
							}
							if($key2 == "SUMMARY"){
								$evenement_texte = $value2;
							}
							if(strpos($key2,"DTSTART") !== false){
								$date_debut = $value2;
								$clef_debut = $key2;
							}
							if(strpos($key2,"DTEND") !== false){
								$date_fin = $value2;
								$clef_fin = $key2;
							}
							if($key2 == "END"){
								$end = $value2;
							}
						}
						
						//Si un évènement VEVENT est trouvé, avec summary et dtstart présents, on ajoute cet évènement à l'agenda
						if ($evenement_texte != '' && strpos($begin,'VEVENT')!==false && $date_debut!=='' ){
							if($date_fin == '') {
								$date_fin = $date_debut; 
								$clef_fin = $clef_debut;
							}
							$evenement_texte = $this->modif_texte($evenement_texte);
							//Modifier date format ics yyyymmddThhmm... ou yyyymmdd vers format fullcalendar yyyy-mm-ddThh:mm
							$date_debut = $this->modif_date($date_debut, $clef_debut);
							$date_fin = $this->modif_date($date_fin, $clef_fin);
						
							//Valeurs par défaut pour l'import ics fond blanc, texte noir, lecture visiteur, modification éditeur
							$this->nouvel_evenement($evenement_texte,$date_debut,$date_fin,'white','black','0','2', '0', '', '', '');			
						}
					}
				}
				
				// Ajouter un carnet d'adresses
				if (strpos($fichier_csv_txt,'.csv') !== false || strpos($fichier_csv_txt,'.txt') !== false){
					$adresses = file_get_contents(self::DATAFILE.'adresses/'.$fichier_csv_txt);
					if( strrchr($adresses, '@') && ! strrchr($adresses, ';')){
						copy(self::DATAFILE.'adresses/'.$fichier_csv_txt, self::DATAMODULE.'adresses/'.$fichier_csv_txt);
					}
					else{
						$notification = $text['agenda']['config'][8];
						$state = false;	
					}
				}
				
				//Mise à jour des données de configuration liées aux droits et à l'affichage
				$this->setData(['module', $this->getUrl(0), 'config', [
					'droit_creation' => intval($droit_creation),
					'droit_limite' => $droit_limite,
					'maxiWidth' => $largeur_maxi,
					'gridColor' => $gridColor,
					'versionData' => $this->getData(['module', $this->getUrl(0), 'config', 'versionData'])
				]]);
				$this->setData(['module', $this->getUrl(0), 'texts',[
					'configTextButtonBack' => $this->getInput('configTextButtonBack'),
					'configTextDateStart' => $this->getInput('configTextDateStart'),
					'configTextDateEnd' =>$this->getInput('configTextDateEnd')
					]
				]);
			
				//Valeurs en sortie
				$this->addOutput([
					'notification' => $notification,
					'redirect' => helper::baseUrl() . $this->getUrl(0),
					'state' => $state
				]);
			}
			else{
				// Fichiers sauvegardés
				if(is_dir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_sauve')) {
					$dir=self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_sauve';
					$values = scandir($dir);
					self::$savedFiles=[];
					$values[0] = $text['agenda']['config'][0];
					unset($values[array_search('..', $values)]);
					unset($values[array_search('.htaccess', $values)]);
					if (count($values) <= 1){
						self::$savedFiles = array(0 => $text['agenda']['config'][1]. self::DATA_DIR. self::$i18n.'/data_module');
					}
					else{
						//Modifier les clefs (qui sont les valeurs de retour du formulaire avec 'config_restaure') avec clef = valeur
						self::$savedFiles = array_combine($values,$values);
					}
				}
				else {
					self::$savedFiles = array(0 => $text['agenda']['config'][2].self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_sauve'.$text['agenda']['config'][3]);
				}
				// Fichiers ics
				if(is_dir(self::DATAFILE.'ics')) {
					$dir=self::DATAFILE.'ics';
					$values = scandir($dir);
					$values[0] = $text['agenda']['config'][0];
					unset($values[array_search('..', $values)]);
					if (count($values) <= 1){
						self::$icsFiles = array(0 => $text['agenda']['config'][1].self::DATAFILE.'ics');
					}
					else{
						//Modifier les clefs (qui sont les valeurs de retour du formulaire avec 'config_fichier_ics') avec clef = valeur
						self::$icsFiles = array_combine($values,$values);
					}
				}
				else {
					self::$icsFiles = array(0 => $text['agenda']['config'][2].self::DATAFILE.$text['agenda']['config'][4]);
				}
				// Fichiers csv ou txt
				if(is_dir(self::DATAFILE.'adresses')) {
					$dir=self::DATAFILE.'adresses';
					$values = scandir($dir);
					$values[0] = $text['agenda']['config'][0];
					unset($values[array_search('..', $values)]);
					// Supprimer les $values qui ne sont pas csv ou txt
					for($i=2; $i <= count($values); $i++){
						if ( pathinfo($dir.'/'.$values[$i],PATHINFO_EXTENSION) !== 'txt' && pathinfo($dir.'/'.$values[$i],PATHINFO_EXTENSION) !== 'csv') unset($values[$i]);	
					}
					if (count($values) <= 1){
						self::$csvFiles = array(0 => $text['agenda']['config'][1].self::DATAFILE.'adresses');
					}
					else{
						//Modifier les clefs (qui sont les valeurs de retour du formulaire avec 'config_fichier_csv_txt') avec clef = valeur
						self::$csvFiles = array_combine($values,$values);
					}
				}
				else {
					self::$csvFiles = array(0 => $text['agenda']['config'][2].self::DATAFILE.$text['agenda']['config'][5]);
				}
				
				// Copie des fichiers ics entre les dossiers self::DATAFILE.ics et self::DATAMODULE.ics pour export
				$this->custom_copy(self::DATAFILE.'ics', self::DATAMODULE.'ics');
				$this->custom_copy(self::DATAMODULE.'ics', self::DATAFILE.'ics');
				
				// Valeurs en sortie hors soumission du formulaire
				$this->addOutput([
					'showBarEditButton' => true,
					'showPageContent' => false,
					'vendor' => [
						'tinycolorpicker'
					],
					'view' => 'config'
				]);
			}
		}
	}
	
	/**
	 * Liaison entre edition et suppression d'un évènement
	 */
	public function deleteEvent() {
		$json = file_get_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json');
		$lid = $this->getUrl(2);
		$sauve = true;
		$this->delete($lid, $sauve, $json);
	}
	
	/**
	 * Suppression d'un évènement
	 */
	public function delete($lid, $sauve, $json) {
		// Autorisation si groupe autorisé à modifier l'evt $lid
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		$json = file_get_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json');
		$tableau = json_decode($json, true);
		if( $group < $tableau[$lid]['groupe_mod'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/agenda/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_agenda.php');
			$json_initial = $json;
			//$pos1 et $pos2 sont les délimiteurs de la partie à supprimer
			$pos1 = strpos($json, '{"id":'.$lid);
			// si $pos1 non trouvé pas d'effacement
			if ( $pos1 !== false ){
				$pos2 = strpos($json, '}', $pos1);
				//Premier évènement ?
				if ($pos1 < 2) {
					//Premier ! et dernier évènement ?
					if (strlen($json) < $pos2 + 4){
						$json ='[]';
					}
					else{
						$json = substr_replace($json,'{},',$pos1, $pos2-$pos1+2);
					}
				}
				else{
					$json = substr_replace($json,',{}',$pos1-1, $pos2-$pos1+2);
				}
				
				//Enregistrer le nouveau fichier json
				//file_put_contents(self::DATAMODULE.'data/'.$this->getUrl(0).'/events.json', $json);
				
				//Enregistrer le json et sauvegarder dans data_sauve si suppression de l'évènement et non modification
				if ($sauve == true){
					file_put_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json', $json);
					$this->sauve($json);
					
					// Emission d'un mailing éventuel en récupérant les valeurs dans le $json initial
					$tableau = json_decode($json_initial, true);
					$mailing_val = '0';
					$mailing_adresses = $text['agenda']['delete'][0];
					// Si la clef 'mailing_val' existe dans events.json (version >=3.0) lire mailing_val et mailing_adresses
					if( isset( $tableau[$lid]['mailing_val'] )){
						$mailing_val = $tableau[$lid]['mailing_val'];
						$mailing_adresses = $tableau[$lid]['mailing_adresses'];
						self::$sujet_mailing = $text['agenda']['delete'][1];
					}
					$evenement_texte = $text['agenda']['delete'][2].$tableau[$lid]['title'];
					$date_debut = $tableau[$lid]['start'];
					$date_fin = $tableau[$lid]['end'];
					if( $mailing_val === '1') $this->mailing($evenement_texte, $date_debut, $date_fin, $mailing_val, $mailing_adresses);	
					//Valeurs en sortie si suppression demandée et réalisée
					$this->addOutput([
							'notification' => $text['agenda']['delete'][3],
							'redirect' => helper::baseUrl() . $this->getUrl(0),
							'state' => true
					]);
				}
				else{
					return $json;
				}
			}
			else{
				return $json;
			}
		}
	}
	
	
	/**
	 * Suppression de tous les évènements
	 */
	public function deleteall() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < agenda::$actions['deleteall'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/agenda/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_agenda.php');
			//Sauvegarde dans data de l'agenda actuel bien qu'il soit déjà sauvegardé dans data_sauve
			$json = file_get_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json');
			file_put_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events_'.date('YmdHis').'.json', $json);
			
			//Enregistrer le nouveau fichier json vide
			$json='[]';	
			file_put_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json', $json);
			
			//Valeurs en sortie
			$this->addOutput([
					'notification' => $text['agenda']['deleteall'][0],
					'redirect' => helper::baseUrl() . $this->getUrl(0),
					'state' => true
			]);
		}
	}
	
	/*
	* Gestion des catégories
	*/
	public function categories(){
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < agenda::$actions['categories'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/agenda/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_agenda.php');
			// Soumission du formulaire
			if($this->isPost()) {
				
				// Ajout ou modification d'une catégorie
				if( $this->getInput('categorie_name') !== ''){
					$name = $this->getInput('categorie_name');
					$fond = $this->getInput('categorie_couleur_fond');
					$texte = $this->getInput('categorie_couleur_texte');
					$json = file_get_contents(self::DATAMODULE.'categories/categories.json');
					$tabcat = json_decode($json,true);
					$unsetkey = '';
					foreach($tabcat as $key=>$value){
						if($value['name'] === $name){
							unset( $value);
							$unsetkey = $key;
						}
					}
					$unsetkey === '' ? $indice = count($tabcat) : $indice = $unsetkey;
					$tabcat[$indice]['name'] = $name;
					$tabcat[$indice]['backgroundcolor'] = $fond;
					$tabcat[$indice]['textcolor'] = $texte;
					$tabcatjson = json_encode($tabcat);
					file_put_contents(self::DATAMODULE.'categories/categories.json', $tabcatjson);
				}
				
				// Validation du choix par catégorie enregistré dans module.json
				$valcategories = $this->getInput('val_categories', helper::FILTER_BOOLEAN);
				//Mise à jour de la validation du choix des couleurs par catégorie
				$this->setData(['module', $this->getUrl(0), 'categories', [
					'valCategories' => $valcategories
				]]);
			
				//Valeurs en sortie
				$this->addOutput([
						'notification' => $text['agenda']['categories'][0],
						'redirect' => helper::baseUrl() . $this->getUrl(),
						'state' => true
				]);
			}
			// Préparation du tableau d'affichage des catégories : nom, couleur du fond, couleur du texte
			$json = file_get_contents(self::DATAMODULE.'categories/categories.json');
			$tabcat = json_decode($json,true);
			foreach( $tabcat as $key=>$value ){
				self::$tabCategories[] = [
					$value['name'],
					$value['backgroundcolor'],
					$value['textcolor'],
					$value['name'] !== 'Défaut' ?
								template::button('categorieDelete' . $key, [
										'class' => 'buttonRed',
										'href' => helper::baseUrl() . $this->getUrl(0) . '/categorieDelete/' . $key,
										'value' => template::ico('cancel')
									])
								: '',
				];
			}
			// Valeurs en sortie hors soumission du formulaire
			$this->addOutput([
				'showBarEditButton' => true,
				'showPageContent' => false,
				'vendor' => [
					'tinycolorpicker'
				],
				'view' => 'categorie'
			]);
		}
	}
	
	/*
	* Suppression d'une catégorie
	*/
	public function categorieDelete(){
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < agenda::$actions['categorieDelete'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/agenda/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_agenda.php');		
			$json = file_get_contents(self::DATAMODULE.'categories/categories.json');
			$tabcat = json_decode($json,true);
			$name = $tabcat[$this->getUrl(2)]['name'];
			unset($tabcat[$this->getUrl(2)]);
			$ii = 0;
			$tab = [];
			foreach($tabcat as $key=>$value){
				$tab[$ii] = $value;
				$ii++;
			}	
			$tabcatjson = json_encode($tab);
			file_put_contents(self::DATAMODULE.'categories/categories.json', $tabcatjson);
			//Valeurs en sortie
			$this->addOutput([
					'notification' => $text['agenda']['categorieDelete'][0].$name.$text['agenda']['categorieDelete'][1],
					'redirect' => helper::baseUrl() . $this->getUrl(0).'/categories/',
					'state' => true
			]);
		}
	}
	
	/**
	 * Création
	 */
	public function creation() {
		// Lexique
		include('./module/agenda/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_agenda.php');	
		// Soumission du formulaire
		if($this->isPost()) {	
			$categorie = '';
			//lecture du formulaire
			if( $this->getData(['module', $this->getUrl(0), 'categories', 'valCategories' ]) === true ){
				$categorie = $this->getInput('creation_categorie');
				$json = file_get_contents(self::DATAMODULE.'categories/categories.json');
				$tabcat = json_decode( $json, true );	
				$couleur_fond = $tabcat[$categorie]['backgroundcolor'];
				$couleur_texte = $tabcat[$categorie]['textcolor'];
			}
			else{
				$couleur_fond = $this->getInput('creation_couleur_fond');
				$couleur_texte = $this->getInput('creation_couleur_texte');
			}
			$evenement_texte = $this->getInput('creation_text',null);
			$date_debut = $this->getInput('creation_date_debut');
			$date_fin = $this->getInput('creation_date_fin');
			$groupe_visible = $this->getInput('creation_groupe_lire');
			$groupe_mod = $this->getInput('creation_groupe_mod');
			$mailing_val = $this->getInput('creation_mailing_validation', helper::FILTER_BOOLEAN);
			$mailing_adresses = $this->getInput('creation_mailing_adresses');
			
			if($mailing_val === false){
				$mailing_val='0';
			}
			else{
				$mailing_val='1';
			}

			//Modification de CR LF " { } dans le texte de l'évènement
			$evenement_texte = $this->modif_texte($evenement_texte);
		
			//Vérification que date fin > date debut			
			if ($this->verif_date($date_debut,$date_fin)){ 
				self::$sujet_mailing = $text['agenda']['creation'][0];
				//Ajout et enregistrement de l'évènement
				$json = file_get_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json');
				$this->nouvel_evenement($evenement_texte,$date_debut,$date_fin,$couleur_fond,$couleur_texte,$groupe_visible,$groupe_mod,$mailing_val,$mailing_adresses,$categorie,$json);
		
				//Valeurs en sortie après prise en compte du formulaire
				$this->addOutput([
					'notification' => $text['agenda']['creation'][1],
					'state' => true,
					'redirect' => helper::baseUrl() . $this->getUrl(0)
				]);			
			}
			//Valeurs saisies non correctes
			else{
				$this->addOutput([
					'notification' => $text['agenda']['creation'][2],
					'view' => 'creation',
					'state' => false
				]);		
			}
		}
		else{
			
			// liste des emails des membres
			if(! is_dir(self::DATAMODULE.'adresses')) mkdir(self::DATAMODULE.'adresses',0770,true);
			// Liste des utilisateurs
			$membres = '';
			$editeurs = '';
			$moderateurs = '';
			$administrateurs = '';
			$inscrits = '';
			foreach($this->getData(['user']) as $userId => $arrayValues){
				if($userId != ''){
					$mail = $this->getData(['user',$userId,'mail']);
					switch ($this->getData(['user',$userId,'group'])) {
						case 1:
							$membres .= $mail.',';
							break;
						case 2:
							$editeurs .= $mail.',';
							break;
						case 3:
							$moderateurs .= $mail.',';
							break;
						case 4:
							$administrateurs .= $mail.',';
							break;
						default :
							break;
					}
					$inscrits .= $mail.',';
				}
			}
			//suppression de la dernière virgule
			if( $membres != ''){$membres = substr($membres, 0, -1);}
			if( $editeurs != ''){$editeurs = substr($editeurs, 0, -1);}
			if( $moderateurs != ''){$editeurs = substr($editeurs, 0, -1);}
			$administrateurs = substr($administrateurs, 0, -1);
			$inscrits = substr($inscrits, 0, -1);
			//Placer les listes dans un fichier txt et sauvegarder dans le dossier self::DATAMODULE.adresses
			file_put_contents(self::DATAMODULE.'adresses/editeurs_administrateurs.txt', $editeurs.','.$moderateurs.', '.$administrateurs);
			file_put_contents(self::DATAMODULE.'adresses/moderateurs_administrateurs.txt', $moderateurs.', '.$administrateurs);
			file_put_contents(self::DATAMODULE.'adresses/administrateurs.txt', $administrateurs);
			file_put_contents(self::DATAMODULE.'adresses/tous_inscrits.txt', $inscrits);
			
			// Sélection du fichier destinataires
			$dir=self::DATAMODULE.'adresses';
			self::$liste_adresses = scandir($dir);
			self::$liste_adresses[0] = $text['agenda']['creation'][3];
			unset(self::$liste_adresses[array_search('..', self::$liste_adresses)]);
			unset(self::$liste_adresses[array_search('.htaccess', self::$liste_adresses)]);
			if (count(self::$liste_adresses) <= 1){
				self::$liste_adresses = array(0 => $text['agenda']['creation'][4].self::DATAMODULE.'adresses');
			}
			else{
				self::$liste_adresses= array_combine(self::$liste_adresses,self::$liste_adresses);
			}
			// Tableau des catégories
			if( is_file(self::DATAMODULE.'categories/categories.json') && $this->getData(['module', $this->getUrl(0), 'categories', 'valCategories' ]) ){
				$json = file_get_contents(self::DATAMODULE.'categories/categories.json');
				$tabcat = json_decode( $json, true );
				self::$categorie = [];
				foreach( $tabcat as $key=>$value){
					self::$categorie[$key] = $tabcat[$key]['name'];
				}
			}
			//Récupérer la date cliquée
			$dateclic = self::$datecreation;
			self::$annee = intval(substr($dateclic, 0, 4));
			self::$mois = intval(substr($dateclic, 5, 2));
			self::$jour= intval(substr($dateclic, 8, 2));
			//Conversion date au format unix (valeur 0 au 1/1/1970 00:00)
			$date = new DateTime();
			//setDate(année, mois, jour) setTime(heure, minute)
			$date->setDate(self::$annee, self::$mois, self::$jour);
			$date->setTime(8, 00);
			self::$time_unix_deb = $date->getTimestamp();
			$date->setTime(18, 00);
			self::$time_unix_fin = $date->getTimestamp();
			// Valeurs en sortie hors soumission du formulaire
			$this->addOutput([
				'showBarEditButton' => true,
				'showPageContent' => false,
				'vendor' => [
						'flatpickr',
						'tinymce'
					],
				'view' => 'creation'
			]);
		}
	}
	
	/**
	 * Edition, modification, suppression
	 */
	public function edition($lid) {
		// Lexique
		include('./module/agenda/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_agenda.php');
		//Préparation avant l'édition de l'évènement
		self::$evenement['id'] = $lid;
		$json = file_get_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json');
		$tableau = json_decode($json, true);
		self::$evenement['groupe_lire'] = $tableau[$lid]['groupe_lire'];
		self::$evenement['groupe_mod'] = $tableau[$lid]['groupe_mod'];
		self::$evenement['texte'] = $this->restaure_texte($tableau[$lid]['title']);
		self::$evenement['couleurfond'] = $tableau[$lid]['backgroundColor'];
		self::$evenement['couleurtexte'] = $tableau[$lid]['textColor'];	
		self::$evenement['categorie'] = $tableau[$lid]['categorie'];
		$dateclic = $tableau[$lid]['start'];
		self::$evenement['datedebut'] = $this->conversion_date($dateclic);	
		$dateclic = $tableau[$lid]['end'];
		self::$evenement['datefin'] = $this->conversion_date($dateclic);
		
		//Soumission du formulaire
		if($this->isPost()) {
			$categorie = $tableau[$lid]['categorie'];
			//lecture du formulaire
			if( self::$evenement['categorie'] != '' ){		
				$categorie = $this->getInput('edition_categorie');
				$jsone = file_get_contents(self::DATAMODULE.'categories/categories.json');
				$tabcat = json_decode( $jsone, true );	
				$couleur_fond = $tabcat[$categorie]['backgroundcolor'];
				$couleur_texte = $tabcat[$categorie]['textcolor'];
			}
			else{
				$couleur_fond = $this->getInput('edition_couleur_fond');
				$couleur_texte = $this->getInput('edition_couleur_texte');
			}
			$evenement_texte = $this->getInput('edition_text', null);
			$date_debut = $this->getInput('edition_date_debut');
			$date_fin = $this->getInput('edition_date_fin');
			$groupe_visible = $this->getInput('edition_groupe_lire');
			$groupe_mod = $this->getInput('edition_groupe_mod');
			
			// Si la clef 'mailing_val' existe dans events.json (version >=3.0) lire mailing_val et mailing_adresses
			if( isset( $tableau[$lid]['mailing_val'] )){
				$mailing_val = $tableau[$lid]['mailing_val'];
				$mailing_adresses = $tableau[$lid]['mailing_adresses'];
				self::$sujet_mailing = $text['agenda']['edition'][0];
			}
			else{
				$mailing_val = '0';
				$mailing_adresses = $text['agenda']['edition'][1];
			}

			//Modification de CR LF " { } dans le texte de l'évènement
			$evenement_texte = $this->modif_texte($evenement_texte);
		
			//Vérification que date fin > date debut			
			if ($this->verif_date($date_debut,$date_fin)){ 
			
				//Effacer l'évènement sans sauvegarde dans data_sauve
				$sauve = false;
				$json = $this->delete($lid, $sauve, $json);
				
				//Ajout, enregistrement et sauvegarde de l'évènement
				$this->nouvel_evenement($evenement_texte,$date_debut,$date_fin,$couleur_fond,$couleur_texte,$groupe_visible,$groupe_mod,$mailing_val,$mailing_adresses,$categorie,$json);

				//Valeurs en sortie après prise en compte du formulaire
				$this->addOutput([
					'notification' => $text['agenda']['edition'][2],
					'state' => true,
					'redirect' => helper::baseUrl() . $this->getUrl(0)
				]);

			}
			//Valeurs saisies non correctes
			else{
				$this->addOutput([
					'notification' => $text['agenda']['edition'][3],
					'view' => 'edition',
					'state' => false
				]);				
			}
		}
		else{
			// Traitement avant affichage
			if( self::$evenement['categorie'] != '' ){
				$json = file_get_contents(self::DATAMODULE.'categories/categories.json');
				$tabcat = json_decode( $json, true );
				self::$categorie = [];
				foreach( $tabcat as $key=>$value){
					self::$categorie[$key] = $tabcat[$key]['name'];
				}
			}
			if( $this->getUser('group') >= self::$evenement['groupe_mod']){

				// Affichage de la page édition d'un évènement avec les valeurs actuelles
				$this->addOutput([
					'showBarEditButton' => true,
					'showPageContent' => false,
					'vendor' => [
							'flatpickr',
							'tinymce'
						],
					'view' => 'edition'
				]);
			}
			else{
				//vue simple de l'évènement si la modification n'est pas autorisée pour cet utilisateur
				$this->addOutput([
					'showBarEditButton' => true,
					'showPageContent' => false,
					'view' => 'vuesimple'
				]);
			}
		}
	}

	
	/**
	 * Newname utilisé pour inscrire le nouveau nom de page dans le json du module
	 */
	 public function newname() {
			$this->setData(['module',$this->getUrl(0),'name',$this->getUrl(0)]);
	 }
	 
	/**
	 * Accueil
	 */
	public function index() {
		// Lexique
		include('./module/agenda/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_agenda.php');
		// Mise à jour des données de module
		if (null === $this->getData(['module', $this->getUrl(0), 'config', 'versionData']) || version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), self::VERSION, '<')) $this->update();
		//Pour récupération des données ajax jquery date ou id 
		$url = $_SERVER['REQUEST_URI'];
		if (strpos($url,'/da:') !== false){
			//Extraction des données de la chaîne url et détection de changement de vue
			$dateclic = $this->vue_debut($url,'/da:');
			self::$datecreation = $dateclic;
			//Vers la création d'un évènement
			$this->creation();
		}
		else{
			if (strpos($url,'/id:') !== false){	
				//Extraction des données de la chaîne url et détection de changement de vue
				$idclic = $this->vue_debut($url,'/id:');
				//Vers l'édition d'un évènement
				$this->edition($idclic);
			}
			else{
				//Initialisations des paramètres de configuration du module et création des dossiers de sauvegarde
				if( null === $this->getData(['module', $this->getUrl(0), 'vue'])) {
					// name est utilisé pour détecter un changement de nom de la page contenant le module
					$this->setData(['module',$this->getUrl(0),[
						'name' => $this->getUrl(0),
						'vue' => [
							'vueagenda' => 'dayGridMonth',
							'debagenda' => date('Y-m-d')
						],
						'config' => [
							'droit_creation' => 2,
							'droit_limite' => true,
							'maxiWidth' => '800',
							'gridColor' => 'rgba(146, 52, 101, 1)',
							'versionData' => self::VERSION
						],
						'categories' => [
							'valCategories' => false
						]
					]]);
				
					// Upload des ressources puis création des dossiers de sauvegarde de l'agenda
					$this->custom_copy('./module/agenda/ressource/data', self::DATA_DIR);
					$this->custom_copy('./module/agenda/ressource/file', self::FILE_DIR);
					if(! is_dir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'))mkdir(self::DATA_DIR. self::$i18n.'/data_module/agenda/');
					if(! is_dir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0)))mkdir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0));
					if(! is_dir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_sauve'))mkdir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_sauve');
					if(! is_dir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_visible')) mkdir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_visible');
					if(! is_dir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_affiche')) mkdir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_affiche');
					if(! is_dir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0))) mkdir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0));
					if(! is_dir(self::DATAFILE.'categories')) mkdir(self::DATAFILE.'categories');
					// copie des fichiers htaccess
					copy( 'module/agenda/ressource/data/agenda/module/data/.htaccess', self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_sauve/.htaccess' );
					copy( 'module/agenda/ressource/data/agenda/module/data/.htaccess', self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_visible/.htaccess' );
					copy( 'module/agenda/ressource/data/agenda/module/data/.htaccess', self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_affiche/.htaccess' );
					copy( 'module/agenda/ressource/data/agenda/module/data/.htaccess', self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/.htaccess' );
					$this->addOutput([
							'notification' => $text['agenda']['index'][0],
							'redirect' => helper::baseUrl() . $this->getUrl(0).'/config/',
							'state' => true
					]);	
				}
				else{
					// Page renommée : détection du changement de nom de la page pour copier les dossiers avec leur nouveau nom
					if(! is_dir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0))){
						$oldname = $this->getData(['module', $this->getUrl(0), 'name']);
						$newname = $this->getUrl(0);
						$this->copyDir( self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$oldname, self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$newname);
						$this->copyDir( self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$oldname.'_visible' , self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$newname.'_visible');
						$this->copyDir( self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$oldname.'_sauve' , self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$newname.'_sauve');
						$this->copyDir( self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$oldname.'_affiche' , self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$newname.'_affiche');	
						// suppression des anciens dossiers
						$this->removeDir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$oldname);
						$this->removeDir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$oldname.'_visible');
						$this->removeDir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$oldname.'_sauve');
						$this->removeDir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$oldname.'_affiche');
						
						$this->addOutput([
								'notification' => $text['agenda']['index'][1],
								'state' => true
						]);	
						$this->newname();
			
					}
				}	
				//Si le fichier events.json n'existe pas ou si sa taille est inférieure à 2 on le crée vide
				if( is_file(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json') === false || 
				( is_file(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json') === true && filesize(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json')<2)){
					file_put_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json', '[]');
				}
				
				//Création d'une copie d'events.json visible en fonction des droits
				$json = file_get_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json');
				$tableau = json_decode($json, true);
				foreach($tableau as $key=>$value){
					if( isset($value['groupe_lire'])){
						if($value['groupe_lire'] > $this->getUser('group')){
								$json = $this->delete_visible($json,$key);
						}
						else{
							if( isset ($value['title'])){
								$newvalues = html_entity_decode($value['title']);
								$newvalue = strip_tags($newvalues);
								//Modification de CR LF " { } dans le texte de l'évènement
								$newvalue = $this->sup_texte($newvalue);
								$json = str_replace($value['title'], $newvalue, $json); 
							}
						}
					}
				}
				file_put_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_affiche/events.json',$json);
				
				// Affichage de la page agenda
				$this->addOutput([
					'showBarEditButton' => true,
					'showPageContent' => true,
					'vendor' => [
						'js'
					],
					'view' => 'index'
				]);
			
			}
		}

	}
	

	/* 
	/*Fonctions privées
	*/
	
	/* Conversion date au format unix (valeur 0 au 1/1/1970 00:00)
	*/
	private function conversion_date($dateclic){
		$annee = intval(substr($dateclic, 0, 4));
		$mois = intval(substr($dateclic, 5, 2));
		$jour= intval(substr($dateclic, 8, 2));
		$heure = intval(substr($dateclic, 11, 2));
		$minute = intval(substr($dateclic, 14, 2));
		$date = new DateTime();
		$date->setDate($annee, $mois, $jour);
		$date->setTime($heure, $minute);
		return $date->getTimestamp();
	}
	
	
	/* Vérification que $datedebut précède $datefin
	*/
	private function verif_date($datedebut, $datefin){
		$result = false;
		$date[0] = $datedebut;
		$date[1] = $datefin;
		for($key = 0; $key <2; $key++){
			$annee = substr($date[$key],0,4);
			$mois = substr($date[$key],5,2);
			$jour = substr($date[$key],8,2);
			$heure = substr($date[$key],11,2);
			$minute = substr($date[$key],14,2);
			$valdate[$key] = intval($annee.$mois.$jour.$heure.$minute);
		}
		if ($valdate[0] <= $valdate[1]){ $result = true;}
		return $result;
	}
	
	/*Modifier date format ics yyyymmddThhmm...  ou yyyymmdd vers format fullcalendar yyyy-mm-ddThh:mm ou yyyy-mm-dd
	*/
	private function modif_date($datein, $clef){
		if (strpos($clef, 'VALUE=DATE') !== false){
			$dateout = substr($datein, 0, 4).'-'.substr($datein, 4, 2).'-'.substr($datein, 6, 2);
		}
		else{
			$dateout = substr($datein, 0, 4).'-'.substr($datein, 4, 2).'-'.substr($datein, 6, 5).':'.substr($datein, 11, 2);
		}
		return $dateout;
	}
						
		
	
	/* Modification de CR LF " ' { } dans le texte de l'évènement
	*/
	private function modif_texte($evenement_texte){
		$evenement_texte = str_replace(CHR(13),"&#13;",$evenement_texte);
		$evenement_texte = str_replace(CHR(10),"&#10;",$evenement_texte);
		$evenement_texte = str_replace('"','&#34;',$evenement_texte);
		$evenement_texte = str_replace("&#39;","'",$evenement_texte);
		$evenement_texte = str_replace('}','&#125;',$evenement_texte);
		$evenement_texte = str_replace('{','&#123;',$evenement_texte);
		return $evenement_texte;
	}
	
	/* Suppression de CR LF " ' { } dans le texte de l'évènement
	*/
	private function sup_texte($evenement_texte){
		$evenement_texte = str_replace(CHR(13),"",$evenement_texte);
		$evenement_texte = str_replace(CHR(10),"",$evenement_texte);
		$evenement_texte = str_replace('"',' ',$evenement_texte);
		$evenement_texte = str_replace("&#39;","'",$evenement_texte);
		$evenement_texte = str_replace('}',' ',$evenement_texte);
		$evenement_texte = str_replace('{',' ',$evenement_texte);
		return $evenement_texte;
	}
	
	/* Restauration des CR LF " ' { } dans le texte de l'évènement
	*/
	private function restaure_texte($evenement_texte){
		$evenement_texte = str_replace("&#13;",CHR(13),$evenement_texte);
		$evenement_texte = str_replace("&#10;",CHR(10),$evenement_texte);
		$evenement_texte = str_replace('&#34;','"',$evenement_texte);
		$evenement_texte = str_replace("&#39;","'",$evenement_texte);
		$evenement_texte = str_replace('&#125;','}',$evenement_texte);
		$evenement_texte = str_replace('&#123;','{',$evenement_texte);
		return $evenement_texte;
	}
	
	/* Ajout et enregistrement d'un évènement sur création ou édition, émission de mail si mailing_val = '1'
	*/
	private function nouvel_evenement($evenement_texte,$date_debut,$date_fin,$couleur_fond,$couleur_texte,$groupe_visible,$groupe_mod,$mailing_val, $mailing_adresses, $categorie, $json){
		//Changement du format des dates yyyy-mm-dd hh:mm:0  vers format fullcalendar yyyy-mm-ddThh:mm
		$date_debut = str_replace(' ','T',$date_debut);
		$date_fin = str_replace(' ','T',$date_fin);
		
		//Limitation à 16 caractères
		$date_debut = substr($date_debut,0,16);
		$date_fin = substr($date_fin,0,16);
		
		//Ouverture et décodage du fichier json
		if($json == ''){$json = file_get_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json');}
		$tableau = json_decode($json, true);
		$keynew = count($tableau);
		
		//Chaîne à ajouter de type ,{"id":"2","title":"...","start":"...","end":"...","backgroundColor":"...","textColor":"...","groupe":"..."}   etc... ]
		//Sans la virgule initiale si c'est le premier évènement
		if (strlen($json) > 2){
			$new = ',{"id":'.$keynew.',"title":"'.$evenement_texte.'","start":"'.$date_debut.'","end":"'
			.$date_fin.'","backgroundColor":"'.$couleur_fond.'","textColor":"'.$couleur_texte.'","groupe_lire":"'.$groupe_visible.'","groupe_mod":"'
			.$groupe_mod.'","mailing_val":"'.$mailing_val.'","mailing_adresses":"'.$mailing_adresses.'","categorie":"'.$categorie.'"}]';
		}
		else{
			$new = '{"id":'.$keynew.',"title":"'.$evenement_texte.'","start":"'.$date_debut.'","end":"'
			.$date_fin.'","backgroundColor":"'.$couleur_fond.'","textColor":"'.$couleur_texte.'","groupe_lire":"'.$groupe_visible.'","groupe_mod":"'
			.$groupe_mod.'","mailing_val":"'.$mailing_val.'","mailing_adresses":"'.$mailing_adresses.'","categorie":"'.$categorie.'"}]';
		}
		$json = str_replace(']',$new,$json);
		
		//Enregistrement dans le fichier json et sauvegarde pour restauration par "Agenda précédent"
		file_put_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'/events.json', $json);
		$this->sauve($json);
		if($mailing_val === '1') $this->mailing($evenement_texte, $date_debut, $date_fin, $mailing_val, $mailing_adresses);
	}
	
	/* Sauvegarde automatique de l'agenda sous une forme datée après chaque création, modification, suppression d'un évènement
	* ou chargement d'un nouvel agenda, seuls les 10 derniers agendas sont sauvegardés
	*/
	private function sauve($sauve_json) {

		//Sauvegarde du fichier json actuel
		file_put_contents(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_sauve/events_'.date('YmdHis').'.json', $sauve_json);
			
		//Effacement du plus ancien fichier de sauvegarde auto si le nombre de fichiers dépasse 10
		$dir=self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_sauve';
		$nom_fichier = scandir($dir);
		//Comptage du nombre de fichiers de sauvegarde auto
		$nb_sauve_auto = 0;
		$plus_ancien_clef = 0;
		foreach($nom_fichier as $key=>$value){
			if(strpos($value,'events_') !== false && strlen($value) == 26){
				if ($nb_sauve_auto == 0) { $plus_ancien_clef = $key;}
				$nb_sauve_auto++;
			}
		}
		if ($nb_sauve_auto > 10){
			$handle = opendir(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_sauve');
			unlink(self::DATA_DIR. self::$i18n.'/data_module/agenda/'.$this->getUrl(0).'_sauve/'.$nom_fichier[$plus_ancien_clef]);
			closedir($handle);
		}
	}
	
	/* Suppression d'évènements dans le json public ( visible) en fonction des droits
	*/ 
	private function delete_visible($json,$lid) {
		//$pos1 et $pos2 sont les délimiteurs de la partie à supprimer
		$pos1 = strpos($json, '{"id":'.$lid);
		$pos2 = strpos($json, '}', $pos1);
		//Premier évènement ?
		if ($pos1 < 2) {
			//Premier ! et dernier évènement ?
			if (strlen($json) < $pos2 + 4){
				$json ='[]';
			}
			else{
				$json = substr_replace($json,'{},',$pos1, $pos2-$pos1+2);
			}
		}
		else{
			$json = substr_replace($json,',{}',$pos1-1, $pos2-$pos1+2);
		}
		return $json;
	}
	
	/*
	* Extraction des données de la chaîne url et détection de changement de vue
	*/
	private function vue_debut($url,$idda) {
		// Lexique
		include('./module/agenda/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_agenda.php');
		$pos1 = strpos($url,$idda);
		$pos2 = strpos($url,'vue:');
		$pos3 = strpos($url,'deb:');
		$iddaclic = substr($url,$pos1 + 4, $pos2-($pos1+4));
		$grid = substr($url,$pos2 + 4, $pos3-($pos2+4));
		$deb = substr($url,$pos3 + 4, 10);
		$gridold = $this->getData(['module', $this->getUrl(0), 'vue','vueagenda']);
		$debold = $this->getData(['module', $this->getUrl(0), 'vue','debagenda']);
		if($grid != $gridold || $deb != $debold){
			$this->setData(['module', $this->getUrl(0), 'vue', [
				'vueagenda' => $grid,
				'debagenda' => $deb
				]]);		
			$this->addOutput([
				'notification' => $text['agenda']['vue_debut'][0],
				'state' => true
			]);	
		}
		return $iddaclic;
	}
	
	/* Function is to get all the contents from ics and explode all the datas according to the events and its sections */
    function getIcsEventsAsArray($file) {
        $icalString = file_get_contents ( $file );
        $icsDates = array ();
        /* Explode the ICs Data to get datas as array according to string ‘BEGIN:’ */
        $icsData = explode ( "BEGIN:", $icalString );
        /* Iterating the icsData value to make all the start end dates as sub array */
        foreach ( $icsData as $key => $value ) {
            $icsDatesMeta [$key] = explode ( "\n", $value );
        }
        /* Itearting the Ics Meta Value */
        foreach ( $icsDatesMeta as $key => $value ) {
            foreach ( $value as $subKey => $subValue ) {
                /* to get ics events in proper order */
                $icsDates = $this->getICSDates ( $key, $subKey, $subValue, $icsDates );
            }
        }
        return $icsDates;
    }
	
    /* funcion is to avaid the elements wich is not having the proper start, end  and summary informations */
    function getICSDates($key, $subKey, $subValue, $icsDates) {
        if ($key != 0 && $subKey == 0) {
            $icsDates [$key] ["BEGIN"] = $subValue;
        } else {
            $subValueArr = explode ( ":", $subValue, 2 );
            if (isset ( $subValueArr [1] )) {
                $icsDates [$key] [$subValueArr [0]] = $subValueArr [1];
            }
        }
        return $icsDates;
    }
	
	/* Fonction mailing($evenement_texte, $date_debut, $date_fin, $mailing_val, $mailing_adresses)
	/*
	*/
	private function mailing($evenement_texte, $date_debut, $date_fin, $mailing_val, $mailing_adresses){
		// Lexique
		include('./module/agenda/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_agenda.php');
		$adresses = file_get_contents(self::DATAMODULE.'adresses/'.$mailing_adresses);
		if( strpos( $adresses, '@' ) !== false){
			// Conversion $adresses en tableau
			$to=[];
			$to = explode(',',$adresses);
			//filtrage des éléments du tableau $to qui ne contiennent pas @ pour fichiers txt ou csv
			$num = count($to);
			for ($c=0; $c < $num; $c++) {
				if (strrchr($to[$c], '@') === false){
					unset($to[$c]);
				}
			}
			// Modification de l'aspect des dates : 2020-12-04T08:00 vers 04/12/2020 à 08:00
			$date_debut = $this->change_date($date_debut);
			$date_fin = $this->change_date($date_fin);
			$subject = self::$sujet_mailing;
			$content = $text['agenda']['mailing'][0].$evenement_texte.'<br/>'.$text['agenda']['mailing'][1].' -> '.$date_debut.'<br/><br/>'.$text['agenda']['mailing'][2].' -> '.$date_fin;
			$mode = 'bcc';
			$this->envoyerMail($to, $subject, $content, $mode);
		}
	}
	
	
	/* Fonction envoyerMail($to, $subject, $content, $mode)
	/* Copie de la fonction sendMail() de core.php avec en plus l'argument $mode pour cacher ou non les destinataires*/
	private function envoyerMail($to, $subject, $content, $mode){
		// Layout
		ob_start();
		include './core/layout/mail.php';
		$layout = ob_get_clean();
		// Mail
		try{
			$mail = new PHPMailer\PHPMailer\PHPMailer;
			$mail->CharSet = 'UTF-8';
			if(null !== $this->getData(['config', 'mailDomainName']) &&  $this->getData(['config', 'mailDomainName']) !==''){
				$host = $this->getData(['config', 'mailDomainName']);
			} else {
				$host = str_replace('www.', '', $_SERVER['HTTP_HOST']);
			}
			$mail->setFrom('no-reply@' . $host, $this->getData(['config', 'title']));
			$mail->addReplyTo('no-reply@' . $host, $this->getData(['config', 'title']));
			if(is_array($to)) {
					foreach($to as $userMail) {
						if ( $mode == 'bcc' ){
							$mail->addBCC($userMail);
						}
						else{
							$mail->addAddress($userMail);
						}	
					}
			}
			else {
				if ( $mode == 'bcc' ){
					$mail->addBCC($to);
				}
				else{
					$mail->addAddress($to);
				}
			}
			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->addCustomHeader('List-Unsubscribe', '<mailto:no-reply@'.$host.'>');
			$mail->Body = $layout;
			$mail->AltBody = strip_tags($content);
			if($mail->send()) {
					return true;
			}
			else {
					return $mail->ErrorInfo;
			}
		} catch (phpmailerException $e) {
			return $e->errorMessage();
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	
	/*
	** Fonction change_date($date) Modification de l'aspect des dates : 2020-12-04T08:00 vers 04/12/2020 à 08:00
	*/
	private function change_date( $date ){
		$jour = substr($date, 8, 2);
		$mois = substr($date, 5, 2);
		$annee = substr($date, 0, 4);
		$heure = substr($date, 11, 2);
		$minute = substr($date, 14, 2);
		$date = $jour.'/'.$mois.'/'.$annee.' à '.$heure.':'.$minute;
		return $date;
	}
	
		/*
	* Copie récursive de dossiers
	*
	*/
	private function custom_copy($src, $dst) {
		// open the source directory
		$dir = opendir($src);
		// Make the destination directory if not exist
		if (!is_dir($dst)) {
			mkdir($dst);
		}
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

}