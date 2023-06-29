<?php
// Lexique
include('./core/module/addon/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_addon.php');

echo template::formOpen('configModulesUpload'); ?>
	<div class="row">
	  <div class="col2">
		  <?php echo template::button('configModulesBack', [
			  'class' => 'buttonGrey',
			  'href' => helper::baseUrl()  . 'addon',
			  'ico' => 'left',
			  'value' => $text['core_addon_view']['upload'][0]
		  ]); ?>
	  </div>
	  <div class="col2">
		<?php echo template::button('addonIndexHelp', [
		  'href' => 'https://doc.deltacms.fr/installer-un-module',
		  'target' => '_blank',
		  'class' => 'buttonHelp',
		  'ico' => 'help',
		  'value' => $text['core_addon_view']['upload'][1]
		]); ?>
	  </div>
	  <!-- Catalogue en ligne hors service
	  <div class="col2 ">
		  <?php echo template::button('configModulesStore', [
			  'href' => helper::baseUrl() . 'addon/store',
			  'value' => 'Catalogue en ligne'
			]); ?>
	  </div>
	  -->
	  <div class="col2 offset6">
			<?php echo template::submit('configModulesSubmit',[
				'value' => $text['core_addon_view']['upload'][2],
				'ico' => 'check'
			]); ?>
	  </div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
			<div class="blockTitle"><?php echo $text['core_addon_view']['upload'][6]; ?> </div>
				<div class="row">
					<div class="col6 offset3">
						<?php echo template::file('configModulesInstallation', [
								'label' => $text['core_addon_view']['upload'][3],
								'type' => 2
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4 offset3">
						<?php echo template::checkbox('configModulesCheck', true, $text['core_addon_view']['upload'][5], [
								'checked' => false,
								'help' => $text['core_addon_view']['upload'][4],
							]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
