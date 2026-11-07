<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
 public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    if ($user->isStudent()) {
        $user->student()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['phone', 'first_name', 'last_name', 'date_of_birth', 'address'])
        );

        $user->name = trim($request->first_name . ' ' . $request->last_name);
    } else {
        $user->name = $request->name;
    }

    $user->email = $request->email;

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}
}
