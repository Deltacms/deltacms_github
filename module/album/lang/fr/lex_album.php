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

$text['album_view']['gallery'][0] = 'Retour';
$text['album_view']['gallery'][1] = 'Géolocalisation';

$text['album_view']['index'][0] = 'Aucun album.';

$text['gallery']['config'][0] = ' (dossier vide)';
$text['gallery']['config'][1] = ' (dossier introuvable)';
$text['gallery']['config'][2] = 'Modifications enregistrées';
$text['gallery']['config'][3] = 'Configuration du module';
$text['gallery']['delete'][0] = 'Suppression  non autorisée';
$text['gallery']['delete'][1] = 'Album supprimé';
$text['gallery']['edit'][0] = 'Action  non autorisée';
$text['gallery']['edit'][1] = 'Modifications enregistrées';

//Selects
if($param === "album_view"){
	$sort = [
		$module::SORT_ASC  => 'Alphabétique ',
		$module::SORT_DSC  => 'Alphabétique inverse',
		$module::SORT_HAND => 'Manuel'
	];
}
?>
