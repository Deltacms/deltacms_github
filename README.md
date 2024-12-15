
# DeltaCMS 5.2.01

DeltaCMS est un CMS sans base de données (flat-file) qui permet de créer et gérer facilement un site web sans aucune connaissance en programmation.
L'administration du site est trilingue espagnol (castillan), anglais ou français, le site peut être rédigé dans une langue quelconque.
Vous pourrez réaliser une traduction rédigée dans la langue de votre choix.

DeltaCMS is a database-less (flat-file) CMS that allows you to easily create and manage a website without any programming knowledge.
The administration of the site is trilingual Spanish, English or French, the site can be written in any language.
You will be able to produce a translation written in the language of your choice.

DeltaCMS es un CMS sin base de datos (flat-file) que permite crear y administrar fácilmente un sitio web sin ningún conocimiento de programación.
La administración del sitio es trilingüe español (castellano), inglés o francés, el sitio puede ser escrito en cualquier idioma.
Podrás realizar una traducción escrita en el idioma de tu elección.

[Site](http://deltacms.fr/)

DeltaCMS a été créé à partir de ZwiiCMS 11.2.00.24 publié sous licence GNU GPL V3


## Configuration recommandée

* PHP 7.2 ou plus
* Support de .htaccess

## Téléchargement de DeltaCMS

Pour télécharger la dernière version publiée, il faut vous rendre sur la page de téléchargement du [site](https://deltacms.fr/telechargement)
To download the latest version, go to the download page of the [site](https://deltacms.fr/telechargement)

## Installation

Décompressez l'archive de DeltaCMS et téléversez son contenu à la racine de votre serveur ou dans un sous-répertoire. C'est tout !
Unzip the DeltaCMS archive and upload its contents to the root of your server or to a subdirectory. That's it!

## Procédures de mise à jour

### Automatique

* Connectez-vous à votre site.
* Si une mise à jour est disponible, elle vous est proposée dans la barre d'administration.
* Cliquez sur le bouton "Mettre à jour".

### Manuelle

* Sauvegardez l'intégralité de votre site, spécialement le répertoire "site".
* Décompressez la nouvelle version sur votre ordinateur.
* Transférez son contenu sur votre serveur en activant le remplacement des fichiers.

En cas de difficulté avec la nouvelle version, il suffira de téléverser la sauvegarde pour remettre votre site dans son état initial.


## Arborescence générale

*Légende : [R] Répertoire - [F] Fichier*

```text
[R] core                   Cœur du système
  [R] class                Classes
  [R] include              Dossier des includes
	[F]	update.inc.php	   Update des données 
	[F] comment.inc.php	   Pseudo module des commentaires de page
	[F] member.inc.php	   Affichage des fichiers pour un membre particulier	
  [R] layout               Mise en page
  [R] module               Modules du cœur
  [R] vendor               Librairies extérieures
  [F] core.js.php          Cœur javascript
  [F] core.php             Cœur PHP

[R] module                 Modules de page
  [R] agenda	           Agenda
  [R] album                Album photo
  [R] blog                 Blog
  [R] form                 Gestionnaire de formulaires
  [R] news                 Nouvelles
  [R] redirection          Redirection
  [R] search               Recherche
  [R] slider	           Slider diaporama
  [R] statislite           Statistiques de fréquentation

[R] site                   Contenu du site
  [R] backup               Sauvegardes automatiques
  [R] data                 Répertoire des données
    [R] base               Dossier localisé, un dossier par langue rédigée, exemples base, en, es, de
	  [F] comment.json	   Commentaires de page
      [F] page.json        Données des pages
      [F] module.json      Données des modules de page
      [F] locale.json      Données du site propres à la langue
      [R] content          Dossier des contenus de page
        [F] accueil.html   Exemple contenu de la page d'accueil
	  [R] data_module	   Données volumineuses des modules de page
		[F] blog.json      Exemple de page avec module ayant des données volumineuses, un fichier par page ou un dossier pour statislite et agenda
    [R] *modules*          Un dossier par module, exemple [R]search [R]agenda, pour les données du module
    [F] admin.css          Thème des pages d'administration
    [F] admin.json         Données de thème des pages d'administration
    [F] blacklist.json     Journalisation des tentatives de connexion avec des comptes inconnus
	[F] body.inc.php       Script personnalisable affiché en bas de page
    [F] config.json        Configuration du site
    [F] core.json          Configuration du noyau
    [F] custom.css         Feuille de style de la personnalisation avancée
    [F] fonts.json         Polices du site
	[F] header.inc.php     Script personnalisable placé dans le header de la page
    [F] journal.log        Journalisation des actions
	[F] session.json       Affichage des utilisateurs en ligne	    
    [F] theme.css          Thème du site
    [F] theme_invert.css   Thème du site avec couleurs inversées
    [F] theme.json         Données du site
    [F] user.json          Données des utilisateurs
    [F] .backup            Marqueur de la sauvegarde des fichiers si présent
  [R] file                 Répertoire d'upload du gestionnaire de fichiers
    [R] source             Ressources diverses
    [R] thumb              Miniatures des images
  [R] tmp                  Répertoire temporaire

[F] index.php              Fichier d'initialisation de DeltaCMS
[F] robots.txt             Filtrage des répertoires accessibles aux robots des moteurs de recherche
[F] sitemap.xml            Plan du site

Les fichiers .htaccess contribuent à la sécurité en filtrant l'accès aux répertoires sensibles.

```
