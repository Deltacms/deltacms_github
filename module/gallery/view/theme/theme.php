<?php
// Lexique
$param = "gallery_view";
include('./module/gallery/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_gallery.php');

echo template::formOpen('galleryThemeForm'); ?>

	<div class="row">
		<div class="col2">
			<?php echo template::button('galleryThemeBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'ico' => 'left',
				'value' => $text['gallery_view']['theme'][0]
			]); ?>
		</div>
		<div class="col2 offset8">
			<?php echo template::submit('galleryThemeBack',[
				'value' => $text['gallery_view']['theme'][1]
			]); ?>
		</div>
	</div>
    <div class="row">
        <div class="col12">
            <div class="block">
                <div class="blockTitle">
                    <?php
						echo $text['gallery_view']['theme'][2]; echo template::help($text['gallery_view']['theme'][3]);
                    ?>
                </div>
                <div class="row">
                    <div class="col3">
                        <?php echo template::select('galleryThemeThumbWidth', $galleryThemeSizeWidth, [
                            'label' => $text['gallery_view']['theme'][4],
                            'selected' => $this->getData(['module', $this->getUrl(0), 'theme','thumbWidth'])
                        ]); ?>
                    </div>
                    <div class="col3">
                        <?php echo template::select('galleryThemeThumbHeight', $galleryThemeSizeHeight, [
                            'label' => $text['gallery_view']['theme'][5],
                            'selected' => $this->getData(['module', $this->getUrl(0), 'theme','thumbHeight'])
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php echo template::select('galleryThemeThumbAlign', $galleryThemeFlexAlign, [
							'label' => $text['gallery_view']['theme'][6],
							'selected' => $this->getData(['module', $this->getUrl(0), 'theme','thumbAlign'])
						]); ?>
                    </div>
                    <div class="col2">
                        <?php echo template::select('galleryThemeThumbMargin', $galleryThemeMargin, [
                            'label' => $text['gallery_view']['theme'][7],
                            'selected' => $this->getData(['module', $this->getUrl(0), 'theme','thumbMargin'])
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col4">
                        <?php echo template::select('galleryThemeThumbBorder', $galleryThemeBorder, [
                            'label' => $text['gallery_view']['theme'][8],
                            'selected' => $this->getData(['module', $this->getUrl(0), 'theme','thumbBorder'])
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php echo template::text('galleryThemeThumbBorderColor', [
                            'class' => 'colorPicker',
                            'help' => $text['gallery_view']['theme'][9],
                            'label' => $text['gallery_view']['theme'][10],
                            'value' => $this->getData(['module', $this->getUrl(0), 'theme','thumbBorderColor'])
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php echo template::select('galleryThemeThumbRadius', $galleryThemeRadius, [
                            'label' => $text['gallery_view']['theme'][11],
                            'selected' => $this->getData(['module', $this->getUrl(0), 'theme','thumbRadius'])
                        ]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col4">
                        <?php echo template::select('galleryThemeThumbShadows', $galleryThemeShadows, [
                            'label' => $text['gallery_view']['theme'][12],
                            'selected' => $this->getData(['module', $this->getUrl(0), 'theme','thumbShadows'])
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php echo template::text('galleryThemeThumbShadowsColor', [
                            'class' => 'colorPicker',
                            'help' => $text['gallery_view']['theme'][9],
                            'label' => $text['gallery_view']['theme'][14],
                            'value' => $this->getData(['module', $this->getUrl(0), 'theme','thumbShadowsColor'])
                        ]); ?>
                    </div>
                    <div class="col4">
                        <?php echo template::select('galleryThemeThumbOpacity', $galleryThemeOpacity, [
                            'label' => $text['gallery_view']['theme'][15],
                            'selected' => $this->getData(['module', $this->getUrl(0), 'theme','thumbOpacity'])
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col12">
            <div class="block">
            <div class="blockTitle">
                <?php
					echo $text['gallery_view']['theme'][17];
                    echo template::help($text['gallery_view']['theme'][3]);
				?>
            </div>
            <div class="row">
                <div class="col3">
                    <?php echo template::text('galleryThemeLegendTextColor', [
                        'class' => 'colorPicker',
                        'help' => $text['gallery_view']['theme'][9],
                        'label' => $text['gallery_view']['theme'][19],
                        'value' => $this->getData(['module', $this->getUrl(0), 'theme','legendTextColor'])
                    ]); ?>
                </div>
                <div class="col3">
                    <?php echo template::text('galleryThemeLegendBgColor', [
                        'class' => 'colorPicker',
                        'help' => $text['gallery_view']['theme'][9],
                        'label' => $text['gallery_view']['theme'][21],
                        'value' => $this->getData(['module', $this->getUrl(0), 'theme','legendBgColor'])
                    ]); ?>
                </div>
                <div class="col3">
                    <?php echo template::select('galleryThemeLegendHeight', $galleryThemeLegendHeight, [
                        'label' => $text['gallery_view']['theme'][22],
                        'selected' => $this->getData(['module', $this->getUrl(0), 'theme','legendHeight'])
                    ]); ?>
                </div>
                <div class="col3">
                    <?php echo template::select('galleryThemeLegendAlign', $galleryThemeAlign, [
                        'label' => $text['gallery_view']['theme'][23],
                        'selected' => $this->getData(['module', $this->getUrl(0), 'theme','legendAlign'])
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

<?php echo template::formClose(); ?>
<div class="row">
    <div class="col12">
        <div class="moduleVersion"><?php echo $text['gallery_view']['theme'][24]; echo $module::VERSION; ?>
        </div>
    </div>
</div>
