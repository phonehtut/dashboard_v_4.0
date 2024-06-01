<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = ['bname', 'cname', 'start_date', 'end_date'];

    public function students()
    {

        return $this->belongsToMany(Student::class, 'student_batch');
    }
}
