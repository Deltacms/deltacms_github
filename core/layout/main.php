<!DOCTYPE html>
<?php
$lang = $this->getData(['config', 'i18n', 'langBase']);
if( $this->getInput('DELTA_I18N_SITE') !== '' && $this->getInput('DELTA_I18N_SITE') !== null && $this->getInput('DELTA_I18N_SITE') !== 'base') $lang = $this->getInput('DELTA_I18N_SITE');
if( $this->getData(['config', 'social', 'headFacebook' ]) === true) { echo '<html prefix="og: http://ogp.me/ns#" lang="'.$lang.'">'; }
else { echo '<html lang="'.$lang.'">'; }
?>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="generator" content="DeltaCMS <?=common::DELTA_VERSION?>">
        <?php
        $this->showMetaTitle();
        if( $this->getData(['config', 'social', 'headFacebook' ]) === true) $this->showMetaPropertyFacebook();
        ?>
		<base href="<?php echo helper::baseUrl(true); ?>">
		<link rel="stylesheet" href="core/vendor/normalize/normalize.min.css">
		<link rel="stylesheet" href="core/layout/common.css">
		<link rel="stylesheet" href="<?php echo self::DATA_DIR; ?>theme.css">
		<link rel="stylesheet" href="core/layout/mediaqueries.css">
		<?php $this->showStyle();
		$this->showSharedVariables();
		$this->sortVendor();
		$this->showVendor('css'); echo PHP_EOL;?>
		<link rel="stylesheet" href="<?php echo self::DATA_DIR; ?>custom.css">
		<?php
		$this->showFavicon();
		$this->showVendor('jshead');
		// Détection RSS 
		if ( ( $this->getData(['page', $this->getUrl(0), 'moduleId']) === 'blog'
					OR $this->getData(['page', $this->getUrl(0), 'moduleId']) === 'news' )
					AND $this->getData(['module', $this->getUrl(0), 'config', 'feeds']) === TRUE ): ?>
			<link rel="alternate" type="application/rss+xml" href="'<?php echo helper::baseUrl(). $this->getUrl(0) . '/rss';?>" title="fLUX rss">
		<?php endif;
		if (file_exists(self::DATA_DIR .'head.inc.php')) include(self::DATA_DIR .'head.inc.php'); ?>
	</head>
	<body>
		<?php //Barre d'administration
		if($this->getUser('group') > self::GROUP_MEMBER) $this->showBar();

		// Notifications
		$this->showNotification(); 

		// div screenshot
		if( isset($_SESSION['screenshot'] ) && $_SESSION['screenshot'] === 'on' ) { ?> <div id="main_screenshot"> <?php }

		// Menu en dehors du site
		if ( $this->getData(['theme', 'menu', 'position']) === 'top') $this->showMenu( 'top');
		
		//Menu avant la bannière, bannière au dessus du site
		if($this->getData(['theme', 'menu', 'position']) === 'body-first') $this->showMenu( 'body-first'); 

		//Bannière au dessus du site
		if($this->getData(['theme', 'header', 'position']) === 'body') $this->showHeader('body');

		// Menu après la bannière, bannière au dessus du site
		if($this->getData(['theme', 'menu', 'position']) === 'body-second') $this->showMenu( 'body-second');

		// Site ?>
		<div id="site" class="container">
		
		<?php // Menu dans le site avant la bannière
		if($this->getData(['theme', 'menu', 'position']) === 'site-first') $this->showMenu( 'site-first'); 

		// Bannière dans le site
		if( $this->getData(['theme', 'header', 'position']) === 'site'
			OR ( $this->getData(['theme', 'header', 'position']) === 'hide' AND $this->getUrl(0) === 'theme' ) ) 
			$this->showHeader( 'site' );
		
		// Menu après la bannière, bannière dans le site
		if( $this->getData(['theme', 'menu', 'position']) === 'site-second' ) $this->showMenu( 'site-second');
		
		// Menu dans le site, bannière au dessus du site
		if( $this->getData(['theme', 'menu', 'position']) === 'site' ) $this->showMenu( 'site'); 
		
		// Menu caché
		if( $this->getData(['theme', 'menu', 'position']) === 'hide') $this->showMenu( 'hide');

		// Corps de page
		$this->showSection();

		// footer 
		$this->showFooter();

		// Fin du site
		echo $this->getData(['theme', 'footer', 'position']) === 'site'? '</div>' : '';

		// fin de la div main_screenshot et bouton screenshot
		if( isset($_SESSION['screenshot'] ) && $_SESSION['screenshot'] === 'on' ){ 	?>	</div><div><button id="screenshot" class="buttonScreenshot" type="button" >
		<img src="<?php echo helper::baseUrl(false); ?>core/vendor/screenshot/appareil_photo.png" width="100px"></button></div> <?php }

		// Lien remonter en haut ?>
		<div id="backToTop"><?php echo template::ico('up'); ?></div>
		
		<?php // Affichage du consentement aux cookies
		$this->showCookies();
		
		// Les scripts
		$this->showVendor('jsbody');
		$this->showScript();?>
	</body>
</html>
