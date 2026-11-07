<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isStudent()) {
            $student = auth()->user()->student;
            abort_unless($student, 403);

            $enrollments = $student->enrollments()
                ->with('course')
                ->latest('enrolled_at')
                ->get();

            return view('dashboard', compact('enrollments'));
        }

        $totalStudents = Student::count();
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();
        $activeStudents = Student::where('status', 'active')->count();

        $studentsByStatus = Student::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $enrollmentsPerCourse = Course::withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalStudents',
            'totalCourses',
            'totalEnrollments',
            'activeStudents',
            'studentsByStatus',
            'enrollmentsPerCourse'
        ));
    }
}