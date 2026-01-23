<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class StudentActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'attendance_percentage',
        'classes_attended',
        'total_classes',
        'assignments_submitted',
        'assignments_pending',
        'assignments_late',
        'exam_eligible',
        'exam_detained',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
