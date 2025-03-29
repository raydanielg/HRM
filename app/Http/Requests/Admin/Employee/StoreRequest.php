<?php

namespace App\Http\Requests\Admin\Employee;

use App\Classes\Reply;
use App\Http\Requests\AdminCoreRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        $full_nameValidation = 'required';
        $ProfileImageValidation = 'image|mimes:jpeg,jpg,png,bmp|max:4000|min:1';

        return [
            'employeeID'    => 'required|unique:employees,employeeID,:id,id,company_id,' . admin()->company_id,
            'full_name' => $full_nameValidation, 'email' => 'required|email|unique:employees',
            'password' => 'required',
            'profile_image' => $ProfileImageValidation,
            'resume' => 'mimes:jpeg,jpg,png,bmp,pdf,doc,docx|max:4000',
            'offerLetter' => 'mimes:jpeg,jpg,png,bmp,pdf,doc,docx|max:4000',
            'joiningLetter' => 'mimes:jpeg,jpg,png,bmp,pdf,doc,docx|max:4000',
            'contract' => 'mimes:jpeg,jpg,png,bmp,pdf,doc,docx|max:4000',
            'IDProof' => 'mimes:pdf,jpeg,jpg,png,bmp|max:4000',
        ];
    }

    public function messages()
    {
        return [
            'employeeID.required' => ' EmployeeID is required'
        ];
    }

}
