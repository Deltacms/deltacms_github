<?php
// Lexique
include('./module/agenda/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_agenda.php');
?>
<script>
var lang_admin = "<?php echo $lang_admin; ?>";
var lang_flatpickr = "<?php echo $lang_flatpickr; ?>";
</script>
<?php
// $this->getUser('group') renvoie false pour un visiteur !
$userGroup = $this->getUser('group');
if( $userGroup === false) $userGroup = 0;

//Modification du tableau $groupe si l'option "limitation du choix des groupes liés aux évènements" est cochée
if ( $this->getData(['module', $this->getUrl(0), 'config', 'droit_limite']) ){
	 switch ($userGroup) {
		case 0 :
			array_splice($groupe,1);
			break;
		case 1 :
			array_splice($groupe,2);
			break;
		case 2 :
			array_splice($groupe,3);
			break;
		case 3 :
			array_splice($groupe,4);
			break;
	 }
}

echo template::formOpen('creation_events'); ?>
<div class="row">
	<div class="col2">
		<?php echo template::button('creation_retour', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . $this->getUrl(0),
			'ico' => 'left',
			'value' => $text['agenda_view']['creation'][0]
		]); ?>
	</div>

	<?php if( $this->getUser('group') >= $this->getData(['module', $this->getUrl(0), 'config', 'droit_creation']) ){
		if( $this->getUser('group') >= self::GROUP_EDITOR){
			$class_tinymce = 'editorWysiwyg';
		}
		else{
			$class_tinymce = 'editorWysiwygComment';
		}
		?>
		<!--Suite de la <div class="row"> -->
			<div class="col2 offset8">
				<?php echo template::submit('creation_enregistrer',[
					'value' => $text['agenda_view']['creation'][1]
				]); ?>
			</div>
		<!-- Fermeture de la <div class="row"> si test true -->
		</div>

		<div class="block">
		<div class="blockTitle"><?php echo $text['agenda_view']['creation'][2]; ?></div>
		<div class="row">
			<div class="col12">
				<?php echo template::textarea('creation_text', [
					'label' => $text['agenda_view']['creation'][3],
					'class' => $class_tinymce,
					'value' => $text['agenda_view']['creation'][4].$module::$jour.'/'.$module::$mois.'/'.$module::$annee
				]); ?>
			</div>
		</div>

		<div class="row">
			<div class="col4">
				<?php echo template::date('creation_date_debut', [
					'help' => $text['agenda_view']['creation'][5],
					'label' => $text['agenda_view']['creation'][6],
					'value' => $module::$time_unix_deb,
					'vendor' => 'flatpickr'
				]); ?>
			</div>

			<div class="col4">
				<?php echo template::date('creation_date_fin', [
					'help' => $text['agenda_view']['creation'][7],
					'label' => $text['agenda_view']['creation'][8],
					'value' => $module::$time_unix_fin,
					'vendor' => 'flatpickr'
				]); ?>
			</div>
		</div>

		<div class="row">
			<?php if( is_file($module::DATAMODULE.'categories/categories.json') && $this->getData(['module', $this->getUrl(0), 'categories', 'valCategories' ]) ){ ?>
				<div class="col8">
					<?php echo template::select('creation_categorie', $module::$categorie,[
						'help' => $text['agenda_view']['creation'][9],
						'label' => $text['agenda_view']['creation'][10]
					]); ?>
				</div>


			<?php }
			else{	?>
				<div class="col4">
				<?php echo template::select('creation_couleur_fond', $couleur,[
						'help' => $text['agenda_view']['creation'][11],
						'label' => $text['agenda_view']['creation'][12],
						'selected' => 'black'
					]); ?>
				</div>
				<div class="col4">
				<?php echo template::select('creation_couleur_texte', $couleur,[
						'help' => $text['agenda_view']['creation'][13],
						'label' => $text['agenda_view']['creation'][14],
						'selected' => 'white'
					]); ?>
				</div>
			<?php } ?>

		</div>
		<div class="row">
			<div class="col4">
				<?php echo template::select('creation_groupe_lire', $groupe,[
					'help' => $text['agenda_view']['creation'][15],
					'label' => $text['agenda_view']['creation'][16],
					'selected' => '0'
				]); ?>
			</div>
			<div class="col4">
				<?php
					$groupe_mini = $this->getUser('group');
					if ($groupe_mini == self::GROUP_ADMIN){ $groupe_mini = self::GROUP_MODERATOR;}
				?>
				<?php echo template::select('creation_groupe_mod', $groupe,[
					'help' => $text['agenda_view']['creation'][17],
					'label' => $text['agenda_view']['creation'][18],
					'selected' => $groupe_mini
				]); ?>
			</div>
		</div>
		<div class="row">
			<div class="col4">
			<?php echo template::checkbox('creation_mailing_validation', true, $text['agenda_view']['creation'][19], [
				'checked' => false,
				'help' => $text['agenda_view']['creation'][20]
			]); ?>
			</div>
			<div class="col4">
			<!-- Sélection d'un fichier txt ou csv -->
			<?php echo template::select('creation_mailing_adresses', $module::$liste_adresses, [
				'help' => $text['agenda_view']['creation'][21],
				'label' => $text['agenda_view']['creation'][22]
			]); ?>
			</div>
		</div>

	</div>



<?php 	}
	else{?>
		<!--Fermeture de la <div class="row"> si test false-->
		</div>
		<div>
			<div class="col12"><h2><?php echo $text['agenda_view']['creation'][23]; ?></h2></div>
		</div>
	<?php ;}	?>

<?php echo template::formClose(); ?>

<div class="moduleVersion">
	<?php echo $text['agenda_view']['creation'][24];echo $module::VERSION; ?>
</div>
