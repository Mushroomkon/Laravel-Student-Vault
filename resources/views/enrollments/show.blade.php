<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Enrollment Details</h2>
            <div class="space-x-2">
                <a href="{{ route('enrollments.edit', $enrollment) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md text-sm">Edit</a>
                <a href="{{ route('enrollments.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Student</h3>
                        <p class="mt-1 text-lg font-semibold">{{ $enrollment->student->full_name }}</p>
                        <p class="text-sm text-gray-500">{{ $enrollment->student->student_number }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Course</h3>
                        <p class="mt-1 text-lg font-semibold">{{ $enrollment->course->code }}</p>
                        <p class="text-sm text-gray-500">{{ $enrollment->course->title }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Status</h3>
                        <p class="mt-1">
                            <span class="px-3 py-1 text-sm rounded-full
                                {{ $enrollment->status === 'enrolled' ? 'bg-blue-100 text-blue-800' : 
                                   ($enrollment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($enrollment->status === 'dropped' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Grade</h3>
                        <p class="mt-1 text-lg font-semibold">{{ $enrollment->grade ?? 'Not yet graded' }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Enrolled Date</h3>
                        <p class="mt-1">{{ $enrollment->enrolled_at?->format('F d, Y') ?? '—' }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Last Updated</h3>
                        <p class="mt-1">{{ $enrollment->updated_at->format('F d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>