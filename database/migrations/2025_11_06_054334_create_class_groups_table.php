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
        Schema::create('class_groups', function (Blueprint $table) {
            $table->id();
            $table->string('course_group_code', 20);
            $table->string('course_group_name', 20);
            $table->foreignId('level_id')->constrained('levels')->onDelete('cascade');
            $table->string('class_room', 10)->nullable();
            $table->integer('level_year');
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade');
            $table->foreignId('teacher_advisor_id')->nullable()->constrained('teachers')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_groups');
    }
};
