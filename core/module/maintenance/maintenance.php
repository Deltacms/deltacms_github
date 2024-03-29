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
 * @author Frédéric Tempez <frederic.tempez@outlook.com>
 * @copyright 2018-2021 © Frédéric Tempez
 */

class maintenance extends common {

	public static $actions = [
		'index' => self::GROUP_VISITOR
	];

	/**
	 * Maintenance
	 */
	public function index() {
		// Lexique
		include('./core/module/maintenance/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_maintenance.php');

		// Redirection vers l'accueil après rafraîchissement et que la maintenance est terminée.
		if($this->getData(['config', 'maintenance']) == False){
			header('Location:' . helper::baseUrl());
			exit();
		}
		// Page perso définie et existante
		if ($this->getData(['locale','page302']) !== 'none'
			AND $this->getData(['page',$this->getData(['locale','page302'])]) ) {
				$this->addOutput([
					'display' => self::DISPLAY_LAYOUT_LIGHT,
					'title' => $this->getData(['page',$this->getData(['locale','page302']),'hideTitle'])
								? ''
								: $this->getData(['page',$this->getData(['locale','page302']),'title']),
					//'content' => $this->getdata(['page',$this->getData(['locale','page302']),'content']),
					'content' => $this->getPage($this->getData(['locale','page302']), self::$i18n),
					'view' => 'index'
				]);
		} else {
			// Valeurs en sortie
			$this->addOutput([
				'display' => self::DISPLAY_LAYOUT_LIGHT,
				'title' => $text['core_maintenance']['index'][0],
				'view' => 'index'
			]);
		}
	}

}