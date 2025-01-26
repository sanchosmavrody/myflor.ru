var tpj = jQuery;
if (window.RS_MODULES === undefined) window.RS_MODULES = {};
if (RS_MODULES.modules === undefined) RS_MODULES.modules = {};
RS_MODULES.modules["revslider1491"] = {
	once: RS_MODULES.modules["revslider1491"] !== undefined ? RS_MODULES.modules["revslider1491"].once : undefined, init: function () {
		window.revapi149 = window.revapi149 === undefined || window.revapi149 === null || window.revapi149.length === 0 ? document.getElementById("rev_slider_149_1") : window.revapi149;
		if (window.revapi149 === null || window.revapi149 === undefined || window.revapi149.length == 0) { window.revapi149initTry = window.revapi149initTry === undefined ? 0 : window.revapi149initTry + 1; if (window.revapi149initTry < 20) requestAnimationFrame(function () { RS_MODULES.modules["revslider1491"].init() }); return; }
		window.revapi149 = jQuery(window.revapi149);
		if (window.revapi149.revolution == undefined) { revslider_showDoubleJqueryError("rev_slider_149_1"); return; }
		revapi149.revolutionInit({
			revapi: "revapi149",
			DPR: "dpr",
			sliderLayout: "fullwidth",
			visibilityLevels: "1240,1024,778,480",
			gridwidth: "1300,1024,778,480",
			gridheight: "900,600,450,450",
			spinner: "spinner0",
			perspective: 600,
			perspectiveType: "global",
			editorheight: "900,600,450,450",
			responsiveLevels: "1240,1024,778,480",
			progressBar: { disableProgressBar: true },
			navigation: {
				wheelCallDelay: 1000,
				onHoverStop: false,
				arrows: {
					enable: true,
					style: "metis",
					hide_onmobile: true,
					hide_under: "767px",
					left: {
						container: "layergrid",
						h_align: "right",
						h_offset: 30
					},
					right: {
						container: "layergrid",
						h_offset: 30,
						v_offset: 78
					}
				},
				bullets: {
					enable: true,
					tmp: "",
					style: "hesperiden",
					hide_over: "768px",
					v_offset: 15,
					space: 10,
					container: "layergrid"
				}
			},
			viewPort: {
				global: false,
				globalDist: "-200px",
				enable: false
			},
			fallbacks: {
				allowHTML5AutoPlayOnAndroid: true
			},
		});
		// listen for when the slider initially loads
		revapi149.bind('revolution.slide.onloaded', function () {

			// get number of total slides in slider
			var totalSlides = revapi149.revmaxslide();

			// listen for when a new slide is shown
			revapi149.bind('revolution.slide.onchange', function (e, data) {

				// get current slide number
				var currentSlide = data.slideIndex;

				jQuery('#rev-total-slide .rs-layer').html(currentSlide + '/' + totalSlides);

			});

		});

	}
} // End of RevInitScript
if (window.RS_MODULES.checkMinimal !== undefined) { window.RS_MODULES.checkMinimal(); };

window.RS_MODULES = window.RS_MODULES || {};
window.RS_MODULES.modules = window.RS_MODULES.modules || {};
window.RS_MODULES.waiting = window.RS_MODULES.waiting || [];
window.RS_MODULES.defered = true;
window.RS_MODULES.moduleWaiting = window.RS_MODULES.moduleWaiting || {};
window.RS_MODULES.type = 'compiled';

function setREVStartSize(e) {
	//window.requestAnimationFrame(function() {
	window.RSIW = window.RSIW === undefined ? window.innerWidth : window.RSIW;
	window.RSIH = window.RSIH === undefined ? window.innerHeight : window.RSIH;
	try {
		var pw = document.getElementById(e.c).parentNode.offsetWidth,
			newh;
		pw = pw === 0 || isNaN(pw) || (e.l == "fullwidth" || e.layout == "fullwidth") ? window.RSIW : pw;
		e.tabw = e.tabw === undefined ? 0 : parseInt(e.tabw);
		e.thumbw = e.thumbw === undefined ? 0 : parseInt(e.thumbw);
		e.tabh = e.tabh === undefined ? 0 : parseInt(e.tabh);
		e.thumbh = e.thumbh === undefined ? 0 : parseInt(e.thumbh);
		e.tabhide = e.tabhide === undefined ? 0 : parseInt(e.tabhide);
		e.thumbhide = e.thumbhide === undefined ? 0 : parseInt(e.thumbhide);
		e.mh = e.mh === undefined || e.mh == "" || e.mh === "auto" ? 0 : parseInt(e.mh, 0);
		if (e.layout === "fullscreen" || e.l === "fullscreen")
			newh = Math.max(e.mh, window.RSIH);
		else {
			e.gw = Array.isArray(e.gw) ? e.gw : [e.gw];
			for (var i in e.rl) if (e.gw[i] === undefined || e.gw[i] === 0) e.gw[i] = e.gw[i - 1];
			e.gh = e.el === undefined || e.el === "" || (Array.isArray(e.el) && e.el.length == 0) ? e.gh : e.el;
			e.gh = Array.isArray(e.gh) ? e.gh : [e.gh];
			for (var i in e.rl) if (e.gh[i] === undefined || e.gh[i] === 0) e.gh[i] = e.gh[i - 1];

			var nl = new Array(e.rl.length),
				ix = 0,
				sl;
			e.tabw = e.tabhide >= pw ? 0 : e.tabw;
			e.thumbw = e.thumbhide >= pw ? 0 : e.thumbw;
			e.tabh = e.tabhide >= pw ? 0 : e.tabh;
			e.thumbh = e.thumbhide >= pw ? 0 : e.thumbh;
			for (var i in e.rl) nl[i] = e.rl[i] < window.RSIW ? 0 : e.rl[i];
			sl = nl[0];
			for (var i in nl) if (sl > nl[i] && nl[i] > 0) { sl = nl[i]; ix = i; }
			var m = pw > (e.gw[ix] + e.tabw + e.thumbw) ? 1 : (pw - (e.tabw + e.thumbw)) / (e.gw[ix]);
			newh = (e.gh[ix] * m) + (e.tabh + e.thumbh);
		}
		var el = document.getElementById(e.c);
		if (el !== null && el) el.style.height = newh + "px";
		el = document.getElementById(e.c + "_wrapper");
		if (el !== null && el) {
			el.style.height = newh + "px";
			el.style.display = "block";
		}
	} catch (e) {
		console.log("Failure at Presize of Slider:" + e)
	}
	//});
};