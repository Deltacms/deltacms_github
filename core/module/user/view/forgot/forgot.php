<?php echo template::formOpen('userForgotForm'); 
// Lexique
include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');

echo template::text('userForgotId', [
		'label' => $text['core_user_view']['forgot'][0]
	]); ?>
	<div class="row">
		<div class="col3 offset6">
			<?php echo template::button('userForgotBack', [
				'href' => helper::baseUrl() . 'user/login/' . $this->getUrl(2),
				'ico' => 'left',
				'value' => $text['core_user_view']['forgot'][1]
			]); ?>
		</div>
		<div class="col3">
			<?php echo template::submit('userForgotSubmit', [
				'value' => $text['core_user_view']['forgot'][2]
			]); ?>
		</div>
	</div>
<?php echo template::formClose(); ?>