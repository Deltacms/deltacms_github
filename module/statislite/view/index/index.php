<link rel="stylesheet" href="./module/statislite/view/index/index.css">
<?php
// Lexique
include('./module/statislite/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_statislite.php');

/*
 * Affichage des résultats
*/

/*
* Paramètres réglés en configuration du module
*/
// Temps minimum à passer sur le site en secondes pour valider une visite
$timeVisiteMini = $this->getData(['module', $this->getUrl(0), 'config', 'timeVisiteMini' ]);
// Affichage graphique : nombre de pages vues à afficher en commençant par la plus fréquente, de 0 à toutes
$nbaffipagesvues = $this->getData(['module', $this->getUrl(0), 'config', 'nbaffipagesvues']);
// Affichage graphique : nombre de langues à afficher en commençant par la plus fréquente, de 0 à toutes
$nbaffilangues = $this->getData(['module', $this->getUrl(0), 'config', 'nbaffilangues']);
// Affichage graphique : nombre de navigateurs à afficher en commençant par le plus fréquent, de 0 à toutes
$nbaffinavigateurs = $this->getData(['module', $this->getUrl(0), 'config', 'nbaffinavigateurs']);
// Affichage graphique : nombre de systèmes d'exploitation à afficher en commençant par le plus fréquent, de 0 à tous
$nbaffise = $this->getData(['module', $this->getUrl(0), 'config', 'nbaffise']);
// Affichage graphique : nombre de pays à afficher en commençant par le plus fréquent, de 0 à tous
$nbaffipays = $this->getData(['module', $this->getUrl(0), 'config', 'nbaffipays']);
// Nombre de sessions affichées dans l'affichage détaillé
$nbEnregSession = $this->getData(['module', $this->getUrl(0), 'config', 'nbEnregSession' ]);
// Nombre de dates affichées dans l'affichage chronologique
$nbAffiDates = $this->getData(['module', $this->getUrl(0), 'config', 'nbaffidates' ]);
// option avec geolocalisation
$geolocalisation = $this->getData(['module', $this->getUrl(0), 'config', 'geolocalisation' ]);


/*
 * Affichage cumulé depuis le début de l'analyse soit depuis l'initialisation du fichier cumul.json
*/
?>
<div class="block">
<?php
if( function_exists('datefmt_create') && function_exists('datefmt_format') && extension_loaded('intl') ){
	// Affichage au format de la langue d'administration
	$fmt = datefmt_create(
		$text['statislite_view']['index'][29],
		IntlDateFormatter::LONG,
		IntlDateFormatter::SHORT,
		$text['statislite_view']['index'][30],
		IntlDateFormatter::GREGORIAN
	);
	$datedeb = datefmt_format($fmt, strtotime($module::$datedebut));

} else{
	$datedeb = $module::$datedebut;
}
?>
	<div class="blockTitle"><?php echo $text['statislite_view']['index'][0]; echo  $datedeb;?></div>
	<div class="row">
		<div class="col4"><h3>
			<?php echo $text['statislite_view']['index'][1].$module::$comptepagestotal;?></h3>
		</div>
		<div class="col4"><h3>
			<?php echo $text['statislite_view']['index'][2].$module::$comptevisitetotal;?></h3>
		</div>
		<div class="col4"><h3>
			<?php echo $text['statislite_view']['index'][3].$module::$dureevisitemoyenne;?></h3>
		</div>
	</div><br/><br/>
	<?php
	if($nbaffipagesvues != 0){
		// Affichage des pages vues et de leur nombre de clics en prenant en compte cumul.json et sessionLog.json
		?>	<div class="blockgraph">
			<div class="stats multicolor">
				<div class="blockgraphTitle"><?php echo $text['statislite_view']['index'][4]; ?></div>
				<ul>
				<?php foreach($module::$pagesvuesaffi as $page=>$score){
					// Adaptation de la longueur au score
					$long =ceil((float)($score/$module::$scoremax)*10)*10;
					?>	<li><?php echo $page; ?><span class="percent v<?php echo $long; ?>"> <?php echo $score; ?></span></li>
					<?php }
				?>
				</ul>
			</div>
		</div><br/><br/>
	<?php }

	// Affichage des langages préférés en prenant en compte cumul.json et sessionLog.json
	if($nbaffilangues != 0){
		?>	<div class="blockgraph">
			<div class="stats grey_gradiant">
				<div class="blockgraphTitle"><?php echo $text['statislite_view']['index'][5];?></div>
				<ul>
				<?php foreach($module::$languesaffi as $lang=>$score){
					// Adaptation de la longueur au score
					$long =ceil((float)($score/$module::$scoremaxlangues)*10)*10;
					?>	<li><?php echo $lang; ?><span class="percent v<?php echo $long; ?>"> <?php echo $score; ?></span></li>
					<?php }
				?>
				</ul>
			</div>
		</div><br/><br/>
	<?php }

	// Affichage des navigateurs en prenant en compte cumul.json et sessionLog.json
	if($nbaffinavigateurs != 0){
		?>	<div class="blockgraph notranslate">
			<div class="stats green_gradiant">
				<div class="blockgraphTitle"><?php echo $text['statislite_view']['index'][6]; ?></div>
				<ul>
				<?php foreach($module::$navigateursaffi as $navig=>$score){
					// Adaptation de la longueur au score
					$long =ceil((float)($score/$module::$scoremaxnavi)*10)*10;
					?>	<li><?php echo $navig; ?><span class="percent v<?php echo $long; ?>"> <?php echo $score; ?></span></li>
					<?php }
				?>
				</ul>
			</div>
		</div><br/><br/>
	<?php }

	// Affichage des systèmes d'exploitation en prenant en compte cumul.json et sessionLog.json
	if($nbaffise != 0){
		?>	<div class="blockgraph notranslate">
			<div class="stats grey_gradiant">
				<div class="blockgraphTitle"><?php echo $text['statislite_view']['index'][7]; ?></div>
				<ul>
				<?php foreach($module::$systemesaffi as $syse=>$score){
					// Adaptation de la longueur au score
					$long =ceil((float)($score/$module::$scoremaxse)*10)*10;
					?>	<li><?php echo $syse; ?><span class="percent v<?php echo $long; ?>"> <?php echo $score; ?></span></li>
					<?php }
				?>
				</ul>
			</div>
		</div><br/><br/>
	<?php }

	// Affichage des robots et des sessions invalides
	$json = file_get_contents($module::$fichiers_json.'cumul.json');
	$cumul = json_decode($json, true);?>
	<br/>
	<div class="row">
		<div class="col4">
			<h3><?php echo $text['statislite_view']['index'][8].$cumul['robots']['ua']; ?></h3>
		</div>
		<div class="col4">
			<h3><?php echo $text['statislite_view']['index'][9].($cumul['robots']['np'] + $cumul['robots']['tv'] + $cumul['robots']['ue']);?></h3>
		</div>
	</div>
<!-- Fermeture bloc principal -->
</div>

<?php
/*
 * Affichage des téléchargements
 *
*/
if( file_exists( $module::$downloadLink.'counter.json' ) && file_get_contents($module::$downloadLink.'counter.json') !== '{}'){
	$json = file_get_contents($module::$downloadLink.'counter.json');
	$download = json_decode($json, true);
	if( function_exists('datefmt_create') && function_exists('datefmt_format') && extension_loaded('intl') ){
		// Affichage au format de la langue d'administration
		$fmt = datefmt_create(
			$text['statislite_view']['index'][29],
			IntlDateFormatter::LONG,
			IntlDateFormatter::SHORT,
			$text['statislite_view']['index'][30],
			IntlDateFormatter::GREGORIAN
		);
		$datedeb = datefmt_format($fmt, strtotime($download["date_creation_fichier"]));

	} else{
		$datedeb = $download["date_creation_fichier"];
	} ?>
<div class="block">
		<div class="blockTitle"><?php echo  $text['statislite_view']['index'][31].$datedeb; ?></div>
	<?php
	foreach( $download as $key=>$value){
		if( $key !== "date_creation_fichier" ){ ?>
		<div class="row">
			<div class="col12">
				<?php echo '<em>'.$key.'</em> => <strong>'.$value.'</strong>'; ?>
			</div>
		</div>
		<?php } } ?>
</div>
<?php } ?>

<?php
/*
 * Affichage des visites, pages vues, durée des x dernières dates du fichier chrono.json
 *
*/
if( $nbAffiDates != 0){ ?>
<div class="block">
		<div class="blockTitle"><?php echo $text['statislite_view']['index'][10]; ?></div>
		<?php
		$i = 0;
		foreach($module::$chronoaffi as $date=>$value){
			$dureeparvisite = '';
			if($module::$chronoaffi[$date]['nb_visites'] > 0){
				$dureeparvisite = $module::conversionTime( (int)($module::$chronoaffi[$date]['duree'] / $module::$chronoaffi[$date]['nb_visites']));
			}
			?>
			<div class="row">
				<div class="col3">
					<?php echo '<strong>'.$date.'</strong>'.$text['statislite_view']['index'][11].$module::$chronoaffi[$date]['nb_visites']; ?>
				</div>
				<div class="col2">
					<?php echo $text['statislite_view']['index'][12].$module::$chronoaffi[$date]['nb_pages_vues']; ?>
				</div>
				<div class="col3">
					<?php echo $text['statislite_view']['index'][13].$module::conversionTime($module::$chronoaffi[$date]['duree']); ?>
				</div>
				<div class="col4">
					<?php if($module::$chronoaffi[$date]['nb_visites'] > 0){ echo $text['statislite_view']['index'][14].$dureeparvisite; }?>
				</div>
			</div>
			<?php
			$i++;
			if($i >= $nbAffiDates) { break;}
		} ?>
	</div>
<?php
}
/*
 * Affichage détaillé pour les enregistrements du fichier affitampon.json
 *
*/
$tableau = $module::$affidetaille;
if( isset($tableau[0]['vues'][0])){
	// Recherche de la première date dans le fichier courant
	$datedebut = date('Y/m/d H:i:s');
	$datedebut = substr($tableau[count($tableau) - 1]['vues'][0], 0 , 19);
	?>
	<div class="block">
		<div class="blockTitle"><?php echo $text['statislite_view']['index'][15]; ?></div>
		<?php
		$comptepages = 0;
		$comptevisites = 0;
		foreach($tableau as $num=>$values){
			$pagesvues ='';
			$nbpageparsession = count($tableau[$num]['vues']);
			$datetimei = strtotime(substr($tableau[$num]['vues'][0], 0 , 19));
			$datetimef = strtotime(substr($tableau[$num]['vues'][$nbpageparsession - 1], 0 , 19));
			$dureevisite = 0;
			for( $i=0 ; $i < $nbpageparsession - 1 ; $i++){
				$nompage = substr($tableau[$num]['vues'][$i], 22 , strlen($tableau[$num]['vues'][$i]));
				$dureepage = strtotime(substr($tableau[$num]['vues'][$i + 1], 0 , 19)) - strtotime(substr($tableau[$num]['vues'][$i], 0 , 19));
				$pagesvues .= $nompage.' ('.$dureepage.' s) - ';
				$dureevisite = $dureevisite + $dureepage;
			}
			$pagesvues .= substr($tableau[$num]['vues'][$nbpageparsession - 1], 22 , strlen($tableau[$num]['vues'][$nbpageparsession - 1]));
			// Affichages
			echo '<strong>'.$text['statislite_view']['index'][16].substr($tableau[$num]['vues'][0], 0 , 19).'</strong><br/>';
			if($geolocalisation){
				echo ' >><em>'.$text['statislite_view']['index'][17].$tableau[$num]['geolocalisation'].'</em><br/>';
			}
			echo ' - User Agent : '.$tableau[$num]['userAgent'].'<br/>';
			echo ' >><em>'.$text['statislite_view']['index'][18].$tableau[$num]['client'][2].'</em><br/>';
			echo ' >><em>'.$text['statislite_view']['index'][19].$tableau[$num]['client'][1].'</em><br/>';
			echo ' - Accept Language : '.$tableau[$num]['langage'].'<br/>';
			echo ' >><em>'.$text['statislite_view']['index'][20].$tableau[$num]['client'][0].'</em><br/>';
			echo ' - Referer : '.$tableau[$num]['referer'].'<br/>';
			echo '<em>'.$text['statislite_view']['index'][21].$nbpageparsession.'</em><br/>';
			if($nbpageparsession >= 1){
				echo $text['statislite_view']['index'][22].$pagesvues.'<br/>';
			}
			else{
				echo $text['statislite_view']['index'][23].$pagesvues.'<br/>';
			}
			$dureevisite = $module::conversionTime($dureevisite);
			if($dureevisite != '0 s'){
				echo '<em>'.$text['statislite_view']['index'][24]. $dureevisite.'</em><br/>'.'<br/>';
			}
			else{
				echo $text['statislite_view']['index'][25].'<br/>'.'<br/>';
			}
			$comptevisites++;
			$comptepages = $comptepages + $nbpageparsession;
		}

		// Affichage du bilan pour la période en cours
		echo '<strong>'.$text['statislite_view']['index'][26].$datedebut.'</strong><br/>'.'<br/>';
		echo $text['statislite_view']['index'][27].$comptepages.'<br/>';
		echo $text['statislite_view']['index'][28].$comptevisites.'<br/>'.'<br/>';
	}
?>
</div>






