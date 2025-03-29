<?php

namespace App\Http\Requests\Front\Employee;

use App\Http\Requests\FrontCoreRequest;

class ChangePassswordRequest extends FrontCoreRequest
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
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|min:5'
        ];
    }

}
