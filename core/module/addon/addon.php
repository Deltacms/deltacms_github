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

class addon extends common {

	public static $actions = [
		'index' => self::GROUP_ADMIN,
		'delete' => self::GROUP_ADMIN,
		'upload' => self::GROUP_ADMIN,
	];

	// Gestion des modules
	public static $modInstal = [];

	// pour tests
	public static $valeur = [];

	/*
	* Effacement d'un module installé et non utilisé
	*/
	public function delete() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < addon::$actions['delete'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/addon/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_addon.php');

			// Jeton incorrect
			if ($this->getUrl(3) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . 'addon',
					'state' => false,
					'notification' => $text['core_addon']['delete'][0]
				]);
			}
			else{
				// Suppression des dossiers
				$infoModules = helper::getModules();
				$module = $this->getUrl(2);
				//Liste des dossiers associés au module non effacés
				if( $this->removeDir('./module/'.$module ) === true   ){
					$success = true;
					$notification = 'Module '. $module .$text['core_addon']['delete'][1];
					if( is_dir($infoModules[$this->getUrl(2)]['dataDirectory']) ) {
						if (!$this->removeDir($infoModules[$this->getUrl(2)]['dataDirectory'])){
							$notification = 'Module '.$module .$text['core_addon']['delete'][2] . $infoModules[$this->getUrl(2)]['dataDirectory'];
						}
					}
				}
				else{
					$success = false;
					$notification = $text['core_addon']['delete'][3];
				}
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'addon',
					'notification' => $notification,
					'state' => $success
				]);
			}
		}
	}

	/***
	 * Installation d'un module
	 * Fonction utilisée par upload et storeUpload
	 */
	private function install ($moduleName, $checkValid){
		// Lexique
		include('./core/module/addon/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_addon.php');
		$tempFolder = 'datamodules';//uniqid();
		$zip = new ZipArchive();
		if ($zip->open($moduleName) === TRUE) {
			$notification = 'Archive ouverte';
			mkdir (self::TEMP_DIR . $tempFolder, 0755);
			$zip->extractTo(self::TEMP_DIR . $tempFolder );
			// Archive de module ?
			$success = false;
			$notification = $text['core_addon']['install'][0];
			$moduleDir = self::TEMP_DIR . $tempFolder . '/module';
			$moduleName = '';
			if ( is_dir( $moduleDir )) {
				// Lire le nom du module
				if ($dh = opendir( $moduleDir )) {
					while ( false !== ($file = readdir($dh)) ) {
						if ($file != "." && $file != "..") {
							$moduleName = $file;
						}
					}
					closedir($dh);
				}
				// Module normalisé ?
				if( is_file( $moduleDir.'/'.$moduleName.'/'.$moduleName.'.php' ) AND is_file( $moduleDir.'/'.$moduleName.'/view/index/index.php' ) ){

					// Lecture de la version et de la validation d'update du module pour validation de la mise à jour
					// Pour une version <= version installée l'utilisateur doit cocher 'Mise à jour forcée'
					$version = '0.0';
					$update = '0.0';
					$valUpdate = false;
					$file = file_get_contents( $moduleDir.'/'.$moduleName.'/'.$moduleName.'.php');
					$file = str_replace(' ','',$file);
					$file = str_replace("\t",'',$file);
					$pos1 = strpos($file, 'constVERSION');
					if( $pos1 !== false){
						$posdeb = strpos($file, "'", $pos1);
						$posend = strpos($file, "'", $posdeb + 1);
						$version = substr($file, $posdeb + 1, $posend - $posdeb - 1);
					}
					$pos1 = strpos($file, 'constUPDATE');
					if( $pos1 !== false){
						$posdeb = strpos($file, "'", $pos1);
						$posend = strpos($file, "'", $posdeb + 1);
						$update = substr($file, $posdeb + 1, $posend - $posdeb - 1);
					}
					// Si version actuelle >= version indiquée dans UPDATE la mise à jour est validée
					$infoModules = helper::getModules();
					if( $infoModules[$moduleName]['update'] >= $update ) $valUpdate = true;

					// Module déjà installé ?
					$moduleInstal = false;
					foreach($infoModules as $key=>$value ){
						if($moduleName === $key){
							$moduleInstal = true;
						}
					}

					// Validation de la maj si autorisation du concepteur du module ET
					// ( Version plus récente OU Check de forçage )
					$valNewVersion = floatval($version);
					$valInstalVersion = floatval( $infoModules[$moduleName]['version'] );
					$newVersion = false;
					if( $valNewVersion > $valInstalVersion ) $newVersion = true;
					$validMaj = $valUpdate && ( $newVersion || $checkValid);

					// Nouvelle installation ou mise à jour du module
					if( ! $moduleInstal ||  $validMaj ){
						// Copie récursive des dossiers
						$this->copyDir( self::TEMP_DIR . $tempFolder, './' );
						$success = true;
						if( ! $moduleInstal ){
							$notification = $text['core_addon']['install'][3].$moduleName. $text['core_addon']['install'][1];
						}
						else{
							$notification =  $text['core_addon']['install'][3].$moduleName. $text['core_addon']['install'][2];
						}
					}
					else{
						$success = false;
						if( $valNewVersion == $valInstalVersion){
							$notification = $text['core_addon']['install'][4].$version.$text['core_addon']['install'][5].$infoModules[$moduleName]['version'];
						}
						else{
							$notification = $text['core_addon']['install'][4].$version.$text['core_addon']['install'][6].$infoModules[$moduleName]['version'];
						}
						if( $valUpdate === false){
							if( $infoModules[$moduleName]['update'] === $update ){
								$notification = $text['core_addon']['install'][7];
							}
							else{
								$notification = $text['core_addon']['install'][8];
							}
						}
					}
				}
			}
			// Supprimer le dossier temporaire même si le module est invalide
			$this->removeDir(self::TEMP_DIR . $tempFolder);
			$zip->close();
		} else {
			// erreur à l'ouverture
			$success = false;
			$notification = $text['core_addon']['install'][9];
		}
		return(['success' => $success,
				'notification'=> $notification
		]);
	}

	/***
	 * Installation d'un module à partir du gestionnaire de fichier
	 */
	public function upload() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < addon::$actions['upload'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/addon/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_addon.php');

			// Soumission du formulaire
			if($this->isPost()) {
				// Installation d'un module
				$checkValidMaj = $this->getInput('configModulesCheck', helper::FILTER_BOOLEAN);
				$zipFilename =	$this->getInput('configModulesInstallation', helper::FILTER_STRING_SHORT);
				if( $zipFilename !== ''){
					$success = [
						'success' => false,
						'notification'=> ''
					];
					$state = $this->install(self::FILE_DIR.'source/'.$zipFilename, $checkValidMaj);
				}
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(),
					'notification' => $state['notification'],
					'state' => $state['success']
				]);
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_addon']['upload'][0],
				'view' => 'upload'
			]);
		}
	}


	/**
	 * Gestion des modules
	 */
	public function index() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < addon::$actions['index'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/addon/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_addon.php');

			// Lister les modules
			// $infoModules[nom_module]['realName'], ['version'], ['update'], ['delete'], ['dataDirectory']
			$infoModules = helper::getModules();

			// Clés moduleIds dans les pages
			$inPages = helper::arrayCollumn($this->getData(['page']),'moduleId', 'SORT_DESC');
			foreach( $inPages as $key=>$value){
				$inPagesTitle[ $this->getData(['page', $key, 'title' ]) ] = $value;
			}

			// Parcourir les données des modules
			foreach ($infoModules as $key=>$value) {
				// Construire le tableau de sortie
				self::$modInstal[] = [
					$key,
					$infoModules[$key]['realName'],
					$infoModules[$key]['version'],
					implode(', ', array_keys($inPagesTitle,$key)),
					//|| ('delete',$infoModules[$key]) && $infoModules[$key]['delete'] === true && implode(', ',array_keys($inPages,$key)) === ''
					$infoModules[$key]['delete'] === true  && implode(', ',array_keys($inPages,$key)) === ''
												? template::button('moduleDelete' . $key, [
														'class' => 'moduleDelete buttonRed',
														'href' => helper::baseUrl() . $this->getUrl(0) . '/delete/' . $key . '/' . $_SESSION['csrf'],
														'value' => template::ico('cancel')
													])
												: ''						
				];
			}

			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_addon']['index'][0],
				'view' => 'index'
			]);
		}
	}
}
