<?php
// Lexique du module News en anglais
$text['news_view']['config'][0] = 'Back';
$text['news_view']['config'][1] = 'News';
$text['news_view']['config'][2] = 'Submit';
$text['news_view']['config'][3] = 'Module parameters';
$text['news_view']['config'][4] = 'RSS feed link';
$text['news_view']['config'][5] = 'Feed limited to articles on the first page.';
$text['news_view']['config'][6] = 'RSS tag';
$text['news_view']['config'][7] = 'Number of columns';
$text['news_view']['config'][8] = 'Articles per page';
$text['news_view']['config'][9] = 'Article abstract';
$text['news_view']['config'][10] = 'Module theme';
$text['news_view']['config'][12] = 'Thickness';
$text['news_view']['config'][13] = 'The colors are initialized to those of the site.';
$text['news_view']['config'][14] = 'Border colour';
$text['news_view']['config'][15] = 'Background colour';
$text['news_view']['config'][16] = 'Title';
$text['news_view']['config'][17] = 'Publication';
$text['news_view']['config'][18] = 'Depublication';
$text['news_view']['config'][19] = 'State';
$text['news_view']['config'][20] = 'No news';
$text['news_view']['config'][21] = 'Version no.';
$text['news_view']['config'][22] = 'Rounding of corners';
$text['news_view']['config'][23] = 'Shadow on edges';
$text['news_view']['config'][24] = 'Hide news titles';
$text['news_view']['config'][25] = 'Hidden titles';
$text['news_view']['config'][26] = 'Same height';
$text['news_view']['config'][27] = 'Columns in the same row will have the same height';
$text['news_view']['config'][28]  = "Are you sure you want to delete this news ?";
$text['news_view']['config'][29] = "This setting concerns the news preview. In the last paragraph, which is often truncated, the different html tags are removed.";
$text['news_view']['config'][30] = "Media without margin";
$text['news_view']['config'][31] = "With this option the media will appear without margin in the preview.";
$text['news_view']['config'][32] = 'Help';
$text['news_view']['config'][33] = 'module/news/view/config/config.help_en.html';
$text['news_view']['config'][34] = 'Hidden media';
$text['news_view']['config'][35] = 'This option hides the media in the preview';
$text['news_view']['config'][36] = 'Text color';
$text['news_view']['config'][37] = 'Heading color';
$text['news_view']['config'][38] = 'Link color';
$text['news_view']['config'][39] = 'Date and signature color';
$text['news_view']['config'][40] = 'Adapt these texts into the language of your visitors';
$text['news_view']['config'][41] = 'Read more';
$text['news_view']['config'][42] = 'Back';
$text['news_view']['config'][43] = 'No news';

$text['news_view']['index'][2] = ' Edit';
$text['news_view']['add'][0] = 'Back';
$text['news_view']['add'][1] = 'Save as draft';
$text['news_view']['add'][2] = 'Publish';
$text['news_view']['add'][3] = 'Title';
$text['news_view']['add'][4] = 'Author';
$text['news_view']['add'][5] = 'General information';
$text['news_view']['add'][6] = 'Publication options';
$text['news_view']['add'][7] = 'The news can be consulted as soon as the publication date has passed';
$text['news_view']['add'][8] = 'Publication date';
$text['news_view']['add'][9] = 'The news is viewable until this date if specified. To cancel the unpublishing date, select a date before publication';
$text['news_view']['add'][10] = 'Unpublish date';
// For Tinymce and Flatpickr
$text['news_view']['add'][12] = 'en_GB';
$text['news_view']['add'][13] = 'default';

$text['news_view']['article'][1] = 'Edit';
$text['news_view']['edit'][0] = 'Back';
$text['news_view']['edit'][1] = 'Save as draft';
$text['news_view']['edit'][2] = 'Publish';
$text['news_view']['edit'][3] = 'General information';
$text['news_view']['edit'][4] = 'Title';
$text['news_view']['edit'][5] = 'Publication options';
$text['news_view']['edit'][6] = 'Author';
$text['news_view']['edit'][7] = 'The news can be consulted as soon as the publication date has passed';
$text['news_view']['edit'][8] = 'Publication date';
$text['news_view']['edit'][9] = 'The news is viewable until this date if specified. To cancel the unpublishing date, select a date before publication';
$text['news_view']['edit'][10] = 'Unpublish date';
// For Tinymce and Flatpickr
$text['news_view']['edit'][12] = 'en_GB';
$text['news_view']['edit'][13] = 'default';
$text['news']['add'][0] = 'New news created';
$text['news']['add'][1] = 'New news';
$text['news']['config'][0] = 'Changes saved';
$text['news']['config'][1] = 'Permanent';
$text['news']['config'][2] = 'Module configuration';
$text['news']['config'][3] = ' at ';
// For Tinymce and Flatpickr
$text['news']['config'][4] = 'en_GB';
$text['news']['config'][5] = 'Europe/London';
$text['news']['delete'][0] = 'Unauthorised action';
$text['news']['delete'][1] = 'News deleted';
$text['news']['edit'][0] = 'Unauthorised action';
$text['news']['edit'][1] = 'Changes saved';
// Selects
$states = [
	false => 'Draft',
	true => 'Published'
];
// Nombre de colone par page
$columns = [
	12 => '1 column',
	6 => '2 columns',
	4 => '3 columns',
	3 => '4 columns'
];
$height = [
	-1 => 'Complete article',
	1000 => '1000 characters + 1 media',
	800 => '800 characters + 1 media',
	600 => '600 characters + 1 media',
	400 => '400 characters + 1 media',
	200 => '200 characters + 1 media'
];
$borderWidth = [
	0 			=> 'None',
	'0.1em' 	=> 'Very fine',
	'0.15em' 	=> 'Fine',
	'0.2em' 	=> 'Very small',
	'0.25em' 	=> 'Small'
];
$newsRadius = [
	'0px' => 'None',
	'5px' => 'Very light',
	'10px' => 'Light',
	'15px' => 'Medium',
	'25px' => 'Important',
	'50px' => 'Very important'
];
$newsShadows = [
	'0px 0px 0px' => 'None',
	'1px 1px 2px' => 'Very light',
	'2px 2px 4px' => 'Light',
	'3px 3px 6px' => 'Medium',
	'5px 5px 10px' => 'Important',
	'10px 10px 20px' => 'Very important'
];
?>
