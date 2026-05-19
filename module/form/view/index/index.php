<?php
// Lexique
$param = '';
include('./module/form/lang/'. $_SESSION['langAdmin'] . '/lex_form.php');

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
		<?php $textIndex=0; $selectIndex=0; $checkboxIndex=0;
		foreach($this->getData(['module', $this->getUrl(0), 'input']) as $index => $input): ?>
			<?php if($input['type'] === $module::TYPE_MAIL): ?>
				<?php echo template::mail('formInput[' . $index . ']', [
					'id' => 'formInput_' . $index,
					'label' => $input['name'],
					'value' => $_SESSION['draft']['mail']
				]); ?>
			<?php elseif($input['type'] === $module::TYPE_SELECT): ?>
				<?php
				$values = array_flip(explode(',', $input['values']));
				foreach($values as $value => $key) {
					$values[$value] = trim($value);
				}
				?>
				<?php echo template::select('formInput[' . $index . ']', $values, [
					'id' => 'formInput_' . $index,
					'label' => $input['name'],
					'selected' => isset($_SESSION['draft']['select'][$selectIndex])? $values[$_SESSION['draft']['select'][$selectIndex]] : ''
				]);
				$selectIndex++; ?>
			<?php elseif($input['type'] === $module::TYPE_TEXT): ?>
				<?php echo template::text('formInput[' . $index . ']', [
					'id' => 'formInput_' . $index,
					'label' => $input['name'],
					'value' => isset($_SESSION['draft']['text'][$textIndex]) ? $_SESSION['draft']['text'][$textIndex] : ''
				]);
				$textIndex++; ?>
			<?php elseif($input['type'] === $module::TYPE_TEXTAREA): ?>
				<?php echo template::textarea('formInput[' . $index . ']', [
					'id' => 'formInput_' . $index,
					'label' => $input['name'],
					'value' => $_SESSION['draft']['textarea'],
					'class' => 'editorWysiwygComment',
					'noDirty' => true
				]); ?>
			<?php elseif($input['type'] === $module::TYPE_DATETIME): ?>
				<?php echo template::date('formInput[' . $index . ']', [
					'id' => 'formInput_' . $index,
					'label' => $input['name'],
					'value' => $_SESSION['draft']['datetime']
				]); ?>
			<?php elseif($input['type'] === $module::TYPE_CHECKBOX):
				echo template::checkbox('formInput[' . $index . ']', true, $input['name'], [
					'checked' => isset($_SESSION['draft']['checkbox'][$checkboxIndex]) ? $_SESSION['draft']['checkbox'][$checkboxIndex] : false
				]);
				$checkboxIndex++; ?>
			<?php elseif($input['type'] === $module::TYPE_FILE): ?>
			<?php // liste les extensions de fichiers validées en config
			$acceptfile = $this->getData(['module', $this->getUrl(0), 'config', 'uploadJpg']) == true ? '.jpg,.jpeg,' : '';
			$acceptfile .= $this->getData(['module', $this->getUrl(0), 'config', 'uploadPng']) == true ? '.png,' : '';
			$acceptfile .= $this->getData(['module', $this->getUrl(0), 'config', 'uploadWebp']) == true ? '.webp,' : '';
			$acceptfile .= $this->getData(['module', $this->getUrl(0), 'config', 'uploadAvif']) == true ? '.avif,' : '';
			$acceptfile .= $this->getData(['module', $this->getUrl(0), 'config', 'uploadGif']) == true ? '.gif,' : '';
			$acceptfile .= $this->getData(['module', $this->getUrl(0), 'config', 'uploadPdf']) == true ? '.pdf,' : '';
			$acceptfile .= $this->getData(['module', $this->getUrl(0), 'config', 'uploadZip']) == true ? '.zip,' : '';
			$acceptfile .= $this->getData(['module', $this->getUrl(0), 'config', 'uploadTxt']) == true ? '.txt,' : '';
			$validfile = substr($acceptfile,0,-1);// supprime la dernière virgule
			?>
				<label class='formLabel'> <?php echo $input['name']; ?> </label>
				<div class="formInputFile">
					<input type="hidden" name="MAX_FILE_SIZE" value="5000000">
					<input type="file" name="fileToUpload" id="fileToUpload" accept="<?=$validfile?>">
					<span><?=$text['form_view']['index'][3]?> : <?=str_replace(',', ', ', $validfile)?></span>
				</div>
			<?php elseif($input['type'] === $module::TYPE_LABEL): ?>
				<p class='formLabel'> <?php echo $input['name']; ?> </p>
			<?php endif; ?>

		<?php endforeach; ?>
		</div>
		<?php if( $this->getData(['module', $this->getUrl(0), 'config', 'captcha']) ) {
			if ( $_SESSION['humanBot']==='bot' || $this->getData(['config', 'connect', 'captchaBot'])===false
			|| ( $this->getData(['config', 'cookieConsent'])===true && !isset( $_COOKIE['DELTA_COOKIE_CONSENT']))){ ?>
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
			<?php } ;
		} ?>
		<div class="row textAlignCenter">
			<div class="formInner humanBotClose">
				<?php echo template::submit('formSubmit', [
					'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'button']),
					'ico' => ''
				]); ?>
			</div>
		</div>
	<?php echo template::formClose(); ?>
<?php else: ?>
	<?php echo template::speech($text['form_view']['index'][1]); ?>
<?php endif; ?>
