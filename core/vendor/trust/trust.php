<?php
// Fichier où seront stockées les données d'activtés de la session exécuté suite à la requête ajax XHR
// Récupération du numéro de session
session_start();
$sessionId = session_id();
$dataFile = "json/".$sessionId.".json";
// Charger les données existantes ou initialiser
$json = is_file($dataFile)? file_get_contents($dataFile) : '{}';
$visitors = json_decode($json, true);
// Réception des données envoyées par JS et sauvegarde
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
	/*
	// Date d'ouvertre de la page
	if (isset($data["time_open"])) $visitors["time_open"] = $data["time_open"];
	// Temps passé sur la page
    if (isset($data["time_spent"])) $visitors["time_spent"] = $data["time_spent"];
	// Nombre de clics réalisés sur la page
    if (isset($data["clicks"])) $visitors["nbClicks"] = $data["nbClicks"];
	// Mouvements de souris
    if (isset($data["mouse_moves"])) $visitors["mouseMoves"] = $data["mouseMoves"];
	// Tactile clic
	if (isset($data["taps"])) $visitors["taps"] = $data["taps"];
	// Tactile mouvements
	if (isset($data["touch_moves"])) $visitors["touch_moves"] = $data["touch_moves"];
	// Tactile scroll
	if (isset($data["scrolls"])) $visitors["scrolls"] = $data["scrolls"];
    file_put_contents($dataFile, json_encode($visitors));
	*/
	file_put_contents($dataFile, json_encode($data));
}
?>

