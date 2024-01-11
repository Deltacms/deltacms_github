/* Affecte la bordure des blocs à la class galleryPicture */
$(document).ready(function(){
	borderColor = "<?=$this->getData(['theme', 'block', 'borderColor'])?>";
	borderRadius = "<?=$this->getdata(['theme', 'block', 'blockBorderRadius'])?>";
	textColor = "<?=$this->getData(['theme', 'text', 'textColor'])?>";

	$(".galleryPicture").css("border","solid 1px");
	$(".galleryPicture").css("border-color", borderColor);
	$(".galleryPicture").css("border-radius", borderRadius);
	$(".galleryName").css("color", textColor);
});
