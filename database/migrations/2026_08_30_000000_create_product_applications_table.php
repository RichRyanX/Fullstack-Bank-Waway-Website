<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_code')->unique();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_type');
            $table->decimal('amount', 18, 2);
            $table->unsignedInteger('tenure');
            $table->string('applicant_name');
            $table->string('nik', 16);
            $table->string('phone', 30);
            $table->string('email');
            $table->string('address')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('BARU');
            $table->timestamps();

            $table->index(['product_type', 'status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_applications');
    }
};
