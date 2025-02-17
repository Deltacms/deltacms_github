<!DOCTYPE html>
<html lang="<?php echo $this->getData(['config', 'i18n', 'langAdmin']);?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
	$this->showMetaTitle();
	?>
	<base href="<?=helper::baseUrl(true)?>">
	<link rel="stylesheet" href="core/vendor/normalize/normalize.min.css">
	<link rel="stylesheet" href="core/layout/common.css">
	<link rel="stylesheet" href="core/layout/mediaqueries.css">
	<link rel="stylesheet" href="core/layout/light.css">
	<link rel="stylesheet" href="<?=self::DATA_DIR?>theme.css">
	<?php $this->showStyle();
	$this->showSharedVariables();
	$this->sortVendor();
	$this->showVendor('css'); ?>
	<link rel="stylesheet" href="<?=self::DATA_DIR?>custom.css">
	<?php
	$this->showFavicon();
	$this->showVendor('jshead');
	?>
</head>
<body>
<?php $this->showNotification(); ?>
<div id="site" class="container light">
	<section><?php $this->showContent(); ?></section>
</div>
<?php $this->showVendor('jsbody'); ?>
<?php $this->showScript(); ?>
</body>
</html>
