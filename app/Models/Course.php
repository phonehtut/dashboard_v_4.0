<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['cname', 'skill_level', 'photo', 'instructor', 'price', 'description', 'start_date', 'end_date'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_course');
    }
}
