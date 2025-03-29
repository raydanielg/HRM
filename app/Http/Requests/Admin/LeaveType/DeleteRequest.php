<?php

namespace App\Http\Requests\Admin\LeaveType;

use App\Http\Requests\AdminCoreRequest;
use App\Models\Leavetype;

class DeleteRequest extends AdminCoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $leaveType = Leavetype::find($this->route('leavetype'));
        return admin() && $leaveType;
    }


    public function rules()
    {
        return [
        ];
    }
}
