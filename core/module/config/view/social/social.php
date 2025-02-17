<?php
// Lexique
$param = 'social_view';
include('./core/module/config/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_config.php');
?>
<div id="socialContainer">
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['social'][0]; ?>
					<span id="specialeHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/referencement" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col4 offset1">
						<div class="row">
							<div class="col12" id="take_screenshoot">
								<?php
								$texte = $text['core_config_view']['social'][2];
								if( isset($_SESSION['screenshot'])) $texte = $_SESSION['screenshot'] === 'on' ? $text['core_config_view']['social'][1]: $text['core_config_view']['social'][2];
								echo template::button('socialMetaImage', [
								'href' => helper::baseUrl() . 'config/configOpenGraph',
								'value' => $texte

								]); ?>
							</div>
						</div>
						<div class="row">
							<div class="col12">
								<?php echo template::button('socialSiteMap', [
									'href' => helper::baseUrl() . 'config/generateFiles',
									'value' => $text['core_config_view']['social'][3]
								]); ?>
							</div>
						</div>
						<div class="row">
							<div class="col12">
								<?php echo template::checkbox('seoRobots', true, $text['core_config_view']['social'][4], [
									'checked' => $this->getData(['config', 'seo','robots'])
								]); ?>
							</div>
						</div>
					</div>
					<div class="col6 offset1">
						<?php if (file_exists(self::FILE_DIR.'source/screenshot.jpg')){ ?>
							<div class="row">
								<div class="col8 offset2 textAlignCenter">
									<img src="<?php echo helper::baseUrl(false) . self::FILE_DIR.'source/screenshot.jpg'.'?n='.uniqid();?>" data-tippy-content="<?php echo $text['core_config_view']['social'][5]; ?>" />
								</div>
							</div>
						<?php } else{?>
							<div class="row">
								<div class="col8 offset2 textAlignCenter">
									<?php echo $text['core_config_view']['social'][6]; ?>
								</div>
							</div>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['social'][19]; ?></div>			
					<div>
						<?php echo template::checkbox('socialConfigMailOptionsToggle', true, $text['core_config_view']['social'][23], [
							'checked' => (bool) $this->getData(['config', 'social', 'comment', 'group']) ||
												!empty($this->getData(['config', 'social', 'comment', 'user'])) ||
												!empty($this->getData(['config', 'social', 'comment', 'mail'])),
							'help' => $text['core_config_view']['social'][24]
						]); ?>
						<div id="socialConfigMailOptions" class="displayNone">
							<div class="row">
								<div class="col11 offset1">
									<?php echo template::text('socialConfigSubject', [
										'help' => $text['core_config_view']['social'][25],
										'label' => $text['core_config_view']['social'][26],
										'value' => $this->getData(['config', 'social', 'comment', 'subject'])
									]); ?>
								</div>
							</div>
							<?php
								// Element 0 quand aucun membre a été sélectionné
								$groupMembers = [''] + $groupNews;
							?>
							<div class="row">
								<div class="col3 offset1">
									<?php echo template::select('socialConfigGroup', $groupMembers, [
										'label' => $text['core_config_view']['social'][27],
										'selected' => $this->getData(['config', 'social', 'comment', 'group']),
										'help' => $text['core_config_view']['social'][28]
									]); ?>
								</div>
								<div class="col3">
									<?php echo template::select('socialConfigUser', config::$listUsers, [
										'label' => $text['core_config_view']['social'][29],
										'selected' => $this->getData(['config', 'social', 'comment', 'user'])
									]); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col4">
							<?php echo template::checkbox('socialConfigCaptcha', true, $text['core_config_view']['social'][40], [
								'checked' => $this->getData(['config', 'social', 'comment', 'captcha'])
							]); ?>
						</div>
						<div class="col4">
							<?php echo template::select('socialConfigNbItemPage', config::$nbItemPage, [
								'label' => $text['core_config_view']['social'][37],
								'selected' => $this->getData(['config', 'social', 'comment', 'nbItemPage'])
							]); ?>
						</div>
						<div class="col4 textAlignCenter" style="font-weight: 600">
							<?php echo template::label('socialConfigCommentLabel', $text['core_config_view']['social'][21], [
							]); ?>
						</div>
					</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['social'][7]; ?>
					<span id="specialeHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/referencement#reseaux-sociaux" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col3">
						<?php echo template::text('socialFacebookId', [
							'help' => $text['core_config_view']['social'][8],
							'label' => 'Facebook',
							'value' => $this->getData(['config', 'social', 'facebookId'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::text('socialInstagramId', [
							'help' => $text['core_config_view']['social'][9],
							'label' => 'Instagram',
							'value' => $this->getData(['config', 'social', 'instagramId'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::text('socialYoutubeId', [
							'help' => $text['core_config_view']['social'][10],
							'label' => $text['core_config_view']['social'][18],
							'value' => $this->getData(['config', 'social', 'youtubeId'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::text('socialYoutubeUserId', [
							'help' => $text['core_config_view']['social'][11],
							'label' => 'Youtube',
							'value' => $this->getData(['config', 'social', 'youtubeUserId'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col3">
						<?php echo template::checkbox('socialHeadFacebook', true, $text['core_config_view']['social'][16], [
							'checked' => $this->getData(['config', 'social','headFacebook']),
							'help' => $text['core_config_view']['social'][17]
						]); ?>					
					</div>
				</div>
				<div class="row">
					<div class="col3">
							<?php echo template::text('socialTwitterId', [
								'help' => $text['core_config_view']['social'][12],
								'label' => 'X',
							'value' => $this->getData(['config', 'social', 'twitterId'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::text('socialPinterestId', [
							'help' => $text['core_config_view']['social'][13],
							'label' => 'Pinterest',
							'value' => $this->getData(['config', 'social', 'pinterestId'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::text('socialLinkedinId', [
							'help' => $text['core_config_view']['social'][14],
							'label' => 'Linkedin',
							'value' => $this->getData(['config', 'social', 'linkedinId'])
						]); ?>
					</div>
					<div class="col3">
							<?php echo template::text('socialMastodonId', [
								'help' => $text['core_config_view']['social'][22],
								'label' => 'Mastodon',
							'value' => $this->getData(['config', 'social', 'mastodonId'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
