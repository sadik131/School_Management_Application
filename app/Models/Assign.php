<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assign extends Model
{
    protected $fillable = [
        'teacher_id',
        'section_id',
        'title',
        'description',
        'due_date',
    ];
    
    protected $appends = [
        'submitted_count',
        'total_students',
    ];

    protected $casts = [
    'due_date' => 'date',
];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'assignment_id');
    }

    public function getSubmittedCountAttribute()
    {
        return $this->submissions()->count();
    }

    public function getTotalStudentsAttribute()
    {
        return $this->section
            ? $this->section->students()->count()
            : 0;
    }
}
