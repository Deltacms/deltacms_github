<?php
// Lexique
$param='';
include('./core/module/config/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_config.php');
?>
<div id="networkContainer">
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['network'][0]; ?>
					<span id="specialeHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/reseau" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col2">
						<?php echo template::select('configProxyType', $module::$proxyType, [
							'label' => $text['core_config_view']['network'][1],
							'selected' => $this->getData(['config', 'proxyType'])
							]); ?>
						</div>
					<div  class="col8">
						<?php echo template::text('configProxyUrl', [
							'label' => $text['core_config_view']['network'][2],
							'placeholder' => 'cache.proxy.fr',
							'value' => $this->getData(['config', 'proxyUrl'])
						]); ?>
					</div>
					<div  class="col2">
						<?php echo template::text('configProxyPort', [
							'label' => $text['core_config_view']['network'][3],
							'placeholder' => '6060',
							'value' => $this->getData(['config', 'proxyPort'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['network'][4]; ?>
					<span id="specialeHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/reseau#smtp" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col12">
						<?php echo template::checkbox('smtpEnable', true, $text['core_config_view']['network'][5], [
								'checked' => $this->getData(['config', 'smtp','enable']),
								'help' => $text['core_config_view']['network'][6]
							]); ?>
					</div>
				</div>
				<div id="smtpParam">
					<div class="row">
						<div class="col8">
							<?php echo template::text('smtpHost', [
								'label' => $text['core_config_view']['network'][7],
								'placeholder' => 'smtp.fr',
								'value' => $this->getData(['config', 'smtp','host'])
							]); ?>
						</div>
						<div  class="col2">
							<?php echo template::text('smtpPort', [
									'label' => $text['core_config_view']['network'][8],
									'placeholder' => '589',
									'value' => $this->getData(['config', 'smtp','port'])
							]); ?>
						</div>
						<div  class="col2">
							<?php echo template::select('smtpAuth', $SMTPauth, [
								'label' => $text['core_config_view']['network'][9],
								'selected' => $this->getData(['config', 'smtp','auth'])
							]); ?>
						</div>
					</div>
					<div id="smtpAuthParam">
						<div class="row">
							<div  class="col5">
								<?php echo template::text('smtpUsername', [
									'label' => $text['core_config_view']['network'][10],
									'value' => $this->getData(['config', 'smtp','username' ])
								]); ?>
							</div>
							<div  class="col5">
								<?php echo template::password('smtpPassword', [
									'label' => $text['core_config_view']['network'][11],
									'autocomplete' => 'off',
									'value' => $this->getData(['config', 'smtp','username' ]) ? helper::decrypt ($this->getData(['config', 'smtp','username' ]),$this->getData(['config','smtp','password'])) : ''
								]); ?>
							</div>
							<div  class="col2">
								<?php echo template::select('smtpSecure', $SMTPEnc	, [
									'label' => $text['core_config_view']['network'][12],
									'selected' => $this->getData(['config', 'smtp','secure'])
								]); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
