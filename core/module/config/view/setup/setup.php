<?php
// Lexique
$param='';
include('./core/module/config/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_config.php');
?>
<div id="setupContainer">
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['setup'][0]; ?>
					<span id="setupHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/configuration" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::file('configFavicon', [
							'type' => 1,
							'help' => $text['core_config_view']['setup'][3],
							'label' => $text['core_config_view']['setup'][4],
							'value' => $this->getData(['config', 'favicon'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::file('configFaviconDark', [
							'type' => 1,
							'help' => $text['core_config_view']['setup'][5],
							'label' => $text['core_config_view']['setup'][6],
							'value' => $this->getData(['config', 'faviconDark'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('configTimezone', $module::$timezones, [
							'label' => $text['core_config_view']['setup'][7],
							'selected' => $this->getData(['config', 'timezone']),
							'help' => $text['core_config_view']['setup'][8]
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col6">
							<?php echo template::checkbox('configCookieConsent', true, $text['core_config_view']['setup'][9], [
								'checked' => $this->getData(['config', 'cookieConsent']),
								'help' => $text['core_config_view']['setup'][10]
							]); ?>
					</div>
					<div class="col6">
						<?php echo template::checkbox('configRewrite', true, $text['core_config_view']['setup'][11], [
							'checked' => helper::checkRewrite(),
							'help' => $text['core_config_view']['setup'][12]
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['setup'][1]; ?>
					<span id="updateHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/configuration#mise-a-jour" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<?php 
				if( $this->getData(['config', 'autoUpdate']) === true){
					$updateVersion = helper::urlGetContents(common::DELTA_UPDATE_URL . common::DELTA_UPDATE_CHANNEL . '/version');
					if( $updateVersion === false) $this->setData(['config', 'autoUpdate', false]);
				} else {
					$updateVersion = false;
				}?>
				<div class="row">
					<div class="col4">
						<?php echo template::checkbox('configAutoUpdate', true, $text['core_config_view']['setup'][13], [
								'checked' => $this->getData(['config', 'autoUpdate']),
								'help' => $text['core_config_view']['setup'][14]
							]); ?>
					</div>
					<div class="col4">
						<?php echo template::checkbox('configAutoUpdateHtaccess', true, $text['core_config_view']['setup'][15], [
								'checked' => $this->getData(['config', 'autoUpdateHtaccess']),
								'help' => $text['core_config_view']['setup'][16],
								'disabled' => !$updateVersion
							]); ?>
					</div>
					<div class="col2 offset1">
						<?php echo template::button('configUpdateForced', [
							'ico' => 'download-cloud',
							'href' => $updateVersion === false ? 'javascript:void(0);' : helper::baseUrl() . 'install/update',
							'value' => $text['core_config_view']['setup'][17],
							'class' => $updateVersion === false ? 'buttonRed' : 'configUpdate buttonRed',
							'disabled' => !$updateVersion
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['setup'][2]; ?>
					<span id="maintenanceHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/configuration#maintenance" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col6">
						<?php echo template::checkbox('configAutoBackup', true, $text['core_config_view']['setup'][18], [
								'checked' => $this->getData(['config', 'autoBackup']),
								'help' => $text['core_config_view']['setup'][19]
							]); ?>
					</div>
					<div class="col6">
						<?php echo template::checkbox('configMaintenance', true, $text['core_config_view']['setup'][20], [
							'checked' => $this->getData(['config', 'maintenance'])
						]); ?>
					</div>
				</div>
				<div class="rows textAlignCenter">
					<div class="col3">
						<?php echo template::button('configBackupButton', [
							'href' => helper::baseUrl() . 'config/backup',
							'value' => $text['core_config_view']['setup'][21],
							'ico' => 'download-cloud'
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::button('configRestoreButton', [
							'href' => helper::baseUrl() . 'config/restore',
							'value' => $text['core_config_view']['setup'][22],
							'ico' => 'upload-cloud'
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::button('configBackupCopyButton', [
							'href' => helper::baseUrl() . 'config/copyBackups',
							'value' => $text['core_config_view']['setup'][23],
							'ico' => 'download-cloud'
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div id="infotopdf">
					<div class="blockTitle"><?php echo $text['core_config_view']['setup'][24]; ?></div>
					<div class="row">
						<div class="col12">
							<?php $textRewrite = $text['core_config_view']['setup'][30];
							if( helper::checkRewrite() === true ) $textRewrite = $text['core_config_view']['setup'][29];
							$listText = $text['core_config_view']['setup'][25]. common::DELTA_VERSION."\n".$text['core_config_view']['setup'][26]. phpversion()."\n".$text['core_config_view']['setup'][27]. $_SERVER['SERVER_SOFTWARE']."\n".$text['core_config_view']['setup'][28].$textRewrite;
							echo template::textarea('modulesPhp1',[
								'value' => $listText
							]); ?> 
						</div>
					</div>
					<div class="row">
						<div class="col12">
							<?php $listMod = get_loaded_extensions();
							natcasesort($listMod);
							$listModText = $text['core_config_view']['setup'][31];
							$listModSmall = [];
							foreach( $listMod as $key=>$value){
								$listModText .= $value.' - ';
								$listModSmall[$key] = strtolower($value);
							}
							$listModText = substr( $listModText, 0, strlen($listModText) - 3);
							$listModRequired = array('exif', 'gd', 'mbstring', 'xmlwriter', 'zip', 'date', 'fileinfo', 'phar');
							$listDiff = array_diff( $listModRequired, $listModSmall );
							if( count($listDiff) > 0) {
								$listModText .= "\n\n".$text['core_config_view']['setup'][32];
							foreach( $listDiff as $key=>$value){
								$listModText .= $value.' - ';
							}
							$listModText = substr( $listModText, 0, strlen($listModText) - 3);
							} else{
								$listModText .= "\n\n".$text['core_config_view']['setup'][33];
							}
							echo template::textarea('modulesPhp2',[
								'value' => $listModText
							]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col12">
							<?php
							$texte ='';
							// Tests des directives php
							$directives = array( 'allow_url_include', 'allow_url_fopen');
							foreach( $directives as $key=>$value){
								if( ini_get($value)) {
									$texte .= $text['core_config_view']['setup'][36].$value.' ON - ';
								}
								else{
									$texte .= $text['core_config_view']['setup'][36].$value.' OFF - ';
								}
							}
							// Tests des fonctions php
							$functions = array(  'fopen', 'file_get_contents', 'curl_version', 'stream_get_contents', 'datefmt_create');
							foreach( $functions as $key=>$value){
								if(function_exists($value)){
									$texte .= $text['core_config_view']['setup'][37].$value.' ON - ';
								}
								else{
									$texte .= $text['core_config_view']['setup'][37].$value.' OFF - ';
								}
							}
							echo template::textarea('directivesFunctionsPhp',[
								'value' => substr( $texte, 0, strlen($texte) - 3)
							]);

							?>
						</div>
					</div>
					<div class="row">
						<div class="col12">
							<?php // $infoModules[nom_module]['realName'], ['version'], ['update'], ['delete'], ['dataDirectory']
							$infoModules = helper::getModules();
							$listModDeltaText = $text['core_config_view']['setup'][34];
							foreach( $infoModules as $key=>$value){
								$listModDeltaText .= $key.' '.$infoModules[$key]['version'].' - ';
							}
							$listModDeltaText = substr( $listModDeltaText, 0, strlen($listModDeltaText) - 3);
							echo template::textarea('modulesDeltacms',[
								'value' => $listModDeltaText
							]); ?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col12">
						<div class="block">
							<div class="blockTitle"><?php echo $text['core_config_view']['setup'][38];?></div>
							<p> <?php echo $text['core_config_view']['setup'][39];?><a href="https://forum.deltacms.fr" target="_blank">https://forum.deltacms.fr</a> </p> 
							<p> <?php echo $text['core_config_view']['setup'][40];?> </p>
							<p> <?php echo $text['core_config_view']['setup'][41];?> </p>
							<div class="row">
								<div class="col2">
									<a href="javascript:void(0);" id="buttonHtmlToClipboard" name="buttonHtmlToClipboard" class="button"><?php echo $text['core_config_view']['setup'][35];?></a>	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var textConfirm = <?php echo '"'.$text['core_config_view']['setup'][42].$updateVersion.' ?"'; ?>;
</script>
