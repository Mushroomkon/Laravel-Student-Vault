<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Course Enrollment</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="rounded-md bg-green-100 px-4 py-3 text-green-700">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="rounded-md bg-red-100 px-4 py-3 text-red-700">{{ $errors->first() }}</div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900">Available courses</h3>
                <div class="mt-4 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @forelse($courses as $course)
                        @php($enrolled = in_array($course->id, $enrolledCourseIds))
                        <div class="rounded-lg border border-gray-200 p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-sm font-semibold text-indigo-600">{{ $course->code }}</p>
                                    <h4 class="mt-1 font-semibold text-gray-900">{{ $course->title }}</h4>
                                </div>
                                <span class="text-xs text-gray-500">{{ $course->credits }} credits</span>
                            </div>
                            <p class="mt-3 text-sm text-gray-600">{{ $course->description ?: 'No description available.' }}</p>
                            <p class="mt-3 text-xs text-gray-500">{{ $course->department ?: 'General' }}</p>
                            <form method="POST" action="{{ route('student.enrollments.store') }}" class="mt-5">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <button type="submit" @disabled($enrolled)
                                    class="w-full rounded-md px-4 py-2 text-sm font-semibold !text-white disabled:cursor-not-allowed disabled:!bg-gray-400 disabled:!text-white {{ $enrolled ? '!bg-gray-400' : '!bg-indigo-600 hover:!bg-indigo-700' }}" style="background-color: {{ $enrolled ? '#9ca3af' : '#4f46e5' }}; color: #ffffff !important;">
                                    {{ $enrolled ? 'Enrolled' : 'Add course' }}
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-gray-500">No courses are available.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900">My enrollments</h3>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50"><tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Course</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Enrolled date</th>
                            <th class="px-4 py-3 text-right text-xs font-medium uppercase text-gray-500">Action</th>
                        </tr></thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($enrollments as $enrollment)
                                <tr>
                                    <td class="px-4 py-3">{{ $enrollment->course->code }} — {{ $enrollment->course->title }}</td>
                                    <td class="px-4 py-3 capitalize">{{ $enrollment->status }}</td>
                                    <td class="px-4 py-3">{{ $enrollment->enrolled_at?->format('M d, Y') ?: '—' }}</td>
                                    <td class="px-4 py-3 text-right">
                                        @if($enrollment->status === 'enrolled')
                                            <form method="POST" action="{{ route('student.enrollments.destroy', $enrollment) }}" onsubmit="return confirm('Drop this course?')">
                                                @csrf @method('DELETE')
                                                <button class="text-red-600 hover:text-red-800">Drop</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">You are not enrolled in any courses yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
