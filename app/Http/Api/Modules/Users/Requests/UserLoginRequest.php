<?php

namespace App\Http\Api\Modules\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required_unless:phone,null|email|exists:users,email',
            'phone' => 'required_unless:email,null',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            //TODO:: Any Customized message
             ];
    }
}
