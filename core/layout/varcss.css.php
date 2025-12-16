<?php
session_start(); 
// Fichier varcss.css.php utilisé pour transmettre les valeurs des variables css
header("Content-Type: text/css");
?>
:root {
    --navsub-scrollbar: <?= $_SESSION['varcss-navsub-scrollbar'] ?? 'blue' ?>;
    --nav-position: <?= $_SESSION['varcss-nav-position'] ?? 'relative' ?>;
	--nav-top: <?= $_SESSION['varcss-nav-top'] ?? '0' ?>;
	--nav-margintop: <?= $_SESSION['varcss-nav-margintop'] ?? '0' ?>;
	--section-paddingtop: <?= $_SESSION['varcss-section-paddingtop'] ?? '20px'?>;
}
