<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'code', 'status'];

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}
