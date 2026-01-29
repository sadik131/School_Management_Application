<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\AssignmentSubmission;
use App\Models\Section;


class Assign extends Model
{
    protected $fillable = [
        'teacher_id',
        'section_id',
        'title',
        'description',
        'due_date',
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
}
