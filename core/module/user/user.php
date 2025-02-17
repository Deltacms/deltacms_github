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

class user extends common {

	public static $actions = [
		'add' => self::GROUP_ADMIN,
		'delete' => self::GROUP_ADMIN,
		'import' => self::GROUP_ADMIN,
		'export' => self::GROUP_ADMIN,
		'index' => self::GROUP_ADMIN,
		'edit' => self::GROUP_MEMBER,
		'logout' => self::GROUP_MEMBER,
		'forgot' => self::GROUP_VISITOR,
		'login' => self::GROUP_VISITOR,
		'reset' => self::GROUP_VISITOR
	];

	public static $users = [];
	public static $userId = '';
	public static $userLongtime = false;
	public static $separators = [
		';' => ';',
		',' => ',',
		':' => ':'
	];

	// Variable pour construire la liste des pages du site
	public static $pagesList = [];
	public static $orphansList = [];

	/**
	 * Ajout
	 */
	public function add() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < user::$actions['add'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {	
			// Lexique
			include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');
			// Soumission du formulaire
			if($this->isPost()) {
				$check=true;
				// L'identifiant d'utilisateur est indisponible
				$userId = $this->getInput('userAddId', helper::FILTER_ID, true);
				if($this->getData(['user', $userId])) {
					self::$inputNotices['userAddId'] = $text['core_user']['add'][0];
					$check=false;
				}
				// Double vérification pour le mot de passe
				if($this->getInput('userAddPassword', helper::FILTER_STRING_SHORT, true) !== $this->getInput('userAddConfirmPassword', helper::FILTER_STRING_SHORT, true)) {
					self::$inputNotices['userAddConfirmPassword'] = $text['core_user']['add'][1];
					$check = false;
				}
				// Crée l'utilisateur
				$userFirstname = $this->getInput('userAddFirstname', helper::FILTER_STRING_SHORT, true);
				$userLastname = $this->getInput('userAddLastname', helper::FILTER_STRING_SHORT, true);
				$userMail = $this->getInput('userAddMail', helper::FILTER_MAIL, true);

				// Stockage des données
				$this->setData([
					'user',
					$userId,
					[
						'firstname' => $userFirstname,
						'forgot' => 0,
						'group' => $this->getInput('userAddGroup', helper::FILTER_INT, true),
						'lastname' => $userLastname,
						'pseudo' => $this->getInput('userAddPseudo', helper::FILTER_STRING_SHORT, true),
						'signature' => $this->getInput('userAddSignature', helper::FILTER_INT, true),
						'mail' => $userMail,
						'password' => $this->getInput('userAddPassword', helper::FILTER_PASSWORD, true),
						"connectFail" => null,
						"connectTimeout" => null,
						"accessUrl" => null,
						"accessTimer" => null,
						"accessCsrf" => null,
						"files" => $this->getInput('userAddFiles', helper::FILTER_BOOLEAN),
						"redirectPageId" => $this->getInput('userRedirectPageId', helper::FILTER_STRING_SHORT)
					]
				]);
				// Création du dossier site/file/source/membersDirectory/id_membre_particulier
				if( $check === true && $this->getData(['user', $userId, 'group']) === 1 ){
					if( !is_dir('site/file/source/membersDirectory')) mkdir('site/file/source/membersDirectory',0705);
					if( !is_dir('site/file/source/membersDirectory/'.$userId)) mkdir('site/file/source/membersDirectory/'.$userId,0705);
				}				
				// Envoie le mail
				$sent = true;
				if($this->getInput('userAddSendMail', helper::FILTER_BOOLEAN) && $check === true) {
					$sent = $this->sendMail(
						$userMail,
						$text['core_user']['add'][2] . $this->getData(['locale', 'title']),
						$text['core_user']['add'][3].'<strong>' . $userFirstname . ' ' . $userLastname . '</strong>,<br><br>' .
						$text['core_user']['add'][4] . $this->getData(['locale', 'title']) . $text['core_user']['add'][5].'<br><br>' .
						'<strong>'.$text['core_user']['add'][6].'</strong> ' . $this->getInput('userAddId') . '<br>' .
						'<small>'.$text['core_user']['add'][7].'</small>',
						null
					);
				}
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'user',
					'notification' => $sent === true ? $text['core_user']['add'][8] : $sent,
					'state' => $sent === true ? true : null
				]);
			}
			// Générer la liste des pages disponibles
			$redirectPage = array( 'noRedirect'=> array( 'title'=>$text['core_user']['add'][10]));
			self::$pagesList = $this->getData(['page']);
			foreach(self::$pagesList as $page => $pageId) {
				if ($this->getData(['page',$page,'block']) === 'bar' ||
					$this->getData(['page',$page,'disable']) === true ||
					$this->getData(['page',$page,'title']) === null ) {
					unset(self::$pagesList[$page]);
				}
			}
			self::$pagesList = array_merge( $redirectPage, self::$pagesList);
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_user']['add'][9],
				'view' => 'add'
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
		if( $group < user::$actions['delete'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {	
			// Lexique
			include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');
			// Accès refusé
			if(
				// L'utilisateur n'existe pas
				$this->getData(['user', $this->getUrl(2)]) === null
				// Groupe insuffisant
				AND ($this->getUrl('group') < self::GROUP_MODERATOR)
			) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			}
			// Jeton incorrect
			elseif ($this->getUrl(3) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'user',
					'notification' => $text['core_user']['delete'][0]
				]);
			}
			// Bloque la suppression de son propre compte
			elseif($this->getUser('id') === $this->getUrl(2)) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'user',
					'notification' => $text['core_user']['delete'][1]
				]);
			}
			// Suppression
			else {
				$this->deleteData(['user', $this->getUrl(2)]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'user',
					'notification' => $text['core_user']['delete'][2],
					'state' => true
				]);
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
		if( $group < user::$actions['edit'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {	
			// Lexique
			include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');

			if ($this->getUrl(3) !== $_SESSION['csrf'] &&
				$this->getUrl(4) !== $_SESSION['csrf']) {
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'user',
					'notification' => $text['core_user']['edit'][0]
				]);
			}
			// Accès refusé
			if(
				// L'utilisateur n'existe pas
				$this->getData(['user', $this->getUrl(2)]) === null
				// Droit d'édition
				AND (
					// Impossible de s'auto-éditer
					(
						$this->getUser('id') === $this->getUrl(2)
						AND $this->getUrl('group') <= self::GROUP_VISITOR
					)
					// Impossible d'éditer un autre utilisateur
					OR ($this->getUrl('group') < self::GROUP_MODERATOR)
				)
			) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			}
			// Accès autorisé
			else {
				// Soumission du formulaire
				if($this->isPost()) {
					// Double vérification pour le mot de passe
					$newPassword = $this->getData(['user', $this->getUrl(2), 'password']);
					if($this->getInput('userEditNewPassword')) {
						// L'ancien mot de passe est correct
						if(password_verify($this->getInput('userEditOldPassword'), $this->getData(['user', $this->getUrl(2), 'password']))) {
							// La confirmation correspond au mot de passe
							if($this->getInput('userEditNewPassword') === $this->getInput('userEditConfirmPassword')) {
								$newPassword = $this->getInput('userEditNewPassword', helper::FILTER_PASSWORD, true);
								// Déconnexion de l'utilisateur si il change le mot de passe de son propre compte
								if($this->getUser('id') === $this->getUrl(2)) {
									helper::deleteCookie('DELTA_USER_ID');
									helper::deleteCookie('DELTA_USER_PASSWORD');
								}
							}
							else {
								self::$inputNotices['userEditConfirmPassword'] = $text['core_user']['edit'][1];
							}
						}
						else {
							self::$inputNotices['userEditOldPassword'] = $text['core_user']['edit'][1];
						}
					}
					// Modification du groupe
					if(
						$this->getUser('group') === self::GROUP_ADMIN
						AND $this->getUrl(2) !== $this->getUser('id')
					) {
						$newGroup = $this->getInput('userEditGroup', helper::FILTER_INT, true);
					}
					else {
						$newGroup = $this->getData(['user', $this->getUrl(2), 'group']);
					}
					// Modification de nom Prénom
					if($this->getUser('group') === self::GROUP_ADMIN){
						$newfirstname = $this->getInput('userEditFirstname', helper::FILTER_STRING_SHORT, true);
						$newlastname = $this->getInput('userEditLastname', helper::FILTER_STRING_SHORT, true);
					}
					else{
						$newfirstname = $this->getData(['user', $this->getUrl(2), 'firstname']);
						$newlastname = $this->getData(['user', $this->getUrl(2), 'lastname']);
					}
					// Modifie l'utilisateur
					$this->setData([
						'user',
						$this->getUrl(2),
						[
							'firstname' => $newfirstname,
							'forgot' => 0,
							'group' => $newGroup,
							'lastname' => $newlastname,
							'pseudo' => $this->getInput('userEditPseudo', helper::FILTER_STRING_SHORT, true),
							'signature' => $this->getInput('userEditSignature', helper::FILTER_INT, true),
							'mail' => $this->getInput('userEditMail', helper::FILTER_MAIL, true),
							'password' => $newPassword,
							'connectFail' => $this->getData(['user',$this->getUrl(2),'connectFail']),
							'connectTimeout' => $this->getData(['user',$this->getUrl(2),'connectTimeout']),
							'accessUrl' => $this->getData(['user',$this->getUrl(2),'accessUrl']),
							'accessTimer' => $this->getData(['user',$this->getUrl(2),'accessTimer']),
							'accessCsrf' => $this->getData(['user',$this->getUrl(2),'accessCsrf']),
							'files' => $this->getInput('userEditFiles', helper::FILTER_BOOLEAN),
							'redirectPageId' => $this->getInput('userRedirectPageId', helper::FILTER_STRING_SHORT)
						]
					]);
					// Redirection spécifique si l'utilisateur change son mot de passe
					if($this->getUser('id') === $this->getUrl(2) AND $this->getInput('userEditNewPassword')) {
						$redirect = helper::baseUrl() . 'user/login/' . str_replace('/', '_', $this->getUrl());
					}
					// Redirection si retour en arrière possible
					elseif($this->getUser('group') === self::GROUP_ADMIN) {
						$redirect = helper::baseUrl() . 'user';
					}
					// Redirection normale
					else {
						$redirect = helper::baseUrl();
					}
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => $redirect,
						'notification' => $text['core_user']['edit'][2],
						'state' => true
					]);
				}
				// Générer la liste des pages disponibles
				$redirectPage = array( 'noRedirect'=> array( 'title'=> $text['core_user']['edit'][3]) );
				self::$pagesList = $this->getData(['page']);
				foreach(self::$pagesList as $page => $pageId) {
					if ($this->getData(['page',$page,'block']) === 'bar' ||
						$this->getData(['page',$page,'disable']) === true ||
						$this->getData(['page',$page,'title']) === null ) {
						unset(self::$pagesList[$page]);
					}
				}
				self::$pagesList = array_merge( $redirectPage, self::$pagesList);
				// Valeurs en sortie
				$this->addOutput([
					'title' => $this->getData(['user', $this->getUrl(2), 'firstname']) . ' ' . $this->getData(['user', $this->getUrl(2), 'lastname']),
					'view' => 'edit'
				]);
			}
		}
	}

	/**
	 * Mot de passe perdu
	 */
	public function forgot() {
		// Lexique
		include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');
		// Soumission du formulaire
		if($this->isPost()) {
			$userId = $this->getInput('userForgotId', helper::FILTER_ID, true);
			if($this->getData(['user', $userId])) {
				// Enregistre la date de la demande dans le compte utilisateur
				$this->setData(['user', $userId, 'forgot', time()]);
				// Crée un id unique pour la réinitialisation
				$uniqId = md5(json_encode($this->getData(['user', $userId])));
				// Envoi le mail
				$sent = $this->sendMail(
					$this->getData(['user', $userId, 'mail']),
					$text['core_user']['forgot'][0],
					$text['core_user']['forgot'][1] .'<strong>' . $this->getData(['user', $userId, 'firstname']) . ' ' . $this->getData(['user', $userId, 'lastname']) . '</strong>,<br><br>' .
					$text['core_user']['forgot'][2].'<br><br>' .
					'<a href="' . helper::baseUrl() . 'user/reset/' . $userId . '/' . $uniqId . '" target="_blank">' . helper::baseUrl() . 'user/reset/' . $userId . '/' . $uniqId . '</a><br><br>' .
					$text['core_user']['forgot'][3].'</small>',
					null
				);
				// Valeurs en sortie
				$this->addOutput([
					'notification' => ($sent === true ? $text['core_user']['forgot'][4] : $sent),
					'state' => ($sent === true ? true : null)
				]);
			}
			// L'utilisateur n'existe pas
			else {
				// Valeurs en sortie
				$this->addOutput([
					'notification' => $text['core_user']['forgot'][5]
				]);
			}
		}
		// Valeurs en sortie
		$this->addOutput([
			'display' => self::DISPLAY_LAYOUT_LIGHT,
			'title' => $text['core_user']['forgot'][6],
			'view' => 'forgot'
		]);
	}

	/**
	 * Liste des utilisateurs
	 */
	public function index() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < user::$actions['index'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {	
			// Lexique
			include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');

			$userIdsFirstnames = helper::arrayCollumn($this->getData(['user']), 'firstname');
			ksort($userIdsFirstnames);
			foreach($userIdsFirstnames as $userId => $userFirstname) {
				if ($this->getData(['user', $userId, 'group'])) {
					self::$users[] = [
						$userId,
						$userFirstname . ' ' . $this->getData(['user', $userId, 'lastname']),
						$groups[$this->getData(['user', $userId, 'group'])],
						template::button('userEdit' . $userId, [
							'href' => helper::baseUrl() . 'user/edit/' . $userId . '/back/'. $_SESSION['csrf'],
							'value' => template::ico('pencil')
						]),
						template::button('userDelete' . $userId, [
							'class' => 'userDelete buttonRed',
							'href' => helper::baseUrl() . 'user/delete/' . $userId. '/' . $_SESSION['csrf'],
							'value' => template::ico('cancel')
						])
					];
				}
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_user']['index'][0],
				'view' => 'index'
			]);
		}
	}

	/**
	 * Connexion
	 */
	public function login() {
	
		// Lexique
		include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');
		// Soumission du formulaire
		$logStatus = '';
		if($this->isPost()) {
			// Lire Id du compte
			$userId = $this->getInput('userLoginId', helper::FILTER_ID, true);
			$detectBot ='';
			$captcha = true;
			// Check le captcha
			if(	$this->getData(['config','connect','captcha']) ){
				$code ='';
				if( isset( $_REQUEST['codeCaptcha'])) $code = strtoupper($_REQUEST['codeCaptcha']);
				if( !isset($_SESSION['captcha']) || md5($code) !== $_SESSION['captcha'] ) {
					$captcha = false;
				} else {
					$captcha = true;
				}	
			}
			/**
			 * Aucun compte existant
			 */
			if ( !$this->getData(['user', $userId])) {
				$logStatus = $text['core_user']['login'][0];
				//Stockage de l'IP
				$this->setData([
					'blacklist',
					$userId,
					[
						'connectFail' => $this->getData(['blacklist',$userId,'connectFail']) + 1,
						'lastFail' => time(),
						'ip' => helper::getIp()
					]
				]);
				// Verrouillage des IP
				$ipBlackList = helper::arrayCollumn($this->getData(['blacklist']), 'ip');
				if ( $this->getData(['blacklist',$userId,'connectFail']) >= $this->getData(['config', 'connect', 'attempt'])
					AND in_array($this->getData(['blacklist',$userId,'ip']),$ipBlackList) ) {
					$logStatus = $text['core_user']['login'][1];
					// Valeurs en sortie
					$this->addOutput([
						'notification' => $text['core_user']['login'][2],
						'redirect' => helper::baseUrl(),
						'state' => false
					]);
				} else {
					// Valeurs en sortie
					$this->addOutput([
						'notification' => $text['core_user']['login'][3]
					]);
				}
			/**
			 * Le compte existe
			 */
			} else 	{
				// Cas 4 : le délai de  blocage est  dépassé et le compte est au max - Réinitialiser
				if ($this->getData(['user',$userId,'connectTimeout'])  + $this->getData(['config', 'connect', 'timeout']) < time()
					AND $this->getData(['user',$userId,'connectFail']) === $this->getData(['config', 'connect', 'attempt']) ) {
					$this->setData(['user',$userId,'connectFail',0 ]);
					$this->setData(['user',$userId,'connectTimeout',0 ]);
				}
				// Check la présence des variables et contrôle du blocage du compte si valeurs dépassées
				// Vérification du mot de passe et du groupe
				if (
					( $this->getData(['user',$userId,'connectTimeout']) + $this->getData(['config', 'connect', 'timeout'])  ) < time()
					AND $this->getData(['user',$userId,'connectFail']) < $this->getData(['config', 'connect', 'attempt'])
					AND password_verify($this->getInput('userLoginPassword', helper::FILTER_STRING_SHORT, true), $this->getData(['user', $userId, 'password']))
					AND $this->getData(['user', $userId, 'group']) >= self::GROUP_MEMBER
					AND $captcha === true
				) {
					// RAZ
					$this->setData(['user',$userId,'connectFail',0 ]);
					$this->setData(['user',$userId,'connectTimeout',0 ]);
					// Expiration
					$expire = $this->getInput('userLoginLongTime') ? strtotime("+1 year") : 0;
					$c = $this->getInput('userLoginLongTime', helper::FILTER_BOOLEAN) === true ? 'true' : 'false';
					setcookie('DELTA_USER_ID', $userId, $expire, helper::baseUrl(false, false)  , '', helper::isHttps(), true);
					setcookie('DELTA_USER_PASSWORD', $this->getData(['user', $userId, 'password']), $expire, helper::baseUrl(false, false), '', helper::isHttps(), true);
					setcookie('DELTA_USER_LONGTIME', $c, $expire, helper::baseUrl(false, false), '', helper::isHttps(), true);
					// Accès multiples avec le même compte
					$this->setData(['user',$userId,'accessCsrf',$_SESSION['csrf']]);
					// Valeurs en sortie lorsque le site est en maintenance et que l'utilisateur n'est pas administrateur
					if(
						$this->getData(['config', 'maintenance'])
						AND $this->getData(['user', $userId, 'group']) < self::GROUP_ADMIN
					) {
						$this->addOutput([
							'notification' => $text['core_user']['login'][4],
							'redirect' => helper::baseUrl(),
							'state' => false
						]);
					} else {
						$logStatus = $text['core_user']['login'][5];
						// Page de redirection par défaut
						$redirectPage = helper::baseUrl() . str_replace('_', '/', str_replace('__', '#', $this->getUrl(2)));
						if( null !==($this->getData(['user',$userId,'redirectPageId'])) AND $this->getData(['user',$userId,'redirectPageId']) !== 'noRedirect') $redirectPage = helper::baseUrl() . $this->getData(['user',$userId,'redirectPageId']);
						// Valeurs en sortie
						$this->addOutput([
							'notification' => $text['core_user']['login'][6] . $this->getData(['user',$userId,'firstname']) . ' ' . $this->getData(['user',$userId,'lastname']) ,
							'redirect' => $redirectPage,
							'state' => true
						]);
					}
				// Sinon notification d'échec et captcha addition
				} else {
					$notification = $text['core_user']['login'][7];
					$_SESSION['humanBot']='bot';
					// Cas 1 le nombre de connexions est inférieur aux tentatives autorisées : incrément compteur d'échec
					if ($this->getData(['user',$userId,'connectFail']) < $this->getData(['config', 'connect', 'attempt'])) {
						$this->setData(['user',$userId,'connectFail',$this->getdata(['user',$userId,'connectFail']) + 1 ]);
					}
					// Cas 2 la limite du nombre de connexion est atteinte : placer le timer
					if ( $this->getdata(['user',$userId,'connectFail']) == $this->getData(['config', 'connect', 'attempt'])	) {
							$this->setData(['user',$userId,'connectTimeout', time()]);
					}
					// Cas 3 le délai de bloquage court
					if ($this->getData(['user',$userId,'connectTimeout'])  + $this->getData(['config', 'connect', 'timeout']) > time() ) {
						$notification = $text['core_user']['login'][10] . ($this->getData(['config', 'connect', 'timeout']) / 60) . ' minutes.';
					}

					// Valeurs en sortie
					$this->addOutput([
						'notification' => $notification
					]);
				}
			}
		}
		// Journalisation
		$dataLog = mb_detect_encoding(date('d\/m\/y',time()), 'UTF-8', true)
				? date('d\/m\/y',time()) . ';' . date('H\:i',time()) . ';'
				: helper::utf8Encode(date('d\/m\/y',time())) . ';' . helper::utf8Encode(date('H\:i',time())) . ';' ;
		$dataLog .= helper::getIp($this->getData(['config','connect','anonymousIp'])) . ';';
		$dataLog .= $this->getInput('userLoginId', helper::FILTER_ID) . ';' ;
		$dataLog .= $this->getUrl() .';' ;
		$dataLog .= $logStatus ;
		$dataLog .= PHP_EOL;
		if ($this->getData(['config','connect','log'])) {
			file_put_contents(self::DATA_DIR . 'journal.log', $dataLog, FILE_APPEND);
		}
		// Stockage des cookies
		if (!empty($_COOKIE['DELTA_USER_ID'])) {
			self::$userId = $_COOKIE['DELTA_USER_ID'];
		}
		if (!empty($_COOKIE['DELTA_USER_LONGTIME'])) {
			self::$userLongtime = $_COOKIE['DELTA_USER_LONGTIME'] == 'true' ? true : false;
		}
		// Valeurs en sortie
		$this->addOutput([
			'display' => self::DISPLAY_LAYOUT_LIGHT,
			'title' => $text['core_user']['login'][11],
			'view' => 'login'
		]);
	}

	/**
	 * Déconnexion
	 */
	public function logout() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < user::$actions['logout'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {	
			// Lexique
			include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');
			// Ne pas effacer l'identifiant mais seulement le mot de passe
			if (array_key_exists('DELTA_USER_LONGTIME',$_COOKIE)
				AND $_COOKIE['DELTA_USER_LONGTIME'] !== 'true' ) {
				helper::deleteCookie('DELTA_USER_ID');
				helper::deleteCookie('DELTA_USER_LONGTIME');
			}
			helper::deleteCookie('DELTA_USER_PASSWORD');
			session_destroy();
			// Valeurs en sortie
			$this->addOutput([
				'notification' => $text['core_user']['logout'][0],
				'redirect' => helper::baseUrl(false),
				'state' => true
			]);
		}
	}

	/**
	 * Réinitialisation du mot de passe
	 */
	public function reset() {
		// Lexique
		include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');
		// Accès refusé
		if(
			// L'utilisateur n'existe pas
			$this->getData(['user', $this->getUrl(2)]) === null
			// Lien de réinitialisation trop vieux
			OR $this->getData(['user', $this->getUrl(2), 'forgot']) + 86400 < time()
			// Id unique incorrecte
			OR $this->getUrl(3) !== md5(json_encode($this->getData(['user', $this->getUrl(2)])))
		) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// Accès autorisé
		else {
			// Soumission du formulaire
			if($this->isPost()) {
				// Double vérification pour le mot de passe
				if($this->getInput('userResetNewPassword')) {
					// La confirmation ne correspond pas au mot de passe
					if($this->getInput('userResetNewPassword', helper::FILTER_STRING_SHORT, true) !== $this->getInput('userResetConfirmPassword', helper::FILTER_STRING_SHORT, true)) {
						$newPassword = $this->getData(['user', $this->getUrl(2), 'password']);
						self::$inputNotices['userResetConfirmPassword'] = $text['core_user']['reset'][0];
					}
					else {
						$newPassword = $this->getInput('userResetNewPassword', helper::FILTER_PASSWORD, true);
					}
					// Modifie le mot de passe
					$this->setData(['user', $this->getUrl(2), 'password', $newPassword]);
					// Réinitialise la date de la demande
					$this->setData(['user', $this->getUrl(2), 'forgot', 0]);
					// Réinitialise le blocage
					$this->setData(['user', $this->getUrl(2),'connectFail',0 ]);
					$this->setData(['user', $this->getUrl(2),'connectTimeout',0 ]);
					// Valeurs en sortie
					$this->addOutput([
						'notification' => $text['core_user']['reset'][1],
						//'redirect' => helper::baseUrl() . 'user/login/' . str_replace('/', '_', $this->getUrl()),
						'redirect' => helper::baseUrl(),
						'state' => true
					]);
				}
			}
			// Valeurs en sortie
			$this->addOutput([
				'display' => self::DISPLAY_LAYOUT_LIGHT,
				'title' => $text['core_user']['reset'][2],
				'view' => 'reset'
			]);
		}
	}

	/**
	 * Importation CSV d'utilisateurs
	 */
	public function import() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < user::$actions['import'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {	
			// Lexique
			include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');
			// Soumission du formulaire
			$notification = '';
			$success = true;
			if($this->isPost()) {
				// Lecture du CSV et construction du tableau
				$file = $this->getInput('userImportCSVFile',helper::FILTER_STRING_SHORT, true);
				$filePath = self::FILE_DIR . 'source/' . $file;
				if ($file AND file_exists($filePath)) {
					// Analyse et extraction du CSV
					$rows   = array_map(function($row) {   return str_getcsv($row, $this->getInput('userImportSeparator') ); }, file($filePath));
					$header = array_shift($rows);
					$csv    = array();
					foreach($rows as $row) {
						if(count($header) === count($row)) $csv[] = array_combine($header, $row);
					}
					// Traitement des données
					foreach($csv as $item ) {
						// Données valides
						if( array_key_exists('id', $item)
						AND array_key_exists('firstname',$item)
						AND array_key_exists('lastname',$item)
						AND array_key_exists('pseudo',$item)
						AND array_key_exists('group',$item)
						AND array_key_exists('mail',$item)
						AND array_key_exists('password',$item)
						AND $item['lastname']
						AND $item['firstname']
						AND $item['pseudo']
						AND $item['id']
						AND $item['mail']
						AND $item['group']
						) {
							// Validation du groupe
							$item['group'] = (int) $item['group'];
							$item['group'] =   ( $item['group'] >= self::GROUP_BANNED AND $item['group'] <= self::GROUP_ADMIN )
												  ? $item['group'] : 1;
							// L'utilisateur de même id existe
							if ( $this->getData(['user',helper::filter($item['id'] , helper::FILTER_ID)]))
							{
								// Notification du doublon
								$item['notification'] = $text['core_user']['import'][10];
								// Création du tableau de confirmation
								self::$users[] = [
									helper::filter($item['id'] , helper::FILTER_ID),
									$item['lastname'],
									$item['firstname'],
									$item['pseudo'],
									$groups[$item['group']],
									helper::filter($item['mail'] , helper::FILTER_MAIL),
									$item['notification']
								];
								// L'utilisateur n'existe pas
							} else {
								// Nettoyage de l'identifiant
								$userId = helper::filter($item['id'] , helper::FILTER_ID);
								// Si le password n'est pas hashé on fixe un password provisoire
								$temporaryPassword = false;
								if( strlen($item['password']) < 60 && substr($item['password'],0,4)!=='$2y$'){
									$temporaryPassword = true;
									$userPwd =  $this->generatePassword();
									$item['password'] = password_hash($userPwd, PASSWORD_BCRYPT);;
								}
								// Enregistre le user
								$create = $this->setData([
									'user',
									$userId, [
										'firstname' => $item['firstname'],
										'forgot' => 0,
										'group' => $item['group'] ,
										'lastname' => $item['lastname'],
										'mail' => $item['mail'],
										'pseudo' => $item['pseudo'],
										'signature' => 1, // Pseudo
										'password' => $item['password'],
										"connectFail" => null,
										"connectTimeout" => null,
										"accessUrl" => null,
										"accessTimer" => null,
										"accessCsrf" => null
								]]);
								// Notification
								$messageCreating = $temporaryPassword === true ? $text['core_user']['import'][16] : $text['core_user']['import'][15];
								$item['notification'] = $create  ? $messageCreating : $text['core_user']['import'][14];
								// Envoi du mail
								if ($create  && ($temporaryPassword === true || $this->getInput('userImportNotification',helper::FILTER_BOOLEAN) === true )) {
									$messagePwd = $temporaryPassword === true ? $text['core_user']['import'][12].$userPwd : $text['core_user']['import'][13];
									$sent = $this->sendMail(
										$item['mail'],
										$text['core_user']['import'][0] . $this->getData(['locale', 'title']),
										$text['core_user']['import'][1].' <strong>' . $item['firstname'] . ' ' . $item['lastname'] . '</strong>,<br><br>' .
										$text['core_user']['import'][2]. $this->getData(['locale', 'title']) . $text['core_user']['import'][3].'<br><br>' .
										'<strong>'.$text['core_user']['import'][4].'</strong> ' . $userId . '<br>' . $messagePwd
									);
									if ($sent === true) {
										// Mail envoyé ajout de l'information
										$item['notification'] .= $text['core_user']['import'][11];
									}
								}
								// Création du tableau de confirmation
								self::$users[] = [
									$userId,
									$item['lastname'],
									$item['firstname'],
									$item['pseudo'],
									$groups[$item['group']],
									$item['mail'],
									$item['notification']
								];
							}
						}
					}
					if (empty(self::$users)) {
						$notification =  $text['core_user']['import'][6] ;
						$success = false;
					} else {
						$notification =  $text['core_user']['import'][7] ;
						$success = true;
					}
				} else {
					$notification = $text['core_user']['import'][8];
					$success = false;
				}
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $text['core_user']['import'][9],
				'view' => 'import',
				'notification' => $notification,
				'state' => $success
			]);
		}
	}
	
	/**
	 * Exportation CSV d'utilisateurs
	 */
	public function export() {
		// Autorisation 
		$group = $this->getUser('group');
		if ($group === false ) $group = 0;
		if( $group < user::$actions['export'] ) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);	
		} else {	
			// Lexique
			include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');
			$notification = $text['core_user']['export'][0].time().'_listusers.csv';
			$success = true;
			$csv ='';
			$sep = ';';
			$list = json_decode(file_get_contents(self::DATA_DIR.'user.json'), true);
			$listUsers = $list['user'];
			//id;nom;prénom;pseudo;email;groupe;mot de passe
			$csv = 'id'.$sep.'lastname'.$sep.'firstname'.$sep.'pseudo'.$sep.'mail'.$sep.'group'.$sep.'password'.PHP_EOL;
			foreach($listUsers as $key=>$value){
				$csv .= $key.$sep.$value['lastname'].$sep.$value['firstname'].$sep.$value['pseudo'].$sep.$value['mail'].$sep.$value['group'].$sep.$value['password'].PHP_EOL;
			}
			// Sauvegarde dans le fichier source/dateunix_listusers.csv
			$result = file_put_contents(self::FILE_DIR.'source/'.time().'_listusers.csv',$csv);
			if($result === false){
				$success = false;
				$notification = $text['core_user']['export'][1];
			}
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . 'user',
				'notification' => $notification,
				'state' => $success
			]);
		}
	}
	
	/*
	* Génère un mot de passe aléatoire
	* @param $length nombre de caractères du mot de passe
	* return le mot de passe
	*/
	Private function generatePassword($length = 12) {
		// Jeu de caractères utilisé pour le mot de passe
		$cara = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
		$sizeCara = strlen($cara);
		if ($length <= 0) $length = 12;
		$password = '';
		for ($i = 0; $i < $length; $i++) {
			$indexRandom = random_int(0, $sizeCara - 1);
			$password .= $cara[$indexRandom];
		}
		return $password ;
	}

}
