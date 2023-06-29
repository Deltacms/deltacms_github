<?php
// Lexique du module Gallery en anglais
$text['gallery_view']['config'][0] = 'Back';
$text['gallery_view']['config'][1] = 'Theme';
$text['gallery_view']['config'][2] = 'Add a gallery';
$text['gallery_view']['config'][3] = 'Name';
$text['gallery_view']['config'][4] = 'Target folder';
$text['gallery_view']['config'][5] = 'Installed galleries';
$text['gallery_view']['config'][6] = 'Target folder';
$text['gallery_view']['config'][7] = 'No galleries';
$text['gallery_view']['config'][8] = 'Version no.';
$text['gallery_view']['config'][9] = "Are you sure you want to delete this gallery ?";
$text['gallery_view']['config'][10] = 'Help';
$text['gallery_view']['config'][11] = 'module/gallery/view/config/config.help_en.html';
$text['gallery_view']['edit'][0] = 'Back';
$text['gallery_view']['edit'][1] = 'Save';
$text['gallery_view']['edit'][2] = 'Image setting';
$text['gallery_view']['edit'][3] = 'Name';
$text['gallery_view']['edit'][4] = 'Target folder';
$text['gallery_view']['edit'][5] = 'Sort images';
$text['gallery_view']['edit'][6] = 'Manual sort: move the images into the table below. The order is saved automatically';
$text['gallery_view']['edit'][7] = 'Automatic full screen mode';
$text['gallery_view']['edit'][8] = 'When the gallery is opened, the first image is displayed full screen';
$text['gallery_view']['edit'][9] = 'Image';
$text['gallery_view']['edit'][10] = 'Cover';
$text['gallery_view']['edit'][11] = 'Caption';
$text['gallery_view']['edit'][12] = 'No image';
$text['gallery_view']['edit'][13] = 'Version No.';
$text['gallery_view']['gallery'][0] = 'Back';
$text['gallery_view']['index'][0] = 'No gallery.';
$text['gallery_view']['theme'][0] = 'Back';
$text['gallery_view']['theme'][1] = 'Save';
$text['gallery_view']['theme'][2] = 'Thumbnails';
$text['gallery_view']['theme'][3] = 'Theme settings are common to modules of the same type';
$text['gallery_view']['theme'][4] = 'Width';
$text['gallery_view']['theme'][5] = 'Height';
$text['gallery_view']['theme'][6] = 'Alignment';
$text['gallery_view']['theme'][7] = 'Margin';
$text['gallery_view']['theme'][8] = 'Border';
$text['gallery_view']['theme'][9] = 'Horizontal cursor sets transparency level';
$text['gallery_view']['theme'][10] = 'Border color';
$text['gallery_view']['theme'][11] = 'Rounding of corners';
$text['gallery_view']['theme'][12] = 'Shadow';
$text['gallery_view']['theme'][14] = 'Shadow colour';
$text['gallery_view']['theme'][15] = 'Hover opacity';
$text['gallery_view']['theme'][17] = 'Legends';
$text['gallery_view']['theme'][19] = 'Text';
$text['gallery_view']['theme'][21] = 'Background';
$text['gallery_view']['theme'][22] = 'Height';
$text['gallery_view']['theme'][23] = 'Alignment';
$text['gallery_view']['theme'][24] = 'Version No.';
$text['gallery']['config'][0] = ' (empty folder)';
$text['gallery']['config'][1] = ' (folder not found)';
$text['gallery']['config'][2] = 'Saved changes';
$text['gallery']['config'][3] = 'Module configuration';
$text['gallery']['delete'][0] = 'Unauthorized deletion';
$text['gallery']['delete'][1] = 'Gallery deleted';
$text['gallery']['edit'][0] = 'Unauthorised action';
$text['gallery']['edit'][1] = 'Changes saved';
$text['gallery']['theme'][0] = 'Unauthorised action';
$text['gallery']['theme'][1] = 'Changes saved';
$text['gallery']['theme'][2] = 'Changes not saved !';
$text['gallery']['theme'][3] = 'Theme settings';

//Selects
if($param === "gallery_view"){
	$sort = [
		$module::SORT_ASC => 'Alphabetical',
		$module::SORT_DSC => 'Reverse Alphabetic',
		$module::SORT_HAND => 'Manual'
	];
	$galleryThemeFlexAlign = [
		'flex-start' => 'Left',
		'center' => 'Center',
		'flex-end' => 'Right',
		'space-around' => 'Distributed with margins',
		'space-between' => 'Distributed without margins',
	];
	$galleryThemeAlign = [
		'left' => 'Left',
		'center' => 'Center',
		'right' => 'Right'
	];
	$galleryThemeSizeWidth = [
		'9em'  => 'Very small',
		'12em' => 'Small',
		'15em' => 'Medium',
		'18em' => 'Large',
		'21em' => 'Very large',
		'100%' => 'Proportional'
	];
	$galleryThemeSizeHeight = [
		'9em'  => 'Very small',
		'12em' => 'Small',
		'15em' => 'Medium',
		'18em' => 'Large',
		'21em' => 'Very large'
	];
	$galleryThemeLegendHeight = [
		'.125em'  => 'Very small',
		'.25em'  => 'Small',
		'.375em'  => 'Medium',
		'.5em'  => 'Large',
		'.625em' => 'Very large'
	];
	$galleryThemeBorder = [
		'0em' => 'None',
		'.1em' => 'Very thin',
		'.3em' => 'Thin',
		'.5em'  => 'Medium',
		'.7em' => 'Thick',
		'.9em'  => 'Very thick'
	];
	$galleryThemeOpacity = [
		'1'   => 'None ',
		'.9'  => 'Very Discreet',
		'.8'  => 'Discreet',
		'.7'  => 'Medium',
		'.6'  => 'High',
		'.5'  => 'Very high'
	];
	$galleryThemeMargin = [
		'0em'    => 'None',
		'.1em'   => 'Very small',
		'.3em'   => 'Small',
		'.5em'   => 'Medium',
		'.7em'  => 'Large',
		'.9em'  => 'Très grande'
	];
	$galleryThemeRadius = [
		'0em' => 'None',
		'.3em' => 'Very light',
		'.6em' => 'Light',
		'.9em' => 'Medium',
		'1.2em' => 'Important',
		'1.5em' => 'Very important'
	];
	$galleryThemeShadows = [
		'0px' => 'None',
		'1px 1px 5px' => 'Very light',
		'1px 1px 10px' => 'Light',
		'1px 1px 15px' => 'Medium',
		'1px 1px 25px' => 'Important',
		'1px 1px 50px' => 'Very important'
	];
}
?>