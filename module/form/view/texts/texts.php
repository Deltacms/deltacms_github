<?php
// Lexique
$param = 'form_view';
include('./module/form/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_form.php');

// drapeau pour la langue d'origine ou la langue en traduction rédigée
if( $this->getInput('DELTA_I18N_SITE') === '' || $this->getInput('DELTA_I18N_SITE')=== null || $this->getInput('DELTA_I18N_SITE') === 'base'){
	$flag = $this->getData(['config', 'i18n', 'langBase']);
}
else{
	$flag = $this->getInput('DELTA_I18N_SITE');
}
?>
<?php echo template::formOpen('formTexts'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('formTextsBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0). '/config',
				'ico' => 'left',
				'value' => $text['form_view']['texts'][0]
			]); ?>
		</div>
		<div class="col2 offset8">
			<?php echo template::submit('formTextsSubmit',[
				'value' => $text['form_view']['texts'][1]
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['form_view']['texts'][2].' '.template::flag($flag, '20px');?></div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('formTextsButton', [
							'label' => $text['form_view']['texts'][4],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'button'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('formTextsWrongCaptcha', [
							'label' => $text['form']['init'][0],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'wrongCaptcha'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('formTextsFormSubmitted', [
							'label' => $text['form']['init'][3],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'formSubmitted'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('formTextsNotImage', [
							'label' => $text['form']['init'][4],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'notImage'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('formTextsSizeExceeds', [
							'label' => $text['form']['init'][6],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'sizeExceeds'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('formTextsNotAllowed', [
							'label' => $text['form']['init'][7],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'notAllowed'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('formTextsErrorUploading', [
							'label' => $text['form']['init'][8],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'errorUploading'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('formTextsNotPdf', [
							'label' => $text['form']['init'][10],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'notPdf'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('formTextsNotZip', [
							'label' => $text['form']['init'][11],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'notZip'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('formTextsFillCaptcha', [
							'label' => $text['form']['init'][12],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'fillCaptcha'])
						]); ?>
					</div>				
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
<div class="moduleVersion"><?php echo $text['form_view']['texts'][5]; ?>
	<?php echo $module::VERSION; ?>
</div>

