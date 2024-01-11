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
 * Module slider
 * Développé par Sylvain Lelièvre
 */

class slider extends common {

	public static $actions = [
		'config' => self::GROUP_EDITOR,
		'index' => self::GROUP_VISITOR
	];
	
	const VERSION = '6.3';	
	const REALNAME = 'Slider';
	const DELETE = true;
	const UPDATE = '0.0';
	const DATADIRECTORY = ''; // Contenu localisé inclus par défaut (page.json et module.json)

	public static $directories = [];

	public static $firstPictures = [];

	public static $galleries = [];

	public static $pictures = [];
	
	public static $pageList = [];
	
	public static $listDirs = [];
	
	public static $view_boutons;

	//Largeur du diaporama
	public static $maxwidth = [
		'400' => '400 pixels',
		'500' => '500 pixels',
		'600' => '600 pixels',
		'710' => '710 pixels',
		'800' => '800 pixels',
		'920' => '920 pixels',
		'1130' => '1130 pixels',
		'10000' => '100%'
	];
	
	//Temps de transition entre diapo
	public static $fadingtime = [
		'500' => '500 ms',
		'1000' => '1000 ms',
		'1500' => '1.5 s',
		'2000' => '2 s',
		'2500' => '2.5 s',
		'3000' => '3 s',
		'3500' => '3.5 s'
	];

	//Temps total entre 2 diapo
	public static $slidertime = [
		'600' => '600 ms',
		'1000' => '1 s',
		'1500' => '1.5 s',
		'2000' => '2 s',
		'3000' => '3 s',
		'5000' => '5 s',
		'7000' => '7 s',
		'10000' => '10 s'
	];

	//Temps d'apparition légende et boutons
	public static $apparition = [
		'opacity 0.2s ease-in' => '0.2s',
		'opacity 0.5s ease-in' => '0.5s',
		'opacity 1s ease-in' => '1s',
		'opacity 2s ease-in'	=> '2s'
	];
	
	/**
	* Mise à jour du module
	*/
	private function update() {
		
		// Mise à jour version 5.0 vers 6.0 ou Initialisation
		if (null === $this->getData(['module', $this->getUrl(0), 'config', 'versionData']) ) {	
			if(null !== $this->getData(['module', $this->getUrl(0) ]) ){ 
				$name = array_key_first(  $this->getData(['module', $this->getUrl(0) ]) );
				// Copie des clefs et données
				$old = $this->getData(['module', $this->getUrl(0), $name]);
				$this->setData(['module', $this->getUrl(0), $old]);
				// Efface les anciennes données et la donnée config name
				$this->deleteData(['module', $this->getUrl(0), $name ]);
				$this->deleteData(['module', $this->getUrl(0), 'config', 'name' ]);
				// Ajoute config versionData
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData','6.0']);
			}else{
				// Initialisation
				$this->setData(['module', $this->getUrl(0), 'config', 'versionData', self::VERSION]);
			}
		}
		// Version 6.3
		if (version_compare($this->getData(['module', $this->getUrl(0), 'config', 'versionData']), '6.3', '<') ) {
			$this->setData(['module', $this->getUrl(0), 'config', 'versionData','6.3']);
		}		
	}	


	/**
	 * Configuration
	 */
	public function config() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < slider::$actions['config'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./module/slider/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_slider.php');
			// Liste des dossiers dans site/file/source triés et non vides
			$filter = ['jpg', 'jpeg', 'png', 'gif', 'tiff', 'ico', 'webp'];
			self::$listDirs = helper::scanDir(self::FILE_DIR.'source', $filter);
			sort(self::$listDirs);
			// Liste des pages pour les liens sur image
			self::$pageList['-']='';
			foreach ($this->getHierarchy(null,null,null) as $parentKey=>$parentValue) {
				// Exclusions les barres, les pages masquées ou non publiques
				if ($this->getData(['page',$parentKey,'group']) !== 0  ||
					$this->getData(['page', $parentKey, 'block']) === 'bar' )  {
					continue;
				}
				self::$pageList [$parentKey] = $parentKey;
				foreach ($parentValue as $childKey) {
					self::$pageList [$childKey] = $childKey;
				}
			}
			// Valeurs par défaut si le slider n'existe pas encore
			if($this->getData(['module', $this->getUrl(0), 'config', 'directory']) === null){
				$this->setData(['module', $this->getUrl(0), [
					'config' => [
						'directory' => self::$listDirs[0],
						'boutonsVisibles' => 'slider2',
						'pagerVisible' => 'true',
						'maxiWidth' => '800',
						'fadingTime' => '1500',
						'sliderTime' => '5000',
						'visibiliteLegende' => 'survol',
						'positionLegende' => 'bas',
						'tempsApparition' => 'opacity 2s ease-in',
						'typeBouton' => 'cer_blanc',
						'tri' => 'SORT_ASC',
						'versionData' => self::VERSION
					],
					'legend' => [],
					'href' => []
				]]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => 'slider init',
					'state' => true
				]);
			}
			
			// Soumission du formulaire
			if($this->isPost()) {
				$legends = [];
				foreach((array) $this->getInput('legend', null) as $file => $legend) {
					$file = str_replace('.','',$file);
					$legends[$file] = helper::filter($legend, helper::FILTER_STRING_SHORT);
				}
				
				$hrefs = [];
				foreach((array) $this->getInput('sliderHref', null) as $file => $href) {
					$file = str_replace('.','',$file);
					$hrefs[$file] = self::$pageList[helper::filter($href, helper::FILTER_STRING_SHORT)];
				}

				$this->setData(['module', $this->getUrl(0), [
					'config' => [
						'directory' => self::$listDirs[$this->getInput('galleryEditDirectory')],
						'boutonsVisibles' => $this->getInput('sliderBoutonsVisibles', helper::FILTER_STRING_SHORT, true),
						'pagerVisible' => $this->getInput('sliderPagerVisible', helper::FILTER_STRING_SHORT, true),
						'maxiWidth' => $this->getInput('sliderMaxiWidth', helper::FILTER_STRING_SHORT, true),
						'fadingTime' => $this->getInput('sliderFadingTime', helper::FILTER_STRING_SHORT, true),
						'sliderTime' => $this->getInput('sliderDiapoTime', helper::FILTER_STRING_SHORT, true),
						'visibiliteLegende' => $this->getInput('sliderVisibiliteLegende', helper::FILTER_STRING_SHORT, true),
						'positionLegende' => $this->getInput('sliderPositionLegende', helper::FILTER_STRING_SHORT, true),
						'tempsApparition' => $this->getInput('sliderTempsApparition', helper::FILTER_STRING_SHORT, true),
						'typeBouton' => $this->getInput('sliderTypeBouton', helper::FILTER_STRING_SHORT, true),
						'tri' => $this->getInput('sliderTri', helper::FILTER_STRING_SHORT, true),
						'versionData' => self::VERSION
					],
					'legend' => $legends,
					'href' => $hrefs
				]]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => $text['slider']['edit'][1],
					'state' => true
				]);
			}
			// Met en forme le tableau
			$directory = $this->getData(['module', $this->getUrl(0), 'config', 'directory']);
			if(is_dir($directory)) {
				$iterator = new DirectoryIterator($directory);
				foreach($iterator as $fileInfos) {
					if($fileInfos->isDot() === false AND $fileInfos->isFile() AND @getimagesize($fileInfos->getPathname())) {
						self::$pictures[$fileInfos->getFilename()] = [
							$fileInfos->getFilename(),
							template::text('legend[' . $fileInfos->getFilename() . ']', [
								'value' => $this->getData(['module', $this->getUrl(0), 'legend', str_replace('.','',$fileInfos->getFilename())])
							]),
							template::select('sliderHref[' . $fileInfos->getFilename() . ']', self::$pageList,[
								'selected' => array_flip(self::$pageList)[$this->getData(['module', $this->getUrl(0), 'href', str_replace('.','',$fileInfos->getFilename())])]
							])
						];
					}
				}
				// Tri des images pour affichage de la liste dans la page de configuration
				switch ($this->getData(['module', $this->getUrl(0), 'config', 'tri'])) {
						case 'SORT_DSC':
							krsort(self::$pictures,SORT_NATURAL | SORT_FLAG_CASE);
							break;
						case 'SORT_ASC':
							ksort(self::$pictures,SORT_NATURAL | SORT_FLAG_CASE);
							break;
						case 'RAND':
							// sans intérêt ici
							break;
						case 'NONE':
							break;
						default:
							break;
				}
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['slider']['config'][3],
				'view' => 'config'
			]);
		}
	}

	/**
	 * Vue publique du slider
	 */
	public function index() {
		$this->update();
		$gallery = $this->getData(['module', $this->getUrl(0),'config','directory']);
		if( isset($gallery)){
			self::$galleries[0] = $gallery;
			// Images de la galerie
			if(is_dir($gallery)) {
				$iterator = new DirectoryIterator($gallery);
				foreach($iterator as $fileInfos) {
					if($fileInfos->isDot() === false AND $fileInfos->isFile() AND @getimagesize($fileInfos->getPathname())) {
						self::$pictures[$gallery . '/' . $fileInfos->getFilename()] = $this->getData(['module', $this->getUrl(0),'legend', str_replace('.','',$fileInfos->getFilename())]);
					}
				}
				// Tri des images par ordre alphabétique, alphabétique inverse, aléatoire ou pas
				switch ($this->getData(['module', $this->getUrl(0), 'config', 'tri'])) {
					case 'SORT_DSC':
						krsort(self::$pictures,SORT_NATURAL | SORT_FLAG_CASE);
						break;
					case 'SORT_ASC':
						ksort(self::$pictures,SORT_NATURAL | SORT_FLAG_CASE);
						break;
					case 'RAND':
						$tab1 = self::$pictures;
						// si absence de légende on en place une provisoire
						foreach($tab1 as $key1=>$value1){
							if($value1 == ''){
								$tab1[$key1] = $key1;
							}
						}
						$tab2 = array_flip($tab1);
						shuffle($tab2);
						$tab1 = array_flip($tab2);
						foreach($tab1 as $key1=>$value1){
							$tab1[$key1] = self::$pictures[$key1];
						}
						self::$pictures = $tab1;
						break;
					case 'NONE':
						break;
					default:
						break;
				}
				// Information sur la visibilité des boutons
				self::$view_boutons = $this->getData(['module', $this->getUrl(0), 'config','boutonsVisibles']);
			}
		}
		// Valeurs en sortie
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