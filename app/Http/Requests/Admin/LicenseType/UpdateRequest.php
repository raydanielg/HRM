<?php

namespace App\Http\Requests\Admin\LicenseType;

use App\Classes\Reply;
use App\Http\Requests\AdminCoreRequest;
use App\Models\LicenseType;
use Illuminate\Support\Facades\Lang;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        $license = LicenseType::findOrFail($this->license_type);

        if ($license->type == 'Cloud') {
            $rules = ['name' => 'required', 'free_users' => 'required', 'price' => 'required',];
        } else {
            $rules = ['name' => 'required', 'price' => 'required',];
        }

        return $rules;
    }

}
