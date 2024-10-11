<?php
// Lexique du module album en anglais
$text['album_view']['config'][0] = 'Back';
$text['album_view']['config'][1] = 'Help';
$text['album_view']['config'][2] = 'New Album';
$text['album_view']['config'][3] = 'Name';
$text['album_view']['config'][4] = 'Target folder';
$text['album_view']['config'][5] = 'Installed albums';
$text['album_view']['config'][6] = "Are you sure you want to delete this album ?";
$text['album_view']['config'][7] = 'No galleries';
$text['album_view']['config'][8] = 'Version no.';
$text['album_view']['config'][9] = 'module/album/view/config/config.help_en.html';
$text['album_view']['config'][10] = 'Help';
$text['album_view']['config'][11] = 'Texts';

$text['album_view']['texts'][0] = 'Return';
$text['album_view']['texts'][1] = 'Save';
$text['album_view']['texts'][2] = 'Adapt these texts into the language of your visitors';
$text['album_view']['texts'][3] = 'Return';
$text['album_view']['texts'][4] = 'Geolocation';
$text['album_view']['texts'][5] = 'No album';
$text['album_view']['texts'][6] = 'Version n°';

$text['album_view']['edit'][0] = 'Back';
$text['album_view']['edit'][1] = 'Save';
$text['album_view']['edit'][2] = 'Image setting';
$text['album_view']['edit'][3] = 'Name';
$text['album_view']['edit'][4] = 'Target folder';
$text['album_view']['edit'][5] = 'Sort images';
$text['album_view']['edit'][6] = 'Manual sort: move the images into the table below. The order is saved automatically';
$text['album_view']['edit'][7] = 'Image';
$text['album_view']['edit'][8] = 'Cover';
$text['album_view']['edit'][9] = 'Caption';
$text['album_view']['edit'][10] = 'No image';
$text['album_view']['edit'][11] = 'Version No.';

$text['gallery']['config'][0] = ' (empty folder)';
$text['gallery']['config'][1] = ' (folder not found)';
$text['gallery']['config'][2] = 'Saved changes';
$text['gallery']['config'][3] = 'Module configuration';
$text['gallery']['delete'][0] = 'Unauthorized deletion';
$text['gallery']['delete'][1] = 'Album deleted';
$text['gallery']['edit'][0] = 'Unauthorised action';
$text['gallery']['edit'][1] = 'Changes saved';

$text['album']['texts'][0] = "Recorded texts";
$text['album']['texts'][1] = "Texts visible to a visitor";

$text['album']['init'][0] = 'Return';
$text['album']['init'][1] = 'Geolocation';
$text['album']['init'][2] = 'No album';

//Selects
if($param === "album_view"){
	$sort = [
		$module::SORT_ASC => 'Alphabetical',
		$module::SORT_DSC => 'Reverse Alphabetic',
		$module::SORT_HAND => 'Manual'
	];
}
?>
