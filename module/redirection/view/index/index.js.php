
/**
 * This file is part of DeltaCMS.
 */

 if (document.referrer.indexOf("edit") === -1)
 {
  	core.confirm(	
  		textConfig,
   		function() {
  			$(location).attr("href", "<?php echo helper::baseUrl(); ?>page/edit/<?php echo $this->getUrl(0); ?>");
  		},
  		function() {
  			$(location).attr("href", "<?php echo helper::baseUrl() . $this->getUrl(); ?>/force");
  		}
  	);
  }
  else
  {
  	$(location).attr("href", "<?php echo helper::baseUrl(); ?>");
  }
