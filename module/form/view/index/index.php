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

if($this->getData(['module', $this->getUrl(0), 'input'])): ?>
	<?php echo template::formOpenFile('formForm'); ?>
		<div class="humanBot">
		<?php foreach($this->getData(['module', $this->getUrl(0), 'input']) as $index => $input): ?>
			<?php if($input['type'] === $module::TYPE_MAIL): ?>
				<?php echo template::mail('formInput[' . $index . ']', [
					'id' => 'formInput_' . $index,
					'label' => $input['name'],
					'value' => $this->getData([ 'module', $this->getUrl(0), 'draft', 'mail'])
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
					'selected' => $values[$this->getData([ 'module', $this->getUrl(0), 'draft', 'select'])]
				]); ?>
			<?php elseif($input['type'] === $module::TYPE_TEXT): ?>
				<?php echo template::text('formInput[' . $index . ']', [
					'id' => 'formInput_' . $index,
					'label' => $input['name'],
					'value' => $this->getData([ 'module', $this->getUrl(0), 'draft', 'text'])
				]); ?>
			<?php elseif($input['type'] === $module::TYPE_TEXTAREA): ?>
				<?php echo template::textarea('formInput[' . $index . ']', [
					'id' => 'formInput_' . $index,
					'label' => $input['name'],
					'value' => $this->getData([ 'module', $this->getUrl(0), 'draft', 'textarea'])
				]); ?>
			<?php elseif($input['type'] === $module::TYPE_DATETIME): ?>
				<?php echo template::date('formInput[' . $index . ']', [
					'id' => 'formInput_' . $index,
					'label' => $input['name'],
					'value' => $this->getData([ 'module', $this->getUrl(0), 'draft', 'datetime'])		
				]); ?>
			<?php elseif($input['type'] === $module::TYPE_CHECKBOX): ?>
				<?php echo template::checkbox('formInput[' . $index . ']', true, $input['name'], [
					'checked' => $this->getData([ 'module', $this->getUrl(0), 'draft', 'checkbox'])
				]); ?>	
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