/*!
 * aurora.js — the hero background of the Code Craft template ("Pixel Hero
 * Aurora"), ported from the template's React component to plain WebGL.
 * Same shader, same props as the template's hero:
 *   background rgb(6,8,10), A black, B rgb(95,100,102), C rgb(36,36,36),
 *   speed .6, scale 2.2, distortion .9, grain .05, pixel 2, steps 4, glow .25
 * Mount: <canvas data-aurora> inside a positioned box. Pauses off-screen and
 * in background tabs; draws one still frame for reduced-motion users.
 */
(function () {
	'use strict';

	var VS = 'attribute vec2 aPos;void main(){gl_Position=vec4(aPos,0.0,1.0);}';
	var FS = [
		'precision highp float;',
		'uniform vec2 uRes;uniform float uTime;uniform float uScale;uniform float uWarp;uniform float uGrain;',
		'uniform vec3 uBg;uniform vec3 uA;uniform vec3 uB;uniform vec3 uC;uniform vec2 uMouse;uniform float uGlow;',
		'uniform float uGlowSize;uniform float uPixel;uniform float uPixelAmt;uniform float uLevels;',
		'float hash(vec2 p){p=fract(p*vec2(123.34,456.21));p+=dot(p,p+45.32);return fract(p.x*p.y);}',
		'vec3 aurora(vec2 px){',
		'  vec2 uv=px/uRes;float aspect=uRes.x/uRes.y;vec2 p=(uv-0.5)*vec2(aspect,1.0)*uScale;float t=uTime;',
		'  for(int i=0;i<4;i++){float k=float(i);p+=uWarp*vec2(sin(p.y*1.3+t*0.7+k*1.9),cos(p.x*1.1-t*0.5+k*2.3))/(1.0+k*0.6);}',
		'  float ribbon=0.5+0.5*sin(p.x*1.2+p.y*0.9+t*0.3);',
		'  float rings=0.5+0.5*sin(length(p)*1.5-t*0.4);',
		'  float veil=0.5+0.5*sin(p.x*0.6-p.y*1.4-t*0.2);',
		'  vec3 col=uBg;',
		'  col=mix(col,uA,smoothstep(0.25,0.85,ribbon));',
		'  col=mix(col,uB,smoothstep(0.45,0.95,rings)*0.75);',
		'  col=mix(col,uC,smoothstep(0.6,1.0,veil)*0.55);',
		'  vec2 d=(uv-uMouse)*vec2(aspect,1.0);',
		'  float glow=exp(-dot(d,d)/max(0.0005,uGlowSize*uGlowSize))*uGlow;',
		'  col+=uC*glow*0.6;',
		'  float vig=1.0-smoothstep(0.25,1.15,length((uv-0.5)*vec2(aspect,1.0)));',
		'  return mix(uBg,col,vig);',
		'}',
		'float orderedThreshold(vec2 cell){vec2 p=floor(cell);float v=0.0;float w=16.0;',
		'  for(int i=0;i<3;i++){vec2 b=mod(p,2.0);v+=w*mod(b.x*2.0+b.y*3.0,4.0);p=floor(p/2.0);w*=0.25;}',
		'  return (v+0.5)/64.0;}',
		'void main(){',
		'  vec3 smoothCol=aurora(gl_FragCoord.xy);',
		'  vec2 block=floor(gl_FragCoord.xy/uPixel);',
		'  vec3 blockCol=aurora((block+0.5)*uPixel);',
		'  float lv=max(2.0,uLevels)-1.0;',
		'  float th=orderedThreshold(block)-0.5;',
		'  vec3 q=floor(clamp(blockCol+th/lv,0.0,1.0)*lv+0.5)/lv;',
		'  vec3 col=mix(smoothCol,q,uPixelAmt);',
		'  col+=(hash(gl_FragCoord.xy+fract(uTime)*91.7)-0.5)*uGrain;',
		'  gl_FragColor=vec4(clamp(col,0.0,1.0),1.0);',
		'}'
	].join('\n');

	var P = {
		bg: [6 / 255, 8 / 255, 10 / 255],
		a: [0, 0, 0],
		b: [95 / 255, 100 / 255, 102 / 255],
		c: [36 / 255, 36 / 255, 36 / 255],
		speed: 0.6, scale: 2.2, warp: 0.9, grain: 0.05, pixel: 2, amount: 1, levels: 4, glowSize: 0.25
	};

	function mount(canvas) {
		var box = canvas.parentElement;
		var gl = canvas.getContext('webgl', { alpha: false, antialias: false, depth: false, stencil: false });
		if (!gl) { return; }
		function sh(type, src) {
			var s = gl.createShader(type);
			gl.shaderSource(s, src); gl.compileShader(s);
			return gl.getShaderParameter(s, gl.COMPILE_STATUS) ? s : null;
		}
		var vs = sh(gl.VERTEX_SHADER, VS), fs = sh(gl.FRAGMENT_SHADER, FS);
		if (!vs || !fs) { return; }
		var pr = gl.createProgram();
		gl.attachShader(pr, vs); gl.attachShader(pr, fs); gl.linkProgram(pr);
		if (!gl.getProgramParameter(pr, gl.LINK_STATUS)) { return; }
		gl.useProgram(pr);
		gl.bindBuffer(gl.ARRAY_BUFFER, gl.createBuffer());
		gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1, -1, 1, -1, -1, 1, -1, 1, 1, -1, 1, 1]), gl.STATIC_DRAW);
		var loc = gl.getAttribLocation(pr, 'aPos');
		gl.enableVertexAttribArray(loc);
		gl.vertexAttribPointer(loc, 2, gl.FLOAT, false, 0, 0);
		var u = {};
		['uRes', 'uTime', 'uPixel', 'uPixelAmt', 'uLevels', 'uScale', 'uWarp', 'uGrain', 'uBg', 'uA', 'uB', 'uC', 'uMouse', 'uGlow', 'uGlowSize'].forEach(function (n) { u[n] = gl.getUniformLocation(pr, n); });

		var dpr = Math.min(window.devicePixelRatio || 1, 1.5);
		var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		var touch = window.matchMedia && window.matchMedia('(hover: none)').matches;
		function size() {
			var wd = box.clientWidth, ht = box.clientHeight;
			if (!wd || !ht) { return; }
			dpr = Math.min(window.devicePixelRatio || 1, 1.5);
			canvas.width = Math.round(wd * dpr);
			canvas.height = Math.round(ht * dpr);
			gl.viewport(0, 0, canvas.width, canvas.height);
		}
		size();

		var target = { x: 0.5, y: 0.5 }, mouse = { x: 0.5, y: 0.5 };
		var time = 6, raf = 0, last = 0, visible = true;
		function draw(t) {
			gl.uniform2f(u.uRes, canvas.width, canvas.height);
			gl.uniform1f(u.uTime, t);
			gl.uniform1f(u.uPixel, Math.max(1, P.pixel) * dpr);
			gl.uniform1f(u.uPixelAmt, P.amount);
			gl.uniform1f(u.uLevels, P.levels);
			gl.uniform1f(u.uScale, P.scale);
			gl.uniform1f(u.uWarp, P.warp);
			gl.uniform1f(u.uGrain, P.grain);
			gl.uniform3f(u.uBg, P.bg[0], P.bg[1], P.bg[2]);
			gl.uniform3f(u.uA, P.a[0], P.a[1], P.a[2]);
			gl.uniform3f(u.uB, P.b[0], P.b[1], P.b[2]);
			gl.uniform3f(u.uC, P.c[0], P.c[1], P.c[2]);
			gl.uniform2f(u.uMouse, mouse.x, mouse.y);
			gl.uniform1f(u.uGlow, touch ? 0 : 1);
			gl.uniform1f(u.uGlowSize, P.glowSize);
			gl.drawArrays(gl.TRIANGLES, 0, 6);
		}
		draw(time);
		if (reduce) { return; }

		function frame(now) {
			var dt = Math.min(0.1, (now - last) / 1000);
			last = now;
			time += dt * P.speed;
			mouse.x += (target.x - mouse.x) * 0.08;
			mouse.y += (target.y - mouse.y) * 0.08;
			draw(time);
			raf = requestAnimationFrame(frame);
		}
		function start() { if (!raf && visible && 'hidden' !== document.visibilityState) { last = performance.now(); raf = requestAnimationFrame(frame); } }
		function stop() { if (raf) { cancelAnimationFrame(raf); } raf = 0; }

		window.addEventListener('pointermove', function (e) {
			var r = box.getBoundingClientRect();
			if (!r.width || !r.height) { return; }
			target.x = (e.clientX - r.left) / r.width;
			target.y = 1 - (e.clientY - r.top) / r.height;
		}, { passive: true });
		document.addEventListener('visibilitychange', function () { 'hidden' === document.visibilityState ? stop() : start(); });
		if ('ResizeObserver' in window) { new ResizeObserver(function () { size(); if (!raf) { draw(time); } }).observe(box); }
		if ('IntersectionObserver' in window) {
			new IntersectionObserver(function (en) { visible = en[0].isIntersecting; visible ? start() : stop(); }, { threshold: 0 }).observe(box);
		}
		start();
	}

	function init() { Array.prototype.forEach.call(document.querySelectorAll('canvas[data-aurora]'), mount); }
	if ('loading' === document.readyState) { document.addEventListener('DOMContentLoaded', init); } else { init(); }
})();
