<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ssubject extends Model
{
    protected $fillable = [
        'subject_name',
        'fees',
        'discount',
        'description',
        'status',
    ];

    /**
     * Get the competition students enrolled in this subject.
     */
    public function cstudents()
    {
        return $this->belongsToMany(Cstudent::class, 'cstudent_ssubject')
                    ->withPivot(['fees_paid', 'fees_submitted', 'extra_discount', 'enrollment_date', 'completion_date', 'status', 'date_of_submitted'])
                    ->withTimestamps();
    }
}