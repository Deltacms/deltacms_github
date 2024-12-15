<?php
// Lexique
include('./core/module/page/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_page.php');
?>
<div class="row">
	<div class="col2">
		<?php echo template::button('pageEditCommentBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . 'page/edit/' .  $this->getUrl(2),
			'ico' => 'left',
			'value' => $text['core_page_view']['comment'][1]
		]); ?>
	</div>
	<div class="col2 offset6">
	<?php echo template::button('formDataDeleteAll', [
			'class' => 'formDataDeleteAll buttonRed',
			'href' => helper::baseUrl() . 'page/commentAllDelete/' . $this->getUrl(2) . '/' . $_SESSION['csrf'],
			'ico' => 'cancel',
			'value' => $text['core_page_view']['comment'][4] 
		]); ?>
	</div>
	<div class="col2">
	<?php echo template::button('formDataBack', [
			'href' => helper::baseUrl() . 'page/commentExport2csv/' . $this->getUrl(2) . '/'. $_SESSION['csrf'],
			'ico' => 'download',
			'value' => $text['core_page_view']['comment'][3]
		]); ?>
	</div>
</div>
<?php if($module::$data): ?>
		<?php echo template::table([2,6,2,1,1], $module::$data,[$text['core_page_view']['comment'][8],$text['core_page_view']['comment'][9],$text['core_page_view']['comment'][10],'','']); ?>
		<?php echo $module::$pages; ?>
	<?php else: ?>
		<?php echo template::speech($text['core_page_view']['comment'][5]); ?>
	<?php endif; ?>

<script>
	var textConfirm = <?php echo '"'.$text['core_page_view']['comment'][6].'"'; ?>;
	var textConfirm2 = <?php echo '"'.$text['core_page_view']['comment'][7].'"'; ?>;
</script>





