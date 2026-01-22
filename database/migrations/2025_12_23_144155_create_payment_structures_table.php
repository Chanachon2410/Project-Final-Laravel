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
            $table->string('name');
            $table->integer('semester');
            $table->integer('year');
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade');
            $table->foreignId('level_id')->constrained('levels')->onDelete('cascade');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->date('payment_start_date')->nullable();
            $table->date('payment_end_date')->nullable();
            
            // Late Fee Logic Columns
            $table->date('late_payment_start_date')->nullable();
            $table->date('late_payment_end_date')->nullable();
            $table->decimal('late_fee_amount', 10, 2)->default(0)->comment('จำนวนเงินค่าปรับ (ต่อวันหรือเหมาจ่าย)');
            $table->enum('late_fee_type', ['flat', 'daily'])->default('flat')->comment('flat=เหมาจ่าย, daily=ปรับรายวัน');
            $table->integer('late_fee_max_days')->nullable()->comment('จำนวนวันปรับสูงสุด (เฉพาะ daily)');
            
            $table->boolean('is_active')->default(true);
            $table->string('custom_ref2')->nullable()->comment('รหัสอ้างอิง Ref.2 แบบกำหนดเอง');
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