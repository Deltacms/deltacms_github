<!-- Agenda dans une div pour contrôler la taille-->

<div id="index_wrapper">
	<!--Affiche l'agenda-->
	<br><div id='calendar'> </div><br>
	<?php echo template::formOpen('index_events');?>
	<?php echo template::formClose();?>
</div>
<script data-deltacms="module">
	// Integer: largeur MAXI du diaporama, en pixels. Par exemple : 800, 920, 500
	var maxwidth=<?= $this->getData(['module', $this->getUrl(0),'config','maxiWidth']); ?>;
</script>
