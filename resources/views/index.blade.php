<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'University Student Portal') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&family=playfair-display:600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f7f8fc] font-sans text-slate-800 antialiased">
    <header class="border-b border-white/10 bg-[#102a43] text-white">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5 lg:px-8" aria-label="Main navigation">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/Logo.png') }}" alt="Student Vault logo" class="h-11 w-11 rounded-full object-contain">
                <span>
                    <span class="block text-lg font-bold leading-tight tracking-wide">Student Vault</span>
                    <span class="block text-xs uppercase tracking-[0.22em] text-blue-200">Student Management</span>
                </span>
            </a>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-md bg-amber-400 px-5 py-2.5 text-sm font-bold text-[#102a43] transition hover:bg-amber-300">Go to Dashboard</a>
                @else
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hidden rounded-md px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/10 sm:block">Create Account</a>
                    @endif
                    <a href="{{ route('login') }}" class="rounded-md bg-white px-5 py-2.5 text-sm font-bold text-[#102a43] transition hover:bg-blue-50">Sign In</a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        <section class="relative overflow-hidden bg-[#102a43]">
            <div class="absolute inset-0 opacity-20" aria-hidden="true">
                <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full border-[70px] border-blue-300"></div>
                <div class="absolute bottom-0 left-1/4 h-40 w-40 rounded-full bg-blue-400 blur-3xl"></div>
            </div>

            <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-6 py-20 lg:grid-cols-[1.15fr_.85fr] lg:px-8 lg:py-28">
                <div class="max-w-2xl text-white">
                    <p class="mb-5 text-sm font-bold uppercase tracking-[0.28em] text-amber-300">Welcome to our academic community</p>
                    <h1 class="font-['Playfair_Display'] text-5xl font-bold leading-tight sm:text-6xl lg:text-7xl">
                        Shape your future through learning.
                    </h1>
                    <p class="mt-7 max-w-xl text-lg leading-8 text-blue-100 sm:text-xl">
                        Welcome to the Student Vault. Access your academic information, explore available courses, and manage your enrollment journey in one convenient place.
                    </p>
                    <div class="mt-9 flex flex-wrap gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="rounded-md bg-amber-400 px-6 py-3.5 font-bold text-[#102a43] shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:bg-amber-300">Enter Student Portal</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-md bg-amber-400 px-6 py-3.5 font-bold text-[#102a43] shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:bg-amber-300">Student Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-md border border-white/40 px-6 py-3.5 font-bold text-white transition hover:bg-white/10">Apply for an Account</a>
                            @endif
                        @endauth
                    </div>
                </div>

                <aside class="rounded-2xl border border-white/20 bg-white/95 p-8 shadow-2xl backdrop-blur sm:p-10">
                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-full bg-[#102a43] text-amber-300">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-4.35-7-11V5l7-2 7 2v5c0 6.65-7 11-7 11Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4" />
                        </svg>
                    </div>
                    <h2 class="font-['Playfair_Display'] text-3xl font-bold text-[#102a43]">Your university, at your fingertips</h2>
                    <p class="mt-4 leading-7 text-slate-600">Everything you need for a productive and organized academic experience.</p>
                    <ul class="mt-7 space-y-4 text-sm font-semibold text-slate-700">
                        <li class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-amber-400"></span>View student and course records</li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-amber-400"></span>Manage current enrollments</li>
                        <li class="flex items-center gap-3"><span class="h-2 w-2 rounded-full bg-amber-400"></span>Stay informed throughout your studies</li>
                    </ul>
                </aside>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
            <div class="mb-10 text-center">
                <p class="text-sm font-bold uppercase tracking-[0.24em] text-blue-700">Student services</p>
                <h2 class="mt-3 font-['Playfair_Display'] text-4xl font-bold text-[#102a43]">Designed for your academic journey</h2>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <article class="rounded-xl border border-slate-200 bg-white p-7 shadow-sm">
                    <div class="text-2xl font-bold text-blue-700">01</div>
                    <h3 class="mt-5 text-xl font-bold text-[#102a43]">Academic Profile</h3>
                    <p class="mt-3 leading-7 text-slate-600">Keep your student information organized and easily accessible.</p>
                </article>
                <article class="rounded-xl border border-slate-200 bg-white p-7 shadow-sm">
                    <div class="text-2xl font-bold text-blue-700">02</div>
                    <h3 class="mt-5 text-xl font-bold text-[#102a43]">Course Discovery</h3>
                    <p class="mt-3 leading-7 text-slate-600">Explore available courses and plan the next step in your education.</p>
                </article>
                <article class="rounded-xl border border-slate-200 bg-white p-7 shadow-sm">
                    <div class="text-2xl font-bold text-blue-700">03</div>
                    <h3 class="mt-5 text-xl font-bold text-[#102a43]">Enrollment Access</h3>
                    <p class="mt-3 leading-7 text-slate-600">View enrollment details and manage your studies from one place.</p>
                </article>
            </div>
        </section>
    </main>

    <footer class="bg-[#102a43] text-blue-100">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-6 py-7 text-sm sm:flex-row sm:items-center sm:justify-between lg:px-8">
            <p class="font-semibold text-white">University Student Management Portal</p>
            <p>&copy; {{ date('Y') }} All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
