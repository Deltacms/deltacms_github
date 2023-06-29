<?php
// Lexique
$param = '';
include('./module/form/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_form.php');
?>
<div class="row">
	<div class="col2">
		<?php echo template::button('formDataBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
			'ico' => 'left',
			'value' => $text['form_view']['data'][0]
		]); ?>
	</div>
	<div class="col2 offset6">
	<?php echo template::button('formDataDeleteAll', [
			'class' => 'formDataDeleteAll buttonRed',
			'href' => helper::baseUrl() . $this->getUrl(0) . '/deleteall' . '/' . $_SESSION['csrf'],
			'ico' => 'cancel',
			'value' => $text['form_view']['data'][1]
		]); ?>
	</div>
	<div class="col2">
	<?php echo template::button('formDataBack', [
			'href' => helper::baseUrl() . $this->getUrl(0) . '/export2csv' . '/' . $_SESSION['csrf'],
			'ico' => 'download',
			'value' => $text['form_view']['data'][2]
		]); ?>
	</div>
</div>
<?php if($module::$data): ?>
		<?php echo template::table([11, 1], $module::$data, [$text['form_view']['data'][3], '']); ?>
		<?php echo $module::$pages; ?>
	<?php else: ?>
		<?php echo template::speech($text['form_view']['data'][4]); ?>
	<?php endif; ?>
<div class="moduleVersion"><?php echo $text['form_view']['data'][5]; ?>
	<?php echo $module::VERSION; ?>
</div>
<script>
	var textConfirm = <?php echo '"'.$text['form_view']['data'][6].'"'; ?>;
	var textConfirm2 = <?php echo '"'.$text['form_view']['data'][7].'"'; ?>;
</script>