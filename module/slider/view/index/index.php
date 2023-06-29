<?php 
// Lexique
include('./module/slider/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_slider.php');

/*
Création automatique du slider avec les images du dossier sélectionné en configuration du module
puis affichage du slider. 
*/


if($module::$galleries){


	foreach($module::$galleries as $galleryId => $gallery):	endforeach;
	
	if (count($module::$pictures) != 0){		
		?>
		<div id="wrapper">
		<div class="rslides_container">
		<?php if($module::$view_boutons == "slider1"){
			echo '<ul class="rslides" id="slider1">';
		}
		else{
			echo '<ul class="rslides" id="slider2">';
		}	
		foreach($module::$pictures as $picture => $legend):
			$href = $this->getData(['module', $this->getUrl(0), 'href', str_replace('.','',substr(strrchr( $picture, '/'), 1)) ]);
			$link = '';
			$endLink = '';
			if ($href != '' && $href != null){
				$link = '<a href="'.helper::baseUrl().$href.'">';
				$endLink = '</a>';
			}
			if ($legend != ''){
				echo  '<li>'.$link.'<img src="'.helper::baseUrl(false) . $picture.'" alt=""><span>'.$legend.'</span></li>'.$endLink;
			}
			else{
				echo  '<li>'.$link.'<img src="'.helper::baseUrl(false) . $picture.'" alt=""></li>'.$endLink;
			}
		endforeach;
		echo '</ul></div><p>&nbsp;</p></div>';	
	}
	else{
		echo template::speech($text['slider_view']['index'][0]);
	}
}
else{
	echo template::speech($text['slider_view']['index'][1]); 
}
?>
<!--Pour liaison entre variables php et javascript-->
<script>
	// Integer: largeur MAXI du diaporama, en pixels. Par exemple : 800, 920, 500
	var maxwidth=<?php echo $this->getData(['module', $this->getUrl(0), 'config','maxiWidth']); ?>;
	// Integer: Vitesse de transition entre 2 diapositives (fading) : de 500 à 3500
	var speed=<?php echo $this->getData(['module', $this->getUrl(0), 'config','fadingTime']); ?>;
	// Integer: Durée d'une diapositive en millisecondes (fading compris) : minimum speed +100
	var timeout=<?php echo $this->getData(['module', $this->getUrl(0), 'config','sliderTime']); ?>;
	// Boolean: visibilité des puces de navigation, true ou false
	var pager=<?php echo $this->getData(['module', $this->getUrl(0), 'config','pagerVisible']); ?>;
	//Visibilité de la légende
	var legendeVisibilite="<?php echo $this->getData(['module', $this->getUrl(0), 'config','visibiliteLegende']); ?>";
	//Position de la légende, "haut" ou "bas"
	var legendePosition="<?php echo $this->getData(['module', $this->getUrl(0), 'config','positionLegende']); ?>";
	//Temps d'apparition de la légende et des boutons
	var timeLegende="<?php echo $this->getData(['module', $this->getUrl(0), 'config','tempsApparition']); ?>";
	//Type de bouton
	var boutonType="<?php echo $this->getData(['module', $this->getUrl(0), 'config','typeBouton']); ?>";	
</script>



