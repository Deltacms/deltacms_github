<?php
// Lexique
include('./module/news/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_news.php');

// Passage de la langue d'administration à Tinymce et flatpickr
$lang_admin = $text['news_view']['add'][12];
$lang_flatpickr = $text['news_view']['add'][13];
?><script> var lang_admin = "<?php echo $lang_admin; ?>";	var lang_flatpickr = "<?php echo $lang_flatpickr; ?>";var newsAddEdit = true;</script>

<?php echo template::formOpen('newsAddForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('newsAddBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'ico' => 'left',
				'value' => $text['news_view']['add'][0]
			]); ?>
		</div>
		<div class="col3 offset5">
			<?php echo template::button('newsAddDraft', [
				'uniqueSubmission' => true,
				'value' => $text['news_view']['add'][1]
			]); ?>
			<?php echo template::hidden('newsAddState', [
				'value' => true
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('newsAddPublish', [
				'value' => $text['news_view']['add'][2],
				'uniqueSubmission' => true
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['news_view']['add'][5]; ?></div>
				<?php echo template::text('newsAddTitle', [
					'label' => $text['news_view']['add'][3]
				]); ?>
			</div>
		</div>
	</div>
	<?php echo template::textarea('newsAddContent', [
		'class' => 'editorWysiwyg'
	]); ?>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['news_view']['add'][6]; ?></div>
				<div class="row">
					<div class="col4 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone'; ?> ">
						<?php echo template::select('newsAddUserId', $module::$users, [
							'label' => $text['news_view']['add'][4],
							'selected' => $this->getUser('id')
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::date('newsAddPublishedOn', [
							'help' => $text['news_view']['add'][7],
							'label' => $text['news_view']['add'][8],
							'value' => time()
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::date('newsAddPublishedOff', [
							'help' => $text['news_view']['add'][9],
							'label' => $text['news_view']['add'][10],
							'value' => $this->getData(['data_module', $this->getUrl(0),'posts', $this->getUrl(2), 'publishedOff'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
