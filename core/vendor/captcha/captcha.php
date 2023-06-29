<?php
session_start();
if ( !defined('ABSPATH') ) define('ABSPATH', dirname(__FILE__) . '/');

function random($tab) {
    return $tab[array_rand($tab)];
}

$chars = '0123456789';

$char1 = mt_rand( 0, strlen($chars) - 1 );
$char2 = mt_rand( 0, strlen($chars) - 1 );
$_SESSION['captcha'] = md5((int)$char1 + (int)$char2);

// polices utilisées
$fonts = glob('polices/*.woff');
// création de l'image captcha
$image = imagecreatefrompng('captcha.png');
// couleurs des caractères
$colors = array ( imagecolorallocate($image,  238, 238, 238),
                  imagecolorallocate($image,  51, 51, 51),
                  imagecolorallocate($image,  0, 102, 153),
                  imagecolorallocate($image, 204, 0, 51),
                  imagecolorallocate($image, 255, 51, 51),
                  imagecolorallocate($image, 51, 255, 51),
                  imagecolorallocate($image, 255, 255, 51) );
// positions, polices, caractères et couleurs randomisées
imagettftext($image, 28, -10, 7, 50, random($colors), ABSPATH .'/'. random($fonts), $char1);
imagettftext($image, 28, 0, 50, 50, random($colors), ABSPATH .'/'. 'polices/Eskiula.woff', '+');
imagettftext($image, 28, -35, 75, 50, random($colors), ABSPATH .'/'. random($fonts), $char2);
imagettftext($image, 28, 0, 125, 50, random($colors), ABSPATH .'/'. 'polices/Eskiula.woff', '=');

header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?>
