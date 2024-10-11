<?php
// Lexique du module album en français
$text['album_view']['config'][0] = 'Retour';
$text['album_view']['config'][1] = 'Aide';
$text['album_view']['config'][2] = 'Nouvel Album';
$text['album_view']['config'][3] = 'Nom';
$text['album_view']['config'][4] = 'Dossier cible';
$text['album_view']['config'][5] = 'Albums installés';
$text['album_view']['config'][6] = "Êtes-vous sûr de vouloir supprimer cet album ?";
$text['album_view']['config'][7] = 'Aucune galerie.';
$text['album_view']['config'][8] = 'Version n°';
$text['album_view']['config'][9] = 'module/album/view/config/config.help.html';
$text['album_view']['config'][10] = 'Aide';
$text['album_view']['config'][11] = 'Textes';

$text['album_view']['texts'][0] = 'Retour';
$text['album_view']['texts'][1] = 'Enregistrer';
$text['album_view']['texts'][2] = 'Adapter ces textes dans la langue de vos visiteurs';
$text['album_view']['texts'][3] = 'Retour';
$text['album_view']['texts'][4] = 'Géolocalisation';
$text['album_view']['texts'][5] = 'Aucun album';
$text['album_view']['texts'][6] = 'Version n°';

$text['album_view']['edit'][0] = 'Retour';
$text['album_view']['edit'][1] = 'Enregistrer';
$text['album_view']['edit'][2] = 'Paramètre des images';
$text['album_view']['edit'][3] = 'Nom';
$text['album_view']['edit'][4] = 'Dossier cible';
$text['album_view']['edit'][5] = 'Tri des images';
$text['album_view']['edit'][6] = 'Tri manuel : déplacez le images dans le tableau ci-dessous. L\'ordre est sauvegardé automatiquement.';
$text['album_view']['edit'][7] = 'Image';
$text['album_view']['edit'][8] = 'Couverture';
$text['album_view']['edit'][9] = 'Légende';
$text['album_view']['edit'][10] = 'Aucune image.';
$text['album_view']['edit'][11] = 'Version n°';

$text['gallery']['config'][0] = ' (dossier vide)';
$text['gallery']['config'][1] = ' (dossier introuvable)';
$text['gallery']['config'][2] = 'Modifications enregistrées';
$text['gallery']['config'][3] = 'Configuration du module';
$text['gallery']['delete'][0] = 'Suppression  non autorisée';
$text['gallery']['delete'][1] = 'Album supprimé';
$text['gallery']['edit'][0] = 'Action  non autorisée';
$text['gallery']['edit'][1] = 'Modifications enregistrées';

$text['album']['texts'][0] = "Textes enregistrés";
$text['album']['texts'][1] = "Textes visibles par un visiteur";

$text['album']['init'][0] = 'Retour';
$text['album']['init'][1] = 'Géolocalisation';
$text['album']['init'][2] = 'Aucun album';

//Selects
if($param === "album_view"){
	$sort = [
		$module::SORT_ASC  => 'Alphabétique ',
		$module::SORT_DSC  => 'Alphabétique inverse',
		$module::SORT_HAND => 'Manuel'
	];
}
?>
