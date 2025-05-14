<!DOCTYPE html>
<html lang="<?=$this->getData(['config', 'i18n', 'langAdmin'])?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <title><?=$subject?></title>
  <style>
	body {
	  margin: 0;
	  padding: 20px;
	  font-family: sans-serif;
	  font-size: 14px;
	  line-height: 1.5;
	  color: #000;
	  background-color: #fff;
	}
	.container {
	  max-width: 600px;
	  margin: 0 auto;
	}
	.footer {
	  margin-top: 40px;
	  font-size: 12px;
	  color: #666;
	  text-align: center;
	}
	a {
	  color: #05c;
	  text-decoration: none;
	}
  </style>
</head>
<body>
  <div class="container">
	<h2 style="font-size: 18px;"><?=htmlspecialchars($subject)?></h2>
	<div>
	  <?=nl2br($content)?>
	</div>
	<div class="footer">
	  <p>
		<a href="<?=helper::baseUrl(false)?>" target="_blank">
		<?php
		if( null !== $this->getData(['module', $this->getUrl(0), 'config', 'signature' ]) && $this->getData(['module', $this->getUrl(0), 'config', 'signature' ]) === 'logo' && is_file( 'site/file/source/'. $this->getData(['module', $this->getUrl(0), 'config', 'logoUrl' ]))){
			$imageFile = helper::baseUrl(false).'site/file/source/'. $this->getData(['module', $this->getUrl(0), 'config', 'logoUrl' ]) ;
			?><img src="<?=$imageFile?>" alt="logo" style="width: <?=$this->getData(['module', $this->getUrl(0), 'config', 'logoWidth'])?>%;">
		<?php
		}
		else{
			echo $this->getData(['locale', 'title']);
		} ?>
		</a>
	  </p>
	</div>
  </div>
</body>
</html>
