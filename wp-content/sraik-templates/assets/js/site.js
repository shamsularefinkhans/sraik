/*!
 * site.js — sraik.com front end. No dependencies (Lenis is optional).
 *
 *   nav           scrolled border, mobile / tablet menu
 *   [data-appear] fade + rise into view (the template's appear animation)
 *   [data-acc]    accordions (FAQ, curriculum); one open at a time per group
 *   [data-tabs]   tab sets (pricing toggle, legal tabs, filters)
 *   [data-price]  pricing values swapped by the pricing toggle
 *   [data-countdown] Bengali live countdown to an ISO date
 *   [data-copy]   copy-to-clipboard buttons
 *   [data-toc]    in-page table of contents: highlights the section in view
 *   Lenis         smooth scroll with the template's own settings
 */
(function () {
	'use strict';

	var d = document, w = window;
	var reduce = w.matchMedia && w.matchMedia('(prefers-reduced-motion: reduce)').matches;

	function $$(sel, root) { return Array.prototype.slice.call((root || d).querySelectorAll(sel)); }

	/* ---------- nav ---------- */
	var nav = d.getElementById('nav');
	var burger = nav && nav.querySelector('.nav-burger');
	var mnav = d.getElementById('mnav');

	function onScroll() {
		if (nav) { nav.classList.toggle('is-scrolled', w.scrollY > 8); }
	}
	w.addEventListener('scroll', onScroll, { passive: true });
	onScroll();

	function setMenu(open) {
		if (!nav || !burger) { return; }
		nav.classList.toggle('is-open', open);
		burger.setAttribute('aria-expanded', open ? 'true' : 'false');
		burger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
		d.body.classList.toggle('menu-open', open);
		if (w.__lenis) { open ? w.__lenis.stop() : w.__lenis.start(); }
	}
	if (burger) {
		burger.addEventListener('click', function () { setMenu(!nav.classList.contains('is-open')); });
		d.addEventListener('keydown', function (e) { if ('Escape' === e.key) { setMenu(false); } });
		if (mnav) { mnav.addEventListener('click', function (e) { if (e.target.closest('a')) { setMenu(false); } }); }
		w.addEventListener('resize', function () { if (w.innerWidth >= 1200) { setMenu(false); } });
	}

	/* ---------- appear on scroll ---------- */
	var appear = $$('[data-appear]');
	if (reduce || !('IntersectionObserver' in w)) {
		appear.forEach(function (el) { el.classList.add('in'); });
	} else {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (en) {
				if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
			});
		}, { rootMargin: '0px 0px -8% 0px', threshold: 0.01 });
		appear.forEach(function (el) { io.observe(el); });
		/* Anything already on screen at load animates immediately. */
		w.addEventListener('load', function () {
			appear.forEach(function (el) {
				var r = el.getBoundingClientRect();
				if (r.top < w.innerHeight && r.bottom > 0) { el.classList.add('in'); }
			});
		});
	}

	/* ---------- accordions ---------- */
	$$('[data-acc]').forEach(function (group) {
		var single = 'multi' !== group.getAttribute('data-acc');
		group.addEventListener('click', function (e) {
			var btn = e.target.closest('[data-acc-btn]');
			if (!btn || !group.contains(btn)) { return; }
			var item = btn.closest('[data-acc-item]');
			var open = !item.classList.contains('is-open');
			if (single) {
				$$('[data-acc-item].is-open', group).forEach(function (it) {
					if (it !== item && it.closest('[data-acc]') === group) { toggle(it, false); }
				});
			}
			toggle(item, open);
		});
	});
	function toggle(item, open) {
		var btn = item.querySelector('[data-acc-btn]');
		var panel = item.querySelector('[data-acc-panel]');
		item.classList.toggle('is-open', open);
		if (btn) { btn.setAttribute('aria-expanded', open ? 'true' : 'false'); }
		if (!panel) { return; }
		if (reduce) { panel.style.height = open ? 'auto' : '0px'; return; }
		var from = panel.getBoundingClientRect().height;
		panel.style.height = 'auto';
		var to = open ? panel.scrollHeight : 0;
		panel.style.height = from + 'px';
		panel.offsetHeight; // reflow
		panel.style.height = to + 'px';
		var done = function (ev) {
			if (ev.propertyName !== 'height') { return; }
			panel.removeEventListener('transitionend', done);
			if (item.classList.contains('is-open')) { panel.style.height = 'auto'; }
		};
		panel.addEventListener('transitionend', done);
	}
	/* Deep link: /faq/#q-12 opens that question — on load and on in-page jumps. */
	function openFromHash() {
		if (!location.hash) { return; }
		var target = d.getElementById(decodeURIComponent(location.hash.slice(1)));
		if (target && target.hasAttribute('data-acc-item') && !target.classList.contains('is-open')) { toggle(target, true); }
	}
	openFromHash();
	w.addEventListener('hashchange', openFromHash);

	/* ---------- tabs ---------- */
	$$('[data-tabs]').forEach(function (set) {
		var tabs = $$('[data-tab]', set);
		var scope = set.getAttribute('data-tabs') ? d.querySelector(set.getAttribute('data-tabs')) : null;
		tabs.forEach(function (tab) {
			tab.addEventListener('click', function (e) {
				if (tab.tagName === 'A' && tab.getAttribute('href') && tab.getAttribute('href').charAt(0) !== '#') { return; }
				e.preventDefault();
				var key = tab.getAttribute('data-tab');
				tabs.forEach(function (t) {
					var on = t === tab;
					t.classList.toggle('is-active', on);
					t.setAttribute('aria-selected', on ? 'true' : 'false');
				});
				set.setAttribute('data-active', key);
				set.dispatchEvent(new CustomEvent('tabchange', { detail: key, bubbles: true }));
				if (scope) {
					$$('[data-panel]', scope).forEach(function (p) {
						var show = p.getAttribute('data-panel') === key || 'all' === key;
						p.hidden = !show;
					});
					$$('[data-price]', scope).forEach(function (el) {
						var v = el.getAttribute('data-price-' + key);
						if (null !== v) { el.textContent = v; }
					});
				}
			});
		});
	});

	/* ---------- countdown (Bengali digits) ---------- */
	var BN = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
	function bn(n) { return String(n).replace(/[0-9]/g, function (c) { return BN[+c]; }); }
	function pad(n) { return (n < 10 ? '0' : '') + n; }
	$$('[data-countdown]').forEach(function (el) {
		var end = new Date(el.getAttribute('data-countdown')).getTime();
		if (isNaN(end)) { return; }
		var parts = { d: el.querySelector('[data-d]'), h: el.querySelector('[data-h]'), m: el.querySelector('[data-m]'), s: el.querySelector('[data-s]') };
		function tick() {
			var diff = end - Date.now();
			if (diff <= 0) {
				el.classList.add('is-over');
				var over = el.getAttribute('data-over');
				if (over) { el.querySelector('[data-cd-text]') && (el.querySelector('[data-cd-text]').textContent = over); }
				clearInterval(t);
				return;
			}
			var v = { d: Math.floor(diff / 864e5), h: Math.floor(diff % 864e5 / 36e5), m: Math.floor(diff % 36e5 / 6e4), s: Math.floor(diff % 6e4 / 1e3) };
			Object.keys(parts).forEach(function (k) { if (parts[k]) { parts[k].textContent = bn(pad(v[k])); } });
		}
		var t = setInterval(tick, 1000);
		tick();
	});

	/* ---------- copy buttons ---------- */
	$$('[data-copy]').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var text = btn.getAttribute('data-copy');
			var done = function () { btn.classList.add('is-copied'); setTimeout(function () { btn.classList.remove('is-copied'); }, 1400); };
			if (navigator.clipboard) { navigator.clipboard.writeText(text).then(done, function () {}); }
		});
	});

	/* ---------- table of contents highlight ---------- */
	$$('[data-toc]').forEach(function (toc) {
		var links = $$('a[href^="#"]', toc);
		var map = {};
		links.forEach(function (a) { var s = d.getElementById(a.getAttribute('href').slice(1)); if (s) { map[s.id] = a; } });
		var secs = Object.keys(map).map(function (id) { return d.getElementById(id); });
		if (!secs.length || !('IntersectionObserver' in w)) { return; }
		var current = toc.querySelector('a.is-active');
		var obs = new IntersectionObserver(function (entries) {
			entries.forEach(function (en) {
				if (en.isIntersecting) {
					if (current) { current.classList.remove('is-active'); }
					current = map[en.target.id];
					current.classList.add('is-active');
				}
			});
		}, { rootMargin: '-20% 0px -70% 0px' });
		secs.forEach(function (s) { obs.observe(s); });
	});

	/* ---------- "watch the video" buttons ---------- */
	$$('[data-play-intro]').forEach(function (btn) {
		btn.addEventListener('click', function (e) {
			var wrap = d.getElementById('intro');
			var box = wrap && wrap.querySelector('[data-sraik-video]');
			if (!box) { return; }
			e.preventDefault();
			var go = function () { box.click(); };
			if (w.__lenis) { w.__lenis.scrollTo(wrap, { offset: -100, onComplete: go }); } else { wrap.scrollIntoView({ behavior: reduce ? 'auto' : 'smooth', block: 'center' }); setTimeout(go, 500); }
		});
	});

	/* ---------- smooth scroll (template settings) ---------- */
	function startLenis() {
		if (reduce || !w.Lenis || w.__lenis) { return; }
		var lenis = new w.Lenis({
			duration: 1.2,
			easing: function (t) { return Math.min(1, 1.001 - Math.pow(2, -10 * t)); },
			smoothWheel: true,
			touchMultiplier: 2
		});
		w.__lenis = lenis;
		function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
		requestAnimationFrame(raf);
		/* In-page anchors go through Lenis so they glide like the template. */
		d.addEventListener('click', function (e) {
			var a = e.target.closest('a[href*="#"]');
			if (!a || e.defaultPrevented) { return; }
			var url = new URL(a.href, location.href);
			if (url.pathname !== location.pathname || !url.hash || url.hash.length < 2) { return; }
			var el = d.getElementById(decodeURIComponent(url.hash.slice(1)));
			if (!el) { return; }
			e.preventDefault();
			lenis.scrollTo(el, { offset: -88 });
			history.replaceState(null, '', url.hash);
			openFromHash();
		});
	}
	if (w.Lenis) { startLenis(); } else { w.addEventListener('load', startLenis); }
})();
