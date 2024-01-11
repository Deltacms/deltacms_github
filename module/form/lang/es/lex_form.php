<?php
// Lexique du module Form en espagnol
$text['form_view']['config'][0] = 'Título';
$text['form_view']['config'][1] = 'No hay opción para este campo';
$text['form_view']['config'][2] = 'Lista de valores separados por comas (valor1,valor2,...)';
$text['form_view']['config'][3] = 'Campo obligatorio';
$text['form_view']['config'][4] = 'Atrás';
$text['form_view']['config'][5] = 'Administrar datos';
$text['form_view']['config'][6] = 'Configuración';
$text['form_view']['config'][7] = 'Dejar vacío para mantener el texto predeterminado.';
$text['form_view']['config'][8] = 'Enviar texto del botón';
$text['form_view']['config'][9] = 'Enviar por correo los datos ingresados:';
$text['form_view']['config'][10] = 'Seleccione al menos un grupo, usuario o ingrese un correo electrónico. Su servidor debe permitir el envío de correo.';
$text['form_view']['config'][11] = 'Dejar vacío para mantener el texto predeterminado.';
$text['form_view']['config'][12] = 'Asunto del correo';
$text['form_view']['config'][13] = 'A grupos desde ';
$text['form_view']['config'][14] = 'Editores = editores + administradores<br/> Miembros = miembros + editores + administradores';
$text['form_view']['config'][15] = 'Tiene un miembro';
$text['form_view']['config'][16] = 'A una dirección de correo electrónico';
$text['form_view']['config'][17] = 'Un correo electrónico o lista de correo';
$text['form_view']['config'][18] = 'Responder al remitente desde el correo de notificación';
$text['form_view']['config'][19] = 'Esta opción le permite responder directamente al remitente del mensaje si el remitente ha indicado un correo electrónico válido.';
$text['form_view']['config'][20] = 'Seleccionar tipo de firma';
$text['form_view']['config'][21] = 'Seleccionar logo del sitio';
$text['form_view']['config'][22] = 'Logotipo';
$text['form_view']['config'][23] = 'Seleccionar ancho de logo';
$text['form_view']['config'][24] = 'Redireccionamiento después del envío del formulario';
$text['form_view']['config'][25] = 'Seleccione una página del sitio:';
$text['form_view']['config'][26] = 'Validar un captcha para enviar el formulario.';
$text['form_view']['config'][27] = 'Lista de campos';
$text['form_view']['config'][28] = 'El formulario no contiene ningún campo.';
$text['form_view']['config'][29] = 'Número de versión';
$text['form_view']['config'][30] = 'Guardar';
$text['form_view']['config'][31] = 'Tamaño máximo de archivo adjunto';
$text['form_view']['config'][32] = 'Tipos de archivos permitidos';
$text['form_view']['config'][33] = 'jpg';
$text['form_view']['config'][34] = 'png';
$text['form_view']['config'][35] = 'pdf';
$text['form_view']['config'][36] = 'zip';
$text['form_view']['config'][37] = 'txt';
$text['form_view']['config'][38] = 'Anote en el campo de archivo la etiqueta del tipo y tamaño de los archivos autorizados. Las comprobaciones se realizan en archivos jpg, png, pdf y zip, pero no en archivos txt. Precaución !';
$text['form_view']['config'][39] = 'Ayuda';
$text['form_view']['config'][40] = 'module/form/view/config/config.help_en.html';
$text['form_view']['data'][0] = 'Atrás';
$text['form_view']['data'][1] = 'Borrar todo';
$text['form_view']['data'][2] = 'Exportar CSV';
$text['form_view']['data'][3] = 'Data';
$text['form_view']['data'][4] = 'Sin datos';
$text['form_view']['data'][5] = 'Número de versión';
$text['form_view']['data'][6] = "¿Está seguro de que desea eliminar estos datos?";
$text['form_view']['data'][7] = "¿Está seguro de que desea eliminar todos los datos?";
$text['form_view']['index'][0] = 'Enviar';
$text['form_view']['index'][1] = 'El formulario no contiene ningún campo.';
$text['form_view']['index'][2] = 'es';
$text['form']['config'][0] = 'Cambios guardados';
$text['form']['config'][1] = 'Configuración del módulo';
$text['form']['data'][0] = 'Datos registrados';
$text['form']['export2csv'][0] = 'Acción no permitida';
$text['form']['export2csv'][1] = 'Exportación CSV realizada en el administrador de archivos<br />bajo el nombre ';
$text['form']['export2csv'][2] = 'No hay datos para exportar';
$text['form']['deleteall'][0] = 'Acción no permitida';
$text['form']['deleteall'][1] = 'Datos eliminados';
$text['form']['deleteall'][2] = 'No hay datos para eliminar';
$text['form']['delete'][0] = 'Acción no permitida';
$text['form']['delete'][1] = 'Datos eliminados';
$text['form']['index'][0] = 'Captcha no válido';
$text['form']['index'][1] = 'Nuevo mensaje de su sitio';
$text['form']['index'][2] = 'Nuevo mensaje de la página "';
$text['form']['index'][3] = 'Formulario enviado';
$text['form']['index'][4] = 'El archivo adjunto no es una imagen';
$text['form']['índex'][5] = '?';
$text['form']['index'][6] = 'El tamaño del archivo excede ';
$text['form']['index'][7] = 'Este tipo de archivo no está permitido';
$text['form']['index'][8] = 'Error al cargar el archivo';
$text['form']['index'][9] = 'falló el mensaje no se envía porque ';
$text['form']['index'][10] = 'El adjunto no es un documento pdf';
$text['form']['index'][11] = 'El archivo adjunto no es un documento zip';
$text['form']['index'][12] = ' Complete el Captcha ';
// Initialisation de flatpickr
$lang_flatpickr = 'es';
// Langue d'administration pour tinymce
$lang_admin = 'es';
// Selects
$signature = [
	'text' => 'Nombre del sitio',
	'logo' => 'Logo del sitio'
];
if( $param === 'form_view'){
	$groupNews = [
		self::GROUP_MEMBER => 'Miembro',
		self::GROUP_EDITOR => 'Editor',
		self::GROUP_MODERATOR => 'Moderador',
		self::GROUP_ADMIN => 'Administrador'
	];
	$types = [
		$module::TYPE_LABEL => 'Etiqueta',
		$module::TYPE_TEXT => 'Campo de texto',
		$module::TYPE_TEXTAREA => 'Campo de texto grande',
		$module::TYPE_MAIL => 'Campo de correo',
		$module::TYPE_SELECT => 'Selección',
		$module::TYPE_CHECKBOX => 'Casilla',
		$module::TYPE_DATETIME => 'Fecha',
		$module::TYPE_FILE => 'archivo'
	];
}
?>