<?php

namespace App\Http\Requests\Site;

use App\Http\Requests\SiteCoreRequest;

class SignupRequest extends SiteCoreRequest
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
            'company_name' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:admins|unique:companies',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|min:5'
        ];
    }

}
