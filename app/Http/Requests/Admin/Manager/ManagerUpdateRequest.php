<?php

namespace App\Http\Requests\Admin\Manager;

use App\Classes\Reply;
use App\Http\Requests\AdminCoreRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ManagerUpdateRequest extends AdminCoreRequest
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

    protected function failedValidation(Validator $validator)
    {
        $response = Reply::failedToastr($validator);
        throw new HttpResponseException(response()->json($response, 200));
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
            'email' => 'required|email|unique:admins,email,'.$this->manager,
            'departments' => 'required|min:1'
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
