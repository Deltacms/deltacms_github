<?php
// Lexique
include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');

echo template::formOpen('themeEditFonts'); ?>
<div class="row">
	<div class="col2">
		<?php echo template::button('themeFontsBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . 'theme/fonts',
			'ico' => 'left',
			'value' => $text['core_theme_view']['editFonts'][0]
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::button('themeSiteHelp', [
			'href' => 'https://doc.deltacms.fr/polices',
			'target' => '_blank',
			'ico' => 'help',
			'value' => $text['core_theme_view']['editFonts'][1],
			'class' => 'buttonHelp'
		]); ?>
	</div>
	<div class="col2 offset6">
		<?php echo template::submit('editFontSubmit',[
			'value' => $text['core_theme_view']['editFonts'][2]
		]); ?>
	</div>
</div>

<div class="block">
	<div class="blockTitle"><?php echo $text['core_theme_view']['editFonts'][3]; ?></div>
	<div class="row">
		<div class="col4">
			<?php echo template::text('nameEditFont', [
			'value' => $this->getData(['fonts', $this->getUrl(2),'name']),
			'label' => $text['core_theme_view']['editFonts'][4],
			'readonly' => true,
			'help' => $text['core_theme_view']['editFonts'][5]
		]); ?>
		</div>
		<div class="col4">
		<?php echo template::select('typeEditFont', $typeAddFont, [
			'label' => $text['core_theme_view']['editFonts'][6],
			'selected' => $this->getData(['fonts', $this->getUrl(2),'type']),
			'help' => $text['core_theme_view']['editFonts'][7]
		]); ?>
		</div>
		<div class="col4">
			<!-- Sélection d'un fichier font -->
			<?php $key = array_search( $this->getData(['fonts', $this->getUrl(2),'file']), $module::$fontFiles);
			echo template::select('fileEditFont', $module::$fontFiles, [
				'selected' => $key,
				'help' => $text['core_theme_view']['editFonts'][8],
				'label' => $text['core_theme_view']['editFonts'][9]
			]); ?>
		</div>
	</div>
	<div class="row">

		<div class="col4">
		<?php echo template::text('licenseEditFont', [
			'value' => $this->getData(['fonts', $this->getUrl(2),'license']),
			'label' => $text['core_theme_view']['editFonts'][10],
			'help' => $text['core_theme_view']['editFonts'][11]
		]); ?>
		</div>
	</div>
</div>
<?php echo template::formClose(); ?>


