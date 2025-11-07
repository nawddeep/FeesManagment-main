<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cstudent extends Model
{
    protected $fillable = [
        'name',
        'father_name',
        'mobile',
        'email',
        'gender',
        'photo',
        'address',
        'competition_level',
    ];

    /**
     * Get the subjects enrolled by this competition student.
     */
    public function ssubjects()
    {
        return $this->belongsToMany(Ssubject::class, 'cstudent_ssubject')
                    ->withPivot(['fees_paid', 'fees_submitted', 'extra_discount', 'enrollment_date', 'completion_date', 'status', 'date_of_submitted'])
                    ->withTimestamps();
    }

    /**
     * Get the enrollment pivot records for this student.
     */
    public function enrollments()
    {
        return $this->hasMany(CstudentSsubject::class, 'cstudent_id');
    }
}