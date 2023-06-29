<?php
// Lexique
include('./core/module/config/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_config.php');

echo template::formOpen('configRestoreForm'); ?>
<div class="row">
	<div class="col2">
		<?php echo template::button('configRestoreBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . 'config',
			'ico' => 'left',
			'value' => $text['core_config_view']['restore'][0]
		]); ?>
	</div>
	<div class="col2 offset8">
		<?php echo template::submit('configRestoreSubmit',[
			'value' => $text['core_config_view']['restore'][1],
			'uniqueSubmission' => true,
		]); ?>
	</div>
</div>
<div class="row">
	<div class="col12">
		<div class="block">
			<div class="blockTitle"><?php echo $text['core_config_view']['restore'][2]; ?></div>
			<div class="row">
				<div class="col10 offset1">
					<div class="row">
						<?php echo template::file('configRestoreImportFile', [
							'label' => $text['core_config_view']['restore'][3],
							'type' => 2,
							'help' => $text['core_config_view']['restore'][4]
						]); ?>
					</div>
					<div class="row">
						<?php echo template::checkbox('configRestoreImportUser', true, $text['core_config_view']['restore'][5], [
							'checked' => true
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo template::formClose(); ?>
