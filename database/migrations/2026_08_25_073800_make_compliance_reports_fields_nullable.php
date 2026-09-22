<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('compliance_reports', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('file_path')->nullable()->change();
            $table->string('file_size')->nullable()->change();
            $table->string('fiscal_year')->nullable()->change();
            $table->string('category')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('compliance_reports', function (Blueprint $table) {
            $table->string('title')->nullable(false)->change();
            $table->string('file_path')->nullable(false)->change();
            $table->string('file_size')->nullable(false)->change();
            $table->string('fiscal_year')->nullable(false)->change();
            $table->string('category')->nullable(false)->change();
        });
    }
};