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

class theme extends common {

	public static $actions = [
		'advanced' => self::GROUP_ADMIN,
		'body' => self::GROUP_ADMIN,
		'fonts' => self::GROUP_ADMIN, 
		'editFonts' => self::GROUP_ADMIN, 
		'deleteFonts' => self::GROUP_ADMIN, 
		'addFonts' => self::GROUP_ADMIN, 
		'footer' => self::GROUP_ADMIN,
		'header' => self::GROUP_ADMIN,
		'index' => self::GROUP_ADMIN,
		'menu' => self::GROUP_ADMIN,
		'reset' => self::GROUP_ADMIN,
		'site' => self::GROUP_ADMIN,
		'admin' => self::GROUP_ADMIN,
		'manage' => self::GROUP_ADMIN,
		'export' => self::GROUP_ADMIN,
		'import' => self::GROUP_ADMIN,
		'save' => self::GROUP_ADMIN
	];

	public static $siteFontSizes = [
		'12px' => '12 pixels',
		'13px' => '13 pixels',
		'14px' => '14 pixels',
		'15px' => '15 pixels',
		'16px' => '16 pixels',
		'18px' => '18 pixels',
		'20px' => '20 pixels'
	];

	// Fonts
	public static $fonts = [];
	public static $fontFiles =[];

	// Variable pour construire la liste des pages du site
	public static $pagesList = [];
	
	//Liste des dossiers avec images
	public static $listDirs =[];
	
	//Liste des pages
	public static $pageList = [];
	
	
	/**
	 * Thème des écrans d'administration
	 */
	public function admin() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['admin'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
			// Soumission du formulaire
			if($this->isPost()) {
				$this->setData(['admin', [
					'backgroundColor' 	=> $this->getInput('adminBackgroundColor'),
					'colorTitle' 		=> $this->getInput('adminColorTitle'),
					'colorText'			=> $this->getInput('adminColorText'),
					'colorButtonText' 	=> $this->getInput('adminColorButtonText'),
					'backgroundColorButton' 	=> $this->getInput('adminColorButton'),
					'backgroundColorButtonGrey'	=> $this->getInput('adminColorGrey'),
					'backgroundColorButtonRed'	=> $this->getInput('adminColorRed'),
					'backgroundColorButtonGreen'=> $this->getInput('adminColorGreen'),
					'backgroundColorButtonHelp'=> $this->getInput('adminColorHelp'),
					'fontText' 		=> $this->getInput('adminFontText'),
					'fontSize' 	=> $this->getInput('adminFontTextSize'),
					'fontTitle' => $this->getInput('adminFontTitle'),
					'backgroundBlockColor' => $this->getInput('adminBackGroundBlockColor'),
					'borderBlockColor' => $this->getInput('adminBorderBlockColor'),
					'maj' => true
				]]);
				// Valeurs en sortie
				$this->addOutput([
					'notification' => $text['core_theme']['admin'][0],
					'redirect' => helper::baseUrl() . 'theme/admin',
					'state' => true
				]);
			}
			self::$fonts = $this->extract('./site/data/fonts.json');		
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_theme']['admin'][1],
				'view' => 'admin',
				'vendor' => [
					'tinycolorpicker'
				],
			]);
		}
	}

	/**
	 * Mode avancé
	 */
	public function advanced() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['advanced'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
			// Soumission du formulaire
			if($this->isPost()) {
				// Enregistre le CSS
				file_put_contents(self::DATA_DIR.'custom.css', $this->getInput('themeAdvancedCss', null));
				// Valeurs en sortie
				$this->addOutput([
					'notification' => $text['core_theme']['advanced'][0],
					'redirect' => helper::baseUrl() . 'theme/advanced',
					'state' => true
				]);
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_theme']['advanced'][1],
				'vendor' => [
					'tinymce/plugins/codemirror/codemirror',
					'tinycolorpicker'
				],
				'view' => 'advanced'
			]);
		}
	}
	
	/**
	 * Gestion des polices / affichage principal
	 */
	public function fonts() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['fonts'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
			// Préparation du tableau d'affichage des polices
			$fontsName = helper::arrayCollumn($this->getData(['fonts']), 'name');
			ksort($fontsName);
			foreach($fontsName as $fontsId => $value) {
				
				self::$fonts[] = [
					'<span style="font-family:'.$this->getData(['fonts', $fontsId, 'name']).'">'.$fontsId.'</span>',
					'<span style="font-family:'.$this->getData(['fonts', $fontsId, 'name']).'">'.$this->getData(['fonts', $fontsId, 'name']).'</span>',
					'<span style="font-family:'.$this->getData(['fonts', $fontsId, 'name']).'">'.$this->getData(['fonts', $fontsId, 'file']).'</span>',
					'<span style="font-family:'.$this->getData(['fonts', $fontsId, 'name']).'">TPQtpq741àéèôüç</span>',
					template::button('fontsEdit' . $fontsId, [
						'href' => helper::baseUrl() . 'theme/editFonts/' . $fontsId,
						'value' => template::ico('pencil')
					]),
					template::button('fontsDelete' . $fontsId, [
						'class' => 'fontDelete buttonRed',
						'href' => helper::baseUrl() . 'theme/deleteFonts/' . $fontsId,
						'value' => template::ico('cancel')
					])
				];
				
			}
		
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_theme']['fonts'][0],
				'view' => 'fonts'
			]);
		}
	}
	
	/**
	 * Gestion des polices / édition
	 */
	public function editfonts() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['editfonts'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
			// Retour du formulaire
			if($this->isPost()) {
				if( $this->getInput('typeEditFont') === 'file' && $this->getInput('fileEditFont') === $text['core_theme']['editFonts'][0]){
					// Valeurs en sortie
					$this->addOutput([
						'notification' => $text['core_theme']['editFonts'][1],
						'redirect' => helper::baseUrl() . 'theme/fonts',
						'state' => false
					]);	
				}
				else{
					$file = $this->getInput('typeEditFont') === 'none' ? '' : $this->getInput('fileEditFont');
					$key = strtolower(str_replace(' ','-',$this->getInput('nameEditFont')));
					$this->setData(['fonts', $key, [
						'name' => $this->getInput('nameEditFont'),
						'type' => $this->getInput('typeEditFont'),
						'file' => $file,
						'link' => '',
						'license' => $this->getInput('licenseEditFont')
					]]);
					// Force une maj de admin.css
					$this-> setData(['admin', 'maj', true]);
					// Valeurs en sortie
					$this->addOutput([
						'notification' => $text['core_theme']['editFonts'][2],
						'redirect' => helper::baseUrl() . 'theme/fonts',
						'state' => true
					]);	
				}
			}
		
			// Fichiers site/file/fonts/
			if(is_dir(self::FILE_DIR.'source/fonts')) {
				$dir=self::FILE_DIR.'source/fonts';
				$values = scandir($dir);
				$values[0] = $text['core_theme']['editFonts'][0];
				unset($values[array_search('..', $values)]);
				if (count($values) <= 1){
					self::$icsFiles = array(0 => $text['core_theme']['editFonts'][3].self::FILE_DIR.'source/fonts');
				}
				else{
					//Modifier les clefs (qui sont les valeurs de retour du formulaire avec clef = valeur
					self::$fontFiles = array_combine($values,$values);
				}
			}
			else {
				self::$fontFiles = array(0 => $text['core_theme']['editFonts'][4].self::FILE_DIR.'source/fonts '.$text['core_theme']['editFonts'][5]);
			}
		
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_theme']['editFonts'][6],
				'view' => 'editFonts'
			]);
		}
	}
	
	/**
	 * Gestion des polices / suppression
	 */
	public function deleteFonts() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['deleteFonts'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
			//Suppression de la police passée en paramètre
			$this->deleteData(['fonts', $this->getUrl(2)]);
			// Force une maj de admin.css
			$this-> setData(['admin', 'maj', true]);
			// Valeurs en sortie
			$this->addOutput([
				'notification' => $text['core_theme']['deleteFonts'][0],
				'redirect' => helper::baseUrl() . 'theme/fonts',
				'state' => true
			]);
		}
	}
	
	/**
	 * Gestion des polices / ajout
	 */
	public function addFonts() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['addFonts'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
			// Retour du formulaire
			if($this->isPost()) {
				if( $this->getInput('typeAddFont') === 'file' && $this->getInput('fileAddFont') === $text['core_theme']['addFonts'][0]){
					// Valeurs en sortie
					$this->addOutput([
						'notification' => $text['core_theme']['addFonts'][1],
						'redirect' => helper::baseUrl() . 'theme/addFonts',
						'state' => false
					]);	
				}
				else{
					$file = $this->getInput('typeAddFont') === 'none' ? '' : $this->getInput('fileAddFont');
					$key = strtolower(str_replace(' ','-',$this->getInput('nameAddFont')));
					$this->setData(['fonts', $key, [
						'name' => $this->getInput('nameAddFont'),
						'type' => $this->getInput('typeAddFont'),
						'file' => $file,
						'link' => '',
						'license' => $this->getInput('licenseAddFont')
					]]);
					// Force une maj de admin.css
					$this-> setData(['admin', 'maj', true]);
					// Valeurs en sortie
					$this->addOutput([
						'notification' => $text['core_theme']['addFonts'][2],
						'redirect' => helper::baseUrl() . 'theme/fonts',
						'state' => true
					]);		
				}
			}
			// Fichiers site/file/fonts/
			if(is_dir(self::FILE_DIR.'source/fonts')) {
				$dir=self::FILE_DIR.'source/fonts';
				$values = scandir($dir);
				$values[0] = $text['core_theme']['addFonts'][0];
				unset($values[array_search('..', $values)]);
				if (count($values) <= 1){
					self::$icsFiles = array(0 => $text['core_theme']['addFonts'][3].self::FILE_DIR.'source/fonts');
				}
				else{
					//Modifier les clefs (qui sont les valeurs de retour du formulaire avec clef = valeur
					self::$fontFiles = array_combine($values,$values);
				}
			}
			else {
				self::$fontFiles = array(0 => $text['core_theme']['addFonts'][4].self::FILE_DIR.'source/fonts '.$text['core_theme']['addFonts'][5]);
			}

			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_theme']['addFonts'][6],
				'view' => 'addFonts'
			]);
		}
	}	
	
	
	/**
	 * Options de l'arrière plan
	 */
	public function body() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['body'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
			// Soumission du formulaire
			if($this->isPost()) {
				$this->setData([ 'theme', 'update', true]);
				$this->setData(['theme', 'body', [
					'backgroundColor' => $this->getInput('themeBodyBackgroundColor'),
					'image' => $this->getInput('themeBodyImage'),
					'imageAttachment' => $this->getInput('themeBodyImageAttachment'),
					'imagePosition' => $this->getInput('themeBodyImagePosition'),
					'imageRepeat' => $this->getInput('themeBodyImageRepeat'),
					'imageSize' => $this->getInput('themeBodyImageSize'),
					'toTopbackgroundColor' => $this->getInput('themeBodyToTopBackground'),
					'toTopColor' => $this->getInput('themeBodyToTopColor')
				]]);
				// Valeurs en sortie
				$this->addOutput([
					'notification' => $text['core_theme']['body'][0],
					'redirect' => helper::baseUrl() . 'theme',
					'state' => true
				]);
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_theme']['body'][1],
				'vendor' => [
					'tinycolorpicker'
				],
				'view' => 'body'
			]);
		}
	}

	/**
	 * Options du pied de page
	 */
	public function footer() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['footer'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
			// Soumission du formulaire
			if($this->isPost()) {
				$this->setData([ 'theme', 'update', true]);
				if ( $this->getInput('themeFooterCopyrightPosition') === 'hide' &&
					 $this->getInput('themeFooterSocialsPosition') === 'hide' &&
					 $this->getInput('themeFooterTextPosition') === 'hide' 	) {
					// Valeurs en sortie
					$this->addOutput([
						'notification' => $text['core_theme']['footer'][0],
						'redirect' => helper::baseUrl() . 'theme/footer',
						'state' => false
					]);
				} else {
					$this->setData(['theme', 'footer', [
						'backgroundColor' => $this->getInput('themeFooterBackgroundColor'),
						'copyrightAlign' => $this->getInput('themeFooterCopyrightAlign'),
						'height' => $this->getInput('themeFooterHeight'),
						'loginLink' => $this->getInput('themeFooterLoginLink'),
						'margin' => $this->getInput('themeFooterMargin', helper::FILTER_BOOLEAN),
						'position' => $this->getInput('themeFooterPosition'),
						'fixed' => $this->getInput('themeFooterFixed', helper::FILTER_BOOLEAN),
						'socialsAlign' => $this->getInput('themeFooterSocialsAlign'),
						'text' => $this->getInput('themeFooterText', null),
						'textAlign' => $this->getInput('themeFooterTextAlign'),
						'textColor' => $this->getInput('themeFooterTextColor'),
						'copyrightPosition' => $this->getInput('themeFooterCopyrightPosition'),
						'textPosition' => $this->getInput('themeFooterTextPosition'),
						'socialsPosition' => $this->getInput('themeFooterSocialsPosition'),
						'textTransform' => $this->getInput('themeFooterTextTransform'),
						'font' => $this->getInput('themeFooterFont'),
						'fontSize' => $this->getInput('themeFooterFontSize'),
						'fontWeight' => $this->getInput('themeFooterFontWeight'),
						'displayVersion' => $this->getInput('themefooterDisplayVersion', helper::FILTER_BOOLEAN),
						'displaySiteMap' => $this->getInput('themefooterDisplaySiteMap', helper::FILTER_BOOLEAN),
						'displayCopyright' => $this->getInput('themefooterDisplayCopyright', helper::FILTER_BOOLEAN),
						'displayCookie' => $this->getInput('themefooterDisplayCookie', helper::FILTER_BOOLEAN),
						'displayLegal' =>  $this->getInput('themeFooterDisplayLegal', helper::FILTER_BOOLEAN),
						'displaySearch' =>  $this->getInput('themeFooterDisplaySearch', helper::FILTER_BOOLEAN),
						'displayMemberBar'=> $this->getInput('themeFooterDisplayMemberBar', helper::FILTER_BOOLEAN),
						'template' => $this->getInput('themeFooterTemplate'),
						'displayWhois' => $this->getInput('themeFooterDisplayWhois', helper::FILTER_BOOLEAN)
					]]);

					// Sauvegarder la configuration localisée
					$this->setData(['locale','legalPageId', $this->getInput('configLegalPageId')]);
					$this->setData(['locale','searchPageId', $this->getInput('configSearchPageId')]);
					
					// Valeurs en sortie
					$this->addOutput([
						'notification' => $text['core_theme']['footer'][1],
						'redirect' => helper::baseUrl() . 'theme',
						'state' => true
					]);
				}
			}

			// Liste des pages
			self::$pagesList = $this->getData(['page']);
			foreach(self::$pagesList as $page => $pageId) {
				if ($this->getData(['page',$page,'block']) === 'bar' ||
					$this->getData(['page',$page,'disable']) === true) {
					unset(self::$pagesList[$page]);
				}
			}
			self::$fonts = $this->extract('./site/data/fonts.json');
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_theme']['footer'][2],
				'vendor' => [
					'tinycolorpicker'
				],
				'view' => 'footer'
			]);
		}
	}

	/**
	 * Options de la bannière
	 */
	public function header() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['header'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
			// Liste des dossiers dans site/file/source triés et non vides
			$filter = ['jpg', 'jpeg', 'png', 'gif', 'tiff', 'ico', 'webp'];
			self::$listDirs = helper::scanDir(self::FILE_DIR.'source', $filter);
			sort(self::$listDirs);
			// Soumission du formulaire
			if($this->isPost()) {
				$this->setData([ 'theme', 'update', true]);
				// Modification des URL des images dans la bannière perso
				$featureContent = $this->getInput('themeHeaderText', null);
				// Bannière animée avec swiper	
				$swiperContent = '';
				if( $this->getInput('themeHeaderFeature') === 'swiper' ){
					$swiperContent = $this->swiperContent('header');
					$headerHeight = 'unset';
				} else {
					$headerHeight = $this->getInput('themeHeaderHeight');
				}
				// $featureContent = str_replace(helper::baseUrl(false,false), './', $featureContent);
				// Si une image est positionnée, l'arrière en transparent.
				$this->setData(['theme', 'header', [
					'backgroundColor' => $this->getInput('themeHeaderBackgroundColor'),
					'font' => $this->getInput('themeHeaderFont'),
					'fontSize' => $this->getInput('themeHeaderFontSize'),
					'fontWeight' => $this->getInput('themeHeaderFontWeight'),
					'heightSelect' => $headerHeight,
					'wide' => $this->getInput('themeHeaderWide'),
					'image' => $this->getInput('themeHeaderImage'),
					'imagePosition' => $this->getInput('themeHeaderImagePosition'),
					'imageRepeat' => $this->getInput('themeHeaderImageRepeat'),
					'margin' => $this->getInput('themeHeaderMargin', helper::FILTER_BOOLEAN),
					'position' => $this->getInput('themeHeaderPosition'),
					'textAlign' => $this->getInput('themeHeaderTextAlign'),
					'textColor' => $this->getInput('themeHeaderTextColor'),
					'textHide' => $this->getInput('themeHeaderTextHide', helper::FILTER_BOOLEAN),
					'textTransform' => $this->getInput('themeHeaderTextTransform'),
					'linkHomePage' => $this->getInput('themeHeaderlinkHomePage',helper::FILTER_BOOLEAN),
					'imageContainer' => $this->getInput('themeHeaderImageContainer'),
					'tinyHidden' => $this->getInput('themeHeaderTinyHidden', helper::FILTER_BOOLEAN),
					'feature' => $this->getInput('themeHeaderFeature'),
					'featureContent' => $featureContent,
					'homePageOnly' => $this->getInput('themeHeaderHomePageOnly', helper::FILTER_BOOLEAN),
					'swiperImagesDir' => self::$listDirs[$this->getInput('themeHeaderDirectory')],
					'swiperContent' => $swiperContent,
					'swiperEffects' => $this->getInput('themeHeaderSwiperEffects'),
					'swiperDirection' => $this->getInput('themeHeaderSwiperDirection', helper::FILTER_BOOLEAN),
					'swiperTime' => $this->getInput('themeHeaderSwiperTime'),
					'swiperTransition' => $this->getInput('themeHeaderSwiperTransition')
				]]);
				// Modification de la position du menu selon la position de la bannière
				if  ( $this->getData(['theme','header','position']) == 'site'  )
					{
						$this->setData(['theme', 'menu', 'position',str_replace ('body-','site-',$this->getData(['theme','menu','position']))]);
				}
				if  ( $this->getData(['theme','header','position']) == 'body')
					{
						$this->setData(['theme', 'menu', 'position',str_replace ('site-','body-',$this->getData(['theme','menu','position']))]);
				}
				// Menu accroché à la bannière qui devient cachée
				if  ( $this->getData(['theme','header','position']) == 'hide' &&
					  in_array( $this->getData(['theme','menu','position']) , ['body-first', 'site-first', 'body-first' , 'site-second'])
					 ) {
						$this->setData(['theme', 'menu', 'position','site']);
				}
				// Suppression de l'image en contenu personnalisé
				if( $this->getData(['theme','header','feature']) == 'feature'){
						$this->setData(['theme','header', 'image',""]);
				}
				// Application de la hauteur de l'image sélectionnée si hauteur de l'image sur hauteur du contenu
				if( $this->getData(['theme', 'header', 'feature']) ==='wallpaper' &&
				  $this->getData(['theme', 'header', 'image']) !== '' &&
				  $this->getData(['theme', 'header', 'heightSelect']) === 'unset' ){
					$infoImage = getimagesize( self::FILE_DIR.'source/'. $this->getData(['theme', 'header', 'image']) );
					$this->setData(['theme', 'header', 'height', $infoImage[1]."px"]);
				} else {
				// Si pas d'image ou bannière personnalisée
					$this->setData(['theme', 'header', 'height', $this->getData(['theme', 'header', 'heightSelect']) ]);
				}
				// Valeurs en sortie
				if (isset($_POST['themeHeaderSubmit'])){
					$this->addOutput([
						'notification' => $text['core_theme']['header'][0],
						'redirect' => helper::baseUrl() . 'theme',
						'state' => true
					]);
				} else { //Preview
					$this->addOutput([
						'redirect' => helper::baseUrl() . 'theme/header'
					]);
				}
			}
			self::$fonts = $this->extract('./site/data/fonts.json');
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_theme']['header'][1],
				'vendor' => [
					'tinycolorpicker',
					'tinymce'
				],
				'view' => 'header'
			]);
		}
	}

	/**
	 * Accueil de la personnalisation
	 */
	public function index() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['index'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_theme']['index'][0],
				'view' => 'index'
			]);
		}
	}

	/**
	 * Options du menu
	 */
	public function menu() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['menu'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
			// Soumission du formulaire
			if($this->isPost()) {
				$this->setData([ 'theme', 'update', true]);
				$this->setData(['theme', 'menu', [
					'backgroundColor' => $this->getInput('themeMenuBackgroundColor'),
					'backgroundColorSub' => $this->getInput('themeMenuBackgroundColorSub'),
					'font' => $this->getInput('themeMenuFont'),
					'fontSize' => $this->getInput('themeMenuFontSize'),
					'fontWeight' => $this->getInput('themeMenuFontWeight'),
					'height' => $this->getInput('themeMenuHeight'),
					'wide' => $this->getInput('themeMenuWide'),
					'loginLink' => $this->getInput('themeMenuLoginLink', helper::FILTER_BOOLEAN),
					'margin' => $this->getInput('themeMenuMargin', helper::FILTER_BOOLEAN),
					'position' => $this->getInput('themeMenuPosition'),
					'textAlign' => $this->getInput('themeMenuTextAlign'),
					'textColor' => $this->getInput('themeMenuTextColor'),
					'textTransform' => $this->getInput('themeMenuTextTransform'),
					'fixed' => $this->getInput('themeMenuFixed', helper::FILTER_BOOLEAN),
					'activeColorAuto' => $this->getInput('themeMenuActiveColorAuto', helper::FILTER_BOOLEAN),
					'activeColor' => $this->getInput('themeMenuActiveColor'),
					'activeTextColor' => $this->getInput('themeMenuActiveTextColor'),
					'radius' => $this->getInput('themeMenuRadius'),
					'burgerTitle' => $this->getInput('themeMenuBurgerTitle', helper::FILTER_BOOLEAN),
					'memberBar' =>  $this->getInput('themeMenuMemberBar', helper::FILTER_BOOLEAN),
					'invertColor' =>  $this->getInput('themeMenuInvertColor', helper::FILTER_BOOLEAN),
					'changeFontSize' => $this->getInput('themeMenuChangeFontSize', helper::FILTER_BOOLEAN),
					'burgerIcon1' => $this->getInput('themeMenuBurgerIcon1'),
					'burgerIcon2' => $this->getInput('themeMenuBurgerIcon2'),
					'burgerContent' => $this->getInput('themeMenuBurgerContent'),
					'burgerTextColor' => $this->getInput('themeMenuBurgerTextColor'),
					'burgerFontSize' => $this->getInput('themeMenuBurgerFontSize'),
					'minWidthTab' => $this->getInput('themeMenuMinWidthTab'),
					'minWidthParentOrAll' => $this->getInput('themeMenuMinWidthParentOrAll', helper::FILTER_BOOLEAN),
					'burgerFixed' => $this->getInput('themeMenuBurgerFixed', helper::FILTER_BOOLEAN),
					'burgerIconColor' => $this->getInput('themeMenuBurgerIconColor'),
					'burgerIconBgColor' => $this->getInput('themeMenuBurgerIconBgColor'),
					'burgerBannerColor' => $this->getInput('themeMenuBurgerBannerColor'),
					'burgerTextMenuColor' => $this->getInput('themeMenuBurgerTextMenuColor'),
					'burgerActiveTextColor' => $this->getInput('themeMenuBurgerActiveTextColor'),
					'burgerBackgroundColor' => $this->getInput('themeMenuBurgerBackgroundColor'),
					'burgerActiveColorAuto' => $this->getInput('themeMenuBurgerActiveColorAuto', helper::FILTER_BOOLEAN),
					'burgerActiveColor' => $this->getInput('themeMenuBurgerActiveColor'),
					'burgerBackgroundColorSub' => $this->getInput('themeMenuBurgerBackgroundColorSub'),
					'burgerOverlay' => $this->getInput('themeMenuBurgerOverlay', helper::FILTER_BOOLEAN)
				]]);
				$this->setData(['locale', 'menuBurger', [
					'burgerLeftIconLink' => $this->getInput('themeMenuBurgerLeftIconLink'),
					'burgerCenterIconLink' => $this->getInput('themeMenuBurgerCenterIconLink')
				]]);
				
				// Valeurs en sortie
				if (isset($_POST['themeMenuSubmit'])){
					$this->addOutput([
						'notification' => $text['core_theme']['menu'][0],
						'redirect' => helper::baseUrl() . 'theme',
						'state' => true
					]);
				} else { // Preview
					$this->addOutput([
						'redirect' => helper::baseUrl() . 'theme/menu'
					]);
				}
			}
			// Liste des pages pour les liens sur icônes
			foreach ($this->getHierarchy(null,true,null) as $parentKey=>$parentValue) {
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
			
			
			self::$fonts = $this->extract('./site/data/fonts.json');
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_theme']['menu'][1],
				'vendor' => [
					'tinycolorpicker'
				],
				'view' => 'menu'
			]);
		}
	}

	/**
	 * Réinitialisation de la personnalisation avancée
	 */
	public function reset() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['reset'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
			// $url prend l'adresse sans le token
			$url = explode('&',$this->getUrl(2));

			if  ( isset($_GET['csrf'])
				 AND $_GET['csrf'] === $_SESSION['csrf']
				) {
				// Réinitialisation
				$redirect ='';
				switch ($url[0]) {
					case 'admin':
						$this->initData('admin');
						$redirect = helper::baseUrl() . 'theme/admin';
						break;
					case 'manage':
						$this->initData('theme');
						$redirect = helper::baseUrl() . 'theme/manage'; 
						break;
					case 'custom':
						unlink(self::DATA_DIR.'custom.css');
						$redirect = helper::baseUrl() . 'theme/advanced';
						break;
					default :
						$redirect = helper::baseUrl() . 'theme';
				}

				// Valeurs en sortie
				$this->addOutput([
					'notification' => $text['core_theme']['reset'][0],
					'redirect' => $redirect,
					'state' => true
				]);
			} else {
				// Valeurs en sortie
				$this->addOutput([
					'notification' => $text['core_theme']['reset'][1]
				]);
			}
		}
	}


	/**
	 * Options du site
	 */
	public function site() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['site'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
			// Soumission du formulaire
			if($this->isPost()) {
				$this->setData([ 'theme', 'update', true]);
				$this->setData(['theme', 'title', [
					'font' => $this->getInput('themeTitleFont'),
					'textColor' => $this->getInput('themeTitleTextColor'),
					'fontWeight' => $this->getInput('themeTitleFontWeight'),
					'textTransform' => $this->getInput('themeTitleTextTransform')
				]]);
				$this->setData(['theme', 'text', [
					'font' => $this->getInput('themeTextFont'),
					'fontSize' => $this->getInput('themeTextFontSize'),
					'textColor' => $this->getInput('themeTextTextColor'),
					'linkColor'=> $this->getInput('themeTextLinkColor')
				]]);
				$this->setData(['theme', 'site', [
					'backgroundColor' => $this->getInput('themeSiteBackgroundColor'),
					'radius' => $this->getInput('themeSiteRadius'),
					'shadow' => $this->getInput('themeSiteShadow'),
					'width' => $this->getInput('themeSiteWidth'),
					'margin' => $this->getInput('themeSiteMargin',helper::FILTER_BOOLEAN)
				]]);
				$this->setData(['theme', 'button', [
					'backgroundColor' => $this->getInput('themeButtonBackgroundColor')
				]]);
				$this->setData(['theme', 'block', [
					'backgroundColor' => $this->getInput('themeBlockBackgroundColor'),
					'borderColor' => $this->getInput('themeBlockBorderColor'),
					'backgroundTitleColor' => $this->getInput('themeBlockBackgroundTitleColor'),
					'blockBorderRadius' => $this->getInput('themeBlockBorderRadius'),
					'blockBorderShadow' => $this->getInput('themeBlockBorderShadow')
				]]);
				// Si barrière animée nouveau swiperContent
				if($this->getData(['theme', 'header', 'feature']) === 'swiper' ) $this->swiperContent('site');
				// Valeurs en sortie
				$this->addOutput([
					'notification' => $text['core_theme']['site'][0],
					'redirect' => helper::baseUrl() . 'theme',
					'state' => true
				]);
			}
			self::$fonts = $this->extract('./site/data/fonts.json');
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_theme']['site'][1],
				'vendor' => [
					'tinycolorpicker'
				],
				'view' => 'site'
			]);
		}
	}

	/**
	 * Import du thème
	 */
	public function manage() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['manage'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');

			if($this->isPost() ) {
				if( isset( $_POST['themeSaveTheme'])){
					$this->save('theme',$this->getInput('themeSaveName'));
				} elseif( isset( $_POST['themeSaveAdmin'])){
					$this->save('admin',$this->getInput('themeSaveName'));
				} elseif( isset( $_POST['themeExportTheme'])){
					$this->export('theme',$this->getInput('themeExportName'));
				} elseif( isset( $_POST['themeExportAdmin'])){
					$this->export('admin',$this->getInput('themeExportName'));
				}else {
					$zipFilename =	$this->getInput('themeManageImport', helper::FILTER_STRING_SHORT, true);		
					$data = $this->import(self::FILE_DIR.'source/' . $zipFilename);
					if ($data['success']) {
						// Refresh: 0 bien contenu dans la réponse envoyée au navigateur mais sans l'effet attendu
						header("Refresh: 0");
						$this->addOutput([
							'notification' => $data['notification'],
							'redirect' => helper::baseUrl() . 'theme',
							'state' => $data['success']
						]);
					} else {
						// Valeurs en sortie
						$this->addOutput([
							'notification' => $data['notification'],
							'state' => $data['success'],
							'title' => $text['core_theme']['manage'][0],
							'view' => 'manage'
						]);;
					}
				}
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_theme']['manage'][0],
				'view' => 'manage'
			]);
		}
	}

	/**
	 * Importe un thème
	 * @param string Url du thème à télécharger
	 * @param @return array contenant $success = true ou false ; $ notification string message à afficher
	 */

	public function import($zipName = '') {
		// Pas de sécurité car cette fonction est utilisée à l'installation
		// Lexique
		include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');

		if ($zipName !== '' &&
			file_exists($zipName)) {
			// Init variables de retour
			$success = false;
			$notification = '';
			// Dossier temporaire
			$tempFolder = uniqid();
			// Ouvrir le zip
			$zip = new ZipArchive();
			if ($zip->open($zipName) === TRUE) {
				mkdir (self::TEMP_DIR . $tempFolder, 0755);
				$zip->extractTo(self::TEMP_DIR . $tempFolder );
				$modele = '';
				// Archive de thème ?
				if (
					file_exists(self::TEMP_DIR . $tempFolder . '/site/data/custom.css')
					AND file_exists(self::TEMP_DIR . $tempFolder . '/site/data/theme.css')
					AND file_exists(self::TEMP_DIR . $tempFolder . '/site/data/theme.json')
					) {
						$modele = 'theme';
						$this->sauve( $modele );
					}
				if(
					file_exists(self::TEMP_DIR . $tempFolder . '/site/data/admin.json')
					AND file_exists(self::TEMP_DIR . $tempFolder . '/site/data/admin.css')
				) {
						$modele = 'admin';
						$this->sauve( $modele );
				}
				if (!empty($modele)
				) {
					// traiter l'archive
					$importFolder = './site/file/import';
					mkdir ($importFolder, 0755);
					$success = $zip->extractTo($importFolder);
					// $path = $importFolder.'/site/file/source/';
					// Modifie le nom de tous les fichiers de $path et leur nom dans theme.json
					// $this->changeName($path);
					$this->copyDir( $importFolder, './');
					$this->removeDir($importFolder);
					// traitement de l'erreur
					$notification = $success ? $text['core_theme']['import'][0] : $text['core_theme']['import'][1];


				} else {
					// pas une archive de thème
					$success = false;
					$notification = $text['core_theme']['import'][2];
				}
				// Supprimer le dossier temporaire même si le thème est invalide
				$this->removeDir(self::TEMP_DIR . $tempFolder);
				$zip->close();
			} else {
				// erreur à l'ouverture
				$success = false;
				$notification = $text['core_theme']['import'][3];
			}
			return (['success' => $success, 'notification' => $notification]);
		}

		return (['success' => false, 'notification' => $text['core_theme']['import'][4]]);
	}



	/**
	 * Export du thème
	 */
	public function export($modele, $name) {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['export'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Make zip
			$zipFilename = $this->zipTheme($modele, $name);
			// Téléchargement du ZIP
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Transfer-Encoding: binary');
			header('Content-Disposition: attachment; filename="' . $zipFilename . '"');
			header('Content-Length: ' . filesize(self::TEMP_DIR . $zipFilename));
			readfile(self::TEMP_DIR . $zipFilename);
			// Nettoyage du dossier
			unlink (self::TEMP_DIR . $zipFilename);
			exit();
		}
	}

	/**
	 * Export du thème
	 */
	public function save($modele, $name) {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < theme::$actions['save'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
			// Make zip
			$zipFilename = $this->zipTheme($modele, $name);
			// Téléchargement du ZIP
			if (!is_dir(self::FILE_DIR.'source/theme')) {
				mkdir(self::FILE_DIR.'source/theme', 0755);
			}
			copy (self::TEMP_DIR . $zipFilename , self::FILE_DIR.'source/theme/' . $zipFilename);
			// Nettoyage du dossier
			unlink (self::TEMP_DIR . $zipFilename);
			// Valeurs en sortie
			$this->addOutput([
				'notification' => $text['core_theme']['save'][0].'<b>'.$zipFilename.'</b>'. $text['core_theme']['save'][1],
				'redirect' => helper::baseUrl() . 'theme/manage',
				'state' => true
			]);
		}
	}
	
	/**
	* Sauvegarde du thème du site ou de l'administration avant application d'un nouveau thème
	*/
	public function sauve( $type ) {
		// Make zip
		$zipFilename = $this->zipTheme( $type, '' );
		// Téléchargement du ZIP
		if (!is_dir(self::FILE_DIR.'source/theme')) {
			mkdir(self::FILE_DIR.'source/theme', 0755);
		}
		copy (self::TEMP_DIR . $zipFilename , self::FILE_DIR.'source/theme/' . $zipFilename);
		// Nettoyage du dossier
		unlink (self::TEMP_DIR . $zipFilename);
		return;
	}

	/**
	 * construction du zip
	 * @param string $modele theme ou admin
	 */
	private function zipTheme($modele, $name) {
		// Creation du dossier
		if( $name === '' || $name === null){ 
			$name = $modele . date('Y-m-d-H-i-s', time()) ;
		} else {
			$name = str_replace('.','',$name);
		}		
		$zipFilename  = $name . '.zip';
		$zip = new ZipArchive();
		if ($zip->open(self::TEMP_DIR . $zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE ) === TRUE) {
			switch ($modele) {
				case 'admin':
					$zip->addFile(self::DATA_DIR.'admin.json',self::DATA_DIR.'admin.json');
					$zip->addFile(self::DATA_DIR.'admin.css',self::DATA_DIR.'admin.css');
					break;
				case 'theme':
					$zip->addFile(self::DATA_DIR.'theme.json',self::DATA_DIR.'theme.json');
					$zip->addFile(self::DATA_DIR.'theme.css',self::DATA_DIR.'theme.css');
					$zip->addFile(self::DATA_DIR.'custom.css',self::DATA_DIR.'custom.css');
					if ($this->getData(['theme','body','image']) !== '' ) {
					$zip->addFile(self::FILE_DIR.'source/'.$this->getData(['theme','body','image']),
								self::FILE_DIR.'source/'.$this->getData(['theme','body','image'])
								);
					}
					if ($this->getData(['theme','header','image']) !== '' ) {
					$zip->addFile(self::FILE_DIR.'source/'.$this->getData(['theme','header','image']),
								  self::FILE_DIR.'source/'.$this->getData(['theme','header','image'])
								);
					}
					// Extraction des images de la bannière personnalisée
					$images=[];
					$ii=0;
					if( $this->getData(['theme','header','feature'])=== 'feature') {
						$tab = str_word_count($this->getData(['theme','header','featureContent']), 1, './' );
						foreach( $tab as $key=>$value ){
                        	if( $value ==='src'){
                              	$images[$ii] = $tab [$key + 1];
                              	$ii++;
							}
						}
						// ajout des images dans le zip
						foreach( $images as $key=>$value){
							$value = str_replace( './site', 'site' , $value);
							$zip->addFile( $value, $value );
						}
					}
					// Extraction des images de la bannière animée avec swiper
					if( $this->getData(['theme','header','feature'])=== 'swiper') {
						$dir = $this->getData(['theme', 'header', 'swiperImagesDir']);
						$scandir = scandir('./'.$dir);
						foreach($scandir as $file){
							if(preg_match("#\.(jpg|jpeg|png|gif|tiff|svg|webp)$#",strtolower($file))){
								$value = $dir.'/'.$file;
								$zip->addFile( $value, $value );
							}
						}
					}
					break;
			}
			$ret = $zip->close();
		}
		return ($zipFilename);
	}
	
	/*
	* Extraction des noms des polices de fonts.json vers self::$fonts
	*/
	private function extract( $file) {
		$fonts = [];
		if (file_exists($file)){
			$json = file_get_contents($file);
			$fonts1 = json_decode($json, true);
			$fonts2 = $fonts1['fonts'];
			foreach ($fonts2 as $key=>$value){
				$fonts[$key] = $value['name'];
			}
			return $fonts;
		}
	}
	
	/*
	* Calcul de swiperContent utilisé par site() ou par header()
	*/
	private function swiperContent( $source ) {
		if( $source === 'site' ){
			$dir = $this->getData(['theme', 'header', 'swiperImagesDir' ]);
			$effect = $this->getData(['theme', 'header', 'swiperEffects']);
			$direction = $this->getData(['theme', 'header', 'swiperDirection']);
			$time = $this->getData(['theme', 'header', 'swiperTime']);
			$transition = $this->getData(['theme', 'header', 'swiperTransition']);
		}
		else {
			$dir = self::$listDirs[$this->getInput('themeHeaderDirectory')];
			$effect = $this->getInput('themeHeaderSwiperEffects');
			$direction = $this->getInput('themeHeaderSwiperDirection');
			$time = $this->getInput('themeHeaderSwiperTime');
			$transition = $this->getInput('themeHeaderSwiperTransition');	
		}
		// Extraction des images du dossier choisi
		$iterator = new DirectoryIterator('./'.$dir);
		$imageFile = [];
		foreach($iterator as $key=>$fileInfos) {
		  if($fileInfos->isDot() === false AND $fileInfos->isFile() AND @getimagesize($fileInfos->getPathname())) {
			$imageFile[$key] = $fileInfos->getPathname();
		  }
		}
		sort($imageFile);
		// Préparation du contenu
		$swiperContent = '';
		// Adaptation du css au client pour l'option de défilement vertical
		if(  $effect === 'vertical'){
			$size = getimagesize($imageFile[0]);
			$heightMod = 0;	
			if( isset( $_COOKIE["DELTA_COOKIE_INNERWIDTH"] ) ){
				$wclient = $_COOKIE["DELTA_COOKIE_INNERWIDTH"];
			} else {
				$wclient = 1500;
			}
			$widthMod = $wclient;
			if( $this->getData(['theme', 'site', 'width' ]) !== '100%' && ( ( $this->getData(['theme', 'header', 'wide' ]) === 'container' && $this->getData(['theme', 'header', 'position' ]) === 'body')
						|| $this->getData(['theme', 'header', 'position' ]) === 'site' ) ){
				switch ( $this->getData(['theme', 'site', 'width' ]) )
				{
					case "75vw":
					$widthMod = 0.75 * $wclient;
					break;
					case "85vw":
					$widthMod  = 0.85 * $wclient;
					break;
					case "95vw":
					$widthMod  = 0.95 * $wclient;
					break;
					default:
					$widthMod  = $wclient;
				}
				$heightMod = $size[1] * ( $widthMod / $size[0]);
				if( $widthMod < 10 || $heightMod <10 ){ $widthMod=10; $heightMod=10;}
				$swiperContent .= '<div id="headerSwiper"><div class="swiper mySwiper" style="width: '. (int)$widthMod . 'px; height:'.(int)$heightMod.'px"><div class="swiper-wrapper">';			
			} else {		
				$heightMod = $size[1] * ( $wclient / $size[0]);
				if( $heightMod <10 ){ $heightMod=10;}
				$swiperContent .= '<div id="headerSwiper"><div class="swiper mySwiper" style="width: 100%; height:'.(int)$heightMod.'px"><div class="swiper-wrapper">';
			}
		} else {
				$swiperContent .= '<div id="headerSwiper"><div class="swiper mySwiper"><div class="swiper-wrapper">';
		}
		foreach($imageFile as $value ) {
			$swiperContent .= '<div class="swiper-slide"><img src="'.$value.'" ></div>';
		}
		$swiperContent .= '</div></div></div>';
		$swiperContent .= '<script> var swiperBanner = new Swiper(".mySwiper", { ';
		// Effets retenus fade, cube, sans effet avec défilement H ou V 
		$reverse ='false';
		switch ($effect) {
			case 'fade':
				$swiperContent .= 'effect: "fade",';
				break;
			case 'cube':
				$swiperContent .= 'effect: "cube",';
				break;
			case 'vertical':
				$swiperContent .= 'direction: "vertical",';
			break;
			case 'none':
			break;
		}	
		$reverse ='false';
		if( $direction === '1') $reverse = 'true';				
		$swiperContent .= 'loop: true,';
		$swiperContent .= 'autoplay: {delay: '. $time .', reverseDirection: '.$reverse.', },';
		$swiperContent .= 'speed: '. $transition .', });';
		$swiperContent .= '</script>';
		if( $source === 'site' ){
			$this->setData(['theme', 'header', 'swiperContent', $swiperContent ]);
		} else {
			return $swiperContent;
		}
	}

}
