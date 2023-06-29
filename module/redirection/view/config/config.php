<?php
// Lexique
include('./module/redirection/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_redirection.php');

echo template::formOpen('redirectionConfig'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('redirectionConfigBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),
				'ico' => 'left',
				'value' => $text['redirection_view']['config'][0]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('redirectionIndexHelp', [
				'class' => 'buttonHelp',
				'ico' => 'help',
				'value' => $text['redirection_view']['config'][8]
			]); ?>
		</div>
		<div class="col2 offset6">
			<?php echo template::submit('redirectionConfigSubmit', [
				'value' => $text['redirection_view']['config'][1]
			]); ?>
		</div>
	</div>
	<!-- Aide à propos de la configuration de redirection, view config -->
	<div class="helpDisplayContent">
		<?php echo file_get_contents( $text['redirection_view']['config'][9]) ;?>
	</div>
	<div class="row">
		<div class="col6">
			<div class="block">
				<div class="blockTitle"><?php echo $text['redirection_view']['config'][4]; ?></div>
				<?php echo template::text('redirectionConfigUrl', [
					'label' => $text['redirection_view']['config'][2],
					'placeholder' => 'http://',
					'value' => $this->getData(['module', $this->getUrl(0), 'url']),
					'help' => $text['redirection_view']['config'][3]
				]); ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<div class="blockTitle"><?php echo $text['redirection_view']['config'][5]; ?></div>
				<?php echo template::text('redirectionConfigCount', [
					'disabled' => true,
					'label' => $text['redirection_view']['config'][6],
					'value' => helper::filter($this->getData(['module', $this->getUrl(0), 'count']), helper::FILTER_INT)
				]); ?>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
<div class="moduleVersion"><?php echo $text['redirection_view']['config'][7].$module::VERSION; ?>
</div>
