<?php

return [
    'retention_threshold_days' => (int) env('COMPLIANCE_RETENTION_THRESHOLD_DAYS', 30),
    'storage_quota_bytes' => (int) env('COMPLIANCE_STORAGE_QUOTA_BYTES', 2 * 1024 * 1024 * 1024),
];