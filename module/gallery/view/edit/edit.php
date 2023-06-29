<?php
// Lexique
$param = "gallery_view";
include('./module/gallery/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_gallery.php');

echo template::formOpen('galleryEditForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('galleryEditBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'ico' => 'left',
				'value' => $text['gallery_view']['edit'][0]
			]); ?>
		</div>
		<div class="col2 offset8">
			<?php echo template::submit('galleryEditSubmit',[
				'value' => $text['gallery_view']['edit'][1]
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['gallery_view']['edit'][2]; ?></div>
				<div class="row">
					<div class="col5">
						<?php echo template::text('galleryEditName', [
							'label' => $text['gallery_view']['edit'][3],
							'value' => $this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(2), 'config', 'name']),
							'readonly' => $this->getUser('group') >= self::GROUP_MODERATOR ? false : true
						]); ?>
					</div>
					<div class="col4 <?php if($this->getUser('group') < self::GROUP_MODERATOR) echo 'displayNone'; ?> ">
						<?php echo template::hidden('galleryEditDirectoryOld', [
							'value' => $this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(2), 'config', 'directory']),
							'noDirty' => true // Désactivé à cause des modifications en ajax
						]); ?>
						<?php echo template::select('galleryEditDirectory', [], [
							'label' => $text['gallery_view']['edit'][4],
							'noDirty' => true // Désactivé à cause des modifications en ajax
						]); ?>
					</div>
					<div class="col3">
						<?php echo template::select('galleryEditSort', $sort, [
							'selected' => $this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(2), 'config', 'sort']),
							'label' => $text['gallery_view']['edit'][5],
							'help' => $text['gallery_view']['edit'][6]
						]); ?>
					</div>
				<div clas="row">
					<div class="col12">
                        <?php echo template::checkbox('galleryEditFullscreen', true, $text['gallery_view']['edit'][7], [
								'checked' => $this->getData(['module', $this->getUrl(0), 'content', $this->getUrl(2), 'config', 'fullScreen']),
								'help' => $text['gallery_view']['edit'][8]
                            ]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col12">
						<?php if($module::$pictures): ?>
							<?php echo template::table([1, 4, 1, 5, 1], $module::$pictures, ['',$text['gallery_view']['edit'][9], $text['gallery_view']['edit'][10],$text['gallery_view']['edit'][11],''],['id' => 'galleryTable'], $module::$picturesId ); ?>
							<?php echo template::hidden('galleryEditFormResponse'); ?>
							<?php echo template::hidden('galleryEditFormGalleryName',['value' => $this->getUrl(2)]); ?>
						<?php else: ?>
							<?php echo template::speech($text['gallery_view']['edit'][12]); ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

		<div class="moduleVersion">
			<?php echo $text['gallery_view']['edit'][13]; echo $module::VERSION; ?>
		</div>
<?php echo template::formClose(); ?>
