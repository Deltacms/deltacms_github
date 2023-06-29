<div class="row">
	<div class="col6">
		<p><img src="./site/file/source/icones/logo_menu_couleur_600_200.png" width="200" height="auto"></p>
	</div>
	<div class="col4 offset2">
				<?php echo template::select('installLang', ['en'=>'English','fr'=>'Français','es'=>'Español'], [
					'label' => '',
					'selected' => 'fr'
				]); ?>
	</div>
</div>
<?php echo template::formOpen('installForm'); ?>
	<div class="row">
		<div class="col6">
			<div id="m2f">Identifiant</div><div id="m2e">Identifier</div><div id="m2s">Nombre de usuario</div>
			<?php echo template::text('installId', [
				'autocomplete' => 'off',
				'label' => ''
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col6">
			<div id="m3f">Mot de passe</div><div id="m3e">Password</div><div id="m3s">Contraseña</div>
			<?php echo template::password('installPassword', [
				'autocomplete' => 'off',
				'label' => ''
			]); ?>
		</div>
		<div class="col6">
			<div id="m4f">Confirmation</div><div id="m4e">Confirmation</div><div id="m4s">Confirmación</div>
			<?php echo template::password('installConfirmPassword', [
				'autocomplete' => 'off',
				'label' => ''
			]); ?>
		</div>
	</div>
	<div id="m1f">Adresse mail</div><div id="m1e">Email address</div><div id="m1s">Correo electrónico</div>
	<?php echo template::mail('installMail', [
		'autocomplete' => 'off',
		'label' => ''
	]); ?>
	<div class="row">
		<div class="col6">
			<div id="m5f">Prénom</div><div id="m5e">First name</div><div id="m5s">Nombre</div>
			<?php echo template::text('installFirstname', [
				'autocomplete' => 'off',
				'label' => ''
			]); ?>
		</div>
		<div class="col6">
			<div id="m6f">Nom</div><div id="m6e">Name</div><div id="m6s">Apellido</div>
			<?php echo template::text('installLastname', [
				'autocomplete' => 'off',
				'label' => ''
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div id="m7f"><p>Thème - <a href="https://deltacms.fr/themes" target="_blank">Voir ces thèmes</a></p></div>
			<div id="m7e"><p>Theme - <a href="https://deltacms.fr/themes" target="_blank">View these themes</a></p></div>
			<div id="m7s"><p>Theme - <a href="https://deltacms.fr/themes" target="_blank">Ver estos temas</a></p></div>
				<?php echo template::select('installTheme', $module::$themes, [
						'label' => ''
				]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col2">
			<?php echo template::checkbox('installDefaultData',true , '', [
				'checked' => false
			]);
			?>
		</div>
		<div class="col10">
			<div id="m8f">Sans exemple de site </div><div id="m8e">Without an example site </div><div id="m8s">Sin ejemplo de sitio </div>
		</div>
	</div>
	<div class="row">
		<div class="col6">
			<div id="m9f">Langue d'administration</div><div id="m9e">Administration language</div><div id="m9s">Idioma administrativo</div>
			<div>
				<?php echo template::select('installLangAdmin', ['fr'=>'Français (fr)','en'=>'English (en)','es'=>'Español (es)'], [
					'label' => '',
					'selected' => $this->getData(['config', 'i18n' , 'langAdmin'])
				]); ?>
			</div>
		</div>
		<div class="col6">
			<div id="m10f">Langue originale du site</div><div id="m10e">Original language of the site</div><div id="m10s">Idioma original del sitio</div>
			<div>
				<?php echo template::select('installLangBase', core::$i18nList_int, [
					'label' => '',
					'selected' => $this->getData(['config', 'i18n' , 'langBase'])
				]); ?>
			</div>
		</div>
	</div>	
	<div class="row">
		<div class="col3 offset9">
			<?php echo template::submit('installSubmit', [
				'value' => 'OK'
			]); ?>
		</div>
	</div>
<?php echo template::formClose(); ?>