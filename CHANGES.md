# Changelog

## Version 5.2.02 de Deltacms
- Modifications :
	- Thème / Gestion : Amélioration de l'application du nouveau thème,
	- Modules / Initialisation : les textes frontaux sont dans la langue de rédaction ou dans la langue de traduction si elle est française, anglaise ou espagnole, sinon dans la langue d'administration,
	- Blog 7.4 : la taille de l'aperçu en nombre de caractères est paramétrable,
	- Filemanager : l'aperçu des fichiers utilise des viewers ©Deltacms, les vignettes respectent le ratio des images, un code tricolor: vert, orange, rouge, renseigne l'utilisateur sur le poids des images, celles en rouge n'étant pas compatibles avec un site Internet
	- Configuration / mise à jour ou réinitialisation : amélioration de la procédure avec timeout et message d'erreur.
- Corrections :
	- Page / Duplication : corrigée pour les pages contenant un module news ou agenda,
	- Membre / affichage des documents personnels : le format avif est pris en compte,
	- Terminaux mobiles à écran large : sélection d'une page d'un sous-menu.
- Sur le site :
	- Template Switch 1.1 : nouveau module en téléchargement, il permet de disposer sur une page d'un sélecteur de thème frontal, vos visiteurs apprécieront.

## Version 5.2.01 de Deltacms
- Modifications :
	- Suppression de fonctions dépréciées par php 8.1, 8.2 et 8.3. Deltacms est compatible avec php 8.3,
	- Commentaires de page et de blog : les modérateurs peuvent les éditer pour par exemple saisir une réponse,
	- Module du coeur / addon : suppression des fonctions export et import,
	- Coeur : amélioration de la prise en compte des informations de localisation du serveur,
	- Nouvelles informations en configuration du site /  configuration : prise en compte du format avif, locale actuelle,
	- Filemanager, modules blog et album : les images au format avif et webp animé sont autorisées.
- Correction :
	- Correction de 2 textes en espagnol et en anglais dans la partie configuration du site / localisation,
	- Site en maintenance / login : l'appui sur le bouton "Annuler" provoquait un warning,
	- Commentaires de page : l'export csv est fonctionnel.
- Sur le site :
	- Geophoto en version 2.7 :
		- diminution d'1 point des zooms de la carte CyclOSM
		- édition du texte descriptif avec tinymce, dans toutes les langues
		- ajout des surcouches ombrage et pente IGN fr
		- le thème de la trace s'affiche dans la fenêtre du sélecteur
		- centrage du sélecteur dans la page et amélioration de son style
		- ajout du contrôle de l'échelle des cartes
		- le bouton "afficher ou cacher la galerie" est plus grand, évitant l'affichage sur 2 lignes du texte par défaut
	- Vidéo : Nouveau module de type galerie, recherche des vidéos mp4, m4v et webm dans un dossier défini, les affiche en vignette, avec ou sans image poster, et les lit dans la lightbox du CMS.

## Version 5.1.02 de Deltacms
- Modifications :
	- Page / Edition : si le groupe requis pour accéder à la page est 'Membre', 2 nouvelles options sont disponibles :
		- Visibilité de la page pour tous les membres ou pour un membre particulier (les éditeurs, modérateurs, administrateurs ont accès à la page),
		- Affichage de documents ou de liens dans la page, visibles uniquement par le ou les membres. Les fichiers sont à placer dans le dossier 'site/file/source/membersDirectory/identifiant_du_membre'.
	- Commentaires de page : remplissage automatique du champ 'Nom ou pseudo' pour les utilisateurs connectés, les notifications comme 'Commentaire soumis' sont traduisibles dans la langue de vos visiteurs,
	- Agenda 7.3, Album 4.7, Blog 7.2, News 5.2, Search 3.7, Form 6.2 : tous les textes affichés par le CMS, comme 'Retour', 'Lire la suite', sont traduisibles dans la langue de vos visiteurs.
	  Un drapeau du pays indique la langue ciblée,
	- Configuration / localisation : internationalisation des messages "Obligatoire" et "Impossible de soumettre..." utilisés dans plusieurs modules.
- Correction :
	- Commentaires de page / configuration : un label erroné,
	- Commentaires de page : si la page change de nom les commentaires sont conservés,
	- Modules : les données volumineuses produites par les modules de page, et spécifiques à la page, sont supprimées à son effacement,
	- Statislite 5.2 : rétablissement de l'accès aux fichiers robots.json et sessionInvalide.json,
	- Form 6.2 : configuration / Gérer les données / Tout effacer, effacement complet,
	- Modules Blog 7.2, Form 6.2, Sondage 2.2 : gestion des captchas,
	- Modules Blog 7.2, News 5.2 : suppression du warning si un article est ouvert sans passer par la page principale du module,
	- Module search : création des fichiers de thèmes à l'installation.
- Sur le site :
	- Modules Sondage 2.2, Guestbook 2.2, Geophoto 2.4 : vous pouvez traduire ou adapter les messages à destination de vos visiteurs,

## Version 5.1.01 de Deltacms
- Modifications :
	- Module Blog 7.1 : boutons article suivant, article précédent en vue article,
	- Modules de page : amélioration de l'initialisation et de la mise à jour des modules,
	- Configuration / Social : nouveau réseau Mastodon et mise à jour de l'icône Twitter,
	- Thème / Menu : nouvelle option 'Inversion des couleurs du site', une icône dans le menu permet de commuter, pour la partie principale du site, entre l'affichage avec les couleurs du thème ou l'affichage avec des couleurs inversées ( hors bannière, menu, images, vidéos...).
	- Thème / Menu : nouvelle option 'Augmentation de la taille des caractères du site', une icône dans le menu permet de modifier, pour la partie principale du site, la taille des caractères ( +2px, +4px, taille initiale, +2px,...)
- Correction :
	- Footer / icônes des réseaux sociaux : taille des icônes SVG et disposition des icônes en petit écran.
- Sur le site :
	- Modules Sondage 2.1, Guestbook 2.1, Snipcart 3.1, Gallery 5.0 : amélioration de l'initialisation et de la mise à jour des modules,
	- Module Sondage 2.1 : amélioration du fonctionnement lorsque l'option 'validation de la participation par courriel' est choisie,
	- Module Géo Photo 2.0 : augmentation du choix de cartes (on passe de 2 à 7 cartes), ajout des surcouches rando, cyclo, vtt, accès et possibilité de masquer la trace GPS,
	- Attention le module Gallery ne sera plus maintenu à partir du 1/1/2025, on vous conseille de migrer vers le module Album inclus dans le zip.

## Version 5.1.00 de Deltacms
- Modifications :
	- Modules Blog 7.0 /  Form 6.0 / News 5.0 / Agenda 7.1 / Statislite 5.0 :
	  Pour alléger le fichier module.json commun à l'ensemble des modules, certaines données de module de page sont enregistrées dans des fichiers json distincts,
	  1 fichier pour Blog, Form et News (au nom de la page), 1 dossier pour Agenda, Statislite. Les autres modules livrés ne sont pas concernés,
	- Module Form 6.0 : nouvelle option "acceptation des conditions d'utilisation des données personnelles".
- Correction :
	- Filemanager : correction d'instructions dépréciées.
- Sur le site :
	- Bonus / Modules / sondage 2.0 : nouvelle structure pour l'enregistrement des données de module de page et nouvelles options "validation de la participation par courriel" et
	  "acceptation des conditions d'utilisation des données personnelles",
	- Bonus / Modules / guestbook 2.0 : nouvelle structure pour l'enregistrement des données de module de page et nouvelle option "acceptation des conditions d'utilisation des données personnelles".

## Version 5.0.02 de Deltacms
- Modifications :
	- animation et réduction du panneau cookies,
	- édition avec Tinymce : nouveaux templates pour insérer un bloc ou une image en pleine largeur quelque soit l'écran et un bloc de texte sans titre,
	- configuration / connexion : le captcha à la connexion est toujours de type opération,
	  le captcha comportemental reste disponible pour les autres usages (blog, formulaire, commentaires de page,...)
- Correction :
	- gestion des langues / copie d'une page : si la page d'accueil est absente, une autre page est utilisée pour l'url par défaut.
- Sur le site :
	- Bonus / Modules : un nouveau module pour réaliser des questionnaires nommé 'Sondage',
	- Bonus / Vidéos : module sondage.

## Version 5.0.01 de Deltacms
- Modifications :
	- Edition de page : nouvelle option avec la possibilité d'autoriser des commentaires sur une page. la configuration des commentaires est commune à toutes les pages, la gestion propre à chaque page. Cette option n'utilise pas de module.
	- Edition de page : nouveau gabarit de page "barre 2/12 - page 8/12 - barre 2/12"
	- Gestion des langues : l'utilitaire de copie permet d'ajouter ou de modifier une page, sous-page ou barre,
	- Editeur Tinymce : Tinymce passe en version 5.10.9. Les utlisateurs du module Snipcart devront faire une mise à jour vers Snipcart V30.
- Corrections :
	- Menu : suppression de l'aléa lors du passage de petit écran à grand écran,
	- Theme / Bannière / option contenu personnalisé : les couleurs dans l'éditeur Tinymce sont celles réglées dans cette option.
- Sur le site :
	- Snipcart V30 : mise à jour indispensable pour compatibilité avec Deltacms 5.0.01

## Version 4.5.04 de Deltacms
- Modifications :
	- Agenda 6.0 : la couleur de la grille est réglable en configuration,
	- News 4.8 : en configuration paramétrage des couleurs pour le texte, les titres, les liens et la signature,
	- Captcha : polices truetype pour compatibilité avec d'anciennes compilations d'une librairie PHP,
	- Form 5.1 : le brouillon est maintenant mémorisé par des variables de session.
- Corrections :
	- News 4.8 : en édition des news les couleurs paramétrées sont visibles dans l'éditeur Tinymce,
	- Form 5.1 : le brouillon peut mémoriser et restituer plusieurs champs texte, case à cocher et sélection.
- Sur le site :
	- Bonus / Modules : Livre d'or (Guestbook), ce module permet également de déposer des commentaires sur une page standard.

## Version 4.5.03 de Deltacms
- Modifications :
	- Mise à jour des icônes,
	- Gabarits de page : Color box, une boîte colorée, sans marge en petit écran, couleurs paramétrables dans l'éditeur CSS,
	- Thème / Editeur CSS : ajout d'une pipette à couleurs et d'une popup de recherche dans l'éditeur,
	- Album Photo en version 4.5 : mise à jour des fichiers d'aide et du tri des galeries, prise en compte du nouveau jeu d'icônes
	- Form 5.0 : Saisie et mise en forme des messages avec Tinymce,
- Corrections :
	- Form 5.0 : la longueur des messages n'est plus limitée à 500 caractères.
- Sur le site :
	- Bonus / Vidéos : module album photo,
	- Bonus / Vidéos : saisie dans Tinymce avec les gabarits blocs, grilles et effet accordeon,
	- Bonus / Vidéos : saisie dans Tinymce avec le gabarit color box,
	- Bonus / Scripts : Script dans head ou dans body limité à certaines pages.

## Version 4.5.02 de Deltacms
- Modifications :
	- Theme / site : suppression des arrondis autour du site en petit écran.
	- Thèmes livrés : un nouveau thème vert sombre (theme_vert_sombre_fluide.zip),
	- Album Photo en version 4.3.2 : amélioration générale de l'interface, les vignettes sont plus grandes, les couleurs de bordure et de texte adoptent celles du thème en place. Les originaux des images réorientées sont désormais sauvegardés, un message informatif s'affiche lors du traitement des images, ajout des fichiers d'aide.
- Corrections :
	- Theme / Menu / Burger : les liens associés aux icônes gauche et centrale du bandeau burger sont valides pour toutes les langues du site,
	- Thèmes livrés : mise à jour du thème sombre islande (theme_sombre_islande_fluide.zip).

## Version 4.5.01 de Deltacms
- Modifications :
	- Une troisième langue d'administration est disponible : espagnol / castillan,
	- Thème / Menu : le menu en petit écran (burger) dispose maintenant de ses propres paramètres,
	- Modules du coeur et de page : renforcement de la sécurité,
	- Module de type galerie: 'Album' remplace 'Gallery', les vignettes respectent le format des photos, 'Album' permet de géo-localiser sur quatre cartes disponibles les photos qui intègrent la balise EXIF GPS, et de donner leur altitude
	- Module mis à jour : Gallery n'est plus distribué dans le zip d'installation ou dans les mises à jour en ligne. La version 4.4 est disponible en téléchargement sur https://deltacms.fr/modules, la mise à jour est conseillée,
	- Langues : la traduction automatique est supprimée, ce qui parachève la dégooglisation de Deltacms,
	- Edition de page / emplacement dans le menu : une page désactivée est signalée par le curseur 'not-allowed' et par une typographie italique en petit écran, son lien est inactif,
	- Nouveaux gabarits pour l'éditeur Tinymce : accordéon à 3 et 4 paragraphes,
	- Configuration / recherche d'une mise à jour : le serveur n'utilise plus son cache pour lire le fichier de version,
	- Statislite 4.8 : comptage des liens cliqués pour lesquels la class 'clicked_link_count' a été ajoutée par l'éditeur de liens de Tinymce,
	- Agenda 5.9 : la langue de l'agenda s'adapte automatiquement à la traduction rédigée,
	- Blog 6.8 et News 4.7 : les dates s'adaptent automatiquement à la traduction rédigée, amélioration de la navigation entre les articles,
	- Theme / Footer : amélioration, 'Qui est en ligne ?' s'affiche dans la langue de rédaction du site avec les labels réglables dans Configuration / Localisation.
	- Scripts : les fichiers body.inc.html et head.inc.html sont renommés body.inc.php et head.inc.php,
	- Modules mis à jour : Snipcart, Modèle, Galerie GPS, Gallery sont disponible en téléchargement sur https://deltacms.fr/modules, la mise à jour est conseillée.
- Correction :
	- Langues : la langue originale de rédaction du site choisie à l'installation peut être modifiée
	- Slider 4.8 / Configuration : les liens sur les images étaient modifiés au changement de l'ordre des pages.

## Version 4.4.10 de Deltacms
- Modifications :
	- Changement d'hébergeur pour les vidéos,
	- Suspension de la traduction automatique.

## Version 4.4.09 de Deltacms
- Corrections :
	- Statislite / configuration : erreur qui effaçait l'information 'configuration validée',
	- Thème / header : bannière sur page d'accueil seulement, correction.

## Version 4.4.08 de Deltacms
- Correction :
	- Thème / bannière : perte de contrôle du thème si la case 'Masquer la bannière en écran réduit' était décochée.

## Version 4.4.07 de Deltacms
- Modifications :
	- Thème / Gestion : possibilité de saisir un nom lors de la sauvegarde ou de l'export d'un thème,
	- Masquage des commentaires dans le layout,
	- Thème / bannière : sur petit écran possibilité de configurer la bannière même quand elle est masquée en petit écran,
- Corrections :
	- Thème / menu : problème de défilement du menu sur petit écran quand il était hors du site et fixe,
	- Thème / menu / configuration : erreur qui modifiait l'ordre d'affichage des blocs en petit écran,

## Version 4.4.06 de Deltacms
- Modifications :
	- Thème / Footer : nouvelle option 'Qui est en ligne ?', affiche le nombre de visiteurs ou d'utilisateurs connectés,
	- Réécriture du layout, l'affichage des pages est plus rapide,
	- Module Form : un brouillon trop ancien est effacé pour détruire les traces de robots malveillants,
	- Configuration / configuration : message de confirmation avant une mise à jour de DeltaCMS.
- Corrections :
	- Module Form : messages liés au captcha,
	- Thème / menu : l'aperçu en direct pendant sa configuration est amélioré,
	- Configuration / configuration : lien du bouton Réinstaller neutralisé si le bouton est désactivé.

## Version 4.4.05 de Deltacms
- Modifications :
	- Chargement ordonné des scripts javascript et des styles, l'affichage des pages est plus rapide,
	- Le fichier pdf pour les informations de debug est remplacé par un copier / coller assisté,
	- Thème / menu : modification de la largeur du menu si la bannière est au dessus du site et limitée au site, améliorations,
	- Thème / bannière : amélioration de l'affichage de la bannière animée.
- Corrections :
	- Initialisation d'une variable utilisée dans la capture d'écran,
	- Encodage de certaines pages de configuration de module.

## Version 4.4.04 de Deltacms
- Modifications :
	- Edition / Tinymce : nouveau blocs de texte 3-6-3,
	- Thème / site : modification des options 'Largeur du site' qui passent en valeurs relatives 75vw, 85vw, 95vw, 100%,
	- Modules de page / thème : le thème des modules de page est maintenant modifiable par custom.css,
	- Site fluide sur petit écran : nouveau seuil à 800px, nettoyage et réorganisation du fichier css principal,
	- Configuration / configuration : modification de la mise à jour automatique pour prendre en compte les incompatibilités du serveur.
- Corrections :
	- Module Form : en absence de champ 'File' un fichier fantôme était émis, logo associé au message compatible avec androïd,
	- Thème / gestion / sauvegarde : le dossier et les images de la bannière animée sont sauvegardés dans le zip.

## Version 4.4.03 de Deltacms
- Modifications :
	- Thème / bannière : nouvelle option, une bannière animée avec Swiper,
	- Configuration / connexion : nouvelle option permettant de dévoiler le mot de passe,
	- Module News : amélioration de l'affichage de l'aperçu,
	- Configuration / référencement : les données meta propres à Facebook, insérées dans le head de la page, sont maintenant optionnelles.
- Corrections :
	- Theme / footer : sélection du template sur une colonne et différents aperçus,
	- Module Agenda : changement de nom du dossier xxxx_affiche quand le nom de la page est modifié.

## Version 4.4.02 de Deltacms
- Modifications :
	- mise en conformité W3C des blocs utilisés en édition et en administration,
	- modification du panneau cookie,
	- mise à jour des mentions légales,
	- modification de la redirection aprés une mise à jour de Deltacms,
	- aide en ligne sous forme de vidéos pour les 9 modules de page Agenda, Slider, Statislite, Blog, Form, Gallery, News, Redirection, Search.
- Corrections :
	- gestion des utilisateurs : description des droits éditeur et modérateur.

## Version 4.4.01 de Deltacms
- Modifications :
	- Ajout du groupe éditeur, autorisations limitées à l'édition des pages, l'ajout de fichiers, l'accès aux pages privées membre et éditeur,
	- Adaptation des modules de page à ce nouveau groupe avec des actions autorisées limitées,
	- Nouvelle option dans l'édition d'une page, permissions : sélection du groupe requis pour modifier la page,
	- Modules Gallery et Slider, sélection du dossier : seuls les dossiers incluant au moins une image sont proposés et exclusion de certains dossiers
	- Nettoyage : suppression de fichiers inutiles (2.5Mo),
- Corrections :
	- Affichage du sous-menu avec un alignement du contenu à droite : il y avait un décalage du site quand les pages situées à la droite du menu possédaient des pages enfants.
	- Affichage du menu : quand le menu comprenait de nombreux items certains pouvaient être masqués dans une fenêtre de taille moyenne.

## Version 4.3.08 de Deltacms
- Modifications :
	- Captcha : nouvelle option 'Captcha simple pour les humains', le Captcha se réduit à une simple case à cocher, une analyse comportementale
	qualifie le type de visiteur,
	- Captcha : nouveau captcha, suppression des options captcha renforcé et type de captcha,
	- Tinymce / image : nouvelle option permettant d'afficher un titre sous l'image,
	- News 4.3 prise en compte de l'option titre sous l'image,
- Corrections :
	- Configuration / configuration : 2 'textarea' avaient le même identifiant.
	- News 4.3 déplacement de l'initialisation de tinymce et flatpickr,
	- Blog 6.4 déplacement de l'initialisation de tinymce et flatpickr,
	- Divers : mise en conformité W3C.

## Version 4.3.07 de Deltacms
- Modifications :
	- Configuration / Thème / Header : nouvelle option bannière visible uniquement sur la page d'accueil,
- Corrections :
	- Snipcart : modification dans Core / Page / Edition pour compatibilité avec ce module,
	- Agenda 5.4 : correction d'un bug critique lié à la limitation des droits liés aux évènements, mise à jour indispensable,
	- Configuration / Thème / Header : correction de plusieurs bugs notamment pour l'affichage en mode aperçu.

## Version 4.3.06 de Deltacms
- Corrections :
	-¨Personnalisation des thémes : color picker absent du paramétrage de la bannière et du footer.

## Version 4.3.05 de Deltacms
- Modifications :
	- Form, Agenda, Gallery : les lexiques pour la langue d'administration sont déportés dans des dossiers 'lang',
	- Modules du coeur, core.php, core.js.php : les lexiques pour la langue d'administration sont déportés dans des dossiers 'lang',
	- Fichier sitemap.xml : exclusion des pages orphelines,
	- Capture Opengraph : réduction du poids de l'image screenshot.jpg.

## Version 4.3.04 de Deltacms
- Modifications :
	- Fichiers .htaccess : Mise à jour vers Apache 2.4. Attention pour cette mise à jour vers la version Deltacms 4.3.04
	l'option "Préservez le fichier .htaccess racine", dans Configurer le site / onglet Configuration / bloc Mise à jour automatisée,
	doit être décochée. Sinon vous devrez mettre en version Apache 2.4 votre .htaccess racine personnalisé,
	- Fichiers robots.txt et sitemap.xml : suppression de la mise à jour automatique de ces fichiers, elle ne pourra plus se faire
	que par un appui sur le bouton "Générer sitemap.xml et robots.txt" dans Configurer le site / onglet Référencement / bloc Paramètres,
	- Blog : le lexique pour la langue d'administration est déporté dans un dossier 'lang',
	- Blog : L'image d'illustration n'est plus obligatoire,
	- Filemanager : les images au format webp sont autorisées,
	- Agenda, Statislite : les dossiers d'installation de ces modules sont placés dans un dossier 'ressource' du module.
- Corrections :
	- Form, Agenda : déplacement de l'initialisation de variables Javascript qui provoquait un décalage d'affichage dans la barre d'administration.

## Version 4.3.03 de Deltacms
- Modifications :
	- News : nouvelle option insérer des images ou des iframe sans marges.

## Version 4.3.02 de Deltacms
- Modifications :
	- News : modernisation du thème avec ajout de nouvelles options,
	- Core / Page / Edition : modifications des valeurs par défaut lors de la création d'une nouvelle page,
	- Core / Page / Edition : modification de la gestion du bouton de configuration du module,
	- News, Search, Redirection, Statilite : les lexiques pour la langue d'administration sont déportés dans un dossier 'lang',
	- Slider : lexiques, compléments.
- Corrections :
	- Statislite : désactivation de Statislite si la page de statistiques est supprimée,
	- Blog : commentaires, mauvais chargement d'une feuille de style.

## Version 4.3.01 de Deltacms
- Modifications :
	- Slider : simplification de la configuration réalisée sur une seule page,
	- Slider : les lexiques pour la langue d'administration sont déportés dans un dossier 'lang',
	- Search : la langue d'administration est prise en compte à l'initialisation du module,
	- Agenda, Blog, News, Statislite : l'affichage des dates fonctionne avec ou sans le module PHP 'intl' installé.
- Corrections
	- Blog : modification de l'initialisation qui créait une erreur sous PHP 8.1,
	- Search : modification de fonctions qui créaient des 'deprecated' sous PHP 8.1.

## Version 4.2.04 de Deltacms
- Modifications :
	- Formulaire : paramétrage des pièces jointes autorisées parmi jpg, png, pdf, zip et txt,
	- Formulaire : contrôle de validité des pièces jointes de type jpg, png, pdf et zip,
	- Tinymce / gabarits : les blocs de texte 6-6, 4-4-4 et 3-3-3-3 ont automatiquement une même hauteur,
	- Nouveau site exemple à l'installation.

## Version 4.2.03 de Deltacms
- Modifications :
	- Configuration / Configuration : affichage et export pdf d'informations à envoyer au support en cas de dysfonctionnement,
	- Configuration / Référencement : amélioration de la capture Open Graph,
	- Statislite : amélioration de l'affichage en petit écran,
	- Agenda : suppression du cache à l'affichage des évènements (problème d'affichage avec certains serveurs),
	- Nettoyage : suppression de 2Mo de données inutiles.

## Version 4.2.02 de Deltacms
- Modifications :
	- Statislite : sécurité vis à vis d'une corruption des fichiers json,
	- Statislite : mise à jour de la ressource d'identification des systèmes d'exploitation,
	- Personnalisation du thème / menu burger avec affichage du titre : réglage de la taille et de la couleur du texte.
- Corrections :
	- Statislite : erreur sur le nom d'une variable.

## Version 4.2.01 de Deltacms
- Modifications :
	- Gestionnaire de fichiers : compatibilité PHP 8.1,
	- News : compatibilité PHP 8.1,
	- Slider : compatibilité PHP 8.1,
	- Configuration / langues : compatibilité PHP 8.1,
	- Configuration / connexion : compatibilité PHP 8.1.

## Version 4.1.05 de Deltacms
- Modifications :
	- Langues : RFM bilingue anglais / français et quelques compléments de traduction,
	- Formulaire : avec le module Form possibilité de placer une pièce jointe dans le mail (jpg, jpeg, png ou gif)

## Version 4.1.04 de Deltacms
- Modifications :
	- Langues : ajout de 4 langues régionales, corse, breton, catalan, basque.

## Version 4.1.03 de Deltacms
- Modifications :
	- Statislite : amèlioration de l'affichage de la date initiale,
	- Agenda : si la langue originale du site n'est pas reconnue, la langue d'administration est utilisée,
	- Blog : dans les labels de Tinymce si la langue originale du site n'est pas reconnue, la langue d'administration est utilisée,
	- Langues : si le dapeau correspondant au langage du site n'existe pas un drapeau par défaut est affiché dans les pages de localisation.
- Correction :
	- Statislite : modification de l'initialisation du filtrage primaire.

## Version 4.1.02 de Deltacms
- Modifications :
	- Installation : la page d'accueil du site d'exemple est dans la langue originale du site.

## Version 4.1.01 de Deltacms
- Modifications :
	- Installation et configuration de la langue originale du site : ajout des langues grec, finnois, irlandais, suédois, danois,
	- Configuration de la langue originale du site : option 'Autre langue' avec saisie du code de langue ISO, la traduction automatique par script
	  est maintenant possible depuis n'importe quelle langue vers les 12 langues européennes proposées.
- Correction :
	- Cookie pour le script de traduction automatique Google : correction d'un bug qui se produisait avec Chrome et associés dans le cas d'un site
	implanté dans un sous-domaine.

## Version 4.0.02 de Deltacms
- Modifications :
	- Administration : totalement bilingue y compris pour les modules de page,
	- Blog et Search : Les textes relatifs aux commentaires visibles par un visiteur peuvent être traduits dans la langue du site,
	- Blog : pour les saisies de commentaire les aides dans Tinymce sont dans la langue du site,
	- Installation : améliorations,
	- Site exemple : le site créé à l'installation est intégralement en anglais ou en français suivant la langue d'administration choisie.

## Version 4.0.01 de Deltacms
- Modifications :
	- Langues : choix de langue d'origine, ce n'est plus automatiquement le français,
	- Langues : choix de la langue, français ou anglais pour les pages d'administration,
	- Langues : traduction automatique du site de la langue d'origine vers une langue européenne (script Google),
	- Langues : traduction rédigée du site avec copie des données d'une langue vers une autre, pour préparer le travail de traduction,
	- Installation : modification de la page d'installation, bilingue français anglais,
	- Site exemple : modification de la page d'accueil du site après installation, bilingue.

## Version 3.2.06 de Deltacms
- Modifications :
	- Traduction automatique du site pour les membres connectés.

## Version 3.2.05 de Deltacms
- Correction :
	- polices : noms à la place des clefs dans les différents thèmes livrés

## Version 3.2.03 de Deltacms
- Modifications :
	- polices : suppression des doublons @open-face dans theme.css

## Version 3.2.02 de Deltacms
- Modifications :
	- polices : identification par nom et non par clef pour permettre l'utilisation de polices sans fichier de définition.

## Version 3.2.01 de Deltacms
- Modifications :
	- nouvelles polices 'Open Font License' hébergées en local, l'administrateur peut ajouter des polices.

## Version 3.1.01 de Deltacms
- Modifications :
	- modification de la capture Open Graph, screenshot.jpg est maintenant générée en local sans recours à Google

## Version 3.0.04 de Deltacms
- Modifications :
	- Nouveau site par défaut à l'installation,
	- Modification de l'affichage en petit écran (smartphone),
	- Adaptation automatique de la taille du logo dans le menu burger,
	- Adaptation automatique de la taille des icônes dans le menu,
	- Sauvegarde automatique du thème du site ou de l'administration avant l'application d'un nouveau thème,
	- Tinymce : amélioration de l'affichage de la zone de saisie wysiwyg,
	- Tinymce : nouveaux gabarits ( 2, 3 ou 4 blocs en ligne) et saisies avec gabarits facilitées,
	- Tinymce: fontsize-formats en pixel,
	- Agenda V4.7 : amélioration de l'affichage en vue par semaine et en petit écran,
	- Thème : nouveaux paramètres pour les blocs,
	- panneau cookies : modification du thème,
	- News: amélioration de l'affichage.

## Version 3.0.03 de Deltacms
	- Installation de nouveaux modules par défaut : Slider (diaporama), Agenda, Statislite (statistiques de fréquentation).

## Version 3.0.02 de Deltacms
- Modifications :
	- Utilisateurs, l'administrateur peut sélectionner une page de redirection après connexion pour chaque membre, par défaut aucune.

## Version 3.0.01 de Deltacms
- Modifications :
	- Export de théme, sauvegarde des images de la bannière personnalisée
	- Import de thème, modification du nom des fichiers importés pour éviter l'écrasement des fichiers de même nom.

Deltacms a été créé à partir de la version 11.2.00.24 de ZwiiCMS publié sous licence GNU GPL V3, les versions 1.x.xx et 2.x.xx de Deltacms n'ont pas été distribuées.


