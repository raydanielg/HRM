<?php

namespace App\Http\Requests\Admin\Employee;

use App\Http\Requests\AdminCoreRequest;
use App\Models\Employee;
use App\Models\Job;

class DeleteRequest extends AdminCoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $employee = Employee::find($this->route('employee'));
        return admin() && $employee;
    }


    public function rules()
    {
        return [
        ];
    }
}
