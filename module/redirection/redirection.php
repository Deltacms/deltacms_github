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

class redirection extends common {

	const VERSION = '2.3';
	const REALNAME = 'Redirection';
	const DELETE = true;
	const UPDATE = '0.0';
	const DATADIRECTORY = ''; // Contenu localisé inclus par défaut (page.json et module.json)

	public static $actions = [
		'config' => self::GROUP_EDITOR,
		'index' => self::GROUP_VISITOR
	];


	/**
	 * Configuration
	 */
	public function config() {
		// Lexique
		include('./module/redirection/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_redirection.php');

		// Soumission du formulaire
		if($this->isPost()) {
			$this->setData(['module', $this->getUrl(0), 'url', $this->getInput('redirectionConfigUrl', helper::FILTER_URL, true)]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(),
				'notification' => $text['redirection']['config'][0],
				'state' => true
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => $text['redirection']['config'][1],
			'view' => 'config'
		]);
	}

	/**
	 * Accueil
	 */
	public function index() {
		// Message si l'utilisateur peut éditer la page
		if(
			$this->getUser('password') === $this->getInput('DELTA_USER_PASSWORD')
			AND $this->getUser('group') >= self::GROUP_EDITOR
			AND $this->getUrl(1) !== 'force'
		) {
			// Valeurs en sortie
			$this->addOutput([
				'display' => self::DISPLAY_LAYOUT_BLANK,
				'title' => '',
				'view' => 'index'
			]);
		}
		// Sinon redirection
		else {
			// Incrémente le compteur de clics
			$this->setData(['module', $this->getUrl(0), 'count', helper::filter($this->getData(['module', $this->getUrl(0), 'count']) + 1, helper::FILTER_INT)]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => $this->getData(['module', $this->getUrl(0), 'url']),
				'state' => true
			]);
		}
	}
}
