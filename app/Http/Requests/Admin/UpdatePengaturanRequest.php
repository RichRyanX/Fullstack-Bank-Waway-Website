<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePengaturanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone_cs' => 'nullable|string',
            'email_publik' => 'nullable|email',
            'alamat_kantor' => 'nullable|string',
            'whatsapp_url' => 'nullable|string',
            'instagram_url' => 'nullable|string',
            'x_url' => 'nullable|string',
            'facebook_url' => 'nullable|string',
            'site_name' => 'nullable|string',
            'site_tagline' => 'nullable|string',
            'site_logo' => 'nullable|string',
            'two_factor' => 'nullable|boolean',
            'lockout' => 'nullable|boolean',
            'lockout_duration' => 'nullable|integer|min:1|max:1440',
            'session_timeout' => 'nullable|integer',
            'notif_login' => 'nullable|boolean',
            'notif_threat' => 'nullable|boolean',
            'notif_weekly' => 'nullable|boolean',
            'notif_email' => 'required|email',
            'site_language' => 'nullable|string',
            'site_timezone' => 'nullable|string',
            'date_format' => 'nullable|string',
            'maintenance' => 'nullable|boolean',
            'badges' => 'nullable|array',
            'badges.*.name' => 'nullable|string',
            'badges.*.description' => 'nullable|string',
            'badges.*.logo' => 'nullable|string',
            'badges.*.active' => 'nullable|boolean',
            'badges.*.category' => 'nullable|string',
            'badges.*.license' => 'nullable|string',
            'badges.*.validUntil' => 'nullable|string',
            'badges.*.reference' => 'nullable|string',
        ];
    }
}
