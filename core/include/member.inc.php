<?php
/* Copyright (C) 2017, Lionel Croquefer. GNU General Public License, version 3
 * script original, version 4 du 7 mai 2023
*/
// Lexique
include('./core/lang/'. $this->getData(['config', 'i18n', 'langAdmin']) . '/lex_core.php');
$du=$this->getInput('DELTA_USER_ID');
if(isset($du)){
	$container = 'site/file/source/membersDirectory/';
	if(!is_dir($container))mkdir($container,0705);
	$dir=$container.$du;
	if(!is_dir($dir))mkdir($dir,0705);
	$files = scandir($dir);
	if(count($files) > 2) {
		echo'<h3>'.$text['core']['showMemberFile'][0].ucfirst($du).'</h3>';
		function QE($fn){
			$in=finfo_open(FILEINFO_MIME_ENCODING);
			$ty=finfo_buffer($in,file_get_contents($fn));
			finfo_close($in);
			return in_array($ty,['utf-8','us-ascii']);
		}
		$width=560;
		$height=314;
		if(is_dir($dir)){
			if($dh=opendir($dir)){
				while(($file=readdir($dh))!==false){
					if(($file!='.')&&($file!='..')&&(filetype($dir.'/'.$file)=='file')){
						$ex = strtolower(strrchr($file,'.'));
						$fs=filesize($dir.'/'.$file);
						$fs=round($fs/1000);
						$nf=str_replace('_',' ',$file);
						$ob=$dir.'/'.$file;
						$dl='<a href="'.$ob.'" target="_blank" rel="noopener" title="'.$text['core']['showMemberFile'][3].'" class="download-link">'.$nf.'</a> : '.$fs.' Ko <br><br>';
						if (in_array ($ex, array ('.mp4','.m4v','.webm','.ogg'))){
							echo'<video src="'.$ob.'" width="'.$width.'" height="'.$height.'" preload="auto" controls></video><br>'.$dl.'<br>';
						} elseif($ex=='.mp3'){
							echo'<audio src="'.$ob.'" type="audio/mp3" preload="auto" controls></audio><br>'.$dl.'<br>';
						}
						elseif (in_array ($ex, array ('.gif','.jpg','.jpeg','.png','.webp'))){
							echo'<a href="'.$ob.'" title="'.$text['core']['showMemberFile'][4].'" data-lity><img src="'.$ob.'" alt="image" style="max-width: 25%; height: auto;"></a><br><br>';
						}
						elseif($ex=='.txt'){
							echo '<pre>';
							if(QE($ob)=='utf-8'){
								readfile($ob);
							} else {
								$te=file_get_contents($ob);print(helper::utf8Encode($te));
							}
							echo'</pre><br>'.$dl.'<br>';
						}
						else echo $text['core']['showMemberFile'][5].$dl.'<br>';
					}
				}
				closedir($dh);
			}
			clearstatcache();
		}
		echo'<p style="width:250px;border: 1px solid black;text-align:center;font-size:1.2em;background:#eee;"><a style="display:block;color:#333;" href="javascript:location.reload();">'.$text['core']['showMemberFile'][2].'</a></p>';
		//'<p style="border: 1px dotted black;text-align:center;font-size:0.9em;"> Fin de l\'espace privé </p>';
	} else {
		echo'<h3>'.$text['core']['showMemberFile'][1].ucfirst($du).'</h3>';
	}
}
?>
