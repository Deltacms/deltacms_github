<?php
// Lexique
include('./module/slider/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_slider.php');
echo template::formOpen('galleryEditForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('galleryEditBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0),
				'ico' => 'left',
				'value' => $text['slider_view']['edit'][0]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('sliderIndexHelp', [
				'class' => 'buttonHelp',
				'ico' => 'help',
				'value' => $text['slider_view']['config'][1]
			]); ?>
		</div>
		<div class="col2 offset6">
			<?php echo template::submit('galleryEditSubmit',[
				'value' => $text['slider_view']['edit'][1]
			]); ?>
		</div>
	</div>
	<!-- Aide à propos de la configuration de slider, view config -->
	<div class="helpDisplayContent">
		<?php echo file_get_contents( $text['slider_view']['config'][8]) ;?>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['slider_view']['config'][2]; ?></div>
				<div class="row">
					<div class="col6">
						<?php echo template::select('galleryEditDirectory', str_replace('site/file/source/','',$module::$listDirs), [
							'label' => $text['slider_view']['config'][4],
							'selected' => array_search($this->getData(['module', $this->getUrl(0), 'config', 'directory']), $module::$listDirs)
						]);
						?>
					</div>
					<div id="galleryEditLabelView" class="col4 offset2 displayNone">
						<?php echo template::label('galleryEditLabel', $text['slider_view']['config'][9], []);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['slider_view']['edit'][2]; ?></div>
				<div class="row">
					<div class="col4">
					<?php echo template::select('sliderBoutonsVisibles', $boutonsVisibles,[
							'help' => $text['slider_view']['edit'][5],
							'label' => $text['slider_view']['edit'][6],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'boutonsVisibles'])
						]); ?>
					</div>
					<div class="col4">
					<?php echo template::select('sliderTypeBouton', $bouton,[
							'help' => $text['slider_view']['edit'][7],
							'label' => $text['slider_view']['edit'][8],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'typeBouton'])
						]); ?>
					</div>
					<div class="col4">
					<?php echo template::select('sliderPagerVisible', $pagerVisible,[
							'help' => $text['slider_view']['edit'][9],
							'label' => $text['slider_view']['edit'][10],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'pagerVisible'])
						]); ?>
					</div>
					<div class="col4">
					<?php echo template::select('sliderMaxiWidth', $module::$maxwidth,[
							'help' => $text['slider_view']['edit'][11],
							'label' => $text['slider_view']['edit'][12],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'maxiWidth'])
						]); ?>
					</div>
					<div class="col4">
					<?php echo template::select('sliderFadingTime', $module::$fadingtime,[
							'help' => $text['slider_view']['edit'][13],
							'label' => $text['slider_view']['edit'][14],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'fadingTime'])
						]); ?>
					</div>
					<div class="col4">
					<?php echo template::select('sliderDiapoTime', $module::$slidertime,[
							'help' => $text['slider_view']['edit'][15],
							'label' => $text['slider_view']['edit'][16],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'sliderTime'])
						]); ?>
					</div>
					<div class="col4">
					<?php echo template::select('sliderVisibiliteLegende', $visibilite_legende,[
							'help' => $text['slider_view']['edit'][17],
							'label' => $text['slider_view']['edit'][18],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'visibiliteLegende'])
						]); ?>
					</div>
					<div class="col4">
					<?php echo template::select('sliderPositionLegende', $position_legende,[
							'help' => $text['slider_view']['edit'][19],
							'label' => $text['slider_view']['edit'][20],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'positionLegende'])
						]); ?>
					</div>
					<div class="col4">
					<?php echo template::select('sliderTempsApparition', $module::$apparition,[
							'help' => $text['slider_view']['edit'][21],
							'label' => $text['slider_view']['edit'][22],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'tempsApparition'])
						]); ?>
					</div>
					<div class="col4">
					<?php echo template::select('sliderTri', $sort,[
							'help' => $text['slider_view']['edit'][23],
							'label' => $text['slider_view']['edit'][24],
							'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'tri'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php  if($module::$pictures):
		echo template::table([3, 5, 4], $module::$pictures, [$text['slider_view']['edit'][25], $text['slider_view']['edit'][26], $text['slider_view']['edit'][27]]);
		endif;
	echo template::formClose();
	?>
	<div class="moduleVersion">
	<?php echo $text['slider_view']['config'][10] . $module::VERSION; ?>
	</div>
