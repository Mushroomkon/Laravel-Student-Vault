<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
       $request->validate([
    'phone' => ['required', 'string', 'max:30'],
    'first_name' => ['required', 'string', 'max:100'],
    'last_name' => ['required', 'string', 'max:100'],
    'date_of_birth' => ['required', 'date', 'before_or_equal:today'],
    'address' => ['required', 'string', 'max:1000'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
    'g-recaptcha-response' => ['required', new Recaptcha],   
]);

        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => trim($request->first_name . ' ' . $request->last_name),
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'student',
            ]);

            Student::create([
                'user_id' => $user->id,
                'student_number' => 'STU-' . str_pad((string) $user->id, 6, '0', STR_PAD_LEFT),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
                'status' => 'active',
            ]);

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
