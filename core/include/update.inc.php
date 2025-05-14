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
	$this->setDataAllLocale(['locale', 'captchaSimpleText', 'Je ne suis pas un robot' ]);
	$this->setDataAllLocale(['locale', 'captchaSimpleHelp', 'Cochez cette case pour prouver que vous n\'êtes pas un robot' ]);
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
	$this->setDataAllLocale(['locale', 'visitorLabel', $groupWhoIs[0] ]);
	$this->setDataAllLocale(['locale', 'memberLabel', $groupWhoIs[1] ]);
	$this->setDataAllLocale(['locale', 'editorLabel', $groupWhoIs[2] ]);
	$this->setDataAllLocale(['locale', 'moderatorLabel', $groupWhoIs[3] ]);
	$this->setDataAllLocale(['locale', 'administratorLabel', $groupWhoIs[4] ]);
	if( is_file('./site/data/body.inc.html')) rename('./site/data/body.inc.html', './site/data/body.inc.php' );
	if( is_file('./site/data/head.inc.html')) rename('./site/data/head.inc.html', './site/data/head.inc.php' );
	$this->setData(['core', 'dataVersion', 4501]);
}
if ($this->getData(['core', 'dataVersion']) < 4502) {
	// Déplacement et renommage des variables Burger Icon Link
	$this->setDataAllLocale(['locale', 'menuBurger', [
		'burgerLeftIconLink' => $this->getData(['theme', 'menu','burgerIconLink1']) ,
		'burgerCenterIconLink' => $this->getData(['theme', 'menu','burgerIconLink2'])
	]]);
	$this->deleteData(['theme', 'menu', 'burgerIconLink1']);
	$this->deleteData(['theme', 'menu', 'burgerIconLink2']);
	$this->setData(['core', 'dataVersion', 4502]);
}
if ($this->getData(['core', 'dataVersion']) < 5001) {
	$this->setData([ 'config', 'social', 'comment',	'group', '']);
	$this->setData([ 'config', 'social', 'comment',	'user', '']);
	$this->setData([ 'config', 'social', 'comment',	'subject', '']);
	$this->setData([ 'config', 'social', 'comment',	'captcha', true]);
	$this->setData([ 'config', 'social', 'comment',	'nbItemPage', '3']);
	copy ('core/module/install/ressource/database_fr/base/comment.json', self::DATA_DIR . 'base' . '/comment.json');
	$this->setDataAllLocale(['locale', 'pageComment', 'writeComment', 'Ecrire un commentaire']);
	$this->setDataAllLocale(['locale', 'pageComment', 'commentName', 'Nom ou pseudo']);
	$this->setDataAllLocale(['locale', 'pageComment', 'comment', 'Commentaire']);
	$this->setDataAllLocale(['locale', 'pageComment', 'submit', 'Envoyer']);
	$this->setDataAllLocale(['locale', 'pageComment', 'link', ', le']);
	$this->setDataAllLocale(['locale', 'pageComment', 'page', 'Page']);
	foreach( $this->getData(['config', 'i18n']) as $key => $value){
		if( $value === 'site') copy ('core/module/install/ressource/database_fr/base/comment.json', self::DATA_DIR . $key . '/comment.json');
	}
	$this->setData(['core', 'dataVersion', 5001]);
}
if ($this->getData(['core', 'dataVersion']) < 5002) {
	// Nouveau dossier site/data/.../data_module
	// Tableau des langues installées sauf base
	$tabLanguages = [];
	foreach (self::$i18nList as $key => $value) {
		if ($this->getData(['config','i18n', $key]) === 'site' && $key !== $this->getData(['config','i18n', 'langBase'])) {
			$tabLanguages[$key] = $value;
		}
	}
	if( !is_dir(self::DATA_DIR .'base/data_module')) mkdir (self::DATA_DIR .'base/data_module', 0755);
	foreach( $tabLanguages as $key => $value){
		if( !is_dir(self::DATA_DIR .$key.'/data_module')) mkdir (self::DATA_DIR .$key.'/data_module', 0755);
	}
	$this->setData(['core', 'dataVersion', 5002]);
}
if ($this->getData(['core', 'dataVersion']) < 5003) {
	// Label initial de la checkbox rgpdCheck
	$param='';
	include('./core/module/config/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_config.php');
	$this->setDataAllLocale(['locale', 'questionnaireAccept', $text['core_config_view']['locale'][62]]);
	$this->setData(['core', 'dataVersion', 5003]);
}
if ($this->getData(['core', 'dataVersion']) < 5101) {
	// Inversion des couleurs et augmentation des caractères non sélectionnées
	$this->setData(['theme', 'menu', 'invertColor', false ]);
	$this->setData(['theme', 'menu', 'changeFontSize', false ]);
	$this->setData(['core', 'dataVersion', 5101]);
}
if ($this->getData(['core', 'dataVersion']) < 5102) {
	// Nouveaux paramètres dans les pages
	foreach($this->getData(['page']) as $id => $values ) {
		$this->setDataAllPage(['page', $id, 'member', 'allMembers' ]);
		$this->setDataAllPage(['page', $id, 'memberFile', false ]);
	}
	// Ajout de variables locales pour toutes les langues
	$param='';
	include('./core/module/config/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_config.php');
	$this->setDataAllLocale(['locale', 'mandatoryText', $text['core_config_view']['locale'][64] ]);
	$this->setDataAllLocale(['locale', 'impossibleText', $text['core_config_view']['locale'][65] ]);
	$this->setDataAllLocale(['locale', 'pageComment', 'submitted', $text['core_config_view']['locale'][66] ]);
	$this->setDataAllLocale(['locale', 'pageComment', 'failed', $text['core_config_view']['locale'][67] ]);
	$this->setData(['core', 'dataVersion', 5102]);
}
if ($this->getData(['core', 'dataVersion']) < 5201) {
	// Localisation avec ordre de locales : langue Admin puis les 2 autres
	$this->localisation($this->getData(['config', 'i18n', 'langAdmin' ]));
	if( null !== $this->getData(['core', 'localisation']) ){
		setlocale(LC_ALL, $this->getData(['core', 'localisation' ]), 'fr_FR.utf8','fr_Fr', 'french');
	} else {
		setlocale(LC_ALL, null);
	}
	$this->setData(['core', 'dataVersion', 5201]);
}
if ($this->getData(['core', 'dataVersion']) < 5202) {
	// Déplacement du dossier core/vendor/i18n/png
	if(is_dir('./core/vendor/i18n')) $this->copyDir('./core/vendor/i18n', './core/module/translate/ressource/i18n');
	// Suppression du dossier thumb < 5202
	if( is_dir('./site/file/thumb/') ) $this->removeDir('./site/file/thumb/');
	$this->setData(['core', 'dataVersion', 5202]);
}
if ($this->getData(['core', 'dataVersion']) < 5301) {
	$this->setData(['core', 'dataVersion', 5301]);
}
if ($this->getData(['core', 'dataVersion']) < 5401) {
	// Déplacement du paramétrage du scroll auto
	$this->setData(['theme', 'site', 'ScrollUaDbackgroundColor', $this->getData(['theme', 'body', 'toTopbackgroundColor'])]);
	$this->setData(['theme', 'site', 'scrollUaDColor', $this->getData(['theme', 'body', 'toTopColor'])]);
	$this->deleteData(['theme', 'body', 'toTopbackgroundColor']);
	$this->deleteData(['theme', 'body', 'toTopColor']);
	// Forçage de la mise à jour de theme.css
	if (file_exists(self::DATA_DIR . '/theme.css')) unlink (self::DATA_DIR . '/theme.css');
	// Nouveau paramètre dans config : mesure de confiance
	$this->setData(['config', 'connect', 'trust', false]);
	// Texte initial de l'aide pour le captcha additions
	$param='';
	include('./core/module/config/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_config.php');
	$this->setDataAllLocale(['locale', 'captchaAddition', $text['core_config_view']['locale'][70]]);
	$this->setData(['core', 'dataVersion', 5401]);
}
if ($this->getData(['core', 'dataVersion']) < 5402) {
	$this->setData(['config', 'mailDomainName', '']);
	$this->setData(['core', 'dataVersion', 5402]);
}
?>
