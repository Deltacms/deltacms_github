<?php 
/* Calcul de l'indice de confiance de 0 à 100
* Exécuté à la soumission d'un formulaire si l'indice de confiance est > 0 et si la fonction est activée dans Configuration/ Connexion Sécurité
* Formulaire => fonction core trustscore() => fichier include trust.inc.php
*/
$session = session_id();
// Si utilisateur connecté => 100
if($this->getUser('group') >= 1){
	$trust_score = 100;
} else {
	// Lecture des données $_SERVER et du hostname
	$ip = helper::getIp();
	$ipMask = helper::getIp(2);
	$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '';
	
	$hostname = gethostbyaddr($ip);
	$hostname = ($hostname === $ip) ? '' : strtolower(preg_replace('/^\d+(?:-\d+)*\./', '', $hostname));

	
	//$hostname = strtolower(preg_replace('/^\d+(?:-\d+)*\./', '', gethostbyaddr($ip)));
	
	$accept_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE']:'';
	$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER']:'';
	// Bot détecté dans user_agent à partir de liste_bot.txt => 0
	$bot = false; $match = 0;
	if(is_file('core/vendor/trust/liste_bot.txt')){
		$regex = file_get_contents('core/vendor/trust/liste_bot.txt');
		$match = preg_match($regex, $user_agent);
	}
	if($match !== 0) {
		$bot = true;
		$trust_score = 0;
	} else {
		// Visiteur qui ne semble pas un bot
		$trust_score = 60; $trace = '';
		//absence de HTTP_USER_AGENT ou vide => -40
		if($user_agent === '') {
			$trust_score += -40;
			$trace = $trace.'user_agent ';
		}
		//absence de language_accept => -20
		if($accept_language === '') {
			$trust_score += -20;
			$trace = $trace.'accept_language ';
		}
		// Eventuellement code du pays non présent dans language_accept, exemple avec ip_api => -20
		/*$response = file_get_contents("http://ip-api.com/json/".$ip);
		$data = json_decode($response, true);
		if( strpos($data['countryCode'], $accept_language) === false) {
			$trust_score += -20;
			$trace += 'ipCountry ';
		}*/
		//absence de referer => -10
		if($referer ==='') {
			$trust_score += -10;
			$trace = $trace.'referer ';
		}
		//VPN ? utilisation de $hostname et de $ip
		//vpn masqué ? gethostbyaddr($ip) renvoie uniquement l'ip le reste est masqué : $hostname = '' => -20
		if($hostname === ''){
			$trust_score += -20;
			$trace = $trace.'vpn_hostnamevide';
		} else {
			//mots clefs comme 'vpn' dans un fichier liste_vpn.txt => -10
			if(is_file('core/vendor/trust/liste_vpn.txt')){
				$regex = file_get_contents('core/vendor/trust/liste_vpn.txt');
				$match = preg_match($regex, $hostname);
			}
			if($match !== 0) {
				$trust_score += -10;
				$trace = $trace.'vpn_vpn.txt';
			} else {
				//ip dans une liste liste_ip_vpn.txt fournie par https://github.com/X4BNet/lists_vpn/tree/main/output/vpn/ipv4.txt => -10
				function ipInRange($ip, $cidr) {
					list($subnet, $mask) = explode('/', $cidr);
					$ipDecimal = ip2long($ip);
					$subnetDecimal = ip2long($subnet);
					$maskDecimal = ~((1 << (32 - $mask)) - 1);

					return ($ipDecimal & $maskDecimal) === ($subnetDecimal & $maskDecimal);
				}
				function isVpnIP($ip) {
					$vpnList = is_file('core/vendor/trust/liste_ip_vpn.txt') ? file('core/vendor/trust/liste_ip_vpn.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES):[];
					
					foreach ($vpnList as $cidr) {
						if (ipInRange($ip, $cidr)) {
							return true;
						}
					}
					return false;
				}
				if (isVpnIP($ip)){
					$trust_score += -10;
					$trace = $trace.'vpn_ip_vpn.txt';			
				}			
			}
		}

		// FAI douteux => -40
		$matchfai = 0;
		if(is_file('core/vendor/trust/liste_fai.txt')){
			$regex = file_get_contents('core/vendor/trust/liste_fai.txt');
			$matchfai = preg_match($regex, $hostname);
		}
		if( strpos($user_agent,'duckduckgo') === false && strpos($hostname,'amazonaws') === true) $matchfai = 1;
		if($matchfai !== 0 || $hostname === '.'){
			$trust_score += -60;
			$trace = $trace.'fai ';
		}
		// Bornage
		if($trust_score < 0) $trust_score=0;
		// Activités détectés par JS et transmis par ajax dans $datafile
		$clics=0;$moves=0;$time=0;
		$datafile = './core/vendor/trust/json/'.$session.'.json';
		$json = file_exists($datafile) ? file_get_contents($datafile) : '';
		$activity = json_decode($json, true) ?? [];
		if(isset($activity['time_open'])){
			$clics = $activity['nbClicks'] + $activity['taps']/2;
			$moves = $activity['mouseMoves'] + $activity['touch_moves'] + $activity['scrolls'];
			$time =  $activity['time_spent'];
			// $clics en considérant un second envoi du formulaire après notices, 1 pour la modification d'un champ, 1 pour le captcha
			if($clics === 0 )  $trust_score += -40; 
			if($clics >= 2 )  $trust_score += 20;			
			if($moves < 10 )  $trust_score += -20; 
			if($moves > 30 )  $trust_score += 20; 
			if($time < 3 ) $trust_score += -20; 
			if($time > 10 ) $trust_score += 20; 
		}
	}
	// Bornage
	if($trust_score > 100) $trust_score=100;
	if($trust_score < 0) $trust_score=0;
	// log si non connecté
	$timeLog = time();
	$date =  mb_detect_encoding(date('d/m/Y - H:i:s',  $timeLog), 'UTF-8', true)? date('d/m/Y - H:i:s', $timeLog): helper::utf8Encode(date('d/m/Y - H:i:s', $timeLog));
	$logArray = ['date d/m/Y'=>$date, 'page'=>$this->getUrl(0),'ip'=>$ipMask,'bot'=>$bot];
	if($bot === false){
		$logArray2 = ['user_agent'=>$user_agent, 'accept_language'=>$accept_language, 'referer'=>$referer, 'hostname'=>$hostname, 'Pénalités'=>$trace, 'clics'=>$clics, 'moves'=>$moves, 'time'=>$time, 'trust_score'=>$trust_score];
		$logArray = array_merge($logArray, $logArray2);
	}
	$logFile = 'core/vendor/trust/log/log.json';
	$json = is_file($logFile) ? file_get_contents($logFile) : "{}";
	$existingLogs = json_decode($json, true);	
	if (!is_array($existingLogs)) $existingLogs = [];
	$existingLogs[$timeLog] = $logArray;
	// Limitation aux 200 derniers scores
	if( count($existingLogs) > 200)	unset($existingLogs[array_key_first($existingLogs)]);
	file_put_contents($logFile,json_encode($existingLogs));
}
//Suppression des fichiers numero_session.json anciens > 15 minutes
$files = glob('core/vendor/trust/json/*.json');
foreach($files as $key=>$path){
  $json=file_get_contents($path);
  $array=json_decode($json,true);
  if( (time() - $array["time_open"]) > 900) unlink($path);
}
?>