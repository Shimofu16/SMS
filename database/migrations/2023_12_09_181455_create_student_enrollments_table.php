<?php

use App\Enums\EnrollmentStudentTypeEnum;
use App\Enums\StudentEnrollmentStatusEnum;
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
        Schema::create('student_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('grade_level_id')->constrained();
            $table->foreignId('section_id')->nullable()->constrained();
            $table->foreignId('school_year_id')->constrained();
            $table->enum('student_type', EnrollmentStudentTypeEnum::toArray()); //
            $table->text('department');
            $table->json('documents');
            $table->json('payments')->nullable();
            $table->enum('status', StudentEnrollmentStatusEnum::toArray()); // ['accepted', 'pending', 'declined']
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_enrollments');
    }
};
