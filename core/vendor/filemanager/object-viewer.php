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
$ressource = '../../../site/file/source/'.$_GET['object'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Object</title>
		<link rel="stylesheet" href="css/viewers.css">
		<style>
		.modal-body {
			min-height: 60vh;
		}
		object {
			width: 100%;
			height: 60vh;
		}
		</style>
	</head>
<body>
<object type="<?=mime_content_type($ressource)?>" data="<?=$ressource?>"></object>
</body>
</html>
