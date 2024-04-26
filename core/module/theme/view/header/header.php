<?php
// Lexique
include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');
// Passage de la langue d'administration à Tinymce et de la class utilisée par tinymce dans le body de l'iframe
?>
<script> var lang_admin = "<?php echo $lang_admin; ?>"; var bodyIframe = "editorWysiwygHeader"; </script>
<?php echo template::formOpen('themeHeaderForm'); ?>
<div class="row">
    <div class="col2">
        <?php echo template::button('themeHeaderBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'theme',
				'ico' => 'left',
				'value' => $text['core_theme_view']['header'][0]
			]); ?>
    </div>
    <div class="col2">
      <?php echo template::button('themeHeaderHelp', [
        'href' => 'https://doc.deltacms.fr/personnalisation-de-la-banniere',
        'target' => '_blank',
        'ico' => 'help',
        'value' => $text['core_theme_view']['header'][1],
        'class' => 'buttonHelp'
      ]); ?>
    </div>
    <div class="col2 offset4">
        <?php echo template::submit('themeHeaderSubmitPreview',[
			'value' => $text['core_theme_view']['header'][37],
			'ico' =>'eye',
			'class' => 'buttonPreview'
		]); ?>
    </div>
    <div class="col2">
        <?php echo template::submit('themeHeaderSubmit',[
			'value' => $text['core_theme_view']['header'][34]
		]); ?>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['header'][2]; ?></div>
            <div class="row">
                <div class="col4">
                    <?php echo template::select('themeHeaderPosition', $headerPositions, [
							'label' => $text['core_theme_view']['header'][3],
							'selected' => $this->getData(['theme', 'header', 'position'])
						]); ?>
                </div>
                <div class="col4">
                    <?php echo template::select('themeHeaderFeature', $headerFeatures, [
							'label' => $text['core_theme_view']['header'][4],
							'selected' => $this->getData(['theme', 'header', 'feature'])
						]); ?>
                </div>

                <div class="col4">
                    <?php echo template::select('themeHeaderHeight', $headerHeights, [
							'label' => $text['core_theme_view']['header'][5],
                            'selected' =>  $this->getData(['theme', 'header', 'heightSelect']),
                            'help' => $text['core_theme_view']['header'][6]
						]); ?>
                </div>
            </div>
            <div class="row">
               <div class="col4">
                    <div id="themeHeaderHomePage" class="displayNone">
                            <?php echo template::checkbox('themeHeaderHomePageOnly', true, $text['core_theme_view']['header'][36], [
                                    'checked' => $this->getData(['theme', 'header', 'homePageOnly'])
                                ]); ?>
                    </div>
                </div>
                <div class="col4">
                    <div id="themeHeaderSmallDisplay" class="displayNone">
                            <?php echo template::checkbox('themeHeaderTinyHidden', true, $text['core_theme_view']['header'][8], [
                                    'checked' => $this->getData(['theme', 'header', 'tinyHidden'])
                                ]); ?>
                    </div>
                </div>
                <div class="col4">
                    <div id="themeHeaderPositionOptions" class="displayNone">
                        <?php echo template::checkbox('themeHeaderMargin', true, $text['core_theme_view']['header'][9], [
                                'checked' => $this->getData(['theme', 'header', 'margin'])
                            ]); ?>
                    </div>
                </div>
            </div>

			<div class="row">
				<div class="col4">
                    <?php echo template::select('themeHeaderWide', $containerWides, [
							'label' => $text['core_theme_view']['header'][7],
							'selected' => $this->getData(['theme', 'header', 'wide'])
						]); ?>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row colorsContainer">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['header'][10]; ?></div>
            <div class="row">
                <div class="col6">
                    <?php echo template::text('themeHeaderBackgroundColor', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['header'][11],
							'label' => $text['core_theme_view']['header'][12],
							'value' => $this->getData(['theme', 'header', 'backgroundColor'])
						]); ?>
                </div>
                <div class="col6">
                    <?php echo template::text('themeHeaderTextColor', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['header'][13],
							'label' => $text['core_theme_view']['header'][14],
							'value' => $this->getData(['theme', 'header', 'textColor'])
						]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row wallpaperContainer">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['header'][15]; ?></div>
            <div class="row">
                <div class="col4">
                    <?php echo template::checkbox('themeHeaderTextHide', true, $text['core_theme_view']['header'][16], [
                            'checked' => $this->getData(['theme', 'header', 'textHide'])
                        ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::select('themeHeaderFont', $module::$fonts, [
							'label' => $text['core_theme_view']['header'][17],
							'selected' => $this->getData(['theme', 'header', 'font']),
							'fonts' => true
						]); ?>
                </div>
                <div class="col4">
                    <?php echo template::select('themeHeaderFontSize', $headerFontSizes, [
							'label' => $text['core_theme_view']['header'][18],
							'help' => $text['core_theme_view']['header'][21],
							'selected' => $this->getData(['theme', 'header', 'fontSize'])
						]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col4">
                    <?php echo template::select('themeHeaderFontWeight', $fontWeights, [
							'label' => $text['core_theme_view']['header'][19],
							'selected' => $this->getData(['theme', 'header', 'fontWeight'])
						]); ?>
                </div>
                <div class="col4">
                    <?php echo template::select('themeHeaderTextTransform', $textTransforms, [
							'label' => $text['core_theme_view']['header'][20],
							'selected' => $this->getData(['theme', 'header', 'textTransform'])
						]); ?>
                </div>
                <div class="col4">
                    <?php echo template::select('themeHeaderTextAlign', $aligns, [
							'label' => $text['core_theme_view']['header'][22],
							'selected' => $this->getData(['theme', 'header', 'textAlign'])
						]); ?>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row wallpaperContainer">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['header'][23]; ?></div>
            <div class="row">
                <div class="col12">
                    <?php
                        $imageFile = file_exists(self::FILE_DIR.'source/'.$this->getData(['theme', 'header', 'image'])) ?
                                $this->getData(['theme', 'header', 'image']) : "";
                        echo template::file('themeHeaderImage', [
                            'help' => $text['core_theme_view']['header'][24],
                            'label' => $text['core_theme_view']['header'][25],
                            'type' => 1,
                            'value' => $imageFile
                    ]); ?>
                </div>
            </div>
            <div id="themeHeaderImageOptions" class="displayNone">
                <div class="row">
                    <div class="col3">
                        <?php echo template::select('themeHeaderImageRepeat', $repeats, [
								'label' => $text['core_theme_view']['header'][26],
								'selected' => $this->getData(['theme', 'header', 'imageRepeat'])
							]); ?>
                    </div>
                    <div class="col3">
                        <?php echo template::select('themeHeaderImageContainer', $headerWide, [
                                'label' => $text['core_theme_view']['header'][27],
                                'selected' => $this->getData(['theme', 'header', 'imageContainer']),
                                'help' => $text['core_theme_view']['header'][28]
                            ]); ?>
                    </div>
                    <div class="col3">
                        <?php echo template::select('themeHeaderImagePosition', $imagePositions, [
								'label' => $text['core_theme_view']['header'][3],
								'selected' => $this->getData(['theme', 'header', 'imagePosition'])
							]); ?>
                    </div>
                    <div id="themeHeaderShow" class="col3">
                        <?php echo template::checkbox('themeHeaderlinkHomePage', true, $text['core_theme_view']['header'][29], [
                                'checked' => $this->getData(['theme', 'header', 'linkHomePage'])
                            ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col12 textAlignCenter">
                        <span id="themeHeaderImage">
                            <?php echo $text['core_theme_view']['header'][30]; ?><span id="themeHeaderImageWidth"></span><?php echo $text['core_theme_view']['header'][31]; ?><span id="themeHeaderImageHeight"></span><?php echo $text['core_theme_view']['header'][32]; ?><span id="themeHeaderImageRatio"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row featureContainer">
    <div class="col12">
        <div class="row">
            <div class="col12" style="margin-top: 90px">
                <?php echo template::textarea('themeHeaderText', [
                    'label' => '<div class="titleWysiwygContent">'.$text['core_theme_view']['header'][33].'</div>',
                    'class' => 'editorWysiwyg',
                    'value' => $this->getData(['theme', 'header', 'featureContent'])
                ]); ?>
            </div>
        </div>
    </div>
</div>
<div id="featureContent" class="displayNone">
    <?php echo $this->getData(['theme','header','featureContent']);?>
</div>

<div class="row swiperContainer">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['header'][38]; ?></div>
            <div class="row">
                <div class="col6">
					<?php echo template::select('themeHeaderDirectory', str_replace('site/file/source/','',$module::$listDirs), [
						'label' => 'Choisissez le dossier',
						'help' => 'Ce dossier contient les images de la bannière, l\'ordre de passage est alphanumérique (0...9a...z).',
						'selected' => array_search( $this->getData(['theme', 'header', 'swiperImagesDir']),$module::$listDirs )
					]);
					?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row swiperContainer">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['header'][39]; ?></div>
            <div class="row">
                <div class="col4">
					 <?php echo template::select('themeHeaderSwiperEffects', $swiperEffects, [
						'label' => $text['core_theme_view']['header'][40],
						'help' => $text['core_theme_view']['header'][41],
						'selected' => $this->getData(['theme', 'header', 'swiperEffects'])
					]); ?>
                </div>
                <div class="col4">
					 <?php echo template::select('themeHeaderSwiperTime', $swiperTime, [
						'label' => $text['core_theme_view']['header'][42],
						'help' => $text['core_theme_view']['header'][43],
						'selected' => $this->getData(['theme', 'header', 'swiperTime'])
					]); ?>
                </div>
                <div class="col4">
					 <?php echo template::select('themeHeaderSwiperTransition', $swiperTime, [
						'label' => $text['core_theme_view']['header'][44],
						'help' => $text['core_theme_view']['header'][45],
						'selected' => $this->getData(['theme', 'header', 'swiperTransition'])
					]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col4">
                    <?php echo template::checkbox('themeHeaderSwiperDirection', true, $text['core_theme_view']['header'][46], [
                            'checked' => $this->getData(['theme', 'header', 'swiperDirection'])
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo template::formClose(); ?>
<script>
	var textOption = <?php echo '"'.$text['core_theme_view']['header'][35].'"'; ?>;
</script>
