<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    protected $fillable = [
        'subject',
        'class_score',
        'exam_score',
        'total_score',
        'grade_meaning',
        'subj_pos_class',
        'subj_pos_form',
        'teacher_mod_p',
        'student_id',
        'teacher_id',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
