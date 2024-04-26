<?php
// Lexique
$param='';
include('./core/module/config/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_config.php');

echo template::formOpen('configScript'); ?>
    <div class="row">
        <div class="col2">
            <?php echo template::button('configManageBack', [
                'class' => 'buttonGrey',
                'href' => helper::baseUrl() . 'config',
                'ico' => 'left',
                'value' => $text['core_config_view']['script'][0]
            ]); ?>
        </div>
        <div class="col2 offset8">
            <?php echo template::submit('configManageSubmit',[
                'value' => $text['core_config_view']['script'][1],
                'ico' => 'check'
            ]); ?>
        </div>
    </div>
    <?php if ($this->geturl(2) === 'head'): ?>
    <div class="row">
        <div class="col12">
            <?php echo template::textarea('configScriptHead', [
                'value' => file_exists( self::DATA_DIR . 'head.inc.php') ? file_get_contents (self::DATA_DIR . 'head.inc.php') : '' ,
                'class' => 'editor'
            ]); ?>
        </div>
    </div>
    <?php endif ?>
    <?php if ($this->geturl(2) === 'body'): ?>
    <div class="row">
        <div class="col12">
            <?php echo template::textarea('configScriptBody', [
                'value' => file_exists( self::DATA_DIR . 'body.inc.php') ? file_get_contents (self::DATA_DIR . 'body.inc.php') : '' ,
                'class' => 'editor'
            ]); ?>
        </div>
    </div>
    <?php endif ?>
<?php echo template::formClose(); ?>