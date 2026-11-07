<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::withCount('enrollments');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        $courses = $query->latest()->paginate(10);

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:courses,code|max:20',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1|max:6',
            'department' => 'nullable|string|max:100',
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $course->load(['enrollments.student']);
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'code' => 'required|max:20|unique:courses,code,' . $course->id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1|max:6',
            'department' => 'nullable|string|max:100',
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}