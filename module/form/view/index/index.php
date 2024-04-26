<?php
// Lexique
$param = '';
include('./module/form/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_form.php');

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
if ( !empty($_COOKIE["DELTA_I18N_SITE"])) {
	if( $this->getInput('DELTA_I18N_SITE') !== 'base' ) $lang = $this->getInput('DELTA_I18N_SITE');
}
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
				<label class='formLabel'> <?php echo $input['name']; ?> </label>
				<div class="formInputFile">
					<input type="hidden" name="MAX_FILE_SIZE" value="5000000">
					<input type="file" name="fileToUpload" id="fileToUpload"> 
					<input type="button" id="formFileReset" value="X">
				</div>
			<?php elseif($input['type'] === $module::TYPE_LABEL): ?>
				<p class='formLabel'> <?php echo $input['name']; ?> </p>
			<?php endif; ?>
				
		<?php endforeach; ?>
		</div>
		<?php if( $this->getData(['module', $this->getUrl(0), 'config', 'captcha']) 
				&& ( $_SESSION['humanBot']==='bot') || $this->getData(['config', 'connect', 'captchaBot'])===false ): ?>
			<div class="row">
				<div class="col12 textAlignCenter">
					<?php echo template::captcha('formCaptcha', ''); ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if( $this->getData(['module', $this->getUrl(0), 'config', 'captcha']) 
			&&  $_SESSION['humanBot']==='human' && $this->getData(['config', 'connect', 'captchaBot']) ): ?>
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
		<?php endif; ?>
		<div class="row textAlignCenter">
			<div class="formInner humanBotClose">
				<?php echo template::submit('formSubmit', [
					'value' => $this->getData(['module', $this->getUrl(0), 'config', 'button']) ? $this->getData(['module', $this->getUrl(0), 'config', 'button']) : $text['form_view']['index'][0],
					'ico' => ''
				]); ?>
			</div>
		</div>
	<?php echo template::formClose(); ?>
<?php else: ?>
	<?php echo template::speech($text['form_view']['index'][1]); ?>
<?php endif; ?>