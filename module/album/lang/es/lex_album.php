<?php
// Lexique du module álbum en espagnol
$text['album_view']['config'][0] = 'Atrás';
$text['album_view']['config'][1] = 'Ayuda';
$text['album_view']['config'][2] = 'Nuevo álbum';
$text['album_view']['config'][3] = 'Nombre';
$text['album_view']['config'][4] = 'Carpeta de destino';
$text['album_view']['config'][5] = 'Albums instalados';
$text['album_view']['config'][6] = "¿Está seguro de que desea eliminar este álbum?";
$text['album_view']['config'][7] = 'Sin galería';
$text['album_view']['config'][8] = 'Número de versión';
$text['album_view']['config'][9] = 'module/album/view/config/config.help_en.html';
$text['album_view']['config'][10] = 'Ayuda';

$text['album_view']['edit'][0] = 'Volver';
$text['album_view']['edit'][1] = 'Guardar';
$text['album_view']['edit'][2] = 'Configuración de imagen';
$text['album_view']['edit'][3] = 'Nombre';
$text['album_view']['edit'][4] = 'Carpeta de destino';
$text['album_view']['edit'][5] = 'Ordenación de imágenes';
$text['album_view']['edit'][6] = 'Ordenación manual: mueva las imágenes en la tabla de abajo. El pedido se guarda automáticamente.';
$text['album_view']['edit'][7] = 'Imagen';
$text['album_view']['edit'][8] = 'Portada';
$text['album_view']['edit'][9] = 'Título';
$text['album_view']['edit'][10] = 'Sin imagen.';
$text['album_view']['edit'][11] = 'Número de versión';

$text['album_view']['gallery'][0] = 'Atrás';
$text['album_view']['gallery'][1] = 'Geolocalización';

$text['album_view']['index'][0] = 'Sin álbum.';

$text['gallery']['config'][0] = '(carpeta vacía)';
$text['gallery']['config'][1] = '(carpeta no encontrada)';
$text['gallery']['config'][2] = 'Cambios guardados';
$text['gallery']['config'][3] = 'Configuración del módulo';
$text['gallery']['delete'][0] = 'Borrar no permitido';
$text['gallery']['delete'][1] = 'Album eliminado';
$text['gallery']['edit'][0] = 'Acción no permitida';
$text['gallery']['edit'][1] = 'Ediciones guardadas';

//Selects
if($param === "album_view"){
	$sort = [
		$module::SORT_ASC => 'Alfabético',
		$module::SORT_DSC => 'Alfabético inverso',
		$module::SORT_HAND => 'Manual'
	];
}
?>
