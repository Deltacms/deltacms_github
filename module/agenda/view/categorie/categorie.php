<?php
// Lexique
include('./module/agenda/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_agenda.php');

echo template::formOpen('gestion_categorie'); ?>

<div class="row">
	<div class="col2">
		<?php echo template::button('edition_retour', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . $this->getUrl(0).'/config',
			'ico' => 'left',
			'value' => $text['agenda_view']['categorie'][0]
		]); ?>
	</div>
	<div class="col2 offset8">
		<?php echo template::submit('edition_enregistrer',[
			'value' => $text['agenda_view']['categorie'][1],
			'ico' => 'check'
		]); ?>
	</div>
</div>

<div class="block">
	<div class="blockTitle"><?php echo $text['agenda_view']['categorie'][4]; ?></div>

	<div class="row">
		<div class="col4">
			<?php echo template::checkbox('val_categories', true, $text['agenda_view']['categorie'][2], [
				'checked' => $this->getData(['module', $this->getUrl(0), 'categories', 'valCategories']),
				'help' => $text['agenda_view']['categorie'][3]
			]); ?>
		</div>
	</div>
</div>

<div class="block">
	<div class="blockTitle"><?php echo $text['agenda_view']['categorie'][5]; ?></div>
	<div class="row">
		<div class="col4">
			<?php
			echo template::text('categorie_name', [
				'help' => $text['agenda_view']['categorie'][6],
				'label' => $text['agenda_view']['categorie'][7]
			]);
			?>
		</div>
		<div class="col4">
			<?php echo template::text('categorie_couleur_fond', [
				'class' => 'colorPicker',
				'help' => $text['agenda_view']['categorie'][8],
				'label' => $text['agenda_view']['categorie'][9],
				'value' => 'rgba(0,0,0,1)'
			]); ?>
		</div>
		<div class="col4">
			<?php echo template::text('categorie_couleur_texte', [
				'class' => 'colorPicker',
				'help' => $text['agenda_view']['categorie'][8],
				'label' => $text['agenda_view']['categorie'][10],
				'value' => 'rgba(255,255,255,1)'
			]); ?>
		</div>
	</div>
</div>

<?php echo template::formClose(); ?>

<?php echo template::table([5,3,3,1], $module::$tabCategories, [$text['agenda_view']['categorie'][11], $text['agenda_view']['categorie'][12],$text['agenda_view']['categorie'][13],'']); ?>

<div class="moduleVersion">
	<?php echo $text['agenda_view']['categorie'][14]; echo $module::VERSION; ?>
</div>
