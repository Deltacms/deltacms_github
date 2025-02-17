<?php
// Lexique
$param = 'blog_view';
include('./module/blog/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_blog.php');
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

if($module::$articles): ?>
	<div class="row">
		<div class="col12">
			<?php // Mémorisation da la page active
			$_SESSION['pageActive'] = $this->getUrl(); ?>
	
			<?php foreach($module::$articles as $articleId => $article): ?>
				<div class="row rowArticle">
					<?php if(  $this->getData(['data_module', $this->getUrl(0), 'posts', $articleId, 'picture']) !=='' ){ ?>
						<div class="col3">
						<?php if ( file_exists(self::FILE_DIR . 'source/' . $article['picture']) ): ?>
							<?php // Déterminer le nom de la miniature
								$parts = explode('/',$article['picture']);
								$thumb = str_replace ($parts[(count($parts)-1)],'mini_' . $parts[(count($parts)-1)], $article['picture']);
								// Créer la miniature si manquante
								if (!file_exists( self::FILE_DIR . 'thumb/' . $thumb) ) {
									$this->makeThumb(  self::FILE_DIR . 'source/' . $article['picture'],
													self::FILE_DIR . 'thumb/' . $thumb,
													self::THUMBS_WIDTH);
								}	
							?>
							<a href="<?php echo helper::baseUrl() . $this->getUrl(0) . '/' . $articleId; ?>" class="blogPicture">
							<?php if ( file_exists( self::FILE_DIR . 'thumb/' . $thumb) ) { ?>
								<img src="<?php echo helper::baseUrl(false) .  self::FILE_DIR . 'thumb/' . $thumb; ?>" alt="<?php echo $article['picture']; ?>">
							<?php } else { 	// Image originale en remplacement	?>
								<img src="<?php echo helper::baseUrl(false) .  self::FILE_DIR . 'source/' . $article['picture']; ?>" alt="<?php echo $article['picture']; ?>">
							<?php } ?>
							</a>
						<?php endif;?>
						</div>
						<div class="col9">
					<?php } else { ?>
						<div class="col12">
					<?php } ?>
						<h2 class="blogTitle">
							<a href="<?php echo helper::baseUrl() . $this->getUrl(0) . '/' . $articleId; ?>">
								<?php echo $article['title']; ?>
							</a>
						</h2>
						<div class="blogComment">
							<a href="<?php echo helper::baseUrl() . $this->getUrl(0) . '/' . $articleId; ?>#comment">
								<?php if ($article['comment']): ?>
									<?php echo count($article['comment']); ?>
								<?php endif; ?>
							</a>
							<?php echo template::ico('comment', 'left'); ?>
						</div>
						<div class="blogDate">
							<?php if( function_exists('datefmt_create') && function_exists('datefmt_format') && extension_loaded('intl') ){
								echo datefmt_format($fmt, strtotime( date('Y/m/d H:i:s',$article['publishedOn']))); 
							} else {
								echo mb_detect_encoding(date('d/m/Y - H:i',  $article['publishedOn']), 'UTF-8', true)? 
								date('d/m/Y', $article['publishedOn']): helper::utf8Encode(date('d/m/Y', $article['publishedOn'])); 
							} ?>
						</div>
						<p class="blogContent">
							<?php 
							$sea = ['<br />', '<br>'];
							$rep = ' ';
							$article['content'] = str_replace($sea, $rep, $article['content']);							
							echo helper::subword(strip_tags($article['content']), 0, $this->getData(['module', $this->getUrl(0),'config', 'previewSize'])); ?>...
							<a href="<?php echo helper::baseUrl() . $this->getUrl(0) . '/' . $articleId;?>"><?php echo $this->getData(['module', $this->getUrl(0), 'texts', 'ReadMore']); ?></a>
						</p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php echo $module::$pages; ?>
	<?php if ($this->getData(['module',$this->getUrl(0), 'config', 'feeds'])): ?>
		<div id="rssFeed">
			<a type="application/rss+xml" href="<?php echo helper::baseUrl() . $this->getUrl(0) . '/rss'; ?>" target="_blank">
				<img  src='module/blog/ressource/feed-icon-16.gif' alt=''>
				<?php
					echo '<p>' . $this->getData(['module',$this->getUrl(0), 'config', 'feedsLabel']) . '</p>' ;
				?>
			</a>
		</div>
	<?php endif; ?>
<?php else: ?>
	<?php echo template::speech($text['blog_view']['index'][1]); ?>
<?php endif; ?>
