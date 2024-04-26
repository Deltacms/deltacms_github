<?php
// Lexique
include('./module/news/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_news.php');

// Passage de la langue d'administration à Tinymce et flatpickr
$lang_admin = $text['news_view']['edit'][12];
$lang_flatpickr = $text['news_view']['edit'][13];
?><script> var lang_admin = "<?php echo $lang_admin; ?>";	var lang_flatpickr = "<?php echo $lang_flatpickr; ?>";var newsAddEdit = true;</script>

<?php echo template::formOpen('newsEditForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('newsEditBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'ico' => 'left',
				'value' => $text['news_view']['edit'][0]
			]); ?>
		</div>
		<div class="col3 offset5">
			<?php echo template::button('newsEditDraft', [
				'uniqueSubmission' => true,
				'value' => $text['news_view']['edit'][1]
			]); ?>
			<?php echo template::hidden('newsEditState', [
				'value' => true
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('newsEditSubmit', [
				'value' => $text['news_view']['edit'][2],
				'uniqueSubmission' => true
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['news_view']['edit'][3]; ?></div>
				<?php echo template::text('newsEditTitle', [
					'label' => $text['news_view']['edit'][4],
					'value' => $this->getData(['data_module', $this->getUrl(0),'posts', $this->getUrl(2), 'title'])
				]); ?>
			</div>
		</div>
	</div>
	<?php echo template::textarea('newsEditContent', [
		'class' => 'editorWysiwyg',
		'value' => $this->getData(['data_module', $this->getUrl(0),'posts', $this->getUrl(2), 'content'])
	]); ?>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['news_view']['edit'][5]; ?></div>
				<div class="row">
					<div class="col4 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone'; ?> ">
						<?php echo template::select('newsEditUserId', $module::$users, [
							'label' => $text['news_view']['edit'][6],
							'selected' => $this->getUser('id')
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::date('newsEditPublishedOn', [
							'help' => $text['news_view']['edit'][7],
							'label' => $text['news_view']['edit'][8],
							'value' => $this->getData(['data_module', $this->getUrl(0),'posts', $this->getUrl(2), 'publishedOn'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::date('newsEditPublishedOff', [
							'help' => $text['news_view']['edit'][9],
							'label' => $text['news_view']['edit'][10],
							'value' => $this->getData(['data_module', $this->getUrl(0),'posts', $this->getUrl(2), 'publishedOff'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
