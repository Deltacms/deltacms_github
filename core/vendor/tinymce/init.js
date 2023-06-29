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
// Initialisations et adaptations pour Snipcart
if ( typeof(initSnipcart) == 'undefined') {
	var initSnipcart = false;
}; 
var pluginsList = "advlist anchor autolink autoresize autosave codemirror colorpicker contextmenu fullscreen hr image imagetools link lists media paste searchreplace stickytoolbar tabfocus table template textcolor nonbreaking";
var toolbarList = "restoredraft | undo redo | formatselect bold italic underline forecolor backcolor | fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist | table template | image media link | code fullscreen";
var templatesList = [
		{
			title: "Bloc de texte",
			url: baseUrl + "core/vendor/tinymce/templates/1block.html",
			description: "Bloc de texte avec un titre."
		},
		{
			title: "Blocs de texte : 6 - 6",
			url: baseUrl + "core/vendor/tinymce/templates/2blocks.html",
			description: "2 blocs de texte, de même hauteur, avec un titre en ligne."
		},
		{
			title: "Blocs de texte : 4 - 4 - 4",
			url: baseUrl + "core/vendor/tinymce/templates/3blocks.html",
			description: "3 blocs de texte, de même hauteur, avec un titre en ligne."
		},
		{
			title: "Blocs de texte : 3 - 6 - 3",
			url: baseUrl + "core/vendor/tinymce/templates/363blocks.html",
			description: "3 blocs de texte, de même hauteur, dissymétriques, avec un titre en ligne."
		},
		{
			title: "Blocs de texte : 3 - 3 - 3 - 3",
			url: baseUrl + "core/vendor/tinymce/templates/4blocks.html",
			description: "4 blocs de texte, de même hauteur, avec un titre en ligne."
		},
		{
			title: "Effet accordéon : 2",
			url: baseUrl + "core/vendor/tinymce/templates/accordion.html",
			description: "Bloc de texte avec effet accordéon à 2 paragraphes."
		},
		{
			title: "Effet accordéon : 3",
			url: baseUrl + "core/vendor/tinymce/templates/accordion3.html",
			description: "Bloc de texte avec effet accordéon à 3 paragraphes."
		},
		{
			title: "Effet accordéon : 4",
			url: baseUrl + "core/vendor/tinymce/templates/accordion4.html",
			description: "Bloc de texte avec effet accordéon à 4 paragraphes."
		},
		{
			title: "Grille symétrique : 6 - 6",
			url: baseUrl + "core/vendor/tinymce/templates/col6.html",
			description: "Grille adaptative sur 12 colonnes, sur mobile elles passent les unes en dessous des autres."
		},
		{
			title: "Grille symétrique : 4 - 4 - 4",
			url: baseUrl + "core/vendor/tinymce/templates/col444.html",
			description: "Grille adaptative sur 12 colonnes, sur mobile elles passent les unes en dessous des autres."
		},
		{
			title: "Grille symétrique : 3 - 3 - 3 - 3",
			url: baseUrl + "core/vendor/tinymce/templates/col3.html",
			description: "Grille adaptative sur 12 colonnes, sur mobile elles passent les unes en dessous des autres."
		},
		{
			title: "Grille asymétrique : 4 - 8",
			url: baseUrl + "core/vendor/tinymce/templates/col4-8.html",
			description: "Grille adaptative sur 12 colonnes, sur mobile elles passent les unes en dessous des autres."
		},
		{
			title: "Grille asymétrique : 8 - 4",
			url: baseUrl + "core/vendor/tinymce/templates/col8-4.html",
			description: "Grille adaptative sur 12 colonnes, sur mobile elles passent les unes en dessous des autres."
		},
		{
			title: "Grille asymétrique : 2 - 10",
			url: baseUrl + "core/vendor/tinymce/templates/col2-10.html",
			description: "Grille adaptative sur 12 colonnes, sur mobile elles passent les unes en dessous des autres."
		},
		{
			title: "Grille asymétrique : 10 - 2",
			url: baseUrl + "core/vendor/tinymce/templates/col10-2.html",
			description: "Grille adaptative sur 12 colonnes, sur mobile elles passent les unes en dessous des autres."
		}
	];
var formatsList = [
		{title: "Headers", items: [
			{title: "Header 1", format: "h1"},
			{title: "Header 2", format: "h2"},
			{title: "Header 3", format: "h3"},
			{title: "Header 4", format: "h4"}
		]},
		{title: "Inline", items: [
			{title: "Bold", icon: "bold", format: "bold"},
			{title: "Italic", icon: "italic", format: "italic"},
			{title: "Underline", icon: "underline", format: "underline"},
			{title: "Strikethrough", icon: "strikethrough", format: "strikethrough"},
			{title: "Superscript", icon: "superscript", format: "superscript"},
			{title: "Subscript", icon: "subscript", format: "subscript"},
			{title: "Code", icon: "code", format: "code"}
		]},
		{title: "Blocks", items: [
			{title: "Paragraph", format: "p"},
			{title: "Blockquote", format: "blockquote"},
			{title: "Div", format: "div"},
			{title: "Pre", format: "pre"}
		]},
		{title: "Alignment", items: [
			{title: "Left", icon: "alignleft", format: "alignleft"},
			{title: "Center", icon: "aligncenter", format: "aligncenter"},
			{title: "Right", icon: "alignright", format: "alignright"},
			{title: "Justify", icon: "alignjustify", format: "alignjustify"}
		]}
	];

if( initSnipcart == true ) {
	var templatesSnipcart = [
		{
			title: "Snipcart 2 colonnes",
			url: baseUrl + "module/snipcart/vendor/col6.html",
			description: "Grille pour Snipcart avec les produits sur 2 colonnes."
		},
		{
			title: "Snipcart 3 colonnes",
			url: baseUrl + "module/snipcart/vendor/col4.html",
			description: "Grille pour Snipcart avec les produits sur 3 colonnes."
		}

	];
	pluginsList = "advlist anchor autolink autoresize autosave codemirror colorpicker contextmenu fullscreen hr image imagetools link lists media paste searchreplace stickytoolbar tabfocus table template textcolor nonbreaking snipcart";
	toolbarList = "restoredraft | undo redo | formatselect bold italic underline forecolor backcolor | fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist | snipcart | table template | image media link | code fullscreen";
	templatesList = templatesSnipcart.concat(templatesList);
}

tinymce.init({
	// Classe où appliquer l'éditeur
	selector: ".editorWysiwyg",
		// Aperçu dans le pied de page
		setup:function(ed) {
			ed.on('change', function(e) {
				if (ed.id === 'themeFooterText') {
					$("#footerText").html(tinyMCE.get('themeFooterText').getContent());
				}
				if (ed.id === 'themeHeaderText') {
					$("#featureContent").html(tinyMCE.get('themeHeaderText').getContent());
				}

			});
		},
	// Langue
	language: lang_admin,
	// Plugins
	plugins: pluginsList,
	// Contenu de la barre d'outils
	toolbar: toolbarList,
	fontsize_formats: "8px 9px 10px 11px 12px 13px 14px 15px 16px 18px 20px 24px 30px 36px 48px 60px 72px 96px",
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
	menubar: true,
	// URL menu contextuel
	link_context_toolbar: true,
	// Cache la barre de statut
	statusbar: false,
	// Coller images blob
	paste_data_images: true,
	/* Eviter BLOB à tester
	images_dataimg_filter: function(img) {
		return img.hasAttribute('internal-blob');
	},*/
	// Autoriser tous les éléments
	valid_elements : '*[*]',
	// Autorise l'ajout de script
	extended_valid_elements: "script[language|type|src]",
	// Conserver les styles
	keep_styles: false,
	// Bloque le dimensionnement des médias (car automatiquement en fullsize avec fitvids pour le responsive)
	media_dimensions: true,
	// Désactiver la dimension des images
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
	style_formats: formatsList,
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
			var caracteres = $("#" + (ed.id)).attr("caracteres");
			var tinymcemaxi = $("#" + (ed.id)).attr("TinymceMaxi");
			var tinymcecara = $("#" + (ed.id)).attr("TinymceCara");
			var tinymceexceed = $("#" + (ed.id)).attr("TinymceExceed");
			var id_alarm = "#blogArticleContentAlarm"
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
		},
	// Langue
	language: lang_admin,
	// Plugins
	plugins: "advlist anchor autolink autoresize autosave colorpicker contextmenu fullscreen hr lists paste searchreplace stickytoolbar tabfocus template textcolor visualblocks",
	// Contenu de la barre d'outils
	toolbar: "restoredraft | undo redo | formatselect bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | visualblocks fullscreen",
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
	// Cache la barre de statut
	statusbar: false,
	// Autorise le copié collé à partir du web
	paste_data_images: true,
	// Bloque le dimensionnement des médias (car automatiquement en fullsize avec fitvids pour le responsive)
	media_dimensions: true,
	// Désactiver la dimension des images
	image_dimensions: true,
	// Active l'onglet avancé lors de l'ajout d'une image
	image_advtab: true,
	// Urls relatives
	relative_urls: true,
	// Url de base
	document_base_url: baseUrl,
	// Contenu du bouton formats
	style_formats: formatsList
});



tinymce.PluginManager.add('stickytoolbar', function(editor, url) {
	editor.on('init', function() {
	  setSticky();
	});

	$(window).on('scroll', function() {
	  setSticky();
	});

	function setSticky() {
	  var container = editor.editorContainer;
	  var toolbars = $(container).find('.mce-toolbar-grp');
	  var statusbar = $(container).find('.mce-statusbar');
	  var menubar = $(container).find('.mce-menubar');

	  if (isSticky()) {
		$(container).css({
		  paddingTop: menubar.outerHeight()
		});

		if (isAtBottom()) {
		  toolbars.css({
			top: 'auto',
			bottom: statusbar.outerHeight(),
			position: 'absolute',
			width: '100%',
			borderBottom: 'none'
		  });
		} else {
			menubar.css({
				top: 45,
				bottom: 'auto',
				position: 'fixed',
				width: $(container).width(),
				borderBottom: '1px solid rgba(0,0,0,0.2)',
				background: '#fff'
			});
		  	toolbars.css({
				top: 78,
				bottom: 'auto',
				position: 'fixed',
				width: $(container).width(),
				borderBottom: '1px solid rgba(0,0,0,0.2)'
		  	});
		}
	  } else {
		$(container).css({
		  paddingTop: 0
		});

		toolbars.css({
  		top:0,
		  position: 'relative',
		  width: 'auto',
		  borderBottom: 'none'
		});
		menubar.css({
			top:0,
			position: 'relative',
			width: 'auto',
			borderBottom: 'none'
		  });
	  }
	}

	function isSticky() {
	  var container = editor.editorContainer,
		editorTop = container.getBoundingClientRect().top;

	  if (editorTop < 0) {
		return true;
	  }

	  return false;
	}

	function isAtBottom() {
	  var container = editor.editorContainer,
		editorTop = container.getBoundingClientRect().top;

	  var toolbarHeight = $(container).find('.mce-toolbar-grp').outerHeight();
	  var footerHeight = $(container).find('.mce-statusbar').outerHeight();

	  var hiddenHeight = -($(container).outerHeight() - toolbarHeight - footerHeight);

  	  if (editorTop < hiddenHeight) {
		return true;
	  }

	  return false;
	}
  });
