const puppeteer = require('puppeteer');
const fs = require('fs');

const delay = ms => new Promise(res => setTimeout(res, ms));

(async () => {
  const browser = await puppeteer.launch({
    headless: false,
    slowMo: 50,
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1280, height: 800 });

  console.log('⏳ Sayt ochilmoqda...');
  await page.goto('https://www.flashscorekz.com/', {
    waitUntil: 'domcontentloaded',
    timeout: 0
  });

  console.log('⏳ JavaScript yuklanishini kutyapmiz...');
  await delay(15000);  // 15 soniya kutamiz

  const data = await page.evaluate(() => {
    const matches = [];
    document.querySelectorAll('.event__match').forEach(match => {
      const time = match.querySelector('.event__time')?.innerText || '';
      const home = match.querySelector('.event__participant--home')?.innerText || '';
      const away = match.querySelector('.event__participant--away')?.innerText || '';
      if (home && away && time) {
        matches.push({ time, home, away });
      }
    });
    return matches;
  });

  fs.writeFileSync('matches.json', JSON.stringify(data, null, 2));

  console.log(`✅ ${data.length} ta o‘yin topildi va matches.json fayliga saqlandi.`);

  await browser.close();
})();
