<?php
// Lexique
include('./core/module/page/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_page.php');

$initSnipcart = false;
if ($this->getData(['page', $this->getUrl(2), 'moduleId']) === 'snipcart' ) $initSnipcart = true;
?>
<script>
var lang_admin = "<?php echo $lang_admin; ?>";
var lang_flatpickr = "<?php echo $lang_flatpickr; ?>";
var initSnipcart = "<?php echo $initSnipcart; ?>";
</script>
<?php
echo template::formOpen('pageEditForm'); ?>
	<div class="row">
		<div class="col2">
			<?php $href = helper::baseUrl() . $this->getUrl(2); ?>
			<?php if ($this->getData(['page', $this->getUrl(2), 'moduleId']) === 'redirection' || 'code')$href = helper::baseUrl(); ?>
			<?php echo template::button('pageEditBack', [
				'class' => 'buttonGrey',
				'href' => $href,
				'ico' => 'left',
				'value' => $text['core_page_view']['edit'][0]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('pageEditHelp', [
				'href' => 'https://doc.deltacms.fr/edition',
				'target' => '_blank',
				'ico' => 'help',
				'value' => $text['core_page_view']['edit'][1],
				'class' => 'buttonHelp'
			]); ?>
		</div>
		<div class="col2 offset2">
			<?php if($this->getUser('group') >= self::GROUP_MODERATOR) { echo template::button('pageEditDuplicate', [
				'href' => helper::baseUrl() . 'page/duplicate/' . $this->getUrl(2) . '&csrf=' . $_SESSION['csrf'],
				'value' => $text['core_page_view']['edit'][2],
				'ico' => 'clone'
			]); } ?>
		</div>
		<div class="col2">
			<?php if($this->getUser('group') >= self::GROUP_MODERATOR) { echo template::button('pageEditDelete', [
				'class' => 'buttonRed',
				'href' => helper::baseUrl() . 'page/delete/' . $this->getUrl(2) . '&csrf=' . $_SESSION['csrf'],
				'value' => $text['core_page_view']['edit'][3],
				'ico' => 'cancel'
			]); } ?>
		</div>
		<div class="col2">
			<?php echo template::submit('pageEditSubmit', [
				'uniqueSubmission' => true,
				'value' => $text['core_page_view']['edit'][4]
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block" id="info">
				<div class="blockTitle"><?php echo $text['core_page_view']['edit'][5]; ?>
					<span id="specialeHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/informations-generales" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				 </div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('pageEditTitle', [
							'label' => $text['core_page_view']['edit'][6],
							'value' => $this->getData(['page', $this->getUrl(2), 'title'])
						]); ?>
					</div>
					<div class="col2">
								<?php echo template::text('pageEditShortTitle', [
									'label' => $text['core_page_view']['edit'][7],
									'value' => $this->getData(['page', $this->getUrl(2), 'shortTitle']),
									'help' => $text['core_page_view']['edit'][8]
								]); ?>
							</div>
					<div class="col4">
						<div class="row" <?php if($this->getUser('group') < self::GROUP_MODERATOR) { echo 'style="display: none;"'; } ?>>
							<div class="col9">
								<?php echo template::hidden('pageEditModuleRedirect'); ?>
								<?php echo template::select('pageEditModuleId', $module::$moduleIds, [
									'help' => $text['core_page_view']['edit'][9],
									'label' => $text['core_page_view']['edit'][10],
									'selected' => $this->getData(['page', $this->getUrl(2), 'moduleId'])
								]); ?>
								<?php echo template::hidden('pageEditModuleIdOld',['value' => $this->getData(['page', $this->getUrl(2), 'moduleId'])]); ?>
								<?php echo template::hidden('pageEditModuleIdOldText',[
									'value' => array_key_exists($this->getData(['page', $this->getUrl(2), 'moduleId']),$module::$moduleIds)? $module::$moduleIds[$this->getData(['page', $this->getUrl(2), 'moduleId'])] : ucfirst($this->getData(['page', $this->getUrl(2), 'moduleId']))
								]); ?>
							</div>
							<?php if( null !== $this->getData(['page', $this->getUrl(2), 'moduleId']) && $this->getData(['page', $this->getUrl(2), 'moduleId']) !== '' ) { ?>
								<div class="col3 verticalAlignBottom">
								<?php echo template::button('pageEditModuleConfig', [
									'uniqueSubmission' => true,
									'value' => template::ico('gear')
								]); ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::select('pageTypeMenu', $typeMenu,[
								'label' => $text['core_page_view']['edit'][11],
								'selected' => $this->getData(['page', $this->getUrl(2), 'typeMenu'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::file('pageIconUrl', [
							'help' => $text['core_page_view']['edit'][12],
							'label' => $text['core_page_view']['edit'][13],
							'value' => $this->getData(['page', $this->getUrl(2), 'iconUrl'])
						]); ?>
					</div>
					<div class="col4">
					<?php echo template::select('configModulePosition', $modulePosition,[
							'help' => $text['core_page_view']['edit'][14],
							'label' => $text['core_page_view']['edit'][15],
							'selected' => $this->getData(['page', $this->getUrl(2), 'modulePosition'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<?php echo template::textarea('pageEditContent', [
				'class' => 'editorWysiwyg',
				//'value' => file_get_contents(self::DATA_DIR . self::$i18n . '/content/' .  $this->getData(['page', $this->getUrl(2), 'content']))
				'value' => $this->getPage($this->getUrl(2), self::$i18n)
			]); ?>
		</div>
	</div>
<?php
if($this->getUser('group') < self::GROUP_MODERATOR) {
	echo '<div style="display: none;">';
}
else {
	echo '<div style="display: block;">';
}
?>
	<div class="row pageEditCommentRow">
	<div class="col12" >
		<div class="block">
			<div class="blockTitle"><?php echo $text['core_page_view']['edit'][47]; ?>
				<span id="specialeHelpButton" class="helpDisplayButton">
					<a href="https://doc.deltacms.fr/commentaires-de-page" target="_blank">
						<?php echo template::ico('help', 'left');?>
					</a>
				</span>
			</div>
			<div class="blockContainer">
					<div class="row">
						<div class="col4">
							<?php echo template::checkbox('pageEditCommentEnable', true, $text['core_page_view']['edit'][50], [
								'checked' => $this->getData(['page', $this->getUrl(2), 'commentEnable']),
								'help' => $text['core_page_view']['edit'][46]
							]); ?>
						</div>
						<div class="col4 pageCommentEnable">
							<?php echo template::button('pageEditCommentConfig', [
								'href' => helper::baseUrl() . 'config',
								'ico' => 'cogs',
								'value' => $text['core_page_view']['edit'][48]
							]); ?>
						</div>
						<div class="col4 pageCommentEnable">
							<?php echo template::button('pageEditCommentManage', [
								'href' => helper::baseUrl() . 'page/comment/' . $this->getUrl(2),
								'ico' => 'gear',
								'value' => $text['core_page_view']['edit'][49]
							]); ?>
						</div>
					</div>
			</div>
		</div>
	</div>
	</div>
	<div class="row">
		<div class="col12" id="pageEditBlockLayout">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_page_view']['edit'][16]; ?>
					<span id="specialeHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/mise-en-page" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="blockContainer">
					<div class="row">
						<div class="col6">
							<div class="row">
								<div class="col12">
									<?php echo template::select('pageEditBlock', $pageBlocks, [
											'label' => $text['core_page_view']['edit'][17],
											'help' => $text['core_page_view']['edit'][18],
											'selected' => $this->getData(['page', $this->getUrl(2) , 'block'])
									]); ?>
								</div>
							</div>
						</div>
						<div class="col6">
							<!-- Sélection des barres latérales	 -->
							<?php if($this->getHierarchy($this->getUrl(2),false,true)): ?>
								<?php echo template::hidden('pageEditBarLeft', [
									'value' => $this->getData(['page', $this->getUrl(2), 'barLeft'])
								]); ?>
							<?php else: ?>
								<?php echo template::select('pageEditBarLeft', $module::$pagesBarId, [
									'label' => $text['core_page_view']['edit'][19],
									'selected' => $this->getData(['page', $this->getUrl(2), 'barLeft'])
								]); ?>
							<?php endif; ?>
							<?php if($this->getHierarchy($this->getUrl(2),false,true)): ?>
								<?php echo template::hidden('pageEditBarRight', [
									'value' => $this->getData(['page', $this->getUrl(2), 'barRight'])
								]); ?>
							<?php else: ?>
								<?php echo template::select('pageEditBarRight', $module::$pagesBarId, [
									'label' => $text['core_page_view']['edit'][20],
									'selected' => $this->getData(['page', $this->getUrl(2), 'barRight'])
								]); ?>
							<?php endif; ?>
							<?php echo template::select('pageEditDisplayMenu', $displayMenu, [
								'label' => $text['core_page_view']['edit'][21],
								'selected' => $this->getData(['page', $this->getUrl(2), 'displayMenu']),
								'help' => $text['core_page_view']['edit'][22]
							]); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12"  id="pageEditMenu">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_page_view']['edit'][23]; ?>
					<span id="specialeHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/emplacement-dans-le-menu" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="blockContainer">
					<div class="row">
						<div class="col6">
							<?php echo template::select('pageEditPosition', [], [
								'label' => $text['core_page_view']['edit'][24],
								'help' => $text['core_page_view']['edit'][25]
							]); ?>
						</div>
						<div class="col6">
							<?php	if($this->getHierarchy($this->getUrl(2), false)): ?>
								<?php echo template::hidden('pageEditParentPageId', [
									'value' => $this->getData(['page', $this->getUrl(2), 'parentPageId'])
								]); ?>
							<?php else: ?>
								<?php echo template::select('pageEditParentPageId', $module::$pagesNoParentId, [
									'label' => $text['core_page_view']['edit'][26],
									'selected' => $this->getData(['page', $this->getUrl(2), 'parentPageId'])
								]); ?>
							<?php endif; ?>
						</div>
					</div>

					<div class="row">
						<div class="col6">
							<?php echo template::checkbox('pageEditDisable', true, $text['core_page_view']['edit'][37], [
								'checked' => $this->getData(['page', $this->getUrl(2), 'disable']),
								'help' => $text['core_page_view']['edit'][27]
							]); ?>
						</div>
						<div class="col6">
							<?php echo template::checkbox('pageEditTargetBlank', true, $text['core_page_view']['edit'][38], [
								'checked' => $this->getData(['page', $this->getUrl(2), 'targetBlank'])
							]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col6">
								<?php echo template::checkbox('pageEditHideTitle', true, $text['core_page_view']['edit'][39], [
									'checked' => $this->getData(['page', $this->getUrl(2), 'hideTitle'])
								]); ?>
						</div>
						<div class="col6">
							<?php echo template::checkbox('pageEditbreadCrumb', true, $text['core_page_view']['edit'][40], [
								'checked' => $this->getData(['page', $this->getUrl(2), 'breadCrumb']),
								'help' => $text['core_page_view']['edit'][28]
							]); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class='row' id="pageEditAdvancedWrapper">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_page_view']['edit'][29]; ?>
					<span id="specialeHelpButton" class="helpDisplayButton">
						<a href="https://doc.deltacms.fr/options-d-emplacement-avancees" target="_blank">
							<?php echo template::ico('help', 'left');?>
						</a>
					</span>
				</div>
				<div class="blockContainer">
					<div class="row">
						<div class="col6">
								<?php echo template::checkbox('pageEditHideMenuChildren', true, $text['core_page_view']['edit'][30], [
									'checked' => $this->getData(['page', $this->getUrl(2), 'hideMenuChildren'])
								]); ?>
						</div>
						<div class="col6">
								<?php echo template::checkbox('pageEditHideMenuSide', true, $text['core_page_view']['edit'][31] , [
									'checked' => $this->getData(['page', $this->getUrl(2), 'hideMenuSide']),
									'help' => $text['core_page_view']['edit'][32]
								]); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class='row' id="pageEditSeoWrapper">
		<div class="col12">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_page_view']['edit'][33]; ?>
				<span id="specialeHelpButton" class="helpDisplayButton">
					<a href="https://doc.deltacms.fr/permission-et-referencement" target="_blank">
						<?php echo template::ico('help', 'left');?>
					</a>
				</span>
				</div>
				<div class="blockContainer">
					<div class="row">
						<div class='col4'>
							<?php echo template::select('pageEditGroup', $groupPublics, [
								'label' => $text['core_page_view']['edit'][34],
								'selected' => $this->getData(['page', $this->getUrl(2), 'group'])
							]); ?>
						</div>
						<div class='col4'>
							<?php 
							$selectedId = $this->getData(['page', $this->getUrl(2), 'member' ]);
							if( $selectedId === 'allMembers'){
								$selected = 0;
							} else {
								$tab =  array_flip($module::$memberIds);
								$selected =$tab[$selectedId];
							}
							echo template::select('pageEditMember', $module::$memberIds, [
								'label' => $text['core_page_view']['edit'][51],
								'selected' => $selected
							]); ?>
						</div>
						<div class='col4'>
							<?php if( $this->getUser('group') === self::GROUP_MODERATOR ) $groupEdit = $groupEditModerator;
							echo template::select('pageEditGroupEdit', $groupEdit, [
								'label' => $text['core_page_view']['edit'][44],
								'selected' => $this->getData(['page', $this->getUrl(2), 'groupEdit'])
							]); ?>
						</div>
					</div>
					<div class="row">
						<div class='col4'>
							<?php echo template::checkbox('pageEditMemberFileEnable', true, $text['core_page_view']['edit'][52], [
								'checked' => $this->getData(['page', $this->getUrl(2), 'memberFile']),
								'help' => $text['core_page_view']['edit'][53]
							]); ?>
						</div>
					</div>
					<div class="row">
						<div class='col12'>
							<?php echo template::text('pageEditMetaTitle', [
								'label' => $text['core_page_view']['edit'][35],
								'value' => $this->getData(['page', $this->getUrl(2), 'metaTitle'])
							]); ?>
							<?php echo template::textarea('pageEditMetaDescription', [
								'label' => $text['core_page_view']['edit'][36],
								//'maxlength' => '500',
								'value' => $this->getData(['page', $this->getUrl(2), 'metaDescription'])
							]); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- conditionnelle -->
<?php echo template::formClose(); ?>

<script>
	var textConfirm = <?php echo '"'.$text['core_page_view']['edit'][41].'"'; ?>;
	var text1Confirm = <?php echo '"'.$text['core_page_view']['edit'][42].'"'; ?>;
	var text2Confirm = <?php echo '"'.$text['core_page_view']['edit'][43].'"'; ?>;
</script>
