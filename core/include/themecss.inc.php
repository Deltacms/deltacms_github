<?php 
/* 
* Modification des fichiers de thème theme.css, theme.json et theme_invert.css
*/
// Version
$css = '/*' . md5(json_encode($this->getData(['theme']))) . '*/';
// Déclaration des polices
$tab=[];
$tab[0] = $this->getData(['theme', 'text', 'font']);
$tab[1] = $this->getData(['theme', 'title', 'font']);
$tab[2] = $this->getData(['theme', 'menu', 'font']);
$tab[3] = $this->getData(['theme', 'header', 'font']);
$tab[4] = $this->getData(['theme', 'footer', 'font']);
// Suppression des doubons
$tab = array_unique($tab);
foreach( $tab as $key=>$value){
	if( $this->getData(['fonts', $value, 'type' ]) === 'file'){
		$file = $this->getData(['fonts', $value, 'file' ]);
		$format ='';
		switch (pathinfo($file, PATHINFO_EXTENSION)){
			case 'woff':
				$format = 'woff';
				break;
			case 'woff2':
				$format = 'woff2';
				break;
		}
		$css .= '@font-face{ font-family: "'. $this->getData(['fonts', $value, 'name' ]) .'"; src: url("../file/source/fonts/' . $file;
		$css .= '") format("'. $format . '");  font-weight: normal;  font-style: normal;}';
		$css .= ' ';
	}

}
// Fond du body
$colors = helper::colorVariants($this->getData(['theme', 'body', 'backgroundColor']));
// Body
$css .= 'body{font-family:"' . $this->getData(['fonts', $this->getData(['theme', 'text', 'font']), 'name']) . '",sans-serif}';
if($themeBodyImage = $this->getData(['theme', 'body', 'image'])) {
	// Image dans html pour éviter les déformations.
	$css .= 'html {background-image:url("../file/source/' . $themeBodyImage . '");background-position:' . $this->getData(['theme', 'body', 'imagePosition']) . ';background-attachment:' . $this->getData(['theme', 'body', 'imageAttachment']) . ';background-size:' . $this->getData(['theme', 'body', 'imageSize']) . ';background-repeat:' . $this->getData(['theme', 'body', 'imageRepeat']) . '}';
	// Couleur du body transparente
	$css .= 'body {background-color: rgba(0,0,0,0)}';
} else {
	// Pas d'image couleur du body
	$css .= 'html {background-color:' . $colors['normal'] . ';}';
	// Même couleur dans le fond de l'éditeur
	//$css .= '{background-color:' . $colors['normal'] . ' !important}';
}
// Icône ScrollUaD
$css .= '#scrollUaD {background-color:' .$this->getData(['theme', 'site', 'ScrollUaDbackgroundColor']). ';color:'.$this->getData(['theme', 'site', 'scrollUaDColor']).';}';
// Site
$colors = helper::colorVariants($this->getData(['theme', 'text', 'linkColor']));
$css .= 'a{color:' . $colors['normal'] . '}';
// Couleurs de site dans TinyMCe
$css .= 'div.mce-edit-area {font-family:"' . $this->getData(['fonts', $this->getData(['theme', 'text', 'font']), 'name']) . '",sans-serif}';
// Site dans TinyMCE pour la class ajoutée par init.js dans l'iframe
$css .= '.editorWysiwyg {background-color:' . $this->getData(['theme', 'site', 'backgroundColor']) . '; margin:0 !important; padding-top: 10px;}';
$css .= '.editorWysiwygHeader {background-color:' . $this->getData(['theme', 'header', 'backgroundColor']) . '; color:' . $this->getData(['theme', 'header', 'textColor']) . '; margin:0 !important; padding-top: 10px;}';
$css .= 'span.mce-text{background-color: unset !important;}';
//$css .= 'a:hover:not(.inputFile, button){color:' . $colors['darken'] . '}';
$css .= 'body,.row > div{font-size:' . $this->getData(['theme', 'text', 'fontSize']) . '}';
$css .= 'body{color:' . $this->getData(['theme', 'text', 'textColor']) . '}';
$css .= 'select,input[type=\'password\'],input[type=\'email\'],input[type=\'text\'],.inputFile,select,textarea{color:' . $this->getData(['theme', 'text', 'textColor']) .';background-color:'.$this->getData(['theme', 'site', 'backgroundColor']).';border-color:'.$this->getData(['theme', 'block', 'borderColor']).';}';
$css .= 'select:focus-visible,input[type=\'password\']:focus-visible,input[type=\'email\']:focus-visible,input[type=\'text\']:focus-visible,.inputFile:focus-visible,textarea:focus-visible{border-color:'.$this->getData(['theme', 'block', 'borderColor']).';}';
$css .= 'select:hover,input[type=\'password\']:hover,input[type=\'email\']:hover,input[type=\'text\']:hover,.inputFile:hover,textarea:hover{border-color:'.$this->getData(['theme', 'block', 'borderColor']).';}';
// spécifiques au module de blog
$css .= '.blogDate {color:' . $this->getData(['theme', 'text', 'textColor']) . '}';
// Couleur fixée dans admin.css
//$css .= '.button.buttonGrey,.button.buttonGrey:hover{color:' . $this->getData(['theme', 'text', 'textColor']) . '}';
$css .= '.container, .helpDisplayContent{max-width:' . $this->getData(['theme', 'site', 'width']) . '}';
$margin = $this->getData(['theme', 'site', 'margin']) ? '0' : '20px';
// Marge supplémentaire lorsque le pied de page est fixe
if ( $this->getData(['theme', 'footer', 'fixed']) === true &&
$this->getData(['theme', 'footer', 'position']) === 'body') {
	$marginBottomLarge = ((str_replace ('px', '', $this->getData(['theme', 'footer', 'height']) ) * 2 ) + 31 ) . 'px';
	$marginBottomSmall = ((str_replace ('px', '', $this->getData(['theme', 'footer', 'height']) ) * 2 ) + 93 ) . 'px';
} else {
	$marginBottomSmall = $margin;
	$marginBottomLarge = $margin;
}
// Site overflow visible si le menu est dans le site ou avant ou après la bannière dans le site
$overflowSite = 'hidden';
if( $this->getData(['theme', 'menu', 'position'])==='site' || ( $this->getData(['theme', 'header', 'position'])==='site' &&
( $this->getData(['theme', 'menu', 'position'])==='site-first' || $this->getData(['theme', 'menu', 'position'])==='site-second' ))) $overflowSite = 'visible';
$css .= '@media screen and (min-width: 800px) { #site { overflow: '.$overflowSite.'; } }';
$css .= '@media screen and (max-width: 799px) { .container { max-width: 100vw; } }';
$css .= $this->getData(['theme', 'site', 'width']) === '100%'
		? '@media (min-width: 800px) {#site{margin:0 auto ' . $marginBottomLarge . ' 0 !important;}}@media (max-width: 799px) {#site{margin:0 auto ' . $marginBottomSmall . ' 0 !important;}}#site.light{margin:5% auto !important;} body{margin:0 auto !important;}  #bar{margin:0 auto !important;} body > header{margin:0 auto !important;} body > nav {margin: 0 auto !important;} body > footer {margin:0 auto !important;}'
		: '@media (min-width: 800px) {#site{margin: ' . $margin . ' auto ' . $marginBottomLarge .  ' auto !important;}}@media (max-width: 799px) {#site{margin:0 auto ' . $marginBottomSmall .  ' auto !important;}}#site.light{margin: 5% auto !important;} body{margin:0px 10px;}  #bar{margin: 0 -10px;} body > header{margin: 0 -10px;} body > nav {margin: 0 -10px;} body > footer {margin: 0 -10px;} ';
$css .= $this->getData(['theme', 'site', 'width']) === '75vw'
		? '.button, button{font-size:0.8em;}'
		: '';
$css .= '@media (min-width: 800px) { #site{background-color:' . $this->getData(['theme', 'site', 'backgroundColor']) . ';border-radius:' . $this->getData(['theme', 'site', 'radius']) . ';box-shadow:' . $this->getData(['theme', 'site', 'shadow']) . ' #212223;} }';
$css .= '@media (max-width: 799px) { #site{background-color:' . $this->getData(['theme', 'site', 'backgroundColor']) . ';border-radius: 0px; box-shadow: none;} }';
$colors = helper::colorVariants($this->getData(['theme', 'button', 'backgroundColor']));
$css .= '.speechBubble,.button,.button:hover,button[type=\'submit\'],.pagination a,.pagination a:hover,input[type=\'checkbox\']:checked + label:before,input[type=\'radio\']:checked + label:before,.helpContent{background-color:' . $colors['normal'] . ';color:' . $colors['text'] . '}';
$css .= '.helpButton span{color:' . $colors['normal'] . '}';
$css .= '.speechBubble:before{border-color:' . $colors['normal'] . ' transparent transparent transparent}';
$css .= '.button:hover,button[type=\'submit\']:hover,.pagination a:hover,input[type=\'checkbox\']:not(:active):checked:hover + label:before,input[type=\'checkbox\']:active + label:before,input[type=\'radio\']:checked:hover + label:before,input[type=\'radio\']:not(:checked):active + label:before{background-color:' . $colors['darken'] . '}';
$css .= '.helpButton span:hover{color:' . $colors['darken'] . '}';
$css .= '.button:active,button[type=\'submit\']:active,.pagination a:active{background-color:' . $colors['veryDarken'] . '}';
$colors = helper::colorVariants($this->getData(['theme', 'title', 'textColor']));
$css .= 'h1,h2,h3,h4,h5,h6,h1 a,h2 a,h3 a,h4 a,h5 a,h6 a,.blockTitle,.accordion-title{color:' . $colors['normal'] . ';font-family:"' . $this->getData(['fonts', $this->getData(['theme', 'title', 'font']), 'name']) . '",sans-serif;font-weight:' . $this->getData(['theme', 'title', 'fontWeight']) . ';text-transform:' . $this->getData(['theme', 'title', 'textTransform']) . '}';
$css .= 'h1 a:hover,h2 a:hover,h3 a:hover,h4 a:hover,h5 a:hover,h6 a:hover{color:' . $colors['darken'] . '}';
// Les blocs
$colors = helper::colorVariants($this->getData(['theme', 'block', 'backgroundTitleColor']));
$css .= '.block {border: 1px solid ' . $this->getdata(['theme','block','borderColor']) .  ';background-color: ' . $this->getdata(['theme','block','backgroundColor']) .';border-radius: ' . $this->getdata(['theme','block','blockBorderRadius']) . ';box-shadow :' . $this->getdata(['theme','block','blockBorderShadow']) . ' ' . $this->getdata(['theme','block','borderColor']) . ';}';
$css .= '.block > h4, .blockTitle {background-color:'. $colors['normal'] . ';color:' . $colors['text'] .';border-radius: ' . $this->getdata(['theme','block','blockBorderRadius']) . ' ' . $this->getdata(['theme','block','blockBorderRadius']) . ' 0px 0px;}';
//Tinymce option titre sous une image valeurs par défaut modifiables dans custom.css
$css .= 'figure.image { border-color: ' . $this->getdata(['theme','block','borderColor']) . '; background-color: ' . $this->getdata(['theme','block','backgroundColor']).'}';

// Bannière

// Eléments communs
if($this->getData(['theme', 'header', 'margin'])) {
	if($this->getData(['theme', 'menu', 'position']) === 'site-first') {
		$css .= 'header{margin:0 20px}';
	}
	else {
		$css .= 'header{margin:20px 20px 0 20px}';
	}
}
$colors = helper::colorVariants($this->getData(['theme', 'header', 'backgroundColor']));
$css .= 'header{background-color:' . $colors['normal'] . '; color:' . $this->getData(['theme', 'header', 'textColor']) . ';}';
// Calcul de la hauteur du bandeau du menu burger utilisé dans plusieurs cas
$fontsize = (int) str_replace('px', '', $this->getData(['theme', 'text', 'fontSize']));
$height = $this->getData(['theme', 'menu', 'height']);
$pospx = strpos($height, 'px');
$height = (int) substr( $height, 0, $pospx);
$bannerHeight = 2 * $height + 2 * $fontsize;	// 2*height imposé par l'icône burger

// Bannière de type papier peint
if ($this->getData(['theme','header','feature']) === 'wallpaper' ) {
	$css .= 'header #wallPaper{background-size:' . $this->getData(['theme','header','imageContainer']).'}';
	$css .= 'header #wallPaper{background-color:' . $colors['normal'];

	// Valeur de hauteur traditionnelle
	$css .= ';height:' . $this->getData(['theme', 'header', 'height']) . ';line-height:' . $this->getData(['theme', 'header', 'height']) ;

	$css .=  ';text-align:' . $this->getData(['theme', 'header', 'textAlign']) . '}';
	if($themeHeaderImage = $this->getData(['theme', 'header', 'image'])) {
		$css .= 'header #wallPaper{background-image:url("../file/source/' . $themeHeaderImage . '");background-position:' . $this->getData(['theme', 'header', 'imagePosition']) . ';background-repeat:' . $this->getData(['theme', 'header', 'imageRepeat']) . '}';
	}
	$colors = helper::colorVariants($this->getData(['theme', 'header', 'textColor']));
	$css .= 'header #wallPaper span{color:' . $colors['normal'] . ';font-family:"' . $this->getData(['fonts', $this->getData(['theme', 'header', 'font']), 'name']) . '",sans-serif;font-weight:' . $this->getData(['theme', 'header', 'fontWeight']) . ';font-size:' . $this->getData(['theme', 'header', 'fontSize']) . ';text-transform:' . $this->getData(['theme', 'header', 'textTransform']) . '}';
	// En petit écran pour s'adapter à des textes longs
	$search ='em';
	if( $this->getData(['theme', 'header', 'fontSize']) === '2.4vmax' ) $search = 'vmax';
	$titleLineHeight = str_replace(',','.',(str_replace(',','.',str_replace($search,'',$this->getData(['theme', 'header', 'fontSize']))/2)+0.2)).'em';
	//Si menu burger fixe et superposé à la bannière
	if( $this->getData(['theme', 'menu', 'burgerFixed']) && $this->getData(['theme', 'menu', 'burgerOverlay'])) {
		$titleMarginTop = strval($bannerHeight - 5).'px';
	} else {
		$titleMarginTop	= ((int) str_replace('px','', $this->getData(['theme', 'header', 'height'])))/2 - $fontsize * ( str_replace($search,'', $this->getData(['theme', 'header', 'fontSize'])));
		$titleMarginTop = strval((int)$titleMarginTop).'px';
	}
	$css .= '@media (max-width: 799px) { header #themeHeaderTitle{ margin-top:'.$titleMarginTop.'; line-height:'.$titleLineHeight.';}}';
}

// Bannière au contenu personnalisé
if ($this->getData(['theme','header','feature']) === 'feature' ) {
	// Hauteur de la taille du contenu perso
	// $css .= 'header {height:'. $this->getData(['theme', 'header', 'height'])  . '; min-height:' . $this->getData(['theme', 'header', 'height'])  .  ';overflow: hidden;}';
	$css .= 'header {height:'. $this->getData(['theme', 'header', 'height'])  . '; min-height:20px;overflow: hidden;}';
	//$css .= '.bannerDisplay img { width: auto;max-height:' . $this->getData(['theme', 'header', 'height']) . ';}';

}

// Pour le décalage de la bannière ou de la section, en petit écran burger fixe, calcul de la hauteur du bandeau du menu
$css .= '@media (max-width: 799px) {';
$bannerHeight = $bannerHeight + 10;
// Décalage de la bannière en petit écran et burger fixe et bannière visible et non superposée
if( $this->getData(['theme', 'menu', 'position']) !== 'hide' && $this->getData(['theme', 'menu', 'burgerFixed']) === true
	&& $this->getData(['theme', 'header', 'tinyHidden']) === false && $this->getData(['theme', 'menu', 'burgerOverlay']) === false){
	$css .= '#site.container header, header.container { padding-top:'.$bannerHeight.'px;}';
} else {
	$css .= '#site.container header, header.container { padding-top: 0;}';
}
$css .= '}';

// Menu écran large couleurs
$css .= '@media (min-width: 800px) {';
	$colors = helper::colorVariants($this->getData(['theme', 'menu', 'backgroundColor']));
	$css .= 'nav,nav.navMain a{background-color:' . $colors['normal'] . '}';
	$css .= 'nav a,nav #toggle span,nav a:hover{color:' . $this->getData(['theme', 'menu', 'textColor']) . '}';
	$css .= 'nav ul li span{color:' . $this->getData(['theme', 'menu', 'textColor']) .'}';
	$css .= 'nav a:hover{background-color:' . $colors['darken'] . '}';
	$css .= 'nav a.active{color:' . $this->getData(['theme','menu','activeTextColor']) . ';}';
	if ($this->getData(['theme','menu','activeColorAuto']) === true) {
		$css .= 'nav a.active{background-color:' . $colors['veryDarken'] . '}';
	} else {
		$css .= 'nav a.active{background-color:' . $this->getData(['theme','menu','activeColor']) . '}';
	}
	// Sous menu
	$colors = helper::colorVariants($this->getData(['theme', 'menu', 'backgroundColorSub']));
	$css .= 'nav .navSub a{background-color:' . $colors['normal'] . '}';
$css .= '}';

// Menu burger couleurs
// Valeurs par défaut si chargement d'un thème < 4501
if(is_null($this->getData(['theme', 'menu', 'burgerBackgroundColor'])) || $this->getData(['theme', 'menu', 'burgerBackgroundColor']) === '') $this->setData(['theme', 'menu', 'burgerBackgroundColor', $this->getData(['theme', 'menu', 'backgroundColor']) ]);
if(is_null($this->getData(['theme', 'menu', 'burgerBackgroundColorSub'])) || $this->getData(['theme', 'menu', 'burgerBackgroundColorSub']) === '') $this->setData(['theme', 'menu', 'burgerBackgroundColorSub', $this->getData(['theme', 'menu', 'backgroundColorSub']) ]);
$css .= '@media (max-width: 799px) {';
	$colors = helper::colorVariants($this->getData(['theme', 'menu', 'burgerBackgroundColor']));
	$css .= 'nav #toggle { background-color:'.$this->getData(['theme', 'menu', 'burgerBannerColor']).';}';
	$css .= 'nav #toggle span.delta-ico-menu::before, nav #toggle span.delta-ico-cancel::before{ background-color:'.$this->getData(['theme', 'menu', 'burgerIconBgColor']).';}';
	$css .= 'nav #toggle span{color:'.$this->getData(['theme', 'menu', 'burgerIconColor']).';}';
	$css .= 'nav ul li span{color:' . $this->getData(['theme', 'menu', 'burgerTextMenuColor']) .'}';
	$css .= 'nav #menu,nav.navMain a{background-color:' . $colors['normal'] .'}';
	$css .= 'nav #menu a,nav #menu a:hover{color:' . $this->getData(['theme', 'menu', 'burgerTextMenuColor']) . '}';
	$css .= 'nav #menu a:hover{background-color:' . $colors['darken'] . '}';
	$css .= 'nav #menu .active{color:' . $this->getData(['theme', 'menu', 'burgerActiveTextColor']) . ';}';
	// Couleur du body à la couleur de la page
	$css .= 'body {background-color:'.$this->getData(['theme', 'site', 'backgroundColor']).'}';
	if ($this->getData(['theme','menu','burgerActiveColorAuto']) === true) {
		$css .= 'nav #menu .active{background-color:' . $colors['veryDarken'] . '}';
	} else {
		$css .= 'nav #menu .active{background-color:' . $this->getData(['theme','menu','burgerActiveColor']) . '}';
	}
	$css .= 'nav #burgerText{color:' .  $this->getData(['theme','menu','burgerTextColor']) .';font-size:'.$this->getData(['theme','menu','burgerFontSize']) .';}';
	// Sous menu
	$colors = helper::colorVariants($this->getData(['theme', 'menu', 'burgerBackgroundColorSub']));
	$css .= 'nav #menu .navSub a{background-color:' . $colors['normal'] . '}';

	// Décalage de la section en menu burger fixe et non caché et bannière masquée ou cachée
	if( $this->getData(['theme', 'menu', 'position']) !== 'hide' && $this->getData(['theme', 'menu', 'burgerFixed']) === true
		&& ( $this->getData(['theme', 'header', 'tinyHidden']) === true || $this->getData(['theme', 'header', 'position']) === 'hide')){
		$css .= 'section { padding-top:'.$bannerHeight.'px;}';
	} else {
		$css .= 'section { padding-top: 10px;}';
	}
$css .= '}';

// Partie commune aux 2 types d'écran
// Appliquer au menu les réglages de largeur minimale suivant l'option tous ou pages parent uniquement
foreach($this->getHierarchy() as $parentPageId => $childrenPageIds) {
	if( $this->getData(['theme', 'menu', 'minWidthParentOrAll']) === true || $childrenPageIds !== [] ){
		$css .= 'nav li .' . $parentPageId . '{ min-width : '. $this->getData(['theme', 'menu', 'minWidthTab'])  .';}';
	}
}
$css .= 'nav .navMain a.active {border-radius:' . $this->getData(['theme', 'menu', 'radius']) . '}';
$css .= '#menu{text-align:' . $this->getData(['theme', 'menu', 'textAlign']) . '}';
if($this->getData(['theme', 'menu', 'margin'])) {
	if(
		$this->getData(['theme', 'menu', 'position']) === 'site-first'
		OR $this->getData(['theme', 'menu', 'position']) === 'site-second'
	) {
		$css .= 'nav{padding:10px 10px 0 10px;}';
	}
	else {
		$css .= 'nav{padding:0 10px}';
	}
} else {
	$css .= 'nav{margin:0}';
}
if(
	$this->getData(['theme', 'menu', 'position']) === 'top'
	) {
		$css .= 'nav{padding:0 10px;}';
}
$css .= '#toggle span,#menu a{padding:' . $this->getData(['theme', 'menu', 'height']) .';font-family:"' . $this->getData(['fonts', $this->getData(['theme', 'menu', 'font']), 'name']) . '",sans-serif;font-weight:' . $this->getData(['theme', 'menu', 'fontWeight']) . ';font-size:' . $this->getData(['theme', 'menu', 'fontSize']) . ';text-transform:' . $this->getData(['theme', 'menu', 'textTransform']) . '}';

// Pied de page
$colors = helper::colorVariants($this->getData(['theme', 'footer', 'backgroundColor']));
if($this->getData(['theme', 'footer', 'margin'])) {
	$css .= 'footer{padding:0 20px;}';
} else {
	$css .= 'footer{padding:0}';
}

$css .= 'footer span, #footerText > p {color:' . $this->getData(['theme', 'footer', 'textColor']) . ';font-family:"' . $this->getData(['fonts', $this->getData(['theme', 'footer', 'font']), 'name']) . '",sans-serif;font-weight:' . $this->getData(['theme', 'footer', 'fontWeight']) . ';font-size:' . $this->getData(['theme', 'footer', 'fontSize']) . ';text-transform:' . $this->getData(['theme', 'footer', 'textTransform']) . '}';
$css .= 'footer {background-color:' . $colors['normal'] . ';color:' . $this->getData(['theme', 'footer', 'textColor']) . '}';
$css .= 'footer a{color:' . $this->getData(['theme', 'footer', 'textColor']) . '}';
$css .= 'footer #footersite > div {margin:' . $this->getData(['theme', 'footer', 'height']) . ' 0}';

$css .= 'footer #footerbody > div  {margin:' . $this->getData(['theme', 'footer', 'height']) . ' 0}';
$css .= '@media (max-width: 799px) {footer #footerbody > div { padding: 2px }}';
$css .= '#footerSocials{justify-content:' . $this->getData(['theme', 'footer', 'socialsAlign']) . '}';
$css .= '#footerText > p {text-align:' . $this->getData(['theme', 'footer', 'textAlign']) . '}';
$css .= '#footerCopyright{text-align:' . $this->getData(['theme', 'footer', 'copyrightAlign']) . '}';

// Panneau de consentement aux cookies, d'autres paramètres CSS sont gérés dans common.css
$colorRgba = $this->getdata(['theme','block','backgroundColor']);
// Suppression de l'opacité pour le panneau cookies
preg_match( '/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i', $colorRgba, $by_color );
$colorbg = sprintf( '#%02x%02x%02x', $by_color[1], $by_color[2], $by_color[3] );
$css .= '#cookieConsent{ color: '. $this->getData(['theme', 'text', 'textColor']).' ; }';
$css .= '#cookieConsent{border: 1px solid ' . $this->getdata(['theme','block','borderColor']) .  ';background-color: ' . $colorbg .';border-radius: ' . $this->getdata(['theme','block','blockBorderRadius']) . ';box-shadow :' . $this->getdata(['theme','block','blockBorderShadow']) . ' ' . $this->getdata(['theme','block','borderColor']) . ';}';
$colors = helper::colorVariants($this->getData(['theme', 'button', 'backgroundColor']));
$css .= '#cookieConsentConfirm{ background-color: '. $colors['normal'].' ; color: '. $colors['text'] .'; }';

// Enregistre la personnalisation
$this->setData([ 'theme', 'update', false]);
file_put_contents(self::DATA_DIR.'theme.css', $css);

// Thème avec couleurs inversées pour le site
$css_invert = "";
$textColorInvert = helper::invertColor( $this->getData(['theme', 'text', 'textColor']) );
$backgroundColorInvert = helper::invertColor( $this->getData(['theme', 'site', 'backgroundColor'])  );
$backgroundBorderColorInvert = helper::invertColor($this->getData(['theme', 'block', 'borderColor']));

// couleur du texte
$css_invert .= 'body{color:' . $textColorInvert . '}';
$css_invert .= 'select,input[type=\'password\'],input[type=\'email\'],input[type=\'text\'],.inputFile,select,textarea{color:' . $textColorInvert .';background-color:'.$backgroundColorInvert.';border-color:'.$backgroundBorderColorInvert.';}';
$css_invert .= '.blogDate {color:' . $textColorInvert . '}';
//Background
$css_invert .= '.editorWysiwyg {background-color:' . $backgroundColorInvert . '; margin:0 !important; padding-top: 10px;}';
$css_invert .= '@media (min-width: 800px) { #site{background-color:' . $backgroundColorInvert . ';border-radius:' . $this->getData(['theme', 'site', 'radius']) . ';box-shadow:' . $this->getData(['theme', 'site', 'shadow']) . ' #212223;} }';
$css_invert .= '@media (max-width: 799px) { #site{background-color:' . $backgroundColorInvert . ';border-radius: 0px; box-shadow: none;} }';
$css_invert .= '@media (max-width: 799px) { body {background-color:'.$backgroundColorInvert.'}}';
// Icône ScrollUaD
$css_invert .= '#scrollUaD {background-color:' .helper::invertColor($this->getData(['theme', 'site', 'ScrollUaDbackgroundColor'])). ';color:'.helper::invertColor($this->getData(['theme', 'site', 'scrollUaDColor'])).';}';
// Titres
$colors = helper::colorVariants(helper::invertColor($this->getData(['theme', 'title', 'textColor'])));
$css_invert .= 'h1,h2,h3,h4,h5,h6,h1 a,h2 a,h3 a,h4 a,h5 a,h6 a,.blockTitle,.accordion-title{color:' . $colors['normal'] . ';font-family:"' . $this->getData(['fonts', $this->getData(['theme', 'title', 'font']), 'name']) . '",sans-serif;font-weight:' . $this->getData(['theme', 'title', 'fontWeight']) . ';text-transform:' . $this->getData(['theme', 'title', 'textTransform']) . '}';
$css_invert .= 'h1 a:hover,h2 a:hover,h3 a:hover,h4 a:hover,h5 a:hover,h6 a:hover{color:' . $colors['darken'] . '}';
//liens
$colors = helper::colorVariants(helper::invertColor($this->getData(['theme', 'text', 'linkColor'])));
$css_invert .= 'a{color:' . $colors['normal'] . '}';
// blocks
$colors = helper::colorVariants(helper::invertColor($this->getData(['theme', 'block', 'backgroundTitleColor'])));
$css_invert .= '.block {border: 1px solid ' . helper::invertColor($this->getdata(['theme','block','borderColor'])) .  ';background-color: ' . helper::invertColor($this->getdata(['theme','block','backgroundColor'])) .';border-radius: ' . $this->getdata(['theme','block','blockBorderRadius']) . ';box-shadow :' . $this->getdata(['theme','block','blockBorderShadow']) . ' ' . helper::invertColor($this->getdata(['theme','block','borderColor'])) . ';}';
$css_invert .= '.block > h4, .blockTitle {background-color:'. $colors['normal'] . ';color:' . $colors['text'] .';border-radius: ' . $this->getdata(['theme','block','blockBorderRadius']) . ' ' . $this->getdata(['theme','block','blockBorderRadius']) . ' 0px 0px;}';
$css_invert .= 'select:focus-visible,input[type=\'password\']:focus-visible,input[type=\'email\']:focus-visible,input[type=\'text\']:focus-visible,.inputFile:focus-visible,textarea:focus-visible{border-color:'.$backgroundBorderColorInvert.';}';
$css_invert .= 'select:hover,input[type=\'password\']:hover,input[type=\'email\']:hover,input[type=\'text\']:hover,.inputFile:hover,textarea:hover{border-color:'.$backgroundBorderColorInvert.';}';
// boutons
$colors = helper::colorVariants(helper::invertColor($this->getData(['theme', 'button', 'backgroundColor'])));
$css_invert .= '.speechBubble,.button,.button:hover,button[type=\'submit\'],.pagination a,.pagination a:hover,input[type=\'checkbox\']:checked + label:before,input[type=\'radio\']:checked + label:before,.helpContent{background-color:' . $colors['normal'] . ';color:' . $colors['text'] . '}';
$css_invert .= '.helpButton span{color:' . $colors['normal'] . '}';
$css_invert .= '.speechBubble:before{border-color:' . $colors['normal'] . ' transparent transparent transparent}';
$css_invert .= '.button:hover,button[type=\'submit\']:hover,.pagination a:hover,input[type=\'checkbox\']:not(:active):checked:hover + label:before,input[type=\'checkbox\']:active + label:before,input[type=\'radio\']:checked:hover + label:before,input[type=\'radio\']:not(:checked):active + label:before{background-color:' . $colors['darken'] . '}';
$css_invert .= '.helpButton span:hover{color:' . $colors['darken'] . '}';
$css_invert .= '.button:active,button[type=\'submit\']:active,.pagination a:active{background-color:' . $colors['veryDarken'] . '}';
// Figure Image
$css_invert .= 'figure.image { border-color: ' . helper::invertColor($this->getdata(['theme','block','borderColor'])) . '; background-color: ' . helper::invertColor($this->getdata(['theme','block','backgroundColor'])).'}';
// footer
$colors = helper::colorVariants(helper::invertColor($this->getData(['theme', 'footer', 'backgroundColor'])));
$footerColorInvert =  helper::invertColor($this->getData(['theme', 'footer', 'textColor']));
$css_invert .= 'footer span, #footerText > p {color:' . $footerColorInvert . ';font-family:"' . $this->getData(['fonts', $this->getData(['theme', 'footer', 'font']), 'name']) . '",sans-serif;font-weight:' . $this->getData(['theme', 'footer', 'fontWeight']) . ';font-size:' . $this->getData(['theme', 'footer', 'fontSize']) . ';text-transform:' . $this->getData(['theme', 'footer', 'textTransform']) . '}';
$css_invert .= 'footer {background-color:' . $colors['normal'] . ';color:' . $footerColorInvert . '}';
$css_invert .= 'footer a{color:' . $footerColorInvert . '}';

// Enregistre le fichier theme_invert.css
file_put_contents(self::DATA_DIR.'theme_invert.css', $css_invert);

// Effacer le cache pour tenir compte de la couleur de fond TinyMCE
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>