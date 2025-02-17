<?php echo template::formOpen('translateForm');
// Lexique
include('./core/module/translate/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_translate.php');
?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('translateFormBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl(),
				'ico' => 'left',
				'value' => $text['core_translate_view']['index'][0]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('translateHelp', [
				'href' => 'https://doc.deltacms.fr/gestion-des-langues',
				'target' => '_blank',
				'ico' => 'help',
				'value' => $text['core_translate_view']['index'][1],
				'class' => 'buttonHelp'
			]); ?>
		</div>
		<div class="col3 offset3">
			<?php echo template::button('translateButton', [
				'href' => helper::baseUrl() . 'translate/copy',
				'value' => $text['core_translate_view']['index'][2],
				'ico' => 'cog-alt',
				'disabled' => $module::$siteTranslate
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('translateFormSubmit', [
				'value'=> $text['core_translate_view']['index'][3]
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
			<div class="blockTitle"><?php echo $text['core_translate_view']['index'][6]; ?></div>
				<div class="row">
					<div class="col4">
						<?php echo template::select('translateLangAdmin', self::$i18nList_admin, [
							'label' => $text['core_translate_view']['index'][4],
							'selected' => $this->getData(['config', 'i18n' , 'langAdmin'])
						]); ?>
					</div>
					<div class="col4">
						<?php
							$select = $this->getData(['config', 'i18n' , 'langBase']);
							if( !isset ($i18nList[$select]) ) $select = 'none';
						?>
						<?php asort(self::$i18nList);
						echo template::select('translateLangBase', self::$i18nList, [
							'label' => $text['core_translate_view']['index'][5],
							'selected' => $select
						]); ?>
					</div>
				</div>
				<div class="row">
					<?php
						if( $this->getData(['config', 'i18n' , 'langBase']) ==='none' || $select === 'none'){
							echo '<div class="col4 offset4">';
						}
						else{
							echo '<div id="translateOtherLangBase" class="displayNone col4 offset4">';
						}
					?>
						<?php echo template::text('translateOtherBase', [
							'label' => $text['core_translate_view']['index'][15],
							'help' => $text['core_translate_view']['index'][16],
							'value' => $this->getData(['config', 'i18n' , 'otherLangBase'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block" id="flagsWrapper">
			<div class="blockTitle"><?php echo $text['core_translate_view']['index'][14]; ?></div>
				<div class="row">
					<div class="col3">
						<?php echo template::select('translateFR', $module::$translateOptions['fr'], [
							'label' =>  template::flag('fr', '30px'),
							'class' => 'translateFlagSelect',
							'selected' => $this->getData(['config', 'i18n' , 'fr']),
						]); ?>
					</div>
					<div class="col3">
							<?php echo template::select('translateDE', $module::$translateOptions['de'], [
								'label' => template::flag('de', '30px'),
								'class' => 'translateFlagSelect',
								'selected' => $this->getData(['config', 'i18n' , 'de'])
							]); ?>
					</div>
					<div class="col3">
						<?php echo template::select('translateEN', $module::$translateOptions['en'], [
							'label' => template::flag('en', '30px'),
							'class' => 'translateFlagSelect',
							'selected' => $this->getData(['config', 'i18n' , 'en'])
						]); ?>
					</div>
					<div class="col3">
							<?php echo template::select('translateES', $module::$translateOptions['es'], [
								'label' =>  template::flag('es', '30px'),
								'class' => 'translateFlagSelect',
								'selected' => $this->getData(['config', 'i18n' , 'es'])
							]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col3">
						<?php echo template::select('translateIT', $module::$translateOptions['it'], [
							'label' =>  template::flag('it', '30px'),
							'class' => 'translateFlagSelect',
							'selected' => $this->getData(['config', 'i18n' , 'it'])
						]); ?>
					</div>
					<div class="col3">
							<?php echo template::select('translateNL', $module::$translateOptions['nl'], [
								'label' =>  template::flag('nl', '30px'),
								'class' => 'translateFlagSelect',
								'selected' => $this->getData(['config', 'i18n' , 'nl'])
							]); ?>
					</div>
					<div class="col3">
							<?php echo template::select('translatePT', $module::$translateOptions['pt'], [
								'label' =>  template::flag('pt', '30px'),
								'class' => 'translateFlagSelect',
								'selected' => $this->getData(['config', 'i18n' , 'pt'])
							]); ?>
					</div>
					<div class="col3">
							<?php echo template::select('translateEL', $module::$translateOptions['el'], [
								'label' =>  template::flag('el', '30px'),
								'class' => 'translateFlagSelect',
								'selected' => $this->getData(['config', 'i18n' , 'el'])
							]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col3">
						<?php echo template::select('translateDA', $module::$translateOptions['da'], [
							'label' =>  template::flag('da', '30px'),
							'class' => 'translateFlagSelect',
							'selected' => $this->getData(['config', 'i18n' , 'da'])
						]); ?>
					</div>
					<div class="col3">
							<?php echo template::select('translateFI', $module::$translateOptions['fi'], [
								'label' =>  template::flag('fi', '30px'),
								'class' => 'translateFlagSelect',
								'selected' => $this->getData(['config', 'i18n' , 'fi'])
							]); ?>
					</div>
					<div class="col3">
							<?php echo template::select('translateGA', $module::$translateOptions['ga'], [
								'label' =>  template::flag('ga', '30px'),
								'class' => 'translateFlagSelect',
								'selected' => $this->getData(['config', 'i18n' , 'ga'])
							]); ?>
					</div>
					<div class="col3">
							<?php echo template::select('translateSV', $module::$translateOptions['sv'], [
								'label' =>  template::flag('sv', '30px'),
								'class' => 'translateFlagSelect',
								'selected' => $this->getData(['config', 'i18n' , 'sv'])
							]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col3">
						<?php echo template::select('translateBR', $module::$translateOptions['br'], [
							'label' =>  template::flag('br', '30px'),
							'class' => 'translateFlagSelect',
							'selected' => $this->getData(['config', 'i18n' , 'br'])
						]); ?>
					</div>
					<div class="col3">
							<?php echo template::select('translateCA', $module::$translateOptions['ca'], [
								'label' =>  template::flag('ca', '30px'),
								'class' => 'translateFlagSelect',
								'selected' => $this->getData(['config', 'i18n' , 'ca'])
							]); ?>
					</div>
					<div class="col3">
							<?php echo template::select('translateCO', $module::$translateOptions['co'], [
								'label' =>  template::flag('co', '30px'),
								'class' => 'translateFlagSelect',
								'selected' => $this->getData(['config', 'i18n' , 'co'])
							]); ?>
					</div>
					<div class="col3">
							<?php echo template::select('translateEU', $module::$translateOptions['eu'], [
								'label' =>  template::flag('eu', '30px'),
								'class' => 'translateFlagSelect',
								'selected' => $this->getData(['config', 'i18n' , 'eu'])
							]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
