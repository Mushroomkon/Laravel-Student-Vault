<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];

        if ($this->user()->isStudent()) {
            $rules['first_name']     = ['required', 'string', 'max:100'];
            $rules['last_name']      = ['required', 'string', 'max:100'];
            $rules['phone']          = ['required', 'string', 'max:30'];
            $rules['date_of_birth']  = ['required', 'date', 'before_or_equal:today'];
            $rules['address']        = ['required', 'string', 'max:1000'];
        } else {
            $rules['name'] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }
}
