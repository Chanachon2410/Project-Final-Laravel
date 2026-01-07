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
        Schema::create('payment_structure_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_structure_id')->constrained('payment_structures')->onDelete('cascade');
            
            $table->string('name'); // ชื่อรายการ หรือ ชื่อวิชา
            $table->decimal('amount', 10, 2)->default(0); // จำนวนเงิน
            
            // Flags
            $table->boolean('is_subject')->default(false); // เป็นรายวิชาหรือไม่
            
            // Subject Details (Nullable if it's just a general fee)
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('set null');
            $table->decimal('credit', 4, 1)->nullable()->comment('หน่วยกิต');
            $table->integer('theory_hour')->nullable()->comment('ชม. ทฤษฎี');
            $table->integer('practical_hour')->nullable()->comment('ชม. ปฏิบัติ');
            
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_structure_items');
    }
};