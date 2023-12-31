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

class gallery extends common {


	const VERSION = '4.4';
	const REALNAME = 'Galerie';
	const DELETE = true;
	const UPDATE = '0.0';
	const DATADIRECTORY = self::DATA_DIR . 'gallery/';

	const SORT_ASC = 'SORT_ASC';
	const SORT_DSC = 'SORT_DSC';
	const SORT_HAND = 'SORT_HAND';


	public static $directories = [];

	public static $firstPictures = [];

	public static $galleries = [];

	public static $galleriesId = [];

	public static $pictures = [];

	public static $picturesId = [];

	public static $thumbs = [];

	public static $actions = [
		'config' 		=> self::GROUP_EDITOR,
		'delete' 		=> self::GROUP_MODERATOR,
		'dirs' 			=> self::GROUP_EDITOR,
		'sortGalleries' => self::GROUP_EDITOR,
		'sortPictures' 	=> self::GROUP_EDITOR,
		'edit' 			=> self::GROUP_EDITOR,
		'theme' 		=> self::GROUP_MODERATOR,
		'index' 		=> self::GROUP_VISITOR
	];

	/**
	 * Mise à jour du module
	 * Appelée par les fonctions index et config
	 */
	private function update() {
		// Initialisation du module, créer les données si elles sont manquantes.
		$this->init();

		$versionData = $this->getData(['module',$this->getUrl(0),'config', 'versionData' ]);
		// Mise à jour 3.1 vers 4.0
		if (version_compare($versionData, '3.1', '<') ) {
			if (is_dir(self::DATADIRECTORY . 'pages/')) {
				// Déplacer les données du dossier Pages
				$this->copyDir(self::DATADIRECTORY . 'pages/' . $this->getUrl(0), self::DATADIRECTORY . $this->getUrl(0));
				$this->removeDir(self::DATADIRECTORY . 'pages/');
				$style = $this->getData(['module', $this->getUrl(0), 'theme', 'style']);
				$this->setData(['module', $this->getUrl(0), 'theme', 'style', str_replace('pages/', '', $style)]);
			}
			// Mettre à jour la version
			$this->setData(['module',$this->getUrl(0),'config', 'versionData', '4.0' ]);
		}
		if (version_compare($versionData, '4.4', '<') ) {
			$this->setData(['module',$this->getUrl(0),'config', 'versionData', '4.4' ]);
		}
	}

	/**
	 * Initialisation séparée des éléments absents
	 * Thème
	 * Config
	 * Content
	 */
	private function init() {

		// Mise à jour d'une version inférieure, la gallery existe mais pas la variable content
		if ($this->getData(['module', $this->getUrl(0)]) &&
		$this->getData(['module', $this->getUrl(0), 'content']) === NULL  ) {

			// Changement de l'arborescence dans module.json
			$data = $this->getData(['module', $this->getUrl(0)]);
			$this->deleteData(['module', $this->getUrl(0)]);
			$this->setData(['module', $this->getUrl(0), 'content', $data]);

			// Effacer les fichiers CSS de l'ancienne version
			if (file_exists('module/gallery/view/index/index.css')) {
				unlink('module/gallery/view/index/index.css');
			}
			if (file_exists('module/gallery/view/gallery/gallery.css')) {
				unlink('module/gallery/view/gallery/gallery.css');
			}
			// Stockage des données du thème de la gallery existant
			if (is_array($this->getData(['theme','gallery']))) {
				$data = $this->getData(['theme','gallery']);
				$this->deleteData(['theme','gallery']);
				$this->setData(['module', $this->getUrl(0), 'theme', $data]);
				// Nom de la feuille de style
				$this->setData(['module', $this->getUrl(0), 'theme', 'style', self::DATADIRECTORY . $this->getUrl(0) . '/theme.css']);
			}
		}

		// Variable commune
		$fileCSS = self::DATADIRECTORY . $this->getUrl(0) . '/theme.css' ;

		// Check la présence des données de thème
		if ( $this->getData(['module',  $this->getUrl(0), 'theme']) === null ) {
			require_once('module/gallery/ressource/defaultdata.php');
			$this->setData(['module',  $this->getUrl(0), 'theme', theme::$defaultTheme]);
			// Nom de la feuille de style
			$this->setData(['module',  $this->getUrl(0), 'theme', 'style', $fileCSS]);
		}

		// Check la présence de la feuille de style
		if ( !file_exists(self::DATADIRECTORY . $this->getUrl(0) . '/theme.css')) {
			// Dossier de l'instance
			if (!is_dir(self::DATADIRECTORY . $this->getUrl(0) )) {
				mkdir (self::DATADIRECTORY . $this->getUrl(0), 0755, true);
			}
			// Générer la feuille de CSS
			$content = file_get_contents('module/gallery/ressource/vartheme.css');
			$themeCss = file_get_contents('module/gallery/ressource/theme.css');

			// Injection des variables
			$content = str_replace('#thumbAlign#',$this->getData(['module',  $this->getUrl(0), 'theme', 'thumbAlign']),$content );
			$content = str_replace('#thumbWidth#',$this->getData(['module',  $this->getUrl(0), 'theme', 'thumbWidth']),$content );
			$content = str_replace('#thumbHeight#',$this->getData(['module',  $this->getUrl(0), 'theme', 'thumbHeight']),$content );
			$content = str_replace('#thumbMargin#',$this->getData(['module',  $this->getUrl(0), 'theme', 'thumbMargin']),$content );
			$content = str_replace('#thumbBorder#',$this->getData(['module',  $this->getUrl(0), 'theme', 'thumbBorder']),$content );
			$content = str_replace('#thumbBorderColor#',$this->getData(['module',  $this->getUrl(0), 'theme', 'thumbBorderColor']),$content );
			$content = str_replace('#thumbOpacity#',$this->getData(['module',  $this->getUrl(0), 'theme', 'thumbOpacity']),$content );
			$content = str_replace('#thumbShadows#',$this->getData(['module',  $this->getUrl(0), 'theme', 'thumbShadows']),$content );
			$content = str_replace('#thumbShadowsColor#',$this->getData(['module',  $this->getUrl(0), 'theme', 'thumbShadowsColor']),$content );
			$content = str_replace('#thumbRadius#',$this->getData(['module',  $this->getUrl(0), 'theme', 'thumbRadius']),$content );
			$content = str_replace('#legendAlign#',$this->getData(['module',  $this->getUrl(0), 'theme', 'legendAlign']),$content );
			$content = str_replace('#legendHeight#',$this->getData(['module',  $this->getUrl(0), 'theme', 'legendHeight']),$content );
			$content = str_replace('#legendTextColor#',$this->getData(['module',  $this->getUrl(0), 'theme', 'legendTextColor']),$content );
			$content = str_replace('#legendBgColor#',$this->getData(['module',  $this->getUrl(0), 'theme', 'legendBgColor']),$content );
			// Ecriture de la feuille de style
			file_put_contents(self::DATADIRECTORY . $this->getUrl(0) . '/theme.css' , $content . $themeCss);
			// Nom de la feuille de style
			$this->setData(['module',  $this->getUrl(0), 'theme', 'style', $fileCSS]);
		}

		// Check la présence de la config
		if ( $this->getData(['module',  $this->getUrl(0), 'config']) === null ) {
			require_once('module/gallery/ressource/defaultdata.php');
			$this->setData(['module',  $this->getUrl(0), 'config', theme::$defaultData]);
		}

		// Contenu vide de la galerie
		if (!is_array($this->getData(['module', $this->getUrl(0), 'content'])) ) {
			$this->setData(['module', $this->getUrl(0), 'content', array() ]);
		}
	}


	/**
	 * Tri de la liste des galeries
	 *
	 */
	public function sortGalleries() {
		if($_POST['response']) {
			$data = explode('&',$_POST['response']);
			$data = str_replace('galleryTable%5B%5D=','',$data);
			for($i=0;$i<count($data);$i++) {
				$this->setData(['module', $this->getUrl(0), 'content', $data[$i], [
					'config' => [
						'name' => $this->getData(['module',$this->getUrl(0), 'content', $data[$i],'config','name']),
						'directory' => $this->getData(['module',$this->getUrl(0), 'content', $data[$i],'config','directory']),
						'homePicture' => $this->getData(['module',$this->getUrl(0), 'content', $data[$i],'config','homePicture']),
						'sort' => $this->getData(['module',$this->getUrl(0), 'content', $data[$i],'config','sort']),
						'position'=> $i,
						'fullScreen' => $this->getData(['module',$this->getUrl(0), 'content',$data[$i],'config','fullScreen'])

					],
					'legend' => $this->getData(['module',$this->getUrl(0), 'content', $data[$i],'legend']),
					'positions' => $this->getData(['module',$this->getUrl(0), 'content', $data[$i],'positions'])
				]]);
			}
		}
	}

	/**
	 * Tri de la liste des images
	 *
	 */
	public function sortPictures() {
		if($_POST['response']) {
			$galleryName = $_POST['gallery'];
			$data = explode('&',$_POST['response']);
			$data = str_replace('galleryTable%5B%5D=','',$data);
			// Sauvegarder
			$this->setData(['module', $this->getUrl(0), 'content', $galleryName, [
				'config' => [
					'name' => $this->getData(['module',$this->getUrl(0),$galleryName,'config','name']),
					'directory' => $this->getData(['module',$this->getUrl(0),$galleryName,'config','directory']),
					'homePicture' => $this->getData(['module',$this->getUrl(0),$galleryName,'config','homePicture']),
					'sort' => $this->getData(['module',$this->getUrl(0),$galleryName,'config','sort']),
					'position' => $this->getData(['module',$this->getUrl(0),$galleryName,'config','position']),
					'fullScreen' => $this->getData(['module',$this->getUrl(0),$galleryName,'config','fullScreen'])

				],
				'legend' => $this->getData(['module',$this->getUrl(0),$galleryName,'legend']),
				'positions' => array_flip($data)
			]]);
		}
	}


	/**
	 * Configuration
	 */
	public function config() {
		// Lexique
		$param = '';
		include('./module/gallery/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_gallery.php');

		// Mise à jour des données de module
		$this->update();

		//Affichage de la galerie triée
		$g = $this->getData(['module', $this->getUrl(0), 'content']);
		$p = helper::arrayCollumn(helper::arrayCollumn($g,'config'),'position');
		asort($p,SORT_NUMERIC);
		$galleries = [];
		foreach ($p as $positionId => $item) {
			$galleries [$positionId] = $g[$positionId];
		}
		// Traitement de l'affichage
		if($galleries) {
			foreach($galleries as $galleryId => $gallery) {
				// Erreur dossier vide
				if(is_dir($gallery['config']['directory'])) {
					if(count(scandir($gallery['config']['directory'])) === 2) {
						$gallery['config']['directory'] = '<span class="galleryConfigError">' . $gallery['config']['directory'] . $text['gallery']['config'][0].'</span>';
					}
				}
				// Erreur dossier supprimé
				else {
					$gallery['config']['directory'] = '<span class="galleryConfigError">' . $gallery['config']['directory'] . $text['gallery']['config'][1].'</span>';
				}
				// Met en forme le tableau
				self::$galleries[] = [
					template::ico('sort'),
					$gallery['config']['name'],
					str_replace('site/file/source/','',$gallery['config']['directory']),
					template::button('galleryConfigEdit' . $galleryId , [
						'href' => helper::baseUrl() . $this->getUrl(0) . '/edit/' . $galleryId  . '/' . $_SESSION['csrf'],
						'value' => template::ico('pencil')
					]),
					template::button('galleryConfigDelete' . $galleryId, [
						'class' => 'galleryConfigDelete buttonRed',
						'href' => helper::baseUrl() . $this->getUrl(0) . '/delete/' . $galleryId . '/' . $_SESSION['csrf'],
						'value' => template::ico('cancel'),
						'disabled' => $this->getUser('group') >= self::GROUP_MODERATOR ? false : true
					])
				];
				// Tableau des id des galleries pour le drag and drop
				self::$galleriesId[] = $galleryId;
			}
		}
		// Soumission du formulaire d'ajout d'une galerie
		if($this->isPost()) {
			if (!$this->getInput('galleryConfigFilterResponse')) {
				$galleryId = helper::increment($this->getInput('galleryConfigName', helper::FILTER_ID, true), (array) $this->getData(['module', $this->getUrl(0), 'content']));
				// définir une vignette par défaut
				$directory = $this->getInput('galleryConfigDirectory', helper::FILTER_STRING_SHORT, true);
				$iterator = new DirectoryIterator($directory);
				foreach($iterator as $fileInfos) {
					if($fileInfos->isDot() === false AND $fileInfos->isFile() AND @getimagesize($fileInfos->getPathname())) {
						// Créer la miniature si manquante
						if (!file_exists( str_replace('source','thumb',$fileInfos->getPath()) . '/' . self::THUMBS_SEPARATOR  . strtolower($fileInfos->getFilename()))) {
							$this->makeThumb($fileInfos->getPathname(),
											str_replace('source','thumb',$fileInfos->getPath()) .  '/' . self::THUMBS_SEPARATOR  . strtolower($fileInfos->getFilename()),
											self::THUMBS_WIDTH);
						}
						// Miniatures
						$homePicture = strtolower($fileInfos->getFilename());
					break;
					}
				}
				$this->setData(['module', $this->getUrl(0), 'content', $galleryId, [
					'config' => [
						'name' => $this->getInput('galleryConfigName'),
						'directory' => $this->getInput('galleryConfigDirectory', helper::FILTER_STRING_SHORT, true),
						'homePicture' => $homePicture,
						'sort' => self::SORT_ASC,
						'position' => $this->getData(['module', $this->getUrl(0), 'content', $galleryId,'config','position']),
						'fullScreen' => false
					],
					'legend' => [],
					'positions' => []
				]]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl() /*. '#galleryConfigForm'*/,
					'notification' => $text['gallery']['config'][2],
					'state' => true
				]);
			}
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => $text['gallery']['config'][3],
			'view' => 'config',
			'vendor' => [
				'tablednd'
			]
		]);
	}

	/**
	 * Suppression
	 */
	public function delete() {
		// Lexique
		$param = '';
		include('./module/gallery/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_gallery.php');

		// $url prend l'adresse sans le token
		// La galerie n'existe pas
		if($this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(2)]) === null) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// Jeton incorrect
		if ($this->getUrl(3) !== $_SESSION['csrf']) {
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'notification' => $text['gallery']['delete'][0]
			]);
		}
		// Suppression
		else {
			$this->deleteData(['module', $this->getUrl(0), 'content', $this->getUrl(2)]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'notification' => $text['gallery']['delete'][1],
				'state' => true
			]);
		}
	}

	/**
	 * Liste des dossiers
	 */
	public function dirs() {
		// Valeurs en sortie
		$filter = ['jpg', 'jpeg', 'png', 'gif', 'tiff', 'ico', 'webp'];
		$this->addOutput([
			'display' => self::DISPLAY_JSON,
			'content' => helper::scanDir(self::FILE_DIR.'source', $filter)
		]);
	}

	/**
	 * Édition
	 */
	public function edit() {
		// Lexique
		$param = '';
		include('./module/gallery/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_gallery.php');

		// Jeton incorrect
		if ($this->getUrl(3) !== $_SESSION['csrf']) {
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'notification' => $text['gallery']['edit'][0]
			]);
		}
		// La galerie n'existe pas
		if($this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(2)]) === null) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// La galerie existe
		else {
			// Soumission du formulaire
			if($this->isPost()) {
				// Si l'id a changée
				$galleryId = !empty($this->getInput('galleryEditName')) ? $this->getInput('galleryEditName', helper::FILTER_ID, true) : $this->getUrl(2);
				if($galleryId !== $this->getUrl(2)) {
					// Incrémente le nouvel id de la galerie
					$galleryId = helper::increment($galleryId, $this->getData(['module', $this->getUrl(0), 'content']));
					// Transférer la position des images
					$oldPositions = $this->getData(['module',$this->getUrl(0), $this->getUrl(2),'positions']);
					// Supprime l'ancienne galerie
					$this->deleteData(['module', $this->getUrl(0), 'content', $this->getUrl(2)]);
				}
				// légendes
				$legends = [];
				foreach((array) $this->getInput('legend', null) as $file => $legend) {
					// Image de couverture par défaut si non définie
					$homePicture = $file;
					$file = str_replace('.','',$file);
					$legends[$file] = helper::filter($legend, helper::FILTER_STRING_SHORT);

				}
				// Photo de la page de garde de l'album définie dans form
				if (is_array($this->getInput('homePicture', null)) ) {
					$d = array_keys($this->getInput('homePicture', null));
					$homePicture = $d[0];
				}
				// Sauvegarder
				if ($this->getInput('galleryEditName')) {
					$this->setData(['module', $this->getUrl(0), 'content', $galleryId, [
						'config' => [
							'name' => $this->getInput('galleryEditName', helper::FILTER_STRING_SHORT, true),
							'directory' => $this->getInput('galleryEditDirectory', helper::FILTER_STRING_SHORT, true),
							'homePicture' => $homePicture,
							// pas de positions, on active le tri alpha
							'sort' =>  $this->getInput('galleryEditSort'),
							'position' => $this->getData(['module', $this->getUrl(0), 'content', $galleryId,'config','position']),
							'fullScreen' => $this->getInput('galleryEditFullscreen', helper::FILTER_BOOLEAN)

						],
						'legend' => $legends,
						'positions' => empty($oldPositions) ? $this->getdata(['module', $this->getUrl(0), 'content', $galleryId, 'positions']) : $oldPositions
					]]);
				}
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/edit/' . $galleryId  . '/' . $_SESSION['csrf'] ,
					'notification' => $text['gallery']['edit'][1],
					'state' => true
				]);
			}
			// Met en forme le tableau
			$directory = $this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(2), 'config', 'directory']);
			if(is_dir($directory)) {
				$iterator = new DirectoryIterator($directory);

				foreach($iterator as $fileInfos) {
					if($fileInfos->isDot() === false AND $fileInfos->isFile() AND @getimagesize($fileInfos->getPathname())) {
						// Créer la miniature RFM si manquante
						if (!file_exists( str_replace('source','thumb',$fileInfos->getPath()) . '/' . strtolower($fileInfos->getFilename()))) {
							$this->makeThumb($fileInfos->getPathname(),
											str_replace('source','thumb',$fileInfos->getPath()) .  '/' .  strtolower($fileInfos->getFilename()),
											122);
						}
						self::$pictures[str_replace('.','',$fileInfos->getFilename())] = [
							template::ico('sort'),
							$fileInfos->getFilename(),
							template::checkbox( 'homePicture[' . $fileInfos->getFilename() . ']', true, '', [
								'checked' => $this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(2),'config', 'homePicture']) === $fileInfos->getFilename() ? true : false,
								'class' => 'homePicture'
							]),
							template::text('legend[' . $fileInfos->getFilename() . ']', [
								'value' => $this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(2), 'legend', str_replace('.','',$fileInfos->getFilename())])
							]),
							'<a href="' . str_replace('source','thumb',$directory) . '/' . self::THUMBS_SEPARATOR . $fileInfos->getFilename() .'" rel="data-lity" data-lity=""><img src="'. str_replace('source','thumb',$directory) . '/' . $fileInfos->getFilename() .  '"></a>'
						];
						self::$picturesId [] = str_replace('.','',$fileInfos->getFilename());
					}
				}
				// Tri des images
				switch ($this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(2), 'config', 'sort'])) {
					case self::SORT_HAND:
						$positions = $this->getdata(['module',$this->getUrl(0),'content', $this->getUrl(2),'positions']);
						if ($positions) {
							foreach ($positions as $key => $value) {
								if (array_key_exists($key,self::$pictures)) {
									$tempPictures[$key] = self::$pictures[$key];
									$tempPicturesId [] = $key;
								}
							}
							// Images ayant été ajoutées dans le dossier mais non triées
							foreach (self::$pictures as $key => $value) {
								if (!array_key_exists($key,$tempPictures)) {
									$tempPictures[$key] = self::$pictures[$key];
									$tempPicturesId [] = $key;
								}
							}
							self::$pictures = $tempPictures;
							self::$picturesId  = $tempPicturesId;
						}
						break;
					case self::SORT_ASC:
						ksort(self::$pictures,SORT_NATURAL);
						sort(self::$picturesId,SORT_NATURAL);
						break;
					case self::SORT_DSC:
						krsort(self::$pictures,SORT_NATURAL);
						rsort(self::$picturesId,SORT_NATURAL);
						break;
				}
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(2), 'config', 'name']),
				'view' => 'edit',
				'vendor' => [
					'tablednd'
				]
			]);
		}
	}

	/**
	 * Accueil (deux affichages en un pour éviter une url à rallonge)
	 */
	public function index() {

		// Mise à jour des données de module
		$this->update();

		// Images d'une galerie
		if($this->getUrl(1)) {
			// La galerie n'existe pas
			if($this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(1)]) === null) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			}
			// La galerie existe
			else {
				// Images de la galerie
				$directory = $this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(1), 'config', 'directory']);
				if(is_dir($directory)) {
					$iterator = new DirectoryIterator($directory);
					foreach($iterator as $fileInfos) {
						if($fileInfos->isDot() === false AND $fileInfos->isFile() AND @getimagesize($fileInfos->getPathname())) {
							self::$pictures[$directory . '/' . $fileInfos->getFilename()] = $this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(1), 'legend', str_replace('.','',$fileInfos->getFilename())]);
							$picturesSort[$directory . '/' . $fileInfos->getFilename()] = $this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(1), 'positions', str_replace('.','',$fileInfos->getFilename())]);
							// Créer la miniature si manquante
							if (!file_exists( str_replace('source','thumb',$fileInfos->getPath()) . '/' . self::THUMBS_SEPARATOR  . strtolower($fileInfos->getFilename()))) {
								$this->makeThumb($fileInfos->getPathname(),
												str_replace('source','thumb',$fileInfos->getPath()) .  '/' . self::THUMBS_SEPARATOR  . strtolower($fileInfos->getFilename()),
												self::THUMBS_WIDTH);
							}
							// Définir la Miniature
							self::$thumbs[$directory . '/' . $fileInfos->getFilename()] = 	file_exists( str_replace('source','thumb',$directory) . '/' . self::THUMBS_SEPARATOR  . strtolower($fileInfos->getFilename()))
																							? str_replace('source','thumb',$directory) . '/' . self::THUMBS_SEPARATOR .  strtolower($fileInfos->getFilename())
																							: str_replace('source','thumb',$directory) . '/' .  strtolower($fileInfos->getFilename());
						}
					}
					// Tri des images par ordre alphabétique
					switch ($this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(1), 'config', 'sort'])) {
						case self::SORT_HAND:
							asort($picturesSort);
							if ($picturesSort) {
								foreach ($picturesSort as $name => $position) {
									$temp[$name] = self::$pictures[$name];
								}
								self::$pictures = $temp;
								break;
							}
						case self::SORT_DSC:
							krsort(self::$pictures,SORT_NATURAL);
							break;
						case self::SORT_ASC:
						default:
							ksort(self::$pictures,SORT_NATURAL);
							break;
					}
				}
				// Affichage du template
				if(self::$pictures) {
					// Valeurs en sortie
					$this->addOutput([
						'showBarEditButton' => true,
						'title' => $this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(1), 'config', 'name']),
						'view' => 'gallery',
						'style' => $this->getData(['module', $this->getUrl(0), 'theme', 'style'])
					]);
				}
				// Pas d'image dans la galerie
				else {
					// Valeurs en sortie
					$this->addOutput([
						'access' => false
					]);
				}
			}

		}
		// Liste des galeries
		else {
			// Tri des galeries suivant l'ordre défini
			$g = $this->getData(['module', $this->getUrl(0), 'content']);
			$p = helper::arrayCollumn(helper::arrayCollumn($g,'config'),'position');
			asort($p,SORT_NUMERIC);
			$galleries = [];
			foreach ($p as $positionId => $item) {
				$galleries [$positionId] = $g[$positionId];
			}
			// Construire le tableau
			foreach((array) $galleries as $galleryId => $gallery) {
				if(is_dir($gallery['config']['directory'])) {
					$iterator = new DirectoryIterator($gallery['config']['directory']);
					foreach($iterator as $fileInfos) {
						if($fileInfos->isDot() === false AND $fileInfos->isFile() AND @getimagesize($fileInfos->getPathname())) {

							self::$galleries[$galleryId] = $gallery;
							// L'image de couverture est-elle supprimée ?
							if (file_exists( $gallery['config']['directory'] . '/' . $gallery['config']['homePicture'])) {
								// Créer la miniature si manquante
								if (!file_exists( str_replace('source','thumb',$gallery['config']['directory']) . '/' . self::THUMBS_SEPARATOR  . strtolower($gallery['config']['homePicture']))) {
									$this->makeThumb($gallery['config']['directory'] . '/' . str_replace(self::THUMBS_SEPARATOR ,'',$gallery['config']['homePicture']),
													str_replace('source','thumb',$gallery['config']['directory']) .  '/' . self::THUMBS_SEPARATOR  . strtolower($gallery['config']['homePicture']),
													self::THUMBS_WIDTH);
								}
								// Définir l'image de couverture
								self::$firstPictures[$galleryId] =	file_exists( str_replace('source','thumb',$gallery['config']['directory']) . '/' . self::THUMBS_SEPARATOR  . strtolower($gallery['config']['homePicture']))
																	? str_replace('source','thumb',$gallery['config']['directory']) . '/' . self::THUMBS_SEPARATOR .  strtolower($gallery['config']['homePicture'])
																	: str_replace('source','thumb',$gallery['config']['directory']) . '/' .  strtolower($gallery['config']['homePicture']);
							} else {
								// homePicture contient une image invalide, supprimée ou déplacée
								// Définir l'image de couverture, première image disponible
								$this->makeThumb($fileInfos->getPath() . '/' . $fileInfos->getFilename(),
												str_replace('source','thumb',$fileInfos->getPath()) .  '/' . self::THUMBS_SEPARATOR  . strtolower($fileInfos->getFilename()),
												self::THUMBS_WIDTH);
								self::$firstPictures[$galleryId] =	file_exists( str_replace('source','thumb',$fileInfos->getPath()) . '/' . self::THUMBS_SEPARATOR  . strtolower($fileInfos->getFilename()))
																	? str_replace('source','thumb',$fileInfos->getPath()) . '/' . self::THUMBS_SEPARATOR .  strtolower($fileInfos->getFilename())
																	: str_replace('source','thumb',$fileInfos->getPath()) . '/' .  strtolower($fileInfos->getFilename());
							}
						}
						continue(1);
					}
				}
			}
			// Valeurs en sortie
			$this->addOutput([
				'showBarEditButton' => true,
				'showPageContent' => true,
				'view' => 'index',
				'style' => $this->getData(['module', $this->getUrl(0), 'theme', 'style'])
			]);
		}
	}

	/**
	 * Thème de la galerie
	 */
	public function theme() {
		// Lexique
		$param = '';
		include('./module/gallery/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_gallery.php');

		// Jeton incorrect
		if ($this->getUrl(2) !== $_SESSION['csrf']) {
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'notification' => $text['gallery']['theme'][0]
			]);
		}
		// Soumission du formulaire
		if($this->isPost()) {
			// Dossier de l'instance
			if (!is_dir(self::DATADIRECTORY . $this->getUrl(0) )) {
				mkdir (self::DATADIRECTORY . $this->getUrl(0), 0755, true);
			}
			$this->setData(['module', $this->getUrl(0), 'theme', [
					'thumbAlign' 	    => $this->getinput('galleryThemeThumbAlign', helper::FILTER_STRING_SHORT),
					'thumbWidth' 	    => $this->getinput('galleryThemeThumbWidth', helper::FILTER_STRING_SHORT),
					'thumbHeight'	    => $this->getinput('galleryThemeThumbHeight', helper::FILTER_STRING_SHORT),
					'thumbMargin'	    => $this->getinput('galleryThemeThumbMargin', helper::FILTER_STRING_SHORT),
					'thumbBorder'	    => $this->getinput('galleryThemeThumbBorder', helper::FILTER_STRING_SHORT),
					'thumbBorderColor'  => $this->getinput('galleryThemeThumbBorderColor', helper::FILTER_STRING_SHORT),
					'thumbOpacity'	    => $this->getinput('galleryThemeThumbOpacity', helper::FILTER_STRING_SHORT),
					'thumbShadows'   	=> $this->getinput('galleryThemeThumbShadows', helper::FILTER_STRING_SHORT),
					'thumbShadowsColor' => $this->getinput('galleryThemeThumbShadowsColor', helper::FILTER_STRING_SHORT),
					'thumbRadius'	    => $this->getinput('galleryThemeThumbRadius', helper::FILTER_STRING_SHORT),
					'legendHeight'	    => $this->getinput('galleryThemeLegendHeight', helper::FILTER_STRING_SHORT),
					'legendAlign'	    => $this->getinput('galleryThemeLegendAlign', helper::FILTER_STRING_SHORT),
					'legendTextColor'   => $this->getinput('galleryThemeLegendTextColor', helper::FILTER_STRING_SHORT),
					'legendBgColor'	    => $this->getinput('galleryThemeLegendBgColor', helper::FILTER_STRING_SHORT),
					'style'				=> self::DATADIRECTORY . $this->getUrl(0) . '/theme.css'
			]]);
			// Création des fichiers CSS
			$content = file_get_contents('module/gallery/ressource/vartheme.css');
			$themeCss = file_get_contents('module/gallery/ressource/theme.css');
			// Injection des variables
			$content = str_replace('#thumbAlign#',$this->getinput('galleryThemeThumbAlign'),$content );
			$content = str_replace('#thumbWidth#',$this->getinput('galleryThemeThumbWidth'),$content );
			$content = str_replace('#thumbHeight#',$this->getinput('galleryThemeThumbHeight'),$content );
			$content = str_replace('#thumbMargin#',$this->getinput('galleryThemeThumbMargin'),$content );
			$content = str_replace('#thumbBorder#',$this->getinput('galleryThemeThumbBorder'),$content );
			$content = str_replace('#thumbBorderColor#',$this->getinput('galleryThemeThumbBorderColor'),$content );
			$content = str_replace('#thumbOpacity#',$this->getinput('galleryThemeThumbOpacity'),$content );
			$content = str_replace('#thumbShadows#',$this->getinput('galleryThemeThumbShadows'),$content );
			$content = str_replace('#thumbShadowsColor#',$this->getinput('galleryThemeThumbShadowsColor'),$content );
			$content = str_replace('#thumbRadius#',$this->getinput('galleryThemeThumbRadius'),$content );
			$content = str_replace('#legendAlign#',$this->getinput('galleryThemeLegendAlign'),$content );
			$content = str_replace('#legendHeight#',$this->getinput('galleryThemeLegendHeight'),$content );
			$content = str_replace('#legendTextColor#',$this->getinput('galleryThemeLegendTextColor'),$content );
			$content = str_replace('#legendBgColor#',$this->getinput('galleryThemeLegendBgColor'),$content );
			$success = file_put_contents(self::DATADIRECTORY . $this->getUrl(0) . '/theme.css', $content . $themeCss);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl() . '/theme',
				'notification' => $success !== FALSE ? $text['gallery']['theme'][1] : $text['gallery']['theme'][2],
				'state' => $success !== FALSE
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => $text['gallery']['theme'][3],
			'view' => 'theme',
			'vendor' => [
				'tinycolorpicker'
			]
		]);
	}

}

