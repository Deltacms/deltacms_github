<?php
// Lexique
$param = 'blog_view';
include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');

// Adaptation de la langue dans tinymce pour la rédaction d'un commentaire en fonction de la langue de la page, originale ou en traduction rédigée
$lang = $this->getData(['config', 'i18n', 'langBase']);
if ( !empty($_COOKIE["DELTA_I18N_SITE"])) {
	if( $this->getInput('DELTA_I18N_SITE') !== 'base' ) $lang = $this->getInput('DELTA_I18N_SITE');
}
$lang_page = $lang;
switch ($lang) {
	case 'en' :
		$lang_page = 'en_GB';
		break;
	case 'pt' :
		$lang_page = 'pt_PT';
		break;
	case 'sv' :
		$lang_page = 'sv_SE';
		break;
	case 'fr' :
		$lang_page = 'fr_FR';
		break;
}
// Si la langue n'est pas supportée par Tinymce la langue d'administration est utilisée
if( ! file_exists( 'core/vendor/tinymce/langs/'.$lang_page.'.js' )){
	$lang_page = $text['blog_view']['article'][0];
}
echo '<script> var lang_admin = "'.$lang_page.'"; </script>';

// Pour les dates suivant la langue de rédaction du site (langue principale ou langue de traduction rédigée)
if( function_exists('datefmt_create') && function_exists('datefmt_format') && extension_loaded('intl') ){
	if( isset( $_SESSION['langFrontEnd']) && isset( $_SESSION['translationType']) && $_SESSION['translationType'] === 'site' ){
		$lang_date =  $_SESSION['langFrontEnd'];
	} else {
		$lang_date = $this->getData(['config', 'i18n', 'langBase']);
	}
	$zone = 'Europe/Paris';
	$fmt = datefmt_create(
		$lang_date,
		IntlDateFormatter::LONG,
		IntlDateFormatter::SHORT,
		$zone,
		IntlDateFormatter::GREGORIAN
	);
}
?>

<div class="row">
	<div class="col12">
		<?php $pictureSize =  $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'pictureSize']) === null ? '100' : $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'pictureSize']); ?>
		<?php if ( $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'hidePicture']) === false
					&& $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'picture']) !=='' ) {
			echo '<img class="blogArticlePicture blogArticlePicture' . $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'picturePosition']) .
			' pict' . $pictureSize . '" src="' . helper::baseUrl(false) . self::FILE_DIR.'source/' . $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'picture']) .
			'" alt="' . $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'picture']) . '">';
		} ?>
		<?php echo $this->getData(['module', $this->getUrl(0),'posts', $this->getUrl(1), 'content']); ?>
	</div>
</div>
<div class="row verticalAlignMiddle">
	<div class="col12 blogDate">
		<!-- bloc signature et date -->
		<?php echo $module::$articleSignature . ' - ';?>
		<?php if( function_exists('datefmt_create') && function_exists('datefmt_format') && extension_loaded('intl') ){
			echo datefmt_format($fmt, strtotime( date('Y/m/d H:i:s',$this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'publishedOn']))));
		} else{
			$date = mb_detect_encoding( date('d/m/Y', $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'publishedOn'])), 'UTF-8', true)
					? date('d/m/Y', $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'publishedOn']))
					: utf8_encode(date('d/m/Y', $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'publishedOn'])));
			$heure =  mb_detect_encoding(date('H:i', $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'publishedOn'])), 'UTF-8', true)
					? date('H:i', $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'publishedOn']))
					:  utf8_encode(date('H:i', $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'publishedOn'])));
			echo $date . ' - ' . $heure;
		} ?>

		<!-- Bloc edition -->
		<?php if (

			$this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')
			AND
			(  // Propriétaire
				(
						$this->getData(['module',  $this->getUrl(0), 'posts', $this->getUrl(1),'editConsent']) === $module::EDIT_OWNER
						AND ( $this->getData(['module',  $this->getUrl(0), 'posts', $this->getUrl(1),'userId']) === $this->getUser('id')
						OR $this->getUser('group') === self::GROUP_ADMIN )
			)
			OR (
					// Groupe
					( $this->getData(['module',  $this->getUrl(0), 'posts',  $this->getUrl(1),'editConsent']) === self::GROUP_ADMIN
					OR $this->getData(['module',  $this->getUrl(0), 'posts',  $this->getUrl(1),'editConsent']) === self::GROUP_MODERATOR)
					AND $this->getUser('group') >=  $this->getData(['module',$this->getUrl(0), 'posts', $this->getUrl(1),'editConsent'])
			)
			OR (
					// Tout le monde
					$this->getData(['module',  $this->getUrl(0), 'posts',  $this->getUrl(1),'editConsent']) === $module::EDIT_ALL
					AND $this->getUser('group') >= $module::$actions['config']
				)
			)
		): ?>
				<a href ="<?php echo helper::baseUrl() . $this->getUrl(0) . '/edit/' . $this->getUrl(1) . '/' . $_SESSION['csrf'];?>">
					<?php echo template::ico('pencil'); echo $this->getData(['module', $this->getUrl(0), 'texts', 'Edit']);?>
				</a>
		<?php endif; ?>
		<!-- Bloc RSS-->
		<?php if ($this->getData(['module',$this->getUrl(0), 'config', 'feeds'])): ?>
			<div id="rssFeed">
				<a type="application/rss+xml" href="<?php echo helper::baseUrl() . $this->getUrl(0) . '/rss'; ?>" target="_blank">
					<img  src='module/news/ressource/feed-icon-16.gif' />
					<?php
						echo '<p>' . $this->getData(['module',$this->getUrl(0), 'config', 'feedsLabel']) . '</p>' ;
					?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php if($this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'commentClose'])): ?>
	<p><?php echo $this->getData(['module', $this->getUrl(0), 'texts', 'ArticleNoComment']); ?></p>
<?php else: ?>
	<h3 id="comment">
		<?php  //$commentsNb = count($module::$comments); ?>
		<?php $commentsNb = $module::$nbCommentsApproved; ?>
		<?php $s =  $commentsNb === 1 ? '': 's' ?>
		<?php echo $commentsNb > 0 ? $commentsNb . ' ' .  $this->getData(['module', $this->getUrl(0), 'texts', 'Comment']) . $s : $this->getData(['module', $this->getUrl(0), 'texts', 'NoComment']); ?>
	</h3>
	<?php echo template::formOpen('blogArticleForm'); ?>
		<?php echo template::text('blogArticleCommentShow', [
			'placeholder' => $this->getData(['module', $this->getUrl(0), 'texts', 'Write']),
			'readonly' => true
		]); ?>
		<div id="blogArticleCommentWrapper" class="displayNone">
				<?php if($this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')): ?>
				<?php echo template::text('blogArticleUserName', [
					'label' => $this->getData(['module', $this->getUrl(0), 'texts', 'Name']),
					'readonly' => true,
					'value' => $module::$editCommentSignature
				]); ?>
				<?php echo template::hidden('blogArticleUserId', [
					'value' => $this->getUser('id')
				]); ?>
			<?php else: ?>
				<div class="row">
					<div class="col9 humanBot">
						<?php echo template::text('blogArticleAuthor', [
							'label' => $this->getData(['module', $this->getUrl(0), 'texts', 'Name']),
							'value' => isset( $_SESSION['commentAuthor'] ) ? $_SESSION['commentAuthor'] : ''
						]); ?>
					</div>
					<div class="col1 textAlignCenter verticalAlignBottom">
						<div id="blogArticleOr"><?php echo ' ';?></div>
					</div>
					<div class="col2 verticalAlignBottom">
						<?php echo template::button('blogArticleLogin', [
							'href' => helper::baseUrl() . 'user/login/' . str_replace('/', '_', $this->getUrl()) . '__comment',
							'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'Connection'])
						]); ?>
					</div>
				</div>
			<?php endif; ?>
			<div class="humanBot">
			<?php echo template::textarea('blogArticleContent', [
					'label' => $this->getData(['module', $this->getUrl(0), 'texts', 'Maxi']).' '.$this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'commentMaxlength']).' '.$this->getData(['module', $this->getUrl(0), 'texts', 'Cara']),
					'class' => 'editorWysiwygComment',
					'noDirty' => true,
					'maxlength' => $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'commentMaxlength']),
					'TinymceMaxi' => $this->getData(['module', $this->getUrl(0), 'texts', 'TinymceMaxi']),
					'TinymceCara' => $this->getData(['module', $this->getUrl(0), 'texts', 'TinymceCara']),
					'TinymceExceed' => $this->getData(['module', $this->getUrl(0), 'texts', 'TinymceExceed']),
					'caracteres'	=> $this->getData(['module', $this->getUrl(0), 'texts', 'Cara']),
					'value' => isset( $_SESSION['commentContent'] ) ? $_SESSION['commentContent'] : ''
			]); ?>
			</div>
			<div id="blogArticleContentAlarm"> </div>
			<?php if($this->getUser('password') !== $this->getInput('DELTA_USER_PASSWORD')): ?>
				<?php if( ($_SESSION['humanBot']==='bot') || $this->getData(['config', 'connect', 'captchaBot'])=== false ) { ?>
					<div class="row">
						<div class="col12">
							<?php echo template::captcha('blogArticleCaptcha', ''); ?>
						</div>
					</div>
				<?php } else { ?>
					<div class="row blogCheckBlue">
						<?php echo template::text('blogInputBlue', [
							'label' => 'Input Blue',
							'value' => ''
						]); ?>
					</div>
					<br>
					<div class="row blogOuter">
							<div class="blogInner humanCheck">
								<?php echo template::checkbox('blogHumanCheck', true, $this->getData(['locale', 'captchaSimpleText']), [
									'checked' => false,
									'help' => $this->getData(['locale', 'captchaSimpleHelp'])
								]); ?>
							</div>
					</div>
				<?php } ?>
			<?php endif; ?>
			<div class="row">
				<div class="col2 offset8">
					<?php echo template::button('blogArticleCommentHide', [
						'class' => 'buttonGrey',
						'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'Cancel'])
					]); ?>
				</div>
				<div class="col2 humanBotClose">
					<?php echo template::submit('blogArticleSubmit', [
						'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'Send']),
						'ico' => ''
					]); ?>
				</div>
			</div>
		</div>
	<?php echo template::formClose(); ?>
<?php endif;?>

<div class="pourTests"></div>


<div class="row">
	<div class="col12">
		<?php foreach($module::$comments as $commentId => $comment): ?>
			<div class="block">
				<div class="blockTitle"><?php echo $module::$commentsSignature[$commentId]; ?>
				<?php echo ' - ';  echo mb_detect_encoding(date('d\/m\/Y\ \-\ H\:i', $comment['createdOn']), 'UTF-8', true)
										? date('d\/m\/Y\ \-\ H\:i', $comment['createdOn'])
										: utf8_encode(date('d\/m\/Y\ \-\ H\:i', $comment['createdOn']));
				?>
				</div>
				<?php echo $comment['content']; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
<?php echo $module::$pages; ?>
