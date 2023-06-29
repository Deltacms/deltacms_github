<?php
include('./module/redirection/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_redirection.php');
// Passage des valeurs à index.js.php
?>
<script>
	var textConfig = <?php echo '"'.$text['redirection_view']['index'][0] .'"' ;  ?>;
</script>
