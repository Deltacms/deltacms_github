<?php
// Lexique
include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
?>
<div class="row">
	<div class="col2">
		<?php echo template::button('themeFontsBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . 'theme',
			'ico' => 'left',
			'value' => $text['core_theme_view']['fonts'][0]
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::button('themeSiteHelp', [
			'href' => 'https://doc.deltacms.fr/polices',
			'target' => '_blank',
			'ico' => 'help',
			'value' => $text['core_theme_view']['fonts'][1],
			'class' => 'buttonHelp'
		]); ?>
	</div>
	<div class="col2 offset6">
		<?php echo template::button('fontAdd', [
			'href' => helper::baseUrl() . 'theme/addFonts',
			'ico' => 'plus',
			'value' => $text['core_theme_view']['fonts'][2]
		]); ?>
	</div>
</div>

<?php echo template::table([2, 2, 3, 3, 1, 1], $module::$fonts, [$text['core_theme_view']['fonts'][3], $text['core_theme_view']['fonts'][4], $text['core_theme_view']['fonts'][5], $text['core_theme_view']['fonts'][6], '', '']); ?>
<script>
	var textConfirm = <?php echo '"'.$text['core_theme_view']['fonts'][7].'"'; ?>;
</script>
