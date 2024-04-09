<?php

namespace App\Http\Api\Modules\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => ['required', 'regex:/^\S*$/', 'max:30','required'],
            'phone' => ['required', 'max:11','min:11'],
            'email' => ['required', 'email', 'max:100',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['required', 'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ];
    }

    public function messages()
    {
        return [
            //TODO:: For any customized messages
             ];
    }
}
