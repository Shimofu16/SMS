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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('subject_id')->constrained();
            $table->foreignId('section_id')->constrained();
            $table->foreignId('grade_level_id')->constrained();
            $table->foreignId('school_year_id')->constrained();
            $table->foreignId('teacher_id')->constrained();
            $table->json('type')->nullable();//grading or semester [grading,semester] both are null
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('schedule_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained();
            $table->date('date');
            $table->time('start');
            $table->time('end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('schedule_classes');
    }
};
