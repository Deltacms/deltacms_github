<?php echo template::formOpen('userResetForm'); 
// Lexique
include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');
?>
	<div class="row">
		<div class="col6">
			<?php echo template::password('userResetNewPassword', [
				'label' => $text['core_user_view']['reset'][0]
			]); ?>
		</div>
		<div class="col6">
			<?php echo template::password('userResetConfirmPassword', [
				'label' => $text['core_user_view']['reset'][1]
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col2 offset10">
			<?php echo template::submit('userResetSubmit', [
				'value' => $text['core_user_view']['reset'][2]
			]); ?>
		</div>
	</div>
<?php echo template::formClose(); ?>