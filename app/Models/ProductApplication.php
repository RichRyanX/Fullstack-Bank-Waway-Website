<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductApplication extends Model
{
    protected $table = 'product_applications';

    protected $fillable = [
        'application_code',
        'product_id',
        'product_name',
        'product_type',
        'amount',
        'tenure',
        'applicant_name',
        'nik',
        'phone',
        'email',
        'address',
        'notes',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tenure' => 'integer',
        'product_id' => 'integer',
    ];
}
