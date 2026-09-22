(function () {
  const nominalInput = document.getElementById('nominal');
  const tenorBtns = document.querySelectorAll('.tenor-btn');
  const rateEl = document.getElementById('rate');
  const bungaKotorEl = document.getElementById('bungaKotor');
  const pajakEl = document.getElementById('pajak');
  const bungaEl = document.getElementById('bunga');
  const totalEl = document.getElementById('total');
  const warningEl = document.getElementById('nominalWarning');

  if (!nominalInput || !tenorBtns.length || !rateEl || !bungaEl || !totalEl) return;

  const TENOR_RATES = { 1: 5.5, 3: 5.75, 6: 5.75, 12: 6 };
  const MIN_NOMINAL = 1000000;
  const PAJAK_PERSEN = 0.20;

  const formatRibuan = (angka) => angka.toLocaleString('id-ID');

  const formatRupiah = (angka) => 'Rp ' + Math.round(angka).toLocaleString('id-ID');

  const getAngkaBersih = () => {
    const bersih = nominalInput.value.replace(/[^0-9]/g, '');
    return bersih ? parseInt(bersih, 10) : 0;
  };

  const getTenorBulan = () => {
    const active = document.querySelector('.tenor-btn.active') || tenorBtns[0];
    return parseInt(active.dataset.bulan, 10);
  };

  function hitung() {
    const bulan = getTenorBulan();
    const bunga = TENOR_RATES[bulan];
    const pokok = getAngkaBersih();

    const bungaKotorTahunan = pokok * (bunga / 100);
    const pajakBunga = bungaKotorTahunan * PAJAK_PERSEN;
    const bungaBersihTahunan = bungaKotorTahunan - pajakBunga;
    const bungaBersihBulanan = bungaBersihTahunan / 12;

    const totalBungaSelamaTenor = bungaBersihBulanan * bulan;
    const totalKembali = pokok + totalBungaSelamaTenor;

    rateEl.textContent = bunga + '%';
    bungaKotorEl.textContent = formatRupiah(bungaKotorTahunan);
    pajakEl.textContent = formatRupiah(pajakBunga);
    bungaEl.textContent = formatRupiah(bungaBersihBulanan);
    totalEl.textContent = formatRupiah(totalKembali);

    if (warningEl) {
      warningEl.style.display = (pokok > 0 && pokok < MIN_NOMINAL) ? 'block' : 'none';
    }
  }

  nominalInput.addEventListener('input', () => {
    const posisiKursorDariBelakang = nominalInput.value.length - nominalInput.selectionStart;
    const angka = getAngkaBersih();
    nominalInput.value = angka ? formatRibuan(angka) : '';
    const posisiBaru = nominalInput.value.length - posisiKursorDariBelakang;
    nominalInput.setSelectionRange(posisiBaru, posisiBaru);
    hitung();
  });

  tenorBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      tenorBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      hitung();
    });
  });

  hitung();
})();
