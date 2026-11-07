<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::with(['student', 'course']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('student_number', 'like', "%{$search}%");
            })->orWhereHas('course', function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $enrollments = $query->latest()->paginate(10);

        return view('enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $students = Student::orderBy('last_name')->get();
        $courses = Course::orderBy('code')->get();
        return view('enrollments.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'status' => 'required|in:enrolled,completed,dropped,failed',
            'grade' => 'nullable|numeric|min:0|max:5',
            'enrolled_at' => 'nullable|date',
        ]);

        // Prevent duplicate
        $exists = Enrollment::where('student_id', $validated['student_id'])
            ->where('course_id', $validated['course_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['course_id' => 'This student is already enrolled in this course.'])->withInput();
        }

        Enrollment::create($validated);

        return redirect()->route('enrollments.index')->with('success', 'Enrollment created successfully.');
    }

    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['student', 'course']);
        return view('enrollments.show', compact('enrollment'));
    }

    public function edit(Enrollment $enrollment)
    {
        $students = Student::orderBy('last_name')->get();
        $courses = Course::orderBy('code')->get();
        return view('enrollments.edit', compact('enrollment', 'students', 'courses'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'status' => 'required|in:enrolled,completed,dropped,failed',
            'grade' => 'nullable|numeric|min:0|max:5',
            'enrolled_at' => 'nullable|date',
        ]);

        $enrollment->update($validated);

        return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully.');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully.');
    }
}