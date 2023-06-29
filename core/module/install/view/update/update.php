<?php
// Lexique
include('./core/module/install/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_install.php');
?>
<p><strong><?php echo $text['core_install_view']['update'][0] . self::DELTA_VERSION . $text['core_install_view']['update'][1] . $module::$newVersion; ?>.</strong></p>
<p><?php echo $text['core_install_view']['update'][2]; ?></p>
<div class="row">
	<div class="col9 verticalAlignMiddle">
		<div id="installUpdateProgress">
			<?php echo template::ico('spin', '', true); ?>
			<span class="installUpdateProgressText" data-id="1"><?php echo $text['core_install_view']['update'][3]; ?></span>
			<span class="installUpdateProgressText displayNone" data-id="2"><?php echo $text['core_install_view']['update'][4]; ?></span>
			<span class="installUpdateProgressText displayNone" data-id="3"><?php echo $text['core_install_view']['update'][5]; ?></span>
			<span class="installUpdateProgressText displayNone" data-id="4"><?php echo $text['core_install_view']['update'][6]; ?></span>
		</div>
		<div id="installUpdateError" class="colorRed displayNone">
			<?php echo template::ico('cancel', ''); ?>
			<?php echo $text['core_install_view']['update'][7]; ?> <span id="installUpdateErrorStep"></span>.
		</div>
		<div id="installUpdateSuccess" class="colorGreen displayNone">
			<?php echo template::ico('check', ''); ?>
			<?php echo $text['core_install_view']['update'][8]; ?>
		</div>
	</div>
	<div class="col3 verticalAlignMiddle">
		<?php echo template::button('installUpdateEnd', [
			'value' => $text['core_install_view']['update'][9],
			'href' => helper::baseUrl(false) . 'index.php',
			'ico' => 'check',
			'class' => 'disabled'
		]); ?>
	</div>
</div>