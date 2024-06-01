<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'category', 'photo', 'content', 'publish', 'owner'];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->owner = Auth::user()->name;
        });
    }
}
