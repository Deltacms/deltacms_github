<?php
// Lexique
$param = '';
include('./module/gallery/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_gallery.php');

echo template::formOpen('galleryConfigForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('galleryConfigBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),
				'ico' => 'left',
				'value' => $text['gallery_view']['config'][0]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('galleryIndexHelp', [
				'class' => 'buttonHelp',
				'ico' => 'help',
				'value' => $text['gallery_view']['config'][10]
			]); ?>
		</div>
		<div class="col2 offset6 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone'; ?> ">
			<?php echo template::button('galleryConfigBack', [
				'href' => helper::baseUrl() . $this->getUrl(0) . '/theme/' . $_SESSION['csrf'],
				'value' => template::ico('brush','right') . $text['gallery_view']['config'][1],
			]); ?>
		</div>
	</div>
	<!-- Aide à propos de la configuration de gallery, view config -->
	<div class="helpDisplayContent">
		<?php echo file_get_contents( $text['gallery_view']['config'][11]) ;?>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['gallery_view']['config'][2]; ?></div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('galleryConfigName', [
							'label' => $text['gallery_view']['config'][3]
						]); ?>
					</div>
					<div class="col5">
						<?php echo template::hidden('galleryConfigDirectoryOld', [
							'noDirty' => true // Désactivé à cause des modifications en ajax
						]); ?>
						<?php echo template::select('galleryConfigDirectory', [], [
							'label' => $text['gallery_view']['config'][4],
							'noDirty' => true // Désactivé à cause des modifications en ajax
						]); ?>
					</div>
					<div class="col1 verticalAlignBottom">
						<?php echo template::submit('galleryConfigSubmit', [
							'ico' => '',
							'value' => template::ico('plus'),
							'class' => 'gallerySubmit'
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
<div class="row">
	<div class="col12">
		<div class="block">
		<div class="blockTitle"><?php echo $text['gallery_view']['config'][5]; ?></div>
			<?php if($module::$galleries): ?>
			<?php echo template::table([1, 4, 5, 1, 1], $module::$galleries, ['',$text['gallery_view']['config'][3], $text['gallery_view']['config'][6], '', ''], ['id' => 'galleryTable'],$module::$galleriesId); ?>
			<?php echo template::hidden('galleryConfigFilterResponse'); ?>
			<?php else: ?>
				<?php echo template::speech($text['gallery_view']['config'][7]); ?>
			<?php endif; ?>
	</div>
	<div class="moduleVersion">
		<?php echo $text['gallery_view']['config'][8]; echo $module::VERSION; ?>
	</div>
</div>
<script>
	var textConfirm = <?php echo '"'.$text['gallery_view']['config'][9].'"'; ?>;
</script>
