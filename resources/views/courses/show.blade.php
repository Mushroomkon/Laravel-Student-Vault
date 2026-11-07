<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Course Details</h2>
            <div class="space-x-2">
                <a href="{{ route('courses.edit', $course) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm">Edit</a>
                <a href="{{ route('courses.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">{{ $course->code }} – {{ $course->title }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><span class="text-gray-500">Credits:</span> <strong>{{ $course->credits }}</strong></div>
                    <div><span class="text-gray-500">Department:</span> <strong>{{ $course->department ?? 'N/A' }}</strong></div>
                    <div class="md:col-span-2"><span class="text-gray-500">Description:</span><br>{{ $course->description ?? 'No description.' }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Enrolled Students ({{ $course->enrollments->count() }})</h3>
                @if($course->enrollments->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Student No.</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Grade</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($course->enrollments as $enrollment)
                                <tr>
                                    <td class="px-4 py-2">{{ $enrollment->student->student_number }}</td>
                                    <td class="px-4 py-2">{{ $enrollment->student->full_name }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($enrollment->status) }}</td>
                                    <td class="px-4 py-2">{{ $enrollment->grade ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500">No students enrolled yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>