<?php
// Lexique
include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');

echo template::formOpen('themeManageForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('themeManageBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'theme',
				'ico' => 'left',
				'value' => $text['core_theme_view']['manage'][0]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('themeSiteHelp', [
				'href' => 'https://doc.deltacms.fr/gestion',
				'target' => '_blank',
				'ico' => 'help',
				'value' => $text['core_theme_view']['manage'][1],
				'class' => 'buttonHelp'
			]); ?>
		</div>
		<div class="col2 offset4">
			<?php echo template::button('configManageReset', [
				'class' => 'buttonRed',
				'href' => helper::baseUrl() . 'theme/reset/manage'  . '&csrf=' . $_SESSION['csrf'],
				'value' => $text['core_theme_view']['manage'][2],
				'ico' => 'cancel'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('themeImportSubmit', [
				'value' => $text['core_theme_view']['manage'][3]
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
			<div class="blockTitle"><?php echo $text['core_theme_view']['manage'][4]; ?></div>
				<div class="row">
					<div class="col6 offset3">
						<?php echo template::file('themeManageImport', [
								'label' => $text['core_theme_view']['manage'][5],
								'type' => 2
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col6">
			<div class="block">
			<div class="blockTitle"><?php echo $text['core_theme_view']['manage'][6]; ?><a href="<?php echo helper::baseUrl(false); ?>core/vendor/filemanager/dialog.php?fldr=theme&type=0&akey=<?php echo md5_file(self::DATA_DIR.'core.json'); ?>"  data-lity><?php echo $text['core_theme_view']['manage'][7]; ?></a><?php echo $text['core_theme_view']['manage'][8]; ?></div>
				<div class="row">
					<div class="col6">
						<?php echo template::submit('themeSaveTheme', [
							'class' => 'themeSave',
							'ico' => 'download-cloud',
							'value' => $text['core_theme_view']['manage'][9]
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::submit('themeSaveAdmin', [
							'class' => 'themeSave',
							'ico' => 'download-cloud',
							'value' => $text['core_theme_view']['manage'][10]
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col6 offset3">
						<?php echo template::text('themeSaveName', [
							'label' => $text['core_theme_view']['manage'][16],
							'value' => ''
						]); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="col6">
			<div class="block">
			<div class="blockTitle"><?php echo $text['core_theme_view']['manage'][11]; ?></div>
				<div class="row">
					<div class="col6">
						<?php echo template::submit('themeExportTheme', [
							'class' => 'themeSave',
							'ico' => 'download',
							'value' => $text['core_theme_view']['manage'][12]
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::submit('themeExportAdmin', [
							'class' => 'themeSave',
							'ico' => 'download',
							'value' => $text['core_theme_view']['manage'][13]
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col6 offset3">
						<?php echo template::text('themeExportName', [
							'label' => $text['core_theme_view']['manage'][16],
							'value' => ''
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
<script>
	var textConfirm = <?php echo '"'.$text['core_theme_view']['manage'][14].'"'; ?>;
	var textConfirm2 = <?php echo '"'.$text['core_theme_view']['manage'][15].'"'; ?>;
</script>
