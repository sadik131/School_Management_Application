<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'total_assignments',
        'checked_assignments',
        'pending_assignments',
        'total_classes',
        'attendance_avg',
        'eligible_students',
        'detained_students',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
