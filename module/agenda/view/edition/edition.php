<?php
// Lexique
include('./module/agenda/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_agenda.php');
?>
<script>
var lang_admin = "<?php echo $lang_admin; ?>";
var lang_flatpickr = "<?php echo $lang_flatpickr; ?>";
</script>

<?php
// Adaptation de Tinymce en fonction des droits des utilisateurs
if( $this->getUser('group') >= $module::$evenement['groupe_mod'] ){
	if( $this->getUser('group') >= self::GROUP_EDITOR){
		$class_tinymce = 'editorWysiwyg';
	}
	else{
		$class_tinymce = 'editorWysiwygComment';
	}
}

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

echo template::formOpen('edition_events'); ?>

<div class="row">
	<div class="col2">
		<?php echo template::button('edition_retour', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . $this->getUrl(0),
			'ico' => 'left',
			'value' => $text['agenda_view']['edition'][0]
		]); ?>
	</div>
<?php 	if( $this->getUser('group') >= $module::$evenement['groupe_mod'] ){?>
	<div class="col2 offset6">
		<?php echo template::button('edition_event_delete', [
			'class' => 'buttonRed',
			'href' => helper::baseUrl() . $this->getUrl(0) . '/deleteEvent/' .$module::$evenement['id'],
			'value' => $text['agenda_view']['edition'][1],
			'ico' => 'cancel'
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::submit('edition_enregistrer',[
			'value' => $text['agenda_view']['edition'][2],
			'ico' => 'check'
		]); ?>
	</div>
<?php
		$readonly = false;
		}
		else{
			$readonly = true;
		}?>
</div>

<div class="block">
	<div class="blockTitle"><?php if ($readonly){echo $text['agenda_view']['edition'][3]; }else{echo $text['agenda_view']['edition'][4];}?></div>

	<?php if($readonly){echo $text['agenda_view']['edition'][5].'<br/><div class="block">'.$module::$evenement['texte'].'</div>';}
	else{
	?>
	<div class="row">
		<div class="col12">
			<?php echo template::textarea('edition_text', [
				'label' => $text['agenda_view']['edition'][5],
				'class' => $class_tinymce,
				'value' => $module::$evenement['texte']
			]); ?>
		</div>
	</div>
	<?php
	}
	?>

	<div class="row">
		<div class="col4">
			<?php echo template::date('edition_date_debut', [
				'help' => $text['agenda_view']['edition'][6],
				'label' => $text['agenda_view']['edition'][7],
				'disabled' => $readonly,
				'value' => $module::$evenement['datedebut'],
				'vendor' => 'flatpickr'
			]); ?>
		</div>

		<div class="col4">
			<?php echo template::date('edition_date_fin', [
				'help' => $text['agenda_view']['edition'][8],
				'label' => $text['agenda_view']['edition'][9],
				'disabled' => $readonly,
				'value' => $module::$evenement['datefin'],
				'vendor' => 'flatpickr'
			]); ?>
		</div>
	</div>

	<div class="row">
			<?php if( $module::$evenement['categorie'] != '' ){	?>
				<div class="col8">
				<?php echo template::select('edition_categorie', $module::$categorie,[
						'help' => $text['agenda_view']['edition'][10],
						'label' => $text['agenda_view']['edition'][11],
						'selected' => $module::$evenement['categorie']
					]); ?>
				</div>
			<?php }
			else{	?>
				<div class="col4">
					<?php echo template::select('edition_couleur_fond', $couleur,[
						'help' => $text['agenda_view']['edition'][12],
						'label' => $text['agenda_view']['edition'][13],
						'disabled' => $readonly,
						'selected' => $module::$evenement['couleurfond']
					]); ?>
				</div>
				<div class="col4">
					<?php echo template::select('edition_couleur_texte', $couleur,[
						'help' => $text['agenda_view']['edition'][14],
						'label' => $text['agenda_view']['edition'][15],
						'disabled' => $readonly,
						'selected' => $module::$evenement['couleurtexte']
					]); ?>
				</div>
			<?php } ?>


	</div>

	<div class="row">
		<div class="col4">
			<?php echo template::select('edition_groupe_lire', $groupe,[
				'help' => $text['agenda_view']['edition'][16],
				'label' => $text['agenda_view']['edition'][17],
				'disabled' => $readonly,
				'selected' => $module::$evenement['groupe_lire']
			]); ?>
		</div>
		<div class="col4">
			<?php echo template::select('edition_groupe_mod', $groupe,[
				'help' => $text['agenda_view']['edition'][18],
				'label' => $text['agenda_view']['edition'][19],
				'disabled' => $readonly,
				'selected' => $module::$evenement['groupe_mod']
			]); ?>
		</div>
	</div>
</div>

<?php echo template::formClose(); ?>
<div class="moduleVersion">
	<?php echo $text['agenda_view']['edition'][20]; echo $module::VERSION; ?>
</div>
