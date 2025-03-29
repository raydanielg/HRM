<?php

namespace App\Http\Requests\Admin\SuperAdminUser;

use App\Http\Requests\AdminCoreRequest;
use Illuminate\Support\Facades\Lang;

class StoreRequest extends AdminCoreRequest
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
            'name'     => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|min:5'
        ];
    }

}
