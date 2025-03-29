<?php

namespace App\Http\Requests\Admin\LicenseType;

use App\Classes\Reply;
use App\Http\Requests\AdminCoreRequest;
use App\Models\LicenseType;
use Illuminate\Support\Facades\Lang;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCountryRequest extends AdminCoreRequest
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
            'country' => 'required',
            'currency_code' => 'required',
            'currency_symbol' => 'required',
            'price' => 'required'
        ];
    }

}
