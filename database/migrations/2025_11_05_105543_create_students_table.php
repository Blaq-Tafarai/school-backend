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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob');
            $table->string('parents_email');
            $table->string('parents_phone');
            $table->string('parents_name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
            $table->text('address');
            $table->string('student_id')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
