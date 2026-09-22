<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Identitas Situs
            $table->string('site_name')->nullable();
            $table->string('site_tagline')->nullable();
            $table->text('site_logo')->nullable();

            // Keamanan
            $table->boolean('two_factor')->default(false);
            $table->boolean('lockout')->default(false);
            $table->integer('session_timeout')->nullable();

            // Notifikasi
            $table->boolean('notif_login')->default(false);
            $table->boolean('notif_threat')->default(false);
            $table->boolean('notif_weekly')->default(false);
            $table->string('notif_email')->nullable();

            // Lokalisasi
            $table->string('site_language')->nullable();
            $table->string('site_timezone')->nullable();
            $table->string('date_format')->nullable();

            // Pemeliharaan
            $table->boolean('maintenance')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'site_name', 'site_tagline', 'site_logo',
                'two_factor', 'lockout', 'session_timeout',
                'notif_login', 'notif_threat', 'notif_weekly', 'notif_email',
                'site_language', 'site_timezone', 'date_format',
                'maintenance',
            ]);
        });
    }
};