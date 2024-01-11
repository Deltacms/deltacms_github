<?php
/**
 * Mises à jour suivant les versions de DeltaCMS
*/

if ($this->getData(['core', 'dataVersion']) < 3202) {
	//Forcer une mise à jour de admin.css
	$this->setData(['admin', 'maj', true]);
	//Forcer une mise à jour de theme.css
	if (file_exists(self::DATA_DIR . '/theme.css')) unlink (self::DATA_DIR . '/theme.css');
	$this->setData(['core', 'dataVersion', 3202]);
}
if ($this->getData(['core', 'dataVersion']) < 3206) {
	// Mise à jour
	$this->setData(['core', 'dataVersion', 3206]);
}
if ($this->getData(['core', 'dataVersion']) < 4001) {
	$this->setData(['config', 'i18n', 'langAdmin', 'fr']);
	$this->setData(['config', 'i18n', 'langBase', 'fr']);
	// Copie le contenu de site/data/fr vers site/data/base puis supprime site/data/fr
	if( is_dir('./site/data/fr/') ){
		$this->copyDir('./site/data/fr/', './site/data/base/');
		$this->removeDir('./site/data/fr/');
	}
	// Mise à jour
	$this->setData(['core', 'dataVersion', 4001]);
}
if ($this->getData(['core', 'dataVersion']) < 4002) {
	// Validation des statistiques
	$this->setData(['config', 'statistlite', 'enable', false]);	
	// Mise à jour
	$this->setData(['core', 'dataVersion', 4002]);
}

if ($this->getData(['core', 'dataVersion']) < 4101) {
	$this->setData(['config', 'i18n', 'da', 'none']);	
	$this->setData(['config', 'i18n', 'el', 'none']);	
	$this->setData(['config', 'i18n', 'fi', 'none']);
	$this->setData(['config', 'i18n', 'ga', 'none']);
	$this->setData(['config', 'i18n', 'sv', 'none']);	
	$this->setData(['config', 'i18n', 'otherLangBase', '']);	
	// Mise à jour
	$this->setData(['core', 'dataVersion', 4101]);
}

if ($this->getData(['core', 'dataVersion']) < 4104) {
	$this->setData(['config', 'i18n', 'br', 'none']);	
	$this->setData(['config', 'i18n', 'ca', 'none']);	
	$this->setData(['config', 'i18n', 'co', 'none']);
	$this->setData(['config', 'i18n', 'eu', 'none']);
	
	// Mise à jour
	$this->setData(['core', 'dataVersion', 4104]);
}

if ($this->getData(['core', 'dataVersion']) < 4202) {
	$this->setData(['theme', 'menu', 'burgerTextColor', '#DDD']);
	$this->setData(['theme', 'menu', 'burgerFontSize', '1.5em']);
	// Mise à jour
	$this->setData(['core', 'dataVersion', 4202]);
}

if ($this->getData(['core', 'dataVersion']) < 4307) {
	$this->setData(['theme', 'header', 'homePageOnly', false]);
	$this->setData(['theme', 'header', 'heightSelect', $this->getData(['theme', 'header', 'height']) ]);
	// Mise à jour
	$this->setData(['core', 'dataVersion', 4307]);
}

if ($this->getData(['core', 'dataVersion']) < 4308) {
	$this->setData(['config', 'connect', 'captchaBot', true]);
	$this->setData(['locale', 'captchaSimpleText', 'Je ne suis pas un robot' ]);
	$this->setData(['locale', 'captchaSimpleHelp', 'Cochez cette case pour prouver que vous n\'êtes pas un robot' ]);
	$this->deleteData([ 'config', 'connect', 'captchaStrong' ]);
	$this->deleteData([ 'config', 'connect', 'captchaType' ]);
	// Mise à jour
	$this->setData(['core', 'dataVersion', 4308]);
}

if ($this->getData(['core', 'dataVersion']) < 4401) {
	$userIdsFirstnames = helper::arrayCollumn($this->getData(['user']), 'firstname');
	foreach($userIdsFirstnames as $userId => $userFirstname) {
		if ($this->getData(['user', $userId, 'group']) >= 2) {
			$this->setData(['user', $userId, 'group', $this->getData(['user', $userId, 'group']) +1 ]);
		}
	}
	$this->setData(['theme', 'menu', 'minWidthTab', 'auto']);
	$this->setData(['theme', 'menu', 'minWidthParentOrAll', true]);
	$this->setData(['theme', 'update', false]);
	// Mise à jour
	$this->setData(['core', 'dataVersion', 4401]);
}

if ($this->getData(['core', 'dataVersion']) < 4403) {
	$this->setData(['theme', 'header', 'swiperImagesDir', '']);
	$this->setData(['theme', 'header', 'swiperContent', '']);
	$this->setData(['theme', 'header', 'swiperEffects', 'fade']);
	$this->setData(['theme', 'header', 'swiperDirection', false]);
	$this->setData(['theme', 'header', 'swiperTime', '2000']);
	$this->setData(['theme', 'header', 'swiperTransition', '1000']);
	$this->setData(['config', 'connect', 'passwordVisibility', false]);
	if( $this->getData(['theme', 'footer', 'copyrightPosition']) === 'center') $this->setData(['theme', 'footer', 'copyrightPosition', 'mcenter']);
	if( $this->getData(['theme', 'footer', 'textPosition']) === 'center') $this->setData(['theme', 'footer', 'textPosition', 'mcenter']);
	if( $this->getData(['theme', 'footer', 'socialsPosition']) === 'center') $this->setData(['theme', 'footer', 'socialsPosition', 'mcenter']);
	// Mise à jour
	$this->setData(['core', 'dataVersion', 4403]);
}
if ($this->getData(['core', 'dataVersion']) < 4404) {
	if( $this->getData(['theme', 'site', 'width']) === '750px') $this->setData(['theme', 'site', 'width', '75vw']);
	if( $this->getData(['theme', 'site', 'width']) === '960px') $this->setData(['theme', 'site', 'width', '85vw']);
	if( $this->getData(['theme', 'site', 'width']) === '1170px') $this->setData(['theme', 'site', 'width', '95vw']);
	// Mise à jour
	$this->setData(['core', 'dataVersion', 4404]);
}
if ($this->getData(['core', 'dataVersion']) < 4406) {
	if( ! file_exists(self::DATA_DIR . 'session.json'))	file_put_contents(self::DATA_DIR . 'session.json', '{}');
	$this->setData(['theme', 'footer', 'displayWhois', false]);
	$this->setData(['theme', 'menu', 'widthLogo', '30px' ]);
	$this->setData(['theme', 'menu', 'heightLogo', 'auto' ]);
	// Mise à jour
	$this->setData(['core', 'dataVersion', 4406]);
}
if ($this->getData(['core', 'dataVersion']) < 4407) {
	// Mise à jour
	$this->setData(['core', 'dataVersion', 4407]);
}
if ($this->getData(['core', 'dataVersion']) < 4501) {	
	// Mise à jour
	if( $this->getData(['theme', 'menu', 'burgerContent' ]) === 'logo') $this->setData(['theme', 'menu', 'burgerContent', 'oneIcon' ]);
	$this->setData(['theme', 'menu', 'burgerFixed', $this->getData(['theme', 'menu', 'fixed' ]) ]);
	$this->setData(['theme', 'menu', 'burgerBannerColor', $this->getData(['theme', 'menu', 'backgroundColor' ]) ]);
	$this->setData(['theme', 'menu', 'burgerIconBgColor', $this->getData(['theme', 'menu', 'backgroundColor' ]) ]);
	$this->setData(['theme', 'menu', 'burgerIconColor', $this->getData(['theme', 'menu', 'textColor' ]) ]);
	$this->setData(['theme', 'menu', 'burgerTextMenuColor', $this->getData(['theme', 'menu', 'textColor' ]) ]);
	$this->setData(['theme', 'menu', 'burgerActiveTextColor', $this->getData(['theme', 'menu', 'activeTextColor' ]) ]);
	$this->setData(['theme', 'menu', 'burgerBackgroundColor', $this->getData(['theme', 'menu', 'backgroundColor' ]) ]);
	$this->setData(['theme', 'menu', 'burgerBackgroundColorSub', $this->getData(['theme', 'menu', 'backgroundColorSub' ]) ]);
	$this->setData(['theme', 'menu', 'burgerActiveColorAuto', $this->getData(['theme', 'menu', 'activeColorAuto' ]) ]);
	$this->setData(['theme', 'menu', 'burgerActiveColor', $this->getData(['theme', 'menu', 'activeColor' ]) ]);
	$this->setData(['theme', 'menu', 'burgerIconLink1', '' ]);
	$this->setData(['theme', 'menu', 'burgerIconLink2', '' ]);
	$this->setData(['theme', 'menu', 'burgerIcon1', $this->getData(['theme', 'menu','burgerLogo']) ]);
	$this->setData(['theme', 'menu', 'burgerIcon2', '' ]);
	$this->setData(['theme', 'menu', 'burgerOverlay', false ]);
	$this->deleteData(['theme', 'menu', 'burgerLogo']);
	$this->deleteData(['theme', 'menu', 'heightLogo']);
	$this->deleteData(['theme', 'menu', 'widthLogo']);
	$this->setData([ 'theme', 'update', true]);
	$this->setData(['config', 'i18n', 'scriptGoogle', false]);
	$this->setData(['config', 'i18n', 'showCredits', false]);
	$this->setData(['config', 'i18n', 'autoDetect', false]);
	switch ( $this->getData(['config', 'i18n', 'langAdmin']) ){
		case 'fr':
			$groupWhoIs = [ 0=>'Visiteur', 1=>'Membre', 2=>'Editeur', 3=>'Modérateur', 4=>'Administrateur' ];
		break;
		case 'en':
			$groupWhoIs = [ 0=>'Visitor', 1=>'Member', 2=>'Editor', 3=>'Moderator', 4=>'Administrator' ];
		break;
		case 'es':
			$groupWhoIs = [ 0=>'Visitante', 1=>'Miembro', 2=>'Editor', 3=>'Moderador', 4=>'Administrador' ];
		break;
	}
	$this->setData(['locale', 'visitorLabel', $groupWhoIs[0] ]);
	$this->setData(['locale', 'memberLabel', $groupWhoIs[1] ]);
	$this->setData(['locale', 'editorLabel', $groupWhoIs[2] ]);
	$this->setData(['locale', 'moderatorLabel', $groupWhoIs[3] ]);
	$this->setData(['locale', 'administratorLabel', $groupWhoIs[4] ]);
	if( is_file('./site/data/body.inc.html')) rename('./site/data/body.inc.html', './site/data/body.inc.php' );
	if( is_file('./site/data/head.inc.html')) rename('./site/data/head.inc.html', './site/data/head.inc.php' );
	$this->setData(['core', 'dataVersion', 4501]);
}
if ($this->getData(['core', 'dataVersion']) < 4502) {
	// Déplacement et renommage des variables Burger Icon Link
	$this->setData(['locale', 'menuBurger', [
		'burgerLeftIconLink' => $this->getData(['theme', 'menu','burgerIconLink1']) ,
		'burgerCenterIconLink' => $this->getData(['theme', 'menu','burgerIconLink2'])
	]]);
	$this->deleteData(['theme', 'menu', 'burgerIconLink1']);
	$this->deleteData(['theme', 'menu', 'burgerIconLink2']);
	$this->setData(['core', 'dataVersion', 4502]);
}
if ($this->getData(['core', 'dataVersion']) < 4504) {
	$this->setData(['core', 'dataVersion', 4504]);
}
?>
