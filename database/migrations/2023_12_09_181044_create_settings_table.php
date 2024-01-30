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
        Schema::create('settings', function (Blueprint $table) {
            $table->foreignId('school_year_id')->constrained();
            $table->enum('current_grading', GradingEnum::toArray())->default(GradingEnum::FIRST);
            $table->enum('enrollment_status', EnrollmentEnum::toArray())->default(EnrollmentEnum::CLOSE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
