<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentEnrollmentController extends Controller
{
    public function index(): View
    {
        $student = auth()->user()->student;
        abort_unless($student, 403);

        $courses = Course::withCount('enrollments')->orderBy('code')->get();
        $enrolledCourseIds = $student->enrollments()->pluck('course_id')->all();
        $enrollments = $student->enrollments()->with('course')->latest('enrolled_at')->get();

        return view('student-enrollments.index', compact('courses', 'enrolledCourseIds', 'enrollments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $student = auth()->user()->student;
        abort_unless($student, 403);

        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $exists = Enrollment::where('student_id', $student->id)
            ->where('course_id', $validated['course_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['course_id' => 'You are already enrolled in this course.']);
        }

        Enrollment::create([
            'student_id' => $student->id,
            'course_id' => $validated['course_id'],
            'status' => 'enrolled',
            'enrolled_at' => now(),
        ]);

        return back()->with('success', 'You have successfully enrolled in the course.');
    }

    public function destroy(Enrollment $enrollment): RedirectResponse
    {
        $student = auth()->user()->student;
        abort_unless($student && $enrollment->student_id === $student->id, 403);

        $enrollment->update(['status' => 'dropped']);

        return back()->with('success', 'Enrollment dropped successfully.');
    }
}
