<?php
// Lexique
include('./core/module/page/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_page.php');

// Passage de la langue d'administration à Tinymce et flatpickr
?>
<script> var lang_admin = "<?php echo $lang_admin; ?>";	var lang_flatpickr = "<?php echo $lang_flatpickr; ?>";</script>

<?php echo template::formOpen('pageCommentEditForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('pageCommentEditBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0). '/comment/'.  $this->getUrl(2),
				'ico' => 'left',
				'value' => $text['core_page_view']['commentEdit'][0]
			]); ?>
		</div>
		<div class="col2 offset8">
			<?php echo template::submit('pageCommentEditSubmit', [
				'value' => $text['core_page_view']['commentEdit'][1],
				'uniqueSubmission' => true,
			]); ?>
		</div>
	</div>

	<?php echo template::textarea('pageCommentEditContent', [
		'class' => 'editorWysiwygComment',
		'value' => $this->getData(['comment', $this->getUrl(2), 'data', $this->getUrl(3) , 'Commentaire' ])
	]); ?>

<?php echo template::formClose(); ?>
