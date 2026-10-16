/* ============================================================
   wap.js — WhatsApp screenshot wall + full-size viewer.
   Markup: parts/wa-proof.php · Styles: assets/wap.css

   · Full wall:  "আরও দেখুন" appends the next batch (data-wap-per, default 6)
                 until the list runs out, then hides itself.
   · Teaser:     (section with data-wap-target) its "আরও দেখুন" scrolls to the
                 full wall and loads the next batch THERE. With no full wall on
                 the page it simply loads in place.
   · Viewer:     opens the ORIGINAL file at its own resolution (scaled down
                 only to fit the screen). Close ×, ← →, Esc, arrow keys,
                 swipe, and the phone's Back button closes it instead of
                 leaving the page.
   ============================================================ */
(function(){
  'use strict';
  if(window.__sraikWap){ return; }
  window.__sraikWap = true;

  var BN = '০১২৩৪৫৬৭৮৯';
  function bn(n){ return String(n).replace(/[0-9]/g, function(d){ return BN.charAt(+d); }); }
  function reduced(){ return !!(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches); }
  function closest(el, sel){
    while(el && el.nodeType === 1){
      if((el.matches || el.msMatchesSelector || el.webkitMatchesSelector).call(el, sel)){ return el; }
      el = el.parentNode;
    }
    return null;
  }

  /* ── Data: one JSON list per set, [[fullUrl, thumbUrl], …] ── */
  var lists = {};
  function list(key){
    if(lists[key]){ return lists[key]; }
    var out = [];
    var nodes = document.querySelectorAll('script.wap-data');
    for(var i = 0; i < nodes.length; i++){
      if(nodes[i].getAttribute('data-wap-set') === key){
        try { out = JSON.parse(nodes[i].textContent || '[]'); } catch(e){ out = []; }
        break;
      }
    }
    lists[key] = Array.isArray(out) ? out : [];
    return lists[key];
  }

  /* ── Tiles ── */
  function labelFor(i){ return 'স্ক্রিনশট ' + bn(i + 1); }      /* স্ক্রিনশট N */

  function watch(img){
    var tile = img.parentNode;
    function done(){ if(tile && tile.classList){ tile.classList.add('is-loaded'); } }
    img.addEventListener('load', done);
    img.addEventListener('error', function(){
      /* Thumbnail failed: show the original instead (once). */
      var full = img.getAttribute('data-full');
      if(full && img.getAttribute('src') !== full && !img.__wapRetry){
        img.__wapRetry = true;
        img.src = full;
      } else {
        done();
      }
    });
    if(img.complete && img.naturalWidth > 0){ done(); }
  }

  function makeTile(item, i){
    var b = document.createElement('button');
    b.type = 'button';
    b.className = 'wap-tile';
    b.setAttribute('data-i', String(i));
    b.setAttribute('aria-label', labelFor(i) + ' বড় করে দেখো');   /* … বড় করে দেখো */
    var img = document.createElement('img');
    img.setAttribute('loading', 'lazy');      /* before src, or the browser starts the fetch eagerly */
    img.setAttribute('decoding', 'async');
    img.setAttribute('width', '720');
    img.setAttribute('height', '720');
    img.setAttribute('alt', 'WhatsApp-এ স্টুডেন্টের ফিডব্যাক — ' + labelFor(i));
    img.setAttribute('data-full', item[0]);
    b.appendChild(img);
    watch(img);
    img.src = item[1];
    return b;
  }

  /* Append the next batch to a wall. Returns the first new tile, or null. */
  function more(sec){
    var s = sec.__wap;
    if(!s){ return null; }
    var shown = s.grid.querySelectorAll('.wap-tile').length;
    var end = Math.min(shown + s.per, s.items.length);
    var first = null, frag = document.createDocumentFragment();
    for(var i = shown; i < end; i++){
      var t = makeTile(s.items[i], i);
      t.classList.add('is-new');
      t.style.setProperty('--d', ((i - shown) * 0.05).toFixed(2) + 's');
      if(!first){ first = t; }
      frag.appendChild(t);
    }
    s.grid.appendChild(frag);
    if(end >= s.items.length && s.btn){ s.btn.hidden = true; }
    return first;
  }

  function scrollToSec(sec){
    try { sec.scrollIntoView({ behavior: reduced() ? 'auto' : 'smooth', block: 'start' }); }
    catch(e){ sec.scrollIntoView(true); }
  }

  function initSection(sec){
    if(sec.__wap){ return; }
    var grid = sec.querySelector('.wap-grid');
    if(!grid){ return; }
    var s = sec.__wap = {
      items: list(sec.getAttribute('data-wap-set') || '_default'),
      grid: grid,
      btn: sec.querySelector('.wap-more'),
      per: Math.max(1, parseInt(sec.getAttribute('data-wap-per'), 10) || 6)
    };
    sec.classList.add('wap-js');

    var imgs = grid.querySelectorAll('.wap-tile img');
    for(var i = 0; i < imgs.length; i++){ watch(imgs[i]); }

    grid.addEventListener('click', function(e){
      var t = closest(e.target, '.wap-tile');
      if(!t || !s.items.length){ return; }
      openViewer(s.items, parseInt(t.getAttribute('data-i'), 10) || 0, t);
    });

    if(!s.btn){ return; }
    if(s.btn.tagName === 'A' || sec.hasAttribute('data-wap-target')){
      /* Teaser: send the visitor to the full wall and load there. */
      s.btn.addEventListener('click', function(e){
        var full = document.getElementById(sec.getAttribute('data-wap-target') || '');
        e.preventDefault();
        if(full && full !== sec && full.__wap){
          more(full);
          scrollToSec(full);
        } else {
          more(sec);
        }
      });
    } else {
      s.btn.addEventListener('click', function(){
        var first = more(sec);
        /* The button just vanished: keep keyboard focus somewhere sensible. */
        if(first && s.btn.hidden){ try { first.focus({ preventScroll: true }); } catch(e){ first.focus(); } }
      });
    }
  }

  /* ── Viewer ── */
  var V = null;            /* viewer elements, built on first open */
  var cur = { items: null, i: 0, opener: null, open: false, token: 0, pushed: false };

  var ICON_X = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>';
  var ICON_L = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>';
  var ICON_R = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>';

  function build(){
    var lb = document.createElement('div');
    lb.className = 'wap-lb';
    lb.setAttribute('role', 'dialog');
    lb.setAttribute('aria-modal', 'true');
    lb.setAttribute('aria-label', 'স্ক্রিনশট');
    lb.setAttribute('aria-hidden', 'true');
    lb.innerHTML =
      '<div class="wap-lb-frame">' +
        '<img class="wap-lb-img" alt="" draggable="false">' +
        '<span class="wap-lb-spin" aria-hidden="true"></span>' +
        '<span class="wap-lb-err">ছবিটি লোড হয়নি</span>' +   /* ছবিটি লোড হয়নি */
        '<button type="button" class="wap-lb-btn wap-lb-close" aria-label="বন্ধ করো">' + ICON_X + '</button>' +   /* বন্ধ করো */
      '</div>' +
      '<button type="button" class="wap-lb-btn wap-lb-nav wap-lb-prev" aria-label="আগেরটি">' + ICON_L + '</button>' +   /* আগেরটি */
      '<button type="button" class="wap-lb-btn wap-lb-nav wap-lb-next" aria-label="পরেরটি">' + ICON_R + '</button>' +   /* পরেরটি */
      '<p class="wap-lb-count" aria-live="polite"></p>';
    document.body.appendChild(lb);

    V = {
      lb: lb,
      img: lb.querySelector('.wap-lb-img'),
      close: lb.querySelector('.wap-lb-close'),
      prev: lb.querySelector('.wap-lb-prev'),
      next: lb.querySelector('.wap-lb-next'),
      count: lb.querySelector('.wap-lb-count')
    };

    V.img.addEventListener('load', function(){ if(cur.open){ ready(cur.token); } });
    V.img.addEventListener('error', function(){
      if(cur.open && V.img.getAttribute('src')){ V.lb.classList.add('is-error'); }
    });

    V.close.addEventListener('click', function(){ closeViewer(false); });
    V.prev.addEventListener('click', function(){ go(-1); });
    V.next.addEventListener('click', function(){ go(1); });

    /* Click on the dark backdrop (not the image or a button) closes. */
    lb.addEventListener('click', function(e){ if(e.target === lb){ closeViewer(false); } });

    /* Swipe left / right. Ignored while pinch-zoomed or with two fingers. */
    var sx = 0, sy = 0, track = false;
    lb.addEventListener('touchstart', function(e){
      track = e.touches.length === 1 && !(window.visualViewport && window.visualViewport.scale > 1.01);
      if(track){ sx = e.touches[0].clientX; sy = e.touches[0].clientY; }
    }, { passive: true });
    lb.addEventListener('touchmove', function(e){ if(e.touches.length > 1){ track = false; } }, { passive: true });
    lb.addEventListener('touchend', function(e){
      if(!track || !e.changedTouches.length){ return; }
      track = false;
      var dx = e.changedTouches[0].clientX - sx, dy = e.changedTouches[0].clientY - sy;
      if(Math.abs(dx) > 50 && Math.abs(dx) > Math.abs(dy) * 1.5){ go(dx < 0 ? 1 : -1); }
    }, { passive: true });

    document.addEventListener('keydown', function(e){
      if(!cur.open){ return; }
      if(e.key === 'Escape' || e.key === 'Esc'){ e.preventDefault(); closeViewer(false); }
      else if(e.key === 'ArrowLeft'){ e.preventDefault(); go(-1); }
      else if(e.key === 'ArrowRight'){ e.preventDefault(); go(1); }
      else if(e.key === 'Tab'){ trap(e); }
    });

    /* Phone Back button: close the viewer instead of leaving the page. */
    window.addEventListener('popstate', function(){
      if(cur.open && cur.pushed){ cur.pushed = false; closeViewer(true); }
    });
  }

  function trap(e){
    var f = [V.close, V.prev, V.next].filter(function(b){ return !b.disabled; });
    if(!f.length){ return; }
    var i = f.indexOf(document.activeElement);
    e.preventDefault();
    if(i === -1){ f[0].focus(); return; }
    f[(i + (e.shiftKey ? -1 : 1) + f.length) % f.length].focus();
  }

  function ready(token){
    if(token !== cur.token || !V.img.getAttribute('src')){ return; }
    V.lb.classList.add('is-ready');
    /* Warm the neighbours so ← → feel instant. */
    [cur.i + 1, cur.i - 1].forEach(function(j){
      if(j >= 0 && j < cur.items.length){ var p = new Image(); p.src = cur.items[j][0]; }
    });
  }

  function show(i){
    var items = cur.items;
    i = Math.max(0, Math.min(i, items.length - 1));
    cur.i = i;
    var token = ++cur.token;
    var src = items[i][0];

    V.lb.classList.remove('is-ready', 'is-error');
    V.img.setAttribute('alt', 'WhatsApp-এ স্টুডেন্টের ফিডব্যাক — ' + labelFor(i));
    if(V.img.getAttribute('src') !== src){ V.img.src = src; }
    /* Same file again, or already in memory: no load event will come. */
    if(V.img.complete && V.img.naturalWidth > 0){ ready(token); }

    V.prev.disabled = i === 0;
    V.next.disabled = i === items.length - 1;
    V.count.textContent = bn(i + 1) + ' / ' + bn(items.length);

    /* Keep focus inside if it sat on an arrow that just got disabled. */
    if(document.activeElement && document.activeElement.disabled){ V.close.focus(); }
  }

  function go(d){
    if(!cur.open){ return; }
    var j = cur.i + d;
    if(j < 0 || j >= cur.items.length){ return; }
    show(j);
  }

  function lock(){
    var de = document.documentElement;
    var sbw = window.innerWidth - de.clientWidth;
    de.style.setProperty('--wap-sbw', (sbw > 0 ? sbw : 0) + 'px');
    de.classList.add('wap-lock');
  }
  function unlock(){
    var de = document.documentElement;
    de.classList.remove('wap-lock');
    de.style.removeProperty('--wap-sbw');
  }

  function openViewer(items, i, opener){
    if(!V){ build(); }
    cur.items = items;
    cur.opener = opener || null;
    cur.open = true;
    show(i);
    lock();
    V.lb.setAttribute('aria-hidden', 'false');
    V.lb.classList.add('is-open');
    try { V.close.focus({ preventScroll: true }); } catch(e){ V.close.focus(); }
    if(window.history && history.pushState){
      try { history.pushState({ wapViewer: true }, ''); cur.pushed = true; } catch(e){ cur.pushed = false; }
    }
  }

  function closeViewer(fromBack){
    if(!cur.open){ return; }
    cur.open = false;
    cur.token++;
    V.lb.classList.remove('is-open');
    V.lb.setAttribute('aria-hidden', 'true');
    unlock();
    if(cur.opener){ try { cur.opener.focus({ preventScroll: true }); } catch(e){} }
    if(!fromBack && cur.pushed){ cur.pushed = false; history.back(); }
  }

  /* ── Boot ── */
  function init(){
    var secs = document.querySelectorAll('section.wap[data-wap-set]');
    for(var i = 0; i < secs.length; i++){ initSection(secs[i]); }
  }
  if(document.readyState === 'loading'){ document.addEventListener('DOMContentLoaded', init); }
  else { init(); }
})();
