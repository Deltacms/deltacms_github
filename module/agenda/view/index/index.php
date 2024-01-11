<!-- Agenda dans une div pour contrôler la taille-->
<style>
	#index_wrapper {
		--grid_color : <?php echo $this->getData(['module', $this->getUrl(0),'config', 'gridColor']); ?>;
		margin:0 auto;
	}
</style>
<div id="index_wrapper">
	<!--Affiche l'agenda-->
	<br>
	<div id='calendar'> </div>
	<br>

	<?php echo template::formOpen('index_events'); ?>

	<?php echo template::formClose();?>
</div>
<script>
	// Integer: largeur MAXI du diaporama, en pixels. Par exemple : 800, 920, 500
	var maxwidth=<?php echo $this->getData(['module', $this->getUrl(0),'config','maxiWidth']); ?>;
</script>
