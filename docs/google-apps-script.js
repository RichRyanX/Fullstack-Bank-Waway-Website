const DEFAULT_WEBHOOK_URL = 'https://your-domain.example.com/api/webhooks/product-application';
const WEBHOOK_URL_KEY = 'WEBHOOK_URL';
const WEBHOOK_SECRET_KEY = 'WEBHOOK_SECRET';
const LOG_SHEET_ID_KEY = 'LOG_SHEET_ID';

function onFormSubmit(e) {
  const url = getWebhookUrl();
  const secret = getWebhookSecret();

  if (!secret) {
    logWebhookAudit('CONFIG_ERROR', null, null, 'WEBHOOK_SECRET not configured');
    return;
  }

  try {
    const payload = buildPayload(e);

    if (!payload.applicant_name || !payload.email) {
      logWebhookAudit('VALIDATION_ERROR', null, JSON.stringify(payload), 'Required fields missing');
      return;
    }

    const body = JSON.stringify(payload);
    const signature = computeSignature(body, secret);

    const response = UrlFetchApp.fetch(url, {
      method: 'post',
      contentType: 'application/json',
      payload: body,
      muteHttpExceptions: true,
      headers: {
        'Content-Type': 'application/json',
        'X-Webhook-Token': secret,
        'X-Webhook-Signature': signature
      }
    });

    const httpCode = response.getResponseCode();
    const resBody = response.getContentText();

    if (httpCode >= 200 && httpCode < 300) {
      logWebhookAudit('SUCCESS', httpCode, body, resBody);
      const json = JSON.parse(resBody || '{}');
      Logger.log('Webhook application created: %s', json.application_code || '');
      return;
    }

    logWebhookAudit('API_ERROR', httpCode, body, resBody);
  } catch (err) {
    logWebhookAudit('EXCEPTION', null, null, err.message);
  }
}

function buildPayload(e) {
  const values = extractValues(e);

  return {
    product_type: normalizeProductType(values.product_type),
    product_id: toNullableInteger(values.product_id),
    product_name: toNullableString(values.product_name),
    amount: toNumber(values.amount),
    tenure: toInteger(values.tenure),
    applicant_name: toRequiredString(values.applicant_name),
    nik: normalizeNik(values.nik),
    phone: toRequiredString(values.phone),
    email: toRequiredString(values.email),
    address: toNullableString(values.address),
    notes: toNullableString(values.notes)
  };
}

function extractValues(e) {
  const map = {};

  if (e && e.response && typeof e.response.getItemResponses === 'function') {
    const titleMap = {
      'Jenis Produk': 'product_type',
      'Produk / Layanan': 'product_id',
      'Nama Produk': 'product_name',
      'Nominal Pengajuan (Rupiah)': 'amount',
      'Jangka Waktu (Bulan)': 'tenure',
      'Nama Lengkap': 'applicant_name',
      'NIK (16 Digit)': 'nik',
      'No. Telepon / WhatsApp': 'phone',
      'Alamat Email': 'email',
      'Alamat Domisili': 'address',
      'Catatan Tambahan': 'notes'
    };

    const responses = e.response.getItemResponses();
    for (let i = 0; i < responses.length; i++) {
      const item = responses[i].getItem();
      const key = titleMap[String(item.getTitle() || '').trim()];
      if (key) {
        map[key] = responses[i].getResponse();
      }
    }
  }

  if (Object.keys(map).length === 0 && e && e.values) {
    const keys = [
      'product_type', 'product_id', 'product_name', 'amount', 'tenure',
      'applicant_name', 'nik', 'phone', 'email', 'address', 'notes'
    ];
    for (let i = 0; i < e.values.length && i < keys.length; i++) {
      map[keys[i]] = e.values[i];
    }
  }

  return map;
}

function normalizeProductType(value) {
  const v = String(value || '').toLowerCase().trim();
  if (v.indexOf('kredit') !== -1) return 'kredit';
  if (v.indexOf('deposito') !== -1) return 'deposito';
  if (v.indexOf('tabung') !== -1) return 'tabungan';
  return v;
}

function normalizeNik(value) {
  return String(value || '').replace(/\D/g, '').slice(0, 16);
}

function toNumber(value) {
  const cleaned = String(value || '').replace(/[^0-9.]/g, '');
  const num = parseFloat(cleaned);
  return isFinite(num) ? num : 0;
}

function toInteger(value) {
  const cleaned = String(value || '').replace(/[^0-9]/g, '');
  const num = parseInt(cleaned, 10);
  return Number.isInteger(num) ? num : 0;
}

function toNullableInteger(value) {
  const cleaned = String(value || '').trim();
  if (cleaned === '') return null;
  const num = parseInt(cleaned, 10);
  return Number.isInteger(num) ? num : null;
}

function toRequiredString(value) {
  return String(value == null ? '' : value).trim();
}

function toNullableString(value) {
  const str = String(value == null ? '' : value).trim();
  return str === '' ? null : str;
}

function computeSignature(body, secret) {
  const bytes = Utilities.computeHmacSha256Signature(body, secret);
  return bytesToHex(bytes);
}

function bytesToHex(bytes) {
  return bytes.map(function (b) {
    return ('0' + (b & 0xFF).toString(16)).slice(-2);
  }).join('');
}

function getWebhookUrl() {
  const props = PropertiesService.getScriptProperties();
  return props.getProperty(WEBHOOK_URL_KEY) || DEFAULT_WEBHOOK_URL;
}

function getWebhookSecret() {
  const props = PropertiesService.getScriptProperties();
  return props.getProperty(WEBHOOK_SECRET_KEY) || '';
}

function logWebhookAudit(status, httpCode, payload, responseBody) {
  const props = PropertiesService.getScriptProperties();
  const sheetId = props.getProperty(LOG_SHEET_ID_KEY);

  if (sheetId) {
    try {
      const ss = SpreadsheetApp.openById(sheetId);
      const sheet = ss.getSheetByName('WebhookLog') || ss.insertSheet('WebhookLog');
      sheet.appendRow([new Date(), status, httpCode == null ? 'N/A' : httpCode, payload || '', responseBody || '']);
      Logger.log('Webhook audit entry appended: %s', status);
    } catch (sheetErr) {
      Logger.log('Webhook audit sheet write failed: %s', sheetErr.message);
    }
  }

  Logger.log('WEBHOOK AUDIT status=%s http=%s payload=%s response=%s', status, httpCode, payload, responseBody);
}

function testWebhook() {
  const event = {
    response: {
      getItemResponses: function () {
        return [
          { getItem: function () { return { getTitle: function () { return 'Jenis Produk'; } }; }, getResponse: function () { return 'Kredit'; } },
          { getItem: function () { return { getTitle: function () { return 'Produk / Layanan'; } }; }, getResponse: function () { return '12'; } },
          { getItem: function () { return { getTitle: function () { return 'Nama Produk'; } }; }, getResponse: function () { return 'Kredit Usaha Rakyat'; } },
          { getItem: function () { return { getTitle: function () { return 'Nominal Pengajuan (Rupiah)'; } }; }, getResponse: function () { return '50000000'; } },
          { getItem: function () { return { getTitle: function () { return 'Jangka Waktu (Bulan)'; } }; }, getResponse: function () { return '36'; } },
          { getItem: function () { return { getTitle: function () { return 'Nama Lengkap'; } }; }, getResponse: function () { return 'Budi Santoso'; } },
          { getItem: function () { return { getTitle: function () { return 'NIK (16 Digit)'; } }; }, getResponse: function () { return '1807022901000001'; } },
          { getItem: function () { return { getTitle: function () { return 'No. Telepon / WhatsApp'; } }; }, getResponse: function () { return '081234567890'; } },
          { getItem: function () { return { getTitle: function () { return 'Alamat Email'; } }; }, getResponse: function () { return 'budi@email.com'; } },
          { getItem: function () { return { getTitle: function () { return 'Alamat Domisili'; } }; }, getResponse: function () { return 'Jl. Merdeka No. 10, Bandar Lampung'; } },
          { getItem: function () { return { getTitle: function () { return 'Catatan Tambahan'; } }; }, getResponse: function () { return 'Butuh pencairan cepat'; } }
        ];
      }
    }
  };

  onFormSubmit(event);
}
