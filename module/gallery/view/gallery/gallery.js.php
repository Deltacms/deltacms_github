/**
 * This file is part of DeltaCMS.
 */

/**
 * Galerie d'image
 * SLB est activé pour tout le site
 */
var b = new SimpleLightbox('.galleryGalleryPicture', { 
	captionSelector: "self",
	captionType: "data",
	captionsData: "caption",
	closeText: "&times;"
});

$( document ).ready(function() {
	// Démarre en mode plein écran
	var fullscreen = <?php echo json_encode($this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'config', 'fullScreen'])); ?>;
	if ( fullscreen === true) {
		$('a#homePicture')[0].click();
	}
 });
