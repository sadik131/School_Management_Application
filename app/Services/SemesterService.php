<?php

namespace App\Services;

use App\Models\Semester;

class SemesterService
{
    public function getAll()
    {
        return Semester::with('course')
            ->latest()
            ->get();
    }
    public function create(array $data)
    {
        return Semester::create($data);
    }
    public function update(Semester $semester, array $data)
    {
        return $semester->update($data);
    }
    public function delete(Semester $semester)
    {
        return $semester->delete();
    }
}
