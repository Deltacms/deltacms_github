<?php
// Lexique
$param = 'blog_view';
include('./module/album/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_album.php');

// drapeau pour la langue d'origine ou la langue en traduction rédigée
if( $this->getInput('DELTA_I18N_SITE') === '' || $this->getInput('DELTA_I18N_SITE')=== null || $this->getInput('DELTA_I18N_SITE') === 'base'){
	$flag = $this->getData(['config', 'i18n', 'langBase']);
}
else{
	$flag = $this->getInput('DELTA_I18N_SITE');
}
?>
<?php echo template::formOpen('albumTexts'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('albumTextsBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0). '/config',
				'ico' => 'left',
				'value' => $text['album_view']['texts'][0]
			]); ?>
		</div>
		<div class="col2 offset8">
			<?php echo template::submit('albumTextsSubmit',[
				'value' => $text['album_view']['texts'][1]
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['album_view']['texts'][2].' '.template::flag($flag, '20px'); ?></div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('albumTextsBackButton', [
							'label' => $text['album_view']['texts'][3],
							'value' => $this->getData(['module', $this->getUrl(0), 'config', 'texts', 'backButton'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('albumTextsGeolocation', [
							'label' => $text['album_view']['texts'][4],
							'value' => $this->getData(['module', $this->getUrl(0), 'config', 'texts', 'geolocation'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('albumTextsNoAlbum', [
							'label' => $text['album_view']['texts'][5],
							'value' => $this->getData(['module', $this->getUrl(0), 'config', 'texts', 'noAlbum'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
<div class="moduleVersion"><?php echo $text['album_view']['texts'][6]; ?>
	<?php echo $module::VERSION; ?>
</div>

