<?php

use App\Enums\EnrollmentStudentTypeEnum;
use App\Enums\StudentEnrollmentPaymentStatus;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('school_id')->unique();
            $table->string('lrn')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('ext_name')->nullable();
            $table->string('gender');
            $table->string('email')->unique();
            $table->date('birthday');
            $table->string('address');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('student_family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained();
            $table->string('name');
            $table->date('birthday');
            $table->text('phone');
            $table->string('occupation');
            $table->string('relationship');
            $table->timestamps();
        });

        Schema::create('student_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('grade_level_id')->constrained();
            $table->foreignId('section_id')->nullable()->constrained();
            $table->foreignId('school_year_id')->constrained();
            $table->enum('student_type', EnrollmentStudentTypeEnum::toArray());
            $table->text('department');
            $table->json('documents');
            $table->json('payments')->nullable();
            $table->enum('status', StudentEnrollmentStatusEnum::toArray()); // ['accepted', 'pending', 'declined']
            $table->timestamps();
        });

        Schema::create('student_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('grade_level_id')->constrained();
            $table->foreignId('school_year_id')->constrained();
            $table->json('grades')->nullable();
            $table->timestamps();
        });

        Schema::create('student_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained();
            $table->decimal('amount_paid', 10, 2);
            $table->decimal('remaining_balance', 10, 2); // Remaining balance after this installment
            $table->boolean('has_balance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('student_family_members');
        Schema::dropIfExists('student_enrollments');
        Schema::dropIfExists('student_grades');
        Schema::dropIfExists('student_transactions');
    }
};
