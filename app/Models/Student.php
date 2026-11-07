<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id', 'student_number', 'first_name', 'last_name',
        'phone', 'date_of_birth', 'address', 'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
                    ->withPivot('status', 'grade', 'enrolled_at')
                    ->withTimestamps();
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}