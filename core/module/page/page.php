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

class page extends common {

	public static $actions = [
		'add' => self::GROUP_MODERATOR,
		'delete' => self::GROUP_MODERATOR,
		'edit' => self::GROUP_EDITOR,
		'duplicate' => self::GROUP_MODERATOR,
		'comment' => self::GROUP_MODERATOR,
		'commentDelete' => self::GROUP_MODERATOR,
		'commentAllDelete' => self::GROUP_MODERATOR,
		'commentExport2csv' => self::GROUP_MODERATOR
	];

	public static $moduleIds = [];
	public static $pagesBarId = [];
	public static $pagesNoParentId = [];
	public static $data = [];
	public static $pages = [];

	/**
	 * Duplication
	 */
	public function duplicate() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < page::$actions['duplicate'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/page/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_page.php');
			// Adresse sans le token
			$url = explode('&',$this->getUrl(2));
			// La page n'existe pas
			if($this->getData(['page', $url[0]]) === null) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			} // Jeton incorrect
			elseif(!isset($_GET['csrf'])) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'page/edit/' . $url[0],
					'notification' => $text['core_page']['duplicate'][0]
				]);
			}
			elseif ($_GET['csrf'] !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'page/edit/' . $url[0],
					'notification' => $text['core_page']['duplicate'][1]
				]);
			} else {
				// Duplication de la page
				$pageTitle = $this->getData(['page',$url[0],'title']);
				$pageId = helper::increment(helper::filter($pageTitle, helper::FILTER_ID), $this->getData(['page']));
				$pageId = helper::increment($pageId, self::$coreModuleIds);
				$pageId = helper::increment($pageId, self::$moduleIds);
				$data = $this->getData([
					'page',
					$url[0]
				]);
				// Ecriture
				$this->setData (['page',$pageId,$data]);
				$notification = $text['core_page']['duplicate'][2];
				// Duplication du module présent
				if ($this->getData(['page',$url[0],'moduleId'])) {
					$data = $this->getData([
						'module',
						$url[0]
					]);
					// Ecriture
					$this->setData (['module',$pageId,$data]);
					$notification = $text['core_page']['duplicate'][3];
				}
				// Duplication des données de page
				if( is_file(self::DATA_DIR . self::$i18n . '/data_module/' . $url[0] . '.json'))
				copy( self::DATA_DIR . self::$i18n . '/data_module/' . $url[0] . '.json', self::DATA_DIR . self::$i18n . '/data_module/' . $pageId . '.json');
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'page/edit/' . $pageId,
					'notification' => $notification,
					'state' => true
				]);
			}
		}
	}


	/**
	 * Création
	 */
	public function add() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < page::$actions['add'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/page/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_page.php');
			$pageTitle = $text['core_page']['add'][0];
			$pageId = helper::increment(helper::filter($pageTitle, helper::FILTER_ID), $this->getData(['page']));
			$this->setData([
				'page',
				$pageId,
				[
					'typeMenu' => 'text',
					'iconUrl' => '',
					'disable' => false,
					'content' =>  $pageId . '.html',
					'hideTitle' => false,
					'breadCrumb' => false,
					'metaDescription' => '',
					'metaTitle' => '',
					'moduleId' => '',
					'parentPageId' => '',
					'modulePosition' => 'bottom',
					'position' => 100,
					'group' => self::GROUP_VISITOR,
					'targetBlank' => false,
					'title' => $pageTitle,
					'shortTitle' => $pageTitle,
					'block' => '12',
					'barLeft' => '',
					'barRight' => '',
					'displayMenu' => '0',
					'hideMenuSide' => false,
					'hideMenuHead' => false,
					'hideMenuChildren' => false
				]
			]);
			// Creation du contenu de la page
			if (!is_dir(self::DATA_DIR . self::$i18n . '/content')) {
				mkdir(self::DATA_DIR . self::$i18n . '/content', 0755);
			}
			$this->setPage($pageId, '<p>'.$text['core_page']['add'][1].'</p>', self::$i18n);
			// Met à jour le site map
			// $this->createSitemap('all');
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $pageId,
				'notification' => $text['core_page']['add'][2],
				'state' => true
			]);
		}
	}

	/**
	 * Suppression
	 */
	public function delete() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < page::$actions['delete'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/page/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_page.php');
			// $url prend l'adresse sans le token
			$url = explode('&',$this->getUrl(2));
			// La page n'existe pas
			if($this->getData(['page', $url[0]]) === null) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			}		// Jeton incorrect
			elseif(!isset($_GET['csrf'])) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'page/edit/' . $url[0],
					'notification' => $text['core_page']['delete'][0]
				]);
			}
			elseif ($_GET['csrf'] !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'page/edit/' . $url[0],
					'notification' => $text['core_page']['delete'][1]
				]);
			}
			// Impossible de supprimer la page d'accueil
			elseif($url[0] === $this->getData(['locale', 'homePageId'])) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . 'config',
					'notification' => $text['core_page']['delete'][2]
				]);
			}
			// Impossible de supprimer la page de recherche affectée
			elseif($url[0] === $this->getData(['locale', 'searchPageId'])) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . 'config',
					'notification' => $text['core_page']['delete'][2]
				]);
			}
			// Impossible de supprimer la page des mentions légales affectée
			elseif($url[0] === $this->getData(['locale', 'legalPageId'])) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'config',
					'notification' => $text['core_page']['delete'][2]
				]);
			}
			// Impossible de supprimer la page des mentions légales affectée
			elseif($url[0] === $this->getData(['locale', 'page404'])) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'config',
					'notification' => $text['core_page']['delete'][2]
				]);
			}
			// Impossible de supprimer la page des mentions légales affectée
			elseif($url[0] === $this->getData(['locale', 'page403'])) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'config',
					'notification' => $text['core_page']['delete'][2]
				]);
			}
			// Impossible de supprimer la page des mentions légales affectée
			elseif($url[0] === $this->getData(['locale', 'page302'])) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'config',
					'notification' => $text['core_page']['delete'][2]
				]);
			}
			// Impossible de supprimer une page si c'est la seule
			elseif( count($this->getData(['page'])) === 1 ) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'config',
					'notification' => $text['core_page']['delete'][1]
				]);
			}
			// Jeton incorrect
			elseif(!isset($_GET['csrf'])) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'page/edit/' . $url[0],
					'notification' => $text['core_page']['delete'][0]
				]);
			}
			elseif ($_GET['csrf'] !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'page/edit/' . $url[0],
					'notification' => $text['core_page']['delete'][1]
				]);
			}
			// Impossible de supprimer une page contenant des enfants
			elseif($this->getHierarchy($url[0],null)) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'page/edit/' . $url[0],
					'notification' => $text['core_page']['delete'][3]
				]);
			}
			// Suppression
			else {

				// Effacer le dossier du module
				$moduleId = $this->getData(['page',$url[0],'moduleId']);
				$modulesData = helper::getModules();
				if (is_dir($modulesData[$moduleId]['dataDirectory']. $url[0])) {
					$this->removeDir( $modulesData[$moduleId]['dataDirectory']. $url[0] );
				}
				// Effacer la page
				$this->deleteData(['page', $url[0]]);
				if (file_exists(self::DATA_DIR . self::$i18n . '/content/' . $url[0] . '.html')) {
					unlink(self::DATA_DIR . self::$i18n . '/content/' . $url[0] . '.html');
				}
				// Effacer le fichier des données de page
				if (file_exists(self::DATA_DIR . self::$i18n . '/data_module/' . $url[0] . '.json')) {
					unlink(self::DATA_DIR . self::$i18n . '/data_module/' . $url[0] . '.json');
				}
				
				$this->deleteData(['module', $url[0]]);
				// Met à jour le site map
				// $this->createSitemap('all');
				// Met à jour 'config', 'statislite', 'enable' si aucume page utilise le module Statislite
				$inPages = helper::arrayCollumn($this->getData(['page']),'moduleId', 'SORT_DESC');
				$statislite = 'off';
				foreach($inPages as $key=>$value){
				  if( $value === 'statislite') $statislite = 'on';
				}
				if( $statislite === 'off') $this->setData(['config', 'statislite', 'enable', false ]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl(false),
					'notification' => $text['core_page']['delete'][4],
					'state' => true
				]);
			}
		}
	}

	/**
	 * Gestion des commentaires
	 */
	public function comment() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < page::$actions['comment'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Préparation des commentaires avec pagination
			$data = $this->getData(['comment', $this->getUrl(2), 'data']);
			if($data) {
				// Pagination
				$pagination = helper::pagination($data, $this->getUrl(), $this->getData(['config', 'social', 'comment', 'nbItemPage' ]));
				// Liste des pages
				self::$pages = $pagination['pages'];
				// Inverse l'ordre du tableau
				$dataIds = array_reverse(array_keys($data));
				$data = array_reverse($data);
				// Données en fonction de la pagination
				for($i = $pagination['first']; $i < $pagination['last']; $i++) {
					$content = '';
					foreach($data[$i] as $input => $value) {
						$value = str_replace('Д','',$value);
						$content .= $input . ' : ' . $value . '<br>';
					}
					self::$data[] = [
						$content,
						template::button('formDataDelete' . $dataIds[$i], [
							'class' => 'formDataDelete buttonRed',
							'href' => helper::baseUrl() . 'page/commentDelete/' . $this->getUrl(2) .'/'. $dataIds[$i]  . '/' . $_SESSION['csrf'],
							'value' => template::ico('cancel')
						])
					];
				}
			}			
			$this->addOutput([
				'title' => $this->getData(['page', $this->getUrl(2), 'title']),
				'view' => 'comment'
			]);		
		}
		
	}
	
	/**
	* commentDelete
	*/
	public function commentDelete() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < page::$actions['commentDelete'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/page/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_page.php');
			// Jeton incorrect
			if ($this->getUrl(4) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'page/edit/' . $this->getUrl(2),
					'notification' => $text['core_page']['commentDelete'][2]
				]);
			} else {
				// La donnée n'existe pas
				if( $this->getData(['comment', $this->getUrl(2), 'data', $this->getUrl(3)]) === null) {
					// Valeurs en sortie
					$this->addOutput([
						'access' => false,
						'redirect' => helper::baseUrl() . 'page/comment/' . $this->getUrl(2)
					]);
				}
				// Suppression
				else {
					$this->deleteData(['comment', $this->getUrl(2), 'data', $this->getUrl(3)]);
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl() . 'page/comment/' . $this->getUrl(2),
						'notification' => $text['core_page']['commentDelete'][1],
						'state' => true
					]);
				}
			}			
			
		}
	}
	
	/**
	* commentAllDelete
	*/
	public function commentAllDelete() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < page::$actions['commentAllDelete'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			include('./core/module/page/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_page.php');
			// Jeton incorrect
			if ($this->getUrl(3) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl()  . 'page/edit/' . $this->getUrl(2),
					'notification' => $text['core_page']['commentAllDelete'][1]
				]);
			} else {
				$data = $this->getData(['comment', $this->getUrl(2), 'data']);
				if (count($data) > 0 ) {
					// Suppression multiple
					foreach( $data as $key=>$value ){
						$this->deleteData(['comment', $this->getUrl(2), 'data', $key]);
					}
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl() . 'page/comment/'. $this->getUrl(2),
						'notification' => $text['core_page']['commentAllDelete'][2],
						'state' => true
					]);
				} else {
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl() . 'page/comment/'. $this->getUrl(2),
						'notification' => $text['core_page']['commentAllDelete'][3]
					]);
				}
			}			
			
		}
	}
	
	/**
	* commentExport2csv
	*/
	public function commentExport2csv() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < page::$actions['commentExport2csv'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/page/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_page.php');
			// Jeton incorrect
			if ($this->getUrl(3) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'page/edit/'. $this->getUrl(2),
					'notification' => '0'
				]);
			} else {
				$data = $this->getData(['comment', $this->getUrl(2), 'data']);
				foreach( $data as $key=>$value){
					$data[$key] = str_replace('Д ','',$value);
				}
				if ($data !== []) {
					$csvfilename = 'data-'.date('dmY').'-'.date('hm').'-'.rand(10,99).'.csv';
					if (!file_exists(self::FILE_DIR.'source/data')) {
						mkdir(self::FILE_DIR.'source/data', 0755);
					}
					$fp = fopen(self::FILE_DIR.'source/data/'.$csvfilename, 'w');
					fputcsv($fp, array_keys($data[1]), ';','"');
					foreach ($data as $fields) {
						fputcsv($fp, $fields, ';','"');
					}
					fclose($fp);
					// Valeurs en sortie
					$this->addOutput([
						'notification' => $text['core_page']['exportToCsv'][1].$csvfilename,
						'redirect' => helper::baseUrl() . 'page/comment/'. $this->getUrl(2),
						'state' => true
					]);
				} else {
					$this->addOutput([
						'notification' => $text['core_page']['exportToCsv'][2],
						'redirect' => helper::baseUrl() . 'page/edit/'. $this->getUrl(2)
					]);
				}
			}			
			
		}
	}

	/**
	 * Édition
	 */
	public function edit() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < page::$actions['edit'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {
			// Lexique
			include('./core/module/page/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_page.php');
			// La page n'existe pas
			if($this->getData(['page', $this->getUrl(2)]) === null) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			}
			// La page existe
			else {
				// Soumission du formulaire
				if($this->isPost()) {
					// Si le Title n'est pas vide, premier test pour positionner la notification du champ obligatoire
					if( $this->getInput('pageEditTitle', helper::FILTER_ID, true) !== null && $this->getInput('pageEditTitle') !== '' ){
						// Génére l'ID si le titre de la page a changé
						if ( $this->getInput('pageEditTitle') !== $this->getData(['page',$this->getUrl(2),'title']) ) {
							$pageId = $this->getInput('pageEditTitle', helper::FILTER_ID, true);
						} else {
							$pageId = $this->getUrl(2);
						}
						// un dossier existe du même nom (erreur en cas de redirection)
						if (file_exists($pageId)) {
							$pageId = uniqid($pageId);
						}
						// Si l'id a changée
						if ($pageId !== $this->getUrl(2)) {
							// Incrémente le nouvel id de la page
								$pageId = helper::increment($pageId, $this->getData(['page']));
								$pageId = helper::increment($pageId, self::$coreModuleIds);
								$pageId = helper::increment($pageId, self::$moduleIds);
							// Met à jour les enfants
							foreach($this->getHierarchy($this->getUrl(2),null) as $childrenPageId) {
								$this->setData(['page', $childrenPageId, 'parentPageId', $pageId]);
							}
							// Change l'id de page dans les données des modules
							if ($this->getData(['module', $this->getUrl(2)]) !== null ) {
								$this->setData(['module', $pageId, $this->getData(['module', $this->getUrl(2)])]);
								$this->deleteData(['module', $this->getUrl(2)]);
								// Renommer le dossier du module
								$moduleId = $this->getData(['page',$this->getUrl(2),'moduleId']);
								$modulesData = helper::getModules();
								if (is_dir($modulesData[$moduleId]['dataDirectory']. $this->getUrl(2))) {
									// Placer la feuille de style dans un dossier au nom de la nouvelle instance
									mkdir( $modulesData[$moduleId]['dataDirectory']. $pageId, 0755 );
									copy( $modulesData[$moduleId]['dataDirectory']. $this->getUrl(2), $modulesData[$moduleId]['dataDirectory']. $pageId);
									$this->removeDir($modulesData[$moduleId]['dataDirectory']. $this->getUrl(2));
									// Mettre à jour le nom de la feuille de style
									$this->setData(['module',$pageId,'theme','style', $modulesData[$moduleId]['dataDirectory']. $pageId]);
								}
							}
							// Change le nom du fichier des données de page dans /data_module/
							if (file_exists(self::DATA_DIR . self::$i18n . '/data_module/' . $this->getUrl(2) . '.json')) 
								rename(self::DATA_DIR . self::$i18n . '/data_module/' . $this->getUrl(2) . '.json', self::DATA_DIR . self::$i18n . '/data_module/' . $pageId . '.json');
							// Si la page correspond à la page d'accueil, change l'id dans la configuration du site
							if($this->getData(['locale', 'homePageId']) === $this->getUrl(2)) {
								$this->setData(['locale', 'homePageId', $pageId]);
							}
						}
						// Supprime les données du module en cas de changement de module
						if($this->getInput('pageEditModuleId') !== $this->getData(['page', $this->getUrl(2), 'moduleId'])) {
							$this->deleteData(['module', $pageId]);
						}
						// Supprime l'ancienne page si l'id a changée
						if($pageId !== $this->getUrl(2)) {
							$this->deleteData(['page', $this->getUrl(2)]);
							unlink (self::DATA_DIR . self::$i18n . '/content/' . $this->getUrl(2) . '.html');
						}
						// Traitement des pages spéciales affectées dans la config :
						if ($this->getUrl(2) === $this->getData(['locale', 'legalPageId']) ) {
							$this->setData(['locale','legalPageId', $pageId]);
						}
						if ($this->getUrl(2) === $this->getData(['locale', 'searchPageId']) ) {
							$this->setData(['locale','searchPageId', $pageId]);
						}
						if ($this->getUrl(2) === $this->getData(['locale', 'page404']) ) {
							$this->setData(['locale','page404', $pageId]);
						}
						if ($this->getUrl(2) === $this->getData(['locale', 'page403']) ) {
							$this->setData(['locale','page403', $pageId]);
						}
						if ($this->getUrl(2) === $this->getData(['locale', 'page302']) ) {
							$this->setData(['locale','page302', $pageId]);
						}
						// Si la page est une page enfant, actualise les positions des autres enfants du parent, sinon actualise les pages sans parents
						$lastPosition = 1;
						$hierarchy = $this->getInput('pageEditParentPageId') ? $this->getHierarchy($this->getInput('pageEditParentPageId')) : array_keys($this->getHierarchy());
						$position = $this->getInput('pageEditPosition', helper::FILTER_INT);
						foreach($hierarchy as $hierarchyPageId) {
							// Ignore la page en cours de modification
							if($hierarchyPageId === $this->getUrl(2)) {
								continue;
							}
							// Incrémente de +1 pour laisser la place à la position de la page en cours de modification
							if($lastPosition === $position) {
								$lastPosition++;
							}
							// Change la position
							$this->setData(['page', $hierarchyPageId, 'position', $lastPosition]);
							// Incrémente pour la prochaine position
							$lastPosition++;
						}
						if ($this->getinput('pageEditBlock') !== 'bar') {
							$barLeft = $this->getinput('pageEditBarLeft');
							$barRight = $this->getinput('pageEditBarRight');
							$hideTitle = $this->getInput('pageEditHideTitle', helper::FILTER_BOOLEAN);

						} else {
							// Une barre ne peut pas avoir de barres
							$barLeft = "";
							$barRight = "";
							// Une barre est masquée
							$position = 0;
							$hideTitle = true;
						}
						// Modifie la page ou en crée une nouvelle si l'id a changé
						$this->setData([
							'page',
							$pageId,
							[
								'typeMenu' => $this->getinput('pageTypeMenu'),
								'iconUrl' => $this->getinput('pageIconUrl'),
								'disable'=> $this->getinput('pageEditDisable', helper::FILTER_BOOLEAN),
								'content' => $pageId . '.html',
								'hideTitle' => $hideTitle,
								'breadCrumb' => $this->getInput('pageEditbreadCrumb', helper::FILTER_BOOLEAN),
								'metaDescription' => $this->getInput('pageEditMetaDescription', helper::FILTER_STRING_LONG),
								'metaTitle' => $this->getInput('pageEditMetaTitle'),
								'moduleId' => $this->getInput('pageEditModuleId'),
								'modulePosition' => $this->getInput('configModulePosition'),
								'parentPageId' => $this->getInput('pageEditParentPageId'),
								'position' => $position,
								'group' => $this->getinput('pageEditBlock') !== 'bar' ? $this->getInput('pageEditGroup', helper::FILTER_INT) : 0,
								'groupEdit' => $this->getInput('pageEditGroupEdit', helper::FILTER_INT),
								'targetBlank' => $this->getInput('pageEditTargetBlank', helper::FILTER_BOOLEAN),
								'title' => $this->getInput('pageEditTitle', helper::FILTER_STRING_SHORT),
								'shortTitle' => $this->getInput('pageEditShortTitle', helper::FILTER_STRING_SHORT, true),
								'block' => $this->getinput('pageEditBlock'),
								'barLeft' => $barLeft,
								'barRight' => $barRight,
								'displayMenu' => $this->getinput('pageEditDisplayMenu'),
								'hideMenuSide' => $this->getinput('pageEditHideMenuSide', helper::FILTER_BOOLEAN),
								'hideMenuHead' => $this->getinput('pageEditHideMenuHead', helper::FILTER_BOOLEAN),
								'hideMenuChildren' => $this->getinput('pageEditHideMenuChildren', helper::FILTER_BOOLEAN),
								'commentEnable' => $this->getinput('pageEditBlock') !== 'bar' ? $this->getinput('pageEditCommentEnable', helper::FILTER_BOOLEAN) : false
							]
						]);
						// Creation du contenu de la page
						if (!is_dir(self::DATA_DIR . self::$i18n . '/content')) {
							mkdir(self::DATA_DIR . self::$i18n . '/content', 0755);
						}
						$content = empty($this->getInput('pageEditContent', null)) ? '<p></p>' : str_replace('<p></p>', '<p>&nbsp;</p>', $this->getInput('pageEditContent', null));
						//file_put_contents( self::DATA_DIR . self::$i18n . '/content/' . $pageId . '.html' , $content );
						$this->setPage($pageId , $content, self::$i18n);
						// Barre renommée : changement le nom de la barre dans les pages mères
						if ($this->getinput('pageEditBlock') === 'bar') {
							foreach ($this->getHierarchy() as $eachPageId=>$parentId) {
								if ($this->getData(['page',$eachPageId,'barRight']) === $this->getUrl(2)) {
									$this->setData(['page',$eachPageId,'barRight',$pageId]);
								}
								if ($this->getData(['page',$eachPageId,'barLeft']) === $this->getUrl(2)) {
									$this->setData(['page',$eachPageId,'barLeft',$pageId]);
								}
								foreach ($parentId as $childId) {
									if ($this->getData(['page',$childId,'barRight']) === $this->getUrl(2)) {
										$this->setData(['page',$childId,'barRight',$pageId]);
									}
									if ($this->getData(['page',$childId,'barLeft']) === $this->getUrl(2)) {
										$this->setData(['page',$childId,'barLeft',$pageId]);
									}
								}
							}
						}
						// Met à jour le site map
						// $this->createSitemap('all');
						// Redirection vers la configuration
						if($this->getInput('pageEditModuleRedirect', helper::FILTER_BOOLEAN)) {
							// Valeurs en sortie
							$this->addOutput([
								'redirect' => helper::baseUrl() . $pageId . '/config',
								'state' => true
							]);
						}
						// Redirection vers la page
						else {
							// Valeurs en sortie
							$this->addOutput([
								'redirect' => helper::baseUrl() . $pageId,
								'notification' => $text['core_page']['edit'][0],
								'state' => true
							]);
						}
					}
				}
				self::$moduleIds = array_merge( ['' => $text['core_page']['edit'][1]] , helper::arrayCollumn(helper::getModules(),'realName','SORT_ASC'));			// Pages sans parent
				self::$pagesNoParentId = $pagesNoParentId;
				foreach($this->getHierarchy() as $parentPageId => $childrenPageIds) {
					if($parentPageId !== $this->getUrl(2)) {
						self::$pagesNoParentId[$parentPageId] = $this->getData(['page', $parentPageId, 'title']);
						//self::$pagesNoParentId_en[$parentPageId] = $this->getData(['page', $parentPageId, 'title']);
					}
				}
				// Pages barre latérales
				self::$pagesBarId = $pagesBarId;
				foreach($this->getHierarchy(null,false,true) as $parentPageId => $childrenPageIds) {
						if($parentPageId !== $this->getUrl(2) &&
							$this->getData(['page', $parentPageId, 'block']) === 'bar') {
							self::$pagesBarId[$parentPageId] = $this->getData(['page', $parentPageId, 'title']);
							//self::$pagesBarId_en[$parentPageId] = $this->getData(['page', $parentPageId, 'title']);
						}
				}
				// Mise à jour de la liste des pages pour TinyMCE
				$this->pages2Json();
				$tinymce = 'tinymce';
				if( $this->getData(['page', $this->getUrl(2), 'moduleId']) === 'snipcart') $tinymce = 'tinymceV4';
				// Valeurs en sortie
				$this->addOutput([
					'title' => $this->getData(['page', $this->getUrl(2), 'title']),
					'vendor' => [$tinymce],
					'view' => 'edit'
				]);
			}
		}
	}
}
