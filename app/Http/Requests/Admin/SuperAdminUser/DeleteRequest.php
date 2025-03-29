<?php

namespace App\Http\Requests\Admin\SuperAdminUser;

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
        return admin()->type === 'superadmin';
    }


    public function rules()
    {
        return [
        ];
    }
}
