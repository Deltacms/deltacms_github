<?php
// Lexique
include('./module/news/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_news.php');

if($module::$news): 
	if( function_exists('datefmt_create') && function_exists('datefmt_format') && extension_loaded('intl') ){
		// Pour les dates suivant la langue de rédaction du site (langue principale ou langue de traduction rédigée)
		if( isset( $_SESSION['langFrontEnd']) && isset( $_SESSION['translationType']) && $_SESSION['translationType'] === 'site' ){
			$lang_date =  $_SESSION['langFrontEnd'];
		} else {
			$lang_date = $this->getData(['config', 'i18n', 'langBase']);
		}
		$fmt = datefmt_create(
			$lang_date,
			IntlDateFormatter::LONG,
			IntlDateFormatter::SHORT,
			'Europe/Paris',
			IntlDateFormatter::GREGORIAN
		); 
	} ?>	
	<?php if( $this->getData(['module', $this->getUrl(0), 'config', 'sameHeight']) === true){ ?>
		<div class="row" style="display: flex; flex-wrap: wrap;">
	<?php } else { ?>
		<div class="row">
	<?php } ?>
		<?php foreach($module::$news as $newsId => $news): ?>
			<div class="col<?php echo $module::$nbrCol ;?>">
				<?php if( $this->getData(['module', $this->getUrl(0), 'config', 'sameHeight']) === true){ ?>
				<div class="newsFrame" style="height: 100%;">
				<?php } else { ?>
				<div class="newsFrame">
				<?php } ?>
					<?php if( $this->getData(['module', $this->getUrl(0), 'config', 'hiddeTitle']) === false) { ?>
						<h2 class="newsTitle" id="<?php echo $newsId;?>">
							<?php echo '<a href="'. helper::baseUrl(true) . $this->getUrl(0) . '/' . $newsId . '">' . $news['title'] . '</a>'; ?>
						</h2>
					<?php } ?>
					<div class="newsContent">
						<?php echo $news['content']; ?>
					</div>
					<div class="newsSignature">	
						<?php if( function_exists('datefmt_create') && function_exists('datefmt_format') && extension_loaded('intl') ){
							echo datefmt_format($fmt, strtotime( date('Y/m/d H:i:s',$news['publishedOn']))); 
						} else {
							echo mb_detect_encoding(date('d/m/Y', $news['publishedOn']), 'UTF-8', true)? 
								date('d/m/Y', $news['publishedOn'])
								: utf8_encode(date('d/m/Y', $news['publishedOn']));
						}
						?>
								- <?php echo $news['userId']; ?>
								<!-- Bloc edition -->
								<?php if (

									$this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')
									AND
									(  // Propriétaire
										(	$this->getUser('group') === self::GROUP_ADMIN )
									)
								): ?>
										<a href ="<?php echo helper::baseUrl() . $this->getUrl(0) . '/edit/' . $newsId . '/' . $_SESSION['csrf'];?>">
											<?php echo template::ico('pencil'); echo $text['news_view']['index'][2]; ?>
										</a>
								<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php echo $module::$pages; ?>
	<?php if ($this->getData(['module',$this->getUrl(0), 'config', 'feeds'])): ?>
		<div id="rssFeed">
			<br><a type="application/rss+xml" href="<?php echo helper::baseUrl() . $this->getUrl(0) . '/rss'; ?>" target="_blank">
				<img  src='module/news/ressource/feed-icon-16.gif' />
				<?php
					echo '<p>' . $this->getData(['module',$this->getUrl(0), 'config', 'feedsLabel']) . '</p>' ;
				?>
			</a>
		</div>
	<?php endif; ?>
<?php else: ?>
	<?php echo template::speech($text['news_view']['index'][1]); ?>
<?php endif; ?>
