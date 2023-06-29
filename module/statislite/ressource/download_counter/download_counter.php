<?php
// Fonctionne avec le script "Compteur de téléchargements" placé dans core.js.php
// Enregistre dans un fichier json ($urlfile) : url => nombre de clics
if (isset($_POST['url'])) {
	$url = $_POST['url'];
	$urlfile = 'counter.json';
	if( !is_file( $urlfile ) || filesize($urlfile)<5 ){
		file_put_contents($urlfile,'{"date_creation_fichier":"'.date('Y/m/d H:i:s').'"}');	
	}
	$json = file_get_contents($urlfile);
	$tab = json_decode($json, true);
	//Lire le tableau si la clef === $url incrémentation de la valeur associée, sortir
	$found = false;
	foreach($tab as $key=>$value){
		if( $key === $url){
			$value = $value + 1;
			$tab[$key] = $value;
			$found = true;
			break;
		}
	}
	//Si la clef n'est pas trouvée on ajoute au tableau url => 1
	if( $found === false ) $tab = array_merge( $tab, array( $url => 1));
	$json = json_encode($tab);
	file_put_contents($urlfile,$json);	
}
?>
