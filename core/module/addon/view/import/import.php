<?php
// Lexique
include('./core/module/addon/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_addon.php');

echo template::formOpen('addonImportForm'); ?>
<div class="row">
    <div class="col2">
        <?php echo template::button('addonImportBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'addon',
            'ico' => 'left',
            'value' => $text['core_addon_view']['import'][0]
        ]); ?>
    </div>
    <div class="col2 offset8">
        <?php echo template::submit('addonImportSubmit', [
            'value' => $text['core_addon_view']['import'][1]
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
        <div class="blockTitle"><?php echo $text['core_addon_view']['import'][3]; ?></div>
            <div class="row">
                <div class="col6 offset3">
                    <?php echo template::file('addonImportFile', [
                            'label' => $text['core_addon_view']['import'][2],
                            'type' => 2
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
