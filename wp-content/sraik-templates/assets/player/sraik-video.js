/*!
 * SRAIK video loader — mounts the Sraik Player into any video box.
 *
 * Printed INLINE by parts/foot.php (no extra request at page load). Costs
 * nothing until a video matters:
 *   1. page loaded + browser idle + a video box near the screen
 *        -> the player's JS/CSS download in the background (~20 KB gzipped)
 *   2. pointer over / finger on / focus on a video box
 *        -> also warm the connection to the video host
 *   3. click / tap / Enter
 *        -> the player mounts in the box and starts playing
 * If the player files cannot load, the box falls back to the old plain
 * embed, so a video can never be left dead.
 *
 * Two ways to use it:
 *   Markup only (any page, any future video):
 *     <div data-sraik-video="VIDEO_ID_OR_URL" data-start="90" data-ratio="16:9">
 *       <img src="thumb.jpg" alt="">   <- optional thumbnail, also the poster
 *     </div>
 *   From a script (the landing pages' custom hero / payment boxes):
 *     SraikVideo.mount(box, { video, start, ratio, poster, onMount, fallback })
 */
(function (w, d) {
	'use strict';

	if (w.SraikVideo) {
		return;
	}

	var cfg = w.SRAIK_PLAYER || {};
	var IDLE = 0, LOADING = 1, READY = 2, FAILED = 3;
	var state = IDLE;
	var waiters = [];
	var hostWarm = false;
	var noop = function () {};

	/* ── helpers ── */

	function parseId(v) {
		v = String(v || '').trim();
		if (/^[A-Za-z0-9_-]{11}$/.test(v)) {
			return v;
		}
		var m = v.match(/(?:youtube(?:-nocookie)?\.com\/(?:embed\/|shorts\/|live\/|v\/|watch\?(?:.*&)?v=)|youtu\.be\/)([A-Za-z0-9_-]{11})/);
		return m ? m[1] : '';
	}

	/* "start=366", "t=366", "t=6m6s", "t=366s" -> seconds */
	function parseStart(v) {
		var m = String(v || '').match(/[?&#](?:start|t)=([0-9hms]+)/);
		if (!m) {
			return 0;
		}
		var t = m[1];
		if (/^\d+s?$/.test(t)) {
			return parseInt(t, 10);
		}
		var h = /(\d+)h/.exec(t), mi = /(\d+)m/.exec(t), se = /(\d+)s/.exec(t);
		return (h ? +h[1] * 3600 : 0) + (mi ? +mi[1] * 60 : 0) + (se ? +se[1] : 0);
	}

	function head() {
		return d.head || d.documentElement;
	}

	/* After load + idle, and never while the page is only being prerendered. */
	function whenIdle(fn) {
		function go() {
			if ('requestIdleCallback' in w) {
				w.requestIdleCallback(fn, { timeout: 2500 });
			} else {
				setTimeout(fn, 200);
			}
		}
		function start() {
			if (d.prerendering) {
				d.addEventListener('prerenderingchange', start, { once: true });
				return;
			}
			if ('complete' === d.readyState) {
				go();
			} else {
				w.addEventListener('load', go, { once: true });
			}
		}
		start();
	}

	/* ── the player files ── */

	function settle(ok) {
		state = ok ? READY : FAILED;
		waiters.splice(0).forEach(function (p) {
			p[ok ? 0 : 1]();
		});
	}

	function load() {
		return new Promise(function (resolve, reject) {
			if (READY === state) {
				resolve();
				return;
			}
			if (FAILED === state) {
				reject();
				return;
			}
			waiters.push([resolve, reject]);
			if (LOADING === state) {
				return;
			}
			state = LOADING;

			if (!cfg.js || !cfg.css) {
				settle(false);
				return;
			}

			var cssDone = false, jsDone = false, over = false;
			var timer = setTimeout(function () { finish(false); }, 15000);
			function finish(ok) {
				if (over) {
					return;
				}
				over = true;
				clearTimeout(timer);
				settle(ok && !!(w.SraikPlayer && w.SraikPlayer.init));
			}
			function check() {
				if (cssDone && jsDone) {
					finish(true);
				}
			}

			var l = d.createElement('link');
			l.rel = 'stylesheet';
			l.href = cfg.css;
			l.setAttribute('data-no-optimize', '1');
			l.onload = function () { cssDone = true; check(); };
			l.onerror = function () { finish(false); };
			head().appendChild(l);

			var s = d.createElement('script');
			s.src = cfg.js;
			s.async = true;
			s.setAttribute('data-no-optimize', '1');
			s.setAttribute('data-cfasync', 'false');
			s.onload = function () { jsDone = true; check(); };
			s.onerror = function () { finish(false); };
			(d.body || head()).appendChild(s);
		});
	}

	/* Open the connection to the video host before the click lands. */
	function warmHost() {
		if (hostWarm) {
			return;
		}
		hostWarm = true;
		['https://www.youtube.com', 'https://i.ytimg.com'].forEach(function (href) {
			var l = d.createElement('link');
			l.rel = 'preconnect';
			l.href = href;
			head().appendChild(l);
		});
		if (!(w.YT && w.YT.Player) && !d.querySelector('script[src*="youtube.com/iframe_api"]')) {
			var s = d.createElement('script');
			s.src = 'https://www.youtube.com/iframe_api';
			s.async = true;
			head().appendChild(s);
		}
	}

	/* ── warming a box ── */

	var io = null;
	function watch(box) {
		if (!box || box.__svWatch) {
			return;
		}
		box.__svWatch = true;

		function intent() {
			load().then(noop, noop);
			warmHost();
		}
		box.addEventListener('pointerenter', intent, { passive: true });
		box.addEventListener('touchstart', intent, { passive: true });
		box.addEventListener('focusin', intent);

		whenIdle(function () {
			if (!('IntersectionObserver' in w)) {
				load().then(noop, noop);
				return;
			}
			if (!io) {
				io = new IntersectionObserver(function (entries) {
					entries.forEach(function (en) {
						if (en.isIntersecting) {
							io.unobserve(en.target);
							load().then(noop, noop);
						}
					});
				}, { rootMargin: '600px 0px' });
			}
			io.observe(box);
		});
	}

	/* ── a small wait indicator while the files arrive (rarely seen) ── */

	function showWait(box) {
		var sp = d.createElement('span');
		sp.setAttribute('aria-hidden', 'true');
		sp.style.cssText = 'position:absolute;top:50%;left:50%;width:44px;height:44px;margin:-22px 0 0 -22px;border:3px solid rgba(255,255,255,.14);border-top-color:#c6ff3d;border-radius:50%;z-index:20;pointer-events:none;box-sizing:border-box';
		box.appendChild(sp);
		if (sp.animate) {
			sp.animate([{ transform: 'rotate(0deg)' }, { transform: 'rotate(360deg)' }], { duration: 800, iterations: Infinity });
		}
		box.setAttribute('aria-busy', 'true');
		return function () {
			if (sp.parentNode) {
				sp.parentNode.removeChild(sp);
			}
			box.removeAttribute('aria-busy');
		};
	}

	/* ── mounting ── */

	function player(box) {
		return box && box.__svMounted ? (box.__svMounted.__sraikPlayer || null) : null;
	}

	function mount(box, opt) {
		opt = opt || {};
		if (!box) {
			return Promise.resolve(null);
		}
		if (box.__svMounted) {
			return Promise.resolve(player(box));
		}
		if (box.__svPending) {
			return box.__svPending;
		}

		var id = parseId(opt.video);
		if (!id) {
			if (opt.fallback) {
				opt.fallback();
			}
			return Promise.resolve(null);
		}
		var start = parseInt(opt.start, 10) || parseStart(opt.video) || 0;
		var ratio = opt.ratio;
		if (!ratio) {
			var r = box.getBoundingClientRect();
			ratio = r.height > r.width ? '9:16' : '16:9';
		}

		warmHost();
		var done = showWait(box);

		box.__svPending = load().then(function () {
			done();
			if ('static' === w.getComputedStyle(box).position) {
				box.style.position = 'relative';
			}

			var el = d.createElement('div');
			el.className = 'sraik-player sp-fill';
			el.setAttribute('data-sp-video', id);
			el.setAttribute('data-sp-autoplay', false === opt.autoplay ? '0' : '1');
			el.setAttribute('data-sp-ratio', '9:16' === ratio ? '9:16' : '16:9');
			if (start > 0) {
				el.setAttribute('data-sp-start', String(start));
			}
			if (opt.poster) {
				el.setAttribute('data-sp-poster', opt.poster);
			}
			el.setAttribute('tabindex', '0');
			el.setAttribute('role', 'region');
			el.setAttribute('aria-label', 'Video player');

			var poster = d.createElement('div');
			poster.className = 'sp-poster';
			poster.style.backgroundImage = 'url("' + String(opt.poster || ('https://i.ytimg.com/vi/' + id + '/hqdefault.jpg')).replace(/["\\\n\r]/g, '') + '")';
			el.appendChild(poster);
			var spin = d.createElement('div');
			spin.className = 'sp-spinner';
			spin.setAttribute('aria-hidden', 'true');
			el.appendChild(spin);

			box.appendChild(el);
			box.__svMounted = el;
			box.__svPending = null;
			if (opt.onMount) {
				try { opt.onMount(el); } catch (e) { /* host callback */ }
			}
			w.SraikPlayer.init();
			if (opt.focus) {
				try { el.focus({ preventScroll: true }); } catch (e) { el.focus(); }
			}
			return player(box);
		}, function () {
			done();
			box.__svPending = null;
			if (opt.fallback) {
				opt.fallback();
			}
			return null;
		});
		return box.__svPending;
	}

	/* ── markup-only boxes: <div data-sraik-video="…"> ── */

	function plainEmbed(box, id, start) {
		var f = d.createElement('iframe');
		f.src = 'https://www.youtube.com/embed/' + id + '?autoplay=1&rel=0' + (start ? '&start=' + start : '');
		f.allow = 'autoplay; encrypted-media; fullscreen; picture-in-picture';
		f.setAttribute('allowfullscreen', '');
		f.style.cssText = 'position:absolute;top:0;left:0;width:100%;height:100%;border:0;border-radius:inherit';
		if ('static' === w.getComputedStyle(box).position) {
			box.style.position = 'relative';
		}
		box.appendChild(f);
	}

	function bind(box) {
		if (box.__svBound) {
			return;
		}
		box.__svBound = true;
		var src = box.getAttribute('data-sraik-video');
		var img = box.querySelector('img');

		function hideCover() {
			box.classList.add('played');
			Array.prototype.forEach.call(box.children, function (c) {
				if (!c.classList.contains('sraik-player')) {
					c.style.display = 'none';
				}
			});
		}
		function go(byKey) {
			mount(box, {
				video: src,
				start: box.getAttribute('data-start'),
				ratio: box.getAttribute('data-ratio'),
				poster: box.getAttribute('data-poster') || (img ? (img.currentSrc || img.src) : ''),
				focus: byKey,
				onMount: hideCover,
				fallback: function () {
					hideCover();
					plainEmbed(box, parseId(src), parseInt(box.getAttribute('data-start'), 10) || parseStart(src));
				}
			});
		}
		if (!box.hasAttribute('tabindex')) {
			box.setAttribute('tabindex', '0');
		}
		if (!box.hasAttribute('role')) {
			box.setAttribute('role', 'button');
		}
		box.addEventListener('click', function (e) {
			if (!box.__svMounted && !(e.target.closest && e.target.closest('.sraik-player'))) {
				go(false);
			}
		});
		box.addEventListener('keydown', function (e) {
			if (e.target === box && !box.__svMounted && ('Enter' === e.key || ' ' === e.key)) {
				e.preventDefault();
				go(true);
			}
		});
		watch(box);
	}

	function scan() {
		Array.prototype.forEach.call(d.querySelectorAll('[data-sraik-video]'), bind);
	}

	w.SraikVideo = {
		mount: mount,
		watch: watch,
		load: load,
		player: player,
		parseId: parseId,
		parseStart: parseStart,
		scan: scan
	};

	if ('loading' === d.readyState) {
		d.addEventListener('DOMContentLoaded', scan);
	} else {
		scan();
	}
})(window, document);
