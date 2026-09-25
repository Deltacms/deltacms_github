/**
 * This file is part of DeltaCMS.
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 * @author Sylvain Lelièvre
 * @copyright 2021 © Sylvain Lelièvre
 * @author Lionel Croquefer
 * @copyright 2022 © Lionel Croquefer
 * @license GNU General Public License, version 3
 * @link https://deltacms.fr/
 * @contact https://deltacms.fr/contact
 *
 * Delta was created from version 11.2.00.24 of ZwiiCMS
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright 2008-2018 © Rémi Jean
 * @copyright 2018-2021 © Zwiicms team
 */

/* pour test perforamence*/

let deltaPerformance = {
    ttfb: 0,
    dom: 0,
    total: 0,
	text : ' temps de chargement indisponible'
};

$(window).on("load", function() {
    setTimeout(function() {
        const nav = performance.getEntriesByType("navigation")[0];
        deltaPerformance = {
            ttfb: Math.round(nav.responseStart),
            dom: Math.round(nav.domContentLoadedEventEnd),
            total: Math.round(nav.loadEventEnd)
        };
		if( deltaPerformance.total > 50) deltaPerformance.text = "<?php echo $text['core']['showBar'][48]; ?>" + deltaPerformance.total + ' ms';
    }, 100);
});

/* Variable globale */
let seoLity = null;
/*
* Fonction utilisée pour le Panel Lity
*/
function openSeoPanel() {
    seoLity = lity(`
        <div class="seo-dialog">
            <div class="seo-tabs">
                <span data-seo-tab="html">HTML5</span>
                <span data-seo-tab="meta" class="seoMeta">META</span>
                <span data-seo-tab="links"><?php echo $text['core']['showBar'][19];?></span>
                <span data-seo-tab="resources"><?php echo $text['core']['showBar'][24];?></span>
				<span data-seo-tab="copy" class="seoCopy delta-ico-clone" data-tippy-content="<?php echo $text['core']['showBar'][49];?>"><!----></span>
            </div>
            <div class="seo-dialog-content">
                <?php echo $text['core']['showBar'][27];?>
            </div>
			<div class="seoLastMod">
				<?php echo $text['core']['showBar'][18].$this->getData(['page',$this->getUrl(0),'title']).'"&nbsp('. date('d/m/Y H:i', $this->getData(['page',$this->getUrl(0),'date'])).')';?> ${deltaPerformance.text}
			</div>
        </div>
    `);
	// pour tooltip du bouton copier et pour le css du background lity avec la class seo-lity
	setTimeout(() => {
		const el = seoLity.element();
		el.addClass('seo-lity');
		tippy(el.find('[data-tippy-content]').toArray(), {
			arrow: true,
			placement: 'top'
		});
	}, 0);
    const container = document.querySelector(".seo-dialog");
    container.querySelectorAll("[data-seo-tab]").forEach(tab => {
        tab.addEventListener("click", function() {
            const type = this.dataset.seoTab;
            switch(type) {
                case "links":
                    sendLinksToPhp("links");
                    break;
                case "resources":
                    sendLinksToPhp("resources");
                    break;
                case "html":
                    openValidator();
                    break;
                case "meta":
                    generateMeta();
                    break;
            }
        });
    });
	$(document).one("lity:close", function () {
        seoLity = null;
    });
}

/*
* Copie du texte de seo-dialog-content
*/
$(document).on("click", ".seoCopy", async function () {
	const clone = $(".seo-dialog-content").clone();
	clone.find("div").append("\n");
	clone.find("span").append("\n");
	clone.find("br").replaceWith("\n");
	const text= clone.text();

    if (navigator.clipboard && window.isSecureContext) {
        try {
            await navigator.clipboard.writeText(text);
        } catch (e) {
            console.error(e);
        }
    } else {
        const textarea = document.createElement("textarea");
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        document.body.removeChild(textarea);
    }

    $(".seo-dialog-content").prepend(
        '<div class="seoMessage"><?php echo $text['core']['showBar'][50];?></div>'
    );
});

/*
* Fonction utilisée pour déterminer si des liens href contenus dans la section sont erronés
*/ 
function collectLinks() {
	const section = document.querySelector("section");
	if (!section) return [];
	const links = [];
	section.querySelectorAll("a[href]").forEach(a => {
		const href = a.getAttribute("href");
		if (!href ||
			href.startsWith("mailto:") ||
			href.startsWith("javascript:") ||
			href.startsWith("#")
		) {
			return;
		}
		links.push({
			url: a.href,
			text: a.innerText.trim()
		});
	});
	return links;
}

/*
* Fonction utilisée pour déterminer si des ressources (img, video, ...) contenus dans la section sont erronés
*/ 
function collectResources() {
	const section = document.querySelector("section");
	if (!section) return [];
	const links = [];
	// Images
	section.querySelectorAll("img[src]").forEach(img => {
		if (img.closest('[data-deltacms="module"]')) return;
		links.push({
			type: "image",
			url: img.src,
			text: img.alt || "",
			naturalWidth: img.naturalWidth,
			naturalHeight: img.naturalHeight
		});
	});
	// Vidéos
	section.querySelectorAll("video[src], video source[src]").forEach(el => {
		links.push({
			type: "video",
			url: el.src,
			text: ""
		});
	});
	// Audio
	section.querySelectorAll("audio[src], audio source[src]").forEach(el => {
		links.push({
			type: "audio",
			url: el.src,
			text: ""
		});
	});
	// Iframes
	section.querySelectorAll("iframe[src]").forEach(frame => {
		links.push({
			type: "iframe",
			url: frame.src,
			text: frame.title || ""
		});
	});
	// Embed
	section.querySelectorAll("embed[src]").forEach(el => {
		links.push({
			type: "embed",
			url: el.src,
			text: ""
		});
	});
	// Object
	section.querySelectorAll("object[data]").forEach(el => {
		links.push({
			type: "object",
			url: el.data,
			text: el.type || ""
		});
	});
	// Scripts SRC ou inline
	section.querySelectorAll("script").forEach(el => {
		if (el.src) {
			links.push({
				type: "script",
				url: el.src,
				text: el.type || "",
			});
		} else {
			links.push({
				type: "script-inline",
				url: "",
				text: el.textContent.substring(0, 100),
				source: el.dataset.deltacms || "unknown"
			});
		}
	});
	return links;
}

// Réponse du serveur 
function serverResponse(code){
	let repServeur ='';
	switch (code) {
		case 404:
			repServeur = '<?php echo $text['core']['showBar'][28];?>';
			break;
		case 403:
			repServeur = '<?php echo $text['core']['showBar'][29];?>';
			break;
		case 0:
			repServeur = '<?php echo $text['core']['showBar'][30];?>';
			break;							
		default:
			repServeur = '';
	}
	return repServeur;
}

// envoi vers PHP pour test curl et retour des résultats
function sendLinksToPhp(typeLink) {
	$(".seo-dialog-content").html('<?php echo $text['core']['showBar'][21];?><span class="delta-ico-spin animate-spin"></span>');
	
	const links = typeLink === 'links' ? collectLinks() : collectResources();
	const rootDomain = "<?php echo $this->getDomainName($_SERVER['HTTP_HOST']);?>";
	fetch("core/vendor/seo/test_links.php", {
		method: "POST",
		headers: {
			"Content-Type": "application/json"
		},
		body: JSON.stringify({ rootDomain: rootDomain, links: links})
	})
	.then(r => r.json())
	.then(data => {
		html='';
		let lines =[];
		if (Array.isArray(data) && data.length > 0) {
			let repServeur = '';
			if( typeLink === 'links'){ // LIENS
				data.forEach(link => {
					if( link.code < 200 || link.code >400){
						repServeur = serverResponse(link.code);
						if( link.text.length > 30) link.text = link.text.substring(0,30) + '...';
						lines.push(`<div>${escapeHtml(link.text)} : ${escapeHtml(link.url)} => [ ${escapeHtml(link.code)} ] ${repServeur}</div>`);
					}
				});
				if (lines.length === 0) lines.push('<?php echo $text['core']['showBar'][20];?>') ;
			} else { // RESSOURCES
				let accessTitle = "<span class='seoTitle'><?php echo $text['core']['showBar'][33];?></span>";
				let dangerTitle = "<span class='seoTitle'><?php echo $text['core']['showBar'][34];?></span>";
				let weightTitle ="<span class='seoTitle'><?php echo $text['core']['showBar'][46];?></span>";
				lines.push(accessTitle);
				data.forEach(link => {						
					if ( link.code < 200 || link.code >400 ||
						(link.type === "image" && !link.content_type.startsWith("image/")) ||
						(link.type === "video" && !link.content_type.startsWith("video/")) ||
						(link.type === "audio" && !link.content_type.startsWith("audio/")) ||
						((link.type === "embed" || link.type === "object") && link.content_type.startsWith("text/html"))
					) {					
						if( link.text.length > 30) link.text = link.text.substring(0,30) + '...';
						plus = '';
						repServeur = serverResponse(link.code);
						if( link.code >= 200 && link.code <= 400) plus = ' & ['+ link.content_type  + ']';
						if( !(link.url.startsWith("data:") || link.url.startsWith("blob:"))) lines.push(`<div>${escapeHtml(link.type)} : ${escapeHtml(link.url)} => [ ${escapeHtml(link.code)} ] ${escapeHtml(plus)} ${escapeHtml(repServeur)} </div>`);
					}
				});
				// Avertissements sécurité
				if(lines.length === 1) lines = [];
				lines.push(dangerTitle);
				let secureLines = 0;
				data.forEach(link => {
					if( link.text.length > 30) link.text = link.text.substring(0,30) + '...';
					if(link.type === "script-inline"){
						if(link.source === "unknown"){
							lines.push(`<div>${escapeHtml(link.type)} : ${escapeHtml(link.text)} => <?php echo $text['core']['showBar'][36];?></div>`);
							secureLines++;
						}
					} else {
						if(link.external === true){
							switch (link.type) {
								case "iframe":
									lines.push(`<div>${escapeHtml(link.type)} : ${escapeHtml(link.url)} => <?php echo $text['core']['showBar'][37];?></div>`);
									break;
								case "image":
									if(link.naturalHeight == 1 && link.naturalWidth ==1){
										lines.push(`<div>${escapeHtml(link.type)} : ${escapeHtml(link.url)} => <?php echo $text['core']['showBar'][38];?></div>`);
									} else {
										lines.push(`<div>${escapeHtml(link.type)} : ${escapeHtml(link.url)} => <?php echo $text['core']['showBar'][39];?></div>`);
									}
									break;
								case "script":
									lines.push(`<div>${escapeHtml(link.type)} : ${escapeHtml(link.url)} => <?php echo $text['core']['showBar'][40];?></div>`);
									break;
								case "video":
									lines.push(`<div>${escapeHtml(link.type)} : ${escapeHtml(link.url)} => <?php echo $text['core']['showBar'][41];?></div>`);
									break;
								case "audio":
									lines.push(`<div>${escapeHtml(link.type)} : ${escapeHtml(link.url)} => <?php echo $text['core']['showBar'][42];?></div>`);
									break;
								case "embed":
									lines.push(`<div>${escapeHtml(link.type)} : ${escapeHtml(link.url)} => <?php echo $text['core']['showBar'][43];?></div>`);
									break;
								case "object":
									lines.push(`<div>${escapeHtml(link.type)} : ${escapeHtml(link.url)} => <?php echo $text['core']['showBar'][44];?></div>`);
									break;
								default:
									lines.push(`<div>${escapeHtml(link.type)} : ${escapeHtml(link.url)} => <?php echo $text['core']['showBar'][45];?></div>`);
							}
							secureLines++;
						}
					}
				});
				if(secureLines === 0) lines.pop();
				/* Poids des ressources en ko*/
				lines.push(weightTitle);
				let weightTotal = 0;
				let maxi = 0;
				let weightLines = 0;
				let weightTotalMaxi = 1024;
				data.forEach(link => {
					switch (link.type) {
						case "image":
							maxi = 500;
							break;
						case "video":
							maxi = 1024;
							break;
						case "audio":
							maxi = 500;
							break;
						case "embed":
							maxi = 500;
							break;	
						case "object":
							maxi = 500;
							break;
						case "iframe":
							maxi = 500;
							break;
						case "script":
							maxi = 500;
							break;
						default:
							maxi = 1024;
					}
					if ( link.code === 200 && (
						(link.type === "image" && link.content_type.startsWith("image/")) ||
						(link.type === "video" && link.content_type.startsWith("video/")) ||
						(link.type === "audio" && link.content_type.startsWith("audio/")) ||
						(link.type === "iframe" && !link.content_type.startsWith("text/html")) ||
						(link.type === "script" && link.content_type.startsWith("text/html")) ||
						((link.type === "embed" || link.type === "object") && !link.content_type.startsWith("text/html")))
					) {
						if( link.size > maxi*1024){
							lines.push(`<div>${escapeHtml(link.type)} : ${escapeHtml(link.url)} : ${escapeHtml(Math.round(link.size/1024))} ko </div>`);
							weightLines++;
						}
						weightTotal += Math.round(link.size/1024);
					}
				});
				if( weightLines > 0 || weightTotal > weightTotalMaxi ){ 
					lines.push(`<div><?php echo $text['core']['showBar'][47];?>${weightTotal} ko </div>`);
					weightLines++;
				}
				// Effacement du titre poids
				if( weightLines === 0) lines.pop();
				// Aucun problème
				if(lines.length === 0){
					lines = [];
					lines.push('<?php echo $text['core']['showBar'][25];?>') ;
				}

			}
		} else {
			let texte = typeLink === 'links' ? '<?php echo $text['core']['showBar'][22];?>' : '<?php echo $text['core']['showBar'][26];?>' ;
			lines.push( texte );
		}
		showSeoResult(typeLink, lines);
	});
}

$("#buttonSeoLinks, #buttonSeoResources").click(function() {
    openSeoPanel();
});

$(".seoBarButton").click(function(e) {
    e.preventDefault();
        if (!seoLity) openSeoPanel();
});

function escapeHtml(str) {
    return String(str)
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;")
        .replaceAll("'", "&#039;");
}

function showSeoResult(typeLink, lines) {

    const html = lines.join("");

    $(".seo-dialog-content").html(`
        <h2>
            ${typeLink === "links" ? "<div><?php echo $text['core']['showBar'][31];?></div>" : "<div><?php echo $text['core']['showBar'][32];?></div>"}
        </h2>
        ${html}
    `);
}

/*
* Copie dans le presse papier le htlm de la section
*/
async function generateMeta() {
    const data = $('section').html();
    try {
        if (navigator.clipboard && window.isSecureContext) {
            await navigator.clipboard.writeText(data);
        } else {
            const textarea = document.createElement("textarea");
            textarea.value = data;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);
        }
        $(".seo-dialog-content").html(`
            <h2>META</h2>
            <p><?php echo $text['core']['showBar'][23];?></p>
        `);
    } catch (err) {
        console.error(err);
        $(".seo-dialog-content").html(`
            <h2>META</h2>
            <p><?php echo $text['core']['showBar'][35];?></p>
        `);
    }
}

/*
* Ouvre une page de valdation html5 avec l'url de la page
*/
function openValidator(){
	const pageUrl = "<?php echo helper::baseUrl().$this->getUrl(); ?>";
	window.open("https://validator.w3.org/nu/?doc=" + encodeURIComponent(pageUrl),"_blank");
}

/* 
* Positionnement vertical du bandeau du menu burger si il est fixe et si un utilisateur est connecté
*/
$(window).on("resize", function() {
	if($(window).width() < 800) {
		<?php if( $this->getData(['theme','menu', 'burgerFixed'])=== true){ ?>
			var barHeight = $(" #bar ").css("height");
			$(".navfixedburgerconnected").css("top",barHeight);
		<?php } ?>
	}
}).trigger("resize");

