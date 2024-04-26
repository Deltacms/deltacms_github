<?php
// Lexique
$param = 'blog_view';
include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');

// Passage de la langue d'administration à Tinymce et flatpickr
$lang_admin = $text['blog_view']['add'][24];
$lang_flatpickr = $text['blog_view']['add'][25];
?>
<script> var lang_admin = "<?php echo $lang_admin; ?>";	var lang_flatpickr = "<?php echo $lang_flatpickr; ?>";</script>

<?php echo template::formOpen('blogAddForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('blogAddBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'ico' => 'left',
				'value' => $text['blog_view']['add'][0]
			]); ?>
		</div>
		<div class="col3 offset5">
			<?php echo template::button('blogAddDraft', [
				'uniqueSubmission' => true,
				'value' => $text['blog_view']['add'][1]
			]); ?>
			<?php echo template::hidden('blogAddState', [
				'value' => true
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('blogAddPublish', [
				'value' => $text['blog_view']['add'][2],
				'uniqueSubmission' => true
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['blog_view']['add'][3]; ?></div>
				<div class="row">
					<div class="col12">
						<?php echo template::text('blogAddTitle', [
							'label' => $text['blog_view']['add'][4]
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php $help =$text['blog_view']['add'][23];
						if( $this->getData(['theme', 'site', 'width']) !== '100%' )	$help = $text['blog_view']['add'][5]. ((int) substr($this->getData(['theme', 'site', 'width']), 0, -2) - (20 * 2)) . ' x 350 pixels.';
						echo template::file('blogAddPicture', [
							'help' => $help,
							'label' => $text['blog_view']['add'][6],
							'type' => 1
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('blogAddPictureSize', $pictureSizes, [
							'label' => $text['blog_view']['add'][7]
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('blogAddPicturePosition', $picturePositions, [
							'label' => $text['blog_view']['add'][8],
							'help' => $text['blog_view']['add'][9]
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col12">
					<?php echo template::checkbox('blogAddHidePicture', true, $text['blog_view']['add'][10], [
							'checked' => $this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2), 'hidePicture'])
							]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php echo template::textarea('blogAddContent', [
		'class' => 'editorWysiwyg'
	]); ?>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['blog_view']['add'][11]; ?></div>
				<div class="row">
					<div class="col4 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone'; ?> ">
						<?php echo template::select('blogAddUserId', $module::$users, [
							'label' => $text['blog_view']['add'][12],
							'selected' => $this->getUser('id')
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::date('blogAddPublishedOn', [
							'help' => $text['blog_view']['add'][13],
							'label' => $text['blog_view']['add'][14],
							'value' => time()
						]); ?>
					</div>
					<div class="col4 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone'; ?> ">
						<?php echo template::select('blogAddConsent', $articleConsent  , [
							'label' => $text['blog_view']['add'][15],
							'selected' => $module::EDIT_ALL,
							'help' => $text['blog_view']['add'][16]
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['blog_view']['add'][17]; ?></div>
				<div class="row">
					<div class="col4 ">
						<?php echo template::checkbox('blogAddCommentClose', true, $text['blog_view']['add'][18]); ?>
					</div>
					<div class="col4 commentOptionsWrapper ">
						<?php echo template::checkbox('blogAddCommentApproved', true, $text['blog_view']['add'][19]); ?>
					</div>
					<div class="col4 commentOptionsWrapper">
						<?php echo template::select('blogAddCommentMaxlength', $commentLength,[
							'help' => $text['blog_view']['add'][20],
							'label' => $text['blog_view']['add'][21]
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col3 commentOptionsWrapper offset2">
						<?php echo template::checkbox('blogAddCommentNotification', true, $text['blog_view']['add'][22]); ?>
					</div>
					<div class="col4 commentOptionsWrapper">
						<?php echo template::select('blogAddCommentGroupNotification', $groupNews); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
