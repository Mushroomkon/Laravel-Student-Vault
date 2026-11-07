<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-indigo-600">Overview</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Dashboard</h2>
            </div>
            <p class="hidden text-sm text-slate-500 sm:block">{{ now()->format('l, F j, Y') }}</p>
        </div>
    </x-slot>

    <div class="py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100">✓</span>
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-8 overflow-hidden rounded-2xl bg-slate-900 px-6 py-7 text-white shadow-lg sm:px-8">
                <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
                    <div>
                        <p class="text-sm font-medium text-indigo-300">Student management</p>
                        <h1 class="mt-1 text-2xl font-bold sm:text-3xl">Welcome back, {{ Auth::user()->name }}</h1>
                        <p class="mt-2 max-w-xl text-sm text-slate-300">Here is a live snapshot of your students, courses, and enrollments.</p>
                    </div>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('students.create') }}" class="inline-flex shrink-0 items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm transition hover:bg-indigo-50">
                            Add student
                        </a>
                    @endif
                </div>
            </div>

            @if(auth()->user()->isStudent())
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-6 py-5">
                        <h2 class="text-lg font-semibold text-slate-900">My Selected Courses</h2>
                        <p class="mt-1 text-sm text-slate-500">Your courses and grades assigned by the administrator.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">Course</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">Grade</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-500">Enrolled</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @forelse($enrollments as $enrollment)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-slate-900">{{ $enrollment->course->code }} — {{ $enrollment->course->title }}</div>
                                        </td>
                                        <td class="px-6 py-4 capitalize text-slate-600">{{ $enrollment->status }}</td>
                                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $enrollment->grade ?? 'Not graded yet' }}</td>
                                        <td class="px-6 py-4 text-slate-600">{{ $enrollment->enrolled_at?->format('M d, Y') ?: '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">You have not selected any courses yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Total students</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">◎</span>
                    </div>
                    <p class="mt-5 text-3xl font-bold tracking-tight text-slate-900">{{ $totalStudents }}</p>
                    <p class="mt-1 text-xs text-slate-400">All registered students</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Active students</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">✓</span>
                    </div>
                    <p class="mt-5 text-3xl font-bold tracking-tight text-slate-900">{{ $activeStudents }}</p>
                    <p class="mt-1 text-xs text-slate-400">Currently active</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Total courses</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-sky-600">▤</span>
                    </div>
                    <p class="mt-5 text-3xl font-bold tracking-tight text-slate-900">{{ $totalCourses }}</p>
                    <p class="mt-1 text-xs text-slate-400">Available courses</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Enrollments</p>
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600">↗</span>
                    </div>
                    <p class="mt-5 text-3xl font-bold tracking-tight text-slate-900">{{ $totalEnrollments }}</p>
                    <p class="mt-1 text-xs text-slate-400">Across all courses</p>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-5">
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                    <div class="mb-5 flex items-start justify-between">
                        <div>
                            <h3 class="font-semibold text-slate-900">Students by status</h3>
                            <p class="mt-1 text-sm text-slate-500">Current student distribution</p>
                        </div>
                    </div>
                    <div class="mx-auto h-64 max-w-sm">
                        <canvas id="statusChart"></canvas>
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-3">
                    <div class="mb-5 flex items-start justify-between">
                        <div>
                            <h3 class="font-semibold text-slate-900">Top courses</h3>
                            <p class="mt-1 text-sm text-slate-500">Courses with the most enrollments</p>
                        </div>
                        <a href="{{ route('courses.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">View all →</a>
                    </div>
                    <div class="h-64">
                        <canvas id="courseChart"></canvas>
                    </div>
                </section>
            </div>
            @endif
        </div>
    </div>

    @if(auth()->user()->isAdmin())
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = 'Figtree, sans-serif';
        Chart.defaults.color = '#64748b';

        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($studentsByStatus->keys()) !!},
                datasets: [{
                    data: {!! json_encode($studentsByStatus->values()) !!},
                    backgroundColor: ['#4f46e5', '#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 4,
                    borderColor: '#ffffff',
                    hoverOffset: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, pointStyle: 'circle', padding: 18 } }
                }
            }
        });

        const courseCtx = document.getElementById('courseChart').getContext('2d');
        new Chart(courseCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($enrollmentsPerCourse->pluck('code')) !!},
                datasets: [{
                    label: 'Enrollments',
                    data: {!! json_encode($enrollmentsPerCourse->pluck('enrollments_count')) !!},
                    backgroundColor: '#4f46e5',
                    borderRadius: 6,
                    borderSkipped: false,
                    maxBarThickness: 42
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, border: { display: false }, ticks: { font: { weight: 600 } } },
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' }, border: { display: false }, ticks: { precision: 0, stepSize: 1 } }
                }
            }
        });
    </script>
    @endpush
    @endif
</x-app-layout>