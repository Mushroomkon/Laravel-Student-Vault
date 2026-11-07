<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
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
            $rules['phone'] = ['required', 'string', 'max:30'];
            $rules['first_name'] = ['required', 'string', 'max:100'];
            $rules['last_name'] = ['required', 'string', 'max:100'];
            $rules['date_of_birth'] = ['required', 'date', 'before_or_equal:today'];
            $rules['address'] = ['required', 'string', 'max:1000'];
        }

        return $rules;
    }
}
