<?php
// Lexique
include('./core/module/addon/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_addon.php');
?>
<div class="row">
	<div class="col2">
		<?php echo template::button('configModulesBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl(),
			'ico' => 'left',
			'value' => $text['core_addon_view']['index'][0]
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::button('configModulesHelp', [
			'href' => 'https://doc.deltacms.fr/gestion-des-modules',
			'target' => '_blank',
			'ico' => 'help',
			'value' => $text['core_addon_view']['index'][1],
			'class' => 'buttonHelp'
		]); ?>
	</div>
	<div class="col2 offset6">
		<?php echo template::button('configStoreUpload', [
			'href' => helper::baseUrl() . 'addon/upload',
			'value' => $text['core_addon_view']['index'][2]
		]); ?>
	</div>
</div>

<?php if($module::$modInstal): ?>
	<?php echo template::table([2, 2, 2, 2, 1, 1, 1], $module::$modInstal, [$text['core_addon_view']['index'][3], $text['core_addon_view']['index'][4], $text['core_addon_view']['index'][5], $text['core_addon_view']['index'][6], $text['core_addon_view']['index'][7], $text['core_addon_view']['index'][8], $text['core_addon_view']['index'][9]]); ?>
<?php else: ?>
	<?php echo template::speech($text['core_addon_view']['index'][10]); ?>
<?php endif; ?>
<script>
	var textConfirm = <?php echo '"'.$text['core_addon_view']['index'][11].'"'; ?>;
</script>
