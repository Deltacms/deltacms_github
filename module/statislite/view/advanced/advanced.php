<?php
// Lexique
include('./module/statislite/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_statislite.php');

echo template::formOpen('advancedForm'); ?>

	<div class="row">
		<div class="col2">
			<?php echo template::button('statisliteAdvancedBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() .$this->getUrl(0),
				'ico' => 'left',
				'value' => $text['statislite_view']['advanced'][0]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('addonIndexHelp', [
				'class' => 'buttonHelp',
				'ico' => 'help',
				'value' => $text['statislite_view']['advanced'][1]
			]); ?>
		</div>
		<div class="col2 offset6">
			<?php echo template::submit('statisliteAdvancedSubmit',[
				'value' => $text['statislite_view']['advanced'][2]
			]); ?>
		</div>
	</div>
	<!-- Aide à propos de la configuration de Statislite, view advanced -->
	<div class="helpDisplayContent">
		<?php echo file_get_contents( $text['statislite_view']['advanced'][3]) ;?>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['statislite_view']['advanced'][4]; ?></div>
				<div class="row">
					<div class="col4">
						<?php echo template::textarea('statisliteAdvancedIP',[
							'value' => $module::$listeIP,
							'help' => $text['statislite_view']['advanced'][5]
						]);?>
					</div>
					<div class="col4">
						<div class="row">
							<?php echo template::text('statisliteEditIP', [
								'autocomplete' => 'off',
								'label' => $text['statislite_view']['advanced'][6],
								'help' => $text['statislite_view']['advanced'][7],
								'value' => $module::$yourIP
							]); ?>
						</div>
						<div class="row statisliteCheckboxAddIP">
							<?php echo template::checkbox('statisliteAddIp', true, $text['statislite_view']['advanced'][8], [
								'checked' => false,
								'help' => $text['statislite_view']['advanced'][9]
							]); ?>
						</div>
						<?php if( $module::$listeIP !== ""){ ?>
							<div class="row statisliteSupCheckboxIP">
								<?php echo template::checkbox('statisliteSupIp', true, 'Supprimer de la liste', [
									'checked' => false,
									'help' => $text['statislite_view']['advanced'][10]
								]); ?>
							</div>
						<?php } ?>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['statislite_view']['advanced'][11]; ?></div>
				<div class="row">
					<div class="col4">
						<?php echo template::textarea('statisliteAdvancedQS',[
							'value' => $module::$listeQS,
							'help' => $text['statislite_view']['advanced'][13]
						]);?>
					</div>
					<div class="col4">
						<div class="row">
							<?php echo template::select('statisliteEditQS', $module::$listePages,[
								'help' => $text['statislite_view']['advanced'][14],
								'label' => $text['statislite_view']['advanced'][15],
								'selected' => $module::$listePages[0]
							]); ?>
						</div>
						<div class="row statisliteCheckboxAddQS">
							<?php echo template::checkbox('statisliteAddQS', true, $text['statislite_view']['advanced'][16], [
								'checked' => false,
								'help' => $text['statislite_view']['advanced'][17]
							]); ?>
						</div>
						<?php if( $module::$listeQS !== ""){ ?>
							<div class="row statisliteSupCheckboxQS">
								<?php echo template::checkbox('statisliteSupQS', true, $text['statislite_view']['advanced'][18], [
									'checked' => false,
									'help' => $text['statislite_view']['advanced'][19]
								]); ?>
							</div>
						<?php } ?>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['statislite_view']['advanced'][12]; ?></div>
				<div class="row">
					<div class="col4">
						<?php echo template::textarea('statisliteAdvancedBot',[
							'value' => $module::$listeBot,
							'help' => $text['statislite_view']['advanced'][20]
						]);?>
					</div>
					<div class="col4">
						<div class="row">
							<?php echo template::text('statisliteEditBot', [
								'label' => $text['statislite_view']['advanced'][21],
								'help' => $text['statislite_view']['advanced'][22],
								'value' => ''
							]); ?>
						</div>
						<div class="row statisliteCheckboxAddBot">
							<?php echo template::checkbox('statisliteAddBot', true, $text['statislite_view']['advanced'][23], [
								'checked' => false,
								'help' => $text['statislite_view']['advanced'][24]
							]); ?>
						</div>
						<?php if( $module::$listeBot !== ""){ ?>
							<div class="row statisliteSupCheckboxBot">
								<?php echo template::checkbox('statisliteSupBot', true, $text['statislite_view']['advanced'][25], [
									'checked' => false,
									'help' => $text['statislite_view']['advanced'][26]
								]); ?>
							</div>
						<?php } ?>
					</div>
				</div>

			</div>
		</div>
	</div>

<?php echo template::formClose(); ?>
<div class="moduleVersion">
	<?php echo $text['statislite_view']['advanced'][27]; echo $module::VERSION; ?>
</div>
