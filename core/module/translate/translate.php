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

	/**
	 * Configuration avancée des langues
	 */
	public function copy() {
		// Lexique
		include('./core/module/translate/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_translate.php');

		// Soumission du formulaire
		if ($this->isPost()) {
			// Initialisation
			$success = false;
			$copyFrom = $this->getInput('translateFormCopySource');
			$toCreate = $this->getInput('translateFormCopyTarget');
			if ($copyFrom !== $toCreate) {
				// Création du dossier
				if (is_dir(self::DATA_DIR . $toCreate) === false ) { // Si le dossier est déjà créé
					$success  = mkdir (self::DATA_DIR . $toCreate, 0755);
					$success  = mkdir (self::DATA_DIR . $toCreate.'/content', 0755);
				} else {
					$success = true;
				}
				// Copier les données par défaut avec gestion des erreurs
				$success  = (copy (self::DATA_DIR . $copyFrom . '/locale.json', self::DATA_DIR . $toCreate . '/locale.json') === true && $success  === true) ? true : false;
				$success  = (copy (self::DATA_DIR . $copyFrom . '/module.json', self::DATA_DIR . $toCreate . '/module.json') === true && $success  === true) ? true : false;
				$success  = (copy (self::DATA_DIR . $copyFrom . '/page.json', self::DATA_DIR . $toCreate . '/page.json') === true && $success  === true) ? true : false;
				$success  = ($this->copyDir (self::DATA_DIR . $copyFrom . '/content', self::DATA_DIR . $toCreate . '/content') === true && $success  === true) ? true : false;
				// Enregistrer la langue
				if ($success) {
					$this->setData(['config', 'i18n', $toCreate, 'site' ]);
					$i18nListBase = array_merge(['base'	=> $text['core_translate']['copy'][5] ],self::$i18nList);
					$notification = $text['core_translate']['copy'][3] . $i18nListBase[$copyFrom] . $text['core_translate']['copy'][4] .  self::$i18nList[$toCreate];
				} else {
					$notification = $text['core_translate']['copy'][0];
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
		// Tableau des langues installées
		foreach ($i18nList as $key => $value) {
			if ($this->getData(['config','i18n', $key]) === 'site') {
				self::$languagesTarget[$key] = $value;
			}
		}

		// Langues cibles base en plus
		self::$languagesInstalled = array_merge(['base'	=> $text['core_translate']['copy'][5] ],self::$languagesTarget);
		
		// Valeurs en sortie
		$this->addOutput([
			'title' => $text['core_translate']['copy'][2],
			'view' => 'copy'
		]);
	}

	/**
	 * Configuration
	 */
	public function index() {
		// Lexique
		include('./core/module/translate/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_translate.php');

		// Soumission du formulaire
		if($this->isPost()) {
			// Si la langue originale du site choisie est seulement en traduction rédigée invalider la traduction automatique
			$script = $this->getInput('translateScriptGoogle', helper::FILTER_BOOLEAN);
			$langBase = $this->getInput('translateLangBase');
			if( array_key_exists( $langBase, self::$i18nListSiteOnly)) $script = false;
			// Désactivation du script Google
			if ($script === false) {
				setrawcookie('googtrans', '/base/base', time() + 3600, helper::baseUrl(false,false));
				$_SESSION['googtrans'] = '/base/base';
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
						helper::deleteCookie('DELTA_I18N_SCRIPT');
				}
			}
			// 'langBase' mémorise le code ISO de la langue sélectionnée ou de la valeur saisie si la langue sélectionnée est Autre langue
			$requiredOtherLang = false;
			if( $langBase === 'none'){
				$langBase = $this->getInput('translateOtherBase');
				$requiredOtherLang = true;
			}

			// Enregistrement des données
			$this->setData(['config','i18n', [
				'enable'			=> $this->getData(['config', 'i18n', 'enable']),
				'scriptGoogle'      => $script,
				'showCredits' 	 	=> $this->getInput('translateScriptGoogle', helper::FILTER_BOOLEAN) ? $this->getInput('translateCredits', helper::FILTER_BOOLEAN) : false,
				'autoDetect' 	 	=> $this->getInput('translateScriptGoogle', helper::FILTER_BOOLEAN) ? $this->getInput('translateAutoDetect', helper::FILTER_BOOLEAN) : false,
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
			
			// Modification de core/vendor/i18n/translation.js
			
			$translation = "function scriptGoogleElementInit() { new google.translate.TranslateElement({ pageLanguage: '".$this->getData(['config', 'i18n', 'langBase'])."'}, 'google_translate_element');}";
			file_put_contents( './core/vendor/i18n/translation.js', $translation);
			
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
				if( ! array_key_exists( $key, self::$i18nListSiteOnly) && $this->getData(['config','i18n','scriptGoogle'])){
					self::$translateOptions [$key] = [
						'none'   => $text['core_translate']['index'][1],
						'script' => $text['core_translate']['index'][2],
						'site'   => $text['core_translate']['index'][3],
						'delete' => $text['core_translate']['index'][4]
					];
				}
				self::$siteTranslate = $key !== $this->getData(['config', 'i18n', 'langBase']) ? false : true;
			} else {
				self::$translateOptions [$key] = [
					'none'   => $text['core_translate']['index'][1],
					'site'   => $text['core_translate']['index'][3]
				];				
				if( ! array_key_exists( $key, self::$i18nListSiteOnly) && $this->getData(['config','i18n','scriptGoogle'])){
					self::$translateOptions [$key] = [
						'none'   => $text['core_translate']['index'][1],
						'script' => $text['core_translate']['index'][2],
						'site'   => $text['core_translate']['index'][3]
					];	
				}		
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


	/*
	 * Traitement du changement de langue
	 * Fonction utilisée par le noyau
	 */
	public function i18n() {

		// Activation du drapeau sauf si c'est celui de la langue de base (drapeau utilisé pour revenir à la langue de base)
		if ( $this->getUrl(2) !== $this->getData(['config', 'i18n', 'langBase']) && $this->getInput('DELTA_I18N_' . strtoupper($this->getUrl(3))) !== $this->getUrl(2) ) {
			// Nettoyer et stocker le choix de l'utilisateur
			helper::deleteCookie('DELTA_I18N_SITE');
			helper::deleteCookie('DELTA_I18N_SCRIPT');
			// Supprimer le cookie de session déposé par google translate, problème avec chrome dans le cas d'un site placé dans un sous domaine
			$host = $_SERVER['HTTP_HOST'];
			unset($_COOKIE['googtrans']);
			setcookie('googtrans', '', time() - 4200, '/',$host);
			$tab = explode('.', $host);
			if( count($tab) > 2){
				$master = str_replace( $tab[0], '', $host);
				setcookie('googtrans', '', time() - 4200, '/',$master);
			}	
			// Sélectionner
			setcookie('DELTA_I18N_' . strtoupper($this->getUrl(3)) , $this->getUrl(2), time() + 3600, helper::baseUrl(false, false)  , '', helper::isHttps(), true);
			setrawcookie('googtrans', '/' . $this->getData(['config', 'i18n', 'langBase']) .'/' . $this->getUrl(2), 0, helper::baseUrl(false, false));
			$_SESSION['googtrans'] = '/'.$this->getData(['config', 'i18n', 'langBase']).'/' . $this->getUrl(2);
			// Mémorisation de la langue en Frontend et du type de traduction actif (site => rédigée, script => traduction automatique)	
			$_SESSION['langFrontEnd'] = $this->getUrl(2);
			$_SESSION['translationType'] = $this->getUrl(3);
		// Désactivation du drapeau, langue base par défaut
		} else {
			setcookie('DELTA_I18N_SITE' , 'base', time() + 3600, helper::baseUrl(false, false)  , '', helper::isHttps(), true);
			helper::deleteCookie('DELTA_I18N_SCRIPT');
			// Supprimer le cookie de session déposé par google translate, problème avec chrome dans le cas d'un site placé dans un sous domaine
			$host = $_SERVER['HTTP_HOST'];
			unset($_COOKIE['googtrans']);
			setcookie('googtrans', '', time() - 4200, '/',$host);
			$tab = explode('.', $host);
			if( count($tab) > 2){
				$master = str_replace( $tab[0], '', $host);
				setcookie('googtrans', '', time() - 4200, '/',$master);
			}	
			// Désactivation du script Google
			setrawcookie('googtrans', '/' . $this->getData(['config', 'i18n', 'langBase']) .'/' . $this->getData(['config', 'i18n', 'langBase']) , 0, helper::baseUrl(false, false));
			$_SESSION['googtrans'] = '/' . $this->getData(['config', 'i18n', 'langBase']) .'/' . $this->getData(['config', 'i18n', 'langBase']);
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