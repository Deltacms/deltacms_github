<?php
// Lexique
include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');

echo template::formOpen('userLoginForm'); 
?>
	<div class="row humanBot">
		<div class="col6">
			<?php echo template::text('userLoginId', [
				'label' => $text['core_user_view']['login'][0],
				'value' => $module::$userId
			]); ?>
		</div>
		<div class="col6">
			<?php 
			if( $this->getData(['config', 'connect', 'passwordVisibility']) === true){
				$passwordLabel = '<span id="passwordLabel">'. $text['core_user_view']['login'][1] .'</span><span id="passwordIcon">' .  template::ico('eye') . '</span>';
			} else {
				$passwordLabel = $text['core_user_view']['login'][1];
			}
			echo template::password('userLoginPassword', [
				'label' => $passwordLabel
			]); ?>
		</div>
	</div>
	<?php if ($this->getData(['config', 'connect','captcha'])){ ?>
			<div class="row">
				<div class="col12 textAlignCenter">
					<?php echo template::captcha('userLoginCaptcha', ''); ?>
				</div>
			</div>
		<?php } ?>
	<div class="row">
		<div class="col6">
			<?php echo template::checkbox('userLoginLongTime', true, $text['core_user_view']['login'][4], [
				'checked' => $module::$userLongtime
			]);	?>
		</div>
		<div class="col6 textAlignRight">
			<a href="<?php echo helper::baseUrl(); ?>user/forgot/<?php echo $this->getUrl(2); ?>"><?php echo $text['core_user_view']['login'][5]; ?> ?</a>
		</div>
	</div>
	<div class="row">
		<div class="col4 offset4">
			<?php echo template::button('userLoginBack', [
				'href' => helper::baseUrl() . str_replace('_', '/', str_replace('__', '#', $this->getUrl(2))),
				'ico' => 'left',
				'value' => $text['core_user_view']['login'][2]
			]); ?>
		</div>
		<div class="col4 humanBotClose">
			<?php echo template::submit('userLoginSubmit', [
				'value' => $text['core_user_view']['login'][3],
				'ico' => 'lock'
			]); ?>
		</div>
	</div>
<?php echo template::formClose(); ?>