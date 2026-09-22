<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplianceReport extends Model
{
    protected $table = 'compliance_reports';

    protected $fillable = [
        'title', 'original_filename', 'file_path', 'file_size', 'fiscal_year',
        'category', 'status', 'security_level', 'retention_date', 'uploaded_by'
    ];

    protected $casts = [
        'retention_date' => 'date',
    ];
}