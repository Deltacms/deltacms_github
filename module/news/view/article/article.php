<?php
// Lexique
include('./module/news/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_news.php');
?>
<div class="row">
    <div class="col12">
	    <?php echo $this->getData(['module', $this->getUrl(0),'posts', $this->getUrl(1), 'content']); ?>
    </div>
</div>
<div class="row verticalAlignMiddle">
	<div class="col12 newsDate">
		<!-- bloc signature et date -->
		<?php if( function_exists('datefmt_create') && function_exists('datefmt_format') && extension_loaded('intl') ){
			// Pour les dates suivant la langue de rédaction du site (langue principale ou langue de traduction rédigée)
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
		echo $module::$articleSignature . ' - ';?>
		<?php if( function_exists('datefmt_create') && function_exists('datefmt_format') && extension_loaded('intl') ){
			echo datefmt_format($fmt, strtotime( date('Y/m/d H:i:s',$this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'publishedOn'])))); 
		} else {
			$date = mb_detect_encoding(date('d/m/Y', $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'publishedOn'])), 'UTF-8', true)
					? date('d/m/Y', $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'publishedOn']))
					: utf8_encode(date('d/m/Y', $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'publishedOn'])));
			$heure =  mb_detect_encoding(date('H:i', $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'publishedOn'])), 'UTF-8', true)
					? date('H:i', $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'publishedOn']))
					:  utf8_encode(date('H:i', $this->getData(['module', $this->getUrl(0), 'posts', $this->getUrl(1), 'publishedOn'])));
			echo $date . $text['news_view']['article'][0] . $heure; 
		} ?>
			
		<!-- Bloc edition -->
        <?php if (
            $this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')
            AND
            (  // Propriétaire
                (	$this->getUser('group') === self::GROUP_ADMIN )
            )
            ): ?>
                <a href ="<?php echo helper::baseUrl() . $this->getUrl(0) . '/edit/' . $this->getUrl(1) . '/' . $_SESSION['csrf'];?>">
                    <?php echo template::ico('pencil');
					echo $text['news_view']['article'][1]; ?>
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
	
	<!--Bouton Retour sur la page active-->
	<div class="col2">	
		<?php echo template::button('newsArticleBack', [
			'href' => helper::baseUrl() . $_SESSION['pageActive'],
			'ico' => 'left',
			'value' => $text['news_view']['article'][2]
		]); ?>
	</div>
	
</div>