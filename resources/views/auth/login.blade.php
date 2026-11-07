<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password with Toggle Visibility -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative mt-1">
                <x-text-input id="password" class="block w-full pr-10" type="password" name="password" required autocomplete="current-password" />
                <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-500 hover:text-gray-700">
                    <!-- Eye Icon (Hidden State) -->
                    <svg id="icon-hide-{{ $loop->index ?? 'pw' }}" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <!-- Eye Slash Icon (Visible State) -->
                    <svg id="icon-show-{{ $loop->index ?? 'pw' }}" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- reCAPTCHA -->
        <div class="mt-4">
            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
            <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <p class="mt-6 text-center text-sm text-gray-600">
                {{ __('Don\'t have an account?') }}
                <a class="rounded-md font-medium text-gray-900 underline hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>
            </p>
        @endif
    </form>

    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            function togglePassword(inputId, btn) {
                const input = document.getElementById(inputId);
                const iconShow = btn.querySelector('[id^="icon-show-"]');
                const iconHide = btn.querySelector('[id^="icon-hide-"]');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    iconShow.classList.add('hidden');
                    iconHide.classList.remove('hidden');
                } else {
                    input.type = 'password';
                    iconShow.classList.remove('hidden');
                    iconHide.classList.add('hidden');
                }
            }
        </script>
    @endpush
</x-guest-layout>
