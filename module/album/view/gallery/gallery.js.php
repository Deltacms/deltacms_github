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
	<?php if( isset( $_COOKIE['DELTA_COOKIE_INVERTCOLOR'] ) && $_COOKIE['DELTA_COOKIE_INVERTCOLOR'] === 'true' ) {?>
		borderColor = "<?php echo helper::invertColor($this->getData(['theme', 'block', 'borderColor'])); ?>";
		textColor = "<?php echo helper::invertColor($this->getData(['theme', 'text', 'textColor']));?>";
		linkColor = "<?php echo helper::invertColor($this->getData(['theme', 'text', 'linkColor']));?>";
	<?php } else { ?>
		borderColor = "<?php echo $this->getData(['theme', 'block', 'borderColor']); ?>";
		textColor = "<?php echo $this->getData(['theme', 'text', 'textColor']);?>";
		linkColor = "<?php echo $this->getData(['theme', 'text', 'linkColor']);?>";
	<?php }	?>
	borderRadius = "<?=$this->getData(['theme', 'block', 'blockBorderRadius'])?>";
	$(".galleryGalleryPicture").css("border","solid 1px");
	$(".galleryGalleryPicture").css("border-color", borderColor);
	$(".galleryGalleryPicture").css("border-radius", borderRadius);
	$(".galleryGalleryName").css("color", textColor);
	$(".picResized").css("color", linkColor);
});
