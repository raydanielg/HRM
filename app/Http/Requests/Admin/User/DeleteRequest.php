<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\AdminCoreRequest;
use App\Models\Admin;

class DeleteRequest extends AdminCoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $admin = Admin::find($this->route('admin_user'));
        return admin() && $admin;
    }


    public function rules()
    {
        return [
        ];
    }
}
