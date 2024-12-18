<?php
/**
 * This file is part of DeltaCMS.
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 * @author Sylvain Lelièvre
 * @copyright 2021 © Sylvain Lelièvre
 * @author Lionel Croquefer
 * @copyright 2022 © Lionel Croquefer
 * @license GNU General Public License, version 3
 * @link https://deltacms.fr/
 * @contact https://deltacms.fr/contact
 */
$ressource = '../../../site/file/source/'.$_GET['img'];
$size = getimagesize($ressource) ?? false;
$taille = isset($size[0]) && $size[0] > 0 ? $size[0].'x'.$size[1].' px, ' : null;
$poids = round(filesize($ressource)/1024,1);
	if ($poids <= 600) {
		$color = 'limegreen';
	}
	elseif ($poids > 600 && $poids < 1200) {
		$color = 'orange';
	}
	elseif ($poids >= 1200) {
		$color = 'red';
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Images</title>
		<link rel="stylesheet" href="css/viewers.css">
		<style>
		#imgprev {
			display: block;
			margin: auto;
			position: relative;
			text-align: center;
		}
		#imgprev img {
			max-width: 100%;
			max-height: 60vh;
		}
		#taillinfos {
			width: 100%;
			position: absolute;
			left: 0;
			top: 0;
			font-size: 0.8em;
			font-weight: 600;
			line-height: 1.5;
			color: <?=$color?>;
			background-color: rgba(0,0,0,0.7);
			display: none;
		}
		</style>
	</head>
<body>
<div id="imgprev">
<img src="<?=$ressource?>">
<span id="taillinfos"><?=$taille.$poids?> Kio</span>
</div>
<script>
 $(function () {
	$('.modal-body').hover(
    function(){$('#taillinfos').stop().fadeIn(100);},
    function(){$('#taillinfos').stop().fadeOut(100);}
);
});
</script>
</body>
</html>
