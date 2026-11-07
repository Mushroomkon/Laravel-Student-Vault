<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Students</h2>
            <a href="{{ route('students.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm">
                + Add Student
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
                           placeholder="Search by name or student number..." 
                           class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    
                    <select name="status" class="border-gray-300 rounded-md shadow-sm">
                        <option value="">All Status</option>
                        <option value="active" @selected(request('status') == 'active')>Active</option>
                        <option value="inactive" @selected(request('status') == 'inactive')>Inactive</option>
                        <option value="graduated" @selected(request('status') == 'graduated')>Graduated</option>
                        <option value="suspended" @selected(request('status') == 'suspended')>Suspended</option>
                    </select>

                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Filter</button>
                    <a href="{{ route('students.index') }}" class="text-gray-600 px-4 py-2 text-sm">Reset</a>
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student No.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($students as $student)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->student_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->full_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $student->status === 'active' ? 'bg-green-100 text-green-800' : 
                                           ($student->status === 'graduated' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($student->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('students.show', $student) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    <a href="{{ route('students.edit', $student) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this student?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $students->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>