<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'teacher_id',
        'designation',
        'department',
        'qualification',
        'experience',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assign::class);
    }

    public function activity()
    {
        return $this->hasOne(TeacherActivity::class);
    }

    public function sections()
    {
        return $this->belongsToMany(
            Section::class,
            'section_teacher',

            'teacher_id',
            'section_id'
        );
    }
}
