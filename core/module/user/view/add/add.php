<?php echo template::formOpen('userAddForm');
// Lexique
include('./core/module/user/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_user.php');
?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('userAddBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'user',
				'ico' => 'left',
				'value' => $text['core_user_view']['add'][0]
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('translateHelp', [
				'href' => 'https://doc.deltacms.fr/nouvel-utilisateur',
				'target' => '_blank',
				'ico' => 'help',
				'value' => $text['core_user_view']['add'][1],
				'class' => 'buttonHelp'
			]); ?>
		</div>
		<div class="col2 offset6">
			<?php echo template::submit('userAddSubmit', [
				'value'=> $text['core_user_view']['add'][29]
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col6">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_user_view']['add'][13]; ?></div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('userAddFirstname', [
							'autocomplete' => 'off',
							'label' => $text['core_user_view']['add'][2]
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('userAddLastname', [
							'autocomplete' => 'off',
							'label' => $text['core_user_view']['add'][3]
						]); ?>
					</div>
				</div>
				<?php echo template::text('userAddPseudo', [
					'autocomplete' => 'off',
					'label' => $text['core_user_view']['add'][4]
				]); ?>
				<?php echo template::select('userAddSignature', $signature, [
					'label' => $text['core_user_view']['add'][5],
					'selected' => 1
				]); ?>
				<?php echo template::mail('userAddMail', [
					'autocomplete' => 'off',
					'label' => $text['core_user_view']['add'][6]
				]); ?>
				<?php echo template::select('userAddGroup', $groupNews, [
					'label' => $text['core_user_view']['add'][7],
					'selected' => self::GROUP_MEMBER
				]); ?>
				<div id="userAddMemberFiles" class="displayNone">
					<?php echo template::checkbox('userAddFiles', true, $text['core_user_view']['add'][8] , [
							'checked' => false,
							'help' => $text['core_user_view']['add'][9]
					]); ?>
				</div>
				<?php echo $text['core_user_view']['add'][10]; ?>
				<ul id="userAddGroupDescription<?php echo self::GROUP_MEMBER; ?>" class="userAddGroupDescription displayNone">
					<li><?php echo $text['core_user_view']['add'][11]; ?></li>
				</ul>
				<ul id="userAddGroupDescription<?php echo self::GROUP_EDITOR; ?>" class="userAddGroupDescription displayNone">
					<li><?php echo $text['core_user_view']['add'][30]; ?></li>
					<li><?php echo $text['core_user_view']['add'][31]; ?></li>
					<li><?php echo $text['core_user_view']['add'][32]; ?></li>
				</ul>
				<ul id="userAddGroupDescription<?php echo self::GROUP_MODERATOR; ?>" class="userAddGroupDescription displayNone">
					<li><?php echo $text['core_user_view']['add'][12]; ?></li>
					<li><?php echo $text['core_user_view']['add'][14]; ?></li>
					<li><?php echo $text['core_user_view']['add'][15]; ?></li>
				</ul>
				<ul id="userAddGroupDescription<?php echo self::GROUP_ADMIN; ?>" class="userAddGroupDescription displayNone">
					<li><?php echo $text['core_user_view']['add'][16]; ?></li>
					<li><?php echo $text['core_user_view']['add'][14]; ?></li>
					<li><?php echo $text['core_user_view']['add'][15]; ?></li>
					<li><?php echo $text['core_user_view']['add'][17]; ?></li>
					<li><?php echo $text['core_user_view']['add'][18]; ?></li>
					<li><?php echo $text['core_user_view']['add'][19]; ?></li>
					<li><?php echo $text['core_user_view']['add'][20]; ?></li>
				</ul>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_user_view']['add'][21]; ?></div>
				<?php echo template::text('userAddId', [
					'autocomplete' => 'off',
					'label' => $text['core_user_view']['add'][22]
				]); ?>
				<?php echo template::password('userAddPassword', [
					'autocomplete' => 'off',
					'label' => $text['core_user_view']['add'][23]
				]); ?>
				<?php echo template::password('userAddConfirmPassword', [
					'autocomplete' => 'off',
					'label' => $text['core_user_view']['add'][24]
				]); ?>
				<?php echo template::checkbox('userAddSendMail', true,
				 $text['core_user_view']['add'][25]);
				?>
			</div>
			<div class="block">
				<div class="blockTitle"><?php echo $text['core_user_view']['add'][26]; ?></div>
				<?php echo template::select('userRedirectPageId', helper::arrayCollumn($module::$pagesList, 'title'), [
						'label' => $text['core_user_view']['add'][27],
						'selected' =>$this->getData(['user', $this->getUrl(2),'redirectPageId']),
						'help' => $text['core_user_view']['add'][28]
				]); ?>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>
