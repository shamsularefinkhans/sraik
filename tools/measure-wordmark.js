// Usage: node measure-wordmark.js <page url with the site fonts> "WORD"  → SVG bbox of the word at 16px
const { chromium } = require('playwright');
(async () => {
  const b = await chromium.launch({ executablePath: '/opt/pw-browsers/chromium-1194/chrome-linux/chrome' });
  const p = await b.newPage();
  await p.goto(process.argv[2], { waitUntil: 'networkidle' });
  const r = await p.evaluate((txt) => {
    const s = document.createElementNS('http://www.w3.org/2000/svg','svg'); s.setAttribute('width','2000'); s.setAttribute('height','200');
    const t = document.createElementNS('http://www.w3.org/2000/svg','text'); t.setAttribute('x','0'); t.setAttribute('y','100');
    t.style.cssText = "font-family:'Bricolage Grotesque';font-weight:600;font-size:16px;letter-spacing:-0.48px"; t.textContent = txt;
    s.appendChild(t); document.body.appendChild(s);
    return document.fonts.ready.then(() => { const bb = t.getBBox(); const c=document.createElement('canvas').getContext('2d'); c.font="600 16px 'Bricolage Grotesque'"; const m=c.measureText(txt); return {bb:[bb.x,bb.y,bb.width,bb.height], asc:m.actualBoundingBoxAscent, desc:m.actualBoundingBoxDescent, l:m.actualBoundingBoxLeft, r:m.actualBoundingBoxRight, w:m.width}; });
  }, process.argv[3]);
  console.log(JSON.stringify(r)); await b.close();
})();
