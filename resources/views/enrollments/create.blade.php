<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Enrollment</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('enrollments.store') }}">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <x-input-label for="student_id" value="Student" />
                            <select id="student_id" name="student_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                                        {{ $student->student_number }} — {{ $student->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="course_id" value="Course" />
                            <select id="course_id" name="course_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>
                                        {{ $course->code }} — {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" value="Status" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="enrolled" @selected(old('status') == 'enrolled')>Enrolled</option>
                                <option value="completed" @selected(old('status') == 'completed')>Completed</option>
                                <option value="dropped" @selected(old('status') == 'dropped')>Dropped</option>
                                <option value="failed" @selected(old('status') == 'failed')>Failed</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="grade" value="Grade (optional)" />
                                <x-text-input id="grade" type="number" step="0.01" name="grade" class="mt-1 block w-full" 
                                              :value="old('grade')" placeholder="e.g. 1.25" />
                                <x-input-error :messages="$errors->get('grade')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="enrolled_at" value="Enrolled Date" />
                                <x-text-input id="enrolled_at" type="date" name="enrolled_at" class="mt-1 block w-full" 
                                              :value="old('enrolled_at', now()->format('Y-m-d'))" />
                                <x-input-error :messages="$errors->get('enrolled_at')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 gap-4">
                        <a href="{{ route('enrollments.index') }}" class="text-gray-600">Cancel</a>
                        <x-primary-button>Save Enrollment</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>