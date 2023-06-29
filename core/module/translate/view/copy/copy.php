<?php echo template::formOpen('translateFormCopy');
// Lexique
include('./core/module/translate/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_translate.php');
?>
<div class="row">
    <div class="col2">
        <?php echo template::button('translateFormCopyBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'translate',
            'ico' => 'left',
            'value' => $text['core_translate_view']['copy'][0]
        ]); ?>
    </div>
	<div class="col2">
		<?php echo template::button('translateHelp', [
			'href' => 'https://doc.deltacms.fr/utilitaire-de-copie',
			'target' => '_blank',
			'ico' => 'help',
			'value' => $text['core_translate_view']['copy'][1],
			'class' => 'buttonHelp'
		]); ?>
	</div>
    <div class="col2 offset6">
        <?php echo template::submit('translateFormCopySubmit', [
			'value'=> $text['core_translate_view']['copy'][2]
		]); ?>
    </div>
</div>
<div class="row">
   <div class="col12">
        <div class="block">
        <div class="blockTitle"><?php echo $text['core_translate_view']['copy'][3]; ?></div>
            <div class="row">
                <div class="col6">
                    <?php echo template::select('translateFormCopySource', $module::$languagesInstalled, [
                        'label' => $text['core_translate_view']['copy'][4]
                        ]); ?>
                </div>
                <div class="col6">
                    <?php echo template::select('translateFormCopyTarget', $module::$languagesTarget, [
                        'label' => $text['core_translate_view']['copy'][5]
                        ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo template::formClose(); ?>
