<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'root_id', 'category', 'file_name', 'file_path',
        'version', 'tahun_buku', 'status', 'uploaded_by'
    ];

    public function uploader()
    {
        return $this->belongsTo(Admin::class, 'uploaded_by');
    }
}
