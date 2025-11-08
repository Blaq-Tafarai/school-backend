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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            // Student Information
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('place_of_birth');
            $table->string('nationality');
            $table->string('religion');
            $table->string('blood_group');
            $table->text('home_address');
            $table->string('current_grade_class');
            $table->string('desired_grade_class');
            $table->string('previous_school');
            $table->text('reason_leaving_previous_school');
            // Parent/Guardian Information
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('guardian_name')->nullable();
            $table->string('relationship_to_student')->nullable();
            $table->string('occupation');
            $table->string('employer');
            $table->string('phone_number');
            $table->string('email');
            $table->text('home_address_guardian')->nullable();
            $table->string('emergency_contact_person');
            $table->string('emergency_contact_number');
            // Health & Medical Information
            $table->text('allergies')->nullable();
            $table->text('chronic_illnesses')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
