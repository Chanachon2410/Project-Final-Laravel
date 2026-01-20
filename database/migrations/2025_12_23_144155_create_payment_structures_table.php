<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_structures', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('ชื่อรายการ เช่น ใบแจ้งหนี้ ปวช.2 เทอม 1/68');
            $table->tinyInteger('semester');
            $table->integer('year');
            
            // Target Group
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade');
            $table->foreignId('level_id')->constrained('levels')->onDelete('cascade'); // e.g., ปวช.2
            
            // Bank Info
            $table->string('company_code', 10)->default('81245');
            $table->string('custom_ref2', 20)->nullable()->comment('รหัสกลุ่มเรียน (Ref.2) ที่ต้องการกำหนดเอง');
            
            // Dates for PDF footer
            $table->date('payment_start_date')->nullable();
            $table->date('payment_end_date')->nullable();
            $table->date('late_payment_start_date')->nullable();
            $table->date('late_payment_end_date')->nullable();
            
            $table->boolean('is_active')->default(true)->comment('สถานะเปิด/ปิดการใช้งาน');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_structures');
    }
};