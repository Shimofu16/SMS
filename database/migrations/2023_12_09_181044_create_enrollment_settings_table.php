<?php

use App\Enums\EnrollmentEnum;
use App\Enums\GradingEnum;
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
        Schema::create('enrollment_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_year_id')->constrained();
            $table->enum('current_grading', GradingEnum::toArray())->default(GradingEnum::FIRST);
            $table->boolean('is_grade_editable')->default(false);
            $table->boolean('enrollment_status')->default(false);
            $table->boolean('is_current')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_settings');
    }
};
