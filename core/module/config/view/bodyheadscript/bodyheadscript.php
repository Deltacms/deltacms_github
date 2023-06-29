<?php
// Lexique
include('./core/module/config/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_config.php');
?>
<div id="scriptContainer">
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['bodyheadscript'][0]; ?>
					<span id="specialeHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/scripts" target="_blank">
								<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col3 offset3 verticalAlignBottom">
						<?php echo template::button('socialScriptHead', [
							'href' => helper::baseUrl() . 'config/script/head',
							'value' => $text['core_config_view']['bodyheadscript'][1],
							'ico' => 'pencil'
						]); ?>
					</div>
					<div class="col3 verticalAlignBottom">
						<?php echo template::button('socialScriptBody', [
							'href' => helper::baseUrl() . 'config/script/body',
							'value' => $text['core_config_view']['bodyheadscript'][2],
							'ico' => 'pencil'
					]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
