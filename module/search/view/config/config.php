<?php echo template::formOpen('searchConfig');
// Lexique
include('./module/search/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_search.php');

?>
<?php // drapeau pour la langue d'origine ou la langue en traduction rédigée
if( $this->getInput('DELTA_I18N_SITE') === '' || $this->getInput('DELTA_I18N_SITE')=== null || $this->getInput('DELTA_I18N_SITE') === 'base'){
	$flag = $this->getData(['config', 'i18n', 'langBase']);
}
else{
	$flag = $this->getInput('DELTA_I18N_SITE');
}
?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('searchConfigBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),
				'ico' => 'left',
				'value' => $text['search_view']['config'][0]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('searchIndexHelp', [
				'class' => 'buttonHelp',
				'ico' => 'help',
				'value' => $text['search_view']['config'][16]
			]); ?>
		</div>
		<div class="col2 offset6">
				<?php echo template::submit('searchConfigSubmit', [
					'value'=> $text['search_view']['config'][1]
				]); ?>
		</div>
	</div>
	<!-- Aide à propos de la configuration de search, view config -->
	<div class="helpDisplayContent">
		<?php echo file_get_contents( $text['search_view']['config'][17]) ;?>
	</div>
	<div class="row" <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo '<div style="display: none;">'; ?> >
		<div class="col12">
			<div class="block">
			<div class="blockTitle"><?php echo $text['search_view']['config'][6]; ?><?php echo ' '.template::flag($flag, '20px');?></div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('searchSubmitText', [
								'label' => $text['search_view']['config'][2],
								'value' => $this->getData(['module', $this->getUrl(0), 'config', 'submitText'])
							]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('searchPlaceHolder', [
								'label' => $text['search_view']['config'][4],
								'value' => $this->getData(['module', $this->getUrl(0), 'config', 'placeHolder'])
							]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('searchNearWordText', [
								'label' => $text['search_view']['config'][12],
								'value' => $this->getData(['module', $this->getUrl(0), 'config', 'nearWordText'])
							]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('searchSuccessTitle', [
								'label' => $text['search_view']['config'][13],
								'value' => $this->getData(['module', $this->getUrl(0), 'config', 'successTitle'])
							]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('searchFailureTitle', [
								'label' => $text['search_view']['config'][14],
								'value' => $this->getData(['module', $this->getUrl(0), 'config', 'failureTitle'])
							]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('searchCommentFailureTitle', [
								'label' => $text['search_view']['config'][15],
								'value' => $this->getData(['module', $this->getUrl(0), 'config', 'commentFailureTitle'])
							]); ?>
					</div>					
				</div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('searchCommentMatch', [
								'label' => $text['search_view']['config'][19],
								'value' => $this->getData(['module', $this->getUrl(0), 'config', 'commentMatch'])
							]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('searchCommentMatches', [
								'label' => $text['search_view']['config'][20],
								'value' => $this->getData(['module', $this->getUrl(0), 'config', 'commentMatches'])
							]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['search_view']['config'][18]; ?></div>
				<div class="row">
					<div class="col3">
						<?php echo template::select('searchPreviewLength', $module::$previewLength, [
								'label' => $text['search_view']['config'][3],
								'help' => $text['search_view']['config'][21],
								'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'previewLength'])
							]); ?>
					</div>
					<div class="col6 offset3">
						<?php echo template::checkbox('searchResultHideContent', true, $text['search_view']['config'][5], [
							'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'resultHideContent']),
						]); ?>
					</div>
				</div>			
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
			<div class="blockTitle"><?php echo $text['search_view']['config'][7]; ?>
				<?php echo template::help( $text['search_view']['config'][8] );	?>
			</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('searchKeywordColor', [
							'class' => 'colorPicker',
							'help' =>  $text['search_view']['config'][9],
							'label' => $text['search_view']['config'][10],
							'value' => $this->getData(['module', $this->getUrl(0), 'theme', 'keywordColor'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
<div class="moduleVersion"><?php echo $text['search_view']['config'][11]; ?>
	<?php echo $module::VERSION; ?>
</div>
