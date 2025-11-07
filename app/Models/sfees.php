<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sfees extends Model
{
    //
     protected $fillable = [
        'student_id',
        'extra_discount',
        'fees_submitted',
        'date_of_submitted',
    ];
    public function student()
{
    return $this->belongsTo(sstudent::class, 'student_id');
}
}
