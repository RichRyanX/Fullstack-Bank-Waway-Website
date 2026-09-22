/* ============ Bank Waway - main.js ============ */
window.debounce = function (fn, wait) {
  var timer = null;
  return function () {
    var context = this;
    var args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      fn.apply(context, args);
    }, wait);
  };
};

document.addEventListener('DOMContentLoaded', function () {

  /* ---- Hero carousel ---- */
  const slides = document.querySelectorAll('.hero-carousel .slide');
  const dots = document.querySelectorAll('.carousel-dots .dot');
  if (slides.length) {
    let idx = 0;
    const show = i => {
      idx = (i + slides.length) % slides.length;
      slides.forEach((s, n) => s.classList.toggle('active', n === idx));
      dots.forEach((d, n) => d.classList.toggle('active', n === idx));
    };
    const next = document.querySelector('.carousel-arrow.next');
    const prev = document.querySelector('.carousel-arrow.prev');
    if (next) next.addEventListener('click', () => show(idx + 1));
    if (prev) prev.addEventListener('click', () => show(idx - 1));
    dots.forEach((d, n) => d.addEventListener('click', () => show(n)));
    if (slides.length > 1) setInterval(() => show(idx + 1), 6000);
  }

  /* ---- Tabungan: tab switch ---- */
  const sideItems = document.querySelectorAll('.side-item');
  sideItems.forEach(btn => {
    btn.addEventListener('click', () => {
      sideItems.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
      const pane = document.getElementById('tab-' + btn.dataset.tab);
      if (pane) pane.classList.add('active');
    });
  });

  /* ---- Kalkulator simulasi (kredit / deposito / tabungan) ---- */
  const calcForm = document.getElementById('simulationCalculatorForm');
  if (calcForm) {
    const calcType = document.getElementById('calcProductType');
    const calcAmount = document.getElementById('calcAmount');
    const calcTenure = document.getElementById('calcTenure');
    const calcTenureRange = document.getElementById('calcTenureRange');
    const calcTenureValue = document.getElementById('calcTenureValue');
    const calcBtn = document.getElementById('btnSimulate');
    const calcResult = document.getElementById('calculatorResult');

    const rpCalc = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');
    const RATE = { kredit: 0.0924, deposito: 0.035, tabungan: 0.018 };

    function renderCalc() {
      if (!calcResult) return;
      const tipe = calcType ? calcType.value : '';
      const pokok = parseFloat(calcAmount ? calcAmount.value : '') || 0;
      const bulan = parseInt(calcTenure ? calcTenure.value : '1', 10) || 1;
      let html = '';

      if (tipe === 'kredit') {
        const rate = RATE.kredit / 12;
        const angsuran = pokok > 0 ? (pokok * rate) / (1 - Math.pow(1 + rate, -bulan)) : 0;
        const total = angsuran * bulan;
        html = `<div class="calc-result-heading">Simulasi Kredit</div>
          <div class="calc-result-row"><span>Pokok Pinjaman</span><span>${rpCalc(pokok)}</span></div>
          <div class="calc-result-row"><span>Angsuran / Bulan</span><span>${rpCalc(angsuran)}</span></div>
          <div class="calc-result-row"><span>Total Angsuran</span><span>${rpCalc(total)}</span></div>
          <div class="calc-result-total"><span>Total Pengembalian</span><div class="val">${rpCalc(total)}</div></div>`;
      } else if (tipe === 'deposito') {
        const rate = RATE.deposito;
        const bungaKotor = pokok * rate;
        const pajak = bungaKotor * 0.20;
        const bungaBersihBulanan = (bungaKotor - pajak) / 12;
        const total = pokok + bungaBersihBulanan * bulan;
        html = `<div class="calc-result-heading">Simulasi Deposito</div>
          <div class="calc-result-row"><span>Pokok Deposito</span><span>${rpCalc(pokok)}</span></div>
          <div class="calc-result-row"><span>Bunga Setahun</span><span>${rpCalc(bungaKotor)}</span></div>
          <div class="calc-result-row"><span>Pajak (20%)</span><span>${rpCalc(pajak)}</span></div>
          <div class="calc-result-row"><span>Bunga Bersih / Bulan</span><span>${rpCalc(bungaBersihBulanan)}</span></div>
          <div class="calc-result-total"><span>Nilai Jatuh Tempo</span><div class="val">${rpCalc(total)}</div></div>`;
      } else if (tipe === 'tabungan') {
        const rate = RATE.tabungan;
        const bungaTahunan = pokok * rate;
        const bungaBulanan = bungaTahunan / 12;
        html = `<div class="calc-result-heading">Simulasi Tabungan</div>
          <div class="calc-result-row"><span>Saldo Awal</span><span>${rpCalc(pokok)}</span></div>
          <div class="calc-result-row"><span>Bunga Setahun</span><span>${rpCalc(bungaTahunan)}</span></div>
          <div class="calc-result-row"><span>Bunga / Bulan</span><span>${rpCalc(bungaBulanan)}</span></div>
          <div class="calc-result-total"><span>Saldo + Bunga Setahun</span><div class="val">${rpCalc(pokok + bungaTahunan)}</div></div>`;
      } else {
        html = `<div class="calc-result-empty"><span class="calc-result-icon">💡</span><p>Pilih jenis produk terlebih dahulu untuk melihat simulasi.</p></div>`;
      }
      calcResult.innerHTML = html;
    }

    const renderCalcDebounced = debounce(renderCalc, 300);

    if (calcBtn) calcBtn.addEventListener('click', renderCalc);
    if (calcType) calcType.addEventListener('change', renderCalcDebounced);
    if (calcAmount) calcAmount.addEventListener('input', renderCalcDebounced);
    if (calcTenureRange) calcTenureRange.addEventListener('input', () => {
      if (calcTenure) calcTenure.value = calcTenureRange.value;
      if (calcTenureValue) calcTenureValue.textContent = calcTenureRange.value + ' bulan';
      renderCalcDebounced();
    });
    if (calcTenure) calcTenure.addEventListener('input', () => {
      if (calcTenureRange) calcTenureRange.value = Math.min(calcTenure.value, 360);
      if (calcTenureValue) calcTenureValue.textContent = calcTenure.value + ' bulan';
      renderCalcDebounced();
    });
  }

  /* ---- Info Terkini slider ---- */
  const infoSlides = document.querySelectorAll('.info-slide');
  const infoDots = document.querySelectorAll('.info-dots .dot');
  if (infoSlides.length) {
    let infoIndex = 0;
    let infoTimer;

    const infoTampilkan = i => {
      infoIndex = (i + infoSlides.length) % infoSlides.length;
      infoSlides.forEach((s, idx) => s.classList.toggle('active', idx === infoIndex));
      infoDots.forEach((d, idx) => d.classList.toggle('active', idx === infoIndex));
    };

    const resetInfoTimer = () => {
      clearInterval(infoTimer);
      infoTimer = setInterval(() => infoTampilkan(infoIndex + 1), 6000);
    };

    window.infoGeser = arah => { infoTampilkan(infoIndex + arah); resetInfoTimer(); };
    window.infoKe = i => { infoTampilkan(i); resetInfoTimer(); };

    infoTampilkan(0);
    resetInfoTimer();
  }

  /* ---- FAQ Accordion ---- */
  document.addEventListener('DOMContentLoaded', () => {
    const faqQuestions = document.querySelectorAll('.faq-question');

    faqQuestions.forEach(btn => {
      btn.addEventListener('click', () => {
        const item = btn.closest('.faq-item');
        const answer = item.querySelector('.faq-answer');
        const isOpen = item.classList.contains('open');

        if (isOpen) {
          item.classList.remove('open');
          answer.style.maxHeight = null;
        } else {
          // Close other open FAQ items for a clean accordion behavior
          document.querySelectorAll('.faq-item').forEach(x => {
            x.classList.remove('open');
            const ans = x.querySelector('.faq-answer');
            if (ans) ans.style.maxHeight = null;
          });

          item.classList.add('open');
          answer.style.maxHeight = answer.scrollHeight + 'px';
        }
      });
    });
  });
});
;