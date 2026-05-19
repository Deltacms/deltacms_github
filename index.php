<?php
/**
 * This file is part of DeltaCMS.
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 * @author Sylvain Lelièvre
 * @copyright 2021 © Sylvain Lelièvre
 * @author Lionel Croquefer
 * @copyright 2022 © Lionel Croquefer
 * @license GNU General Public License, version 3
 * @link https://deltacms.fr/
 * @contact https://deltacms.fr/contact
 *
 * Delta was created from version 11.2.00.24 of ZwiiCMS
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright 2008-2018 © Rémi Jean
 * @copyright 2018-2021 © Zwiicms team
 */

 /**
 * Initialisation de Deltacms
 */
ini_set('session.use_trans_sid', '0');
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')){
    ini_set('session.cookie_secure', '1');
}
ini_set('session.cookie_samesite', 'Strict');
session_start();

/**
 * Vérification de la version de PHP
 */
if(version_compare(PHP_VERSION, '7.2.0', '<')) {
	exit('PHP 7.2+ required.');
}

/**
 * Encodage utf8
 */
 header('Content-Type: text/html; charset=utf-8');
 mb_internal_encoding('UTF-8');
 
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
