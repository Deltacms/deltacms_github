<?php
// Lexique
$param = '';
include('./module/album/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_album.php');
// drapeau pour la langue d'origine ou la langue en traduction rédigée
if( $this->getInput('DELTA_I18N_SITE') === '' || $this->getInput('DELTA_I18N_SITE')=== null || $this->getInput('DELTA_I18N_SITE') === 'base'){
	$flag = $this->getData(['config', 'i18n', 'langBase']);
}
else{
	$flag = $this->getInput('DELTA_I18N_SITE');
}

echo template::formOpen('galleryConfigForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('galleryConfigBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),
				'ico' => 'left',
				'value' => $text['album_view']['config'][0]
			]); ?>
		</div>
		<div class="col2 inset8">
			<?php echo template::button('albumIndexHelp', [
				'class' => 'buttonHelp',
				'ico' => 'help',
				'value' => $text['album_view']['config'][10]
			]); ?>
		</div>
		<div class="col2 offset6 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone'; ?> ">
			<?php echo template::button('albumConfigTexts', [
				'href' => helper::baseUrl() . $this->getUrl(0) . '/texts',
				'ico' => 'pencil',
				'value' => $text['album_view']['config'][11].' '.template::flag($flag, '20px')
			]); ?>
		</div>
	</div>
	<!-- Aide à propos de la configuration de album, view config -->
	<div class="helpDisplayContent">
		<?php echo file_get_contents( $text['album_view']['config'][9]) ;?>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['album_view']['config'][2]; ?></div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('galleryConfigName', [
							'label' => $text['album_view']['config'][3]
						]); ?>
					</div>
					<div class="col5">
						<?php echo template::hidden('galleryConfigDirectoryOld', [
							'noDirty' => true // Désactivé à cause des modifications en ajax
						]); ?>
						<?php echo template::select('galleryConfigDirectory', [], [
							'label' => $text['album_view']['config'][4],
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
		<div class="blockTitle"><?php echo $text['album_view']['config'][5]; ?></div>
	<?php if($module::$galleries): ?>
			<?php echo template::table([1, 4, 5, 1, 1], $module::$galleries, ['',$text['album_view']['config'][3], $text['album_view']['config'][4], '', ''], ['id' => 'galleryTable'],$module::$galleriesId); ?>
	<?php echo template::hidden('galleryConfigFilterResponse'); ?>
	<?php else: ?>
				<?php echo template::speech($text['album_view']['config'][7]); ?>
	<?php endif; ?>
		</div>
	<div class="moduleVersion">
		<?php echo $text['album_view']['config'][8]; echo $module::VERSION; ?>
	</div>
</div>
<script>
	var textConfirm = <?php echo '"'.$text['album_view']['config'][6].'"'; ?>;
</script>
