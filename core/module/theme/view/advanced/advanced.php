<?php
// Lexique
include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');

echo template::formOpen('themeAdvancedForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('themeAdvancedBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'theme',
				'ico' => 'left',
				'value' => $text['core_theme_view']['advanced'][0]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('themeSiteHelp', [
				'href' => 'https://doc.deltacms.fr/editeur-css',
				'target' => '_blank',
				'ico' => 'help',
				'value' => $text['core_theme_view']['advanced'][1],
				'class' => 'buttonHelp'
			]); ?>
		</div>
		<div class="col2 offset4">
			<?php echo template::button('themeAdvancedReset', [
				'href' => helper::baseUrl() . 'theme/reset/custom' . '&csrf=' . $_SESSION['csrf'],
				'class' => 'buttonRed',
				'ico' => 'cancel',
				'value' => $text['core_theme_view']['advanced'][2]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('themeAdvancedSubmit',[
				'value' => $text['core_theme_view']['advanced'][3]
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<?php echo template::textarea('themeAdvancedCss', [
				'value' => file_get_contents(self::DATA_DIR.'custom.css'),
				'class' => 'editor'
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col2">
			<?php echo template::text('themeAdvancedColorPicker', [
				'class' => 'colorPicker',
				'label' => $text['core_theme_view']['advanced'][5],
				'value' => 'rgba(245,245,245,1)'
			]); ?>		
		</div>
	</div>
<?php echo template::formClose(); ?>
<script>
	var textConfirm = <?php echo '"'.$text['core_theme_view']['advanced'][4].'"'; ?>;
</script>