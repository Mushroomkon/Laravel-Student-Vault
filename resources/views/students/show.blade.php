<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Student Details</h2>
            <div class="space-x-2">
                <a href="{{ route('students.edit', $student) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm">Edit</a>
                <a href="{{ route('students.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Student Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><span class="text-gray-500">Student Number:</span> <strong>{{ $student->student_number }}</strong></div>
                    <div><span class="text-gray-500">Full Name:</span> <strong>{{ $student->full_name }}</strong></div>
                    <div><span class="text-gray-500">Email:</span> <strong>{{ $student->user->email }}</strong></div>
                    <div><span class="text-gray-500">Phone:</span> <strong>{{ $student->phone ?? 'N/A' }}</strong></div>
                    <div><span class="text-gray-500">Date of Birth:</span> <strong>{{ $student->date_of_birth?->format('M d, Y') ?? 'N/A' }}</strong></div>
                    <div><span class="text-gray-500">Status:</span> 
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $student->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($student->status) }}
                        </span>
                    </div>
                    <div class="md:col-span-2"><span class="text-gray-500">Address:</span> <strong>{{ $student->address ?? 'N/A' }}</strong></div>
                </div>
            </div>

            <!-- Enrollments -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Enrolled Courses</h3>
                @if($student->enrollments->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Course Code</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Grade</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($student->enrollments as $enrollment)
                                <tr>
                                    <td class="px-4 py-2">{{ $enrollment->course->code }}</td>
                                    <td class="px-4 py-2">{{ $enrollment->course->title }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($enrollment->status) }}</td>
                                    <td class="px-4 py-2">{{ $enrollment->grade ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500">No enrollments yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>