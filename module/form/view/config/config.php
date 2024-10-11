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
<div id="formConfigCopy" class="displayNone">
	<div class="formConfigInput">
		<?php echo template::hidden('formConfigPosition[]', [
			'class' => 'formConfigPosition'
		]); ?>
		<div class="row">
			<div class="col1">
				<?php echo template::button('formConfigMove[]', [
					'value' => template::ico('sort'),
					'class' => 'formConfigMove'
				]); ?>
			</div>
			<div class="col5">
				<?php echo template::text('formConfigName[]', [
					'placeholder' => $text['form_view']['config'][0]
				]); ?>
			</div>
			<div class="col4">
				<?php echo template::select('formConfigType[]', $types, [
					'class' => 'formConfigType'
				]); ?>
			</div>
			<div class="col1">
				<?php echo template::button('formConfigMoreToggle[]', [
					'value' => template::ico('gear'),
					'class' => 'formConfigMoreToggle'
				]); ?>
			</div>
			<div class="col1">
				<?php echo template::button('formConfigDelete[]', [
					'value' => template::ico('minus'),
					'class' => 'formConfigDelete'
				]); ?>
			</div>
		</div>
		<div class="formConfigMoreLabel displayNone">
			<?php echo template::label('formConfigLabel', $text['form_view']['config'][1], [
					'class' => 'displayNone formConfigLabelWrapper'
				]); ?>
		</div>
		<div class="formConfigMore displayNone">
			<?php echo template::text('formConfigValues[]', [
				'placeholder' => $text['form_view']['config'][2],
				'class' => 'formConfigValues',
				'classWrapper' => 'displayNone formConfigValuesWrapper'
			]); ?>
			<?php echo template::checkbox('formConfigRequired[]', true, $text['form_view']['config'][3]); ?>
		</div>
	</div>
</div>
<?php echo template::formOpen('formConfigForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('formConfigBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),
				'ico' => 'left',
				'value' => $text['form_view']['config'][4]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('formIndexHelp', [
				'class' => 'buttonHelp',
				'ico' => 'help',
				'value' => $text['form_view']['config'][39]
			]); ?>
		</div>
		<div class="col2 offset2 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone';?>">
			<?php echo template::button('formConfigTexts', [
				'href' => helper::baseUrl() . $this->getUrl(0) . '/texts',
				'ico' => 'pencil',
				'value' => $text['form_view']['config'][43].' '.template::flag($flag, '20px')
			]); ?>
		</div>
		<div class="col2 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone';?>">
			<?php echo template::button('formConfigData', [
				'href' => helper::baseUrl() . $this->getUrl(0) . '/data',
				'ico' => 'gear',
				'value' => $text['form_view']['config'][5]
			]); ?>
		</div>
		<div class="col2 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'offset6';?>">
			<?php echo template::submit('formConfigSubmit',[
				'value' => $text['form_view']['config'][30]
			]); ?>
		</div>
	</div>
	<!-- Aide à propos de la configuration de formulaire, view config -->
	<div class="helpDisplayContent">
		<?php echo file_get_contents( $text['form_view']['config'][40]) ;?>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['form_view']['config'][6]; ?></div>

				<div <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo '<div style="display: none;">'; ?> >
					<?php echo template::checkbox('formConfigMailOptionsToggle', true, $text['form_view']['config'][9], [
						'checked' => (bool) $this->getData(['module', $this->getUrl(0), 'config', 'group']) ||
											!empty($this->getData(['module', $this->getUrl(0), 'config', 'user'])) ||
											!empty($this->getData(['module', $this->getUrl(0), 'config', 'mail'])),
						'help' => $text['form_view']['config'][10]
					]); ?>
					<div id="formConfigMailOptions" class="displayNone">
						<div class="row">
							<div class="col11 offset1">
								<?php echo template::text('formConfigSubject', [
									'help' => $text['form_view']['config'][11],
									'label' => $text['form_view']['config'][12],
									'value' => $this->getData(['module', $this->getUrl(0), 'config', 'subject'])
								]); ?>
							</div>
						</div>
						<?php
							// Element 0 quand aucun membre a été sélectionné
							$groupMembers = [''] + $groupNews;
						?>
						<div class="row">
							<div class="col3 offset1">
								<?php echo template::select('formConfigGroup', $groupMembers, [
									'label' => $text['form_view']['config'][13],
									'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'group']),
									'help' => $text['form_view']['config'][14]
								]); ?>
							</div>
							<div class="col3">
								<?php echo template::select('formConfigUser', $module::$listUsers, [
									'label' => $text['form_view']['config'][15],
									'selected' => array_search($this->getData(['module', $this->getUrl(0), 'config', 'user']),$module::$listUsers)
								]); ?>
							</div>
							<div class="col4">
								<?php echo template::text('formConfigMail', [
									'label' => $text['form_view']['config'][16],
									'value' => $this->getData(['module', $this->getUrl(0), 'config', 'mail']),
									'help' => $text['form_view']['config'][17]
								]); ?>
							</div>
						</div>
						<div class="row">
							<div class="col6 offset1">
								<?php echo template::checkbox('formConfigMailReplyTo', true, $text['form_view']['config'][18], [
										'checked' => (bool) $this->getData(['module', $this->getUrl(0), 'config', 'replyto']),
										'help' => $text['form_view']['config'][19]
									]); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="row" <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo '<div style="display: none;">'; ?> >
					<div class="col4">
						<?php echo template::select('formConfigSignature', $signature, [
							'label' => $text['form_view']['config'][20],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'signature'])
						]); ?>
					</div>
					<div class="col4">
												<?php echo template::file('formConfigLogo', [
							'help' => $text['form_view']['config'][21],
														'label' => $text['form_view']['config'][22],
														'value' => $this->getData(['module', $this->getUrl(0), 'config', 'logoUrl'])
												]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('formConfigLogoWidth', $module::$logoWidth, [
							'label' => $text['form_view']['config'][23],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'logoWidth'])
						]); ?>
					</div>
				</div>
				<div class="row" <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo '<div style="display: none;">'; ?>>
					<div class="col6">
						<?php echo template::checkbox('formConfigPageIdToggle', true, $text['form_view']['config'][24], [
							'checked' => (bool) $this->getData(['module', $this->getUrl(0), 'config', 'pageId'])
						]); ?>
					</div>
					<div class="col5">
						<?php echo template::select('formConfigPageId', $module::$pages, [
							'classWrapper' => 'displayNone',
							'label' => $text['form_view']['config'][25],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'pageId'])
						]); ?>
					</div>
				</div>
				<div class="row" <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo '<div style="display: none;">'; ?>>
					<div class="col4">
						<?php echo template::checkbox('formConfigCaptcha', true, $text['form_view']['config'][26], [
							'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'captcha'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::checkbox('formConfigRgpdCheck', true, $text['form_view']['config'][41], [
							'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'rgpdCheck']),
							'help' => $text['form_view']['config'][42]
						]); ?>
					</div>
				</div>
				<div class="row" <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo '<div style="display: none;">'; ?>>
					<div class="col4">
						<?php echo template::select('formConfigMaxSize', $module::$maxSizeUpload, [
							'label' => $text['form_view']['config'][31],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'maxSizeUpload'])
						]); ?>
					</div>
					<div class="col8">
						<div class="row">
							<div class="col12">
								<?php echo template::label('formConfigUploadLabel', $text['form_view']['config'][32],[
									'help' => $text['form_view']['config'][38]
								]); ?>
							</div>
						</div>
						<div class="row">
							<div class="col2">
								<?php echo template::checkbox('formConfigUploadJpg', true, $text['form_view']['config'][33], [
									'checked' => (bool) $this->getData(['module', $this->getUrl(0), 'config', 'uploadJpg'])
								]); ?>
							</div>
							<div class="col2">
								<?php echo template::checkbox('formConfigUploadPng', true, $text['form_view']['config'][34], [
									'checked' => (bool) $this->getData(['module', $this->getUrl(0), 'config', 'uploadPng'])
								]); ?>
							</div>
							<div class="col2">
								<?php echo template::checkbox('formConfigUploadPdf', true, $text['form_view']['config'][35], [
									'checked' => (bool) $this->getData(['module', $this->getUrl(0), 'config', 'uploadPdf'])
								]); ?>
							</div>
							<div class="col2">
								<?php echo template::checkbox('formConfigUploadZip', true, $text['form_view']['config'][36], [
									'checked' => (bool) $this->getData(['module', $this->getUrl(0), 'config', 'uploadZip'])
								]); ?>
							</div>
							<div class="col2">
								<?php echo template::checkbox('formConfigUploadTxt', true, $text['form_view']['config'][37], [
									'checked' => (bool) $this->getData(['module', $this->getUrl(0), 'config', 'uploadTxt'])
								]); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="block" <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo '<div style="display: none;">'; ?>>
				<div class="blockTitle"><?php echo $text['form_view']['config'][27]; ?></div>
				<div id="formConfigNoInput">
					<?php echo template::speech($text['form_view']['config'][28]); ?>
				</div>
				<div id="formConfigInputs"></div>
				<div class="row">
					<div class="col1 offset11">
						<?php echo template::button('formConfigAdd', [
							'value' => template::ico('plus')
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
<div class="moduleVersion"><?php echo $text['form_view']['config'][29]; ?>
	<?php echo $module::VERSION; ?>
</div>
