<?php
/**
 * @license GNU General Public License, version 3
 * @copyright 2008-2018 © Rémi Jean
 * @copyright 2019 © Lionel Croquefer
 * @copyright 2024 © Sylvain Lelièvre
 */
setlocale(LC_NUMERIC,'English','en_US','en_US.UTF-8');
class album extends common {
	const VERSION = '5.2';
	const REALNAME = 'Album Photo';
	const DELETE = true;
	const UPDATE = '0.0';
	const DATADIRECTORY = '';
	const SORT_ASC = 'SORT_ASC';
	const SORT_DSC = 'SORT_DSC';
	const SORT_HAND = 'SORT_HAND';

	public static $directories = [];
	public static $firstPictures = [];
	public static $galleries = [];
	public static $galleriesId = [];
	public static $pictures = [];
	public static $picturesId = [];

	public static $actions = [
		'config' => self::GROUP_EDITOR,
		'delete' => self::GROUP_MODERATOR,
		'dirs' => self::GROUP_EDITOR,
		'sortGalleries' => self::GROUP_EDITOR,
		'sortPictures' 	=> self::GROUP_EDITOR,
		'edit' => self::GROUP_EDITOR,
		'texts' => self::GROUP_EDITOR,
		'index' => self::GROUP_VISITOR
	];

	/**
	 * Mise à jour du module
	 * Appelée par les fonctions index et config
	*/
	private function update() {
		// Lexique
		$param = '';
		include('./module/album/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_album.php');
		// Versions < 4.4 : versionData absent ou données module absentes
		if( null === $this->getData(['module', $this->getUrl(0), 'config', 'versionData']) ) {
			$this->init();
		} else {
			// Version 4.7
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '4.7', '<') ) {
				$this->setData(['module', $this->getUrl(0), 'config', 'texts', 'backButton', $text['album']['init'][0]]);
				$this->setData(['module', $this->getUrl(0), 'config', 'texts', 'geolocation', $text['album']['init'][1]]);
				$this->setData(['module', $this->getUrl(0), 'config', 'texts', 'noAlbum', $text['album']['init'][2]]);
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','4.7']);
			}
			// Mise à jour de la version du module
			if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), self::VERSION, '<') ) {
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData', self::VERSION]);
			}
		}
	}

	/**
	 * Initialisation
	*/
	private function init() {
		// Lexique
		$param = '';
		include('./module/album/lang/'. helper::lexlang($this->getData(['config', 'i18n', 'langBase']) , $this->getData(['config', 'i18n', 'langAdmin'])) . '/lex_album.php');
		$this->setData(['module', $this->getUrl(0), 'config', 'versionData', self::VERSION]);
		$this->setData(['module', $this->getUrl(0), 'config', 'texts', 'backButton', $text['album']['init'][0]]);
		$this->setData(['module', $this->getUrl(0), 'config', 'texts', 'geolocation', $text['album']['init'][1]]);
		$this->setData(['module', $this->getUrl(0), 'config', 'texts', 'noAlbum', $text['album']['init'][2]]);
	}

	/**
	 * Tri de la liste des galeries sans bouton
	 */
	public function sortGalleries () {
		// Autorisation
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < album::$actions['sortGalleries'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		} else {
			if($_POST['response']) {
				$data = explode('&',$_POST['response']);
				$data = str_replace('galleryTable%5B%5D=','',$data);
				for($i=0;$i<count($data);$i++) {
					$this->setData(['module', $this->getUrl(0), $data[$i], [
						'config' => [
							'name' => $this->getData(['module',$this->getUrl(0),$data[$i],'config','name']),
							'directory' => $this->getData(['module',$this->getUrl(0),$data[$i],'config','directory']),
							'homePicture' => $this->getData(['module',$this->getUrl(0),$data[$i],'config','homePicture']),
							'sort' => $this->getData(['module',$this->getUrl(0),$data[$i],'config','sort']),
							'position' => $i
						],
							'legend' => $this->getData(['module',$this->getUrl(0),$data[$i],'legend']),
							'order' => $this->getData(['module',$this->getUrl(0),$data[$i],'order'])
					]]);
				}
			}
		}
	}

	/**
	 * Traduction de textes en langue frontend
	 *
	 */
	public function texts() {
		// Autorisation
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < album::$actions['texts'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		} else {
			// Lexique
			$param = '';
			include('./module/album/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_album.php');

			// Soumission du formulaire
			if($this->isPost()) {
				$this->setData(['module', $this->getUrl(0), 'config', 'texts',[
					'backButton' => $this->getInput('albumTextsBackButton',helper::FILTER_STRING_SHORT),
					'geolocation' => $this->getInput('albumTextsGeolocation',helper::FILTER_STRING_SHORT),
					'noAlbum' => $this->getInput('albumTextsNoAlbum',helper::FILTER_STRING_SHORT)
				]]);

				$this->setData(['module', $this->getUrl(0), 'config', 'versionData', self::VERSION]);

				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['album']['texts'][0],
					'state' => true
				]);
			}

			$this->addOutput([
				'title' => $text['album']['texts'][1],
				'view' => 'texts',
			]);
		}
	}

	/**
	 * Tri de la liste des images
	 *
	 */
	public function sortPictures() {
		// Autorisation
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < album::$actions['sortPictures'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		} else {
		if($_POST['response']) {
			$galleryName = $_POST['gallery'];
			$data = explode('&',$_POST['response']);
			$data = str_replace('galleryTable%5B%5D=','',$data);
			// Sauvegarder
			$this->setData(['module', $this->getUrl(0), $galleryName, [
				'config' => [
					'name' => $this->getData(['module',$this->getUrl(0),$galleryName,'config','name']),
					'directory' => $this->getData(['module',$this->getUrl(0),$galleryName,'config','directory']),
					'homePicture' => $this->getData(['module',$this->getUrl(0),$galleryName,'config','homePicture']),
					'sort' => $this->getData(['module',$this->getUrl(0),$galleryName,'config','sort']),
					'position' => $this->getData(['module',$this->getUrl(0),$galleryName,'config','position'])

				],
				'legend' => $this->getData(['module',$this->getUrl(0),$galleryName,'legend']),
					'order' => array_flip($data)
			]]);
			}
		}
	}

	/**
	 * Configuration
	 */
	public function config() {
		// Autorisation
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < album::$actions['config'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		} else {
			// Lexique
			$param = '';
			include('./module/album/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_album.php');
			//Affichage de l'album triée sauf le faux tableau 'config'
			$g = $this->getData(['module', $this->getUrl(0)]);
			unset($g['config']);
			$p = helper::arrayCollumn(helper::arrayCollumn($g,'config'),'position');
			asort($p,SORT_NUMERIC);
			$galleries = [];
			foreach ($p as $positionId => $item) {
				$galleries [$positionId] = $g[$positionId];
			}
			// Traitement de l'affichage
			if($galleries) {
				foreach($galleries as $galleryId => $gallery) {
				// pour ne pas prendre en compte la fausse galerie 'config'
				if (isset($gallery['config']['directory']) && is_dir($gallery['config']['directory'])) {
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
			// Soumission du formulaire
			if($this->isPost()) {
				if (!$this->getInput('galleryConfigFilterResponse')) {
					$galleryId = helper::increment($this->getInput('galleryConfigName', helper::FILTER_ID, true), (array) $this->getData(['module', $this->getUrl(0)]));
					$this->setData(['module', $this->getUrl(0), $galleryId, [
						'config' => [
							'name' => $this->getInput('galleryConfigName'),
							'directory' => $this->getInput('galleryConfigDirectory', helper::FILTER_STRING_SHORT, true),
							'homePicture' => NULL, // homePicture non préalablement définie
							'sort' => self::SORT_ASC,
							'position' => $this->getData(['module',$this->getUrl(0)]) !== null ? count($this->getData(['module',$this->getUrl(0)])) + 1 : 0
						],
							'legend' => [],
							'order' => []
					]]);
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl() . $this->getUrl(),
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
	}

	/**
	 * Suppression
	 */
	public function delete() {
		// Autorisation
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < album::$actions['delete'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		} else {
			// Lexique
			$param = '';
			include('./module/album/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_album.php');

			// $url prend l'adresse sans le token
			// La galerie n'existe pas
			if($this->getData(['module', $this->getUrl(0), $this->getUrl(2)]) === null) {
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
				$this->deleteData(['module', $this->getUrl(0), $this->getUrl(2)]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['gallery']['delete'][1],
					'state' => true
				]);
			}
		}
	}

	/**
	 * Liste des dossiers
	 */
	public function dirs() {
		// Autorisation
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < album::$actions['dirs'] ) {
			$this->addOutput([
				'access' => false
			]);
		} else {
			// Valeurs en sortie
			$filter = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];
			$this->addOutput([
				'display' => self::DISPLAY_JSON,
				'content' => helper::scanDir(self::FILE_DIR.'source', $filter)
			]);
		}
	}

	/**
	 * Édition
	 */
	public function edit() {
		// Autorisation
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < album::$actions['edit'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		} else {
			// Lexique
			$param = '';
			include('./module/album/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_album.php');

		// Jeton incorrect
		if ($this->getUrl(3) !== $_SESSION['csrf']) {
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'notification' => $text['gallery']['edit'][0]
			]);
		}
		// La galerie n'existe pas
		if($this->getData(['module', $this->getUrl(0), $this->getUrl(2)]) === null) {
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
					$galleryId = helper::increment($galleryId, $this->getData(['module', $this->getUrl(0)]));
					// Transférer la position des images
					$oldorder = $this->getData(['module',$this->getUrl(0), $this->getUrl(2),'order']);
					// Supprime l'ancienne galerie
					$this->deleteData(['module', $this->getUrl(0), $this->getUrl(2)]);
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
				$this->setData(['module', $this->getUrl(0), $galleryId, [
					'config' => [
						'name' => $this->getInput('galleryEditName', helper::FILTER_STRING_SHORT, true),
						'directory' => $this->getInput('galleryEditDirectory', helper::FILTER_STRING_SHORT, true),
						'homePicture' => $homePicture,
						// pas d'ordre, on active le tri alpha
						'sort' =>  $this->getInput('galleryEditSort'),
						'position' => $this->getData(['module', $this->getUrl(0), $galleryId,'config','position'])
					],
					'legend' => $legends,
					'order' => empty($oldorder) ? $this->getData(['module', $this->getUrl(0), $galleryId, 'order']) : $oldorder
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
			$directory = $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'directory']);
			if(is_dir($directory)) {
				$iterator = new DirectoryIterator($directory);
				foreach($iterator as $fileInfos) {
					if($fileInfos->isDot() === false AND $fileInfos->isFile() AND substr(mime_content_type($fileInfos->getPathname()), 0, 5) == 'image') {
						self::$pictures[str_replace('.','',$fileInfos->getFilename())] = [
							template::ico('sort'),
							$fileInfos->getFilename(),
							template::checkbox( 'homePicture[' . $fileInfos->getFilename() . ']', true, '', [
								'checked' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2),'config', 'homePicture']) === $fileInfos->getFilename() ? true : false,
								'class' => 'homePicture'
							]),
							template::text('legend[' . $fileInfos->getFilename() . ']', [
								'value' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'legend', str_replace('.','',$fileInfos->getFilename())])
							]),
							'<a href="'.$fileInfos->getPathname().'" rel="data-lity"><img class="config" src="'.albumHelper::makeThumbnail($fileInfos->getPathname()).'" alt="miniature"></a>'
						];
						self::$picturesId [] = str_replace('.','',$fileInfos->getFilename());
					}
				}
				// Tri des images
				switch ($this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'sort'])) {
					case self::SORT_HAND:
						$order = $this->getData(['module',$this->getUrl(0), $this->getUrl(2),'order']);
						if ($order) {
							foreach ($order as $key => $value) {
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
				'title' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'name']),
				'view' => 'edit',
				'vendor' => [
					'tablednd'
				]
			]);
		}
	}
}

	/**
	 * Accueil
	 */
	public function index() {
		// Mise à jour des données de module
		if ( null===$this->getData(['module', $this->getUrl(0), 'config', 'versionData']) || version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), self::VERSION, '<') ) $this->update();
		// Images d'une galerie
		if($this->getUrl(1)) {
			// La galerie n'existe pas
			if($this->getData(['module', $this->getUrl(0), $this->getUrl(1)]) === null) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			}
			// La galerie existe
			else {
				// Images de la galerie
				$directory = $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'config', 'directory']);
				if(is_dir($directory)) {
					$iterator = new DirectoryIterator($directory);
					foreach($iterator as $fileInfos) {
						if($fileInfos->isDot() === false AND $fileInfos->isFile() AND substr(mime_content_type($fileInfos->getPathname()), 0, 5) == 'image') {
						// contrôle et traite éventuellement les images affichées dans la galerie
						$imgalerie = str_replace('\\','/',$fileInfos->getPathname());
						albumHelper::controle($imgalerie);
						self::$pictures[$directory . '/' . $fileInfos->getFilename()] = $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'legend', str_replace('.','',$fileInfos->getFilename())]);
						$picturesSort[$directory . '/' . $fileInfos->getFilename()] = $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'order', str_replace('.','',$fileInfos->getFilename())]);
						}
					}
					// Tri des images par ordre alphabétique
					switch ($this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'config', 'sort'])) {
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
						'title' => $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'config', 'name']),
						'view' => 'gallery'
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
			// Tri des galeries suivant l'ordre défini sauf pour la fausse galerie 'config'
			$g = $this->getData(['module', $this->getUrl(0)]);
			unset($g['config']);
			$p = helper::arrayCollumn(helper::arrayCollumn($g,'config'),'position');
			asort($p,SORT_NUMERIC);
			$galleries = [];
			foreach ($p as $positionId => $item) {
				$galleries [$positionId] = $g[$positionId];
			}
			// Construire le tableau
			foreach((array) $galleries as $galleryId => $gallery) {
				// pour ne pas prendre en compte la fausse galerie 'config'
				if (isset($gallery['config']['directory']) && is_dir($gallery['config']['directory'])) {
					$iterator = new DirectoryIterator($gallery['config']['directory']);
					foreach($iterator as $fileInfos) {
						if($fileInfos->isDot() === false AND $fileInfos->isFile() AND substr(mime_content_type($fileInfos->getPathname()), 0, 5) == 'image') {
						// contrôle et traite éventuellement les images affichées dans l'index de la galerie
						$imgalerie = str_replace('\\','/',$fileInfos->getPathname());
						albumHelper::controle($imgalerie);
						self::$galleries[$galleryId] = $gallery;
						self::$firstPictures[$galleryId] = $gallery['config']['directory'] . '/' . $fileInfos->getFilename();
						continue(2);
						}
					}
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
}
/* ********************** albumHelper ********************** */

class albumHelper extends helper {

	// création des dossiers
	public static function makeDir($rep) {
		if (is_dir($rep)) {
			return true;
		} else {
			if (mkdir($rep)) { return true; }
			else { return false; }
		}
	}

	// relevés exif gps des photos
	public static function gps_exif($foto) {
	if (!preg_match('/(\.jpe?g)$/i', $foto)) {
		return null;
	}
	if (function_exists('exif_read_data')) {
		$exif = @exif_read_data($foto, 0, true);
		if ($exif && isset($exif['GPS']['GPSLongitudeRef']) && !empty($exif['GPS']['GPSLongitude'][0])) {
			$latitude = self::gps($exif['GPS']['GPSLatitude'], $exif['GPS']['GPSLatitudeRef']);
			$longitude = self::gps($exif['GPS']['GPSLongitude'], $exif['GPS']['GPSLongitudeRef']);
			$altitude = 0;
			if (!empty($exif['GPS']['GPSAltitude'])) {
			$alt = explode('/',$exif['GPS']['GPSAltitude']);
			if (($alt[0] > 0) && ($alt[1] > 0)) {
			$altitude = round($alt[0] / $alt[1]);
			}
			}
			if ( (!isset($latitude) || !isset($longitude)) || (($latitude == 0) && ($longitude == 0)) ) {
				return null; }
			else {
				return ($latitude.'¤'.$longitude.'¤'.$altitude);
				}
			}
		}
	}
	public static function gps($coordinate, $hemisphere) {
	if (is_string($coordinate)) {
		$coordinate = array_map('trim', explode(',', $coordinate));
	}
	for ($i = 0; $i < 3; $i++) {
		$part = explode('/', $coordinate[$i]);
		if (count($part) == 1) {
			$coordinate[$i] = $part[0];
			} elseif ( (count($part) == 2) && ($part[1] > 0) ) {
				$coordinate[$i] = floatval($part[0])/floatval($part[1]);
			} else {
			$coordinate[$i] = 0;
		}
	}
	list($degrees, $minutes, $seconds) = $coordinate;
	$sign = ($hemisphere == 'W' || $hemisphere == 'S') ? -1 : 1;
	return $sign * ($degrees + $minutes/60 + $seconds/3600);
	}

	// formatage light des noms d'images
	public static function formate($foto) {
		$foto = trim($foto);
		$foto = preg_replace('/[^[:alnum:]_.\-\/]/', '', $foto);
		return $foto;
	}

	// renommage des fichiers transformés
	public static function renamePic($foto) {
		$imor = basename($foto);
		$extension = strrchr($imor,'.');
		$namimor = str_replace($extension,'',$imor);
		$redimg = dirname($foto).'/'.$namimor.'_t960.jpg';
		return $redimg;
	}

	// backup des images réorientées ou redimensionnées
	public static function backUp($foto) {
		$backup = dirname($foto).'/backup';
		self::makeDir($backup);
		$backimg = $backup.'/'.strtolower(str_replace('.jpeg','.jpg',basename($foto)));
		rename($foto,$backimg);
	}

	// réorientation
	public static function reorientation($foto) {
		$size = @getimagesize($foto);
		$mime = $size['mime'];
		// seules les images/jpeg sont réorientées
		if ((function_exists('exif_read_data')) && ($mime == 'image/jpeg')) {
			$exif = @exif_read_data($foto);
			$image = imagecreatefromstring(file_get_contents($foto));
			if ($image !== false) {
			$orientation = isset($exif['Orientation']) === true ? $exif['Orientation'] : '';
			if ( (!empty($orientation)) && ($orientation != 1) ) {
				switch($orientation) {
					case 3:
						$image = imagerotate($image,180,0);
						break;
					case 6:
						$image = imagerotate($image,-90,0);
						break;
					case 8:
						$image = imagerotate($image,90,0);
						break;
				}
				imagejpeg($image, self::renamePic($foto), 80);
				self::backUp($foto);
				echo '<script>document.location.reload(false);</script>';
				exit('Réorientation des photos...');
				}
			}
		}
	}

	// redimension
	public static function redimension($foto) {
	$max_size = 960;// dimension du plus petit côté
	$infoto = @getimagesize($foto);
		$large = $infoto[0];
		$haut = $infoto[1];
		$type = $infoto[2];
		// seules les images/jpeg sont redimensionnées
		if (($type == 2) && ($large > $max_size) && ($haut > $max_size)) {
			$src = imagecreatefromjpeg($foto);
			imageinterlace($src, true);
			if ($large > $haut) {
				$im = imagecreatetruecolor(round(($max_size/$haut)*$large), $max_size);
				imagecopyresampled($im, $src, 0, 0, 0, 0, round(($max_size/$haut)*$large), $max_size, $large, $haut);
			} else {
				$im = imagecreatetruecolor($max_size, round(($max_size/$large)*$haut));
				imagecopyresampled($im, $src, 0, 0, 0, 0, $max_size, round($haut*($max_size/$large)), $large, $haut);
			}
			if (strpos($foto, 't960.') == false) {
				imagejpeg($im, self::renamePic($foto), 80);
				imagedestroy($im);
				self::backUp($foto);
			} else {
				imagejpeg($im, $foto, 80);
				imagedestroy($im);
		}
			echo '<script>document.location.reload(false);</script>';
			exit('Redimension des photos...');
		}
	}

	// contrôle des photos
	public static function controle($foto) {
		$tn_tmp = basename($foto);
		$minidos = substr(strrchr(dirname($foto), '/'), 1);
		$mini = 'site/file/cache/'.$minidos.'/'.$tn_tmp;
		if (!file_exists($mini)) {
			$valid = array('-', '_','.');
			if (!ctype_alnum(str_replace($valid, '', $tn_tmp))) {
				$nommage = self::formate($foto);
				$foto = rename($foto,$nommage);
				echo '<script>document.location.reload(false);</script>';
				exit('Renommage des photos...');
			} else {
				self::reorientation($foto);
				self::redimension($foto);
			}
		}
		return $foto;
		clearstatcache();
	}

	// Thumbnailer
	public static function makeThumbnail($foto) {
		if ( is_file($foto) && substr(mime_content_type($foto), 0, 5) == 'image' ) {
			// taille des miniatures
			$tnlarge = 320;
			$tnhaut = ($tnlarge/1.6);

			$dossiercache = 'site/file/cache';
			self::makeDir($dossiercache);
			$cache = substr(strrchr(dirname($foto), '/'), 1);
			self::makeDir($dossiercache.'/'.$cache);

			$par = basename($foto);
			$extension = strrchr($par,'.');
			$vignette = str_replace($extension,'',$par);
			$miniature = $dossiercache.'/'.$cache.'/tn-'.$vignette.'-'.filesize($foto).'.webp';

			if (!file_exists($miniature)) {
				list($width, $height, $type, $attr) = getimagesize($foto);

				if ($height > $tnhaut) {
				$convert = $tnhaut/$height;
				$height = $tnhaut;
				$width = ceil($width*$convert);
				}
				if ($width > $tnlarge) {
				$convert = $tnlarge/$width;
				$width = $tnlarge;
				$height = ceil($height*$convert);
				}

				$largeur = $width;
				$hauteur = $height;

			switch ($type) {
				case 1:
				$img_in = imagecreatefromgif($foto);
				break;
				case 2:
				$img_in = imagecreatefromjpeg($foto);
				break;
				case 3:
				$img_in = imagecreatefrompng($foto);
				break;
				case 18:
				$webpContents = file_get_contents($foto);
				$anim = ( strpos($webpContents, 'ANIM') !== false || strpos($webpContents, 'ANMF') !== false );
				if ($anim === false) {
				$img_in = imagecreatefromwebp($foto);
				}
				else { $img_in = false; }
				break;
				case 19:
				$img_in = function_exists('imagecreatefromavif') ? imagecreatefromavif($foto) : false;
				break;
			}

				if (false !== $img_in) {
					imageinterlace($img_in, true);
					$img_out = imagecreatetruecolor($largeur, $hauteur) or die ('Unable to create a GD image stream');
				if ($type !== 2) {
					imagecolortransparent($img_out, imagecolorallocatealpha($img_out, 0, 0, 0, 127));
					imagealphablending($img_out, false);
					imagesavealpha($img_out, true);
				}
					imagecopyresampled($img_out, $img_in, 0, 0, 0, 0, imagesx($img_out), imagesy($img_out), imagesx($img_in), imagesy($img_in));
					imagewebp($img_out, $miniature, 80);
					imagedestroy($img_out);
				} else { $miniature = $foto; }
			}
			return $miniature;
			clearstatcache();
		}
		else { return false; }
	} // makeThumbnail

} // albumHelper
