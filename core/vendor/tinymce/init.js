/**

 * Initialisation de TinyMCE

 */

 /**
  * Quand tinyMCE est invoqué hors connexion, initialiser privateKey
  */
if ( typeof(privateKey) == 'undefined') {
	var privateKey = null;
};
if ( typeof(lang_admin) == 'undefined') {
	var lang_admin = "fr_FR";
};

var blockFormats ='Paragraph=p; Header 1=h1; Header 2=h2; Header 3=h3; Header 4=h4; div=div; pre=pre';
switch (lang_admin) {
  case 'fr_FR':
    blockFormats ='Paragraphe=p; Titre 1=h1; Titre 2=h2; Titre 3=h3; Titre 4=h4; div=div; pre=pre';
    break;
  case 'es':
	blockFormats ='Párrafo=p; Título 1=h1; Título 2=h2; Título 3=h3; Título 4=h4; div=div;pre=pre';
    break;
}

var blockFormatsComment ='Paragraph=p; H1=h1; H2=h2; H3=h3;';
switch (lang_admin) {
  case 'fr_FR':
    blockFormatsComment ='Paragraphe=p; Titre 1=h1; Titre 2=h2; Titre 3=h3;';
    break;
  case 'es':
	blockFormatsComment ='Párrafo=p; Título 1=h1; Título 2=h2; Título 3=h3;';
    break;
}

// Pour autoriser le menu et la barre sticky (par défaut)
if ( typeof(okSticky) == 'undefined') {
	var okSticky = true;
};

// Pour définir la hauteur minimale
if ( typeof(tinyMiniHeight) == 'undefined') {
	var tinyMiniHeight = 500;
};

// Pour la class dans le body de l'iframe
if ( typeof(bodyIframe) == 'undefined') {
	var bodyIframe = "editorWysiwyg";
};

// Adaptations pour la saisie des news
if ( typeof(newsAddEdit) == 'undefined') {
	var newsAddEdit = false;
};
if(newsAddEdit){
	var content_css = [ baseUrl + "core/layout/common.css",baseUrl + "core/layout/mediaqueries.css",baseUrl + "core/vendor/tinymce/content.css",baseUrl + "site/data/theme.css",baseUrl + "site/data/news/themeNews.css",baseUrl + "site/data/custom.css"];
} else {
	var content_css = [baseUrl + "core/layout/common.css",baseUrl + "core/layout/mediaqueries.css",baseUrl + "core/vendor/tinymce/content.css",baseUrl + "site/data/theme.css",baseUrl + "site/data/custom.css"];
}
newAddEdit = false;
var pluginsList = "advlist anchor autolink autosave autoresize codemirror fullscreen hr image link lists media nonbreaking paste searchreplace tabfocus table template";
var toolbarList = "restoredraft | undo redo | formatselect bold italic underline forecolor backcolor | fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist | table template | image media link | code fullscreen";
// Vocabulaire pour templates description
switch (lang_admin) {
	case 'fr_FR':
		var blocktext = "Bloc de texte";
		var blocktextnotitle = "Bloc de texte sans titre";
		var blocks_text = "Blocs de texte";
		var blocktexts = " blocs de texte";
		var title = " avec un titre.";
		var widthtitle = ", de même hauteur, avec un titre en ligne.";
		var widthtitleassym = ", de même hauteur, assymétriques, avec un titre en ligne.";
		var accordion = "Effet accordéon : ";
		var accordionblock = "Bloc de texte avec effet accordéon à ";
		var paragraph = " paragraphes.";
		var symgrid = "Grille symétrique : ";
		var asymgrid = "Grille assymétrique : ";
		var desgrid = "Grille adaptative sur 12 colonnes, sur mobile elles passent les unes en dessous des autres.";
		var colorbox = "Bloc coloré";
		var colorboxwide = "Bloc coloré pleine largeur";
		var imagewide = "Image pleine largeur";
		var descolorbox = "Bloc coloré aligné avec les textes.";
		var descolorboxwide = "Bloc coloré sans marge quelque soit l'écran.";
		var desimagewide = "Image sans marge quelque soit l'écran.";
    break;
	case 'en_GB':
		var blocktext = "Text Block";
		var blocktextnotitle = "Untitled block of text";
		var blocks_text = "Text blocks";
		var blocktexts = " text blocks";
		var title = " with a title.";
		var widthtitle = ", same height, with inline title.";
		var widthtitleassym = ", same height, asymmetric, with inline title.";
		var accordion = "Accordion effect : ";
		var accordionblock = "Text block with accordion effect with ";
		var paragraph = " paragraphs.";
		var symgrid = "Symmetrical grid : ";
		var asymgrid = "Asymmetric grid : ";
		var desgrid = "Adaptive grid on 12 columns, on mobile they pass one below the other.";
		var colorbox = "Colored box";
		var colorboxwide = "Full width colored box";
		var imagewide = "Full width image";
		var descolorbox = "Colored box aligned with the texts.";
		var descolorboxwide = "Colored box without borders whatever the screen.";
		var desimagewide = "Borderless image whatever the screen.";
    break;
	case 'es':
		var blocktext = "Bloque de texto";
		var blocktextnotitle = "Bloque de texto sin título";
		var blocks_text = "Bloques de texto";
		var blocktexts = " bloques de texto";
		var title = " con un título.";
		var widthtitle = ", misma altura, con título en línea.";
		var widthtitleassym = ", misma altura, asimétrica, con título en línea.";
		var accordion = "Efecto acordeón : ";
		var accordionblock = "Bloque de texto con efecto acordeón de ";
		var paragraph = " párrafos.";
		var symgrid = "Cuadrícula simétrica : ";
		var asymgrid = "Cuadrícula asimétrica : ";
		var desgrid = "Cuadrícula adaptativa de 12 columnas, en dispositivos móviles pasan una debajo de la otra.";
		var colorbox = "Cuadro de color";
		var colorboxwide = "Cuadro coloreado de ancho completo";
		var imagewide = "Imagen de ancho completo";
		var descolorbox = "Cuadro coloreado alineado con los textos.";
		var descolorboxwide = "Cuadro coloreado sin bordes sea cual sea la pantalla.";
		var desimagewide = "Imagen sin bordes en cualquier pantalla.";
    break;
}
var templatesList = [
		{
			title: blocktext,
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/1block.html",
			description: blocktext + title
		},
		{
			title: blocks_text +" : 6 - 6",
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/2blocks.html",
			description: "2" +  blocktexts + widthtitle
		},
		{
			title: blocks_text +" : 4 - 4 - 4",
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/3blocks.html",
			description: "3"+ blocktexts + widthtitle
		},
		{
			title: blocks_text +" : 3 - 6 - 3",
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/363blocks.html",
			description: "3"+ blocktexts + widthtitleassym
		},
		{
			title: blocks_text +" : 3 - 3 - 3 - 3",
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/4blocks.html",
			description: "4"+ blocktexts + widthtitle
		},
		{
			title: blocktextnotitle,
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/1block-notitle.html",
			description: blocktextnotitle
		},
		{
			title: colorbox,
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/colorbox.html",
			description: descolorbox
		},
		{
			title: colorboxwide,
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/colorboxFullWidth.html",
			description: descolorboxwide
		},
		{
			title: imagewide,
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/imagefullwidth.html",
			description: desimagewide
		},
		{
			title: accordion +"2",
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/accordion.html",
			description: accordionblock +"2"+ paragraph
		},
		{
			title: accordion +"3",
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/accordion3.html",
			description: accordionblock +"3"+ paragraph
		},
		{
			title: accordion +"4",
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/accordion4.html",
			description: accordionblock +"4"+ paragraph
		},
		{
			title: symgrid +"6 - 6",
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/col6.html",
			description: desgrid
		},
		{
			title: symgrid +"4 - 4 - 4",
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/col444.html",
			description: desgrid
		},
		{
			title: symgrid +"3 - 3 - 3 - 3",
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/col3.html",
			description: desgrid
		},
		{
			title: asymgrid +"4 - 8",
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/col4-8.html",
			description: desgrid
		},
		{
			title: asymgrid +"8 - 4",
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/col8-4.html",
			description: desgrid
		},
		{
			title: asymgrid +"2 - 10",
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/col2-10.html",
			description: desgrid
		},
		{
			title: asymgrid +"10 - 2",
			url: baseUrl + "core/vendor/tinymce/templates/" + lang_admin + "/col10-2.html",
			description: desgrid
		}
	];

var offsetToolbar = 45;
if( document.documentElement.clientWidth < 800 ) offsetToolbar = 80;

tinymce.init({
	// Classe où appliquer l'éditeur
	selector: ".editorWysiwyg",
	setup:function(ed) {
		// Aperçu dans le pied de page
		ed.on('change', function(e) {
			if (ed.id === 'themeFooterText') {
				$("#footerText").html(tinyMCE.get('themeFooterText').getContent());
			}
			if (ed.id === 'themeHeaderText') {
				$("#featureContent").html(tinyMCE.get('themeHeaderText').getContent());
			}
		});
		// Suppression des normes de balisage xhtml
		ed.on('GetContent', function (e) {
			e.content = e.content.replace(/ \/>/g, '>');
			e.content = e.content.replace(/(height|width)="(\d+)px"/g, '$1="$2"');
			e.content = e.content.replace(/(controls)(="controls")/g, '$1');
		});
		// Ajout d'un espace insécable à la suite d'une image à sa création
		ed.on('NodeChange', function (e) {
		  if (e.element.nodeName === 'IMG') {
			const parentElement = e.element.parentNode;
			if (parentElement && parentElement.nodeName === 'P' && parentElement.textContent === '') {
				parentElement.innerHTML += '\u00A0';
			}
		  }
		});
	},
	// Mode d'affichage de la barre d'outils
	toolbar_mode: 'wrap',
	toolbar_sticky: okSticky,
	toolbar_sticky_offset: offsetToolbar,
	// Langue
	language: lang_admin,

	// Plugins
	plugins: pluginsList,
	// Contenu de la barre d'outils
	toolbar: toolbarList,
	fontsize_formats: "8px 9px 10px 11px 12px 13px 14px 15px 16px 18px 20px 24px 30px 36px 48px 60px 72px 96px",
	menubar: 'file edit insert view format tools',
	menu: {
		file: { title: 'File', items: 'newdocument restoredraft | preview | export print | deleteallconversations' },
		edit: { title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall | searchreplace' },
		view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen | showcomments' },
		insert: { title: 'Insert', items: 'image link media addcomment pageembed template codesample inserttable | charmap hr | pagebreak nonbreaking anchor tableofcontents | insertdatetime' },
		format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | blocks align | forecolor backcolor | language | removeformat' },
		tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | a11ycheck code ' },
		table: { title: 'Table', items: '' },
		help: { title: 'Help', items: '' }
	},
	//Autoresize
    autoresize_overflow_padding: 0,
    autoresize_bottom_margin: 0,
	// Hauteur minimale en pixels de la zone d'édition
	min_height: tinyMiniHeight,
	// CodeMirror
	codemirror: {
		indentOnInit: true, // Whether or not to indent code on init.
		path: 'codemirror', // Path to CodeMirror distribution
		saveCursorPosition: false,    // Insert caret marker
		config: {           // CodeMirror config object
			/*theme: 'ambiance',*/
			fullscreen: true,
			/*mode: 'application/x-httpd-php',*/
			indentUnit: 4,
			lineNumbers: true,
			mode: "htmlmixed",
		},
		jsFiles: [
			'mode/php/php.js',
			'mode/css/css.js',
			'mode/htmlmixed/htmlmixed.js',
			'mode/htmlembedded/htmlembedded.js',
			'mode/javascript/javascript.js',
			'mode/xml/xml.js',
			'addon/search/searchcursor.js',
			'addon/search/search.js',
		],
		cssFiles: [
			/*'theme/ambiance.css',*/
		],
		width: 800,         // Default value is 800
		height: 500       // Default value is 550
	},
	// Cibles de la target
	target_list: [
		{title: 'None', value: ''},
		{title: 'Nouvel onglet', value: '_blank'}
		],
	// Target pour lightbox
	rel_list: [
		{title: 'None', value: ''},
		{title: 'Une popup (Lity)', value: 'data-lity'},
		{title: 'Une galerie d\'images (SimpleLightbox)', value: 'gallery'}
	],
	// Titre des images
	image_title: true,
	// figure html5
	image_caption: true,
	// Pages internes
	link_list: baseUrl + "core/vendor/tinymce/links.php",
	link_class_list: [
		{title: 'None', value: ''},
		{title: 'clicked_link_count', value: 'clicked_link_count'}
	],
	// Contenu du menu contextuel
	contextmenu: "selectall searchreplace | hr | media image  link anchor nonbreaking  | insertable  cell row column deletetable",
	// Fichiers CSS à intégrer à l'éditeur
	content_css,
	// Classe à ajouter à la balise body dans l'iframe
	body_class: bodyIframe,
	// Affiche les menus
	menubar: true,
	// URL menu contextuel
	link_context_toolbar: true,
	// Affiche la barre de statut pour redimenssionnent
	statusbar: true,
	// Coller images blob
	paste_data_images: true,
	// Autoriser tous les éléments
	valid_elements : '*[*]',
	// Autorise l'ajout de script
	extended_valid_elements: "script[language|type|src]",
	// Conserver les styles
	keep_styles: false,
	// Bloque ou autorise le dimensionnement des medias
	media_dimensions: true,
	// Désactiver ou activer la dimension des images
	image_dimensions: true,
	// Active l'onglet avancé lors de l'ajout d'une image
	image_advtab: true,
	// Urls relatives
	relative_urls: true,
	// Url de base
	document_base_url: baseUrl,
	// Gestionnaire de fichiers
	filemanager_access_key: privateKey,
	external_filemanager_path: baseUrl + "core/vendor/filemanager/",
	external_plugins: {
		"filemanager": baseUrl + "core/vendor/filemanager/plugin.min.js"
	},
	// Contenu du bouton insérer
	insert_button_items: "anchor hr table",
	// Contenu du bouton formats
	block_formats: blockFormats,
	// Templates
	templates: templatesList
});


tinymce.init({
	// Classe où appliquer l'éditeur
	selector: ".editorWysiwygComment",
	setup:function(ed) {
		// Aperçu dans le pied de page
		ed.on('change', function(e) {
			if (ed.id === 'themeFooterText') {
				$("#footerText").html(tinyMCE.get('themeFooterText').getContent());
			}
		});
		// Limitation du nombre de caractères des commentaires à maxlength
		var alarmCaraMin = 200; // alarme sur le nombre de caractères restants à partir de...
		var maxlength = parseInt($("#" + (ed.id)).attr("maxlength"));
		var id_alarm = "#blogArticleContentAlarm";
		var contentLength = 0;
		ed.on("keydown", function(e) {
			contentLength = ed.getContent({format : 'text'}).length;
			if (contentLength > maxlength) {
				$(id_alarm).html( tinymcemaxi + " "  + maxlength + " " + caracteres );
				if(e.keyCode != 8 && e.keyCode != 46){
					e.preventDefault();
					e.stopPropagation();
					return false;
				}
			}
			else{
				if(maxlength - contentLength < alarmCaraMin){
					$(id_alarm).html((maxlength - contentLength) + " " + tinymcecara);
				}
				else{
					$(id_alarm).html(" ");
				}
			}
		});
		// Limitation y compris lors d'un copier/coller
		ed.on("paste", function(e){
			contentLeng = ed.getContent({format : 'text'}).length - 16;
			var data = e.clipboardData.getData('Text');
			if (data.length > (maxlength - contentLeng)) {
				$(id_alarm).html( tinymceexceed + " "  + maxlength + " " + caracteres + " ! ");
				return false;
			} else {
				if(maxlength - contentLeng < alarmCaraMin){
					$(id_alarm).html((maxlength - contentLeng - data.length) + " " + tinymcecara);
				}
				else{
					$(id_alarm).html(" ");
				}
				return true;
			}
		});
		// Supprime les barres obliques /> et retire les unités px des attributs height et width
		ed.on('GetContent', function (e) {
			e.content = e.content.replace(/ \/>/g, '>');
			e.content = e.content.replace(/(height|width)="(\d+)px"/g, '$1="$2"');
		});
	},
	// Langue
	language: lang_admin,
	// Plugins
	plugins: "advlist anchor autolink autosave autoresize fullscreen hr lists paste searchreplace tabfocus template",
	// Contenu de la barre d'outils
	toolbar: "restoredraft | undo redo | formatselect bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | fullscreen",
	// Hauteur en pixels de la zone d'édition
	//Autoresize
    autoresize_overflow_padding: 0,
    autoresize_bottom_margin: 0,
	min_height: 200,
	// Mode d'affichage de la barre d'outils
	toolbar_mode: 'wrap',
	// Titre des images
	image_title: true,
	// Pages internes
	link_list: baseUrl + "core/vendor/tinymce/links.php",
	// Contenu du menu contextuel
	contextmenu: "cut copy paste pastetext | selectall searchreplace ",
	// Fichiers CSS à intégrer à l'éditeur
	content_css: [
		baseUrl + "core/layout/common.css",
		baseUrl + "core/layout/mediaqueries.css",
		baseUrl + "core/vendor/tinymce/content.css",
		baseUrl + "site/data/theme.css",
		baseUrl + "site/data/custom.css"
	],
	// Classe à ajouter à la balise body dans l'iframe
	body_class: "editorWysiwyg",
	// Cache les menus
	menubar: false,
	// URL menu contextuel
	link_context_toolbar: true,
	// Affiche la barre de statut sinon on ne peut pas redimenssionner
	statusbar: true,
	// Autorise le copié collé à partir du web
	paste_data_images: true,
	// Bloque ou autorise le dimensionnement des medias
	media_dimensions: true,
	// Désactiver ou activer la dimension des images
	image_dimensions: true,
	// Active l'onglet avancé lors de l'ajout d'une image
	image_advtab: true,
	// Urls relatives
	relative_urls: true,
	// Url de base
	document_base_url: baseUrl,
	// Contenu du bouton formats
	block_formats: blockFormatsComment
});


