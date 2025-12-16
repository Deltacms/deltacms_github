<?php
// Lexique
$param = '';
include('./module/album/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_album.php');

$i = 1;
$picturesNb = count($module::$pictures);
foreach($module::$pictures as $picture => $legend):
// détermination des photos redimensionnées et originales
$photo = basename($picture);
$url_photo = dirname($picture);
$original = str_replace('_t960','',$photo);
$urloriginal = $url_photo.'/backup/'.strtolower($original);
$existoriginal = strpos($photo, 't960.') && file_exists($urloriginal);
$urlback = (isset($urloriginal)) ? $urloriginal : 0;
if (file_exists($urloriginal)) {
$get_location = albumHelper::gps_exif($urloriginal);
}
else {
$get_location = albumHelper::gps_exif($picture);
}
clearstatcache();
?>
<?php if($i % 6 === 1): ?>
<div class="row">
<?php endif; ?>
	<div class="col2 gallery">
		<figure class="album"><a class="galleryGalleryPicture" href="<?=$picture?>" data-caption="<?=$legend?>"><img src="<?=albumHelper::makeThumbnail($picture)?>" alt="<?=$legend?>"></a>
		<?php
		if ($existoriginal): ?>
		<figcaption>
			<div class="galleryGalleryName"><a rel="data-lity" href="<?=$urlback?>" data-tippy-content="image originale">
		<?php else: ?>
		<figcaption>
			<div class="galleryGalleryName">
		<?php endif;
		// Affichage de la légende,
		if (!empty($legend)):
			$shortenedLegend = helper::subword($legend, 0, 30);
		if ( strlen($shortenedLegend) < strlen($legend) ) $legend = $shortenedLegend.'...';
			echo $legend;
			// ou, nettoyage et affichage du nom des images
			else:
			$separe = ['_','-','t960'];
			$picname = str_replace($separe, ' ', pathinfo($photo, PATHINFO_FILENAME));
			$shortenedPicname = helper::subword($picname, 0, 30);
		if ( strlen($shortenedPicname) < strlen($picname) ) $picname = $shortenedPicname.'...';
			echo $picname;
		endif;
		if ($existoriginal) echo '</a>';
		?></div>
			</figcaption>
		</figure>
	<?php
	// ajout du marqueur aux images contenant des données exif gps
	$data = isset($get_location) ? $get_location : NULL;
	$lis = explode('¤',$data ?? '');
	if ( ! isset($lis[1])) { $lis[1] = null; }
	else {
	$altitude = '';
	if ( (isset($lis[2])) && (is_int($lis[2]) !== false) && ($lis[2] > 0) ) {
	$alt = $lis[2];
	}
	$exif_data = "lat=".$lis[0]."&lon=".$lis[1]."&alt=".$lis[2]."&zoom=15";
	?>
	<div class="osm"><a href="module/album/plugins/map.php?<?=$exif_data?>" rel="data-lity" title="<?=$this->getData(['module', $this->getUrl(0), 'config', 'texts', 'geolocation'])?>"><img src="module/album/plugins/leaflet/images/marker-icon.png" style="width: 20px; height: auto;" alt="GPS"></a></div>
	<?php } ?>
	</div>
	<?php if($i % 6 === 0 OR $i === $picturesNb): ?>
</div>
	<?php
	endif;
	$i++;
	endforeach;
	?>
<div class="row back">
	<div class="col2">
		<?php echo template::button('galleryGalleryBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . $this->getUrl(0),
			'ico' => 'left',
			'value' => $this->getData(['module', $this->getUrl(0), 'config', 'texts', 'backButton'])
		]); ?>
	</div>
</div>
