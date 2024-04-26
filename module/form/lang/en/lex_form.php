<?php
// Lexique du module Form en anglais
$text['form_view']['config'][0] = 'Heading';
$text['form_view']['config'][1] = 'No option for this field';
$text['form_view']['config'][2] = 'Comma separated list of values (value1,value2,...)';
$text['form_view']['config'][3] = 'Required field';
$text['form_view']['config'][4] = 'Back';
$text['form_view']['config'][5] = 'Manage data';
$text['form_view']['config'][6] = 'Configuration';
$text['form_view']['config'][7] = 'Leave blank to keep default text';
$text['form_view']['config'][8] = 'Submit button text';
$text['form_view']['config'][9] = 'Send entered data by email :';		
$text['form_view']['config'][10] = 'Select at least one group, user or enter an email. Your server must allow mail to be sent.';
$text['form_view']['config'][11] = 'Leave blank to keep the default text';
$text['form_view']['config'][12] = 'Mail subject';
$text['form_view']['config'][13] = 'To groups from ';
$text['form_view']['config'][14] = 'Editors = editors + administrators<br/> Members = members + editors + administrators';
$text['form_view']['config'][15] = 'To a member';
$text['form_view']['config'][16] = 'To an email address';
$text['form_view']['config'][17] = 'An email or mailing list';
$text['form_view']['config'][18] = 'Reply to the sender from the notification email';
$text['form_view']['config'][19] = 'This option allows the sender of the message to be replied to directly if he/she has given a valid email address';
$text['form_view']['config'][20] = 'Select signature type';
$text['form_view']['config'][21] = 'Select the site logo';
$text['form_view']['config'][22] = 'Logo';
$text['form_view']['config'][23] = 'Select logo width';
$text['form_view']['config'][24] = 'Redirect after form submission';
$text['form_view']['config'][25] = 'Select a page from the site:';
$text['form_view']['config'][26] = 'Validate a captcha in order to submit the form';
$text['form_view']['config'][27] = 'List of fields';
$text['form_view']['config'][28] = 'The form contains no fields';
$text['form_view']['config'][29] = 'Version no.';
$text['form_view']['config'][30] = 'Register';
$text['form_view']['config'][31] = 'Maximum size of the attachment';
$text['form_view']['config'][32] = 'Permitted file types';
$text['form_view']['config'][33] = 'jpg';
$text['form_view']['config'][34] = 'png';
$text['form_view']['config'][35] = 'pdf';
$text['form_view']['config'][36] = 'zip';
$text['form_view']['config'][37] = 'txt';
$text['form_view']['config'][38] = 'Note in the label of the file field the type and size of files allowed. Checks are performed on jpg, png, pdf and zip files but not on txt files. Be careful!';
$text['form_view']['config'][39] = 'Help';
$text['form_view']['config'][40] = 'module/form/view/config/config.help_en.html';
$text['form_view']['config'][41] = 'Check box for acceptance of the conditions of use of personal data';
$text['form_view']['config'][42] = 'If your questionnaire concerns personal data, the GDPR in certain countries requires acceptance of their conditions of use by the participant. You must also explain why you are using this data. The associated text must be updated in location configuration.';
$text['form_view']['data'][0] = 'Back';
$text['form_view']['data'][1] = 'Delete all';
$text['form_view']['data'][2] = 'CSV export';
$text['form_view']['data'][3] = 'Data';
$text['form_view']['data'][4] = 'No data';
$text['form_view']['data'][5] = 'Version No';
$text['form_view']['data'][6] = "Are you sure you want to delete this data ?";
$text['form_view']['data'][7] = "Are you sure you want to delete all the data ?";
$text['form_view']['index'][0] = 'Send';
$text['form_view']['index'][1] = 'The form contains no fields';
$text['form_view']['index'][2] = 'default';
$text['form']['config'][0] = 'Saved changes';
$text['form']['config'][1] = 'Module configuration';
$text['form']['data'][0] = 'Registered data';
$text['form']['export2csv'][0] = 'Action not allowed';
$text['form']['export2csv'][1] = 'CSV export performed in the file manager under the name ';
$text['form']['export2csv'][2] = 'No data to export';
$text['form']['deleteall'][0] = 'Unauthorised action';
$text['form']['deleteall'][1] = 'Data deleted';
$text['form']['deleteall'][2] = 'No data to be deleted';
$text['form']['delete'][0] = 'Unauthorised action';
$text['form']['delete'][1] = 'Data deleted';
$text['form']['index'][0] = 'Wrong Captcha';
$text['form']['index'][1] = 'New message from your site';
$text['form']['index'][2] = 'New message from the page "';
$text['form']['index'][3] = 'Form submitted';
$text['form']['index'][4] = 'File is not an image';
$text['form']['index'][5] = '?';
$text['form']['index'][6] = 'File size exceeds ';
$text['form']['index'][7] = 'This type of file is not allowed';
$text['form']['index'][8] = 'Error while uploading file' ;
$text['form']['index'][9] = 'failure, the message is not sent because ';
$text['form']['index'][10] = 'The attachment is not a pdf document';
$text['form']['index'][11] = 'The attachment is not a zip document';
$text['form']['index'][12] = ' Fill in the Captcha ';
// Initialisation de flatpickr
$lang_flatpickr = 'default';
// Langue d'administration pour tinymce
$lang_admin = 'en_GB';
// Selects
$signature = [
	'text' => 'Name of the site',
	'logo' => 'Website logo'
];
if( $param === 'form_view'){
	$groupNews = [
		self::GROUP_MEMBER => 'Member',
		self::GROUP_EDITOR => 'Editor',
		self::GROUP_MODERATOR => 'Moderator',
		self::GROUP_ADMIN => 'Administrator'
	];
	$types = [
		$module::TYPE_LABEL => 'Label',
		$module::TYPE_TEXT => 'Text field',
		$module::TYPE_TEXTAREA => 'Large text field',
		$module::TYPE_MAIL => 'Mail field',
		$module::TYPE_SELECT => 'Selection',
		$module::TYPE_CHECKBOX => 'Check box',
		$module::TYPE_DATETIME => 'Date',
		$module::TYPE_FILE => 'file'
	];
}
?>