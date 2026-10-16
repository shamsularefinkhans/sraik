/*!
 * SRAIK Player 1.3.0
 * Custom YouTube player for Tutor LMS lessons.
 *
 * Talks to YouTube through the official IFrame Player API and to Tutor
 * through the same two AJAX actions Tutor Player uses (sync_video_playback,
 * autoload_next_course_content), reading Tutor's own hidden tracking input.
 * Exposes window.TutorLessonPlayer with the currentTime / play() surface
 * that Tutor Pro's lesson notes expect.
 */
(function (window, document) {
	'use strict';

	if (window.SraikPlayer) {
		return;
	}

	var YT_STATE = { UNSTARTED: -1, ENDED: 0, PLAYING: 1, PAUSED: 2, BUFFERING: 3, CUED: 5 };
	var QUALITY = { auto: 'Auto', high: 'High (HD)', saver: 'Data saver' };
	var UNCROP_AFTER = 4000;
	var STORE = 'sraikPlayer.';
	var noop = function () {};

	/* ─────────────────────────── helpers ─────────────────────────── */

	function load(key, fallback) {
		try {
			var v = window.localStorage.getItem(STORE + key);
			return null === v ? fallback : v;
		} catch (e) {
			return fallback;
		}
	}

	function save(key, value) {
		try {
			window.localStorage.setItem(STORE + key, String(value));
		} catch (e) { /* private mode */ }
	}

	function clamp(v, min, max) {
		return Math.min(max, Math.max(min, v));
	}

	function fmt(sec) {
		sec = Math.max(0, Math.floor(Number(sec) || 0));
		var h = Math.floor(sec / 3600);
		var m = Math.floor((sec % 3600) / 60);
		var s = sec % 60;
		return (h ? h + ':' + (m < 10 ? '0' : '') : '') + m + ':' + (s < 10 ? '0' : '') + s;
	}

	function esc(str) {
		return String(str).replace(/[&<>"']/g, function (c) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
		});
	}

	function tutorConfig() {
		var core = window.TutorCore;
		if (core && core.config && core.config.tutorConfig) {
			return core.config.tutorConfig;
		}
		return window._tutorobject || {};
	}

	/* Same transport Tutor's own player uses; plain admin-ajax as a fallback. */
	function wpPost(action, data) {
		var core = window.TutorCore;
		try {
			if (core && core.api && 'function' === typeof core.api.wpPost) {
				return Promise.resolve(core.api.wpPost(action, data)).then(null, function () { return {}; });
			}
		} catch (e) { /* fall through */ }

		var o = window._tutorobject || {};
		var body = new FormData();
		body.append('action', action);
		Object.keys(data || {}).forEach(function (k) {
			body.append(k, String(data[k]));
		});
		if (o.nonce_key && o[o.nonce_key]) {
			body.append(o.nonce_key, o[o.nonce_key]);
		}
		return window.fetch(o.ajaxurl || '/wp-admin/admin-ajax.php', { method: 'POST', credentials: 'same-origin', body: body })
			.then(function (r) { return r.json(); })
			.then(null, function () { return {}; });
	}

	/* ─────────────────────────── icons ─────────────────────────── */

	var LINE = 'fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"';

	function svg(inner, cls) {
		return '<svg class="sp-ico ' + cls + '" width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" focusable="false">' + inner + '</svg>';
	}

	var I = {
		play: svg('<path d="M8 5.6v12.8a1 1 0 0 0 1.53.85l10.1-6.4a1 1 0 0 0 0-1.7L9.53 4.75A1 1 0 0 0 8 5.6z" fill="currentColor"/>', 'i-play'),
		pause: svg('<rect x="6" y="5" width="4" height="14" rx="1.2" fill="currentColor"/><rect x="14" y="5" width="4" height="14" rx="1.2" fill="currentColor"/>', 'i-pause'),
		replay: svg('<path d="M12 4.5A7.5 7.5 0 1 1 4.87 9.68" ' + LINE + '/><path d="M14.5 2 12 4.5 14.5 7" ' + LINE + '/>', 'i-replay'),
		back: svg('<path d="M12 4.5A7.5 7.5 0 1 1 4.87 9.68" ' + LINE + '/><path d="M14.5 2 12 4.5 14.5 7" ' + LINE + '/>', 'i-back'),
		fwd: svg('<path d="M12 4.5A7.5 7.5 0 1 0 19.13 9.68" ' + LINE + '/><path d="M9.5 2 12 4.5 9.5 7" ' + LINE + '/>', 'i-fwd'),
		vol: svg('<path d="M4 9.5h3.2L11.5 6v12l-4.3-3.5H4z" fill="currentColor"/><path d="M15.2 9.2a4 4 0 0 1 0 5.6M17.8 6.6a7.6 7.6 0 0 1 0 10.8" ' + LINE + '/>', 'i-vol'),
		mute: svg('<path d="M4 9.5h3.2L11.5 6v12l-4.3-3.5H4z" fill="currentColor"/><path d="m15.5 9.5 5 5m0-5-5 5" ' + LINE + '/>', 'i-mute'),
		cc: svg('<rect x="3" y="5.5" width="18" height="13" rx="2.5" ' + LINE + '/><path d="M10.6 10.2a2.3 2.3 0 1 0 0 3.6M16.8 10.2a2.3 2.3 0 1 0 0 3.6" ' + LINE + '/>', 'i-cc'),
		gear: svg('<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" ' + LINE + ' stroke-width="1.8"/><circle cx="12" cy="12" r="3" ' + LINE + ' stroke-width="1.8"/>', 'i-gear'),
		fsOn: svg('<path d="M4 9V5.5A1.5 1.5 0 0 1 5.5 4H9M15 4h3.5A1.5 1.5 0 0 1 20 5.5V9M20 15v3.5a1.5 1.5 0 0 1-1.5 1.5H15M9 20H5.5A1.5 1.5 0 0 1 4 18.5V15" ' + LINE + '/>', 'i-fson'),
		fsOff: svg('<path d="M9 4v3.5A1.5 1.5 0 0 1 7.5 9H4M20 9h-3.5A1.5 1.5 0 0 1 15 7.5V4M15 20v-3.5a1.5 1.5 0 0 1 1.5-1.5H20M4 15h3.5A1.5 1.5 0 0 1 9 16.5V20" ' + LINE + '/>', 'i-fsoff'),
		next: svg('<path d="m9.5 6 6 6-6 6" ' + LINE + '/>', 'i-next'),
		prev: svg('<path d="m14.5 6-6 6 6 6" ' + LINE + '/>', 'i-prev'),
		check: svg('<path d="m5 12.5 4.5 4.5L19 7.5" ' + LINE + '/>', 'i-check')
	};

	/* ─────────────────────── YouTube API loader ─────────────────────── */

	var ytQueue = [];
	var ytRequested = false;

	function ytAvailable() {
		return !!(window.YT && 'function' === typeof window.YT.Player);
	}

	function flushYT() {
		if (!ytAvailable()) {
			return;
		}
		var q = ytQueue.splice(0);
		q.forEach(function (fn) {
			try { fn(); } catch (e) { /* keep others alive */ }
		});
	}

	function whenYT(fn) {
		if (ytAvailable()) {
			fn();
			return;
		}
		ytQueue.push(fn);
		if (ytRequested) {
			return;
		}
		ytRequested = true;

		/* Chain, never replace, anyone else's ready callback. */
		var previous = window.onYouTubeIframeAPIReady;
		window.onYouTubeIframeAPIReady = function () {
			if ('function' === typeof previous) {
				try { previous(); } catch (e) { /* not ours */ }
			}
			flushYT();
		};

		if (window.YT && 'function' === typeof window.YT.ready) {
			window.YT.ready(flushYT);
		} else if (!document.querySelector('script[src*="youtube.com/iframe_api"]')) {
			var s = document.createElement('script');
			s.src = 'https://www.youtube.com/iframe_api';
			s.async = true;
			(document.head || document.documentElement).appendChild(s);
		}

		/* Belt and braces for a loader that swallowed the callback. */
		var tries = 0;
		var poll = window.setInterval(function () {
			tries++;
			if (ytAvailable()) {
				window.clearInterval(poll);
				flushYT();
			} else if (tries > 150) {
				window.clearInterval(poll);
			}
		}, 200);
	}

	/* ─────────────────────────── player ─────────────────────────── */

	function Player(root) {
		this.root = root;
		this.videoId = root.getAttribute('data-sp-video') || '';
		this.skipBy = parseInt(root.getAttribute('data-sp-skip'), 10) || 5;
		if ([5, 10, 15].indexOf(this.skipBy) < 0) {
			this.skipBy = 5;
		}

		this.yt = null;
		this.ready = false;
		this.started = false;
		this.ended = false;
		this.wantsPlay = false;
		this.queuedPlay = false;
		this.ytState = YT_STATE.UNSTARTED;
		this.cur = 0;
		this.buffered = 0;
		this.scrubTime = 0;
		this.dragging = false;
		this.lastSeekAt = 0;
		this.uiVisible = true;
		this.menuOpen = false;
		this.menuView = 'main';
		this.fake = false;
		this.touch = !!(window.matchMedia && window.matchMedia('(hover: none)').matches);
		/* iPhone / iPad Safari ignores volume set by a page — only mute works there. */
		this.ios = /iP(hone|od|ad)/.test(navigator.userAgent || '') || ('MacIntel' === navigator.platform && navigator.maxTouchPoints > 1);
		this.volOpen = false;

		this.rates = [0.5, 0.75, 1, 1.25, 1.5, 1.75, 2];
		this.rate = parseFloat(load('rate', '1')) || 1;
		this.volume = clamp(parseInt(load('vol', '100'), 10) || 0, 0, 100);
		this.muted = '1' === load('muted', '0');

		this.quality = load('quality', 'auto');
		if (!QUALITY[this.quality]) {
			this.quality = 'auto';
		}
		this.uncrop = false;

		this.tracks = [];
		this.ccKey = null;
		this.ccWanted = load('cc', 'off');
		this.ccApplied = false;
		this.ccLoading = false;
		this.ccNone = false;
		this.ccAsked = false;

		this.listeners = {};
		this.timers = {};

		/* Tutor tracking: only the lesson's main player reports watch time. */
		this.track = !!root.closest('.tutor-lesson-video-wrapper');
		this.data = this.track ? this.readTrackingData() : {};
		var cfg = tutorConfig();
		this.pro = !!cfg.tutor_pro_url;
		this.autoNext = cfg.user_preferences && 'undefined' !== typeof cfg.user_preferences.auto_play_next
			? !!cfg.user_preferences.auto_play_next
			: !!this.data.autoload_next_course_content;
		this.strict = this.track && !!(this.pro && this.data.is_enrolled && !this.data.lesson_completed && this.data.strict_mode && this.data.control_video_lesson_completion);
		this.maxSeek = Number(this.data.best_watch_time) || 0;
		this.playedOnce = false;

		/* Resume point — Tutor Pro only, exactly as Tutor Player does it. */
		this.startAt = 0;
		var best = Number(this.data.best_watch_time) || 0;
		var known = Number(this.data.video_duration) || 0;
		if (this.pro && best > 0 && (!known || best < known - 3)) {
			this.startAt = Math.floor(best);
		}
		/* Embedding options (landing pages): a start time and autoplay-on-mount. */
		var optStart = parseInt(root.getAttribute('data-sp-start'), 10);
		if (!this.startAt && optStart > 0) {
			this.startAt = optStart;
		}
		this.autoplay = '1' === root.getAttribute('data-sp-autoplay');
		if (this.autoplay) {
			this.queuedPlay = true;
			this.wantsPlay = true;
		}
		/* 9:16 videos: the stage takes the video's shape, so the crop stays exact. */
		if ('9:16' === root.getAttribute('data-sp-ratio')) {
			root.classList.add('sp-portrait');
		}
		this.cur = this.startAt;

		this.build();
		this.bind();
		this.facade = this.makeFacade();

		if (this.strict) {
			this.disableCompleteBtn();
		}

		var self = this;
		whenYT(function () { self.create(); });
	}

	var P = Player.prototype;

	P.readTrackingData = function () {
		var el = document.getElementById('tutor_video_tracking_information');
		if (!el || !el.value) {
			return {};
		}
		try {
			return JSON.parse(el.value) || {};
		} catch (e) {
			return {};
		}
	};

	/* ── DOM ── */

	P.build = function () {
		var r = this.root;
		var n = this.skipBy;
		var poster = r.querySelector('.sp-poster');
		var spinner = r.querySelector('.sp-spinner');

		var html = '' +
			'<div class="sp-stage"><div class="sp-media"><div class="sp-yt"></div></div></div>' +
			'<div class="sp-shield" aria-hidden="true"></div>' +
			'<div class="sp-scrim" aria-hidden="true"></div>' +
			'<div class="sp-ripple sp-ripple--l" aria-hidden="true">' + I.back + '<span class="sp-ripple-txt"></span></div>' +
			'<div class="sp-ripple sp-ripple--r" aria-hidden="true">' + I.fwd + '<span class="sp-ripple-txt"></span></div>' +
			'<div class="sp-center">' +
				'<button type="button" class="sp-btn sp-cskip" data-act="back" aria-label="Back ' + n + ' seconds">' + I.back + '<span class="sp-num">' + n + '</span></button>' +
				'<button type="button" class="sp-btn sp-big" data-act="play" aria-label="Play">' + I.play + I.pause + I.replay + '</button>' +
				'<button type="button" class="sp-btn sp-cskip" data-act="fwd" aria-label="Forward ' + n + ' seconds">' + I.fwd + '<span class="sp-num">' + n + '</span></button>' +
			'</div>' +
			'<div class="sp-bar">' +
				'<div class="sp-progress" role="slider" tabindex="0" aria-label="Seek" aria-valuemin="0" aria-valuemax="0" aria-valuenow="0" aria-valuetext="0:00">' +
					'<div class="sp-track"><div class="sp-buffer"></div><div class="sp-played"></div></div>' +
					'<div class="sp-thumb"></div>' +
					'<div class="sp-tip">0:00</div>' +
				'</div>' +
				'<div class="sp-row">' +
					'<button type="button" class="sp-btn sp-play" data-act="play" aria-label="Play">' + I.play + I.pause + I.replay + '</button>' +
					'<button type="button" class="sp-btn sp-skip" data-act="back" aria-label="Back ' + n + ' seconds">' + I.back + '<span class="sp-num">' + n + '</span></button>' +
					'<button type="button" class="sp-btn sp-skip" data-act="fwd" aria-label="Forward ' + n + ' seconds">' + I.fwd + '<span class="sp-num">' + n + '</span></button>' +
					'<div class="sp-vol">' +
						'<button type="button" class="sp-btn sp-mute" data-act="mute" aria-label="Mute">' + I.vol + I.mute + '</button>' +
						'<div class="sp-volume" role="slider" tabindex="0" aria-label="Volume" aria-valuemin="0" aria-valuemax="100" aria-valuenow="100" aria-valuetext="100%">' +
							'<div class="sp-vtrack"><div class="sp-vfill"></div><div class="sp-vthumb"></div></div>' +
						'</div>' +
					'</div>' +
					'<div class="sp-time"><span class="sp-cur">0:00</span><span class="sp-sep">/</span><span class="sp-dur">0:00</span></div>' +
					'<div class="sp-spacer"></div>' +
					'<button type="button" class="sp-btn sp-ccb" data-act="cc" aria-label="Subtitles" aria-pressed="false">' + I.cc + '</button>' +
					'<button type="button" class="sp-btn sp-setb" data-act="menu" aria-label="Settings" aria-haspopup="menu" aria-expanded="false">' + I.gear + '</button>' +
					'<button type="button" class="sp-btn sp-fsb" data-act="fs" aria-label="Full screen">' + I.fsOn + I.fsOff + '</button>' +
				'</div>' +
			'</div>' +
			'<div class="sp-menu" role="menu" aria-label="Settings"></div>' +
			'<div class="sp-toast" role="status" aria-live="polite"></div>' +
			'<div class="sp-error" role="alert"></div>';

		r.insertAdjacentHTML('beforeend', html);

		if (!poster) {
			poster = document.createElement('div');
			poster.className = 'sp-poster';
		}
		if (!spinner) {
			spinner = document.createElement('div');
			spinner.className = 'sp-spinner';
			spinner.setAttribute('aria-hidden', 'true');
		}
		/* The poster lives in the 16:9 stage, above the media, below the shield. */
		r.querySelector('.sp-stage').appendChild(poster);
		r.insertBefore(spinner, r.querySelector('.sp-center'));

		this.el = {
			media: r.querySelector('.sp-yt'),
			poster: poster,
			shield: r.querySelector('.sp-shield'),
			rippleL: r.querySelector('.sp-ripple--l'),
			rippleR: r.querySelector('.sp-ripple--r'),
			bar: r.querySelector('.sp-bar'),
			progress: r.querySelector('.sp-progress'),
			buffer: r.querySelector('.sp-buffer'),
			played: r.querySelector('.sp-played'),
			thumb: r.querySelector('.sp-thumb'),
			tip: r.querySelector('.sp-tip'),
			cur: r.querySelector('.sp-cur'),
			dur: r.querySelector('.sp-dur'),
			volume: r.querySelector('.sp-volume'),
			vfill: r.querySelector('.sp-vfill'),
			vthumb: r.querySelector('.sp-vthumb'),
			ccb: r.querySelector('.sp-ccb'),
			setb: r.querySelector('.sp-setb'),
			fsb: r.querySelector('.sp-fsb'),
			menu: r.querySelector('.sp-menu'),
			toast: r.querySelector('.sp-toast'),
			error: r.querySelector('.sp-error')
		};

		this.paintVolume();

		if (!r.getAttribute('data-sp-poster')) {
			this.upgradePoster();
		}

		r.classList.add('sp-init', 'sp-ui');
		r.classList.toggle('sp-touch', this.touch);
		this.syncClasses();
		this.render();
	};

	/* hqdefault is printed by PHP; swap in a sharper frame if YouTube has one. */
	P.upgradePoster = function () {
		var self = this;
		var sizes = ['maxresdefault', 'sddefault'];
		(function next(i) {
			if (i >= sizes.length) {
				return;
			}
			var img = new Image();
			img.onload = function () {
				if (img.naturalWidth > 121) {
					self.el.poster.style.backgroundImage = 'url("' + img.src + '")';
				} else {
					next(i + 1);
				}
			};
			img.onerror = function () { next(i + 1); };
			img.src = 'https://i.ytimg.com/vi/' + self.videoId + '/' + sizes[i] + '.jpg';
		})(0);
	};

	P.create = function () {
		var self = this;
		var vars = {
			autoplay: this.autoplay ? 1 : 0,
			controls: 0,
			disablekb: 1,
			fs: 0,
			playsinline: 1,
			rel: 0,
			showinfo: 0,
			iv_load_policy: 3,
			modestbranding: 1,
			enablejsapi: 1,
			origin: window.location.origin,
			widget_referrer: window.location.href
		};
		if (this.startAt > 0) {
			vars.start = this.startAt;
		}
		if ('off' !== this.ccWanted) {
			vars.cc_load_policy = 1;
		}

		this.yt = new window.YT.Player(this.el.media, {
			videoId: this.videoId,
			width: '100%',
			height: '100%',
			playerVars: vars,
			events: {
				onReady: function () { self.onReady(); },
				onStateChange: function (e) { self.onState(e.data); },
				onPlaybackRateChange: function (e) { self.rate = Number(e.data) || self.rate; self.renderMenu(); },
				onApiChange: function () { self.onApiChange(); },
				onError: function (e) { self.onError(e.data); }
			}
		});
	};

	/* ── YouTube events ── */

	P.onReady = function () {
		var yt = this.yt;
		this.ready = true;

		try {
			var frame = yt.getIframe();
			frame.setAttribute('tabindex', '-1');
			frame.setAttribute('title', 'Lesson video');
		} catch (e) { /* cosmetic */ }

		try {
			var list = yt.getAvailablePlaybackRates();
			if (list && list.length) {
				this.rates = list.filter(function (r) { return r >= 0.25 && r <= 4; });
			}
		} catch (e) { /* keep defaults */ }
		if (this.rates.indexOf(this.rate) < 0) {
			this.rate = 1;
		}
		this.applyRate();
		this.applyVolume();

		this.syncClasses();
		this.render();

		if (this.track) {
			this.syncTime();
			window.TutorLessonPlayer = this.facade;
			try {
				window.dispatchEvent(new CustomEvent('tutorLessonPlayerReady', { detail: { player: this.facade } }));
			} catch (e) { /* very old browser */ }
		}
		this.emit('ready');

		if (this.queuedPlay) {
			this.queuedPlay = false;
			this.play();
		}
	};

	P.onState = function (s) {
		this.ytState = s;
		var self = this;

		if (YT_STATE.PLAYING === s) {
			this.armUncrop();
		} else {
			this.forceCrop();
		}

		switch (s) {
			case YT_STATE.PLAYING:
				if (!this.started) {
					this.started = true;
					this.firstPlay();
				}
				this.ended = false;
				this.wantsPlay = true;
				this.clearPassthrough();
				this.startTick();
				this.scheduleHide();
				if (this.track) {
					this.stopSync();
					this.playedOnce = true;
					if (this.pro) {
						this.timers.sync = window.setInterval(function () { self.syncTime(); }, 10000);
					}
				}
				this.emit('play');
				this.emit('playing');
				break;

			case YT_STATE.PAUSED:
				this.wantsPlay = false;
				this.stopTick();
				this.readTime();
				this.setUi(true);
				if (this.track) {
					this.stopSync();
					if (this.pro) {
						this.syncTime();
					}
				}
				this.emit('pause');
				break;

			case YT_STATE.ENDED:
				this.ended = true;
				this.wantsPlay = false;
				this.stopTick();
				this.cur = this.duration();
				this.setUi(true);
				this.closeMenu();
				if (this.track) {
					this.stopSync();
					this.syncTime({ is_ended: true });
					if (this.autoNext && this.playedOnce) {
						this.autoload();
					}
				}
				this.emit('ended');
				break;

			case YT_STATE.BUFFERING:
				this.startTick();
				break;
		}

		this.syncClasses();
		this.render();
	};

	P.firstPlay = function () {
		/* YouTube can reset the rate when playback begins; re-apply the saved one. */
		var pref = parseFloat(load('rate', '1')) || 1;
		if (this.rates.indexOf(pref) > -1) {
			this.rate = pref;
		}
		this.applyRate();
		if ('off' !== this.ccWanted && !this.tracks.length) {
			this.loadCaptions();
		}
	};

	P.onError = function (code) {
		var msg = 'This video can\'t be played right now.';
		if (100 === code) {
			msg = 'This video is unavailable.';
		} else if (101 === code || 150 === code) {
			msg = 'This video can\'t be played here.';
		}
		this.showError(msg);
	};

	P.showError = function (msg) {
		this.errored = true;
		this.wantsPlay = false;
		this.queuedPlay = false;
		this.stopTick();
		this.clearPassthrough();
		this.el.error.textContent = msg;
		this.syncClasses();
	};

	/* ── time ── */

	P.duration = function () {
		var d = 0;
		if (this.ready) {
			try { d = Number(this.yt.getDuration()) || 0; } catch (e) { d = 0; }
		}
		return d || Number(this.data.video_duration) || 0;
	};

	P.time = function () {
		if (!this.ready || Date.now() - this.lastSeekAt < 700) {
			return this.cur;
		}
		try {
			return Number(this.yt.getCurrentTime()) || 0;
		} catch (e) {
			return this.cur;
		}
	};

	P.readTime = function () {
		this.cur = this.time();
		try { this.buffered = Number(this.yt.getVideoLoadedFraction()) || 0; } catch (e) { /* keep */ }
	};

	P.startTick = function () {
		if (this.timers.tick) {
			return;
		}
		var self = this;
		this.timers.tick = window.setInterval(function () { self.tick(); }, 250);
	};

	P.stopTick = function () {
		window.clearInterval(this.timers.tick);
		this.timers.tick = null;
	};

	P.tick = function () {
		if (!this.ready) {
			return;
		}
		this.readTime();
		/* Only natural playback extends the strict-mode limit; seeks are guarded. */
		if (YT_STATE.PLAYING === this.ytState && Date.now() - this.lastSeekAt > 1500 && this.cur > this.maxSeek) {
			this.maxSeek = this.cur;
		}
		this.syncClasses();
		this.render();
		this.emit('timeupdate');
	};

	/* ── transport ── */

	P.play = function () {
		if (this.errored) {
			return;
		}
		if (!this.ready) {
			this.queuedPlay = true;
			this.wantsPlay = true;
			this.syncClasses();
			var self = this;
			window.clearTimeout(this.timers.loadFail);
			this.timers.loadFail = window.setTimeout(function () {
				if (!self.ready) {
					self.showError('Couldn\'t load the video. Check your connection and refresh the page.');
				}
			}, 15000);
			return;
		}
		if (this.ended) {
			this.lastSeekAt = Date.now();
			this.cur = 0;
			this.yt.seekTo(0, true);
		}
		this.wantsPlay = true;
		this.yt.playVideo();
		this.armPassthrough();
		this.syncClasses();
	};

	P.pause = function () {
		/* Crop first, so YouTube's pause overlay is never on screen for a frame. */
		this.forceCrop();
		this.wantsPlay = false;
		this.queuedPlay = false;
		if (this.ready) {
			this.yt.pauseVideo();
		}
		this.syncClasses();
	};

	P.togglePlay = function () {
		if (this.wantsPlay && !this.ended) {
			this.pause();
		} else {
			this.play();
		}
	};

	/*
	 * Some mobile browsers refuse an API-started play without a gesture inside
	 * the frame. If nothing has started a moment after a tap, let the next tap
	 * fall through to YouTube itself; the shield comes back once playing.
	 */
	P.armPassthrough = function () {
		var self = this;
		window.clearTimeout(this.timers.pass);
		this.timers.pass = window.setTimeout(function () {
			var s = self.ytState;
			if (self.wantsPlay && !self.errored && YT_STATE.PLAYING !== s && YT_STATE.BUFFERING !== s) {
				self.root.classList.add('sp-passthrough');
				self.toast('Tap the video once more to play');
			}
		}, 2500);
	};

	P.clearPassthrough = function () {
		window.clearTimeout(this.timers.pass);
		this.root.classList.remove('sp-passthrough');
	};

	/* Strict mode: never past the furthest point actually watched. */
	P.guard = function (target) {
		if (!this.strict) {
			return target;
		}
		var now = this.time();
		var limit = Math.max(now, this.maxSeek);
		if (target <= limit + 1) {
			return target;
		}
		this.toast('Forward seeking is disabled');
		return limit > now + 1 ? limit : null;
	};

	P.seek = function (target, skipGuard) {
		target = Number(target);
		if (!isFinite(target) || this.errored) {
			return;
		}
		var d = this.duration();
		target = d ? clamp(target, 0, Math.max(0, d - 0.1)) : Math.max(0, target);
		if (!skipGuard) {
			target = this.guard(target);
			if (null === target) {
				return;
			}
		}
		this.cur = target;
		this.lastSeekAt = Date.now();
		if (this.ended && target < d - 0.5) {
			this.ended = false;
		}
		if (this.ready) {
			this.yt.seekTo(target, true);
			/* From a cued (never played) state YouTube starts playing on seek. */
			if (!this.started) {
				this.wantsPlay = true;
				this.armPassthrough();
			}
		}
		this.syncClasses();
		this.render();
		this.emit('seeked');
	};

	P.skip = function (dir, fromTap) {
		if (!this.ready) {
			return;
		}
		this.seek(this.time() + dir * this.skipBy);
		this.ripple(dir, fromTap);
	};

	/*
	 * BRANDING CROP — the same geometry Tutor Pro uses for Tutor Player:
	 * the iframe is twice the stage height and shifted up by half, so
	 * YouTube's title bar (top) and logo / share / watch-later / more-videos
	 * (bottom) land in bands the stage clips away, while the 16:9 picture
	 * sits exactly in the visible box.
	 *
	 * The one thing YouTube may also draw in those bands is subtitles. So
	 * while subtitles are ON and the video has been playing steadily for a
	 * few seconds — the only time YouTube shows none of its chrome — the
	 * frame returns to normal size. The picture does not move when it does.
	 * Any pause, buffer, end or subtitles-off re-crops immediately.
	 */
	P.setCrop = function (cropped) {
		this.uncrop = !cropped;
		this.root.classList.toggle('sp-uncrop', this.uncrop);
	};

	P.forceCrop = function () {
		window.clearTimeout(this.timers.uncrop);
		this.setCrop(true);
	};

	P.armUncrop = function () {
		var self = this;
		window.clearTimeout(this.timers.uncrop);
		if (!this.ccKey || YT_STATE.PLAYING !== this.ytState || this.uncrop) {
			return;
		}
		this.timers.uncrop = window.setTimeout(function () {
			if (self.ccKey && self.wantsPlay && YT_STATE.PLAYING === self.ytState) {
				self.setCrop(false);
			}
		}, UNCROP_AFTER);
	};

	/* ── quality ── */

	P.setQuality = function (q) {
		if (!QUALITY[q]) {
			return;
		}
		this.quality = q;
		save('quality', q);
		this.syncClasses();
		this.renderMenu();
	};

	/* ── volume / speed ── */

	P.applyVolume = function () {
		if (!this.ready) {
			return;
		}
		try {
			this.yt.setVolume(this.volume);
			if (this.muted) {
				this.yt.mute();
			} else {
				this.yt.unMute();
			}
		} catch (e) { /* iOS ignores volume */ }
	};

	P.setVolume = function (v) {
		v = clamp(Math.round(v), 0, 100);
		this.muted = 0 === v;
		if (v > 0) {
			this.volume = v;
		}
		save('vol', this.volume);
		save('muted', this.muted ? 1 : 0);
		this.applyVolume();
		this.paintVolume();
		this.syncClasses();
	};

	P.toggleMute = function () {
		this.muted = !this.muted;
		if (!this.muted && !this.volume) {
			this.volume = 50;
		}
		save('muted', this.muted ? 1 : 0);
		save('vol', this.volume);
		this.applyVolume();
		this.paintVolume();
		this.syncClasses();
	};

	/* Touch only: the slider slides out on demand and tucks itself away again. */
	P.setVolOpen = function (on) {
		var self = this;
		window.clearTimeout(this.timers.vol);
		this.volOpen = !!on;
		this.root.classList.toggle('sp-vol-open', this.volOpen);
		if (this.volOpen) {
			this.timers.vol = window.setTimeout(function () { self.setVolOpen(false); }, 3000);
		}
		this.syncClasses();
	};

	P.paintVolume = function () {
		var v = this.muted ? 0 : this.volume;
		this.el.vfill.style.width = v + '%';
		this.el.vthumb.style.left = v + '%';
		this.el.volume.setAttribute('aria-valuenow', String(v));
		this.el.volume.setAttribute('aria-valuetext', v + '%');
	};

	P.applyRate = function () {
		if (!this.ready) {
			return;
		}
		try { this.yt.setPlaybackRate(this.rate); } catch (e) { /* unsupported */ }
	};

	P.setRate = function (r) {
		r = Number(r);
		if (this.rates.indexOf(r) < 0) {
			return;
		}
		this.rate = r;
		save('rate', r);
		this.applyRate();
		this.renderMenu();
	};

	/* ── subtitles ── */

	P.trackKey = function (t) {
		return t.vss_id || ((t.languageCode || '') + (t.kind === 'asr' ? '.asr' : ''));
	};

	P.trackLabel = function (t) {
		return t.displayName || t.languageName || t.languageCode || 'Subtitles';
	};

	P.findTrack = function (key) {
		var i;
		for (i = 0; i < this.tracks.length; i++) {
			if (this.trackKey(this.tracks[i]) === key) {
				return this.tracks[i];
			}
		}
		/* vss_id looks like ".en", "a.en" (auto) or ".en.xyz"; our own keys like "en" / "en.asr". */
		var lang = String(key || '');
		var m = /^a?\.(.+)$/.exec(lang);
		lang = (m ? m[1] : lang).split('.')[0];
		for (i = 0; i < this.tracks.length; i++) {
			if (this.tracks[i].languageCode === lang) {
				return this.tracks[i];
			}
		}
		return null;
	};

	P.loadCaptions = function () {
		if (!this.ready || this.ccLoading) {
			return;
		}
		var self = this;
		this.ccLoading = true;
		try { this.yt.loadModule('captions'); } catch (e) { /* older player */ }
		window.clearTimeout(this.timers.cc);
		this.timers.cc = window.setTimeout(function () {
			self.ccLoading = false;
			if (!self.tracks.length) {
				self.ccNone = true;
				if (self.ccAsked) {
					self.toast('No subtitles for this video');
				}
				self.ccAsked = false;
			}
			self.syncClasses();
			self.renderMenu();
		}, 4000);
		this.renderMenu();
	};

	P.onApiChange = function () {
		var list = [];
		try { list = this.yt.getOption('captions', 'tracklist') || []; } catch (e) { list = []; }
		if (list && list.length) {
			this.tracks = list;
			this.ccNone = false;
			this.ccLoading = false;
			window.clearTimeout(this.timers.cc);
		}

		var current = null;
		try { current = this.yt.getOption('captions', 'track'); } catch (e) { current = null; }
		if (current && current.languageCode && !this.ccPending) {
			this.ccKey = this.trackKey(current);
		}

		if (this.tracks.length && !this.ccApplied) {
			this.ccApplied = true;
			var wanted = this.ccWanted;
			this.ccAsked = false;
			if ('off' === wanted) {
				this.captionsOff(false);
			} else if ('auto' === wanted && this.ccKey) {
				this.ccWanted = this.ccKey;
			} else {
				var t = this.findTrack(wanted) || this.tracks[0];
				this.captionsOn(t, false);
			}
		}

		/* A track chosen while the module was unloaded only sticks once it is back. */
		if (this.ccPending && this.ccApplied) {
			try { this.yt.setOption('captions', 'track', this.ccPending); } catch (e) { /* noop */ }
			this.ccKey = this.trackKey(this.ccPending);
		}
		this.ccPending = null;

		this.armUncrop();
		this.syncClasses();
		this.renderMenu();
	};

	P.captionsOn = function (t, remember) {
		if (!t || !this.ready) {
			return;
		}
		try { this.yt.loadModule('captions'); } catch (e) { /* noop */ }
		try { this.yt.setOption('captions', 'track', t); } catch (e) { /* noop */ }
		this.ccPending = t;
		this.ccKey = this.trackKey(t);
		this.ccWanted = this.ccKey;
		if (false !== remember) {
			save('cc', this.ccKey);
			save('ccLang', this.ccKey);
		}
		this.armUncrop();
		this.syncClasses();
		this.renderMenu();
	};

	P.captionsOff = function (remember) {
		this.ccPending = null;
		if (this.ready) {
			try { this.yt.setOption('captions', 'track', {}); } catch (e) { /* noop */ }
			try { this.yt.unloadModule('captions'); } catch (e) { /* noop */ }
		}
		this.ccKey = null;
		this.ccWanted = 'off';
		this.forceCrop();
		if (false !== remember) {
			save('cc', 'off');
		}
		this.syncClasses();
		this.renderMenu();
	};

	P.toggleCaptions = function () {
		if (this.ccKey) {
			this.captionsOff();
			this.toast('Subtitles off');
			return;
		}
		if (this.tracks.length) {
			var pref = load('ccLang', '');
			var t = (pref && this.findTrack(pref)) || this.tracks[0];
			this.captionsOn(t);
			this.toast(this.trackLabel(t));
			return;
		}
		if (this.ccNone) {
			this.toast('No subtitles for this video');
			return;
		}
		this.ccWanted = load('ccLang', '') || 'auto';
		this.ccApplied = false;
		this.ccAsked = true;
		if (this.started) {
			this.loadCaptions();
			this.toast('Loading subtitles…');
		} else {
			this.toast('Subtitles will start with the video');
		}
		this.syncClasses();
	};

	/* ── fullscreen ── */

	P.nativeFsElement = function () {
		return document.fullscreenElement || document.webkitFullscreenElement || null;
	};

	P.canNativeFs = function () {
		var r = this.root;
		return !!((r.requestFullscreen || r.webkitRequestFullscreen) && (document.fullscreenEnabled || document.webkitFullscreenEnabled));
	};

	P.toggleFs = function () {
		var self = this;
		if (this.nativeFsElement() === this.root) {
			var exit = document.exitFullscreen || document.webkitExitFullscreen;
			if (exit) {
				var p = exit.call(document);
				if (p && p.then) {
					p.then(null, noop);
				}
			}
			return;
		}
		if (this.fake) {
			this.setFake(false);
			return;
		}
		if (this.canNativeFs()) {
			var req = this.root.requestFullscreen ? this.root.requestFullscreen({ navigationUI: 'hide' }) : this.root.webkitRequestFullscreen();
			if (req && req.then) {
				req.then(function () { self.lockLandscape(); }, function () { self.setFake(true); });
			} else {
				window.setTimeout(function () { self.lockLandscape(); }, 50);
			}
			return;
		}
		/* iPhone Safari has no element fullscreen — fill the viewport instead. */
		this.setFake(true);
	};

	/*
	 * An ancestor with a transform / filter / perspective / contain / will-change
	 * becomes the containing block of a position:fixed child, and an ancestor
	 * with a z-index caps how high it can stack. Either one would keep the
	 * viewport-fill under a site's sticky header. While it is on, those
	 * properties are neutralised inline on the ancestors, then restored exactly.
	 */
	P.liftAncestors = function () {
		var saved = [];
		var el = this.root.parentElement;
		while (el && el !== document.body && el !== document.documentElement) {
			var cs = window.getComputedStyle(el);
			var traps = ('none' !== cs.transform) || ('none' !== cs.filter) || ('none' !== cs.perspective) ||
				(cs.contain && 'none' !== cs.contain) || /transform|filter|perspective/.test(cs.willChange || '') ||
				(cs.backdropFilter && 'none' !== cs.backdropFilter);
			var stacks = 'static' !== cs.position && 'auto' !== cs.zIndex;
			if (traps || stacks) {
				saved.push({ el: el, css: el.getAttribute('style') });
				if (traps) {
					el.style.setProperty('transform', 'none', 'important');
					el.style.setProperty('filter', 'none', 'important');
					el.style.setProperty('perspective', 'none', 'important');
					el.style.setProperty('contain', 'none', 'important');
					el.style.setProperty('will-change', 'auto', 'important');
					el.style.setProperty('backdrop-filter', 'none', 'important');
					el.style.setProperty('-webkit-backdrop-filter', 'none', 'important');
					el.style.setProperty('animation', 'none', 'important');
				}
				if (stacks) {
					el.style.setProperty('z-index', '2147483000', 'important');
				}
			}
			el = el.parentElement;
		}
		this.lifted = saved;
	};

	P.restoreAncestors = function () {
		(this.lifted || []).forEach(function (x) {
			if (null === x.css) {
				x.el.removeAttribute('style');
			} else {
				x.el.setAttribute('style', x.css);
			}
		});
		this.lifted = null;
	};

	P.setFake = function (on) {
		if (on && !this.fake) {
			this.liftAncestors();
		} else if (!on && this.fake) {
			this.restoreAncestors();
		}
		this.fake = !!on;
		this.root.classList.toggle('sp-fake-fs', this.fake);
		document.documentElement.classList.toggle('sraik-player-lock', this.fake);
		this.syncClasses();
		this.show();
	};

	P.lockLandscape = function () {
		if (!this.touch) {
			return;
		}
		try {
			if (window.screen.orientation && window.screen.orientation.lock) {
				window.screen.orientation.lock('landscape').then(null, noop);
			}
		} catch (e) { /* unsupported */ }
	};

	P.onFsChange = function () {
		if (this.nativeFsElement() !== this.root) {
			try {
				if (window.screen.orientation && window.screen.orientation.unlock) {
					window.screen.orientation.unlock();
				}
			} catch (e) { /* unsupported */ }
		}
		this.syncClasses();
		this.show();
	};

	/* ── controls visibility ── */

	P.setUi = function (on) {
		this.uiVisible = !!on;
		if (!on) {
			window.clearTimeout(this.timers.hide);
			if (this.volOpen) {
				this.setVolOpen(false);
			}
		}
		this.root.classList.toggle('sp-ui', this.uiVisible);
	};

	P.show = function () {
		this.setUi(true);
		this.scheduleHide();
	};

	P.scheduleHide = function () {
		var self = this;
		window.clearTimeout(this.timers.hide);
		if (!this.wantsPlay || this.ended || this.menuOpen || this.dragging) {
			return;
		}
		this.timers.hide = window.setTimeout(function () {
			if (self.wantsPlay && !self.ended && !self.menuOpen && !self.dragging && !self.barHover && self.started) {
				self.setUi(false);
			}
		}, this.touch ? 3000 : 2400);
	};

	/* ── feedback ── */

	P.toast = function (msg) {
		var el = this.el.toast;
		el.textContent = msg;
		el.classList.add('is-on');
		window.clearTimeout(this.timers.toast);
		this.timers.toast = window.setTimeout(function () { el.classList.remove('is-on'); }, 2200);
	};

	P.ripple = function (dir, fromTap) {
		var el = dir < 0 ? this.el.rippleL : this.el.rippleR;
		var other = dir < 0 ? this.el.rippleR : this.el.rippleL;
		var key = dir < 0 ? 'rippleL' : 'rippleR';
		other.classList.remove('is-on');
		this.rippleSum = this.rippleSum || {};
		this.rippleSum[key] = el.classList.contains('is-on') ? (this.rippleSum[key] || 0) + this.skipBy : this.skipBy;
		el.querySelector('.sp-ripple-txt').textContent = this.rippleSum[key] + ' seconds';
		el.classList.add('is-on');
		if (!fromTap) {
			el.classList.add('is-soft');
		} else {
			el.classList.remove('is-soft');
		}
		window.clearTimeout(this.timers[key]);
		this.timers[key] = window.setTimeout(function () { el.classList.remove('is-on'); }, 650);
	};

	/* ── state → DOM ── */

	P.syncClasses = function () {
		var c = this.root.classList;
		var nativeFs = this.nativeFsElement() === this.root;
		var buffering = this.wantsPlay && !this.errored && (!this.ready || YT_STATE.BUFFERING === this.ytState || (!this.started && YT_STATE.PLAYING !== this.ytState));

		c.toggle('sp-ready', this.ready);
		c.toggle('sp-started', this.started);
		c.toggle('sp-playing', this.wantsPlay && !this.ended);
		c.toggle('sp-paused', !this.wantsPlay || this.ended);
		c.toggle('sp-ended', this.ended);
		c.toggle('sp-buffering', buffering);
		c.toggle('sp-muted', this.muted);
		c.toggle('sp-cc-on', !!this.ccKey);
		c.toggle('sp-cc-none', this.ccNone);
		c.toggle('sp-fs', nativeFs || this.fake);
		c.toggle('sp-touch', this.touch);
		c.toggle('sp-menu-open', this.menuOpen);
		c.toggle('sp-dragging', this.dragging);
		c.toggle('sp-has-error', !!this.errored);
		c.toggle('sp-uncrop', this.uncrop);
		c.toggle('sp-q-high', 'high' === this.quality);
		c.toggle('sp-q-saver', 'saver' === this.quality);

		var playing = this.wantsPlay && !this.ended;
		var label = this.ended ? 'Replay' : (playing ? 'Pause' : 'Play');
		var btns = this.root.querySelectorAll('[data-act="play"]');
		for (var i = 0; i < btns.length; i++) {
			btns[i].setAttribute('aria-label', label);
		}
		this.el.ccb.setAttribute('aria-pressed', this.ccKey ? 'true' : 'false');
		this.el.fsb.setAttribute('aria-label', (nativeFs || this.fake) ? 'Exit full screen' : 'Full screen');
		c.toggle('sp-ios', this.ios);
		this.root.querySelector('[data-act="mute"]').setAttribute('aria-label', (this.touch && !this.ios && !this.volOpen) ? 'Volume' : (this.muted ? 'Unmute' : 'Mute'));
	};

	P.render = function () {
		var d = this.duration();
		var t = this.dragging ? this.scrubTime : this.cur;
		var f = d ? clamp(t / d, 0, 1) : 0;
		var pct = (f * 100).toFixed(3) + '%';

		this.el.played.style.width = pct;
		this.el.thumb.style.left = pct;
		this.el.buffer.style.width = (clamp(this.buffered, 0, 1) * 100).toFixed(2) + '%';

		var curText = fmt(t);
		var durText = fmt(d);
		if (this.el.cur.textContent !== curText) {
			this.el.cur.textContent = curText;
		}
		if (this.el.dur.textContent !== durText) {
			this.el.dur.textContent = durText;
		}

		var p = this.el.progress;
		p.setAttribute('aria-valuemax', String(Math.floor(d)));
		p.setAttribute('aria-valuenow', String(Math.floor(t)));
		p.setAttribute('aria-valuetext', curText + ' of ' + durText);
	};

	/* ── settings menu ── */

	P.rateLabel = function (r) {
		return 1 === r ? 'Normal' : r + 'x';
	};

	P.renderMenu = function () {
		if (!this.menuOpen) {
			return;
		}
		var self = this;
		var h = '';
		var view = this.menuView;

		if ('speed' === view) {
			h += '<button type="button" class="sp-mi sp-mhead" data-go="main">' + I.prev + '<span>Playback speed</span></button>';
			this.rates.forEach(function (r) {
				var on = r === self.rate;
				h += '<button type="button" class="sp-mi sp-opt" role="menuitemradio" aria-checked="' + on + '" data-rate="' + r + '">' + I.check + '<span>' + esc(self.rateLabel(r)) + '</span></button>';
			});
		} else if ('quality' === view) {
			h += '<button type="button" class="sp-mi sp-mhead" data-go="main">' + I.prev + '<span>Quality</span></button>';
			Object.keys(QUALITY).forEach(function (q) {
				h += '<button type="button" class="sp-mi sp-opt" role="menuitemradio" aria-checked="' + (q === self.quality) + '" data-q="' + q + '">' + I.check + '<span>' + QUALITY[q] + '</span></button>';
			});
			h += '<p class="sp-mnote">High streams in HD, Data saver uses less mobile data. A slow connection can still lower the picture.</p>';
		} else if ('cc' === view) {
			h += '<button type="button" class="sp-mi sp-mhead" data-go="main">' + I.prev + '<span>Subtitles</span></button>';
			if (this.tracks.length) {
				h += '<button type="button" class="sp-mi sp-opt" role="menuitemradio" aria-checked="' + !this.ccKey + '" data-cc="off">' + I.check + '<span>Off</span></button>';
				this.tracks.forEach(function (t) {
					var key = self.trackKey(t);
					h += '<button type="button" class="sp-mi sp-opt" role="menuitemradio" aria-checked="' + (key === self.ccKey) + '" data-cc="' + esc(key) + '">' + I.check + '<span>' + esc(self.trackLabel(t)) + '</span></button>';
				});
			} else if (this.ccLoading) {
				h += '<p class="sp-mnote">Loading subtitles…</p>';
			} else if (this.ccNone) {
				h += '<p class="sp-mnote">No subtitles for this video.</p>';
			} else {
				h += '<p class="sp-mnote">Start the video to load subtitles.</p>';
			}
		} else {
			var ccLabel = 'Off';
			if (this.ccKey) {
				var cur = this.findTrack(this.ccKey);
				ccLabel = cur ? this.trackLabel(cur) : 'On';
			} else if (this.ccNone) {
				ccLabel = 'Unavailable';
			}
			h += '<button type="button" class="sp-mi" data-go="quality"><span class="sp-ml">Quality</span><span class="sp-mv">' + QUALITY[this.quality] + '</span>' + I.next + '</button>';
			h += '<button type="button" class="sp-mi" data-go="speed"><span class="sp-ml">Playback speed</span><span class="sp-mv">' + esc(this.rateLabel(this.rate)) + '</span>' + I.next + '</button>';
			h += '<button type="button" class="sp-mi" data-go="cc"><span class="sp-ml">Subtitles</span><span class="sp-mv">' + esc(ccLabel) + '</span>' + I.next + '</button>';
		}

		/* Re-rendering must not drop keyboard focus out of the menu. */
		var active = document.activeElement;
		var refocus = null;
		if (active && this.el.menu.contains(active)) {
			refocus = '.sp-mi';
			['data-go', 'data-rate', 'data-cc', 'data-q'].forEach(function (a) {
				if (active.hasAttribute(a)) {
					refocus = '.sp-mi[' + a + '="' + String(active.getAttribute(a)).replace(/["\\]/g, '\\$&') + '"]';
				}
			});
		}

		this.el.menu.innerHTML = h;

		if (refocus) {
			var target = this.el.menu.querySelector(refocus) || this.el.menu.querySelector('.sp-mi');
			if (target) {
				try { target.focus({ preventScroll: true }); } catch (e) { target.focus(); }
			}
		}
	};

	P.openMenu = function (view) {
		if (this.volOpen) {
			this.setVolOpen(false);
		}
		this.menuOpen = true;
		this.menuView = view || 'main';
		this.el.setb.setAttribute('aria-expanded', 'true');
		this.renderMenu();
		this.syncClasses();
		this.setUi(true);
		window.clearTimeout(this.timers.hide);
		var first = this.el.menu.querySelector('button');
		if (first && !this.touch) {
			try { first.focus({ preventScroll: true }); } catch (e) { first.focus(); }
		}
	};

	P.closeMenu = function () {
		if (!this.menuOpen) {
			return;
		}
		this.menuOpen = false;
		this.el.setb.setAttribute('aria-expanded', 'false');
		this.el.menu.innerHTML = '';
		this.syncClasses();
		this.scheduleHide();
	};

	P.goMenu = function (view) {
		this.menuView = view;
		if ('cc' === view && !this.tracks.length && !this.ccNone && this.started) {
			this.loadCaptions();
		}
		this.renderMenu();
		var first = this.el.menu.querySelector('button');
		if (first && !this.touch) {
			try { first.focus({ preventScroll: true }); } catch (e) { first.focus(); }
		}
	};

	/* ── Tutor integration ── */

	P.percentage = function (a, b) {
		return a > 0 && b > 0 ? Math.round((a / b) * 100) : 0;
	};

	P.syncTime = function (extra) {
		if (!this.track || !this.data.post_id) {
			return;
		}
		if (this.strict) {
			this.enableCompleteBtn();
		}
		var now = this.time();
		var payload = { currentTime: now, duration: this.duration(), post_id: this.data.post_id };
		if (extra) {
			Object.keys(extra).forEach(function (k) { payload[k] = extra[k]; });
		}
		wpPost('sync_video_playback', payload);
		var best = Number(this.data.best_watch_time) || 0;
		var top = best > now ? best : now;
		if (top > this.maxSeek) {
			this.maxSeek = top;
		}
	};

	P.stopSync = function () {
		window.clearInterval(this.timers.sync);
		this.timers.sync = null;
	};

	P.autoload = function () {
		if (!this.data.post_id) {
			return;
		}
		wpPost('autoload_next_course_content', { post_id: this.data.post_id }).then(function (res) {
			if (res && res.success && res.data && res.data.next_url) {
				window.location.href = res.data.next_url;
			}
		});
	};

	P.enableCompleteBtn = function () {
		var btn = document.querySelector('button[name="complete_lesson_btn"]');
		if (!btn) {
			return;
		}
		var need = Number(this.data.required_percentage) || 0;
		if (this.percentage(this.time(), this.duration()) < need) {
			return;
		}
		btn.disabled = false;
		var next = btn.nextElementSibling;
		if (next && next.classList.contains('tutor-tooltip')) {
			next.remove();
		}
		var parent = btn.parentElement;
		if (parent && parent.classList.contains('tutor-tooltip-wrap')) {
			parent.replaceWith(btn);
		}
	};

	P.disableCompleteBtn = function () {
		var need = Number(this.data.required_percentage) || 0;
		if (this.percentage(Number(this.data.best_watch_time) || 0, Number(this.data.video_duration) || 0) >= need) {
			return;
		}
		var btn = document.querySelector('button[name="complete_lesson_btn"]');
		if (!btn || btn.disabled) {
			return;
		}
		btn.disabled = true;
		var parent = btn.parentElement;
		if (!parent || !parent.classList.contains('tutor-tooltip-wrap')) {
			var wrap = document.createElement('div');
			wrap.className = 'tutor-tooltip-wrap';
			wrap.setAttribute('x-data', 'tutorTooltip({ placement: "top" })');
			btn.parentNode.insertBefore(wrap, btn);
			wrap.appendChild(btn);
			btn.setAttribute('x-ref', 'trigger');
		}
		var after = btn.nextElementSibling;
		if (!after || !after.classList.contains('tutor-tooltip')) {
			btn.insertAdjacentHTML('afterend', '<div x-ref="content" class="tutor-tooltip" x-show="open" x-cloak x-transition>Watch at least ' + need + '% to complete the lesson.</div>');
			if (window.Alpine && 'function' === typeof window.Alpine.initTree) {
				try { window.Alpine.initTree(btn.parentElement); } catch (e) { /* tooltip only */ }
			}
		}
	};

	/* The surface Tutor Pro's notes (and anything else) call on Tutor Player. */
	P.makeFacade = function () {
		var self = this;
		var api = {
			provider: 'youtube',
			elements: { container: this.root, wrapper: this.root },
			play: function () { self.play(); return Promise.resolve(); },
			pause: function () { self.pause(); },
			togglePlay: function () { self.togglePlay(); },
			stop: function () { self.pause(); self.seek(0, true); },
			forward: function (s) { self.seek(self.time() + (Number(s) || self.skipBy)); },
			rewind: function (s) { self.seek(self.time() - (Number(s) || self.skipBy)); },
			on: function (name, fn) {
				(self.listeners[name] = self.listeners[name] || []).push(fn);
				return api;
			},
			off: function (name, fn) {
				var list = self.listeners[name] || [];
				var i = list.indexOf(fn);
				if (i > -1) {
					list.splice(i, 1);
				}
				return api;
			},
			once: function (name, fn) {
				var wrapped = function (e) { api.off(name, wrapped); fn(e); };
				return api.on(name, wrapped);
			}
		};
		Object.defineProperties(api, {
			currentTime: { get: function () { return self.time(); }, set: function (v) { self.seek(Number(v) || 0); } },
			duration: { get: function () { return self.duration(); } },
			playing: { get: function () { return YT_STATE.PLAYING === self.ytState; } },
			paused: { get: function () { return !self.wantsPlay || self.ended; } },
			ended: { get: function () { return self.ended; } },
			muted: { get: function () { return self.muted; }, set: function (v) { if (!!v !== self.muted) { self.toggleMute(); } } },
			volume: { get: function () { return self.muted ? 0 : self.volume / 100; }, set: function (v) { self.setVolume((Number(v) || 0) * 100); } },
			speed: { get: function () { return self.rate; }, set: function (v) { self.setRate(v); } },
			embed: { get: function () { return self.yt; } }
		});
		return api;
	};

	P.emit = function (name) {
		var list = (this.listeners[name] || []).slice();
		var evt = { type: name, detail: { plyr: this.facade } };
		for (var i = 0; i < list.length; i++) {
			try { list[i](evt); } catch (e) { /* listener error */ }
		}
	};

	/* ── input ── */

	P.bind = function () {
		var self = this;
		var r = this.root;
		var el = this.el;

		/* Pointer kind decides the interaction model, live. */
		r.addEventListener('pointerdown', function (e) {
			var touch = 'mouse' !== e.pointerType;
			if (touch !== self.touch) {
				self.touch = touch;
				self.syncClasses();
			}
		}, true);

		/* Close the menu on any press outside it; that press does nothing else. */
		document.addEventListener('pointerdown', function (e) {
			if (!self.menuOpen) {
				return;
			}
			if (el.menu.contains(e.target) || el.setb.contains(e.target)) {
				return;
			}
			self.closeMenu();
			if (e.target === el.shield) {
				self.swallowTap = true;
			}
		}, true);

		/* ── the video surface ── */
		var tap = { id: null, x: 0, y: 0, t: 0 };
		var last = { t: 0, side: 0, ui: true };
		var streak = { side: 0, until: 0 };

		el.shield.addEventListener('pointerdown', function (e) {
			tap.id = e.pointerId;
			tap.x = e.clientX;
			tap.y = e.clientY;
			tap.t = Date.now();
			if ('mouse' === e.pointerType) {
				try { r.focus({ preventScroll: true }); } catch (err) { /* old browser */ }
			}
		});

		el.shield.addEventListener('pointercancel', function () { tap.id = null; });

		el.shield.addEventListener('pointerup', function (e) {
			if (tap.id !== e.pointerId) {
				return;
			}
			tap.id = null;
			if (self.swallowTap) {
				self.swallowTap = false;
				return;
			}
			if (Math.abs(e.clientX - tap.x) > 12 || Math.abs(e.clientY - tap.y) > 12 || Date.now() - tap.t > 700) {
				return;
			}
			if ('mouse' === e.pointerType && 0 !== e.button) {
				return;
			}
			if (self.errored) {
				return;
			}
			if (!self.started || self.ended) {
				self.play();
				return;
			}
			if ('mouse' === e.pointerType) {
				self.togglePlay();
				self.show();
				return;
			}

			/* Touch: tap toggles the controls, double-tap a side skips. */
			var rect = r.getBoundingClientRect();
			var fx = rect.width ? (e.clientX - rect.left) / rect.width : 0.5;
			var side = fx < 0.35 ? -1 : (fx > 0.65 ? 1 : 0);
			var now = Date.now();

			if (side && ((now - last.t < 320 && last.side === side) || (now < streak.until && streak.side === side))) {
				if (now - last.t < 320) {
					self.setUi(last.ui);
				}
				last.t = 0;
				streak.side = side;
				streak.until = now + 700;
				self.skip(side, true);
				if (self.uiVisible) {
					self.scheduleHide();
				}
				return;
			}

			last.t = now;
			last.side = side;
			last.ui = self.uiVisible;
			streak.until = 0;
			if (self.uiVisible && self.started) {
				self.setUi(false);
			} else {
				self.show();
			}
		});

		el.shield.addEventListener('dblclick', function (e) {
			if (self.touch) {
				return;
			}
			e.preventDefault();
			self.toggleFs();
		});

		/* Mouse movement wakes the controls. */
		var lastMove = { x: -1, y: -1 };
		r.addEventListener('pointermove', function (e) {
			if ('mouse' !== e.pointerType) {
				return;
			}
			if (e.clientX === lastMove.x && e.clientY === lastMove.y) {
				return;
			}
			lastMove.x = e.clientX;
			lastMove.y = e.clientY;
			self.show();
		});
		r.addEventListener('mouseleave', function () {
			if (self.wantsPlay && !self.menuOpen && !self.dragging && self.started) {
				window.clearTimeout(self.timers.hide);
				self.timers.hide = window.setTimeout(function () {
					if (self.wantsPlay && !self.menuOpen && !self.dragging) {
						self.setUi(false);
					}
				}, 400);
			}
		});
		el.bar.addEventListener('pointerenter', function (e) {
			if ('mouse' === e.pointerType) {
				self.barHover = true;
			}
		});
		el.bar.addEventListener('pointerleave', function () {
			self.barHover = false;
			self.scheduleHide();
		});
		r.addEventListener('focusin', function () { self.show(); });

		/* ── buttons ── */
		r.addEventListener('click', function (e) {
			var b = e.target.closest ? e.target.closest('button') : null;
			if (!b || !r.contains(b)) {
				return;
			}
			var act = b.getAttribute('data-act');
			var go = b.getAttribute('data-go');
			var rate = b.getAttribute('data-rate');
			var cc = b.getAttribute('data-cc');
			var q = b.getAttribute('data-q');

			if (act) {
				switch (act) {
					case 'play': self.togglePlay(); break;
					case 'back': self.skip(-1, false); break;
					case 'fwd': self.skip(1, false); break;
					case 'mute':
						if (self.touch && !self.ios && !self.volOpen) {
							self.setVolOpen(true);
						} else {
							self.toggleMute();
							if (self.volOpen) {
								self.setVolOpen(true);
							}
						}
						break;
					case 'cc': self.toggleCaptions(); break;
					case 'fs': self.toggleFs(); break;
					case 'menu':
						if (self.menuOpen) {
							self.closeMenu();
						} else {
							self.openMenu('main');
						}
						break;
				}
				if ('menu' !== act) {
					self.show();
				}
				return;
			}
			if (go) {
				self.goMenu(go);
				return;
			}
			if (null !== q) {
				self.setQuality(q);
				self.goMenu('main');
				return;
			}
			if (null !== rate) {
				self.setRate(rate);
				self.goMenu('main');
				return;
			}
			if (null !== cc) {
				if ('off' === cc) {
					self.captionsOff();
				} else {
					self.captionsOn(self.findTrack(cc));
				}
				self.goMenu('main');
			}
		});

		/* ── volume ── */
		var vol = el.volume;
		var volWrap = vol.parentNode;
		var volDrag = false;
		function volFrom(e) {
			var rect = vol.querySelector('.sp-vtrack').getBoundingClientRect();
			var f = rect.width ? clamp((e.clientX - rect.left) / rect.width, 0, 1) : 0;
			self.setVolume(f * 100);
			self.show();
			if (self.volOpen) {
				self.setVolOpen(true);
			}
		}
		vol.addEventListener('pointerdown', function (e) {
			if ('mouse' === e.pointerType && 0 !== e.button) {
				return;
			}
			e.preventDefault();
			volDrag = true;
			volWrap.classList.add('is-active');
			try { vol.setPointerCapture(e.pointerId); } catch (err) { /* old browser */ }
			volFrom(e);
		});
		vol.addEventListener('pointermove', function (e) {
			if (volDrag) {
				volFrom(e);
			}
		});
		function volEnd() {
			volDrag = false;
			volWrap.classList.remove('is-active');
		}
		vol.addEventListener('pointerup', volEnd);
		vol.addEventListener('pointercancel', volEnd);
		vol.addEventListener('lostpointercapture', volEnd);
		vol.addEventListener('keydown', function (e) {
			var step = { ArrowRight: 5, ArrowUp: 5, ArrowLeft: -5, ArrowDown: -5, PageUp: 10, PageDown: -10 }[e.key];
			if ('Home' === e.key) {
				step = -100;
			} else if ('End' === e.key) {
				step = 100;
			}
			if (!step) {
				return;
			}
			e.preventDefault();
			e.stopPropagation();
			self.setVolume((self.muted ? 0 : self.volume) + step);
			self.show();
		});

		/* ── progress / scrubbing ── */
		var p = el.progress;
		function fraction(e) {
			var rect = p.getBoundingClientRect();
			return rect.width ? clamp((e.clientX - rect.left) / rect.width, 0, 1) : 0;
		}
		function placeTip(f, time) {
			var rect = p.getBoundingClientRect();
			var tipW = el.tip.offsetWidth || 40;
			var x = clamp(f * rect.width, tipW / 2, Math.max(tipW / 2, rect.width - tipW / 2));
			el.tip.style.left = x + 'px';
			el.tip.textContent = fmt(time);
		}
		function scrub(e) {
			var f = fraction(e);
			self.scrubTime = f * self.duration();
			placeTip(f, self.scrubTime);
			self.render();
		}
		p.addEventListener('pointerdown', function (e) {
			if (('mouse' === e.pointerType && 0 !== e.button) || self.errored) {
				return;
			}
			e.preventDefault();
			self.dragging = true;
			try { p.setPointerCapture(e.pointerId); } catch (err) { /* old browser */ }
			p.classList.add('is-tip');
			scrub(e);
			self.syncClasses();
			self.setUi(true);
			window.clearTimeout(self.timers.hide);
		});
		p.addEventListener('pointermove', function (e) {
			if (self.dragging) {
				scrub(e);
			} else if ('mouse' === e.pointerType) {
				var f = fraction(e);
				p.classList.add('is-tip');
				placeTip(f, f * self.duration());
			}
		});
		function endDrag(commit) {
			if (!self.dragging) {
				return;
			}
			self.dragging = false;
			p.classList.remove('is-tip');
			if (commit) {
				self.seek(self.scrubTime);
			}
			self.syncClasses();
			self.render();
			self.scheduleHide();
		}
		p.addEventListener('pointerup', function () { endDrag(true); });
		p.addEventListener('pointercancel', function () { endDrag(false); });
		p.addEventListener('pointerleave', function () {
			if (!self.dragging) {
				p.classList.remove('is-tip');
			}
		});

		/* ── keyboard (only while the player has focus) ── */
		r.addEventListener('keydown', function (e) {
			if (e.defaultPrevented || e.ctrlKey || e.metaKey || e.altKey) {
				return;
			}
			var t = e.target;
			var tag = t && t.tagName;
			if ('INPUT' === tag || 'TEXTAREA' === tag || 'SELECT' === tag || (t && t.isContentEditable)) {
				return;
			}
			var k = e.key;
			if ('Escape' === k || 'Esc' === k) {
				if (self.menuOpen) {
					e.preventDefault();
					self.closeMenu();
					try { el.setb.focus({ preventScroll: true }); } catch (err) { el.setb.focus(); }
				} else if (self.fake) {
					e.preventDefault();
					self.setFake(false);
				}
				return;
			}
			if (self.menuOpen && el.menu.contains(t)) {
				return;
			}
			var onButton = 'BUTTON' === tag;
			var handled = true;
			switch (k) {
				case ' ':
				case 'Spacebar':
					if (onButton) {
						return;
					}
					self.togglePlay();
					break;
				case 'k':
				case 'K':
					self.togglePlay();
					break;
				case 'ArrowLeft':
				case 'j':
				case 'J':
					self.skip(-1, false);
					break;
				case 'ArrowRight':
				case 'l':
				case 'L':
					self.skip(1, false);
					break;
				case 'ArrowUp':
					self.setVolume((self.muted ? 0 : self.volume) + 5);
					break;
				case 'ArrowDown':
					self.setVolume((self.muted ? 0 : self.volume) - 5);
					break;
				case 'm':
				case 'M':
					self.toggleMute();
					break;
				case 'f':
				case 'F':
					self.toggleFs();
					break;
				case 'c':
				case 'C':
					self.toggleCaptions();
					break;
				default:
					if (/^[0-9]$/.test(k) && self.started) {
						self.seek(self.duration() * Number(k) / 10);
					} else {
						handled = false;
					}
			}
			if (handled) {
				e.preventDefault();
				self.show();
			}
		});

		/* Escape out of the iPhone viewport fill even when focus left the player. */
		document.addEventListener('keydown', function (e) {
			if (self.fake && ('Escape' === e.key || 'Esc' === e.key) && !r.contains(e.target)) {
				self.setFake(false);
			}
		});

		document.addEventListener('fullscreenchange', function () { self.onFsChange(); });
		document.addEventListener('webkitfullscreenchange', function () { self.onFsChange(); });
	};

	/* ─────────────────────────── boot ─────────────────────────── */

	function boot() {
		var els = document.querySelectorAll('.sraik-player');
		for (var i = 0; i < els.length; i++) {
			if (!els[i].__sraikPlayer && els[i].getAttribute('data-sp-video')) {
				els[i].__sraikPlayer = new Player(els[i]);
			}
		}
	}

	window.SraikPlayer = { version: '1.3.0', init: boot };

	if ('loading' === document.readyState) {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})(window, document);
