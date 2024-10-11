<?php
// Lexique
include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');

// drapeau pour la langue d'origine ou la langue en traduction rédigée
if( $this->getInput('DELTA_I18N_SITE') === '' || $this->getInput('DELTA_I18N_SITE')=== null || $this->getInput('DELTA_I18N_SITE') === 'base'){
	$flag = $this->getData(['config', 'i18n', 'langBase']);
}
else{
	$flag = $this->getInput('DELTA_I18N_SITE');
}

echo template::formOpen('themeMenuForm'); ?>
<div class="row">
    <div class="col2">
        <?php echo template::button('themeMenuBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'theme',
				'ico' => 'left',
				'value' => $text['core_theme_view']['menu'][0]
			]); ?>
    </div>
    <div class="col2">
      <?php echo template::button('themeMenuHelp', [
        'href' => 'https://doc.deltacms.fr/personnalisation-du-menu',
        'target' => '_blank',
        'ico' => 'help',
        'value' => $text['core_theme_view']['menu'][1],
        'class' => 'buttonHelp'
      ]); ?>
    </div>
	<div class="col2 offset4 submitPreview">
        <?php echo template::submit('themeMenuSubmitPreview',[
			'value' => $text['core_theme_view']['header'][37],
			'ico' =>'eye',
			'class' => 'buttonPreview'
		]); ?>
    </div>
    <div class="col2 offsetPreview">
        <?php echo template::submit('themeMenuSubmit',[
			'value' => $text['core_theme_view']['menu'][2]
		]); ?>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['menu'][3]; ?></div>
            <div class="row">
               <div class="col4">
                    <?php
                    if( $this->getData(['theme', 'header', 'position']) == "site"){
                    	echo template::select('themeMenuPosition', $menuPositionsSite, [
                            'label' => $text['core_theme_view']['menu'][4],
							'help' =>  $text['core_theme_view']['menu'][59],
                            'selected' => $this->getData(['theme', 'menu', 'position'])
                        ]);
					} elseif( $this->getData(['theme', 'header', 'position']) == "body"){
						echo template::select('themeMenuPosition', $menuPositionsBody, [
							'label' => $text['core_theme_view']['menu'][4],
							'help' =>  $text['core_theme_view']['menu'][59],
							'selected' => $this->getData(['theme', 'menu', 'position'])
						]);					
                    }else{
						echo template::select('themeMenuPosition', $menuPositionsHide, [
							'label' => $text['core_theme_view']['menu'][4],
							'help' =>  $text['core_theme_view']['menu'][59],
							'selected' => $this->getData(['theme', 'menu', 'position'])
						]);
                     }?>
                </div>
				<div class="col4">
						<?php echo template::select('themeMenuHeight', $menuHeights, [
						'label' => $text['core_theme_view']['menu'][8],
						'selected' => $this->getData(['theme', 'menu', 'height'])
					]); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['menu'][60]; ?></div>
            <div class="row">
               <div class="col4">
                    <?php echo template::select('themeMenuRadius', $menuRadius, [
                    'label' => $text['core_theme_view']['menu'][6],
                    'selected' => $this->getData(['theme', 'menu', 'radius']),
                    'help' => $text['core_theme_view']['menu'][7]
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::select('themeMenuTextAlign', $aligns, [
                    'label' => $text['core_theme_view']['menu'][9],
                    'selected' => $this->getData(['theme', 'menu', 'textAlign'])
                ]); ?>
                </div>
                <div class="col4 themeMenuWideWrapper">
                    <?php echo template::select('themeMenuWide', $containerWides, [
							'label' =>  $text['core_theme_view']['menu'][5],
							'help' =>  $text['core_theme_view']['menu'][40],
							'selected' => $this->getData(['theme', 'menu', 'wide'])
						]); ?>
                </div>
            </div>
		   <div class="row">
				<div class="col4">
					<div id="themeMenuPositionOptions" class="displayNone">
						<?php echo template::checkbox('themeMenuMargin', true, $text['core_theme_view']['menu'][10], [
								'checked' => $this->getData(['theme', 'menu', 'margin'])
							]); ?>
					</div>
					<div id="themeMenuPositionFixed" class="displayNone">
						<?php echo template::checkbox('themeMenuFixed', true, $text['core_theme_view']['menu'][11], [
								'checked' => $this->getData(['theme', 'menu', 'fixed'])
							]); ?>
					</div>
				</div>
               <div class="col4">
                    <?php echo template::select('themeMenuMinWidthTab', $minWidthTab, [
                    'label' => $text['core_theme_view']['menu'][37],
					'help' => $text['core_theme_view']['menu'][38],
                    'selected' => $this->getData(['theme', 'menu', 'minWidthTab'])
                ]); ?>
                </div>
				<div class="col4" style="padding:30px 0 0 10px;">
					<?php echo template::checkbox('themeMenuMinWidthParentOrAll', true, $text['core_theme_view']['menu'][39], [
							'checked' => $this->getData(['theme', 'menu', 'minWidthParentOrAll'])
					]); ?>
				</div>
			</div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
        <div class="blockTitle"><?php echo $text['core_theme_view']['menu'][12]; ?></div>
            <div class="row">
                <div class="col3">
                        <?php echo template::checkbox('themeMenuLoginLink', true, $text['core_theme_view']['menu'][13], [
                                'checked' => $this->getData(['theme', 'menu', 'loginLink'])
                            ]); ?>
                </div>
                <div class="col3">
                        <?php echo template::checkbox('themeMenuMemberBar', true, $text['core_theme_view']['menu'][14], [
                                'checked' =>  $this->getData(['theme', 'menu', 'memberBar']),
                                'help' => $text['core_theme_view']['menu'][15]
                        ]); ?>
                </div>
                <div class="col3">
                        <?php echo template::checkbox('themeMenuInvertColor', true, $text['core_theme_view']['menu'][61], [
                                'checked' =>  $this->getData(['theme', 'menu', 'invertColor']),
                                'help' => $text['core_theme_view']['menu'][62]
                        ]); ?>
                </div>
                <div class="col3">
                        <?php echo template::checkbox('themeMenuChangeFontSize', true, $text['core_theme_view']['menu'][63], [
                                'checked' =>  $this->getData(['theme', 'menu', 'changeFontSize']),
                                'help' => $text['core_theme_view']['menu'][64]
                        ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['menu'][20]; ?></div>
            <div class="row">
                <div class="col4">
                    <?php echo template::text('themeMenuTextColor', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['menu'][21],
							'label' => $text['core_theme_view']['menu'][22],
							'value' => $this->getData(['theme', 'menu', 'textColor'])
						]); ?>
                </div>
                <div class="col4">
                    <?php echo template::text('themeMenuBackgroundColor', [
                            'class' => 'colorPicker',
                            'help' => $text['core_theme_view']['menu'][23],
                            'label' => $text['core_theme_view']['menu'][24],
                            'value' => $this->getData(['theme', 'menu', 'backgroundColor'])
                        ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::text('themeMenuBackgroundColorSub', [
                            'class' => 'colorPicker',
                            'help' => $text['core_theme_view']['menu'][23],
                            'label' => $text['core_theme_view']['menu'][25],
                            'value' => $this->getData(['theme', 'menu', 'backgroundColorSub'])
                        ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col4">
                    <?php echo template::text('themeMenuActiveTextColor', [
                            'class' => 'colorPicker',
                            'help' => $text['core_theme_view']['menu'][23],
                            'label' => $text['core_theme_view']['menu'][26],
                            'value' => $this->getData(['theme', 'menu', 'activeTextColor'])
                        ]); ?>
                </div>
                <div class="col4 verticalAlignBottom">
                    <?php
                        echo template::checkbox('themeMenuActiveColorAuto', true, $text['core_theme_view']['menu'][36], [
                        'checked' => $this->getData(['theme', 'menu', 'activeColorAuto']),
                        'help' => $text['core_theme_view']['menu'][27]
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::text('themeMenuActiveColor', [
                            'class' => 'colorPicker',
                            'help' => $text['core_theme_view']['menu'][28],
                            'label' => $text['core_theme_view']['menu'][29],
                            'value' => $this->getData(['theme', 'menu', 'activeColor'])
                        ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['menu'][41]; ?></div>
			<div class="row">
               <div class="col3">
                        <?php echo template::checkbox('themeMenuBurgerFixed', true, $text['core_theme_view']['menu'][42], [
                                'checked' => $this->getData(['theme', 'menu', 'burgerFixed']),
								'help' => $text['core_theme_view']['menu'][56]
                         ]); ?>
                </div>
               <div class="col3">
                        <?php echo template::checkbox('themeMenuBurgerOverlay', true, $text['core_theme_view']['menu'][57], [
                                'checked' => $this->getData(['theme', 'menu', 'burgerOverlay']),
								'help' => $text['core_theme_view']['menu'][58]
                         ]); ?>
                </div>
			    <div class="col4 offset2">
                        <?php echo template::select('themeMenuBurgerContent', $burgerContent, [
								'label' => $text['core_theme_view']['menu'][16],
                                'selected' => $this->getData(['theme', 'menu', 'burgerContent']),
                                'help' => $text['core_theme_view']['menu'][17]
                            ]); ?>
                </div>	
				
			</div>
			<div id="themeMenuBurgerTitle" class="row <?php if( $this->getData(['theme', 'menu', 'burgerContent']) !== 'title') echo ' displayNone';?>">
				<div class="col6">
					<?php echo template::text('themeMenuBurgerTextColor', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['menu'][21],
							'label' => $text['core_theme_view']['menu'][43],
							'value' => $this->getData(['theme', 'menu', 'burgerTextColor'])
						]); ?>
				</div>
				<div class="col6">
					<?php echo template::select('themeMenuBurgerFontSize', $menuBurgerFontSizes, [
								'label' => $text['core_theme_view']['menu'][32],
								'help' => $text['core_theme_view']['menu'][33],
								'selected' => $this->getData(['theme', 'menu', 'burgerFontSize'])
							]); ?>
				</div>
			</div>
			<div id="themeMenuBurgerLogoId1" class="row <?php if( $this->getData(['theme', 'menu', 'burgerContent']) !== 'oneIcon' 
						&&  $this->getData(['theme', 'menu', 'burgerContent']) !== 'twoIcon' ) echo ' displayNone';?>">
				<div class="col6">
					<?php
					  $imageFile = file_exists(self::FILE_DIR.'source/'.$this->getData(['theme', 'menu', 'burgerIcon1'])) ?
						  $this->getData(['theme', 'menu', 'burgerIcon1']) : "";
					  echo template::file('themeMenuBurgerIcon1', [
						'help' => $text['core_theme_view']['menu'][51],
						'label' => $text['core_theme_view']['menu'][50],
						'type' => 1,
						'value' => $imageFile
					]); ?>
				</div>
				<div class="col6">
					<?php echo template::select('themeMenuBurgerLeftIconLink', $module::$pageList,[
							'selected' => $this->getData(['locale', 'menuBurger','burgerLeftIconLink']),
							'label' => $text['core_theme_view']['menu'][52] .' '. template::flag($flag, '20px'),
							'help' => $text['core_theme_view']['menu'][53]
					]); ?>
				</div>
           	</div>
			<div id="themeMenuBurgerLogoId2" class="row <?php if( $this->getData(['theme', 'menu', 'burgerContent']) !== 'twoIcon') echo ' displayNone';?>">
				<div class="col6">
					<?php
					  $imageFile = file_exists(self::FILE_DIR.'source/'.$this->getData(['theme', 'menu', 'burgerIcon2'])) ?
						  $this->getData(['theme', 'menu', 'burgerIcon2']) : "";
					  echo template::file('themeMenuBurgerIcon2', [
						'help' => $text['core_theme_view']['menu'][55],
						'label' => $text['core_theme_view']['menu'][54],
						'type' => 1,
						'value' => $imageFile
					]); ?>
				</div>
				<div class="col6">
					<?php echo template::select('themeMenuBurgerCenterIconLink', $module::$pageList,[
							'selected' => $this->getData(['locale', 'menuBurger','burgerCenterIconLink']),
							'label' => $text['core_theme_view']['menu'][52] .' '. template::flag($flag, '20px'),
							'help' => $text['core_theme_view']['menu'][53]
					]); ?>
				</div>
           	</div>
            <div class="row">
                <div class="col4">
                    <?php echo template::text('themeMenuBurgerBannerColor', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['menu'][44],
							'label' => $text['core_theme_view']['menu'][45],
							'value' => $this->getData(['theme', 'menu', 'burgerBannerColor'])
						]); ?>
                </div>
                <div class="col4">
                    <?php echo template::text('themeMenuBurgerIconColor', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['menu'][48],
							'label' => $text['core_theme_view']['menu'][49],
							'value' => $this->getData(['theme', 'menu', 'burgerIconColor'])
						]); ?>
                </div>
                <div class="col4">
                    <?php echo template::text('themeMenuBurgerIconBgColor', [
                            'class' => 'colorPicker',
                            'help' => $text['core_theme_view']['menu'][46],
                            'label' => $text['core_theme_view']['menu'][47],
                            'value' => $this->getData(['theme', 'menu', 'burgerIconBgColor'])
                        ]); ?>
                </div>
            </div>			
            <div class="row">
                <div class="col4">
                    <?php echo template::text('themeMenuBurgerTextMenuColor', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['menu'][21],
							'label' => $text['core_theme_view']['menu'][22],
							'value' => $this->getData(['theme', 'menu', 'burgerTextMenuColor'])
						]); ?>
                </div>
                <div class="col4">
                    <?php echo template::text('themeMenuBurgerBackgroundColor', [
                            'class' => 'colorPicker',
                            'help' => $text['core_theme_view']['menu'][23],
                            'label' => $text['core_theme_view']['menu'][24],
                            'value' => $this->getData(['theme', 'menu', 'burgerBackgroundColor'])
                        ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::text('themeMenuBurgerBackgroundColorSub', [
                            'class' => 'colorPicker',
                            'help' => $text['core_theme_view']['menu'][23],
                            'label' => $text['core_theme_view']['menu'][25],
                            'value' => $this->getData(['theme', 'menu', 'burgerBackgroundColorSub'])
                        ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col4">
                    <?php echo template::text('themeMenuBurgerActiveTextColor', [
                            'class' => 'colorPicker',
                            'help' => $text['core_theme_view']['menu'][23],
                            'label' => $text['core_theme_view']['menu'][26],
                            'value' => $this->getData(['theme', 'menu', 'burgerActiveTextColor'])
                        ]); ?>
                </div>
                <div class="col4 verticalAlignBottom">
                    <?php
                        echo template::checkbox('themeMenuBurgerActiveColorAuto', true, $text['core_theme_view']['menu'][36], [
                        'checked' => $this->getData(['theme', 'menu', 'burgerActiveColorAuto']),
                        'help' => $text['core_theme_view']['menu'][27]
                    ]); ?>
                </div>
                <div class="col4">
                    <?php echo template::text('themeMenuBurgerActiveColor', [
                            'class' => 'colorPicker',
                            'help' => $text['core_theme_view']['menu'][28],
                            'label' => $text['core_theme_view']['menu'][29],
                            'value' => $this->getData(['theme', 'menu', 'burgerActiveColor'])
                        ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col12">
        <div class="block">
            <div class="blockTitle"><?php echo $text['core_theme_view']['menu'][30]; ?></div>
            <div class="row">
                <div class="col6">
                    <?php echo template::select('themeMenuFont', $module::$fonts, [
								'label' => $text['core_theme_view']['menu'][31],
								'selected' => $this->getData(['theme', 'menu', 'font']),
                                'fonts' => true
							]); ?>
                </div>
                <div class="col6">
                    <?php echo template::select('themeMenuFontSize', $menuFontSizes, [
								'label' => $text['core_theme_view']['menu'][32],
								'help' => $text['core_theme_view']['menu'][33],
								'selected' => $this->getData(['theme', 'menu', 'fontSize'])
							]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col6">
                    <?php echo template::select('themeMenuFontWeight', $fontWeights, [
							'label' => $text['core_theme_view']['menu'][34],
							'selected' => $this->getData(['theme', 'menu', 'fontWeight'])
						]); ?>
                </div>
                <div class="col6">
                    <?php echo template::select('themeMenuTextTransform', $textTransforms, [
							'label' => $text['core_theme_view']['menu'][35],
							'selected' => $this->getData(['theme', 'menu', 'textTransform'])
						]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo template::formClose(); ?>
