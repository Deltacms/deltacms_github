<?php
// Lexique
include('./core/module/page/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_page.php');

echo template::formOpen('pageEditPluginForm'); ?>
<div class="row">
	<div class="col2">
		<?php echo template::button('pageEditPluginBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . 'page/edit/' .  $this->getUrl(2),
			'ico' => 'left',
			'value' => $text['core_page_view']['plugin'][1]
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::button('pageEditPluginHelp', [
			'href' => 'https://doc.deltacms.fr/plugins',
			'target' => '_blank',
			'ico' => 'help',
			'value' => $text['core_page_view']['plugin'][8],
			'class' => 'buttonHelp'
		]); ?>
	</div>
<?php if($module::$pluginNoHtml === true){ ?>
	<div class="col2 offset6">
        <?php echo template::submit('themeMenuSubmit',[
			'value' => $text['core_page_view']['plugin'][7]
		]); ?>
    </div>
<?php } ?>
</div>
<?php if($module::$data): ?>
		<?php echo template::table([1,1,1,7,1,1], $module::$data,[$text['core_page_view']['plugin'][2],$text['core_page_view']['plugin'][9],$text['core_page_view']['plugin'][3],$text['core_page_view']['plugin'][4],'','']); ?>
	<?php else: ?>
		<?php echo template::speech($text['core_page_view']['plugin'][5]); ?>
<?php endif; ?>

<?php echo template::formClose(); ?>

<script>
	var textConfirm = <?php echo '"'.$text['core_page_view']['plugin'][6].'"'; ?>;
</script>





