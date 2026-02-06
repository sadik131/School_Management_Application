<?php 

namespace App\Services;
use App\Models\Section;

class SectionService
{
    public function getAll(){
        return Section::with('semester.course')->latest()->get();
    }
    public function create(array $data){
        return Section::create($data);
    }
    public function update(Section $section,array $data){
        return $section->update($data);
    }
    public function delete(Section $section){
        return $section->delete();
    }
}
