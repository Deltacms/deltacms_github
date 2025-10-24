<?php
// Lexique du module Guestbook en anglais
$text['guestbook_view']['config'][0] = 'Heading';
$text['guestbook_view']['config'][1] = 'No option for this field';
$text['guestbook_view']['config'][2] = 'Comma separated list of values (value1,value2,...)';
$text['guestbook_view']['config'][3] = 'Required field';
$text['guestbook_view']['config'][4] = 'Back';
$text['guestbook_view']['config'][5] = 'Manage data';
$text['guestbook_view']['config'][6] = 'Configuration';
$text['guestbook_view']['config'][9] = 'Send entered data by email :';
$text['guestbook_view']['config'][10] = 'Select at least one group, user or enter an email. Your server must allow mail to be sent.';
$text['guestbook_view']['config'][11] = 'Leave blank to keep the default text';
$text['guestbook_view']['config'][12] = 'Mail subject';
$text['guestbook_view']['config'][13] = 'To groups from ';
$text['guestbook_view']['config'][14] = 'Editors = editors + administrators<br/> Members = members + editors + administrators';
$text['guestbook_view']['config'][15] = 'To a member';
$text['guestbook_view']['config'][16] = 'To an email address';
$text['guestbook_view']['config'][17] = 'An email or mailing list';
$text['guestbook_view']['config'][18] = 'Reply to the sender from the notification email';
$text['guestbook_view']['config'][19] = 'This option allows the sender of the message to be replied to directly if he/she has given a valid email address';
$text['guestbook_view']['config'][20] = 'Select signature type';
$text['guestbook_view']['config'][21] = 'Select the site logo';
$text['guestbook_view']['config'][22] = 'Logo';
$text['guestbook_view']['config'][23] = 'Select logo width';
$text['guestbook_view']['config'][24] = 'Redirect after form submission';
$text['guestbook_view']['config'][25] = 'Select a page from the site:';
$text['guestbook_view']['config'][26] = 'Validate a captcha in order to submit the form';
$text['guestbook_view']['config'][27] = 'List of fields';
$text['guestbook_view']['config'][28] = 'The form contains no fields';
$text['guestbook_view']['config'][29] = 'Version no.';
$text['guestbook_view']['config'][30] = 'Register';
$text['guestbook_view']['config'][38] = 'Note in the label of the file field the type and size of files allowed. Checks are performed on jpg, png, pdf and zip files but not on txt files. Be careful!';
$text['guestbook_view']['config'][39] = 'Help';
$text['guestbook_view']['config'][40] = 'module/guestbook/view/config/config.help_en.html';
$text['guestbook_view']['config'][41] = 'Check box for acceptance of the conditions of use of personal data';
$text['guestbook_view']['config'][42] = 'If your questionnaire concerns personal data, the GDPR in certain countries requires acceptance of their conditions of use by the participant. You must also explain why you are using this data. The associated text must be updated in location configuration.';
$text['guestbook_view']['config'][43] = 'Texts ';
$text['guestbook_view']['config'][44] = 'To prevent the email from being considered spam, it is preferable to choose a signature with the name of the site';
$text['guestbook_view']['texts'][0] = 'Back';
$text['guestbook_view']['texts'][1] = 'Save';
$text['guestbook_view']['texts'][2] = 'Adapt these texts to the language of your visitors ';
$text['guestbook_view']['texts'][3] = 'Version n°';
$text['guestbook_view']['data'][0] = 'Back';
$text['guestbook_view']['data'][1] = 'Delete all';
$text['guestbook_view']['data'][2] = 'CSV export';
$text['guestbook_view']['data'][3] = 'Data';
$text['guestbook_view']['data'][4] = 'No data';
$text['guestbook_view']['data'][5] = 'Version No';
$text['guestbook_view']['data'][6] = "Are you sure you want to delete this data ?";
$text['guestbook_view']['data'][7] = "Are you sure you want to delete all the data ?";
$text['guestbook_view']['index'][0] = 'Send';
$text['guestbook_view']['index'][1] = 'The form contains no fields';
$text['guestbook_view']['index'][2] = 'default';
$text['guestbook_view']['index'][3] = 'No message yet';
$text['guestbook']['config'][0] = 'Saved changes';
$text['guestbook']['config'][1] = 'Module configuration';
$text['guestbook']['texts'][0] = 'Texts visible to a visitor';
$text['guestbook']['texts'][1] = 'Texts saved ';
$text['guestbook']['data'][0] = 'Registered data';
$text['guestbook']['export2csv'][0] = 'Action not allowed';
$text['guestbook']['export2csv'][1] = 'CSV export performed in the file manager under the name ';
$text['guestbook']['export2csv'][2] = 'No data to export';
$text['guestbook']['deleteall'][0] = 'Unauthorised action';
$text['guestbook']['deleteall'][1] = 'Data deleted';
$text['guestbook']['deleteall'][2] = 'No data to be deleted';
$text['guestbook']['delete'][0] = 'Unauthorised action';
$text['guestbook']['delete'][1] = 'Data deleted';
$text['guestbook']['index'][0] = 'Wrong Captcha';
$text['guestbook']['index'][1] = 'New message from your site';
$text['guestbook']['index'][2] = 'New message from the page "';
$text['guestbook']['index'][3] = 'Form submitted';
$text['guestbook']['index'][9] = 'failure, the message is not sent because ';
$text['guestbook']['index'][10] = 'Date';
$text['guestbook']['index'][12] = ' Fill in the Captcha ';
$text['guestbook']['index'][13] = 'Display or hide form';
// Initialisation de flatpickr
$lang_flatpickr = 'default';
// Langue d'administration pour tinymce
$lang_admin = 'en_GB';
// Selects
$signature = [
	'text' => 'Name of the site',
	'logo' => 'Website logo'
];
if( $param === 'guestbook_view'){
	$groupNews = [
		self::GROUP_MEMBER => 'Member',
		self::GROUP_EDITOR => 'Editor',
		self::GROUP_MODERATOR => 'Moderator',
		self::GROUP_ADMIN => 'Administrator'
	];
	$types = [
		$module::TYPE_TEXT => 'Text field',
		$module::TYPE_TEXTAREA => 'Large text field',
		$module::TYPE_MAIL => 'Mail field'
	];
}
?>
