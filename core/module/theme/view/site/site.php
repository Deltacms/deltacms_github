<?php
// Lexique
include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');

echo template::formOpen('themeFooterForm');
echo template::formOpen('themeSiteForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('themeSiteBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'theme',
				'ico' => 'left',
				'value' => $text['core_theme_view']['site'][0]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('themeSiteHelp', [
				'href' => 'https://doc.deltacms.fr/personnalisation-du-site',
				'target' => '_blank',
				'ico' => 'help',
				'value' => $text['core_theme_view']['site'][1],
				'class' => 'buttonHelp'
			]); ?>
		</div>
		<div class="col2 offset6">
			<?php echo template::submit('themeSiteSubmit',[
				'value' => $text['core_theme_view']['site'][2]
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_theme_view']['site'][3]; ?></div>
				<div class="row">
					<div class="col4">
						<?php echo template::select('themeSiteWidth', $siteWidths, [
							'label' => $text['core_theme_view']['site'][4],
							'help' => $text['core_theme_view']['site'][32],
							'selected' => $this->getData(['theme', 'site', 'width'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeSiteRadius', $radius, [
							'label' => $text['core_theme_view']['site'][5],
							'selected' => $this->getData(['theme', 'site', 'radius'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeSiteShadow', $shadows, [
							'label' => $text['core_theme_view']['site'][6],
							'selected' => $this->getData(['theme', 'site', 'shadow'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col6">
						<?php echo template::checkbox('themeSiteMargin',true, $text['core_theme_view']['site'][7], [
							'checked' => $this->getData(['theme', 'site', 'margin'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_theme_view']['site'][8]; ?></div>
				<div class="row">
					<div class="col8">
						<div class="row">
							<div class="col6">
								<?php echo template::text('themeSiteBackgroundColor', [
									'class' => 'colorPicker',
									'help' => $text['core_theme_view']['site'][9],
									'label' => $text['core_theme_view']['site'][10],
									'value' => $this->getData(['theme', 'site', 'backgroundColor'])
								]); ?>
							</div>
							<div class="col6">
								<?php echo template::text('themeTextTextColor', [
									'class' => 'colorPicker',
									'help' => $text['core_theme_view']['site'][9],
									'label' => $text['core_theme_view']['site'][11],
									'value' => $this->getData(['theme', 'text', 'textColor'])
								]); ?>
							</div>
						</div>
						<div class="row">
							<div class="col6">
								<?php echo template::text('themeTitleTextColor', [
									'class' => 'colorPicker',
									'help' => $text['core_theme_view']['site'][9],
									'label' => $text['core_theme_view']['site'][12],
									'value' => $this->getData(['theme', 'title', 'textColor'])
								]); ?>
							</div>
							<div class="col6">
								<?php echo template::text('themeTextLinkColor', [
									'class' => 'colorPicker',
									'help' => $text['core_theme_view']['site'][9],
									'label' => $text['core_theme_view']['site'][13],
									'value' => $this->getData(['theme', 'text', 'linkColor'])
								]); ?>
							</div>
						</div>
						<div class="row">
							<div class="col6">
								<?php echo template::text('themeBlockBackgroundColor', [
									'class' => 'colorPicker',
									'help' => $text['core_theme_view']['site'][14],
									'label' => $text['core_theme_view']['site'][15],
									'value' => $this->getData(['theme', 'block', 'backgroundColor'])
								]); ?>
							</div>
							<div class="col6">
								<?php echo template::text('themeBlockBorderColor', [
									'class' => 'colorPicker',
									'help' => $text['core_theme_view']['site'][14],
									'label' => $text['core_theme_view']['site'][16],
									'value' => $this->getData(['theme', 'block', 'borderColor'])
								]); ?>
							</div>
						</div>
						<!-- Plus -->
						<div class="row">
							<div class="col6">
								<?php echo template::select('themeBlockBorderRadius', $radius, [
									'label' => $text['core_theme_view']['site'][17],
									'selected' => $this->getData(['theme', 'block', 'blockBorderRadius'])
								]); ?>
							</div>
							<div class="col6">
								<?php echo template::select('themeBlockBorderShadow', $blockShadows, [
									'label' => $text['core_theme_view']['site'][18],
									'selected' => $this->getData(['theme', 'block', 'blockBorderShadow'])
								]); ?>
							</div>
						</div>
						<div class="row">
							<div class="col6">
								<?php echo template::text('themeBlockBackgroundTitleColor', [
									'class' => 'colorPicker',
									'help' => $text['core_theme_view']['site'][14],
									'label' => $text['core_theme_view']['site'][19],
									'value' => $this->getData(['theme', 'block', 'backgroundTitleColor'])
								]); ?>
							</div>
							<div class="col6">
								<?php echo template::text('themeButtonBackgroundColor', [
									'class' => 'colorPicker',
									'help' => $text['core_theme_view']['site'][9],
									'label' => $text['core_theme_view']['site'][20],
									'value' => $this->getData(['theme', 'button', 'backgroundColor'])
								]); ?>
							</div>
						</div>
						<!-- Fin -->
					</div>
					<div class="col4 bodybackground">
						<div class="bgPreview">
							<div class="row">
								<div class="col6">
                                    <h1 class="headerPreview"><?php echo $text['core_theme_view']['site'][21]; ?></h1>
                                    <h2 class="headerPreview"><?php echo $text['core_theme_view']['site'][22]; ?></h2>
                                </div>
                                <div class="col6">
                                    <?php echo template::button('themeSiteSubmitButtonPreview', [
                                        'class' => 'buttonSubmitPreview',
                                        'value' => $text['core_theme_view']['site'][23]
                                    ]); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col12">
                                    <div class="block preview">
                                        <div class="blockTitle preview"><?php echo $text['core_theme_view']['site'][24]; ?></div>										
										<p class="textPreview">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
										<p><a href="#" class="urlPreview">Lorem ipsum dolor sit amet.</a></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col6">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_theme_view']['site'][25]; ?></div>
				<div class="row">
					<div class="col6">
						<?php asort($module::$fonts);
						echo template::select('themeTextFont', $module::$fonts, [
							'label' => $text['core_theme_view']['site'][26],
							'selected' => $this->getData(['theme', 'text', 'font']),
							'fonts' => true
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::select('themeTextFontSize', $module::$siteFontSizes, [
							'label' => $text['core_theme_view']['site'][29],
							'help' => $text['core_theme_view']['site'][30],
							'selected' => $this->getData(['theme', 'text', 'fontSize'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_theme_view']['site'][31]; ?></div>
				<div class="row">
					<div class="col4">
						<?php	echo template::select('themeTitleFont', $module::$fonts, [
							'label' => $text['core_theme_view']['site'][26],
							'selected' => $this->getData(['theme', 'title', 'font']),
							'fonts' => true
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeTitleFontWeight', $fontWeights, [
							'label' => $text['core_theme_view']['site'][27],
							'selected' => $this->getData(['theme', 'title', 'fontWeight'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeTitleTextTransform', $textTransforms, [
							'label' => $text['core_theme_view']['site'][28],
							'selected' => $this->getData(['theme', 'title', 'textTransform'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
