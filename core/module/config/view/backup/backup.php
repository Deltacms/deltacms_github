<?php
// Lexique
$param='';
include('./core/module/config/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_config.php');

echo template::formOpen('configBackupForm'); ?>
<div class="row">
	<div class="col2">
		<?php echo template::button('configBackupBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'config',
				'ico' => 'left',
				'value' => $text['core_config_view']['backup'][0]
		]); ?>
	</div>
	<div class="col2 offset8">
		<?php echo template::submit('configBackupSubmit',[
			'value' => $text['core_config_view']['backup'][1],
			'uniqueSubmission' => true
		]); ?>
	</div>
</div>
<div class="row">
	<div class="col12">
		<div class="block">
			<div class="blockTitle"><?php echo $text['core_config_view']['backup'][4]; ?></div>
			<div class="row">
				<div class="col12">
					<?php echo template::checkbox('configBackupOption', true, $text['core_config_view']['backup'][2], [
						'checked' => true,
						'help' => $text['core_config_view']['backup'][3]
					]); ?>
				</div>
				<div class="col12">
					<em><?php echo $text['core_config_view']['backup'][5]; ?><a href="<?php echo helper::baseUrl(false); ?>core/vendor/filemanager/dialog.php?fldr=backup&type=0&akey=<?php echo md5_file(self::DATA_DIR.'core.json'); ?>"  data-lity><?php echo $text['core_config_view']['backup'][6]; ?></a><?php echo $text['core_config_view']['backup'][7]; ?></em>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo template::formClose(); ?>
<script>
	var text1 = <?php echo '"'.$text['core_config_view']['backup'][8].'"'; ?>;
	var text2 = <?php echo '"'.$text['core_config_view']['backup'][9].'"'; ?>;
	var text3 = <?php echo '"'.$text['core_config_view']['backup'][10].'"'; ?>;
</script>
