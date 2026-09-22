(function () {
  var toggle = document.getElementById('navbarToggle');
  var nav = document.getElementById('navbarNav');

  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var isOpen = nav.classList.toggle('open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }

  function formatNumber(value) {
    return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0,
      maximumFractionDigits: 0
    }).format(Math.round(value));
  }

  function formatDecimal(value, digits) {
    return new Intl.NumberFormat('id-ID', {
      minimumFractionDigits: digits,
      maximumFractionDigits: digits
    }).format(value);
  }

  function computeCreditSimulation(amount, tenure) {
    var annualRate = 0.0924;
    var monthlyRate = annualRate / 12;

    if (tenure <= 0) {
      return { monthly: 0, interest: 0, total: 0 };
    }

    var exponent = Math.pow(1 + monthlyRate, tenure);
    var monthlyPayment = amount * monthlyRate * exponent / (exponent - 1);
    var totalPayment = monthlyPayment * tenure;
    var totalInterest = totalPayment - amount;

    return {
      monthly: monthlyPayment,
      interest: totalInterest,
      total: totalPayment,
      rate: annualRate * 100
    };
  }

  function computeDepositSimulation(amount, tenure) {
    var annualRate = 0.035;
    var years = tenure / 12;
    var maturity = amount * Math.pow(1 + annualRate, years);
    var interest = maturity - amount;

    return {
      interest: interest,
      maturity: maturity,
      rate: annualRate * 100
    };
  }

  function computeSavingSimulation(amount, tenure) {
    var annualRate = 0.018;
    var years = tenure / 12;
    var maturity = amount * Math.pow(1 + annualRate, years);
    var interest = maturity - amount;

    return {
      interest: interest,
      maturity: maturity,
      rate: annualRate * 100
    };
  }

  function buildResultHtml(result) {
    if (!result) {
      return '';
    }

    var html = '';

    if (result.type === 'kredit') {
      html =
        '<div class="calc-result-body">' +
        '<h3 class="calc-result-title">Estimasi Angsuran Kredit</h3>' +
        '<p class="calc-result-sub">Bunga {rate}% per tahun</p>'.replace('{rate}', formatDecimal(result.rate, 2)) +
        '<div class="calc-metric-grid">' +
        '<div class="calc-metric">' +
        '<span class="calc-metric-label">Angsuran / Bulan</span>' +
        '<span class="calc-metric-value">' + formatNumber(result.monthly_payment) + '</span>' +
        '</div>' +
        '<div class="calc-metric">' +
        '<span class="calc-metric-label">Total Bunga</span>' +
        '<span class="calc-metric-value">' + formatNumber(result.total_interest) + '</span>' +
        '</div>' +
        '<div class="calc-metric">' +
        '<span class="calc-metric-label">Total Pembayaran</span>' +
        '<span class="calc-metric-value">' + formatNumber(result.total_payment) + '</span>' +
        '</div>' +
        '<div class="calc-metric">' +
        '<span class="calc-metric-label">Jangka Waktu</span>' +
        '<span class="calc-metric-value">' + result.tenure + ' bulan</span>' +
        '</div>' +
        '</div>' +
        '</div>';
    } else {
      var title = result.type === 'deposito' ? 'Estimasi Deposito' : 'Estimasi Tabungan';
      var label = result.type === 'deposito' ? 'Nilai Jatuh Tempo' : 'Perkiraan Saldo';

      html =
        '<div class="calc-result-body">' +
        '<h3 class="calc-result-title">' + title + '</h3>' +
        '<p class="calc-result-sub">Bunga {rate}% per tahun</p>'.replace('{rate}', formatDecimal(result.rate, 2)) +
        '<div class="calc-metric-grid">' +
        '<div class="calc-metric">' +
        '<span class="calc-metric-label">Imbal Bunga</span>' +
        '<span class="calc-metric-value">' + formatNumber(result.interest_payout) + '</span>' +
        '</div>' +
        '<div class="calc-metric">' +
        '<span class="calc-metric-label">' + label + '</span>' +
        '<span class="calc-metric-value">' + formatNumber(result.maturity_value) + '</span>' +
        '</div>' +
        '<div class="calc-metric">' +
        '<span class="calc-metric-label">Jangka Waktu</span>' +
        '<span class="calc-metric-value">' + result.tenure + ' bulan</span>' +
        '</div>' +
        '<div class="calc-metric">' +
        '<span class="calc-metric-label">Nominal Awal</span>' +
        '<span class="calc-metric-value">' + formatNumber(result.amount) + '</span>' +
        '</div>' +
        '</div>' +
        '</div>';
    }

    var cta =
      '<div class="calc-result-cta">' +
      '<a href="/pengajuan" class="btn btn-primary">Ajukan Sekarang</a>' +
      '</div>';

    return html + cta;
  }

  function readFormValues(prefix) {
    var type = document.getElementById(prefix + 'ProductType');
    var amount = document.getElementById(prefix + 'Amount');
    var tenureRange = document.getElementById(prefix + 'TenureRange');
    var tenure = document.getElementById(prefix + 'Tenure');

    var productType = type ? type.value : 'kredit';
    var amountValue = amount ? parseFloat(amount.value) : 0;
    var tenureValue = tenure ? parseInt(tenure.value, 10) : (tenureRange ? parseInt(tenureRange.value, 10) : 12);

    tenureValue = Math.max(1, Math.min(360, isNaN(tenureValue) ? 12 : tenureValue));

    return {
      productType: productType,
      amount: isNaN(amountValue) ? 0 : Math.max(100000, amountValue),
      tenure: tenureValue
    };
  }

  function runSimulation(prefix, resultEl) {
    var values = readFormValues(prefix);
    var result = null;
    var title = '';

    if (values.productType === 'kredit') {
      var credit = computeCreditSimulation(values.amount, values.tenure);
      result = {
        type: 'kredit',
        amount: values.amount,
        tenure: values.tenure,
        monthly_payment: credit.monthly,
        total_interest: credit.interest,
        total_payment: credit.total,
        rate: credit.rate
      };
    } else if (values.productType === 'deposito') {
      var deposit = computeDepositSimulation(values.amount, values.tenure);
      result = {
        type: 'deposito',
        amount: values.amount,
        tenure: values.tenure,
        interest_payout: deposit.interest,
        maturity_value: deposit.maturity,
        rate: deposit.rate
      };
    } else {
      var saving = computeSavingSimulation(values.amount, values.tenure);
      result = {
        type: 'tabungan',
        amount: values.amount,
        tenure: values.tenure,
        interest_payout: saving.interest,
        maturity_value: saving.maturity,
        rate: saving.rate
      };
    }

    if (resultEl) {
      resultEl.innerHTML = buildResultHtml(result);
    }

    return result;
  }

  function bindSlider(sliderId, displayId, syncId) {
    var slider = document.getElementById(sliderId);
    var display = document.getElementById(displayId);
    var sync = document.getElementById(syncId);

    if (!slider || !display) {
      return;
    }

    function updateValue() {
      var value = slider.value;
      display.textContent = value + ' bulan';
      if (sync) {
        sync.value = value;
      }
    }

    slider.addEventListener('input', updateValue);

    if (sync) {
      sync.addEventListener('input', function () {
        var value = sync.value;
        slider.value = value;
        display.textContent = value + ' bulan';
      });
    }

    updateValue();
  }

  function bindCalculator(prefix, formId, buttonId, resultId, outputType) {
    var btn = document.getElementById(buttonId);
    var resultEl = document.getElementById(resultId);

    if (btn && resultEl) {
      btn.addEventListener('click', function () {
        runSimulation(prefix, resultEl);
      });

      var typeSelect = document.getElementById(prefix + 'ProductType');
      if (typeSelect) {
        typeSelect.addEventListener('change', function () {
          runSimulation(prefix, resultEl);
        });
      }

      var amountInput = document.getElementById(prefix + 'Amount');
      if (amountInput) {
        amountInput.addEventListener('input', function () {
          runSimulation(prefix, resultEl);
        });
      }

      var tenureSlider = document.getElementById(prefix + 'TenureRange');
      if (tenureSlider) {
        tenureSlider.addEventListener('input', function () {
          runSimulation(prefix, resultEl);
        });
      }

      var tenureInput = document.getElementById(prefix + 'Tenure');
      if (tenureInput) {
        tenureInput.addEventListener('input', function () {
          runSimulation(prefix, resultEl);
        });
      }

      runSimulation(prefix, resultEl);
    }
  }

  bindSlider('calcTenureRange', 'calcTenureValue', 'calcTenure');
  bindSlider('inlineTenureRange', 'inlineTenureValue', null);
  bindCalculator('calc', 'simulationCalculatorForm', 'btnSimulate', 'calculatorResult');
  bindCalculator('inline', 'productSimulationForm', 'btnInlineSimulate', 'inlineCalculatorResult');
})();
