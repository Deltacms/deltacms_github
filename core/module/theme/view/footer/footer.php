<?php
// Lexique
include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');

// Passage de la langue d'administration à Tinymce
?>
<script>
	var lang_admin = "<?php echo $lang_admin ?>";
</script>
<?php
// Inclusion de tinymce
echo '<script src="' . helper::baseUrl(false) . 'core/vendor/tinymce/tinymce.min.js' . '"></script>';
echo '<script src="' . helper::baseUrl(false) . 'core/vendor/tinymce/init.js' . '"></script>';
echo '<link rel="stylesheet" href="' . helper::baseUrl(false) . 'core/vendor/tinymce/init.css' . '">';
echo template::formOpen('themeFooterForm');
?>
<div class="row">
    <div class="col2">
        <?php echo template::button('themeFooterBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'theme',
				'ico' => 'left',
				'value' => $text['core_theme_view']['footer'][0]
			]); ?>
    </div>
    <div class="col2">
      <?php echo template::button('themeFooterHelp', [
        'href' => 'https://doc.deltacms.fr/personnalisation-du-pied-de-page',
        'target' => '_blank',
        'ico' => 'help',
        'value' => $text['core_theme_view']['footer'][1],
        'class' => 'buttonHelp'
      ]); ?>
    </div>
    <div class="col2 offset6">
        <?php echo template::submit('themeFooterSubmit',[
			'value' => $text['core_theme_view']['footer'][2]
		]); ?>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['footer'][3]; ?></div>
            <div class="row">
                <div class="col6">
                    <?php echo template::select('themeFooterPosition', $footerPositions, [
                            'label' => $text['core_theme_view']['footer'][4],
                            'selected' => $this->getData(['theme', 'footer', 'position'])
                        ]); ?>
                </div>
                <div class="col6">
                    <?php echo template::select('themeFooterHeight', $footerHeights, [
                            'label' => $text['core_theme_view']['footer'][5],
                            'selected' => $this->getData(['theme', 'footer', 'height'])
                        ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['footer'][6]; ?></div>
            <div class="row">
                <div class="col6">
                    <?php echo template::text('themeFooterTextColor', [
                        'class' => 'colorPicker',
                        'label' => $text['core_theme_view']['footer'][7],
                        'value' => $this->getData(['theme', 'footer', 'textColor'])
                    ]); ?>
                </div>
                <div class="col6">
                    <?php echo template::text('themeFooterBackgroundColor', [
                        'class' => 'colorPicker',
                        'label' => $text['core_theme_view']['footer'][8],
                        'value' => $this->getData(['theme', 'footer', 'backgroundColor']),
                        'help'  => $text['core_theme_view']['footer'][9]
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['footer'][10]; ?></div>
            <div class="row">
                <div class="col3">
                    <?php echo template::checkbox('themefooterDisplayCopyright', true, $text['core_theme_view']['footer'][11], [
                            'checked' => $this->getData(['theme', 'footer','displayCopyright']),
                            'help' => $text['core_theme_view']['footer'][12]
                        ]); ?>
                </div>
                <div class="col3">
                    <?php echo template::checkbox('themefooterDisplayVersion', true, $text['core_theme_view']['footer'][13], [
                            'checked' => $this->getData(['theme', 'footer','displayVersion']),
                            'help' => $text['core_theme_view']['footer'][14]
                        ]); ?>
                </div>
                <div class="col3">
                    <?php echo template::checkbox('themefooterDisplaySiteMap', true, $text['core_theme_view']['footer'][15], [
                            'checked' => $this->getData(['theme', 'footer', 'displaySiteMap'])
                        ]); ?>
                </div>
                <div class="col3">
                    <?php echo template::checkbox('themefooterDisplayCookie', true, $text['core_theme_view']['footer'][16], [
                            'checked' => $this->getData(['config', 'cookieConsent']) === true ? $this->getData(['theme', 'footer', 'displayCookie']) : false,
                            'help' => $text['core_theme_view']['footer'][17],
                            'disabled' => !$this->getData(['config', 'cookieConsent'])
                        ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col3">
                    <?php echo template::checkbox('themeFooterDisplayWhois', true, $text['core_theme_view']['footer'][47], [
                            'checked' => $this->getData(['theme', 'footer', 'displayWhois']),
                            'help' => $text['core_theme_view']['footer'][48]
                        ]); ?>
                </div>			
                <div class="col3">
                    <?php echo template::checkbox('themeFooterLoginLink', true, $text['core_theme_view']['footer'][18], [
                            'checked' => $this->getData(['theme', 'footer', 'loginLink']),
                            'help' => $text['core_theme_view']['footer'][19]
                        ]); ?>
                </div>
                <div class="col3">
                    <?php echo template::checkbox('themeFooterDisplayMemberBar', true, $text['core_theme_view']['footer'][20], [
                        'checked' =>  $this->getData(['theme', 'footer', 'displayMemberBar']),
                        'help' => $text['core_theme_view']['footer'][21]
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col3">
                    <?php echo template::checkbox('themeFooterDisplayLegal', true, $text['core_theme_view']['footer'][22], [
                            'checked' => $this->getData(['locale', 'legalPageId']) === 'none' ? false : $this->getData(['theme', 'footer', 'displayLegal']),
                            'disabled' => $this->getData(['locale', 'legalPageId']) === 'none' ? true : false,
                            'help' => $text['core_theme_view']['footer'][23]
                    ]); ?>
                </div>
                <div class="col3">
					<?php // drapeau pour la langue d'origine ou la langue en traduction rédigée
					$flag = 'site';
					if( $this->getInput('DELTA_I18N_SITE') === 'base') $flag = $this->getData(['config', 'i18n', 'langBase']); ?>
                    <?php echo template::select('configLegalPageId', array_merge(['none' => $text['core_theme_view']['footer'][24]] , helper::arrayCollumn($module::$pagesList, 'title', 'SORT_ASC') ) , [
                        'label' => $text['core_theme_view']['footer'][25] . template::flag($flag, '20px'),
                        'selected' => $this->getData(['locale', 'legalPageId'])
                    ]); ?>
                </div>

                <div class="col3">
                    <?php echo template::checkbox('themeFooterDisplaySearch', true, $text['core_theme_view']['footer'][26], [
                            'checked' => $this->getData(['locale', 'searchPageId']) === 'none' ? false : $this->getData(['theme', 'footer', 'displaySearch']),
                            'disabled' => $this->getData(['locale', 'searchPageId']) === 'none' ? true : false,
                            'help' => $text['core_theme_view']['footer'][27]
                        ]); ?>
                </div>
                <div class="col3">
                    <?php echo template::select('configSearchPageId', array_merge(['none' => $text['core_theme_view']['footer'][24]] , helper::arrayCollumn($module::$pagesList, 'title', 'SORT_ASC') ) , [
                        'label' => $text['core_theme_view']['footer'][28] . template::flag($flag, '20px'),
                        'selected' => $this->getData(['locale', 'searchPageId']),
                        'help' => $text['core_theme_view']['footer'][29]
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col12">
        <?php echo template::textarea('themeFooterText', [
                'label' => '<div class="titleWysiwygContent">'.$text['core_theme_view']['footer'][45].'</div>',
                'value' => $this->getData(['theme', 'footer', 'text']),
                'class' => 'editorWysiwyg'
            ]); ?>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['footer'][30]; ?></div>
            <div class="row">
                <div class="col3">
                    <?php echo template::select('themeFooterFont', $module::$fonts, [
							'label' => $text['core_theme_view']['footer'][31],
							'selected' => $this->getData(['theme', 'footer', 'font']),
							'fonts' => true
						]); ?>
                </div>
                <div class="col3">
                    <?php echo template::select('themeFooterFontSize', $footerFontSizes, [
							'label' => $text['core_theme_view']['footer'][32],
							'help' => $text['core_theme_view']['footer'][33],
							'selected' => $this->getData(['theme', 'footer', 'fontSize'])
						]); ?>
                </div>
                <div class="col3">
                    <?php echo template::select('themeFooterFontWeight', $fontWeights, [
							'label' => $text['core_theme_view']['footer'][34],
							'selected' => $this->getData(['theme', 'footer', 'fontWeight'])
						]); ?>
                </div>
                <div class="col3">
                    <?php echo template::select('themeFooterTextTransform', $textTransforms, [
							'label' => $text['core_theme_view']['footer'][35],
							'selected' => $this->getData(['theme', 'footer', 'textTransform'])
						]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['footer'][36]; ?></div>
            <div class="row">
                <div class="col4">
                    <?php $footerBlockPosition =  is_null($this->getData(['theme', 'footer', 'template'])) ? $footerblocks[3] : $footerblocks [$this->getData(['theme', 'footer', 'template'])] ;?>
                    <?php echo template::select('themeFooterTemplate', $footerTemplate, [
                            'label' => $text['core_theme_view']['footer'][37],
                            'selected' => is_null($this->getData(['theme', 'footer', 'template'])) ? 4 : $this->getData(['theme', 'footer', 'template'])
                        ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col4">
                    <p><strong><?php echo $text['core_theme_view']['footer'][38]; ?></strong></p>
                    <div class="row">
                        <div class="col12">
                            <?php echo template::select('themeFooterTextPosition', $footerBlockPosition, [
                                    'label' => $text['core_theme_view']['footer'][39],
                                    'selected' => $this->getData(['theme', 'footer', 'textPosition']),
                                    'class' => 'themeFooterContent'
                                ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col12">
                            <?php echo template::select('themeFooterTextAlign', $aligns, [
                                    'label' => $text['core_theme_view']['footer'][40],
                                    'selected' => $this->getData(['theme', 'footer', 'textAlign'])
                                ]); ?>
                        </div>
                    </div>
                </div>
                <div class="col4">
                    <p><strong><?php echo $text['core_theme_view']['footer'][41]; ?></strong></p>
                    <div class="row">
                        <div class="col12">
                            <?php echo template::select('themeFooterSocialsPosition', $footerBlockPosition, [
                                    'label' => $text['core_theme_view']['footer'][39],
                                    'selected' => $this->getData(['theme', 'footer', 'socialsPosition']),
                                    'class' => 'themeFooterContent'
                                ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col12">
                            <?php echo template::select('themeFooterSocialsAlign', $aligns, [
                                    'label' => $text['core_theme_view']['footer'][40],
                                    'selected' => $this->getData(['theme', 'footer', 'socialsAlign'])
                                ]); ?>
                        </div>
                    </div>
                </div>
                <div class="col4">
                    <p><strong><?php echo $text['core_theme_view']['footer'][42]; ?></strong></p>
                    <div class="row">
                        <div class="col12">
                            <?php echo template::select('themeFooterCopyrightPosition', $footerBlockPosition, [
                                    'label' => $text['core_theme_view']['footer'][39],
                                    'selected' => $this->getData(['theme', 'footer', 'copyrightPosition']),
                                    'class' => 'themeFooterContent'
                                ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col12">
                            <?php echo template::select('themeFooterCopyrightAlign', $aligns, [
                                    'label' => $text['core_theme_view']['footer'][40],
                                    'selected' => $this->getData(['theme', 'footer', 'copyrightAlign'])
                                ]); ?>
                        </div>
                    </div>
                </div>
                <div class="col6">
                    <div id="themeFooterPositionOptions">
                        <?php echo template::checkbox('themeFooterMargin', true, $text['core_theme_view']['footer'][43], [
                                'checked' => $this->getData(['theme', 'footer', 'margin'])
                            ]); ?>
                    </div>
                </div>
                <div class="col6">
                    <div id="themeFooterPositionFixed" class="displayNone">
                        <?php echo template::checkbox('themeFooterFixed', true, $text['core_theme_view']['footer'][44], [
							'checked' => $this->getData(['theme', 'footer', 'fixed'])
						]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo template::formClose(); ?>
<script>
	var newOptions = <?php echo $text['core_theme_view']['footer'][46]; ?>;
</script>
