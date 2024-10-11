<!-- version <?php echo $module::VERSION; ?> de l'album -->
<?php
// Lexique
$param = '';
include('./module/album/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_album.php');

if($module::$galleries):
$i = 1;
$galleriesNb = count($module::$galleries);
foreach($module::$galleries as $galleryId => $gallery):
if($i % 4 === 1):
?>
		<div class="row">
	<?php endif; ?>
			<div class="col3">
				<a href="<?php echo helper::baseUrl() . $this->getUrl(0); ?>/<?php echo $galleryId; ?>" class="galleryPicture">
					<figure class="album"><img src="<?php if ($this->getData(['module', $this->getUrl(0), $galleryId, 'config', 'homePicture']) === null ) {
					echo albumHelper::makeThumbnail($module::$firstPictures[$galleryId]); }
					else {
					echo albumHelper::makeThumbnail($this->getData(['module', $this->getUrl(0), $galleryId, 'config', 'directory']) . '/' . $this->getData(['module', $this->getUrl(0), $galleryId, 'config', 'homePicture']));
					}  ?>" alt="<?php echo $gallery['config']['name']; ?>">
				<figcaption><div class="galleryName"><?php echo $gallery['config']['name']; ?></div></figcaption></figure>
			</a>
		</div>
	<?php if($i % 4 === 0 OR $i === $galleriesNb): ?>
		</div>
	<?php
	endif;
	$i++;
	endforeach;
	else:
		$speechText = null === $this->getData(['module', $this->getUrl(0), 'config', 'texts', 'noAlbum'])? $text['album']['init'][2] : $this->getData(['module', $this->getUrl(0), 'config', 'texts', 'noAlbum']);
		echo template::speech( $speechText );
	endif;
	?>
