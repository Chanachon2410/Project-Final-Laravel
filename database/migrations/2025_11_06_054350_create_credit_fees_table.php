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
        Schema::create('credit_fees', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('semester');
            $table->integer('year');
            $table->foreignId('level_id')->constrained('levels')->onDelete('cascade');
            $table->decimal('credit_fee', 10, 2);
            $table->decimal('lab_fee', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_fees');
    }
};
