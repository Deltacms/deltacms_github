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

class translate extends common {

	public static $actions = [
		'index' => self::GROUP_ADMIN,
		'copy' => self::GROUP_ADMIN,
		'i18n' => self::GROUP_VISITOR
	];

	public static $translateOptions = [];

	// Liste des langues installées
	public static $languagesInstalled = [];
	// Liste des langues cibles
	public static $languagesTarget = [];
	// Activation du bouton de copie
	public static $siteTranslate = true;
	// Variable pour construire la liste des pages du site
	public static $pagesList = [];

	/**
	 * Configuration avancée des langues
	 */
	public function copy() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < translate::$actions['copy'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/translate/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_translate.php');
			// Tableau des pages, sous-pages et barres
			$pagesList = $this->getData(['page']);
			foreach($pagesList as $page => $pageId) {
				if ( $this->getData(['page',$page,'title']) === null ) unset($pagesList[$page]);	
			}
			// Soumission du formulaire
			if ($this->isPost()) {
				// Initialisation
				$success = false;
				if( $this->getInput('translateCopyAllPages') === '1'){
					$copyFrom = $this->getInput('translateFormCopySource');
				} else {
					if( $this->getInput('DELTA_I18N_SITE') === '' || $this->getInput('DELTA_I18N_SITE')=== null || $this->getInput('DELTA_I18N_SITE') === 'base'){
						$copyFrom = 'base';
					}
					else{
						$copyFrom = $this->getInput('DELTA_I18N_SITE');
					}
				}
				$toCreate = $this->getInput('translateFormCopyTarget');
				$this->setData([ 'config', 'i18n', 'CopyTarget', $toCreate]);
				// Tableau des langues installées
				foreach ($i18nList as $key => $value) {
					if ($this->getData(['config','i18n', $key]) === 'site') {
						$tabLanguagesTarget[$key] = $value;
					}
				}
				$langTarget = $tabLanguagesTarget[$toCreate];
				if ($copyFrom !== $toCreate) {
					// Création du dossier
					if (is_dir(self::DATA_DIR . $toCreate) === false ) { // Si le dossier est déjà créé
						$success  = mkdir (self::DATA_DIR . $toCreate, 0755);
						$success  = mkdir (self::DATA_DIR . $toCreate.'/content', 0755);
						$success  = mkdir (self::DATA_DIR . $toCreate.'/data_module', 0755);
					} else {
						$success = true;
					}
					if( $this->getInput('translateCopyAllPages') === '1'){
						// Copie de toutes les pages / Copier les données par défaut avec gestion des erreurs
						$success  = (copy (self::DATA_DIR . $copyFrom . '/locale.json', self::DATA_DIR . $toCreate . '/locale.json') === true && $success  === true) ? true : false;
						$success  = (copy (self::DATA_DIR . $copyFrom . '/module.json', self::DATA_DIR . $toCreate . '/module.json') === true && $success  === true) ? true : false;
						$success  = (copy (self::DATA_DIR . $copyFrom . '/page.json', self::DATA_DIR . $toCreate . '/page.json') === true && $success  === true) ? true : false;
						$success  = ($this->copyDir (self::DATA_DIR . $copyFrom . '/content', self::DATA_DIR . $toCreate . '/content') === true && $success  === true) ? true : false;
						$success  = (copy ('core/module/translate/ressource/comment.json', self::DATA_DIR . $toCreate . '/comment.json') === true && $success  === true) ? true : false;
						$success  = ($this->copyDir (self::DATA_DIR . $copyFrom . '/data_module', self::DATA_DIR . $toCreate . '/data_module') === true && $success  === true) ? true : false;
						// Enregistrer la langue
						if ($success) {
							$this->setData(['config', 'i18n', $toCreate, 'site' ]);
							$i18nListBase = array_merge(['base'	=> $text['core_translate']['copy'][5] ],self::$i18nList);
							$notification = $text['core_translate']['copy'][3] . $i18nListBase[$copyFrom] . $text['core_translate']['copy'][4] .  self::$i18nList[$toCreate];
						} else {
							$notification = $text['core_translate']['copy'][0];
						}
					} else {
						// Copie d'une seule page / Récupération de son id et du choix pour les barres
						$pageId = $this->getInput('translateCopyPage');
						$copyBarAuto = $this->getInput('translateCopyBarAuto');
						// Si le dossier langue (es, en, de...) ne contient pas le fichier page.json l'initialiser avec module vide,  page vide, locale de la langue d'origine
						if( !file_exists( self::DATA_DIR . $toCreate . '/page.json')){
							$success  = (copy (self::DATA_DIR . $copyFrom . '/locale.json', self::DATA_DIR . $toCreate . '/locale.json') === true && $success  === true) ? true : false;
							$success  = (copy ('core/module/translate/ressource/module.json', self::DATA_DIR . $toCreate . '/module.json') === true && $success  === true) ? true : false;
							$success  = (copy ('core/module/translate/ressource/page.json', self::DATA_DIR . $toCreate . '/page.json') === true && $success  === true) ? true : false;
							$success  = (copy ('core/module/translate/ressource/comment.json', self::DATA_DIR . $toCreate . '/comment.json') === true && $success  === true) ? true : false;							
						}
						// Si une page de même nom existe déjà elle sera écrasée
						// Si une page est de nom différent mais de position identique, elle sera ajoutée au menu dans le bon ordre
						// Ajouter les entrées $pageId dans page, module si existant et dans content
						$pageAdd = $this->getData(['page',$pageId]);
						$moduleAdd = $this->getData(['module',$pageId]);
						$jsonPage = file_get_contents(self::DATA_DIR . $toCreate . '/page.json');
						$jsonModule = file_get_contents(self::DATA_DIR . $toCreate . '/module.json');
						
						// Ajout des données dans page.json
						$fp= json_decode($jsonPage, true);
						$fp['page'] = array_merge($fp['page'], array($pageId => $pageAdd));
						// Si c'est une sous-page lire la valeur de parentPageId dans la langues d'origine et si il n'y a pas de page parent de même nom dans la langue cible positionner parentPageId à "" 
						if( ! array_key_exists( $this->getData(['page', $pageId, 'parentPageId']), $fp['page'])) $fp['page'][$pageId]['parentPageId'] = "";	
						// Si la page ou la sous-page possède 1 ou 2 barres les copier automatiquement si c'est autorisé, et copier leur contenu
						if( $copyBarAuto === '1' && ($this->getData(['page', $pageId, 'barLeft']) !== '' || $this->getData(['page', $pageId, 'barRight']) !== '')){
							$nameBar = $this->getData(['page', $pageId, 'barLeft']) !== '' ? $this->getData(['page', $pageId, 'barLeft']) : $this->getData(['page', $pageId, 'barRight']);
							$fp['page'] = array_merge($fp['page'], array( $nameBar => $this->getData(['page',$nameBar]) ));
							$success  = (copy (self::DATA_DIR . $copyFrom . '/content/'.$nameBar.'.html', self::DATA_DIR . $toCreate . '/content/'.$nameBar.'.html') === true && $success  === true) ? true : false;
						}						
						$jsonmod = json_encode($fp);
						file_put_contents(self::DATA_DIR . $toCreate . '/page.json',$jsonmod);
						
						// Ajout des données dans module.json
						if( $moduleAdd !== NULL && $moduleAdd !==''){
							$fp= json_decode($jsonModule, true);
							$fp['module'] = array_merge($fp['module'], array($pageId => $moduleAdd));
							$jsonmod = json_encode($fp);
							file_put_contents(self::DATA_DIR . $toCreate . '/module.json',$jsonmod);
						}
						// Ajout des données dans content						
						$success  = (copy (self::DATA_DIR . $copyFrom . '/content/'.$pageId.'.html', self::DATA_DIR . $toCreate . '/content/'.$pageId.'.html') === true && $success  === true) ? true : false;
						// Ajout des données, externes à module.json, contenues dans data_module/nom_de_la_page.json
						if( is_file( self::DATA_DIR . $copyFrom . '/data_module/'.$pageId.'.json' ) ) copy (self::DATA_DIR . $copyFrom . '/data_module/'.$pageId.'.json'  , self::DATA_DIR . $toCreate . '/data_module/'.$pageId.'.json' );
						// Cas particuliers d'une page agenda
						if( $this->getData(['page', $pageId, 'moduleId']) === 'agenda'){
							if(is_dir( self::DATA_DIR . $copyFrom . '/data_module/'.$pageId )) $this->copyDir(self::DATA_DIR . $copyFrom . '/data_module/'.$pageId, self::DATA_DIR . $toCreate . '/data_module/'.$pageId );
							if(is_dir( self::DATA_DIR . $copyFrom . '/data_module/'.$pageId .'_sauve' )) $this->copyDir(self::DATA_DIR . $copyFrom . '/data_module/'.$pageId .'_sauve', self::DATA_DIR . $toCreate . '/data_module/'.$pageId .'_sauve' );
							if(is_dir( self::DATA_DIR . $copyFrom . '/data_module/'.$pageId .'_affiche')) $this->copyDir(self::DATA_DIR . $copyFrom . '/data_module/'.$pageId .'_affiche', self::DATA_DIR . $toCreate . '/data_module/'.$pageId .'_affiche');
							if(is_dir( self::DATA_DIR . $copyFrom . '/data_module/'.$pageId .'_visible')) $this->copyDir(self::DATA_DIR . $copyFrom . '/data_module/'.$pageId .'_visible', self::DATA_DIR . $toCreate . '/data_module/'.$pageId .'_visible');
						}
						// Notification du titre court de la page copiée
						$notification = $this->getData(['page',$pageId,'shortTitle']).$text['core_translate']['copy'][7]. $langTarget;
					}
				} else {
					$success = false;
					$notification = $text['core_translate']['copy'][1];
				}
				// Valeurs en sortie
				$this->addOutput([
					'notification'  =>  $notification,
					'title' 		=> $text['core_translate']['copy'][2],
					'view' 			=> 'index',
					'state' 		=>  $success
				]);
			}
			// Classement pages, sous-pages, pages orphelines, barres
			foreach($pagesList as $page => $pageId) {
				if ( $this->getData(['page',$page,'parentPageId']) === '' ) $pagesList[$page]['type'] = 'page';
              	if ( $this->getData(['page',$page,'parentPageId']) !== '' ) $pagesList[$page]['type'] = 'sous-page';
              	if ( $this->getData(['page',$page,'position']) === 0 ) $pagesList[$page]['type'] = 'page orpheline';
              	if ( $this->getData(['page',$page,'block']) === 'bar' ) $pagesList[$page]['type'] = 'barre';
			}
			//Affichage des pages et mémorisation dans le tableau de sortie self::$pagesList
			// Type de page : titre court ( titre - identifiant )
			foreach($pagesList as $page => $pageId) {
				switch ($pagesList[$page]['type']){
					case 'page' :
						self::$pagesList[$page]= $text['core_translate']['copy'][8].$this->getData(['page',$page,'shortTitle']).' ( '. $this->getData(['page',$page,'title']).' - '.$page.' )';
					break;
					case 'sous-page' :
						self::$pagesList[$page]= $text['core_translate']['copy'][10].$this->getData(['page',$page,'shortTitle']).' ( '. $this->getData(['page',$page,'title']).' - '.$page.' )';
					break;
					case 'page orpheline' :
						self::$pagesList[$page]= $text['core_translate']['copy'][9]. $this->getData(['page',$page,'shortTitle']).' ( '. $this->getData(['page',$page,'title']).' - '.$page.' )';
					break;
					case 'barre' :
						self::$pagesList[$page]= $text['core_translate']['copy'][11].$this->getData(['page',$page,'shortTitle']).' ( '. $this->getData(['page',$page,'title']).' - '.$page.' )';
					break;
					
				}		
			}	
			// Tableau des langues installées
			foreach ($i18nList as $key => $value) {
				if ($this->getData(['config','i18n', $key]) === 'site') {
					self::$languagesTarget[$key] = $value;
				}
			}

			// Langues cibles avec dossier existant et base en plus
			$installed = self::$languagesTarget;
			foreach( $installed as $key=>$value){
				if( ! is_dir( self::DATA_DIR.$key )) unset( $installed[$key]);
			}
			self::$languagesInstalled = array_merge(['base'	=> $text['core_translate']['copy'][5] ],$installed);
			
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_translate']['copy'][2],
				'view' => 'copy'
			]);
		}
	}

	/**
	 * Configuration
	 */
	public function index() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < translate::$actions['index'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {		
			// Lexique
			include('./core/module/translate/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_translate.php');

			// Soumission du formulaire
			if($this->isPost()) {
				// Si la langue originale du site est modifiée
				if( $this->getData(['config', 'i18n', 'langBase']) !== $this->getInput('translateLangBase') ){
					// Sauvegarde du dossier 'base' dans un dossier code ISO de l'ancienne langue originale du site
					$this->copyDir('./site/data/base', './site/data/'.	$this->getData(['config', 'i18n', 'langBase']));
					// La nouvelle langue originale du site était une langue en traduction rédigée
					if( is_dir('./site/data/'.$this->getInput('translateLangBase'))){
						$this->removeDir('./site/data/base');
						rename('./site/data/'. $this->getInput('translateLangBase') , './site/data/base');	
					}
				}
				// Edition des langues
				foreach (self::$i18nList as $keyi18n => $value) {
					if ($keyi18n === 'base') continue;

					// Effacement d'une langue installée
					if ( is_dir( self::DATA_DIR . $keyi18n ) === true
						AND  $this->getInput('translate' . strtoupper($keyi18n)) === 'delete')
					{
							$this->removeDir( self::DATA_DIR . $keyi18n);
							// Au cas ou la langue est sélectionnée
							helper::deleteCookie('DELTA_I18N_SITE');
					}
				}
				// 'langBase' mémorise le code ISO de la langue sélectionnée ou de la valeur saisie si la langue sélectionnée est Autre langue
				$requiredOtherLang = false;
				$langBase = $this->getInput('translateLangBase');
				if( $langBase === 'none'){
					$langBase = $this->getInput('translateOtherBase');
					$requiredOtherLang = true;
				}

				// Enregistrement des données
				$this->setData(['config','i18n', [
					'enable'			=> $this->getData(['config', 'i18n', 'enable']),
					'langAdmin'			=> $this->getInput('translateLangAdmin'),
					'langBase'			=> $langBase,
					'otherLangBase'		=> $this->getInput('translateOtherBase', helper::FILTER_STRING_SHORT,$requiredOtherLang),
					'fr'		 		=> $this->getInput('translateFR'),
					'de' 		 		=> $this->getInput('translateDE'),
					'en' 			 	=> $this->getInput('translateEN'),
					'es' 			 	=> $this->getInput('translateES'),
					'it' 			 	=> $this->getInput('translateIT'),
					'nl' 			 	=> $this->getInput('translateNL'),
					'pt' 			 	=> $this->getInput('translatePT'),
					'el' 			 	=> $this->getInput('translateEL'),
					'da' 			 	=> $this->getInput('translateDA'),
					'fi' 			 	=> $this->getInput('translateFI'),
					'ga' 			 	=> $this->getInput('translateGA'),
					'sv' 			 	=> $this->getInput('translateSV'),
					'br' 			 	=> $this->getInput('translateBR'),
					'ca' 			 	=> $this->getInput('translateCA'),
					'co' 			 	=> $this->getInput('translateCO'),
					'eu' 			 	=> $this->getInput('translateEU')

				]]);
				
				// Mise à jour de la localisation
				$this->localisation($this->getData(['config', 'i18n', 'langAdmin' ]));
					
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(),
					'notification' => $text['core_translate']['index'][0],
					'state' => true
				]);
			}
			// Modification des options de suppression de la langue installée.
			foreach (self::$i18nList as $key => $value) {
				if ($this->getData(['config','i18n',$key]) === 'site') {
					self::$translateOptions [$key] = [
						'none'   => $text['core_translate']['index'][1],
						'site'   => $text['core_translate']['index'][3],
						'delete' => $text['core_translate']['index'][4]
					];				
					self::$siteTranslate = $key !== $this->getData(['config', 'i18n', 'langBase']) ? false : true;
				} else {
					self::$translateOptions [$key] = [
						'none'   => $text['core_translate']['index'][1],
						'site'   => $text['core_translate']['index'][3]
					];						
				}
				// Limitation du choix pour la langue d'origine
				if ( $key === $this->getData(['config', 'i18n', 'langBase'])){
					self::$translateOptions [$key] = [
						'none'   => $text['core_translate']['index'][1],
						'site'   => $text['core_translate']['index'][5]
					];			
				}			
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_translate']['index'][6],
				'view' => 'index'
			]);
		}
	}


	/*
	 * Traitement du changement de langue
	 * Fonction utilisée par le noyau
	 */
	public function i18n() {

		// Activation du drapeau sauf si c'est celui de la langue de base (drapeau utilisé pour revenir à la langue de base)
		if ( $this->getUrl(2) !== $this->getData(['config', 'i18n', 'langBase']) && $this->getInput('DELTA_I18N_' . strtoupper($this->getUrl(3))) !== $this->getUrl(2) ) {
			// Nettoyer et stocker le choix de l'utilisateur
			helper::deleteCookie('DELTA_I18N_SITE');	
			// Sélectionner
			setcookie('DELTA_I18N_' . strtoupper($this->getUrl(3)) , $this->getUrl(2), time() + 3600, helper::baseUrl(false, false)  , '', helper::isHttps(), true);
			// Mémorisation de la langue en Frontend et du type de traduction actif (site => rédigée, none => pas de traduction)	
			$_SESSION['langFrontEnd'] = $this->getUrl(2);
			$_SESSION['translationType'] = $this->getUrl(3);
		// Désactivation du drapeau, langue base par défaut
		} else {
			setcookie('DELTA_I18N_SITE' , 'base', time() + 3600, helper::baseUrl(false, false)  , '', helper::isHttps(), true);
			// Mise à jour des données de langue et de traduction en frontend
			$_SESSION['langFrontEnd'] = $this->getData(['config', 'i18n', 'langBase']);
			$_SESSION['translationType'] = 'none';			
		}

		// Valeurs en sortie
		$this->addOutput([
			'redirect' 	=> 	helper::baseUrl() . $this->getData(['locale', $this->getUrl(2), 'homePageId' ])
		]);
	}
}