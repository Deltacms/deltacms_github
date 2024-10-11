/* Affecte la bordure des blocs à la class galleryPicture */
$(document).ready(function(){
	<?php if( isset( $_COOKIE['DELTA_COOKIE_INVERTCOLOR'] ) && $_COOKIE['DELTA_COOKIE_INVERTCOLOR'] === 'true' ) {?>
		borderColor = "<?php echo helper::invertColor($this->getData(['theme', 'block', 'borderColor'])); ?>";
		textColor = "<?php echo helper::invertColor($this->getData(['theme', 'text', 'textColor']));?>";	
	<?php } else { ?>
		borderColor = "<?php echo $this->getData(['theme', 'block', 'borderColor']); ?>";
		textColor = "<?php echo $this->getData(['theme', 'text', 'textColor']);?>";		
	<?php }	?>
	borderRadius = "<?=$this->getdata(['theme', 'block', 'blockBorderRadius'])?>";
	$(".galleryPicture").css("border","solid 1px");
	$(".galleryPicture").css("border-color", borderColor);
	$(".galleryPicture").css("border-radius", borderRadius);
	$(".galleryName").css("color", textColor);
});
