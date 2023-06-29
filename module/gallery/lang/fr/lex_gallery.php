<?php
// Lexique du module Gallery en français
$text['gallery_view']['config'][0] = 'Retour';
$text['gallery_view']['config'][1] = 'Thème';
$text['gallery_view']['config'][2] = 'Ajouter une galerie';
$text['gallery_view']['config'][3] = 'Nom';
$text['gallery_view']['config'][4] = 'Dossier cible';
$text['gallery_view']['config'][5] = 'Galeries installées';
$text['gallery_view']['config'][6] = 'Dossier cible';
$text['gallery_view']['config'][7] = 'Aucune galerie.';
$text['gallery_view']['config'][8] = 'Version n°';
$text['gallery_view']['config'][9] = "Êtes-vous sûr de vouloir supprimer cette galerie ?";
$text['gallery_view']['config'][10] = 'Aide';
$text['gallery_view']['config'][11] = 'module/gallery/view/config/config.help.html';
$text['gallery_view']['edit'][0] = 'Retour';
$text['gallery_view']['edit'][1] = 'Enregistrer';
$text['gallery_view']['edit'][2] = 'Paramètre des images';
$text['gallery_view']['edit'][3] = 'Nom';
$text['gallery_view']['edit'][4] = 'Dossier cible';
$text['gallery_view']['edit'][5] = 'Tri des images';
$text['gallery_view']['edit'][6] = 'Tri manuel : déplacez le images dans le tableau ci-dessous. L\'ordre est sauvegardé automatiquement.';
$text['gallery_view']['edit'][7] = 'Mode plein écran automatique';
$text['gallery_view']['edit'][8] = 'A l\'ouverture de la galerie, la première image est affichée en plein écran.';
$text['gallery_view']['edit'][9] = 'Image';
$text['gallery_view']['edit'][10] = 'Couverture';
$text['gallery_view']['edit'][11] = 'Légende';
$text['gallery_view']['edit'][12] = 'Aucune image.';
$text['gallery_view']['edit'][13] = 'Version n°';
$text['gallery_view']['gallery'][0] = 'Retour';
$text['gallery_view']['index'][0] = 'Aucune galerie.';		
$text['gallery_view']['theme'][0] = 'Retour';
$text['gallery_view']['theme'][1] = 'Enregistrer';
$text['gallery_view']['theme'][2] = 'Vignettes';
$text['gallery_view']['theme'][3] = 'Les paramètres du thème sont communs aux modules du même type.';
$text['gallery_view']['theme'][4] = 'Largeur';
$text['gallery_view']['theme'][5] = 'Hauteur';
$text['gallery_view']['theme'][6] = 'Alignement';
$text['gallery_view']['theme'][7] = 'Marge';
$text['gallery_view']['theme'][8] = 'Bordure';
$text['gallery_view']['theme'][9] = 'Le curseur horizontal règle le niveau de transparence.';
$text['gallery_view']['theme'][10] = 'Couleur de la bordure';
$text['gallery_view']['theme'][11] = 'Arrondi des angles';
$text['gallery_view']['theme'][12] = 'Ombre';
$text['gallery_view']['theme'][14] = 'Couleur de l\'ombre';
$text['gallery_view']['theme'][15] = 'Opacité au survol';
$text['gallery_view']['theme'][17] = 'Légendes';
$text['gallery_view']['theme'][19] = 'Texte';
$text['gallery_view']['theme'][21] = 'Arrière-plan';
$text['gallery_view']['theme'][22] = 'Hauteur';
$text['gallery_view']['theme'][23] = 'Alignement';
$text['gallery_view']['theme'][24] = 'Version n°';
$text['gallery']['config'][0] = ' (dossier vide)';
$text['gallery']['config'][1] = ' (dossier introuvable)';
$text['gallery']['config'][2] = 'Modifications enregistrées';
$text['gallery']['config'][3] = 'Configuration du module';
$text['gallery']['delete'][0] = 'Suppression  non autorisée';
$text['gallery']['delete'][1] = 'Galerie supprimée';
$text['gallery']['edit'][0] = 'Action  non autorisée';
$text['gallery']['edit'][1] = 'Modifications enregistrées';
$text['gallery']['theme'][0] = 'Action  non autorisée';
$text['gallery']['theme'][1] = 'Modifications enregistrées';
$text['gallery']['theme'][2] = 'Modifications non enregistrées !';
$text['gallery']['theme'][3] = 'Thème';
//Selects
if($param === "gallery_view"){
	$sort = [
		$module::SORT_ASC  => 'Alphabétique ',
		$module::SORT_DSC  => 'Alphabétique inverse',
		$module::SORT_HAND => 'Manuel'
	];
	$galleryThemeFlexAlign = [
		'flex-start' => 'À gauche',
		'center' => 'Au centre',
		'flex-end' => 'À droite',
		'space-around' => 'Distribué avec marges',
		'space-between' => 'Distribué sans marge',
	];
	$galleryThemeAlign = [
		'left' => 'À gauche',
		'center' => 'Au centre',
		'right' => 'À droite'
	];
	$galleryThemeSizeWidth = [
		'9em'  => 'Très petite',
		'12em' => 'Petite',
		'15em' => 'Moyenne',
		'18em' => 'Grande',
		'21em' => 'Très grande',
		'100%' => 'Proportionnelle'
	];
	$galleryThemeSizeHeight = [
		'9em'  => 'Très petite',
		'12em' => 'Petite',
		'15em' => 'Moyenne',
		'18em' => 'Grande',
		'21em' => 'Très grande'
	];
	$galleryThemeLegendHeight = [
		'.125em'  => 'Très petite',
		'.25em'  => 'Petite',
		'.375em'  => 'Moyenne',
		'.5em'  => 'Grande',
		'.625em' => 'Très grande'
	];
	$galleryThemeBorder = [
		'0em' => 'Aucune',
		'.1em' => 'Très fine',
		'.3em' => 'Fine',
		'.5em'  => 'Moyenne',
		'.7em' => 'Epaisse',
		'.9em'  => 'Très épaisse'
	];
	$galleryThemeOpacity = [
		'1'   => 'Aucun ',
		'.9'  => 'Très Discrète',
		'.8'  => 'Discrète',
		'.7'  => 'Moyenne',
		'.6'  => 'Forte',
		'.5'  => 'Très forte'
	];
	$galleryThemeMargin = [
		'0em'    => 'Aucune',
		'.1em'   => 'Très petite',
		'.3em'   => 'Petite',
		'.5em'   => 'Moyenne',
		'.7em'  => 'Grande',
		'.9em'  => 'Très grande'
	];
	$galleryThemeRadius = [
		'0em' => 'Aucun',
		'.3em' => 'Très léger',
		'.6em' => 'Léger',
		'.9em' => 'Moyen',
		'1.2em' => 'Important',
		'1.5em' => 'Très important'
	];
	$galleryThemeShadows = [
		'0px' => 'Aucune',
		'1px 1px 5px' => 'Très légère',
		'1px 1px 10px' => 'Légère',
		'1px 1px 15px' => 'Moyenne',
		'1px 1px 25px' => 'Importante',
		'1px 1px 50px' => 'Très importante'
	];
}
?>