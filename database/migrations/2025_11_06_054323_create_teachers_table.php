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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            // แก้ไข: เพิ่ม ->nullable() ในคอลัมน์ที่ไม่จำเป็นต้องมีทันที
            $table->string('teacher_code', 20)->nullable(); // อนุญาตให้ว่างได้
            $table->string('title', 20)->nullable();        // อนุญาตให้ว่างได้

            $table->string('firstname', 100);
            $table->string('lastname', 100);

            // แก้ไข: เพิ่ม ->nullable()
            $table->string('citizen_id', 13)->nullable();   // อนุญาตให้ว่างได้

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
