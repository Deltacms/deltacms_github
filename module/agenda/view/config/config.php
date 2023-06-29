<!-- Configuration du module agenda -->
<?php
// Lexique
include('./module/agenda/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_agenda.php');

if(! is_dir($module::DATAMODULE.'data/'.$this->getUrl(0))){ $readonly = true;}else{ $readonly = false;}
echo template::formOpen('configuration'); ?>

<div class="row">
	<div class="col2">
		<?php echo template::button('config_retour', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . $this->getUrl(0),
			'ico' => 'left',
			'value' => $text['agenda_view']['config'][0]
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::button('agendaIndexHelp', [
			'class' => 'buttonHelp',
			'ico' => 'help',
			'value' => $text['agenda_view']['config'][36]
		]); ?>
	</div>
	<div class="col2 offset4">
		<?php echo template::button('config_gestion_categorie', [
			'class' => 'buttonBlue',
			'href' => helper::baseUrl() . $this->getUrl(0).'/categories/',
			'ico' => 'cogs',
			'value' => $text['agenda_view']['config'][1]
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::submit('config_enregistrer',[
			'value' => $text['agenda_view']['config'][2]
		]); ?>
	</div>
</div>
<!-- Aide à propos de la configuration de agenda, view config -->
<div class="helpDisplayContent">
	<?php echo file_get_contents( $text['agenda_view']['config'][37]) ;?>
</div>

<?php
if($this->getUser('group') < self::GROUP_MODERATOR) {
	echo '<div class="displayNone">';
}
else {
	echo '<div class="block">';
}
?>
	<div class="blockTitle"><?php echo $text['agenda_view']['config'][3]; ?></div>
		<div class="col6">
			<?php	echo template::select('config_droit_creation', $groupe, [
			'help' => $text['agenda_view']['config'][6],
			'id' => 'config_droit_creation',
			'disabled' => $readonly,
			'label' => $text['agenda_view']['config'][7],
			'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'droit_creation'])
			]); ?>
		</div>
		<div class="col6">
			<?php echo template::checkbox('config_droit_limite', true, $text['agenda_view']['config'][8], [
				'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'droit_limite']),
				'disabled' => $readonly,
				'help' => $text['agenda_view']['config'][9]
			]); ?>
		</div>
</div> <!-- Conditionnel -->

<div class="block">
	<div class="blockTitle"><?php echo $text['agenda_view']['config'][4]; ?></div>
		<div class="col4">
			<?php echo template::select('config_MaxiWidth', $maxwidth,[
				'help' => $text['agenda_view']['config'][10],
				'label' => $text['agenda_view']['config'][11],
				'selected' => $this->getData(['module', $this->getUrl(0),'config', 'maxiWidth'])
			]); ?>
		</div>
</div>

<div class="block">
	<div class="blockTitle"><?php echo $text['agenda_view']['config'][5]; ?></div>
	<div class="row">
		<!--Sauvegarder l'agenda actuel-->
		<div class="col6">
			<?php
			echo template::text('config_sauve', [
				'help' => $text['agenda_view']['config'][12],
				'disabled' => $readonly,
				'id' => 'config_sauvegarde',
				'label' => $text['agenda_view']['config'][13]
				]);
			?>
		</div>


		<!--Sélection d'un fichier de sauvegarde-->
		<?php
		if($this->getUser('group') >= self::GROUP_MODERATOR) {
			echo '<div class="col6">';
			echo template::select('config_restaure', $module::$savedFiles, [
				'help' => $text['agenda_view']['config'][14],
				'id' => 'config_restauration',
				'disabled' => $readonly,
				'label' => $text['agenda_view']['config'][15]
			]);
			echo '</div>';
		} ?>
	</div>




</div>

<!--Tout supprimer-->
<?php if($this->getUser('group') >= self::GROUP_MODERATOR) { ?>
	<div class="block">
			<div class="blockTitle"><?php echo $text['agenda_view']['config'][16]; ?></div>
			<div class="col4">
				<?php echo template::button('config_suptout', [
					'class' => 'configSup buttonRed',
					'disabled' => $readonly,
					'help' => $text['agenda_view']['config'][20],
					'href' => helper::baseUrl() . $this->getUrl(0).'/deleteall',
					'ico' => 'cancel',
					'value' => $text['agenda_view']['config'][21]
				]); ?>
			</div>
	</div>
<?php } ?>

<!-- Sélection d'un fichier ics depuis le dossier site/file/source/agenda/ics  -->
<div class="block">
	<div class="blockTitle"><?php echo $text['agenda_view']['config'][17]; ?></div>
	<div class="row">
		<div class="col6">
			<!-- Sélection d'un fichier ics -->
			<?php echo template::select('config_fichier_ics', $module::$icsFiles, [
				'help' => $text['agenda_view']['config'][22],
				'id' => 'config_fichier_ics',
				'label' => $text['agenda_view']['config'][23]
			]); ?>
		</div>
	</div>
</div>

<!-- Sélection d'un carnet d'adresses au format txt ou csv avec séparateur virgule  -->
<div class="block">
	<div class="blockTitle"><?php echo $text['agenda_view']['config'][18]; ?></div>
	<div class="row">
		<div class="col6">
			<!-- Sélection d'un fichier csv ou txt -->
			<?php echo template::select('config_fichier_csv_txt', $module::$csvFiles, [
				'help' => $text['agenda_view']['config'][24],
				'id' => 'config_fichier_csv_txt',
				'label' => $text['agenda_view']['config'][25]
			]); ?>
		</div>
	</div>
</div>

<!-- Textes pour la vue des évènements par un visiteur -->
<?php
if( null === $this->getData(['module', $this->getUrl(0), 'texts', 'configTextButtonBack'])) $this->setData(['module', $this->getUrl(0), 'texts', 'configTextButtonBack', $text['agenda_view']['config'][0]]);
if( null === $this->getData(['module', $this->getUrl(0), 'texts', 'configTextDateStart'])) $this->setData(['module', $this->getUrl(0), 'texts', 'configTextDateStart', $text['agenda_view']['config'][33]]);
if( null === $this->getData(['module', $this->getUrl(0), 'texts', 'configTextDateEnd'])) $this->setData(['module', $this->getUrl(0), 'texts', 'configTextDateEnd', $text['agenda_view']['config'][34]]);
?>
<div class="block">
	<div class="blockTitle"><?php echo $text['agenda_view']['config'][26]; ?></div>
	<div class="row">
		<div class="col4">
			<?php echo template::text('configTextButtonBack', [
				'help' => $text['agenda_view']['config'][27],
				'disabled' => $readonly,
				'label' => $text['agenda_view']['config'][28],
				'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'configTextButtonBack'])
				]);
			?>
		</div>
		<div class="col4">
			<?php echo template::text('configTextDateStart', [
				'help' => $text['agenda_view']['config'][29],
				'disabled' => $readonly,
				'label' => $text['agenda_view']['config'][30],
				'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'configTextDateStart'])
				]);
			?>
		</div>
		<div class="col4">
			<?php echo template::text('configTextDateEnd', [
				'help' => $text['agenda_view']['config'][31],
				'disabled' => $readonly,
				'label' => $text['agenda_view']['config'][32],
				'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'configTextDateEnd'])
				]);
			?>
		</div>
	</div>
</div>

<!-- Fin du formulaire principal à la mode Deltacms -->
<?php echo template::formClose(); ?>



<div class="moduleVersion">
	<?php echo $text['agenda_view']['config'][19]; echo $module::VERSION; ?>
</div>
<script>
	var textConfirm = <?php echo '"'.$text['agenda_view']['config'][35].'"'; ?>;
</script>


