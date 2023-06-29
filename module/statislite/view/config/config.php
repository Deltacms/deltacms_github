<?php
// Lexique
include('./module/statislite/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_statislite.php');

echo template::formOpen('statisliteConfigForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('statisliteConfigBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),
				'ico' => 'left',
				'value' => $text['statislite_view']['config'][1]
			]); ?>
		</div>
		<div class="col2"<?php if( $this->getUser('group') < self::GROUP_MODERATOR ) echo 'style="display:none"'?>>
			<?php echo template::button('addonIndexHelp', [
				'class' => 'buttonHelp',
				'ico' => 'help',
				'value' => $text['statislite_view']['config'][2]
			]); ?>
		</div>
		<div class="col2 offset4"<?php if( $this->getUser('group') < self::GROUP_MODERATOR ) echo 'style="display:none"';?> >
			<?php echo template::button('configAdvancedButton', [
				'href' => helper::baseUrl() . $this->getUrl(0).'/advanced',
				'value' => $text['statislite_view']['config'][3],
				'ico' => 'cog-alt'
			]); ?>
		</div>
		<div class="col2 <?php if( $this->getUser('group') < self::GROUP_MODERATOR ) echo 'offset8'; ?> " >
			<?php echo template::submit('statisliteConfigSubmit',[
				'value' => $text['statislite_view']['config'][4]
			]); ?>
		</div>
	</div>
	<!-- Aide à propos de la configuration de Statislite, view config -->
	<div class="helpDisplayContent">
		<?php echo file_get_contents( $text['statislite_view']['config'][0]) ;?>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block" <?php if( $this->getUser('group') < self::GROUP_MODERATOR ) echo 'style="display:none"'?> >
				<div class="blockTitle"><?php echo $text['statislite_view']['config'][5]; ?></div>
				<div class="row" >
					<div class="col4">
						<?php echo template::select('statisliteConfigTimePageMini', $timePageMini,[
							'help' => $text['statislite_view']['config'][6],
							'label' => $text['statislite_view']['config'][7],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'timePageMini'])
						]); ?>
					</div>
					<div class="col4">
					<?php echo template::select('statisliteConfigTimeVisiteMini', $timeVisiteMini,[
							'help' => $text['statislite_view']['config'][8],
							'label' => $text['statislite_view']['config'][9],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'timeVisiteMini'])
						]); ?>
					</div>
					<div class="col4">
					<?php echo template::select('statisliteConfigNbPageMini', $nbPageMini,[
							'help' => $text['statislite_view']['config'][10],
							'label' => $text['statislite_view']['config'][11],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'nbPageMini'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::select('statisliteConfigUsersExclus', $users_exclus,[
							'help' => $text['statislite_view']['config'][12],
							'label' => $text['statislite_view']['config'][13],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'usersExclus']),
						]); ?>
					</div>
				</div>
			</div>

			<div class="block">
				<div class="blockTitle"><?php echo $text['statislite_view']['config'][14]; ?></div>
				<div class="row">
					<!-- Affichage graphique des pages vues -->

					<div class="col4">
						<?php echo template::select('statisliteConfigNbAffiPagesVues', $nbaffipagesvues,[
							'help' => $text['statislite_view']['config'][15],
							'label' => $text['statislite_view']['config'][16],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'nbaffipagesvues'])
						]); ?>
					</div>

					<!-- Affichage graphique des langues préférées -->

					<div class="col4">
						<?php echo template::select('statisliteConfigNbAffiLangues', $nbaffilangues,[
							'help' => $text['statislite_view']['config'][17],
							'label' => $text['statislite_view']['config'][18],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'nbaffilangues'])
						]); ?>
					</div>

					<!-- Affichage graphique des navigateurs -->

					<div class="col4">
						<?php echo template::select('statisliteConfigNbAffiNavigateurs', $nbaffinavigateurs,[
							'help' => $text['statislite_view']['config'][19],
							'label' => $text['statislite_view']['config'][20],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'nbaffinavigateurs'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<!-- Affichage graphique des systèmes d'exploitation -->

					<div class="col4">
						<?php echo template::select('statisliteConfigNbAffiSe', $nbaffise,[
							'help' => $text['statislite_view']['config'][21],
							'label' => $text['statislite_view']['config'][22],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'nbaffise'])
						]); ?>
					</div>

				</div>
			</div>

			<div class="block">
				<div class="blockTitle"><?php echo $text['statislite_view']['config'][23]; ?></div>
				<div class="row">
					<div class="col4">
					<?php echo template::select('statisLiteConfigNbAffiDates', $nbAffiDates,[
							'help' => $text['statislite_view']['config'][24],
							'label' => $text['statislite_view']['config'][25],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'nbaffidates'])
						]); ?>
					</div>
				</div>

			</div>

			<div class="block">
				<div class="blockTitle"><?php echo $text['statislite_view']['config'][26]; ?></div>
				<div class="row">
					<div class="col4">
					<?php echo template::select('statisliteConfigNbEnregSession', $nbEnregSession,[
							'help' => $text['statislite_view']['config'][27],
							'label' => $text['statislite_view']['config'][28],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'nbEnregSession'])
						]); ?>
					</div>
				</div>

			</div>

			<div class="block">
				<div class="blockTitle"><?php echo $text['statislite_view']['config'][29]; ?></div>
				<?php if(is_file( $module::$fichiers_json.'robots.json')){
					copy( $module::$fichiers_json.'robots.json', $module::$tmp.'robots.json');
					echo $text['statislite_view']['config'][30];
					echo '<p><a href="'. helper::baseUrl(false).'site/data/statislite/module/tmp/robots.json" target="_blank">Fichier robots.json</a></p>';
				}
				if(is_file( $module::$fichiers_json.'sessionInvalide.json')){
					copy( $module::$fichiers_json.'sessionInvalide.json', $module::$tmp.'sessionInvalide.json');
					echo $text['statislite_view']['config'][31];
					echo '<p><a href="'.helper::baseUrl(false).'site/data/statislite/module/tmp/sessionInvalide.json" target="_blank">Fichier sessionInvalide.json</a></p>';
				}
				?>
			</div>

			<div class="block"<?php if( $this->getUser('group') < self::GROUP_MODERATOR ) echo 'style="display:none"'?>>
				<div class="blockTitle"><?php echo $text['statislite_view']['config'][32]; ?></div>
				<?php echo template::checkbox('statisliteConfigMajForce', true, $text['statislite_view']['config'][33], [
					'checked' => false,
					'help' => $text['statislite_view']['config'][34]
				]); ?>
			</div>

			<div class="block"<?php if( $this->getUser('group') < self::GROUP_MODERATOR ) echo 'style="display:none"'?>>
				<div class="blockTitle"><?php echo $text['statislite_view']['config'][35];?></div>
				<div class="row">
					<div class="col2">
						<?php echo template::button('configSauveJson', [
							'href' => helper::baseUrl() . $this->getUrl(0) . '/sauveJson',
							'ico' => 'download',
							'value' => $text['statislite_view']['config'][36]
						]); ?>
					</div>
					<div class="col2 offset8">
					<?php echo template::button('configInitJson', [
							'class' => 'configInitJson buttonRed',
							'href' => helper::baseUrl() . $this->getUrl(0) . '/initJson' . '/' . $_SESSION['csrf'],
							'ico' => 'cancel',
							'value' => $text['statislite_view']['config'][37],
						]); ?>
					</div>
				</div>

				<div class="row">
					<!--Sélection d'un fichier de sauvegarde-->
					<div class="col8">
					<?php	echo template::select('configRestoreJson', $module::$filesSaved, [
							'help' => $text['statislite_view']['config'][38],
							'id' => 'config_restauration',
							'label' => $text['statislite_view']['config'][39],
							'selected' => $text['statislite_view']['config'][40]
							]);	?>
					</div>
				</div>

			</div>
			
			<div class="block"<?php if( $this->getUser('group') < self::GROUP_MODERATOR ) echo 'style="display:none"'?>>
				<div class="blockTitle"><?php echo $text['statislite_view']['config'][43];?></div>
				<div class="row">
					<div class="col2">
					<?php echo template::button('configInitDownload', [
							'class' => 'configInitDownload buttonRed',
							'href' => helper::baseUrl() . $this->getUrl(0) . '/initDownload' . '/' . $_SESSION['csrf'],
							'ico' => 'cancel',
							'value' => $text['statislite_view']['config'][44],
						]); ?>
					</div>
				</div>
			</div>			
		</div>
	</div>


<?php echo template::formClose(); ?>
<div class="moduleVersion">
	<?php echo $text['statislite_view']['config'][41]; echo $module::VERSION; ?>
</div>
<script>
	var textConfig = <?php echo '"'.$text['statislite_view']['config'][42].'"'; ?>;
	var textDownload = <?php echo '"'.$text['statislite_view']['config'][45].'"'; ?>;
</script>
