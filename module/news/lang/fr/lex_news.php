<?php
// Lexique du module News en français
$text['news_view']['config'][0] = 'Retour';
$text['news_view']['config'][1] = 'News';
$text['news_view']['config'][2] = 'Enregistrer';
$text['news_view']['config'][3] = 'Paramètres du module';
$text['news_view']['config'][4] = 'Lien du flux RSS';
$text['news_view']['config'][5] = 'Flux limité aux articles de la première page.';
$text['news_view']['config'][6] = 'Etiquette RSS';
$text['news_view']['config'][7] = 'Nombre de colonnes';
$text['news_view']['config'][8] = 'Articles par page';
$text['news_view']['config'][9] = 'Abrégé de l\'article';
$text['news_view']['config'][10] = 'Thème du module';
$text['news_view']['config'][12] = 'Epaisseur';
$text['news_view']['config'][13] = 'Les couleurs sont initialisées à celles du site.';
$text['news_view']['config'][14] = 'Couleur de la bordure';
$text['news_view']['config'][15] = 'Couleur du fond';
$text['news_view']['config'][16] = 'Titre';
$text['news_view']['config'][17] = 'Publication';
$text['news_view']['config'][18] = 'Dépublication';
$text['news_view']['config'][19] = 'Etat';
$text['news_view']['config'][20] = 'Aucune news.';
$text['news_view']['config'][21] = 'Version n°';
$text['news_view']['config'][22] = 'Arrondi des angles';
$text['news_view']['config'][23] = 'Ombre sur les bords';
$text['news_view']['config'][24] = 'Masquer le titre des nouvelles';
$text['news_view']['config'][25] = 'Titres masqués';
$text['news_view']['config'][26] = 'Même hauteur';
$text['news_view']['config'][27] = 'Les colonnes sur une même ligne auront même hauteur';
$text['news_view']['config'][28] = "Êtes-vous sûr de vouloir supprimer cette news ?";
$text['news_view']['config'][29] = "Ce réglage concerne l'aperçu des nouvelles. Dans le dernier paragraphe, souvent tronqué, les différentes balises html sont supprimées.";
$text['news_view']['config'][30] = "Média sans marge";
$text['news_view']['config'][31] = "Avec cette option les médias apparaîtront sans marge dans l'aperçu.";
$text['news_view']['config'][32] = 'Aide';
$text['news_view']['config'][33] = 'module/news/view/config/config.help.html';
$text['news_view']['config'][34] = 'Médias cachés';
$text['news_view']['config'][35] = 'Cette option cache les médias dans l\'aperçu.';
$text['news_view']['config'][36] = 'Couleur du texte';
$text['news_view']['config'][37] = 'Couleur des titres';
$text['news_view']['config'][38] = 'Couleur des liens';
$text['news_view']['config'][39] = 'Couleur de la date et de la siganture';
$text['news_view']['index'][0] = 'lire la suite';
$text['news_view']['index'][1] = 'Aucune news.';
$text['news_view']['index'][2] = ' Editer';
$text['news_view']['add'][0] = 'Retour';
$text['news_view']['add'][1] = 'Enregistrer en brouillon';
$text['news_view']['add'][2] = 'Publier';
$text['news_view']['add'][3] = 'Titre';
$text['news_view']['add'][4] = 'Auteur';
$text['news_view']['add'][5] = 'Informations générales';
$text['news_view']['add'][6] = 'Options de publication';
$text['news_view']['add'][7] = 'La news est consultable à partir du moment ou la date de publication est passée.';
$text['news_view']['add'][8] = 'Date de publication';
$text['news_view']['add'][9] = 'La news est consultable Jusqu\'à cette date si elle est spécifiée. Pour annuler la date de dépublication, sélectionnez une date antérieure à la publication.';
$text['news_view']['add'][10] = 'Date de dépublication';
// Pour Tinymce et Flatpickr
$text['news_view']['add'][12] = 'fr_FR';
$text['news_view']['add'][13] = 'fr';
$text['news_view']['article'][0] = ' à ';
$text['news_view']['article'][1] = 'Editer';
$text['news_view']['article'][2] = 'Retour';
$text['news_view']['edit'][0] = 'Retour';
$text['news_view']['edit'][1] = 'Enregistrer en brouillon';
$text['news_view']['edit'][2] = 'Publier';
$text['news_view']['edit'][3] = 'Informations générales';
$text['news_view']['edit'][4] = 'Titre';
$text['news_view']['edit'][5] = 'Options de publication';
$text['news_view']['edit'][6] = 'Auteur';
$text['news_view']['edit'][7] = 'La news est consultable à partir du moment ou la date de publication est passée.';
$text['news_view']['edit'][8] = 'Date de publication';
$text['news_view']['edit'][9] = 'La news est consultable Jusqu\'à cette date si elle est spécifiée. Pour annuler la date de dépublication, sélectionnez une date antérieure à la publication.';
$text['news_view']['edit'][10] = 'Date de dépublication';
// Pour Tinymce et Flatpickr
$text['news_view']['edit'][12] = 'fr_FR';
$text['news_view']['edit'][13] = 'fr';
$text['news']['add'][0] = 'Nouvelle news créée';
$text['news']['add'][1] = 'Nouvelle news';
$text['news']['config'][0] = 'Modifications enregistrées';
$text['news']['config'][1] = 'Permanent';
$text['news']['config'][2] = 'Configuration du module';
$text['news']['config'][3] = ' à ';
// Pour Tinymce et Flatpickr
$text['news']['config'][4] = 'fr_FR';
$text['news']['config'][5] = 'Europe/Paris';
$text['news']['delete'][0] = 'Action non autorisée';
$text['news']['delete'][1] = 'News supprimée';
$text['news']['edit'][0] = 'Action  non autorisée';
$text['news']['edit'][1] = 'Modifications enregistrées';
// Selects
$states = [
	false => 'Brouillon',
	true => 'Publié'
];
// Nombre de colone par page
$columns = [
	12 => '1 colonne',
	6 => '2 colonnes',
	4 => '3 colonnes',
	3 => '4 colonnes'
];
$height = [
	-1		=> 'Article complet',
	1000 	=> '1000 caractères + 1 média',
	800 	=> '800 caractères + 1 média',
	600 	=> '600 caractères + 1 média',
	400 	=> '400 caractères + 1 média',
	200 	=> '200 caractères + 1 média'
];
$borderWidth = [
	0 			=> 'Aucune',
	'0.1em' 	=> 'Très fine',
	'0.15em'	=> 'Fine',
	'0.2em'		=> 'Très petite',
	'0.25em'	=> 'Petite'
];
$newsRadius = [
	'0px' => 'Aucun',
	'5px' => 'Très léger',
	'10px' => 'Léger',
	'15px' => 'Moyen',
	'25px' => 'Important',
	'50px' => 'Très important'
];
$newsShadows = [
	'0px 0px 0px' => 'Aucune',
	'1px 1px 2px' => 'Très légère',
	'2px 2px 4px' => 'Légère',
	'3px 3px 6px' => 'Moyenne',
	'5px 5px 10px' => 'Important',
	'10px 10px 20px' => 'Très important'
];
?>
