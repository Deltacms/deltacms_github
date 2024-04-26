<?php
// Lexique
$param = 'blog_view';
include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');

// Passage de la langue d'administration à Tinymce et flatpickr
$lang_admin = $text['blog_view']['edit'][24];
$lang_flatpickr = $text['blog_view']['edit'][25];
?>
<script> var lang_admin = "<?php echo $lang_admin; ?>";	var lang_flatpickr = "<?php echo $lang_flatpickr; ?>";</script>

<?php echo template::formOpen('blogEditForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('blogEditBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'ico' => 'left',
				'value' => $text['blog_view']['edit'][0]
			]); ?>
		</div>
		<div class="col3 offset5">
			<?php echo template::button('blogEditDraft', [
				'uniqueSubmission' => true,
				'value' => $text['blog_view']['edit'][1]
			]); ?>
			<?php echo template::hidden('blogEditState', [
				'value' => true
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('blogEditSubmit', [
				'value' => $text['blog_view']['edit'][2],
				'uniqueSubmission' => true,
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['blog_view']['edit'][3]; ?></div>
				<div class="row">
					<div class="col12">
						<?php echo template::text('blogEditTitle', [
							'label' => $text['blog_view']['edit'][4],
							'value' => $this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2), 'title'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col6">
						<?php $help = $text['blog_view']['add'][23];
						if( $this->getData(['theme', 'site', 'width']) !== '100%' ) $help = $text['blog_view']['edit'][5] . ((int) substr($this->getData(['theme', 'site', 'width']), 0, -2) - (20 * 2)) . ' x 350 pixels.';
						echo template::file('blogEditPicture', [
							'help' => $help,
							'label' => $text['blog_view']['edit'][6],
							'type' => 1,
							'value' => $this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2), 'picture'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::select('blogEditPictureSize', $pictureSizes, [
							'label' => $text['blog_view']['edit'][7],
							'selected' => $this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2), 'pictureSize'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::select('blogEditPicturePosition', $picturePositions, [
							'label' => $text['blog_view']['edit'][8],
							'selected' => $this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2), 'picturePosition']),
							'help' => $text['blog_view']['edit'][9]
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col6">
						<?php echo template::checkbox('blogEditHidePicture', true, $text['blog_view']['edit'][10], [
							'checked' => $this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2), 'hidePicture'])
							]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php echo template::textarea('blogEditContent', [
		'class' => 'editorWysiwyg',
		'value' => $this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2), 'content'])
	]); ?>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['blog_view']['edit'][11]; ?></div>
				<div class="row">
					<div class="col4 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone'; ?> ">
						<?php echo template::select('blogEditUserId', $module::$users, [
							'label' => $text['blog_view']['edit'][12],
							'selected' => $this->getUser('id')
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::date('blogEditPublishedOn', [
							'help' => $text['blog_view']['edit'][13],
							'label' => $text['blog_view']['edit'][14],
							'value' => $this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2), 'publishedOn'])
						]); ?>
					</div>
					<div class="col4 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone'; ?> ">
						<?php echo template::select('blogEditConsent', $articleConsent  , [
							'label' => $text['blog_view']['edit'][15],
							'selected' => is_numeric($this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2), 'editConsent'])) ? $module::EDIT_GROUP : $this->getData(['data_module', $this->getUrl(0), 'posts',  $this->getUrl(2), 'editConsent']),
							'help' => $text['blog_view']['edit'][16]
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo$text['blog_view']['edit'][17]; ?></div>
				<div class="row">
					<div class="col4 ">
						<?php echo template::checkbox('blogEditCommentClose', true, $text['blog_view']['edit'][18], [
							'checked' => $this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2), 'commentClose'])
						]); ?>
					</div>
					<div class="col4 commentOptionsWrapper ">
						<?php echo template::checkbox('blogEditCommentApproved', true, $text['blog_view']['edit'][19], [
							'checked' => $this->getData(['data_module', $this->getUrl(0), 'posts',  $this->getUrl(2), 'commentApproved']),
							''
						]); ?>
					</div>
					<div class="col4 commentOptionsWrapper">
						<?php echo template::select('blogEditCommentMaxlength', $commentLength,[
							'help' => $text['blog_view']['edit'][20],
							'label' => $text['blog_view']['edit'][21],
							'selected' => $this->getData(['data_module', $this->getUrl(0), 'posts',  $this->getUrl(2), 'commentMaxlength'])
						]); ?>
					</div>

				</div>
				<div class="row">
					<div class="col3 commentOptionsWrapper offset2">
						<?php echo template::checkbox('blogEditCommentNotification', true, $text['blog_view']['edit'][22], [
							'checked' => $this->getData(['data_module', $this->getUrl(0), 'posts',  $this->getUrl(2), 'commentNotification']),
						]); ?>
					</div>
					<div class="col4 commentOptionsWrapper">
						<?php echo template::select('blogEditCommentGroupNotification', $groupNews, [
							'selected' => $this->getData(['data_module', $this->getUrl(0), 'posts',  $this->getUrl(2), 'commentGroupNotification']),
							'help' => $text['blog_view']['edit'][23]
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
