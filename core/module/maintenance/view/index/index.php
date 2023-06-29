<?php
	// Lexique
	include('./core/module/maintenance/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_maintenance.php');
?>
<p><?php echo $text['core_maintenance']['index'][1]; ?></p>

<div class="row">
	<div class="col4 offset8 textAlignCenter">
		<?php echo template::button('maintenanceLogin', [
			'value' => '',
			'href' => helper::baseUrl() . 'user/login',
			'ico' => 'lock'
		]); ?>
	</div>
</div>