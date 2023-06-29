<?php
// Lexique
include('./module/news/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_news.php');

echo template::formOpen('newsConfig'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('newsConfigBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),'posts',
				'ico' => 'left',
				'value' => $text['news_view']['config'][0]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('newsIndexHelp', [
				'class' => 'buttonHelp',
				'ico' => 'help',
				'value' => $text['news_view']['config'][32]
			]); ?>
		</div>
		<div class="col2 <?php echo ($this->getUser('group') < self::GROUP_MODERATOR ? 'offset6' : 'offset4'); ?> ">
			<?php echo template::button('newsConfigAdd', [
				'href' => helper::baseUrl() . $this->getUrl(0) . '/add',
				'ico' => 'plus',
				'value' => $text['news_view']['config'][1]
			]); ?>
		</div>
		<div class="col2 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone'; ?>">
				<?php echo template::submit('newsConfigSubmit',[
					'value' => $text['news_view']['config'][2]
				]); ?>
		</div>
	</div>
	<!-- Aide à propos de la configuration de news, view config -->
	<div class="helpDisplayContent">
		<?php echo file_get_contents( $text['news_view']['config'][33]) ;?>
	</div>
	<div class="row <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone'; ?> ">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['news_view']['config'][3]; ?></div>
				<div class="row">
					<div class="col6">
						<?php echo template::checkbox('newsConfigShowFeeds', true, $text['news_view']['config'][4], [
							'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'feeds']),
							'help' => $text['news_view']['config'][5]
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('newsConfigFeedslabel', [
							'label' => $text['news_view']['config'][6],
							'value' => $this->getData(['module', $this->getUrl(0), 'config', 'feedsLabel'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::select('newsConfigItemsperCol', $columns, [
							'label' => $text['news_view']['config'][7],
							'selected' => $this->getData(['module', $this->getUrl(0),'config', 'itemsperCol'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('newsConfigItemsperPage', $module::$itemsList, [
							'label' => $text['news_view']['config'][8],
							'selected' => $this->getData(['module', $this->getUrl(0),'config', 'itemsperPage'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('newsConfigHeight', $height, [
							'label' => $text['news_view']['config'][9],
							'help' => $text['news_view']['config'][29],
							'selected' => $this->getData(['module', $this->getUrl(0),'config', 'height'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col3">
						<?php echo template::checkbox('newsThemeTitle', true, $text['news_view']['config'][25], [
							'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'hiddeTitle']),
							'help' => $text['news_view']['config'][24]
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::checkbox('newsThemeMedia', true, $text['news_view']['config'][34], [
							'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'hideMedia']),
							'help' => $text['news_view']['config'][35]
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::checkbox('newsThemeSameHeight', true, $text['news_view']['config'][26], [
							'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'sameHeight']),
							'help' => $text['news_view']['config'][27]
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::checkbox('newsThemeNoMargin', true, $text['news_view']['config'][30], [
							'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'noMargin']),
							'help' => $text['news_view']['config'][31]
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone'; ?> ">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['news_view']['config'][10]; ?></div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('newsThemeBackgroundColor', [
							'class' => 'colorPicker',
							'help' => $text['news_view']['config'][13],
							'label' => $text['news_view']['config'][15],
							'value' => $this->getData(['module', $this->getUrl(0),'theme', 'backgroundColor'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('newsThemeBorderColor', [
							'class' => 'colorPicker',
							'help' => $text['news_view']['config'][13],
							'label' => $text['news_view']['config'][14],
							'value' => $this->getData(['module', $this->getUrl(0),'theme', 'borderColor'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('newsThemeBorderWidth', $borderWidth, [
							'label' => $text['news_view']['config'][12],
							'selected' => $this->getData(['module', $this->getUrl(0),'theme', 'borderWidth'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::select('newsBorderRadius', $newsRadius, [
							'label' => $text['news_view']['config'][22],
							'selected' => $this->getData(['module', $this->getUrl(0),'theme', 'borderRadius'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('newsBorderShadows', $newsShadows, [
							'label' => $text['news_view']['config'][23],
							'selected' => $this->getData(['module', $this->getUrl(0),'theme', 'borderShadows'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if($module::$news): ?>
		<?php echo template::table([4, 2, 2, 2, 1, 1], $module::$news, [$text['news_view']['config'][16], $text['news_view']['config'][17], $text['news_view']['config'][18], $text['news_view']['config'][19], '', '']); ?>
		<?php echo $module::$pages; ?>
	<?php else: ?>
		<?php echo template::speech($text['news_view']['config'][20]); ?>
	<?php endif; ?>
<?php echo template::formClose(); ?>
<div class="moduleVersion"><?php echo $text['news_view']['config'][21]; ?>
	<?php echo $module::VERSION; ?>
</div>
<script>
	var textConfirm = <?php echo '"'.$text['news_view']['config'][28].'"'; ?>;
</script>
