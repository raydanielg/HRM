<?php

namespace App\Http\Requests\Admin\SuperAdminUser;

use App\Http\Requests\AdminCoreRequest;

class UpdateRequest extends AdminCoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return admin()->type === 'superadmin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required',
            'email' => 'required|email|unique:admins,email,'.$this->superadmin_user,
            'password' => 'confirmed',
        ];
    }
}
