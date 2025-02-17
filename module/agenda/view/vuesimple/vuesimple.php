<div class="row">
	<div class="col2">
		<?php echo template::button('edition_retour', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . $this->getUrl(0),
			'ico' => 'left',
			'value' => $this->getData(['module', $this->getUrl(0), 'texts', 'configTextButtonBack'])
		]); ?>
	</div>
</div>
<?php
if( function_exists('datefmt_create') && function_exists('datefmt_format') && extension_loaded('intl') ){
	// Pour les dates suivant la langue de rédaction du site (langue principale ou langue de traduction rédigée)
	if( isset( $_SESSION['langFrontEnd']) && isset( $_SESSION['translationType']) && $_SESSION['translationType'] === 'site' ){
		$lang_date =  $_SESSION['langFrontEnd'];
	} else {
		$lang_date = $this->getData(['config', 'i18n', 'langBase']);
	}
	$fmt = datefmt_create(
		$lang_date,
		IntlDateFormatter::FULL,
		IntlDateFormatter::SHORT,
		null,
		IntlDateFormatter::GREGORIAN
	);
	$datedeb = datefmt_format($fmt, $module::$evenement['datedebut']);
	$datefin = datefmt_format($fmt, $module::$evenement['datefin']);
} else {
	$datedeb = date("d/m/Y - H:i",$module::$evenement['datedebut']);
	$datefin = date("d/m/Y - H:i",$module::$evenement['datefin']);
}
?>
<div class="row">
	<div class="col6 offset3">
		<div class="block">
			<div class="blockTitle"><?php echo $this->getData(['module', $this->getUrl(0), 'texts', 'configTextDateStart']).' ';
			echo  $datedeb.'<br>';
			echo $this->getData(['module', $this->getUrl(0), 'texts', 'configTextDateEnd']).' ';
			echo  $datefin;?> </div>
			<?php echo $module::$evenement['texte'];?>
		</div>
	</div>
</div>








