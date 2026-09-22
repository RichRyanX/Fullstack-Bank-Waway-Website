# Bank Waway – Google Apps Script Webhook Bridge

This document describes how to deploy and configure the Google Apps Script bridge that
forwards external Google Form submissions into the Bank Waway API webhook pipeline.

## Deliverables

- `docs/google-apps-script.js` – the Google Apps Script bridge source.
- `docs/google-apps-script.md` – this setup and configuration guide.

## Architecture

The bridge subscribes to a Google Form submission event via an installable trigger.
On each submission it:

1. Extracts the form responses and maps them to the product application payload.
2. Computes an HMAC-SHA256 signature over the serialized JSON body.
3. Sends an asynchronous `POST` to `POST /api/webhooks/product-application`.
4. Logs the outcome (status code, payload, response) to a configurable audit sheet.

## Backend Integration

The receiving Laravel endpoint is registered in `routes/api.php` as:

```
POST /api/webhooks/product-application
```

The handler is `App\Http\Controllers\Api\WebhookController`. Authentication is
performed against `config('services.webhook.secret')`, whose value comes from the
`WEBHOOK_SECRET` environment variable defined in `.env.example`.

The controller accepts any of the following authentication mechanisms:

- `X-Webhook-Token: <secret>` (plain token, compared with `hash_equals`).
- `Authorization: Bearer <secret>`.
- `X-Webhook-Signature: <hex HMAC-SHA256 of the raw request body>`.

The bridge sends both `X-Webhook-Token` and `X-Webhook-Signature` headers for
compatibility with every authorization path.

## Payload Schema

The controller validates these keys. Field names match `App\Models\ProductApplication`
and the `product_applications` migration.

| Field            | Rule                                                  |
|------------------|-------------------------------------------------------|
| `product_type`   | required, one of `kredit`, `deposito`, `tabungan`     |
| `product_id`     | nullable integer                                      |
| `product_name`   | nullable string, max 255                              |
| `amount`         | required numeric, minimum 100000                      |
| `tenure`         | required integer, 1–360                               |
| `applicant_name` | required string, max 150                              |
| `nik`            | required string, exactly 16 digits                    |
| `phone`          | required string, max 30                               |
| `email`          | required valid email, max 255                         |
| `address`        | nullable string, max 500                              |
| `notes`          | nullable string, max 2000                             |

## Google Form Field Mapping

The bridge maps Google Form item titles to payload keys. Create the form items with
the following titles (or rely on the column-order fallback when the form is submitted
with `e.values`):

| Form item title                 | Payload key        |
|---------------------------------|--------------------|
| `Jenis Produk`                  | `product_type`     |
| `Produk / Layanan`              | `product_id`       |
| `Nama Produk`                   | `product_name`     |
| `Nominal Pengajuan (Rupiah)`    | `amount`           |
| `Jangka Waktu (Bulan)`          | `tenure`           |
| `Nama Lengkap`                  | `applicant_name`   |
| `NIK (16 Digit)`                | `nik`              |
| `No. Telepon / WhatsApp`        | `phone`            |
| `Alamat Email`                  | `email`            |
| `Alamat Domisili`               | `address`          |
| `Catatan Tambahan`              | `notes`            |

## Deployment Steps

1. Open [Google Apps Script](https://script.google.com) and create a new project.
2. Paste the contents of `docs/google-apps-script.js` into `Code.gs`.
3. Set the script properties (Script Properties) used by the bridge:
   - `WEBHOOK_URL` – full URL, e.g. `https://bank-waway.example.com/api/webhooks/product-application`.
   - `WEBHOOK_SECRET` – the value must equal `WEBHOOK_SECRET` in `.env`.
   - `LOG_SHEET_ID` – (optional) the spreadsheet ID used for webhook audit logging.
4. Save the project and authorize the required scopes (`Script Properties`,
   `UrlFetchApp`, and optionally `SpreadsheetApp`).
5. Create an **installable** trigger:
   - Event source: `From spreadsheet`.
   - Event type: `On form submit`.
   - Function: `onFormSubmit`.
6. Verify connectivity by running the `testWebhook` function from the editor; it
   fires a synthetic event through the full pipeline.

## Audit Logging

When `LOG_SHEET_ID` is configured, the bridge appends one row per submission to the
`WebhookLog` sheet with these columns:

- Timestamp
- Status (`SUCCESS`, `API_ERROR`, `EXCEPTION`, `VALIDATION_ERROR`, `CONFIG_ERROR`)
- HTTP response code (or `N/A`)
- Serialized request payload (or the error context)
- Response body

If the sheet does not exist, it is created automatically. Every event is also written
to the Apps Script execution log via `Logger.log`.

## Exception Handling

- Missing `WEBHOOK_SECRET` short-circuits with a `CONFIG_ERROR` audit entry.
- Missing required `applicant_name` or `email` short-circuits with a `VALIDATION_ERROR`.
- `UrlFetchApp.fetch` is called with `muteHttpExceptions: true`, so non-2xx responses
  are captured with their exact status code instead of throwing.
- Any thrown exception is caught and recorded as an `EXCEPTION` audit entry.

## Notes

- Do not add comments to the deployed script; the source is intentionally comment-free.
- The default webhook URL is a placeholder. Always set `WEBHOOK_URL` in Script Properties
  to the real production endpoint.
