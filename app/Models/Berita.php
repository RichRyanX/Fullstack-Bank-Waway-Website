<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = ['title', 'category', 'status', 'content', 'views', 'created_by'];

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
