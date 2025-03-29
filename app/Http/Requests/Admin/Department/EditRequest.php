<?php

namespace App\Http\Requests\Admin\Department;

use App\Http\Requests\AdminCoreRequest;
use App\Models\Department;

class EditRequest extends AdminCoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $department = Department::find($this->route('department'));
        return admin() && $department;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }


}
