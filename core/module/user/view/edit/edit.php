<?php echo template::formOpen('userEditForm');
// Lexique
include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');
?>
	<div class="row">
		<div class="col2">
		<?php if($this->getUser('group') === self::GROUP_ADMIN): ?>
				<?php echo template::button('userEditBack', [
					'class' => 'buttonGrey',
					'href' => helper::baseUrl() . 'user',
					'ico' => 'left',
					'value' => $text['core_user_view']['edit'][0]
				]); ?>
			<?php else: ?>
				<?php echo template::button('userEditBack', [
					'class' => 'buttonGrey',
					'href' => helper::baseUrl(false),
					'ico' => 'home',
					'value' => $text['core_user_view']['edit'][0]
				]); ?>
			<?php endif; ?>
		</div>
		<div class="col2 offset8">
			<?php echo template::submit('userEditSubmit', [
				'value'=> $text['core_user_view']['edit'][29]
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col6">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_user_view']['edit'][13]; ?></div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('userEditFirstname', [
							'autocomplete' => 'off',
							'disabled' => $this->getUser('group') > 2 ? false : true,
							'label' => $text['core_user_view']['edit'][2],
							'value' => $this->getData(['user', $this->getUrl(2), 'firstname'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('userEditLastname', [
							'autocomplete' => 'off',
							'disabled' => $this->getUser('group') > 2 ? false : true,
							'label' => $text['core_user_view']['edit'][3],
							'value' => $this->getData(['user', $this->getUrl(2), 'lastname'])
						]); ?>
					</div>
				</div>
				<?php echo template::text('userEditPseudo', [
					'autocomplete' => 'off',
					'label' => $text['core_user_view']['edit'][4],
					'value' => $this->getData(['user', $this->getUrl(2), 'pseudo'])
				]); ?>
				<?php echo template::select('userEditSignature', $signature, [
					'label' => $text['core_user_view']['edit'][5],
					'selected' => $this->getData(['user', $this->getUrl(2), 'signature'])
				]); ?>
				<?php echo template::mail('userEditMail', [
					'autocomplete' => 'off',
					'label' => $text['core_user_view']['edit'][6],
					'value' => $this->getData(['user', $this->getUrl(2), 'mail'])
				]); ?>
				<?php if($this->getUser('group') === self::GROUP_ADMIN): ?>
					<?php echo template::select('userEditGroup', $groupEdits, [
						'disabled' => ($this->getUrl(2) === $this->getUser('id')),
						'help' => ($this->getUrl(2) === $this->getUser('id') ? $text['core_user_view']['edit'][30] : ''),
						'label' => $text['core_user_view']['edit'][7],
						'selected' => $this->getData(['user', $this->getUrl(2), 'group'])
					]); ?>
					<div id="userEditMemberFiles" class="displayNone">
							 <?php echo template::checkbox('userEditFiles', true, $text['core_user_view']['edit'][8], [
									'checked' => $this->getData(['user', $this->getUrl(2), 'files']),
									'help' => $text['core_user_view']['edit'][9]
							]); ?>
					</div>
					<div id="userEditLabelAuth"><?php echo $text['core_user_view']['edit'][10]; ?></div>
					<ul id="userEditGroupDescription<?php echo self::GROUP_MEMBER; ?>" class="userEditGroupDescription displayNone">
						<li><?php echo $text['core_user_view']['edit'][11]; ?></li>
					</ul>
					<ul id="userEditGroupDescription<?php echo self::GROUP_EDITOR; ?>" class="userEditGroupDescription displayNone">
						<li><?php echo $text['core_user_view']['edit'][33]; ?></li>
						<li><?php echo $text['core_user_view']['edit'][34]; ?></li>
						<li><?php echo $text['core_user_view']['edit'][35]; ?></li>
					</ul>
					<ul id="userEditGroupDescription<?php echo self::GROUP_MODERATOR; ?>" class="userEditGroupDescription displayNone">
						<li><?php echo $text['core_user_view']['edit'][12]; ?></li>
						<li><?php echo $text['core_user_view']['edit'][14]; ?></li>
						<li><?php echo $text['core_user_view']['edit'][15]; ?></li>
					</ul>
					<ul id="userEditGroupDescription<?php echo self::GROUP_ADMIN; ?>" class="userEditGroupDescription displayNone">
						<li><?php echo $text['core_user_view']['edit'][16]; ?></li>
						<li><?php echo $text['core_user_view']['edit'][14]; ?></li>
						<li><?php echo $text['core_user_view']['edit'][15]; ?></li>
						<li><?php echo $text['core_user_view']['edit'][17]; ?></li>
						<li><?php echo $text['core_user_view']['edit'][18]; ?></li>
						<li><?php echo $text['core_user_view']['edit'][19]; ?></li>
						<li><?php echo $text['core_user_view']['edit'][20]; ?></li>
					</ul>
				<?php endif; ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_user_view']['edit'][21]; ?></div>
				<?php echo template::text('userEditId', [
					'autocomplete' => 'off',
					'help' => $text['core_user_view']['edit'][31],
					'label' => $text['core_user_view']['edit'][22],
					'readonly' => true,
					'value' => $this->getUrl(2)
				]); ?>
				<?php echo template::password('userEditOldPassword', [
					'autocomplete' => 'new-password', // remplace 'off' pour éviter le pré remplissage auto
					'label' => $text['core_user_view']['edit'][23]
				]); ?>
				<?php echo template::password('userEditNewPassword', [
					'autocomplete' => 'off',
					'label' => $text['core_user_view']['edit'][32]
				]); ?>
				<?php echo template::password('userEditConfirmPassword', [
					'autocomplete' => 'off',
					'label' => $text['core_user_view']['edit'][24]
				]); ?>
			</div>
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_user_view']['edit'][26]; ?></div>
				<?php $list = helper::arrayCollumn($module::$pagesList, 'title');
				ksort($list);
				echo template::select('userRedirectPageId', $list, [
						'label' => $text['core_user_view']['edit'][27],
						'selected' =>$this->getData(['user', $this->getUrl(2),'redirectPageId']),
						'help' =>  $text['core_user_view']['edit'][28]
				]); ?>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
