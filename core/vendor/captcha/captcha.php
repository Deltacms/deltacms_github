<?php
session_start();
if ( !defined('ABSPATH') ) define('ABSPATH', dirname(__FILE__) . '/');

function random($tab) {
    return $tab[array_rand($tab)];
}

$chars = '0123456789';

$char1 = mt_rand( 0, strlen($chars) - 1 );
$char2 = mt_rand( 0, strlen($chars) - 1 );
$char3 = mt_rand( 0, strlen($chars) - 1 );

$_SESSION['captcha'] = md5((int)$char1 + (int)$char2 + (int)$char3);

// polices utilisées
$fonts = glob('polices/*.ttf');
// création de l'image captcha
$varimg = ['captcha.png','captcha-1.png','captcha-2.png'];
$image = imagecreatefrompng(random($varimg));
// positionnement vertical, inclinaison et taille des caractères
$vpos = [45,55,65];
$angle = [-12,-17,-22,0,12,17,22];
$size = [30,32,34];
// couleurs des caractères
$colors = [imagecolorallocatealpha($image,238,238,238,23),
		  imagecolorallocatealpha($image,51,51,51,51),
		  imagecolorallocatealpha($image,0,102,153,25),
		  imagecolorallocatealpha($image,204,0,51,41),
		  imagecolorallocatealpha($image,255,51,51,34),
		  imagecolorallocatealpha($image,51,255,51,30),
		  imagecolorallocatealpha($image,255,255,51,33)];
// positions, polices, caractères et couleurs randomisées
imagettftext($image, random($size), random($angle), 8, random($vpos), random($colors), ABSPATH .'/'. random($fonts), $char1);
imagettftext($image, random($size), random($angle), 64, random($vpos), random($colors), ABSPATH .'/'. random($fonts), $char2);
imagettftext($image, random($size), random($angle), 122, random($vpos), random($colors), ABSPATH .'/'. random($fonts), $char3);

header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?>
