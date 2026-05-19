/**
 * This file is part of DeltaCMS.
 * Album Photo /view/gallery
 */

 $(".galleryGalleryPicture").simpleLightbox({
	captionSelector: "self",
	captionType: "data",
	captionsData: "caption",
	closeText: "&times;"
});

/* Affecte la bordure des blocs à la class galleryGalleryPicture */
$(document).ready(function(){
	<?php if ( isset( $_SESSION['ACC_INVERTCOLOR'] ) && $_SESSION['ACC_INVERTCOLOR'] === true ) { ?>
		borderColor = "<?=helper::invertColor($this->getData(['theme', 'block', 'borderColor']))?>";
	<?php } else { ?>
		borderColor = "<?=$this->getData(['theme', 'block', 'borderColor'])?>";
	<?php }	?>
	borderRadius = "<?=$this->getData(['theme', 'block', 'blockBorderRadius'])?>";
	$(".galleryGalleryPicture").css("border","solid 1px");
	$(".galleryGalleryPicture").css("border-color", borderColor);
	$(".galleryGalleryPicture").css("border-radius", borderRadius);
});
