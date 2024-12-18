<?php
/* * texte info v3 *
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
$info = '../../../site/file/source/'.$_GET['info'];
$text = file_get_contents($info);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Info</title>
		<style>
		.modal-body {
			min-height: 40vh;
		}
		</style>
	</head>
<body>
<?php
// encodage du texte
function QE($fn) {
	$in = finfo_open(FILEINFO_MIME_ENCODING);
	$ty = finfo_buffer($in,file_get_contents($fn));
	finfo_close($in);
return in_array($ty,['utf-8','us-ascii']);
}
$texte_info = QE($info)=='utf-8' ? $text : mb_convert_encoding($text, 'UTF-8', mb_detect_encoding($info,['ISO-8859-15', 'ISO-8859-1', 'ISO-8859-5', 'ASCII', 'WINDOWS-1252']));
	print(nl2br($texte_info));
?>
</body>
</html>
