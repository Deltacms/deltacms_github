<?php
// Lexique
$param = 'blog_view';
include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');

// Passage de la langue d'administration à Tinymce et flatpickr
$lang_admin = $text['blog_view']['edit'][24];
$lang_flatpickr = $text['blog_view']['edit'][25];
?>
<script> var lang_admin = "<?php echo $lang_admin; ?>";	var lang_flatpickr = "<?php echo $lang_flatpickr; ?>";</script>

<?php echo template::formOpen('blogCommentEditForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('blogCommentEditBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'ico' => 'left',
				'value' => $text['blog_view']['edit'][0]
			]); ?>
		</div>
		<div class="col2 offset8">
			<?php echo template::submit('blogCommentEditSubmit', [
				'value' => $text['blog_view']['config'][2],
				'uniqueSubmission' => true,
			]); ?>
		</div>
	</div>

	<?php echo template::textarea('blogCommentEditContent', [
		'class' => 'editorWysiwygComment',
		'value' => $this->getData(['data_module', $this->getUrl(0), 'posts', $this->getUrl(2), 'comment', $this->getUrl(3), 'content'])
	]); ?>

<?php echo template::formClose(); ?>
