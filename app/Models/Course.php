<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'code', 'title', 'description', 'credits', 'department'
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
                    ->withPivot('status', 'grade', 'enrolled_at')
                    ->withTimestamps();
    }

}
