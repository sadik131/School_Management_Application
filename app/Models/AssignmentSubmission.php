<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    protected $fillable = [
        'assignment_id',
        'student_id',
        'answer_text',
        'marks',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    /* ================= Relations ================= */

    // assignment (Assign model)
    public function assignment()
    {
        return $this->belongsTo(Assign::class, 'assignment_id');
    }

    // student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
