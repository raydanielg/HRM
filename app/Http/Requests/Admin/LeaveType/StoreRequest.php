<?php

namespace App\Http\Requests\Admin\LeaveType;

use App\Http\Requests\AdminCoreRequest;

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


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'leaveType' => 'required|unique:leavetypes,leaveType,:id,id,company_id,'.$this->companyId,
            'num_of_leave'=>'required|integer'
        ];
    }

}
