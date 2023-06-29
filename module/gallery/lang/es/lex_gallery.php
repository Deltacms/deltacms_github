<?php
// Lexique du module Gallery en espagnol
$text['gallery_view']['config'][0] = 'Atrás';
$text['gallery_view']['config'][1] = 'Tema';
$text['gallery_view']['config'][2] = 'Agregar galería';
$text['gallery_view']['config'][3] = 'Nombre';
$text['gallery_view']['config'][4] = 'Carpeta de destino';
$text['gallery_view']['config'][5] = 'Galerías instaladas';
$text['gallery_view']['config'][6] = 'Carpeta de destino';
$text['gallery_view']['config'][7] = 'Sin galería';
$text['gallery_view']['config'][8] = 'Número de versión';
$text['gallery_view']['config'][9] = "¿Está seguro de que desea eliminar esta galería?";
$text['gallery_view']['config'][10] = 'Ayuda';
$text['gallery_view']['config'][11] = 'module/gallery/view/config/config.help_en.html';
$text['gallery_view']['edit'][0] = 'Volver';
$text['gallery_view']['edit'][1] = 'Guardar';
$text['gallery_view']['edit'][2] = 'Configuración de imagen';
$text['gallery_view']['edit'][3] = 'Nombre';
$text['gallery_view']['edit'][4] = 'Carpeta de destino';
$text['gallery_view']['edit'][5] = 'Ordenación de imágenes';
$text['gallery_view']['edit'][6] = 'Ordenación manual: mueva las imágenes en la tabla de abajo. El pedido se guarda automáticamente.';
$text['gallery_view']['edit'][7] = 'Modo automático de pantalla completa';
$text['gallery_view']['edit'][8] = 'Al abrir la galería, la primera imagen se muestra en pantalla completa.';
$text['gallery_view']['edit'][9] = 'Imagen';
$text['gallery_view']['edit'][10] = 'Portada';
$text['gallery_view']['edit'][11] = 'Título';
$text['gallery_view']['edit'][12] = 'Sin imagen.';
$text['gallery_view']['edit'][13] = 'Número de versión';
$text['gallery_view']['gallery'][0] = 'Atrás';
$text['gallery_view']['index'][0] = 'Sin galería.';
$text['gallery_view']['theme'][0] = 'Atrás';
$text['gallery_view']['theme'][1] = 'Guardar';
$text['gallery_view']['theme'][2] = 'Miniaturas';
$text['gallery_view']['theme'][3] = 'La configuración del tema es común a los módulos del mismo tipo.';
$text['gallery_view']['theme'][4] = 'Ancho';
$text['gallery_view']['theme'][5] = 'Altura';
$text['gallery_view']['theme'][6] = 'Alineación';
$text['gallery_view']['theme'][7] = 'Margen';
$text['gallery_view']['theme'][8] = 'Borde';
$text['gallery_view']['theme'][9] = 'El control deslizante horizontal ajusta el nivel de transparencia.';
$text['gallery_view']['theme'][10] = 'Color del borde';
$text['gallery_view']['theme'][11] = 'Esquinas redondeadas';
$text['gallery_view']['theme'][12] = 'Sombra';
$text['gallery_view']['theme'][14] = 'Color de sombra';
$text['gallery_view']['theme'][15] = 'Opacidad de desplazamiento';
$text['gallery_view']['theme'][17] = 'Subtítulos';
$text['gallery_view']['theme'][19] = 'Texto';
$text['gallery_view']['theme'][21] = 'Fondo';
$text['gallery_view']['theme'][22] = 'Altura';
$text['gallery_view']['theme'][23] = 'Alineación';
$text['gallery_view']['theme'][24] = 'Número de versión';
$text['gallery']['config'][0] = '(carpeta vacía)';
$text['gallery']['config'][1] = '(carpeta no encontrada)';
$text['gallery']['config'][2] = 'Cambios guardados';
$text['gallery']['config'][3] = 'Configuración del módulo';
$text['gallery']['delete'][0] = 'Borrar no permitido';
$text['gallery']['delete'][1] = 'Galería eliminada';
$text['gallery']['edit'][0] = 'Acción no permitida';
$text['gallery']['edit'][1] = 'Ediciones guardadas';
$text['gallery']['theme'][0] = 'Acción no permitida';
$text['gallery']['theme'][1] = 'Cambios guardados';
$text['gallery']['theme'][2] = '¡Cambios no guardados!';
$text['gallery']['theme'][3] = 'Tema';
//Selects
if($param === "gallery_view"){
	$sort = [
		$module::SORT_ASC => 'Alfabético',
		$module::SORT_DSC => 'Alfabético inverso',
		$module::SORT_HAND => 'Manual'
	];
	$galleryThemeFlexAlign = [
		'flex-start' => 'Izquierda',
		'center' => 'Centro',
		'flex-end' => 'Derecha',
		'space-around' => 'Distribuido con márgenes',
		'space-between' => 'Distribuido sin margen',
	];
	$galleryThemeAlign = [
		'left' => 'Izquierda',
		'center' => 'Centro',
		'right' => 'Derecha'
	];
	$galleryThemeSizeWidth = [
		'9em' => 'Muy pequeño',
		'12' => 'Pequeño',
		'15em' => 'Promedio',
		'18em' => 'Grande',
		'21' => 'Muy grande',
		'100%' => 'Proporcional'
	];
	$galleryThemeSizeHeight = [
		'9em' => 'Muy pequeño',
		'12' => 'Pequeño',
		'15em' => 'Promedio',
		'18em' => 'Grande',
		'21' => 'Muy grande'
	];
	$galleryThemeLegendHeight = [
		'.125em' => 'Muy pequeño',
		'.25em' => 'Pequeño',
		'.375em' => 'Promedio',
		'.5em' => 'Grande',
		'.625em' => 'Muy grande'
	];
	$galleryThemeBorder = [
		'0em' => 'Ninguno',
		'.1em' => 'Muy bien',
		'.3em' => 'Bien',
		'.5em' => 'Promedio',
		'.7em' => 'Grueso',
		'.9em' => 'Muy grueso'
	];
	$galleryThemeOpacity = [
		'1' => 'Ninguno',
		'.9' => 'Muy discreto',
		'.8' => 'Discreto',
		'.7' => 'Promedio',
		'.6' => 'Fuerte',
		'.5' => 'Muy fuerte'
	];
	$galleryThemeMargin = [
		'0em' => 'Ninguno',
		'.1em' => 'Muy pequeño',
		'.3em' => 'Pequeño',
		'.5em' => 'Promedio',
		'.7em' => 'Grande',
		'.9em' => 'Muy grande'
	];
	$galleryThemeRadius = [
		'0em' => 'Ninguno',
		'.3em' => 'Muy ligero',
		'.6em' => 'Luz',
		'.9em' => 'Medio',
		'1.2em' => 'Importante',
		'1.5em' => 'Muy importante'
	];
	$galleryThemeShadows = [
		'0px' => 'Ninguno',
		'1px 1px 5px' => 'Muy ligero',
		'1px 1px 10px' => 'Luz',
		'1px 1px 15px' => 'Promedio',
		'1px 1px 25px' => 'Importante',
		'1px 1px 50px' => 'Muy importante'
	];
}
?>