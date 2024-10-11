<?php
// Lexique
$param = 'blog_view';
include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');

// drapeau pour la langue d'origine ou la langue en traduction rédigée
if( $this->getInput('DELTA_I18N_SITE') === '' || $this->getInput('DELTA_I18N_SITE')=== null || $this->getInput('DELTA_I18N_SITE') === 'base'){
	$flag = $this->getData(['config', 'i18n', 'langBase']);
}
else{
	$flag = $this->getInput('DELTA_I18N_SITE');
}
?>
<?php echo template::formOpen('blogTexts'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('blogTextsBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0). '/config',
				'ico' => 'left',
				'value' => $text['blog_view']['texts'][0]
			]); ?>
		</div>
		<div class="col2 offset8">
			<?php echo template::submit('blogTextsSubmit',[
				'value' => $text['blog_view']['texts'][2]
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['blog_view']['texts'][1]; ?><?php echo ' '.template::flag($flag, '20px');?></div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('blogTextsNoComment', [
							'label' => $text['blog_view']['texts'][3],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'NoComment'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('blogTextsWrite', [
							'label' => $text['blog_view']['texts'][4],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'Write'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('blogTextsName', [
							'label' => $text['blog_view']['texts'][5],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'Name'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('blogTextsMaxi', [
							'label' => $text['blog_view']['texts'][6],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'Maxi'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('blogTextsCara', [
							'label' => $text['blog_view']['texts'][7],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'Cara'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('blogTextsComment', [
							'label' => $text['blog_view']['texts'][8],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'Comment'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('blogTextsComments', [
							'label' => $text['blog_view']['texts'][28],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'Comments'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('blogTextsCommentOK', [
							'label' => $text['blog_view']['texts'][9],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'CommentOK'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('blogTextsWaiting', [
							'label' => $text['blog_view']['texts'][10],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'Waiting'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('blogTextsArticleNoComment', [
							'label' => $text['blog_view']['texts'][11],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'ArticleNoComment'])
						]); ?>
					</div>				
					<div class="col4">
						<?php echo template::text('blogTextsConnection', [
							'label' => $text['blog_view']['texts'][13],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'Connection'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('blogTextsEdit', [
							'label' => $text['blog_view']['texts'][15],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'Edit'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('blogTextsCancel', [
							'label' => $text['blog_view']['texts'][16],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'Cancel'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('blogTextsSend', [
							'label' => $text['blog_view']['texts'][17],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'Send'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('blogTextsTinymceMaxi', [
							'label' => $text['blog_view']['texts'][18],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'TinymceMaxi'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('blogTextsTinymceCara', [
							'label' => $text['blog_view']['texts'][19],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'TinymceCara'])
						]); ?>
					</div>				
					<div class="col4">
						<?php echo template::text('blogTextsTinymceExceed', [
							'label' => $text['blog_view']['texts'][20],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'TinymceExceed'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('blogTextsReadMore', [
							'label' => $text['blog_view']['texts'][26],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'ReadMore'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('blogTextsBack', [
							'label' => $text['blog_view']['texts'][27],
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'Back'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
<div class="moduleVersion"><?php echo $text['blog_view']['texts'][25]; ?>
	<?php echo $module::VERSION; ?>
</div>

