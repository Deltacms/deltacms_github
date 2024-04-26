<?php // Commentaires de page, fichier inclus dans showComment() ?>

<?php // Style lié au thème du site ?>
<style>.msgs .block .dataNameDate {  --dataNameDate_font : <?=$this->getData(['theme', 'text', 'font'])?>; }</style>

<?php
// Lexique
include('./core/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_core.php');

// Pour les dates suivant la langue de rédaction du site (langue principale ou langue de traduction rédigée)
if( function_exists('datefmt_create') && function_exists('datefmt_format') && extension_loaded('intl') ){
	if( isset( $_SESSION['langFrontEnd']) && isset( $_SESSION['translationType']) && $_SESSION['translationType'] === 'site' ){
		$lang_date =  $_SESSION['langFrontEnd'];
	} else {
		$lang_date = $this->getData(['config', 'i18n', 'langBase']);
	}
	$zone = 'Europe/Paris';
	$fmt = datefmt_create(
		$lang_date,
		IntlDateFormatter::LONG,
		IntlDateFormatter::SHORT,
		$zone,
		IntlDateFormatter::GREGORIAN
	);
}

// Création du brouillon s'il n'existe pas
if( !isset($_SESSION[$this->getUrl()]['draft'])){
	$_SESSION[$this->getUrl()]['draft'] = [];
	$_SESSION[$this->getUrl()]['draft']['textarea'] = "";
	$_SESSION[$this->getUrl()]['draft']['text'] = "";
}

// Traitement des boutons pagination
$commentNumPage = 'commentNumPage'. $this->getUrl(0);
if($this->isPost() && isset($_POST['commentPageFormNext' ])){
	$_SESSION[$commentNumPage] = $_SESSION[$commentNumPage] + 1;
}
if($this->isPost() && isset($_POST['commentPageFormPrev' ])){
	$_SESSION[$commentNumPage] = $_SESSION[$commentNumPage] - 1;
}

// Traitement de l'envoi du formualire
if($this->isPost() && isset($_POST['commentPageFormSubmit']) ) {


	// $notice concerne la détection d'erreurs
	$notice = ''; $detectBot='';
	$code = null !== $this->getInput('codeCaptcha') ? $this->getInput('codeCaptcha') : '';
	// Captcha demandée
	if(	$this->getData(['config', 'social', 'comment', 'captcha']) ){
		// option de détection de robot en premier cochée et $_SESSION['humanBot']==='human'
		if(	$_SESSION['humanBot']==='human' && $this->getData(['config', 'connect', 'captchaBot'])=== true ) {
			// Présence des 5 cookies et checkbox cochée ?
			$detectBot ='bot';
			if ( isset ($_COOKIE['evtO']) && isset ($_COOKIE['evtV']) && isset ($_COOKIE['evtH'])
				&& isset ($_COOKIE['evtS']) && isset ($_COOKIE['evtA']) && $this->getInput('commentPageFormHumanCheck', helper::FILTER_BOOLEAN) === true ) {
				// Calcul des intervals de temps
				$time2 = $_COOKIE['evtH'] - $_COOKIE['evtO']; // temps entre click checkbox et ouverture de la page
				$time3 = $_COOKIE['evtV'] - $_COOKIE['evtH']; // temps entre validation formulaire et click checkbox
				$time4 = $_COOKIE['evtS'] - $_COOKIE['evtA']; // temps passé sur la checkbox
				if( $time2 >= 1000 && $time3 >=300 && $time4 >=300 ) $detectBot = 'human';
			}
			// Bot présumé
			if( $detectBot === 'bot') $_SESSION['humanBot']='bot';
		}
		// $_SESSION['humanBot']==='bot' ou option 'Pas de Captcha pour un humain' non validée
		elseif( md5($code) !== $_SESSION['captcha'] ) {
			$notice = $text['core']['showComment'][1];
		}
	}

	// Lecture des inputs
	$valueText = $this->getInput('commentPageFormInput[0]', helper::FILTER_STRING_SHORT, true);
	$valueTextarea =  $this->getInput('commentPageFormInput[1]', helper::FILTER_STRING_LONG_NOSTRIP, true);

	// Mise à jour du brouillon
	$_SESSION[$this->getUrl()]['draft']['text'] = $valueText;
	$_SESSION[$this->getUrl()]['draft']['textarea']  = $valueTextarea;

	// Préparation du contenu des données ($data) et du mail
	$data = [];
	$content = '';
	$file_name = '';
	// Mail
	if( $valueText !== '') $content .= '<strong>' . $this->getData(['locale', 'pageComment', 'commentName']) . ' :</strong> ' . $valueText . '<br>';
	if( $valueTextarea !== '') $content .= '<strong>' . $this->getData(['locale', 'pageComment', 'comment']) . ' :</strong> ' . $valueTextarea . '<br>';
	// Données
	$data[$this->getData(['locale', 'pageComment', 'commentName'])] = $valueText;
	$data[$this->getData(['locale', 'pageComment', 'comment'])] = $valueTextarea;

	// Bot présumé, la page sera actualisée avec l'affichage du captcha complet
	if( $detectBot === 'bot') $notice = $text['core']['showComment'][1];

	// Si absence d'erreur
	$sent = true;
	if( $notice === ''){
		// Crée les données, l'indice des messages est la date unix
		$id = time();
		$this->setData(['comment', $this->getUrl(0), 'data', $id , $data]);
		// Enregistrement de la date formatée
		if( function_exists('datefmt_create') && function_exists('datefmt_format') && extension_loaded('intl') ){
			$dateMessage =  datefmt_format($fmt, strtotime( date('Y/m/d H:i:s',$id))); 
		} else {
			if( mb_detect_encoding(date('d/m/Y - H:i',  $id), 'UTF-8', true)){
				$dateMessage = date('d/m/Y - H:i', $id);
			} else {
				$dateMessage = utf8_encode(date('d/m/Y - H:i', $id));
			}
		} 
		$this->setData(['comment', $this->getUrl(0), 'data', $id , 'Date' , $dateMessage ]);
		// Liste des utilisateurs
		$userIdsFirstnames = helper::arrayCollumn($this->getData(['user']), 'firstname');
		ksort($userIdsFirstnames);
		$listUsers [] = '';
		foreach($userIdsFirstnames as $userId => $userFirstname) {
			$listUsers [] =  $userId;
		}
		// Emission du mail
		// Rechercher l'adresse en fonction du mail
		$singleuser = '';
		if( $this->getData(['config', 'social', 'comment', 'user']) !== '' ) $singleuser = $this->getData(['user', $listUsers[$this->getData(['config', 'social', 'comment', 'user'])], 'mail']);
		$group = $this->getData(['config', 'social', 'comment', 'group']);
		// Verification si le mail peut être envoyé
		if(
			self::$inputNotices === [] && (
				$group > 0 ||
				$singleuser !== '')
		) {
			// Utilisateurs dans le groupe
			$to = [];
			if ($group > 0){
				foreach($this->getData(['user']) as $userId => $user) {
					if($user['group'] >= $group) {
						$to[] = $user['mail'];
					}
				}
			}
			// Utilisateur désigné
			if (!empty($singleuser)) {
				$to[] = $singleuser;
			}
			if($to) {
				// Sujet du mail
				$subject = $this->getData(['config', 'social', 'comment', 'subject']);
				if($subject === '') {
					$subject = $text['core']['showComment'][2];
				}
				// Envoi le mail
				$sent = $this->sendMail(
					$to,
					$subject,
					$text['core']['showComment'][3] . $this->getData(['page', $this->getUrl(0), 'title']) . ' :<br><br>' .
					$content
				);
			}
		}
		// Redirection
		$redirect = helper::baseUrl() . $this->getUrl(0);
		if ( $this->getData(['module', $this->getUrl(0), 'config', 'pageId']) !== '') $redirect = helper::baseUrl() . $this->getData(['module', $this->getUrl(0), 'config', 'pageId']);
		// Effacement des données provisoires
		if( self::$inputNotices === [] ){
			$_SESSION[$this->getUrl()]['draft'] = [];
			$_SESSION[$this->getUrl()]['draft']['textarea'] = "";
			$_SESSION[$this->getUrl()]['draft']['text'] = "";
		} else {
				$sent = false;
		}
	} else {
		$sent = false;
	}

	// Notifications
	if( $sent === true) {
		$_SESSION['DELTA_NOTIFICATION_SUCCESS']= $text['core']['showComment'][4];
		$_SESSION['DELTA_NOTIFICATION_ERROR'] = '';
	} else {
		$_SESSION['DELTA_NOTIFICATION_SUCCESS']= '';
		$_SESSION['DELTA_NOTIFICATION_ERROR'] = $text['core']['showComment'][5];
	}
	$this->showNotification();
}

// Préparation de la liste paginée des commentaires // Initialisation de la pagination
$nbPage =0;
$data=[];
$pagesComment = '';
if ( !isset($_SESSION[$commentNumPage] )) $_SESSION[$commentNumPage] = 1;
$dataPage = $this->getData(['comment', $this->getUrl(0), 'data']);
if ( NULL !== $dataPage && is_array($dataPage) && $dataPage !== [] ) {
	$nbItemPage = $this->getData(['config', 'social', 'comment', 'nbItemPage']);
	$nbPage = ceil(count( $dataPage) / $nbItemPage);
	if( $_SESSION[$commentNumPage] > $nbPage ) $_SESSION[$commentNumPage] = $nbPage;
	if( $_SESSION[$commentNumPage] <= 0 ) $_SESSION[$commentNumPage] = 1;
	$paramPage = $this->getUrl() .'/'. $_SESSION[$commentNumPage];
	// Pagination
	$pagination = helper::pagination($dataPage, $paramPage, $nbItemPage);
	// Liste des pages
	$pagesComment = $pagination['pages'];
	// Inverse l'ordre du tableau
	$dataPage = array_reverse($dataPage);
	// Données en fonction de la pagination et suppression des adresses e-mail
	for($i = $pagination['first']; $i < $pagination['last']; $i++) {
		$content = '';
		$dataKeys = array_keys($dataPage[$i]);
		$content .= '<div class="msgs"><div class="block"><div class="dataNameDate blockTitle">'. $dataPage[$i][$dataKeys[0]] . $this->getData(['locale', 'pageComment', 'link']). ' ' . $dataPage[$i][$dataKeys[2]] .'</div>';
		$content .= '<div class="dataComment">' . $dataPage[$i][$dataKeys[1]] . '</div></div></div><br>';
		$data[] = [$content];
	}
}

// Partie affichage  (View dans la structure classique)
// Adaptation de la langue dans tinymce pour la rédaction d'un message en fonction de la langue de la page, originale ou en traduction rédigée
$lang = $this->getData(['config', 'i18n', 'langBase']);
if ( !empty($_COOKIE["DELTA_I18N_SITE"])) {
	if( $this->getInput('DELTA_I18N_SITE') !== 'base' ) $lang = $this->getInput('DELTA_I18N_SITE');
}
$lang_page = $lang;
switch ($lang) {
	case 'en' :
		$lang_page = 'en_GB';
		break;
	case 'pt' :
		$lang_page = 'pt_PT';
		break;
	case 'sv' :
		$lang_page = 'sv_SE';
		break;
	case 'fr' :
		$lang_page = 'fr_FR';
		break;
}
// Si la langue n'est pas supportée par Tinymce la langue d'administration est utilisée
if( ! file_exists( 'core/vendor/tinymce/langs/'.$lang_page.'.js' )){	
	$lang_page = $text['core']['showComment'][7];
}
echo '<script> var lang_admin = "'.$lang_page.'"; </script>';
// Vendor tinymce ?>
<script src="core/vendor/tinymce/tinymce.min.js"></script><script src="core/vendor/tinymce/init.js"></script>
<div class="row">
	<div class="col4 offset4">
		<?php echo template::button('buttonCommentShowForm', [
			'value' => $this->getData(['locale', 'pageComment', 'writeComment']),
			'ico' => 'pencil'
		]); ?>
	</div>
</div>
<div id="formCommentVisible" style="display: none;">
<?php // Formulaire
$action =  helper::baseUrl().$this->getUrl().'#commentAnchor';
echo template::formOpenFile('commentPageFormForm', $action);
?>
	<div class="humanBot">
		<?php echo template::text('commentPageFormInput[0]', [
			'id' => 'commentPageFormInput_0',
			'label' => $this->getData(['locale', 'pageComment', 'commentName']),
			'value' => $_SESSION[$this->getUrl()]['draft']['text']
		]);
		echo template::textarea('commentPageFormInput[1]', [
			'id' => 'commentPageFormInput_1',
			'label' => $this->getData(['locale', 'pageComment', 'comment']),
			'value' => $_SESSION[$this->getUrl()]['draft']['textarea'],
			'class' => 'editorWysiwygComment',
			'noDirty' => true
		]); ?>
	</div>
	<?php if( $this->getData(['config', 'social', 'comment',  'captcha']) && ( $_SESSION['humanBot']==='bot') || $this->getData(['config', 'connect', 'captchaBot'])===false ): ?>
		<div class="row">
			<div class="col12 textAlignCenter">
				<?php echo template::captcha('commentPageFormCaptcha', ''); ?>
			</div>
		</div>
	<?php endif; ?>
	<?php if( $this->getData(['config', 'social', 'comment',  'captcha'])	&&  $_SESSION['humanBot']==='human' && $this->getData(['config', 'connect', 'captchaBot']) ): ?>
		<div class="row formCheckBlue">
			<?php echo template::text('commentPageFormInputBlue', [
				'label' => 'Input Blue',
				'value' => ''
			]); ?>
		</div>
		<br>
		<div class="row formOuter">
			<div class="formInner commentHumanCheck">
				<?php echo template::checkbox('commentPageFormHumanCheck', true, $this->getData(['locale', 'captchaSimpleText']), [
					'checked' => false,
					'help' => $this->getData(['locale', 'captchaSimpleHelp'])
				]); ?>
			</div>
		</div>
		<br>
	<?php endif; ?>
	<div class="row textAlignCenter">
		<div class="formInner commentHumanBotClose">
			<?php echo template::submit('commentPageFormSubmit', [
				'value' => $this->getData(['locale', 'pageComment', 'submit']),
				'ico' => ''
			]); ?>
		</div>
	</div>
	<br>
</div>

<?php
// Affichage des messages
if( $data ){
	echo '<div  id="commentAnchor">';
		foreach( $data as $key1=>$value1){
			if( is_array($value1)){
				foreach( $value1 as $key2=>$value2){
					echo $value2;
				}
			}
		}
	echo '</div>';
}

if($pagesComment && $nbPage > 1){ ?>
		<?php $disabledNext = false;
		$disabledPrev = false;
		if($_SESSION[$commentNumPage] <= 1) $disabledPrev = true;
		if($_SESSION[$commentNumPage] >= $nbPage) $disabledNext = true; ?>
		<div class="textAlignCenter" style="margin-top: 20px;">
			<?php echo template::submit('commentPageFormPrev', [
				'class' => 'commentPageButtonPrevNext',
				'value' => '<',
				'disabled' => $disabledPrev,
				'ico' =>''
			]); ?>
			<?php  echo template::button('commentButtonPageNumber',[
				'class' =>  'commentPageButtonPageNb',
				'disabled' => true,
				'value' => $this->getData(['locale', 'pageComment', 'page']).' '.$_SESSION[$commentNumPage].'/'.$nbPage
			]);  ?>
			<?php echo template::submit('commentPageFormNext', [
				'class' => 'commentPageButtonPrevNext',
				'value' => '>',
				'disabled' => $disabledNext,
				'ico' =>''
			]); ?>
		</div>
 <?php
}
echo template::formClose();
?>
