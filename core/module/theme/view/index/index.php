<?php
// Lexique
include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');

echo template::speech($text['core_theme_view']['index'][8]); ?>
<div class="row">
	<div class="col2 offset4">
		<?php echo template::button('themeBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl(false),
			'ico' => 'home',
			'value' => $text['core_theme_view']['index'][1]
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::button('themeHelp', [
			'href' => 'https://doc.deltacms.fr/theme-2',
			'target' => '_blank',
			'ico' => 'help',
			'value' => $text['core_theme_view']['index'][2],
			'class' => 'buttonHelp'
		]); ?>
	</div>
</div>
<div class="row showAll">
	<div class="col2 offset5">
		<?php echo template::button('themeShowAll', [
			'ico' => 'eye',
			'value' => $text['core_theme_view']['index'][3]
		]); ?>
	</div>
</div>
<div class="row">
	<div class="col2  offset3">
		<?php echo template::button('themeManage', [
			'ico' => 'cogs',
			'href' => helper::baseUrl() . $this->getUrl(0) . '/manage',
			'value' => $text['core_theme_view']['index'][4]
		]); ?>
	</div>
	<div class="col2">
	<?php echo template::button('themeAdmin', [
			'ico' => 'brush',
			'href' => helper::baseUrl() . $this->getUrl(0) . '/admin',
			'value' => $text['core_theme_view']['index'][5]
		]); ?>

	</div>
	<div class="col2">
		<?php echo template::button('themeAdvanced', [
			'ico' => 'code',
			'href' => helper::baseUrl() . $this->getUrl(0) . '/advanced',
			'value' => $text['core_theme_view']['index'][6]
		]); ?>
	</div>
</div>
<div class="row">
	<div class="col2  offset5">
		<?php echo template::button('themeFonts', [
			'ico' => 'pencil',
			'href' => helper::baseUrl() . $this->getUrl(0) . '/fonts',
			'value' => $text['core_theme_view']['index'][7]
		]); ?>
	</div>
</div>

