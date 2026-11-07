<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Enrollments</h2>
            <a href="{{ route('enrollments.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm">
                + New Enrollment
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search & Filter -->
            <div class="bg-white p-4 mb-6 shadow-sm sm:rounded-lg">
                <form method="GET" class="flex flex-wrap gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search student or course..." 
                           class="border-gray-300 rounded-md shadow-sm">
                    
                    <select name="status" class="border-gray-300 rounded-md shadow-sm">
                        <option value="">All Status</option>
                        <option value="enrolled" @selected(request('status') == 'enrolled')>Enrolled</option>
                        <option value="completed" @selected(request('status') == 'completed')>Completed</option>
                        <option value="dropped" @selected(request('status') == 'dropped')>Dropped</option>
                        <option value="failed" @selected(request('status') == 'failed')>Failed</option>
                    </select>

                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Filter</button>
                    <a href="{{ route('enrollments.index') }}" class="text-gray-600 px-4 py-2 text-sm">Reset</a>
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Course</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enrolled At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($enrollments as $enrollment)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-medium">{{ $enrollment->student->full_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $enrollment->student->student_number }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">{{ $enrollment->course->code }}</div>
                                    <div class="text-sm text-gray-500">{{ $enrollment->course->title }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $enrollment->status === 'enrolled' ? 'bg-blue-100 text-blue-800' : 
                                           ($enrollment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($enrollment->status === 'dropped' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($enrollment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $enrollment->grade ?? '—' }}</td>
                                <td class="px-6 py-4">{{ $enrollment->enrolled_at?->format('M d, Y') ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <a href="{{ route('enrollments.show', $enrollment) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    <a href="{{ route('enrollments.edit', $enrollment) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                    <form action="{{ route('enrollments.destroy', $enrollment) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this enrollment?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No enrollments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $enrollments->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>