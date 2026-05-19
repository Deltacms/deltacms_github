/* Affecte la bordure des blocs à la class galleryPicture */
$(document).ready(function(){
	<?php if ( isset( $_SESSION['ACC_INVERTCOLOR'] ) && $_SESSION['ACC_INVERTCOLOR'] === true ) { ?>
		borderColor = "<?=helper::invertColor($this->getData(['theme', 'block', 'borderColor']))?>";
	<?php } else { ?>
		borderColor = "<?=$this->getData(['theme', 'block', 'borderColor'])?>";
	<?php }	?>
	borderRadius = "<?=$this->getData(['theme', 'block', 'blockBorderRadius'])?>";
	$(".galleryPicture").css("border","solid 1px");
	$(".galleryPicture").css("border-color", borderColor);
	$(".galleryPicture").css("border-radius", borderRadius);
});
