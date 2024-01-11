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
	borderColor = "<?=$this->getData(['theme', 'block', 'borderColor'])?>";
	borderRadius = "<?=$this->getdata(['theme', 'block', 'blockBorderRadius'])?>";
	textColor = "<?=$this->getData(['theme', 'text', 'textColor'])?>";
	linkColor = "<?=$this->getData(['theme', 'text', 'linkColor'])?>";

	$(".galleryGalleryPicture").css("border","solid 1px");
	$(".galleryGalleryPicture").css("border-color", borderColor);
	$(".galleryGalleryPicture").css("border-radius", borderRadius);
	$(".galleryGalleryName").css("color", textColor);
	$(".picResized").css("color", linkColor);
});
