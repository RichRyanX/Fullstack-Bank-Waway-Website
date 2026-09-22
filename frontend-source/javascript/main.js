/* ============ Bank Waway - main.js ============ */
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

  /* ---- Deposito: simulasi ---- */
  const nominal = document.getElementById('nominal');
  const tenorBtns = document.querySelectorAll('.tenor-btn');
  const rp = n => 'Rp ' + Math.round(n).toLocaleString('id-ID');

  function hitung() {
    if (!nominal) return;
    const active = document.querySelector('.tenor-btn.active');
    const bunga = parseFloat(active.dataset.bunga);   // % per tahun
    const bulan = parseInt(active.dataset.bulan, 10);
    const pokok = parseFloat(nominal.value) || 0;
    const estBunga = pokok * (bunga / 100) * (bulan / 12);
    document.getElementById('rate').textContent = bunga + '%';
    document.getElementById('bunga').textContent = rp(estBunga);
    document.getElementById('total').textContent = rp(pokok + estBunga);
  }
  if (nominal) {
    nominal.addEventListener('input', hitung);
    tenorBtns.forEach(b => b.addEventListener('click', () => {
      tenorBtns.forEach(x => x.classList.remove('active'));
      b.classList.add('active');
      hitung();
    }));
    hitung();
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