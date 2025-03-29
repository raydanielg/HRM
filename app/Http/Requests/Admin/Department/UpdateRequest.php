<?php

namespace App\Http\Requests\Admin\Department;

use App\Http\Requests\AdminCoreRequest;
use App\Models\Department;
use Illuminate\Support\Facades\Lang;

class UpdateRequest extends AdminCoreRequest
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
            'name'      => 'required|unique:department,name,'.$this->department.',id,company_id,'.$this->companyId,
            "designation.0" => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => Lang::get('messages.nameRequired'),
            'designation.0.required' => Lang::get('messages.designation0required'),
        ];
    }
}
