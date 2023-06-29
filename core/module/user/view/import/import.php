<?php echo template::formOpen('userImportForm');
// Lexique
include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');
?>
<div class="row">
    <div class="col2">
        <?php echo template::button('userImportBack', [
            'class' => 'buttonGrey',
            'href' => helper::baseUrl() . 'user',
            'ico' => 'left',
            'value' => $text['core_user_view']['import'][0]
        ]); ?>
    </div>
	<div class="col2">
		<?php echo template::button('userHelp', [
			'href' => 'https://doc.deltacms.fr/importation',
			'target' => '_blank',
			'ico' => 'help',
			'value' => $text['core_user_view']['import'][1],
			'class' => 'buttonHelp'
		]); ?>
	</div>
    <div class="col2 offset6">
		<?php echo template::submit('userImportSubmit', [
				'value' => $text['core_user_view']['import'][2]
			]); ?>
	</div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
        <div class="blockTitle"><?php echo $text['core_user_view']['import'][3]; ?></div>
            <div class="row">
                <div class="col6">
                      <?php echo template::file('userImportCSVFile', [
                            'label' => $text['core_user_view']['import'][4]
                      ]); ?>
                </div>
                <div class="col2">
					<?php echo template::select('userImportSeparator', $module::$separators, [
					'label' => $text['core_user_view']['import'][5]
					]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col12">
                    <?php echo template::checkbox('userImportNotification', true, $text['core_user_view']['import'][6], [
						'checked' => false
					]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo template::formClose(); ?>
<?php if ($module::$users): ?>
    <div class="row">
        <div class="col12 textAlignCenter">
        <?php echo template::table([1, 3, 3, 1, 1, 2, 1], $module::$users, [$text['core_user_view']['import'][7], $text['core_user_view']['import'][8], $text['core_user_view']['import'][9],$text['core_user_view']['import'][10], $text['core_user_view']['import'][11], $text['core_user_view']['import'][12], '']); ?>
        <?php echo template::ico('check'). $text['core_user_view']['import'][13]; echo template::ico('mail'). $text['core_user_view']['import'][14]; echo template::ico('cancel'). $text['core_user_view']['import'][15];?>
        </div>
    </div>
<?php  endif;?>
