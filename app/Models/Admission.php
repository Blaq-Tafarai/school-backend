<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $fillable = [
        'full_name',
        'date_of_birth',
        'gender',
        'place_of_birth',
        'nationality',
        'religion',
        'blood_group',
        'home_address',
        'current_grade_class',
        'desired_grade_class',
        'previous_school',
        'reason_leaving_previous_school',
        'father_name',
        'mother_name',
        'guardian_name',
        'relationship_to_student',
        'occupation',
        'employer',
        'phone_number',
        'email',
        'home_address_guardian',
        'emergency_contact_person',
        'emergency_contact_number',
        'allergies',
        'chronic_illnesses',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
