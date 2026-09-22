<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['username', 'password_hash', 'name', 'role', 'failed_attempts', 'locked_until'];

    protected $hidden = ['password_hash'];

    protected $casts = [
        'failed_attempts' => 'integer',
        'locked_until' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
