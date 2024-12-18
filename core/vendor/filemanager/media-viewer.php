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
$ressource = '../../../site/file/source/'.$_GET['media'];
$media_ext = pathinfo($ressource, PATHINFO_EXTENSION);
$videos = ['webm', 'mp4', 'm4v', 'ogv'];
$media = in_array($media_ext,$videos) ? 'video' : 'audio';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Média</title>
		<link rel="stylesheet" href="css/viewers.css">
		<style>
		video, audio {
			max-width: 100%;
			max-height: 60vh;
			display: block;
			margin: auto;
		}
		</style>
	</head>
<body>
<<?=$media?> type="<?=mime_content_type($ressource)?>" src="<?=$ressource?>" controls id="mediaViewer"></<?=$media?>>
<script>
const lecteur = document.getElementById('mediaViewer');
document.addEventListener('click', function() {
lecteur.pause();
lecteur.currentTime = 0;
});
</script>
</body>
</html>
