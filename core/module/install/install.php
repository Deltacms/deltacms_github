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


class install extends common {

	public static $actions = [
		'index' => self::GROUP_VISITOR,
		'steps' => self::GROUP_MODERATOR,
		'update' => self::GROUP_ADMIN
	];

	// Thèmes proposés à l'installation
	public static $themes =   [];

	public static $newVersion;


	/**
	 * Installation
	 */
	public function index() {
		// Accès refusé
		if($this->getData(['user']) !== []) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// Accès autorisé
		else {
			// Soumission du formulaire
			if($this->isPost()) {
				$success = true;
				// Double vérification pour le mot de passe
				if($this->getInput('installPassword', helper::FILTER_STRING_SHORT, true) !== $this->getInput('installConfirmPassword', helper::FILTER_STRING_SHORT, true)) {
					self::$inputNotices['installConfirmPassword'] = 'Incorrect';
					$success = false;
				}
				// Utilisateur
				$userFirstname = $this->getInput('installFirstname', helper::FILTER_STRING_SHORT, true);
				$userLastname = $this->getInput('installLastname', helper::FILTER_STRING_SHORT, true);
				$userMail = $this->getInput('installMail', helper::FILTER_MAIL, true);
				$userId = $this->getInput('installId', helper::FILTER_ID, true);
				
				// Langues
				$langAdmin = $this->getInput('installLangAdmin');
				$langBase = $this->getInput('installLangBase');
				$this->setData(['config', 'i18n', 'langAdmin', $langAdmin]);
				$this->setData(['config', 'i18n', 'langBase', $langBase]);
				
				// Localisation avec ordre de locales : $langAdmin puis les 2 autres
				$this->localisation($langAdmin);

				// Création de l'utilisateur si les données sont complétées.
				// success retour de l'enregistrement des données
				
				$success = $this->setData([
					'user',
					$userId,
					[
						'firstname' => $userFirstname,
						'forgot' => 0,
						'group' => self::GROUP_ADMIN,
						'lastname' => $userLastname,
						'pseudo' => 'Admin',
						'signature' => 1,
						'mail' => $userMail,
						'password' => $this->getInput('installPassword', helper::FILTER_PASSWORD, true)
					]
				]);
				
				// Lexique
				include('./core/module/install/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_install.php');			
				// Compte créé, envoi du mail et création des données du site
				if ($success) { // Formulaire complété envoi du mail
					// Envoie le mail
					// Sent contient true si réussite sinon code erreur d'envoi en clair
					$sent = $this->sendMail(
						$userMail,
						$text['core_install']['index'][0],
						$text['core_install']['index'][1] . ' <strong>' . $userFirstname . ' ' . $userLastname . '</strong>,<br><br>' .
						$text['core_install']['index'][2].'<br><br>' .
						'<strong>'.$text['core_install']['index'][3].' : </strong> <a href="' . helper::baseUrl(false) . '" target="_blank">' . helper::baseUrl(false) . '</a><br>' .
						'<strong>'.$text['core_install']['index'][4].' : </strong> ' . $this->getInput('installId') . '<br>',
						null
					);
					// Nettoyer les cookies de langue d'une précédente installation
					helper::deleteCookie('DELTA_I18N_SITE');
					helper::deleteCookie('DELTA_I18N_SCRIPT');
					
					// Installation du site de test en français, le site light est installé par défaut pour la langue de rédaction fr
					$langSource = ( $langBase === 'en' || $langBase === 'es' || $langBase === 'fr') ? $langBase : $langAdmin;
					if( $langAdmin === 'fr'){
						if ($this->getInput('installDefaultData',helper::FILTER_BOOLEAN) === FALSE) {
								$this->copyDir( './core/module/install/ressource/database_'.$langSource.'/base/', './site/data/base/');
						} else {
							if( $langBase === 'en' || $langBase === 'es') $this->copyDir( './core/module/install/ressource/databaselight_'.$langBase.'/base/', './site/data/base/');
						}
					}
					
					// Installation du site de test dans une langue d'administration différente du français
					if( $langAdmin !== 'fr'){
						if ($this->getInput('installDefaultData',helper::FILTER_BOOLEAN) === FALSE) {
							$this->copyDir( './core/module/install/ressource/database_'.$langSource.'/base/', './site/data/base/');
							if($langBase !== 'fr') $this->copyDir( './core/module/install/ressource/database_'.$langSource.'/search/', './site/data/search/');
						}
						else{
							if($langBase !== 'fr') $this->copyDir( './core/module/install/ressource/databaselight_'.$langSource.'/base/', './site/data/base/');							
						}
					}
					
					// Personnalisation de la page d'accueil en fonction de la langue de rédaction choisie
					if( $langBase !== $langAdmin && file_exists( './core/module/install/ressource/'. $langBase . '/accueil.html'  )){
						$accueil = $text['core_install']['index'][6];
						copy('./core/module/install/ressource/'. $langBase . '/accueil.html', './site/data/base/content/'. $accueil);
					}
					
					
					// Images exemples livrées dans tous les cas
					try {
						// Décompression dans le dossier de fichier temporaires
						if (file_exists(self::TEMP_DIR . 'files.tar.gz')) {
							unlink(self::TEMP_DIR . 'files.tar.gz');
						}
						if (file_exists(self::TEMP_DIR . 'files.tar')) {
							unlink(self::TEMP_DIR . 'files.tar');
						}
						copy('core/module/install/ressource/files.tar.gz', self::TEMP_DIR . 'files.tar.gz');
						$pharData = new PharData(self::TEMP_DIR . 'files.tar.gz');
						$pharData->decompress();
						// Installation
						$pharData->extractTo(__DIR__ . '/../../../', null, true);
					} catch (Exception $e) {
						$success = $e->getMessage();
					}
					unlink(self::TEMP_DIR . 'files.tar.gz');
					unlink(self::TEMP_DIR . 'files.tar');
					// Stocker le dossier d'installation
					$this->setData(['core', 'baseUrl', helper::baseUrl(false,false) ]);
					// Créer sitemap
					$this->createSitemap();

					// Installation du thème sélectionné
					$dataThemes = file_get_contents('core/module/install/ressource/themes/themes.json');
					$dataThemes = json_decode($dataThemes, true);
					$themeId = $dataThemes [$this->getInput('installTheme', helper::FILTER_STRING_SHORT)]['filename'];
					if ($themeId !== 'default' ) {
							$theme = new theme;
							$theme->import('core/module/install/ressource/themes/' . $themeId);
					}

					// Copie des thèmes dans les fichiers
					if (!is_dir(self::FILE_DIR . 'source/theme' )) {
						mkdir(self::FILE_DIR . 'source/theme');
					}
					$this->copyDir('core/module/install/ressource/themes', self::FILE_DIR . 'source/theme');
					unlink(self::FILE_DIR . 'source/theme/themes.json');
					
					// Modification des textes 'Pied de page personnalisé', 'Bannière vide' et du lien vers la page d'accueil situé dans theme.json ( $this->setData pose problème)
					if($langAdmin !== 'fr' || $langBase === 'en' || $langBase === 'es' || $langBase === 'fr'){
						switch ($langBase){
							case 'en':
								$texte1 = 'Custom footer';
								$texte2 = 'Banner empty';
								$texte3 = 'home';
								break;
							case 'es':
								$texte1 = 'Pie de página personalizado';
								$texte2 = 'Banner vacío';
								$texte3 = 'inicio';
								break;
							case 'fr':
								$texte1 = 'Pied de page personnalisé';
								$texte2 = 'Bannière vide';
								$texte3 = 'accueil';
								break;
							default:
								$texte1 = $text['core_install']['index'][7];
								$texte2 = $text['core_install']['index'][8];
								$texte3 = $text['core_install']['index'][9];
						}
						$theme = file_get_contents( self::DATA_DIR.'theme.json');
						$theme = json_decode( $theme, true);
						$theme['theme']['footer']['text'] = $texte1;
						$theme['theme']['header']['featureContent'] = $texte2;
						$theme['theme']['menu']['burgerIconLink1'] = $texte3;
						$json = json_encode($theme);
						file_put_contents(self::DATA_DIR.'theme.json',$json);
					}
					
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl(false),
						'notification' => $sent === true ? $text['core_install']['index'][5] : $sent,
						'state' => ($sent === true &&  $success === true) ? true : null
					]);
				}
			}
			// Localisation avec ordre de locales : fr puis en puis es
			$this->localisation('fr');
			// Récupération de la liste des thèmes
			$dataThemes = file_get_contents('core/module/install/ressource/themes/themes.json');
			$dataThemes = json_decode($dataThemes, true);
			self::$themes = helper::arrayCollumn($dataThemes, 'name');
			
			// Valeurs en sortie
			$this->addOutput([
				'display' => self::DISPLAY_LAYOUT_LIGHT,
				'title' => 'Installation',
				'view' => 'index'
			]);
		}
	}

	/**
	 * Étapes de mise à jour
	 */
	public function steps() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < install::$actions['steps'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			switch($this->getInput('step', helper::FILTER_INT)) {
				// Préparation
				case 1:
					$success = true;
					// RAZ la mise à jour auto
					$this->setData(['core','updateAvailable', false]);
					// Backup du dossier Data
					helper::autoBackup(self::BACKUP_DIR,['backup','tmp','file']);
					// Sauvegarde htaccess
					if ($this->getData(['config','autoUpdateHtaccess'])) {
						$success = copy('.htaccess', '.htaccess' . '.bak');
					}
					// Nettoyage des fichiers d'installation précédents
					if(file_exists(self::TEMP_DIR.'update.tar.gz') && $success) {
						$success = unlink(self::TEMP_DIR.'update.tar.gz');
					}
					if(file_exists(self::TEMP_DIR.'update.tar') && $success) {
						$success = unlink(self::TEMP_DIR.'update.tar');
					}
					// Valeurs en sortie
					$this->addOutput([
						'display' => self::DISPLAY_JSON,
						'content' => [
							'success' => $success,
							'data' => null
						]
					]);
					break;
				// Téléchargement
				case 2:
					$success = (file_put_contents(self::TEMP_DIR.'update.tar.gz', helper::urlGetContents(common::DELTA_UPDATE_URL . common::DELTA_UPDATE_CHANNEL . '/update.tar.gz')) !== false);
					// Valeurs en sortie
					$this->addOutput([
						'display' => self::DISPLAY_JSON,
						'content' => [
							'success' => $success,
							'data' => null
						]
					]);
					break;
				// Installation
				case 3:
					$success = true;
					// Check la réécriture d'URL avant d'écraser les fichiers
					$rewrite = helper::checkRewrite();
					// Décompression et installation
					try {
						// Décompression dans le dossier de fichier temporaires
						$pharData = new PharData(self::TEMP_DIR.'update.tar.gz');
						$pharData->decompress();
						// Installation
						$pharData->extractTo(__DIR__ . '/../../../', null, true);
					} catch (Exception $e) {
						$success = $e->getMessage();
					}
					// Nettoyage du dossier
					if(file_exists(self::TEMP_DIR.'update.tar.gz')) {
						unlink(self::TEMP_DIR.'update.tar.gz');
					}
					if(file_exists(self::TEMP_DIR.'update.tar')) {
						unlink(self::TEMP_DIR.'update.tar');
					}
					// Valeurs en sortie
					$this->addOutput([
						'display' => self::DISPLAY_JSON,
						'content' => [
							'success' => $success,
							'data' => $rewrite
						]
					]);
					break;
				// Configuration
				case 4:
					$success = true;
					$rewrite = $this->getInput('data');
					// Réécriture d'URL
					if ($rewrite === "true") {
						$success = (file_put_contents(
							'.htaccess',
							PHP_EOL .
							'<IfModule mod_rewrite.c>' . PHP_EOL .
							"\tRewriteEngine on" . PHP_EOL .
							"\tRewriteBase " . helper::baseUrl(false, false) . PHP_EOL .
							"\tRewriteCond %{REQUEST_FILENAME} !-f" . PHP_EOL .
							"\tRewriteCond %{REQUEST_FILENAME} !-d" . PHP_EOL .
							"\tRewriteRule ^(.*)$ index.php?$1 [L]" . PHP_EOL .
							'</IfModule>',
							FILE_APPEND
						) !== false);
					}
					// Recopie htaccess
					if ($this->getData(['config','autoUpdateHtaccess']) &&
						$success && file_exists( '.htaccess.bak')
					) {
							// L'écraser avec le backup
							$success = copy( '.htaccess.bak' ,'.htaccess' );
							// Effacer l ebackup
							unlink('.htaccess.bak');
					}
					// Valeurs en sortie
					$this->addOutput([
						'display' => self::DISPLAY_JSON,
						'content' => [
							'success' => $success,
							'data' => null
						]
					]);
					break;
			}
		}
	}

	/**
	 * Mise à jour
	 */
	public function update() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < install::$actions['update'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/install/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_install.php');
			// Nouvelle version
			self::$newVersion = helper::urlGetContents(common::DELTA_UPDATE_URL . common::DELTA_UPDATE_CHANNEL . '/version');
			// Valeurs en sortie
			$this->addOutput([
				'display' => self::DISPLAY_LAYOUT_LIGHT,
				'title' => $text['core_install']['update'][0],
				'view' => 'update'
			]);
		}
	}


}