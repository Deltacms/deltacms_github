<?php
// Lexique
include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');

echo template::formOpen('configAdminForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('configAdminBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'theme',
				'ico' => 'left',
				'value' => $text['core_theme_view']['admin'][0]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('themeSiteHelp', [
				'href' => 'https://doc.deltacms.fr/administration',
				'target' => '_blank',
				'ico' => 'help',
				'value' => $text['core_theme_view']['admin'][1],
				'class' => 'buttonHelp'
			]); ?>
		</div>
		<div class="col2 offset4">
			<?php echo template::button('configAdminReset', [
				'class' => 'buttonRed',
				'href' => helper::baseUrl() . 'theme/reset/admin' . '&csrf=' . $_SESSION['csrf'],
				'value' => $text['core_theme_view']['admin'][3],
				'ico' => 'cancel'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('configAdminSubmit',[
				'value' => $text['core_theme_view']['admin'][4],
				'ico' => 'check'
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
					<div class="blockTitle"><?php echo $text['core_theme_view']['admin'][5]; ?></div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('adminBackgroundColor', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['admin'][6],
							'label' => $text['core_theme_view']['admin'][8],
							'value' => $this->getData(['admin', 'backgroundColor'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('adminColorTitle', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['admin'][6],
							'label' => $text['core_theme_view']['admin'][9],
							'value' => $this->getData(['admin', 'colorTitle'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('adminColorText', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['admin'][6],
							'label' => $text['core_theme_view']['admin'][10],
							'value' => $this->getData(['admin', 'colorText'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('adminBackGroundBlockColor', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['admin'][7],
							'label' => $text['core_theme_view']['admin'][11],
							'value' => $this->getData(['admin', 'backgroundBlockColor'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('adminBorderBlockColor', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['admin'][6],
							'label' => $text['core_theme_view']['admin'][12],
							'value' => $this->getData(['admin', 'borderBlockColor'])
						]); ?>
					</div>
					<div class="col3 offset1">
						<?php echo template::text('adminColorHelp', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['admin'][6],
							'label' => $text['core_theme_view']['admin'][13],
							'value' => $this->getData(['admin', 'backgroundColorButtonHelp'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col3">
						<?php echo template::text('adminColorGrey', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['admin'][6],
							'label' => $text['core_theme_view']['admin'][14],
							'value' => $this->getData(['admin', 'backgroundColorButtonGrey'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::text('adminColorButton', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['admin'][6],
							'label' => $text['core_theme_view']['admin'][15],
							'value' => $this->getData(['admin', 'backgroundColorButton'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::text('adminColorRed', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['admin'][6],
							'label' => $text['core_theme_view']['admin'][16],
							'value' => $this->getData(['admin', 'backgroundColorButtonRed'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::text('adminColorGreen', [
							'class' => 'colorPicker',
							'help' => $text['core_theme_view']['admin'][6],
							'label' => $text['core_theme_view']['admin'][17],
							'value' => $this->getData(['admin', 'backgroundColorButtonGreen'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
					<div class="blockTitle"><?php echo $text['core_theme_view']['admin'][18]; ?></div>
					<div class="row">
						<div class="col4">
							<?php asort($module::$fonts); 
							echo template::select('adminFontText', $module::$fonts, [
								'label' => $text['core_theme_view']['admin'][19],
								'selected' => $this->getData(['admin', 'fontText']),
								'fonts' => true
							]); ?>
						</div>
						<div class="col4">
							<?php echo template::select('adminFontTextSize', $module::$siteFontSizes, [
								'label' => $text['core_theme_view']['admin'][20],
								'selected' => $this->getData(['admin', 'fontSize'])
							]); ?>
						</div>
						<div class="col4">
							<?php echo template::select('adminFontTitle', $module::$fonts, [
								'label' => $text['core_theme_view']['admin'][21],
								'selected' => $this->getData(['admin', 'fontTitle']),
								'fonts' => true
							]); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
<script>
	var textConfirm = <?php echo '"'.$text['core_theme_view']['admin'][22].'"'; ?>;
</script>
