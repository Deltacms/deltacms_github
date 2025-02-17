<?php echo template::formOpen('searchForm');
// Lexique
include('./module/search/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_search.php');
?>
	<div class="row">
		<div class="col10 offset1">
            <div class="row">
                <div class="col9 verticalAlignMiddle">
                    <?php echo template::text('searchMotphraseclef', [
                        'placeholder' => $this->getData(['module', $this->getUrl(0), 'config', 'placeHolder']) ? $this->getData(['module', $this->getUrl(0), 'config', 'placeHolder']):$text['search_view']['index'][0],
                        'value' => $module::$motclef
                    ]); ?>
                </div>
                <?php $col = empty($this->getData(['module', $this->getUrl(0), 'config', 'submitText'])) ? 'col1' : 'col3';?>
                <div class="<?php echo $col;?> verticalAlignMiddle">
                    <?php echo template::submit('pageEditSubmit', [
                        'value' => $this->getData(['module', $this->getUrl(0), 'config', 'submitText']),
                        'ico' => 'search'
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col12">
                    <?php echo template::checkbox('searchMotentier', true, $this->getData(['module', $this->getUrl(0), 'config', 'nearWordText']), [
                        'checked' => $module::$motentier
                    ]); 
					?>
                </div>
            </div>
		</div>
    </div>
    <?php if ( $module::$resultTitle ): ?>
        <div class="col12">
            <div class="block">
                <?php echo '<div class="blockTitle">'.$module::$resultTitle . '</div>'; ?>
                <?php if ($module::$resultList )
                            echo '<p>'.$module::$resultList.'</p>';
                ?>
                <?php if ($module::$resultError )
                            echo '<p>'.$module::$resultError.'</p>';
                ?>
            </div>
        </div>
    <?php endif; ?>
<?php echo template::formClose(); ?>
