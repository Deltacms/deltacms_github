<?php
// Lexique
$param = 'guestbook_view';
include('./module/guestbook/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_guestbook.php');
// drapeau pour la langue d'origine ou la langue en traduction rédigée
$flag = $this->flagLang();

echo template::formOpen('guestbookTexts'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('guestbookTextsBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0). '/config',
				'ico' => 'left',
				'value' => $text['guestbook_view']['texts'][0]
			]); ?>
		</div>
		<div class="col2 offset8">
			<?php echo template::submit('guestbookTextsSubmit',[
				'value' => $text['guestbook_view']['texts'][1]
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['guestbook_view']['texts'][2].' '.template::flag($flag, '20px');?></div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('guestbookTextsSend', [
							'label' => $text['guestbook_view']['index'][0],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'send'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('guestbookTextsNoFields', [
							'label' => $text['guestbook_view']['index'][1],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'noFields'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('guestbookTextsNoMessage', [
							'label' => $text['guestbook_view']['index'][3],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'noMessage'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('guestbookTextsWrongCaptcha', [
							'label' => $text['guestbook']['index'][0],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'wrongCaptcha'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('guestbookTextsFormSubmitted', [
							'label' => $text['guestbook']['index'][3],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'formSubmitted'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('guestbookTextsFailure', [
							'label' => $text['guestbook']['index'][9],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'failure'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('guestbookTextsDate', [
							'label' => $text['guestbook']['index'][10],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'date'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('guestbookTextsFillCaptcha', [
							'label' => $text['guestbook']['index'][12],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'fillCaptcha'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('guestbookTextsDisplay', [
							'label' => $text['guestbook']['index'][13],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'display'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
<div class="moduleVersion"><?php echo $text['guestbook_view']['texts'][3]; ?>
	<?php echo $module::VERSION; ?>
</div>

