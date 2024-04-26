<?php
// Lexique
$param='';
include('./core/module/config/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_config.php');

echo template::formOpen('configForm');?>
<div class="row">
	<div class="col2">
		<?php echo template::button('configBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl(false),
			'ico' => 'home',
			'value' => $text['core_config_view']['index'][0]
		]); ?>
	</div>
    <div class="col2 ">
			<?php echo template::button('configHelp', [
				'class' => 'buttonHelp',
                'href' => 'https://doc.deltacms.fr/configuration-du-site',
                'target' => '_blank',
				'ico' => 'help',
				'value' => $text['core_config_view']['index'][1]
			]); ?>
		</div>
	<div class="col2 offset6">
		<?php echo template::submit('Submit', [ 
			'value' => $text['core_config_view']['index'][3]
		]); ?>
	</div>
</div>
<div class="row">
    <div class="col12">
        <div class="row textAlignCenter">
            <div class="col2">
                <?php echo template::button('configSetupButton', [
                    'value' => $text['core_config_view']['index'][2]
                ]); ?>
            </div>
            <div class="col2">
                <?php echo template::button('configLocaleButton', [
                    'value' => $text['core_config_view']['index'][4]
                ]); ?>
            </div>
            <div class="col2">
                <?php echo template::button('configSocialButton', [
                    'value' => $text['core_config_view']['index'][5]
                ]); ?>
            </div>
            <div class="col2">
                <?php echo template::button('configConnectButton', [
                    'value' => $text['core_config_view']['index'][6]
                ]); ?>
            </div>
            <div class="col2">
                <?php echo template::button('configNetworkButton', [
                    'value' => $text['core_config_view']['index'][7]
                ]); ?>
            </div>
			<div class="col2">
                <?php echo template::button('configScriptButton', [
                    'value' => $text['core_config_view']['index'][8]
                ]); ?>
            </div>
        </div>
    </div>
</div>


<?php include ('core/module/config/view/setup/setup.php') ?>
<?php include ('core/module/config/view/locale/locale.php') ?>
<?php include ('core/module/config/view/social/social.php') ?>
<?php include ('core/module/config/view/connect/connect.php') ?>
<?php include ('core/module/config/view/network/network.php') ?>
<?php include ('core/module/config/view/bodyheadscript/bodyheadscript.php') ?>
<?php echo template::formClose(); ?>