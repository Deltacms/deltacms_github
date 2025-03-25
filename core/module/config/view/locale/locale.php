<?php
// Lexique
$param='';
include('./core/module/config/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_config.php');

// drapeau pour la langue d'origine ou la langue en traduction rédigée
if( $this->getInput('DELTA_I18N_SITE') === '' || $this->getInput('DELTA_I18N_SITE')=== null || $this->getInput('DELTA_I18N_SITE') === 'base'){
	$flag = $this->getData(['config', 'i18n', 'langBase']);
}
else{
	$flag = $this->getInput('DELTA_I18N_SITE');
}
?>
<div id="localeContainer">
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['locale'][0]; ?></div>
				<div class="row">
					<div class="col12">
						<?php echo template::checkbox('localei18n', true, $text['core_config_view']['locale'][1], [
								'checked' => $this->getData(['config', 'i18n', 'enable']),
								'help'=> $text['core_config_view']['locale'][2]
							]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['locale'][3]; ?><?php echo template::flag($flag, '20px');?>
					<span id="localeHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/localisation" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col9">
						<?php echo template::text('localeTitle', [
							'label' => $text['core_config_view']['locale'][4],
							'value' => $this->getData(['locale', 'title']),
							'help'  => $text['core_config_view']['locale'][5]
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::text('localeVersion', [
							'label' => $text['core_config_view']['locale'][6],
							'value' => common::DELTA_VERSION,
							'readonly' => true
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col12">
						<?php echo template::textarea('localeMetaDescription', [
							'label' => $text['core_config_view']['locale'][7],
							'value' => $this->getData(['locale', 'metaDescription']),
							'help'  => $text['core_config_view']['locale'][8]
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['locale'][9]; echo template::flag($flag, '20px');?>
					<span id="localeHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/localisation#pages-speciales" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::select('localeHomePageId', helper::arrayCollumn($module::$pagesList, 'title', 'SORT_ASC'), [
								'label' => $text['core_config_view']['locale'][10],
								'selected' =>$this->getData(['locale', 'homePageId']),
								'help' => $text['core_config_view']['locale'][11]
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('localePage403', array_merge(['none' => $text['core_config_view']['locale'][19]],helper::arrayCollumn($module::$orphansList, 'title', 'SORT_ASC')), [
								'label' => $text['core_config_view']['locale'][12],
								'selected' =>$this->getData(['locale', 'page403']),
								'help' => $text['core_config_view']['locale'][13]
							]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('localePage404', array_merge(['none' => $text['core_config_view']['locale'][19]],helper::arrayCollumn($module::$orphansList, 'title', 'SORT_ASC')), [
								'label' => $text['core_config_view']['locale'][14],
								'selected' =>$this->getData(['locale', 'page404']),
								'help' => $text['core_config_view']['locale'][13]
							]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::select('localeLegalPageId', array_merge(['none' => $text['core_config_view']['locale'][20]] , helper::arrayCollumn($module::$pagesList, 'title', 'SORT_ASC') ) , [
							'label' => $text['core_config_view']['locale'][15],
							'selected' => $this->getData(['locale', 'legalPageId']),
							'help' => $text['core_config_view']['locale'][16]
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('localeSearchPageId', array_merge(['none' => $text['core_config_view']['locale'][20]] , helper::arrayCollumn($module::$pagesList, 'title', 'SORT_ASC') ) , [
							'label' => $text['core_config_view']['locale'][17],
							'selected' => $this->getData(['locale', 'searchPageId']),
							'help' => $text['core_config_view']['locale'][18]
						]); ?>
					</div>
					<div class="col4">
						<?php
							echo template::select('localePage302', array_merge(['none' => $text['core_config_view']['locale'][19]],helper::arrayCollumn($module::$orphansList, 'title', 'SORT_ASC')), [
								'label' => $text['core_config_view']['locale'][21],
								'selected' =>$this->getData(['locale', 'page302']),
								'help' => $text['core_config_view']['locale'][13]
							]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['locale'][22]; echo template::flag($flag, '20px');?>
					<span id="labelHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/localisation#etiquettes" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col3">
						<?php echo template::text('localeLegalPageLabel', [
							'label' => $text['core_config_view']['locale'][15],
							'placeholder' => $text['core_config_view']['locale'][15],
							'value' => $this->getData(['locale', 'legalPageLabel'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::text('localeSearchPageLabel', [
							'label' => $text['core_config_view']['locale'][23],
							'placeholder' => $text['core_config_view']['locale'][23],
							'value' => $this->getData(['locale', 'searchPageLabel'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::text('localeSitemapPageLabel', [
							'label' => $text['core_config_view']['locale'][24],
							'placeholder' => $text['core_config_view']['locale'][24],
							'value' => $this->getData(['locale', 'sitemapPageLabel']),
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::text('localeCookiesFooterText', [
							'label' => $text['core_config_view']['locale'][25],
							'value' => $this->getData(['locale', 'cookies', 'cookiesFooterText']),
							'placeHolder' => $text['core_config_view']['locale'][25]
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['locale'][47]; echo template::flag($flag, '20px');?>
					<span id="labelHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/localisation#etiquettes" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col3">
						<?php echo template::text('localeVisitorLabel', [
							'label' => $text['core_config_view']['locale'][48],
							'placeholder' => $text['core_config_view']['locale'][48],
							'value' => $this->getData(['locale', 'visitorLabel'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::text('localeMemberLabel', [
							'label' => $text['core_config_view']['locale'][49],
							'placeholder' => $text['core_config_view']['locale'][49],
							'value' => $this->getData(['locale', 'memberLabel'])
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::text('localeEditorLabel', [
							'label' => $text['core_config_view']['locale'][50],
							'placeholder' => $text['core_config_view']['locale'][50],
							'value' => $this->getData(['locale', 'editorLabel']),
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::text('localeModeratorLabel', [
							'label' => $text['core_config_view']['locale'][51],
							'value' => $this->getData(['locale', 'moderatorLabel']),
							'placeHolder' => $text['core_config_view']['locale'][51]
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col3">
						<?php echo template::text('localeAdministratorLabel', [
							'label' => $text['core_config_view']['locale'][52],
							'placeholder' => $text['core_config_view']['locale'][52],
							'value' => $this->getData(['locale', 'administratorLabel'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['locale'][54]; ?><?php echo ' '.template::flag($flag, '20px');?>
					<span id="labelHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/localisation#comment" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('localeConfigWriteComment', [
							'label' => $text['core_config_view']['locale'][55],
							'value' => $this->getData(['locale', 'pageComment', 'writeComment'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('localeConfigCommentName', [
							'label' => $text['core_config_view']['locale'][56],
							'value' => $this->getData(['locale', 'pageComment', 'commentName'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('localeConfigCommentComment', [
							'label' => $text['core_config_view']['locale'][57],
							'value' => $this->getData(['locale', 'pageComment', 'comment'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('localeConfigCommentSubmit', [
							'label' => $text['core_config_view']['locale'][53],
							'value' => $this->getData(['locale', 'pageComment', 'submit'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('localeConfigCommentLink', [
							'label' => $text['core_config_view']['locale'][58],
							'value' => $this->getData(['locale', 'pageComment', 'link'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('localeConfigCommentPage', [
							'label' => $text['core_config_view']['locale'][59],
							'value' => $this->getData(['locale', 'pageComment', 'page'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('localeConfigCommentSubmitted', [
							'label' => $text['core_config_view']['locale'][66],
							'value' => $this->getData(['locale', 'pageComment', 'submitted'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('localeConfigCommentFailed', [
							'label' => $text['core_config_view']['locale'][67],
							'value' => $this->getData(['locale', 'pageComment', 'failed'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['locale'][42]; echo template::flag($flag, '20px');?>
					<span id="labelHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/localisation#captcha" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('localeCaptchaSimpleText', [
							'label' => $text['core_config_view']['locale'][43],
							'placeholder' => $text['core_config_view']['locale'][44],
							'value' => $this->getData(['locale', 'captchaSimpleText'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('localeCaptchaSimpleHelp', [
							'label' => $text['core_config_view']['locale'][45],
							'placeholder' => $text['core_config_view']['locale'][46],
							'value' => $this->getData(['locale', 'captchaSimpleHelp'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['locale'][68]; echo template::flag($flag, '20px');?>
					<span id="labelHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/localisation#captcha_addition" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('localeCaptchaAddition', [
							'label' => $text['core_config_view']['locale'][69],
							'placeholder' => $text['core_config_view']['locale'][70],
							'value' => $this->getData(['locale', 'captchaAddition'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['locale'][60]; echo template::flag($flag, '20px');?>
					<span id="labelHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/localisation#questionnaire" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col12">
						<?php echo template::text('localeQuestionnaireAccept', [
							'label' => $text['core_config_view']['locale'][61],
							'placeholder' => $text['core_config_view']['locale'][62],
							'value' => $this->getData(['locale', 'questionnaireAccept'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['locale'][63]; echo template::flag($flag, '20px');?>
					<span id="labelHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/localisation#texts" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('localeMandatoryText', [
							'label' => $text['core_config_view']['locale'][64],
							'value' => $this->getData(['locale', 'mandatoryText'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('localeImpossibleText', [
							'label' => $text['core_config_view']['locale'][65],
							'value' => $this->getData(['locale', 'impossibleText'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_config_view']['locale'][26]; echo template::flag($flag, '20px');?>
					<span id="specialeHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/localisation#cookies" target="_blank">
								<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="row">
					<div class="col12">
						<?php echo template::text('localeCookiesTitleText', [
							'help' => $text['core_config_view']['locale'][27],
							'label' => $text['core_config_view']['locale'][28] ,
							'value' => $this->getData(['locale', 'cookies', 'cookiesTitleText']),
							'placeHolder' => $text['core_config_view']['locale'][29]
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col8">
						<?php echo template::textarea('localeCookiesDeltaText', [
							'help' => $text['core_config_view']['locale'][30],
							'label' => $text['core_config_view']['locale'][31],
							'value' => $this->getData(['locale', 'cookies', 'cookiesDeltaText']),
							'placeHolder' => $text['core_config_view']['locale'][32]
						]); ?>
					</div>

					<div class="col4">
						<?php echo template::text('localeCookiesLinkMlText', [
							'help' => $text['core_config_view']['locale'][33],
							'label' => $text['core_config_view']['locale'][34],
							'value' => $this->getData(['locale', 'cookies', 'cookiesLinkMlText']),
							'placeHolder' => $text['core_config_view']['locale'][35]
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col8">
						<?php echo template::textarea('localeCookiesExtText', [
							'help' => $text['core_config_view']['locale'][36],
							'label' => $text['core_config_view']['locale'][37],
							'value' => $this->getData(['locale', 'cookies', 'cookiesExtText'])
						]); ?>
					</div>

					<div class="col4">
						<?php echo template::text('localeCookiesCheckboxExtText', [
							'help' => $text['core_config_view']['locale'][38],
							'label' => $text['core_config_view']['locale'][39],
							'value' => $this->getData(['locale', 'cookies', 'cookiesCheckboxExtText'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4 offset4">
						<?php echo template::text('localeCookiesButtonText', [
							'label' => $text['core_config_view']['locale'][40],
							'value' => $this->getData(['locale', 'cookies', 'cookiesButtonText']),
							'placeHolder' => $text['core_config_view']['locale'][41]
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
