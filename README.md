
# DeltaCMS 4.5.01

DeltaCMS est un CMS sans base de données (flat-file) qui permet de créer et gérer facilement un site web sans aucune connaissance en programmation.
L'administration du site est trilingue espagnol (castillan), anglais ou français, le site peut être rédigé dans une langue quelconque.
2 modes de traduction sont proposés : traduction rédigée, assistée (conseillée) ou à défaut traduction automatique par script.

DeltaCMS is a database-less (flat-file) CMS that allows you to easily create and manage a website without any programming knowledge.
The administration of the site is trilingual Spanish, English or French, the site can be written in any language.
2 translation modes are available: written and assisted translation (recommended) or automatic translation by script.

DeltaCMS es un CMS sin base de datos (flat-file) que permite crear y administrar fácilmente un sitio web sin ningún conocimiento de programación.
La administración del sitio es trilingüe español (castellano), inglés o francés, el sitio puede ser escrito en cualquier idioma.
Hay 2 modos de traducción disponibles: traducción escrita, asistida (recomendada) o traducción automática por script.

[Site](http://deltacms.fr/)

DeltaCMS a été créé à partir de ZwiiCMS 11.2.00.24

[ZwiiCMS](https://forge.chapril.org/fredtempez/ZwiiCMS)

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
  [R] include              Update des données 
  [R] layout               Mise en page
  [R] module               Modules du cœur
  [R] vendor               Librairies extérieures
  [F] core.js.php          Cœur javascript
  [F] core.php             Cœur PHP

[R] module                 Modules de page
  [R] agenda	           Agenda
  [R] blog                 Blog
  [R] form                 Gestionnaire de formulaires
  [R] gallery              Galerie
  [R] news                 Nouvelles
  [R] redirection          Redirection
  [R] search               Recherche
  [R] slider	           Slider diaporama
  [R] statislite           Statistiques de fréquentation

[R] site                   Contenu du site
  [R] backup               Sauvegardes automatiques
  [R] data                 Répertoire des données
    [R] base                 Dossier localisé, un dossier par langue rédigée
      [F] page.json        Données des pages
      [F] module.json      Données des modules de pages
      [F] locale.json       Données du site propres à la langue
      [R] content          Dossier des contenus de page
        [F] accueil.html   Exemple contenu de la page d'accueil
    [R] *modules*          Un dossier par module, exemple [R]search [R]gallery [R]agenda, pour les données du module
    [F] admin.css          Thème des pages d'administration
    [F] admin.json         Données de thème des pages d'administration
    [F] blacklist.json     Journalisation des tentatives de connexion avec des comptes inconnus
    [F] config.json        Configuration du site
    [F] core.json          Configuration du noyau
    [F] custom.css         Feuille de style de la personnalisation avancée
    [F] fonts.json         Polices du site
    [F] journal.log        Journalisation des actions
    [F] theme.css          Thème du site
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

Le fichiers .htaccess contribuent à la sécurité en filtrant l'accès aux répertoires sensibles.

```
