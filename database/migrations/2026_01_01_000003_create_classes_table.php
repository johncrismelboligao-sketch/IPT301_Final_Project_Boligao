<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('grade_level');
            $table->string('section', 50);
            $table->string('school_year', 9);
            $table->foreignId('teacher_id')->constrained('teachers')->restrictOnDelete();
            $table->timestamps();

            $table->unique(['grade_level', 'section', 'school_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
