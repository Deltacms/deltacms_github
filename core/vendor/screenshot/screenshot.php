<?php  
	
	if (isset($_POST['image'])) {  
 
			$data = $_POST['image'] ;
			$data = str_replace(' ','+',$data);	
			$data = str_replace('data:image/jpeg;base64,', '', $data);		
			$img = base64_decode($data);
			
			// Effacer l'image et la miniature jpg
			if (file_exists('../../../site/file/thumb/screenshot.jpg')) {
				chmod('../../../site/file/thumb/screenshot.jpg', 0777); 
				unlink ('../../../site/file/thumb/screenshot.jpg');
			}
			if (file_exists('../../../site/file/source/screenshot.jpg')) {
				chmod('../../../site/file/source/screenshot.jpg', 0777);
				unlink ('../../../site/file/source/screenshot.jpg');
			}
			
			file_put_contents('../../../site/file/source/screenshot.jpg',$img) ;

	}   
?> 
  