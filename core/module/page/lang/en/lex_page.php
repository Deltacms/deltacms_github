<?php
// Lexique du module du coeur Page en anglais
$text['core_page_view']['edit'][0] = 'Back';
$text['core_page_view']['edit'][1] = 'Help';
$text['core_page_view']['edit'][2] = 'Duplicate';
$text['core_page_view']['edit'][3] = 'Delete';
$text['core_page_view']['edit'][4] = 'OK';
$text['core_page_view']['edit'][5] = 'General information';
$text['core_page_view']['edit'][6] = 'Title';
$text['core_page_view']['edit'][7] = 'Short title';
$text['core_page_view']['edit'][8] = 'The short title is displayed in the menus. It can be identical to the page title.';
$text['core_page_view']['edit'][9] = 'If the module is changed, the data of the previous module will be deleted.';
$text['core_page_view']['edit'][10] = 'Module';
$text['core_page_view']['edit'][11] = 'Aspect of the link';
$text['core_page_view']['edit'][12] = 'Select a small image or icon';
$text['core_page_view']['edit'][13] = 'Icon';
$text['core_page_view']['edit'][14] = 'In free position add the module by placing [MODULE] at the desired location on your page.';
$text['core_page_view']['edit'][15] = 'Module position';
$text['core_page_view']['edit'][16] = 'Layout';
$text['core_page_view']['edit'][17] = 'Page templates / Sidebar';
$text['core_page_view']['edit'][18] = 'To set the page as a sidebar, choose the option from the list.';
$text['core_page_view']['edit'][19] = 'Left sidebar :';
$text['core_page_view']['edit'][20] = 'Right sidebar :';
$text['core_page_view']['edit'][21] = 'Content of the vertical menu';
$text['core_page_view']['edit'][22] = 'By default the menu is displayed AFTER the page content. To position it at a specific location, insert [MENU] into the page content.';
$text['core_page_view']['edit'][23] = 'Location in the menu';
$text['core_page_view']['edit'][24] = 'Position';
$text['core_page_view']['edit'][25] = 'Do not display creates an orphan page that cannot be accessed via the menus.';
$text['core_page_view']['edit'][26] = 'Parent page';
$text['core_page_view']['edit'][27] = 'A deactivated page is not clickable in disconnected mode, the child pages are visible and accessible. The home page cannot be disabled.';
$text['core_page_view']['edit'][28] = 'Displays the parent page name followed by the page name, the title should not be hidden.';
$text['core_page_view']['edit'][29] = 'Advanced location options';
$text['core_page_view']['edit'][30] = 'Hide child pages in the horizontal menu';
$text['core_page_view']['edit'][31] = 'Hide the page and child pages in the sidebar menu';
$text['core_page_view']['edit'][32] = 'The page is displayed in a horizontal menu but not in the vertical menu of a sidebar.';
$text['core_page_view']['edit'][33] = 'Permission and referencing';
$text['core_page_view']['edit'][34] = 'Group required to access the page:';
$text['core_page_view']['edit'][35] = 'Meta title';
$text['core_page_view']['edit'][36] = 'Meta description';
$text['core_page_view']['edit'][37] = 'Disabled';
$text['core_page_view']['edit'][38] = 'New tab';
$text['core_page_view']['edit'][39] = 'Title hidden';
$text['core_page_view']['edit'][40] = 'Breadcrumb';
$text['core_page_view']['edit'][41] = "Are you sure you want to delete this page ?";
$text['core_page_view']['edit'][42] = "The data in the module ";
$text['core_page_view']['edit'][43]	= " will be deleted. Do you confirm?";
$text['core_page_view']['edit'][44] = "Group required to edit the page :";
$text['core_page_view']['edit'][45] = "You do not have editing rights, contact an administrator.";
$text['core_page_view']['edit'][46] = 'Allows visitors to leave a comment on the page. The configuration is common to all pages, the management specific to each page.';
$text['core_page_view']['edit'][47] = 'Comments';
$text['core_page_view']['edit'][48] = 'Configure';
$text['core_page_view']['edit'][49] = 'Manage comments';
$text['core_page_view']['edit'][50] = 'Allow comments';
$text['core_page']['duplicate'][0] = "Invalid token";
$text['core_page']['duplicate'][1] = "Unauthorised duplication";
$text['core_page']['duplicate'][2] = "The page has been duplicated";
$text['core_page']['duplicate'][3] = "The page and its module have been duplicated";
$text['core_page']['add'][0] = "New page";
$text['core_page']['add'][1] = "Content of your new page.";
$text['core_page']['add'][2] = "New page created";
$text['core_page']['delete'][0] = "Invalid token";
$text['core_page']['delete'][1] = "Unauthorized deletion";
$text['core_page']['delete'][2] = "Disable the page in the configuration before deleting it";
$text['core_page']['delete'][3] = "Cannot delete a page containing children";
$text['core_page']['delete'][4] = "Deleted page";
$text['core_page']['edit'][0] = "Changes saved";
$text['core_page']['edit'][1] = "None";
$text['core_page_view']['comment'][1] = 'Return';
$text['core_page_view']['comment'][2] = 'Data';
$text['core_page_view']['comment'][3] = 'Export CSV';
$text['core_page_view']['comment'][4] = 'Clear all';
$text['core_page_view']['comment'][5] = 'No data';
$text['core_page_view']['comment'][6] = 'Are you sure you want to delete this data?';
$text['core_page_view']['comment'][7] = 'Are you sure you want to delete all data?';
$text['core_page']['commentDelete'][1] = 'Data deleted';
$text['core_page']['commentDelete'][2] = 'Unauthorized access';
$text['core_page']['exportToCsv'][1] = 'Data exported to file ';
$text['core_page']['exportToCsv'][2] = 'No data to export';
$text['core_page']['commentAllDelete'][1] = 'Unauthorized access';
$text['core_page']['commentAllDelete'][2] = 'Data deleted';
$text['core_page']['commentAllDelete'][3] = 'No data to delete';

// Tinymce et Flatpickr	
$lang_admin = 'en_GB';
$lang_flatpickr = 'default';
// Selects
$pagesNoParentId = [
	'' => 'None'
];
$pagesBarId = [
	'' => 'None'
];
$typeMenu = [
	'text' => 'Text',
	'icon' => 'Icon',
	'icontitle' => 'Icon with text bubble'
];
$modulePosition = [
	'bottom' => 'Bottom',
	'top'    => 'Top',
	'free'   => 'Free'
];
$pageBlocks = [
	'12'    => 'Standard page',
	'4-8'   => 'Bar 1/3 - page 2/3',
	'8-4'   => 'Page 2/3 - bar 1/3',
	'3-9'   => 'Bar 1/4 - page 3/4',
	'9-3'   => 'Page 3/4 - bar 1/4',
	'3-6-3' => 'Bar 1/4 - page 1/2 - bar 1/4',
	'2-7-3' => 'Bar 2/12 - page 7/12 - bar 3/12 ',
	'3-7-2' => 'Bar 3/12 - page 7/12 - bar 2/12 ',
	'2-8-2' => 'Bar 2/12 - page 8/12 - bar 2/12 ',
	'bar'	=> 'Sidebar'
];
$displayMenu = [
	'none'	=> 'None',
	'parents' 	=> 'Menu',
	'children'	=> 'The submenu of the parent page'
];
$groupPublics = [
	self::GROUP_VISITOR => 'Visitor',
	self::GROUP_MEMBER => 'Member',
	self::GROUP_EDITOR => 'Editor',
	self::GROUP_MODERATOR => 'Moderator',
	self::GROUP_ADMIN => 'Administrator'
];
$groupEdit = [
	self::GROUP_EDITOR => 'Editor',
	self::GROUP_MODERATOR => 'Moderator',
	self::GROUP_ADMIN => 'Administrator'
];
$groupEditModerator = [
	self::GROUP_EDITOR => 'Editor',
	self::GROUP_MODERATOR => 'Moderator'
];
?>