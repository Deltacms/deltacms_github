<?php
// Lexique
$param = 'blog_view';
include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');

echo template::formOpen('blogConfig'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('blogConfigBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0), 'posts',
				'ico' => 'left',
				'value' => $text['blog_view']['config'][0]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('agendaIndexHelp', [
				'class' => 'buttonHelp',
				'ico' => 'help',
				'value' => $text['blog_view']['config'][15]
			]); ?>
		</div>
		<div class="col2 offset2 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone'; ?> ">
			<?php echo template::button('blogConfigTexts', [
				'href' => helper::baseUrl() . $this->getUrl(0) . '/texts',
				'ico' => '',
				'value' => $text['blog_view']['config'][13]
			]); ?>
		</div>
		<div class="col2 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'offset8'; ?>">
			<?php echo template::button('blogConfigAdd', [
				'href' => helper::baseUrl() . $this->getUrl(0) . '/add',
				'ico' => 'plus',
				'value' => $text['blog_view']['config'][1]
			]); ?>
		</div>
		<div class="col2 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone'; ?> ">
			<?php echo template::submit('blogConfigSubmit',[
				'value' => $text['blog_view']['config'][2]
			]); ?>
		</div>
	</div>
	<!-- Aide à propos de la configuration de blog, view config -->
	<div class="helpDisplayContent">
		<?php echo file_get_contents( $text['blog_view']['config'][16]) ;?>
	</div>
	<div class="row" <?php if($this->getUser('group') < self::GROUP_MODERATOR) { echo 'style="display: none;"'; } ?> >
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['blog_view']['config'][3]; ?></div>
				<div class="row">
					<div class="col6">
						<?php echo template::checkbox('blogConfigShowFeeds', true, $text['blog_view']['config'][4], [
							'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'feeds']),
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('blogConfigFeedslabel', [
							'label' => $text['blog_view']['config'][5],
							'value' => $this->getData(['module', $this->getUrl(0), 'config', 'feedsLabel'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col6 offset6">
						<?php echo template::select('blogConfigItemsperPage', $ItemsList, [
							'label' => $text['blog_view']['config'][6],
							'selected' => $this->getData(['module', $this->getUrl(0),'config', 'itemsperPage'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
<?php if($module::$articles): ?>
	<?php echo template::table([4, 4, 1, 1, 1, 1], $module::$articles, [$text['blog_view']['config'][7], $text['blog_view']['config'][8], $text['blog_view']['config'][9], $text['blog_view']['config'][10], '','']); ?>
	<?php echo $module::$pages; ?>
<?php else: ?>
	<?php echo template::speech($text['blog_view']['config'][11]); ?>
<?php endif; ?>
<div class="moduleVersion"><?php echo $text['blog_view']['config'][12]; ?>
	<?php echo $module::VERSION; ?>
</div>
<script>
	var textConfirm = <?php echo '"'.$text['blog_view']['config'][14].'"'; ?>;
</script>

