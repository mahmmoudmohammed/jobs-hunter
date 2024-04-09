<?php

namespace App\Http\Api\Modules\Jobs\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateJobRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:140'],
            'description' => ['required', 'string', 'max:3000'],
            'admin_id' => ['required', Rule::exists('admins','id')->whereNull('deleted_at')],
        ];
    }
}
