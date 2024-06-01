<?php

namespace App\Models;

use App\Models\Batch;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'birth_date', 'age', 'photo', 'gender', 'class', 'batch', 'os', 'ip'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->ip = request()->ip();
        });

        static::updating(function ($model) {
            $model->ip = request()->ip();
        });
    }

    public function getPhotoUrlAttribute()
    {
        return Storage::disk('public')->url($this->photo);
    }
}
