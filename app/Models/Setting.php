<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    public $timestamps = false;

    protected $fillable = [
        'phone_cs', 'email_publik', 'alamat_kantor', 'whatsapp_url', 'instagram_url', 'x_url', 'facebook_url',
        'site_name', 'site_tagline', 'site_logo',
        'two_factor', 'lockout', 'lockout_duration', 'session_timeout',
        'notif_login', 'notif_threat', 'notif_weekly', 'notif_email',
        'site_language', 'site_timezone', 'date_format',
        'maintenance',
        'badges',
    ];

    protected $casts = [
        'two_factor' => 'boolean',
        'lockout' => 'boolean',
        'notif_login' => 'boolean',
        'notif_threat' => 'boolean',
        'notif_weekly' => 'boolean',
        'maintenance' => 'boolean',
        'badges' => 'array',
    ];
}
