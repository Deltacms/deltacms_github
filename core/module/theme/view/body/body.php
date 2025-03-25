<?php
// Lexique
include('./core/module/theme/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_theme.php');

echo template::formOpen('themeBodyForm'); ?>
<div class="row">
	<div class="col2">
		<?php echo template::button('themeBodyBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . 'theme',
			'ico' => 'left',
			'value' => $text['core_theme_view']['body'][0]
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::button('themeBodyHelp', [
			'href' => 'https://doc.deltacms.fr/personnalisation-de-l-arriere-plan',
			'target' => '_blank',
			'ico' => 'help',
			'value' => $text['core_theme_view']['body'][1],
			'class' => 'buttonHelp'
		]); ?>
	</div>
	<div class="col2 offset6">
		<?php echo template::submit('themeBodySubmit',[
			'value' => $text['core_theme_view']['body'][2]
		]); ?>
	</div>
</div>
<div class="row">
	<div class="col12">
		<div class="block">
			<div class="blockTitle"><?php echo $text['core_theme_view']['body'][3]; ?></div>
			<div class="row">
				<div class="col6 offset3">
					<?php echo template::text('themeBodyBackgroundColor', [
						'class' => 'colorPicker',
						'help' => $text['core_theme_view']['body'][4],
						'label' => $text['core_theme_view']['body'][5],
						'value' => $this->getData(['theme', 'body', 'backgroundColor'])
					]); ?>
				</div>
			</div>
<!-- déplacement scroll -->
		</div>
	</div>
</div>
<div class="row">
	<div class="col12">
		<div class="block">
			<div class="blockTitle"><?php echo $text['core_theme_view']['body'][9]; ?></div>
			<div class="row">
				<div class="col6 offset3">
					<?php
					$imageFile = file_exists(self::FILE_DIR.'source/'.$this->getData(['theme', 'body', 'image'])) ? $this->getData(['theme', 'body', 'image']) : "";
					echo template::file('themeBodyImage', [
						'help' => $text['core_theme_view']['body'][10],
						'label' => $text['core_theme_view']['body'][11],
						'type' => 1,
						'value' => $imageFile
					]); ?>
				</div>
			</div>
			<div id="themeBodyImageOptions" class="displayNone">
				<div class="row">
					<div class="col6">
						<?php echo template::select('themeBodyImageRepeat', $repeats, [
							'label' => $text['core_theme_view']['body'][12],
							'selected' => $this->getData(['theme', 'body', 'imageRepeat'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::select('themeBodyImagePosition', $imagePositions, [
							'label' => $text['core_theme_view']['body'][13],
							'selected' => $this->getData(['theme', 'body', 'imagePosition'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col6">
						<?php echo template::select('themeBodyImageAttachment', $attachments, [
							'label' => $text['core_theme_view']['body'][14],
							'selected' => $this->getData(['theme', 'body', 'imageAttachment'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::select('themeBodyImageSize', $bodySizes, [
							'label' => $text['core_theme_view']['body'][15],
							'selected' => $this->getData(['theme', 'body', 'imageSize'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo template::formClose(); ?>
