<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_name',
        'year_level',
        'course_id'
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
