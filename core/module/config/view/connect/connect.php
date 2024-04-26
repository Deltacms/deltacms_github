<?php
// Lexique
$param='';
include('./core/module/config/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_config.php');
?>
<div id="connectContainer">
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['connect'][0]; ?>
					<span id="specialeHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/connexion" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col3">
						<?php echo template::checkbox('connectCaptcha', true, $text['core_config_view']['connect'][1], [
							'checked' => $this->getData(['config', 'connect','captcha'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::checkbox('connectCaptchaBot', true, $text['core_config_view']['connect'][19], [
							'checked' => $this->getData(['config', 'connect', 'captchaBot']),
							'help' => $text['core_config_view']['connect'][3]
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::checkbox('connectPasswordVisibility', true, $text['core_config_view']['connect'][20], [
							'checked' => $this->getData(['config', 'connect', 'passwordVisibility']),
							'help' => $text['core_config_view']['connect'][21]
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::checkbox('connectAutoDisconnect', true, $text['core_config_view']['connect'][5], [
								'checked' => $this->getData(['config','connect', 'autoDisconnect']),
								'help' => $text['core_config_view']['connect'][6]
							]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col3">
						<?php echo template::select('connectAttempt', $connectAttempt , [
							'label' => $text['core_config_view']['connect'][7],
							'selected' => $this->getData(['config', 'connect', 'attempt'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::select('connectTimeout', $connectTimeout , [
							'label' => $text['core_config_view']['connect'][8],
							'selected' => $this->getData(['config', 'connect', 'timeout'])
						]); ?>
					</div>
					<div class="col3 verticalAlignBottom">
						<label id="helpBlacklist"><?php echo $text['core_config_view']['connect'][10]; ?>
							<?php echo template::help($text['core_config_view']['connect'][9]);
							?>
						</label>
						<?php echo template::button('ConnectBlackListDownload', [
							'href' => helper::baseUrl() . 'config/blacklistDownload',
							'value' => $text['core_config_view']['connect'][11],
							'ico' => 'download'
						]); ?>
					</div>
					<div class="col3 verticalAlignBottom">
						<?php echo template::button('CnnectBlackListReset', [
							'class' => 'buttonRed',
							'href' => helper::baseUrl() . 'config/blacklistReset',
							'value' => $text['core_config_view']['connect'][12],
							'ico' => 'cancel'
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['connect'][13];?>
					<span id="specialeHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/connexion#journalisation" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col3">
						<?php echo template::checkbox('connectLog', true, $text['core_config_view']['connect'][14], [
							'checked' => $this->getData(['config', 'connect', 'log'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::select('connectAnonymousIp', $anonIP, [
							'label' => $text['core_config_view']['connect'][15],
							'selected' => $this->getData(['config', 'connect', 'anonymousIp']),
							'help' => $text['core_config_view']['connect'][16]
							]); ?>
					</div>
					<div class="col3 verticalAlignBottom">
						<?php echo template::button('ConfigLogDownload', [
							'href' => helper::baseUrl() . 'config/logDownload',
							'value' => $text['core_config_view']['connect'][17],
							'ico' => 'download'
						]); ?>
					</div>
					<div class="col3 verticalAlignBottom">
						<?php echo template::button('ConnectLogReset', [
							'class' => 'buttonRed',
							'href' => helper::baseUrl() . 'config/logReset',
							'value' => $text['core_config_view']['connect'][18],
							'ico' => 'cancel'
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
