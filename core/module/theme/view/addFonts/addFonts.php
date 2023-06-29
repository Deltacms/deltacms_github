<?php
// Lexique
include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');

echo template::formOpen('themeAddFonts'); ?>
<div class="row">
	<div class="col2">
		<?php echo template::button('themeFontsBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . 'theme/fonts',
			'ico' => 'left',
			'value' => $text['core_theme_view']['addFonts'][0]
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::button('themeSiteHelp', [
			'href' => 'https://doc.deltacms.fr/polices',
			'target' => '_blank',
			'ico' => 'help',
			'value' => $text['core_theme_view']['addFonts'][1],
			'class' => 'buttonHelp'
		]); ?>
	</div>
	<div class="col2 offset6">
		<?php echo template::submit('addFontSubmit',[
			'value' => $text['core_theme_view']['addFonts'][2]
		]); ?>
	</div>
</div>

<div class="block">
	<div class="blockTitle"><?php echo $text['core_theme_view']['addFonts'][3]; ?></div>
	<div class="row">
		<div class="col4">
			<?php echo template::text('nameAddFont', [
			'autocomplete' => 'off',
			'label' => $text['core_theme_view']['addFonts'][4],
			'help' => $text['core_theme_view']['addFonts'][5]
		]); ?>
		</div>
		<div class="col4">
		<?php echo template::select('typeAddFont', $typeAddFont, [
			'label' => $text['core_theme_view']['addFonts'][6],
			'selected' => 'file',
			'help' => $text['core_theme_view']['addFonts'][7]
		]); ?>
		</div>
		<div class="col4">
			<!-- Sélection d'un fichier font -->
			<?php echo template::select('fileAddFont', $module::$fontFiles, [
				'help' => $text['core_theme_view']['addFonts'][8],
				'label' => $text['core_theme_view']['addFonts'][9]
			]); ?>
		</div>
	</div>
	<div class="row">

		<div class="col4">
		<?php echo template::text('licenseAddFont', [
			'autocomplete' => 'off',
			'label' => $text['core_theme_view']['addFonts'][10],
			'help' => $text['core_theme_view']['addFonts'][11]
		]); ?>
		</div>
	</div>
</div>
<?php echo template::formClose(); ?>
<script>
	var textConfirm = <?php echo '"'.$text['core_theme_view']['addFonts'][12].'"'; ?>;
</script>
