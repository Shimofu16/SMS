<?php

use App\Enums\FeeTypeEnum;
use App\Enums\LevelEnum;
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
        Schema::create('annual_fees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('amount');
            $table->enum('type', FeeTypeEnum::toArray());
            $table->enum('level', LevelEnum::toArray());
            $table->foreignId('school_year_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annual_fees');
    }
};
