<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CstudentSsubject extends Model
{
    protected $table = 'cstudent_ssubject';
    
    protected $fillable = [
        'cstudent_id',
        'ssubject_id',
        'fees_paid',
        'extra_discount',
        'enrollment_date',
        'completion_date',
        'status',
    ];

    protected $casts = [
        'enrollment_date' => 'date',
        'completion_date' => 'date',
        'fees_paid' => 'decimal:2',
        'extra_discount' => 'decimal:2',
    ];

    /**
     * Get the student that owns the enrollment.
     */
    public function cstudent()
    {
        return $this->belongsTo(Cstudent::class, 'cstudent_id');
    }

    /**
     * Get the subject that owns the enrollment.
     */
    public function ssubject()
    {
        return $this->belongsTo(Ssubject::class, 'ssubject_id');
    }
}