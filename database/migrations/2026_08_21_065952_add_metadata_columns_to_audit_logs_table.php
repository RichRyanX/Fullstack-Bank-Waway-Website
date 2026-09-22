<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('method')->nullable();
            $table->string('route')->nullable();
            $table->integer('status_code')->nullable();
            $table->string('session_id')->nullable();
            $table->string('auth_guard')->nullable();
            $table->string('failure_reason')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('audit_logs', function (Blueprint $table) {
            $table->dropColumn([
                'old_values',
                'new_values',
                'user_agent',
                'method',
                'route',
                'status_code',
                'session_id',
                'auth_guard',
                'failure_reason',
            ]);
        });
    }
};
