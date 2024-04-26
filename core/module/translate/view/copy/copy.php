<?php echo template::formOpen('translateFormCopy');
// Lexique
include('./core/module/translate/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_translate.php');

// drapeau pour la langue d'origine ou la langue en traduction rédigée
if( $this->getInput('DELTA_I18N_SITE') === '' || $this->getInput('DELTA_I18N_SITE')=== null || $this->getInput('DELTA_I18N_SITE') === 'base'){
	$flag = $this->getData(['config', 'i18n', 'langBase']);
}
else{
	$flag = $this->getInput('DELTA_I18N_SITE');
}
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
                <div class="col6 copyAll">
                    <?php echo template::select('translateFormCopySource', $module::$languagesInstalled, [
                        'label' => $text['core_translate_view']['copy'][4]
                        ]); ?>
                </div>
                <div class="col6 pagesList">
				<?php 
				asort($module::$pagesList);
				echo template::select('translateCopyPage', $module::$pagesList, [
						'label' => $text['core_translate_view']['copy'][7].template::flag($flag, '20px'),
						'selected' => '',
						'help' =>  $text['core_translate_view']['copy'][8],
						'ksort' => false
				]); ?>
                </div>
                <div class="col6">
                    <?php echo template::select('translateFormCopyTarget', $module::$languagesTarget, [
                        'label' => $text['core_translate_view']['copy'][5],
						'selected' => $this->getData([ 'config', 'i18n', 'CopyTarget'])
                        ]); ?>
                </div>
            </div>
			<div class="row">
                <div class="col3">
					<?php echo template::checkbox('translateCopyAllPages', true, $text['core_translate_view']['copy'][6], [
							'checked' => ''
					]); ?>
                </div>
               <div class="col4 offset1 pagesList">
					<?php echo template::checkbox('translateCopyBarAuto', true, $text['core_translate_view']['copy'][9], [
							'checked' => '',
							'help' => $text['core_translate_view']['copy'][10]
					]); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo template::formClose(); ?>
