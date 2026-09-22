<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('compliance_reports', function (Blueprint $table) {
            $table->string('mime_type')->nullable()->after('file_size');
            $table->string('file_hash')->nullable()->after('mime_type');
            $table->string('uploaded_by')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('compliance_reports', function (Blueprint $table) {
            $table->dropColumn(['mime_type', 'file_hash']);
            $table->string('uploaded_by')->nullable(false)->change();
        });
    }
};
