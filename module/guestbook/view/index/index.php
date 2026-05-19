<?php
// Lexique
$param = '';
include('./module/guestbook/lang/'. $_SESSION['langAdmin'] . '/lex_guestbook.php');

// Flatpickr dans la langue en frontend si elle est connue de Flatpickr, y compris en traduction auto
$arrayFlatpickr = ['fr', 'es', 'pt', 'el', 'it'];
if( isset( $_SESSION['langFrontEnd'])){
	$lang_base = $_SESSION['langFrontEnd'];
} else {
	$lang_base = $this->getData(['config', 'i18n', 'langBase']);
}
$lang_flatpickr = in_array($lang_base, $arrayFlatpickr) ? $lang_base : 'default';
?><script>var lang_flatpickr = "<?php echo $lang_flatpickr; ?>";</script><?php

// Adaptation de la langue dans tinymce pour la rédaction d'un message en fonction de la langue de la page, originale ou en traduction rédigée
$lang = $this->getData(['config', 'i18n', 'langBase']);
if( isset($_SESSION['translationType']) && $_SESSION['translationType']==='site' && isset($_SESSION['langFrontEnd'])) $lang = $_SESSION['langFrontEnd'];
$lang_page = $lang;
switch ($lang) {
	case 'en' :
		$lang_page = 'en_GB';
		break;
	case 'pt' :
		$lang_page = 'pt_PT';
		break;
	case 'sv' :
		$lang_page = 'sv_SE';
		break;
	case 'fr' :
		$lang_page = 'fr_FR';
		break;
}
// Si la langue n'est pas supportée par Tinymce la langue d'administration est utilisée
if( ! file_exists( 'core/vendor/tinymce/langs/'.$lang_page.'.js' )){
	$lang_page = $lang_admin;
}
echo '<script> var lang_admin = "'.$lang_page.'"; </script>';
?>
<div class="row">
    <div class="col4 offset4">
        <?php echo template::button('guestbookShowForm', [
            'class' => 'buttonGuestbook',
            'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'display']) ? $this->getData(['module', $this->getUrl(0), 'texts', 'display']) : $text['guestbook']['index'][13],
            'ico' => 'pencil'
        ]); ?>
    </div>
</div>
<div id="GuestBook" style="display: none;">
	<?php
if($this->getData(['module', $this->getUrl(0), 'input'])): ?>
	<?php echo template::formOpenFile('formForm'); ?>
		<?php if($this->getData(['module', $this->getUrl(0), 'config', 'rgpdCheck' ]) === true){ ?>
		<div class="row">
			<div class="col12">
				<?php echo template::checkbox('formRgpdCheck', true, $this->getData(['locale', 'questionnaireAccept']), [
					'checked' => false
				]); ?>
			</div>
		</div>
		<?php } ?>
		<div class="humanBot">
		<?php $textIndex=0;
		foreach($this->getData(['module', $this->getUrl(0), 'input']) as $index => $input): ?>
			<?php if($input['type'] === $module::TYPE_MAIL): ?>
				<?php echo template::mail('formInput[' . $index . ']', [
					'id' => 'formInput_' . $index,
					'label' => $input['name'],
					'value' => $_SESSION['draftG']['mail']
				]); ?>
			<?php elseif($input['type'] === $module::TYPE_TEXT): ?>
				<?php echo template::text('formInput[' . $index . ']', [
					'id' => 'formInput_' . $index,
					'label' => $input['name'],
					'value' => isset($_SESSION['draftG']['text'][$textIndex])? $_SESSION['draftG']['text'][$textIndex]:''
				]);
				$textIndex++;?>
			<?php elseif($input['type'] === $module::TYPE_TEXTAREA): ?>
				<?php echo template::textarea('formInput[' . $index . ']', [
					'id' => 'formInput_' . $index,
					'label' => $input['name'],
					'value' => $_SESSION['draftG']['textarea'],
					'class' => 'editorWysiwygComment',
					'noDirty' => true
				]); ?>
			<?php endif; ?>

		<?php endforeach; ?>
		</div>
		<?php if( $this->getData(['module', $this->getUrl(0), 'config', 'captcha']) ){
			
				if ( $_SESSION['humanBot']==='bot' || $this->getData(['config', 'connect', 'captchaBot'])===false 
				|| ( $this->getData(['config', 'cookieConsent'])===true && !isset( $_COOKIE['DELTA_COOKIE_CONSENT']))) { ?>
				<div class="row">
					<div class="col12 textAlignCenter">
						<?php echo template::captcha('formCaptcha', ''); ?>
					</div>
				</div>
				<?php } else { ?>
				<div class="row formCheckBlue">
					<?php echo template::text('formInputBlue', [
						'label' => 'Input Blue',
						'value' => ''
					]); ?>			
				</div>
				<br>
				<div class="row formOuter">
						<div class="formInner humanCheck">
							<?php echo template::checkbox('formHumanCheck', true, $this->getData(['locale', 'captchaSimpleText']), [
								'checked' => false,
								'help' => $this->getData(['locale', 'captchaSimpleHelp'])
							]); ?>
						</div>
				</div>
				<br>
				<?php }  
		} ?>
		<div class="row textAlignCenter">
			<div class="formInner humanBotClose">
				<?php echo template::submit('formSubmit', [
					'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'send']),
					'ico' => ''
				]); ?>
			</div>
		</div>
		<br>
	<?php echo template::formClose(); ?>
	</div><!--GuestBook-->
<?php else: ?>
	<?php echo template::speech($this->getData(['module', $this->getUrl(0), 'texts', 'noFields']) ? $this->getData(['module', $this->getUrl(0), 'texts', 'noFields']) : $text['guestbook_view']['index'][1]); ?>
<?php endif;
// Affichage des messages
echo '<div class="block msgs">';
if($module::$data):
		foreach( $module::$data as $key1=>$value1){
			foreach( $value1 as $key2=>$value2){
				echo $value2;
			}
		}
	else:
		echo template::speech('<div style=" text-align: center;">'.($this->getData(['module', $this->getUrl(0), 'texts', 'noMessage']) ? $this->getData(['module', $this->getUrl(0), 'texts', 'noMessage']) : $text['guestbook_view']['index'][3]).'</div>' );
	endif;
echo '</div>';
if($module::$pages) echo $module::$pages;
?>
