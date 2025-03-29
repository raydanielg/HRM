<?php

namespace App\Http\Requests\Admin\Company;

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
            'company_name' => 'required',
            'email' => 'required|email',
            'name' => 'required',
            'logo' => 'image|mimes:jpeg,jpg,png,bmp,gif,svg|max:1000'
        ];
    }
}
