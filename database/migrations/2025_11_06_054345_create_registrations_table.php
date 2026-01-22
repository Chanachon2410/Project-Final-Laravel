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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->tinyInteger('semester');
            $table->integer('year');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->string('approved_by')->nullable()->comment('ชื่อผู้ทำการอนุมัติ');
            $table->text('remarks')->nullable()->comment('หมายเหตุ เช่น เหตุผลการปฏิเสธ');
            $table->string('registration_card_file')->nullable();
            $table->string('slip_file_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
