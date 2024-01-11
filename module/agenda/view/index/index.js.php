/**
 * This file is part of DeltaCMS.
 **/
 
 $.ajaxSetup({
    cache: false
 });
 
 $(document).ready(function() {

	//Fullcalendar : instanciation, initialisations
	<?php $listeLocale = 'af, ar, bg, bs, ca, cs, da, de, el, en, es, et, eu, fa, fi, fr, gl, he, hi, hr, hu, id, is, it, ja, ka, kk, ko, lb, lt, lv, mk, ms, nb, nl, nn, pl, pt, ro, ru, sk, sl ,sq, sr, sv, th, tr, uk, vi, zh';
	$valid_locale = $this->getData(['config', 'i18n', 'langBase']) ;
	if( isset( $_SESSION['langFrontEnd']) && isset( $_SESSION['translationType']) && $_SESSION['translationType'] === 'site' ) $valid_locale =  $_SESSION['langFrontEnd'];
	if( strpos( $listeLocale, $valid_locale ) === false ) $valid_locale = $this->getData(['config', 'i18n', 'langAdmin']);
	?>
	var calendarEl = document.getElementById('calendar');
	var calendar = new FullCalendar.Calendar(calendarEl, {
		header: {
		  left:   'dayGridMonth,dayGridWeek',
		  center: 'title',
		  right:  'today,prev,next'
		},
		titleFormat: {
			month: 'long',
			year: 'numeric'
	    },
	   	columnHeaderFormat: {
			weekday: 'long'
		},
		views: {
			dayGridWeek: {
				titleFormat: { month: 'long', day: '2-digit' }
			}
		},
		plugins: [ 'dayGrid', 'interaction' ],
		locale : '<?php echo $valid_locale ;?>',
		defaultView: '<?php echo $this->getData(['module', $this->getUrl(0), 'vue', 'vueagenda']) ;?>',
		defaultDate: '<?php echo $this->getData(['module', $this->getUrl(0), 'vue', 'debagenda']) ;?>',
		selectable: true,
		editable: true,
		//afficher les évènements à partir d'un fichier JSON
		events : '<?php echo $module::DATAMODULE.'data/'.$this->getUrl(0); ?>'+'_affiche/events.json?n='+'<?php echo uniqid(); ?>',
		//créer un évènement
		dateClick: function(info) {
			  window.open('<?php echo helper::baseUrl() . $this->getUrl(0); ?>'+ '/da:'+ info.dateStr + 'vue:' + info.view.type + 'deb:' + calendar.formatIso(info.view.currentStart),'_self');			  
		},
		//Lire, modifier, supprimer un évènement
		eventClick: function(info) {
			  window.open('<?php echo helper::baseUrl() . $this->getUrl(0); ?>'+'/id:'+ info.event.id + 'vue:' + info.view.type + 'deb:' + calendar.formatIso(info.view.currentStart),'_self');
		}
	});

	//Déclaration de la fonction wrapper pour déterminer la largeur du div qui contient l'agenda et le bouton gérer : index_wrapper
	$.wrapper = function(){
		// Adaptation de la largeur du wrapper en fonction de la largeur de la page client et de la largeur du site
		// 10000 pour la sélection 100%
		if(maxwidth != 10000){
			var wclient = document.body.clientWidth,
				largeur_pour_cent,
				largeur,
				wsection = getComputedStyle(site).width,
				wcalcul;	
				
			// 20 pour les margin du body / html, 40 pour le padding intérieur dans section			
			wcalcul = wsection.replace('px','')-40;
			largeur_pour_cent = Math.floor(100*(maxwidth/wcalcul));
			if(largeur_pour_cent > 100) { largeur_pour_cent=100;}
			largeur=largeur_pour_cent.toString() + "%";
			$("#index_wrapper").css('width',largeur);
		}
		else
		{
			$("#index_wrapper").css('width',"100%");
		}
		//La taille du wrapper étant défini on peut l'afficher
		$("#index_wrapper").css('visibility', "visible");
	};
 
	$.wrapper();
	calendar.render();
	
	$(window).resize(function(){
		$.wrapper();
		calendar.render();
	});
});




		