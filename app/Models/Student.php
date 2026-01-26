<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Student extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_id',
        'student_id',
        'roll_number',
        'section_id',
        'program',
        'semester',
        'admission_year',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    
    public function activity()
    {
        return $this->hasOne(StudentActivity::class);
    }
}
