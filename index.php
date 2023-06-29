<?php

/**
 * This file is part of DeltaCMS.
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 * @author Sylvain Lelièvre <lelievresylvain@free.fr>
 * @copyright Copyright (C) 2021, Sylvain Lelièvre
 * @license GNU General Public License, version 3
 * @link https://deltacms.fr/
 *
 * Delta was created from version 11.2.00.24 of ZwiiCMS
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2018, Rémi Jean
 * @author Frédéric Tempez <frederic.tempez@outlook.com>
 * @copyright Copyright (C) 2018-2021, Frédéric Tempez
 */

 /**
 * Initialisation de Delta
 */
ini_set('session.use_trans_sid', FALSE);
session_start();

/**
 * Vérification de la version de PHP
 */
if(version_compare(PHP_VERSION, '7.2.0', '<')) {
	exit('PHP 7.2+ required.');
}

/*
 *Localisation

 * Locales :
 * french : free.fr
 * fr_FR : XAMPP Macos
 * fr_FR.utf8 : la majorité
*/
date_default_timezone_set('Europe/Paris');
setlocale (LC_ALL,'french','fr_Fr','fr_FR.utf8');

/**
 * Chargement des classes
 */
require 'core/class/autoload.php';
autoload::autoloader();

/**
 * Chargement du coeur
 */
require 'core/core.php';
$core = new core;
spl_autoload_register('core::autoload');
echo $core->router();
