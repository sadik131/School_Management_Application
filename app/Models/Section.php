<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['semester_id', 'name', 'capacity', 'status'];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}