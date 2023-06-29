<?php
// Lexique
$param = 'blog_view';
include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');
?>
<div class="row">
	<div class="col2">
		<?php echo template::button('blogCommentBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
			'ico' => 'left',
			'value' => $text['blog_view']['comment'][0]
		]); ?>
	</div>

<?php if($module::$comments ): ?>
	<div class="col2 offset8">
			<?php echo $module::$commentsDelete; ?>
	</div>

</div>
	<?php echo template::table([3, 5, 2, 1, 1], $module::$comments, [$text['blog_view']['comment'][1], $text['blog_view']['comment'][2], $text['blog_view']['comment'][3], '', '']); ?>
	<?php echo $module::$pages.'<br/>'; ?>
<?php else: ?>
</div>
	<?php echo template::speech($text['blog_view']['comment'][4]); ?>
<?php endif; ?>
