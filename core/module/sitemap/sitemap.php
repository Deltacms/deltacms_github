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

class sitemap extends common
{
    public static $actions = [
        'index' => self::GROUP_VISITOR
    ];

	public static $siteMap = '';

    /**
     * Plan du site
     */
    public function index() {
		// Lexique
		include('./core/module/sitemap/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_sitemap.php');

        $items = '<ul>';
		
		
		// Groupe du client connecté (1, 2, 3, 4) ou non connecté (0)
		$groupUser = $this->getUser('group') === false ? 0 : $this->getUser('group');
        foreach ($this->getHierarchy(null, true, null) as $parentId => $childIds) {
			// Cas où les pages enfants enfant sont toutes desactivées dans le menu
			$totalChild = 0;
			$disableChild = 0;
			foreach($childIds as $childKey) {
				$totalChild += 1;
				if( $this->getData(['page', $childKey, 'disable']) === true ) $disableChild +=1;
			}
			// Ne pas afficher les pages masquées dans le menu latéral ou les pages désactivées sans sous-page active pour les clients < éditeur
			if ($this->getData(['page',$parentId,'hideMenuSide']) === true || ( $this->getData(['page',$parentId,'disable']) && (empty($childIds) ||  $disableChild === $totalChild) && $groupUser < 2 ) ) {
				continue;
			}
            $items .= ' <li>';
                if ($this->getData(['page', $parentId, 'disable']) === false  && $this->getUser('group') >= $this->getData(['page', $parentId, 'group'])) {
                    $pageUrl = ($parentId !== $this->getData(['locale', 'homePageId'])) ? helper::baseUrl() . $parentId : helper::baseUrl(false);
                    $items .= '<a href="' . $pageUrl .'">'  .$this->getData(['page', $parentId, 'title']) . '</a>';
                } else {
                    // page désactivée
                    $items .= $this->getData(['page', $parentId, 'title']);
                }
                // ou articles d'un blog
                
                if ($this->getData(['page', $parentId, 'moduleId']) === 'blog'  &&
                !empty($this->getData(['module',$parentId, 'posts' ]))) {
                    $items .= '<ul>';									
                    // Ids des articles par ordre de publication
                    $articleIdsPublishedOns = helper::arrayCollumn($this->getData(['module', $parentId,'posts']), 'publishedOn', 'SORT_DESC');
                    $articleIdsStates = helper::arrayCollumn($this->getData(['module', $parentId, 'posts']), 'state', 'SORT_DESC');
                    $articleIds = [];
                    foreach ($articleIdsPublishedOns as $articleId => $articlePublishedOn) {
                        if ($articlePublishedOn <= time() and $articleIdsStates[$articleId]) {
                            $articleIds[] = $articleId;
                        }
                    }
                    foreach ($articleIds as $articleId => $article) {
                        if ($this->getData(['module',$parentId,'posts',$article,'state']) === true) {
                            $items .= ' <li>';
                            $items .= '<a href="' . helper::baseUrl() . $parentId. '/' . $article . '">' . $this->getData(['module',$parentId,'posts',$article,'title']) . '</a>';
                            $items .= '</li>';
                        }
                    }
                    $items .= '</ul>';
                } 
                
                foreach ($childIds as $childId) {
					// Passer les sous-pages masquées ou désactivées si client < éditeur
					if ($this->getData(['page',$childId,'hideMenuSide']) === true || ( $this->getData(['page',$childId,'disable']) === true && $groupUser < 2)) {
						continue;
					}
					$items .= '<ul>';
					// Sous-page
					$items .= ' <li>';              
					if ($this->getData(['page', $childId, 'disable']) === false && $this->getUser('group') >= $this->getData(['page', $parentId, 'group'])) {
						$pageUrl = ($childId !== $this->getData(['locale', 'homePageId'])) ? helper::baseUrl() . $childId : helper::baseUrl(false) ;
						$items .= '<a href="' . $pageUrl . '">' . $this->getData(['page', $childId, 'title']) . '</a>';
					} else {
						// page désactivée
						$items .=  $this->getData(['page', $childId, 'title']);
					}
					$items .= '</li>';

                    // Articles d'une sous-page blog                
                    if ($this->getData(['page', $childId, 'moduleId']) === 'blog'  &&
                                !empty($this->getData(['module', $childId, 'posts' ]))) {
                        $items .= '<ul>';
                        // Ids des articles par ordre de publication
                        $articleIdsPublishedOns = helper::arrayCollumn($this->getData(['module', $childId,'posts']), 'publishedOn', 'SORT_DESC');
                        $articleIdsStates = helper::arrayCollumn($this->getData(['module', $childId, 'posts']), 'state', 'SORT_DESC');
                        $articleIds = [];
                        foreach ($articleIdsPublishedOns as $articleId => $articlePublishedOn) {
                            if ($articlePublishedOn <= time() and $articleIdsStates[$articleId]) {
                                $articleIds[] = $articleId;
                            }
                        }
                        foreach ($articleIds as $articleId => $article) {
                            if ($this->getData(['module',$childId,'posts',$article,'state']) === true) {
                                $items .= ' <li>';
                                $items .=  '<a href="' . helper::baseUrl() . $childId . '/' . $article . '">' . $this->getData(['module',$childId,'posts',$article,'title']) . '</a>';
                                $items .= '</li>';
                            }
                        }
                        $items .= '</ul>';
                    }
                    $items .= '</ul>';
                }
            $items .= '</li>';
        }
        // Fin du grand bloc
        $items .= '</ul>';    
		self::$siteMap = $items;

        // Valeurs en sortie
        $this->addOutput([
            'title' => $text['core_sitemap']['index'][0],
            'view' => 'index'
        ]);
    }
}
