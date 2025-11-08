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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->decimal('first_test', 5, 2)->default(0); // max 100
            $table->decimal('second_test', 5, 2)->default(0); // max 100
            $table->decimal('ca', 5, 2)->default(0); // max 100
            $table->decimal('grade', 5, 2)->default(0); // calculated grade
            $table->integer('position')->nullable();
            $table->text('remark')->nullable();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
