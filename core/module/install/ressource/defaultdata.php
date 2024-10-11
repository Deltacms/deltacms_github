<?php
class init extends common {
	public static $defaultData = [
		'config' => [
			'analyticsId' => '',
			'autoBackup' => true,
			'autoUpdate' => true,
			'autoUpdateHtaccess' => false,
			'favicon' => 'favicon.ico',
			'faviconDark' => 'faviconDark.ico',
			'maintenance' => false,
			'cookieConsent' => true,
			'social' => [
				'facebookId' => '',
				'instagramId' => '',
				'pinterestId' => '',
				'twitterId' => '',
				'youtubeId' => '',
				'youtubeUserId' => '',
				'githubId' => '',
				'comment' => [
					'group' => '',
					'user' => '',
					'subject' => '',
					'captcha' => true,
					'nbItemPage' => '3'					
				]
			],
			'timezone' => 'Europe/Paris',
			'proxyUrl' => '',
			'proxyPort' => '',
			'proxyType' => 'tcp://',
			'smtp' => [
				'enable' => false,
			],
			'statislite' => [
				'enable' => false,
			],
			'seo' => [
				'robots' => true
			],
			'connect' => [
				'timeout' => 600,
				'attempt' => 3,
				'log' => false,
				'anonymousIp' => 2,
				'captcha' => true,
				'captchaBot' => true,
				'passwordVisibility' => false
			],
			'i18n' => [
				'enable'=> true,
				'scriptGoogle'=> false,
				'showCredits'=> false,
				'autoDetect'=> false,
				'admin'=> false,
				'langAdmin'=> 'fr',
				'langBase'=> 'fr',
				'otherLangBase'=> '',
				'fr'=> 'none',
				'de'=> 'none',
				'en'=> 'none',
				'es'=> 'none',
				'it'=> 'none',
				'nl'=> 'none',
				'pt'=> 'none',
				'el'=> 'none',
				'da'=> 'none',
				'ga'=> 'none',
				'fi'=> 'none',
				'sv'=> 'none',
				'eu'=> 'none',
				'br'=> 'none',
				'ca'=> 'none',
				'co'=> 'none'
			]
		],
		'core' => [
			'dataVersion' => 5102,
			'lastBackup' => 0,
			'lastClearTmp' => 0,
			'lastAutoUpdate' => 0,
			'updateAvailable' => false,
			'baseUrl' => ''
		],
		'locale' => [
			'homePageId' => 'accueil',
			'page302' => 'none',
			'page403' => 'none',
			'page404' => 'none',
			'legalPageId' => 'none',
			'searchPageId' => 'none',
			'searchPageLabel' => 'Rechercher',
			'sitemapPageLabel' => 'Plan du site',
			'legalPageLabel' => 'Mentions légales',
			'visitorLabel' => 'Visiteur',
			'memberLabel' => 'Membre',
			'editorLabel' => 'Editeur',
			'moderatorLabel' => 'Modérateur',
			'administratorLabel' => 'Administrateur',
			'metaDescription' => 'DeltaCMS est un CMS sans base de données qui permet de créer et gérer facilement un site web sans aucune connaissance en programmation.',
			'title' => 'DeltaCMS',
			'captchaSimpleText' => 'Je suis un humain',
			'captchaSimpleHelp' => 'Cochez cette case pour prouver que vous êtes humain',
			'questionnaireAccept' => 'J\'accepte les conditions d\'utilisation de mes données personnelles',
			'cookies' => [
				'cookiesDeltaText' => 'Ce site utilise des cookies nécessaires à son fonctionnement, ils permettent de fluidifier son fonctionnement par exemple en mémorisant les données de connexion, la langue que vous avez choisie ou la validation de ce message.',
				'cookiesExtText' => '',
				'cookiesTitleText' => 'Gérer les cookies',
				'cookiesLinkMlText' => 'Consulter  les mentions légales',
				'cookiesCheckboxExtText' => '',
				'cookiesFooterText' => 'Cookies',
				'cookiesButtonText' => 'J\'ai compris'
			],
			'pageComment' => [
				'writeComment' => 'Ecrire un commentaire',
				'commentName' => 'Nom ou pseudo',
				'comment' => 'Commentaire',
				'submit' => 'Envoyer',
				'link' => ', le',
				'page' => 'Page',
				'submitted' => 'Commentaire soumis',
				'failed' => 'Echec d\'envoi du commentaire'
			],
			'menuBurger' => [
            'burgerLeftIconLink' => 'accueil',
            'burgerCenterIconLink' => 'recherche'
			],
			'mandatoryText' => 'Obligatoire',
			'impossibleText' => 'Impossible de soumettre le formulaire, car il contient des erreurs'
		],
		'page' => [
			'accueil' => [
			'typeMenu' => 'text',
			'iconUrl' => '',
			'disable' => false,
			'content' => 'accueil.html',
			'hideTitle' => true,
			'homePageId' => true,
			'breadCrumb' => false,
			'metaDescription' => '',
			'metaTitle' => '',
			'moduleId' => '',
			'modulePosition' => 'bottom',
			'parentPageId' => '',
			'position' => 1,
			'group' => self::GROUP_VISITOR,
			'member' => 'allMembers',
			'memberFile' => false,
			'groupEdit' => self::GROUP_EDITOR,
			'targetBlank' => false,
			'title' => 'Accueil',
			'shortTitle' => 'Accueil',
			'block' => '12',
			'barLeft' => '',
			'barRight' => '',
			'displayMenu' => 'none',
			'hideMenuSide' => false,
			'hideMenuChildren' =>false
			]
		],
		'module' => [],
		'comment' => [],
		'fonts'=> [
			'liberation-sans'=> [
				'name'=> 'Liberation Sans',
				'type'=> 'file',
				'file'=> 'liberationsans-rg.woff',
				'link'=> '',
				'license'=> 'SIL Open Font License'
			],
			'roboto'=> [
				'name'=> 'Roboto',
				'type'=> 'file',
				'file'=> 'roboto-regular.woff',
				'link'=> '',
				'license'=> 'Apache 2.0'
			],
			'cooper-hewitt'=> [
				'name'=> 'Cooper Hewitt',
				'type'=> 'file',
				'file'=> 'cooperhewitt-book.woff',
				'link'=> '',
				'license'=> 'SIL Open Font License'
			],
			'linux-biolinum'=> [
				'name'=> 'Linux Biolinum',
				'type'=> 'file',
				'file'=> 'linbiolinum.woff',
				'link'=> '',
				'license'=> 'SIL Open Font License'
			],
			'now-regular'=> [
				'name'=> 'Now Regular',
				'type'=> 'file',
				'file'=> 'now-regular.woff',
				'link'=> '',
				'license'=> 'SIL Open Font License'
			],
			'cousine'=> [
				'name'=> 'Cousine',
				'type'=> 'file',
				'file'=> 'cousine-regular.woff',
				'link'=> '',
				'license'=> 'SIL Open Font License'
			],
			'montserrat'=> [
				'name'=> 'Montserrat',
				'type'=> 'file',
				'file'=> 'montserrat-regular.woff',
				'link'=> '',
				'license'=> 'SIL Open Font License'
			],
			'trabajo'=> [
				'name'=> 'Trabajo',
				'type'=> 'file',
				'file'=> 'trabajo.woff',
				'link'=> '',
				'license'=> 'SIL Open Font License'
			],
			'noto-serif-medium'=> [
				'name'=> 'Noto Serif Medium',
				'type'=> 'file',
				'file'=> 'notoserif-medium.woff',
				'link'=> '',
				'license'=> 'SIL Open Font License'
			],
			'averia'=> [
				'name'=> 'Averia',
				'type'=> 'file',
				'file'=> 'averia.woff',
				'link'=> '',
				'license'=> 'SIL Open Font License'
			],
			'space-text'=> [
				'name'=> 'Space Text',
				'type'=> 'file',
				'file'=> 'spacetext-regular.woff',
				'link'=> '',
				'license'=> 'SIL Open Font License'
			],
			'avrile'=> [
				'name'=> 'Avrile',
				'type'=> 'file',
				'file'=> 'avrilesansui-regular.woff',
				'link'=> '',
				'license'=> 'SIL Open Font License'
			],
			'comic-neue'=> [
				'name'=> 'Comic Neue',
				'type'=> 'file',
				'file'=> 'comicneue-regular.woff',
				'link'=> '',
				'license'=> 'Open Font License'
			],
			'seanslab'=> [
				'name'=> 'SeansLab',
				'type'=> 'file',
				'file'=> 'seanslab-wideregular.woff',
				'link'=> '',
				'license'=> ''
			],
			'lemon'=> [
				'name'=> 'Lemon',
				'type'=> 'file',
				'file'=> 'lemon.woff',
				'link'=> '',
				'license'=> 'Open Font License'
			],
			'funtype'=> [
				'name'=> 'Funtype',
				'type'=> 'file',
				'file'=> 'funtype.woff',
				'link'=> '',
				'license'=> 'OFL'
			],
			'remindsans'=> [
				'name'=> 'RemindSans',
				'type'=> 'file',
				'file'=> 'remindsans-medium.woff',
				'link'=> '',
				'license'=> ''
			],
			'clayborn'=> [
				'name'=> 'Clayborn',
				'type'=> 'file',
				'file'=> 'clayborn.woff',
				'link'=> '',
				'license'=> 'OFL'
			],
			'simply-sans-book'=> [
				'name'=> 'Simply Sans Book',
				'type'=> 'file',
				'file'=> 'simplysans-book.woff',
				'link'=> '',
				'license'=> 'Open File License'
			],
			'heraclito'=> [
				'name'=> 'Heraclito',
				'type'=> 'file',
				'file'=> 'heraclito-regular.woff',
				'link'=> '',
				'license'=> 'Open Font License'
			],
			'open-sauce-sans'=> [
				'name'=> 'Open Sauce Sans',
				'type'=> 'file',
				'file'=> 'opensaucesans-regular.woff',
				'link'=> '',
				'license'=> 'Open Font Style'
			]
		],
		'user' => [],
		'theme' =>  [
			'body' => [
				'backgroundColor' => 'rgba(103, 127, 163, 1)',
				'image' => '',
				'imageAttachment' => 'scroll',
				'imageRepeat' => 'no-repeat',
				'imagePosition' => 'top center',
				'imageSize' => 'auto',
				'toTopbackgroundColor' => 'rgba(33, 34, 35, .8)',
				'toTopColor' => 'rgba(255, 255, 255, 1)'
			],
			'footer' => [
				'backgroundColor' => 'rgba(255, 255, 255, 1)',
				'font' => 'roboto',
				'fontSize' => '1em',
				'fontWeight' => 'normal',
				'height' => '5px',
				'loginLink' => true,
				'margin' => true,
				'position' => 'site',
				'textColor' => 'rgba(33, 34, 35, 1)',
				'copyrightPosition' => 'right',
				'copyrightAlign' => 'right',
				'text' => '<p>Pied de page personnalisé</p>',
				'textPosition' => 'left',
				'textAlign' => 'left',
				'textTransform' => 'none',
				'socialsPosition' => 'mcenter',
				'socialsAlign' => 'center',
				'displayVersion' => true,
				'displaySiteMap' => true,
				'displayCopyright' => false,
				'displayCookie' => true,
				'displayLegal' => false,
				'displaySearch' => false,
				'displayMemberBar' => false,
				'template' => '3'
			],
			'header' => [
				'backgroundColor' => 'rgba(32, 59, 82, 1)',
				'font' => 'liberation-sans',
				'fontSize' => '2em',
				'fontWeight' => 'normal',
				'height' => '200px',
				'heightSelect' => '200px',
				'image' => 'theme/defaut/banniere_1500x200.jpg',
				'imagePosition' => 'center center',
				'imageRepeat' => 'no-repeat',
				'margin' => false,
				'position' => 'site',
				'textAlign' => 'center',
				'textColor' => 'rgba(255, 255, 255, 1)',
				'textHide' => false,
				'textTransform' => 'none',
				'linkHomePage' => true,
				'imageContainer' => 'cover',
				'tinyHidden' => true,
				'feature' => 'wallpaper',
				'featureContent' => '<p>Bannière vide</p>',
				'width' => 'container',
				'homePageOnly' => false,	
				'swiperImagesDir' => '',
				'swiperContent' => '',
				'swiperEffects' => 'fade',
				'swiperDirection' => false,
				'swiperTime' => '2000',
				'swiperTransition' => '1000'
			],
			'menu' => [
				'backgroundColor' => 'rgba(103, 127, 163, 0.85)',
				'backgroundColorSub' => 'rgba(83, 107, 143, 1)',
				'font' => 'roboto',
				'fontSize' => '1.1em',
				'fontWeight' => 'normal',
				'height' => '15px 10px',
				'loginLink' => false,
				'margin' => false,
				'position' => 'top',
				'textAlign' => 'left',
				'textColor' => 'rgba(255, 255, 255, 1)',
				'textTransform' => 'none',
				'fixed' => true,
				'activeColorAuto' => true,
				'activeColor' => 'rgba(255, 255, 255, 1)',
				'activeTextColor' => 'rgba(224, 248, 87, 1)',
				'radius' => '0px',
				'memberBar' => true,
				'width' => 'container',
				'minWidthTab' => 'auto',
				'minWidthParentOrAll' => false,
				'burgerTitle' => false,
				'burgerIcon1' => 'icones/home_orange.png',
				'burgerIcon2' => '',
				'burgerContent' => 'oneIcon',
				'burgerTextColor' => 'rgba(221, 221, 221, 1)',
				'burgerFontSize' => '1.5em',
				'burgerFixed' => true,
				'burgerIconColor' => 'rgba(199, 246, 9, 1)',
				'burgerIconBgColor' => 'rgba(103, 127, 163, 0)',
				'burgerBannerColor' => 'rgba(103, 127, 163, 0)',
				'burgerTextMenuColor' => 'rgba(255, 255, 255, 1)',
				'burgerActiveTextColor' => 'rgba(224, 248, 87, 1)',
				'burgerBackgroundColor' => 'rgba(103, 127, 163, 0.85)',
				'burgerActiveColorAuto' => true,
				'burgerActiveColor' => '',
				'burgerBackgroundColorSub' => 'rgba(83, 107, 143, 1)',
				'burgerIconLink1' => 'accueil',
				'burgerIconLink2' => '',
				'burgerOverlay' => true,
				'invertColor' => false,
				'changeFontSize' => false
				],
			'site' => [
				'backgroundColor' => 'rgba(255, 255, 255, 1)',
				'radius' => '0px',
				'shadow' => '0px 0px 0px',
				'width' => '100%'
			],
			'block' => [
				'backgroundTitleColor' => 'rgba(230, 230, 230, 1)',
				'backgroundColor' => 'rgba(241, 241, 241, 1)',
				'borderColor' => 'rgba(230, 230, 230, 1)',
				'blockBorderRadius' => '5px',
				'blockBorderShadow' => '3px 3px 6px',
			],
			'text' => [
				'font' => 'roboto',
				'fontSize' => '15px',
				'textColor' => 'rgba(33, 34, 35, 1)',
				'linkColor' => 'rgba(74, 105, 189, 1)'
			],
			'title' => [
				'font' => 'liberation-sans',
				'fontWeight' => 'normal',
				'textColor' => 'rgba(74, 105, 189, 1)',
				'textTransform' => 'none'
			],
			'button' => [
				'backgroundColor' => 'rgba(32, 59, 82, 1)'
			],
			'version' => 0,
			'update' => false
		],
		'admin' => [
			'backgroundColor' => 'rgba(255, 255, 255, 1)',
			'fontText' => 'roboto',
			'fontSize' => '13px',
			'fontTitle' => 'liberation-sans',
			'colorText' => 'rgba(33, 34, 35, 1)',
			'colorTitle' => 'rgba(74, 105, 189, 1)',
			'backgroundColorButton' => 'rgba(74, 105, 189, 1)',
			'backgroundColorButtonGrey' => 'rgba(170, 180, 188, 1)',
			'backgroundColorButtonRed' => 'rgba(217, 95, 78, 1)',
			'backgroundColorButtonGreen' => 'rgba(162, 223, 57, 1)',
			'backgroundColorButtonHelp' => 'rgba(255, 153, 0, 1)',
			'backgroundBlockColor' => 'rgba(236, 239, 241, 1)',
			'borderBlockColor' => 'rgba(190, 202, 209, 1)',
			'maj' => true
		],
		'blacklist' => []
    ];


    public static $siteData = [];

	public static $siteContent = [];
}
