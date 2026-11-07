<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

    

        foreach ($studentsData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);

            Student::create([
                'user_id' => $user->id,
                'student_number' => $data['student_number'],
                'first_name' => explode(' ', $data['name'])[0],
                'last_name' => explode(' ', $data['name'])[1] ?? '',
                'phone' => '09' . rand(100000000, 999999999),
                'status' => 'active',
            ]);
        }



        foreach ($courses as $course) {
            Course::create($course);
        }

        foreach ($courseIds->take(3) as $courseId) {
            Enrollment::create([
                'student_id' => $student1->id,
                'course_id' => $courseId,
                'status' => 'enrolled',
                'enrolled_at' => now()->subDays(rand(10, 60)),
            ]);
        }
    }
}