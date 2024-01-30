<?php

use App\Enums\FamilyMemberContactTypeEnum;
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_family_members');
    }
};
