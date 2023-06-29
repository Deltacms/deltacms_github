<?php
// Lexique
include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');
?>
<div class="row">
	<div class="col2">
		<?php echo template::button('userAddBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl(false),
			'ico' => 'home',
			'value' => $text['core_user_view']['index'][0]
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::button('userHelp', [
			'href' => 'https://doc.deltacms.fr/liste-des-utilisateurs',
			'target' => '_blank',
			'ico' => 'help',
			'value' => $text['core_user_view']['index'][1],
			'class' => 'buttonHelp'
		]); ?>
	</div>
	<div class="col2 offset4">
		<?php echo template::button('userImport', [
			'href' => helper::baseUrl() . 'user/import',
			'ico' => 'plus',
			'value' => $text['core_user_view']['index'][2]
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::button('userAdd', [
			'href' => helper::baseUrl() . 'user/add',
			'ico' => 'plus',
			'value' => $text['core_user_view']['index'][3]
		]); ?>
	</div>
</div>
<?php echo template::table([3, 4, 3, 1, 1], $module::$users, [$text['core_user_view']['index'][4], $text['core_user_view']['index'][5], $text['core_user_view']['index'][6], '', '']); ?>
<script>
	var textConfirm = <?php echo '"'.$text['core_user_view']['index'][7].'"'; ?>;
</script>