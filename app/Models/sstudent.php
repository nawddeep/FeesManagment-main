<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sstudent extends Model
{
    //
     protected $fillable = [
        'name',
        'father_name',
        'mobile',
        'email',
        'gender',
        'photo',
        'class_id',
    ];

    public function fees()
    {
        return $this->hasMany(sfees::class, 'student_id');
    }

    public function class()
    {
        return $this->belongsTo(sclass::class, 'class_id');
    }
}
