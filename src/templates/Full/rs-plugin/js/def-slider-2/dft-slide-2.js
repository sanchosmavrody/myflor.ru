var tpj = jQuery;
if (window.RS_MODULES === undefined) window.RS_MODULES = {};
if (RS_MODULES.modules === undefined) RS_MODULES.modules = {};
RS_MODULES.modules["revslider21"] = {
	once: RS_MODULES.modules["revslider21"] !== undefined ? RS_MODULES.modules["revslider21"].once : undefined, init: function () {
		window.revapi2 = window.revapi2 === undefined || window.revapi2 === null || window.revapi2.length === 0 ? document.getElementById("rev_slider_2_1") : window.revapi2;
		if (window.revapi2 === null || window.revapi2 === undefined || window.revapi2.length == 0) { window.revapi2initTry = window.revapi2initTry === undefined ? 0 : window.revapi2initTry + 1; if (window.revapi2initTry < 20) requestAnimationFrame(function () { RS_MODULES.modules["revslider21"].init() }); return; }
		window.revapi2 = jQuery(window.revapi2);
		if (window.revapi2.revolution == undefined) { revslider_showDoubleJqueryError("rev_slider_2_1"); return; }
		revapi2.revolutionInit({
			revapi: "revapi2",
			DPR: "dpr",
			sliderLayout: "fullwidth",
			visibilityLevels: "1240,1024,778,480",
			gridwidth: "1240,1024,778,480",
			gridheight: "980,768,620,620",
			lazyType: "smart",
			perspective: 600,
			perspectiveType: "global",
			editorheight: "980,768,620,620",
			responsiveLevels: "1240,1024,778,480",
			stopAtSlide: 1,
			stopAfterLoops: 0,
			stopLoop: true,
			progressBar: { disableProgressBar: true },
			navigation: {
				wheelCallDelay: 1000,
				onHoverStop: false,
				touch: {
					touchenabled: true,
					touchOnDesktop: true,
					swipe_min_touches: 50
				},
				arrows: {
					enable: true,
					style: "uranus",
					hide_onmobile: true,
					hide_under: "700px",
					rtl: true,
					left: {
						anim: "left",
						container: "layergrid",
						v_align: "bottom",
						h_offset: 12,
						v_offset: 75
					},
					right: {
						anim: "right",
						container: "layergrid",
						h_align: "left",
						v_align: "bottom",
						h_offset: 105,
						v_offset: 75
					}
				},
				bullets: {
					enable: true,
					tmp: "<span class=\"tp-bullet-inner\"></span>",
					style: "uranus",
					hide_onmobile: true,
					hide_under: "700px",
					anim: "zoomin",
					h_align: "left",
					v_align: "center",
					h_offset: -250,
					direction: "vertical",
					space: 20,
					container: "layergrid"
				}
			},
			viewPort: {
				global: true,
				globalDist: "-200px",
				enable: false,
				visible_area: "20%"
			},
			fallbacks: {
				allowHTML5AutoPlayOnAndroid: true
			},
		});

	}
} // End of RevInitScript
if (window.RS_MODULES.checkMinimal !== undefined) { window.RS_MODULES.checkMinimal(); };