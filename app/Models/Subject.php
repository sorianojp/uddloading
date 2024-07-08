<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject_name',
        'subject_code',
        'lec',
        'lab',
        'course_id'
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
