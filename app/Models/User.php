<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
   protected $fillable = [
    'name',
    'email',
    'password',
    'role',
];

public function student()
{
    return $this->hasOne(Student::class);
}

public function isAdmin()
{
    return $this->role === 'admin';
}

public function isStudent()
{
    return $this->role === 'student';
}
}
