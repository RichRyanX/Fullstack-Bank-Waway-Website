<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone_cs')->nullable();
            $table->string('email_publik')->nullable();
            $table->string('alamat_kantor')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
