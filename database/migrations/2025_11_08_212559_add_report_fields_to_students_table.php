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
        Schema::table('students', function (Blueprint $table) {
            $table->string('position_in_class')->nullable();
            $table->date('next_term_reopens')->nullable();
            $table->string('interest')->nullable();
            $table->string('conduct')->nullable();
            $table->string('attitude')->nullable();
            $table->text('class_teacher_remark')->nullable();
            $table->text('academic_remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['position_in_class', 'next_term_reopens', 'interest', 'conduct', 'attitude', 'class_teacher_remark', 'academic_remark']);
        });
    }
};
