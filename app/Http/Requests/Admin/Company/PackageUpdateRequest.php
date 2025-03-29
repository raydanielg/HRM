<?php

namespace App\Http\Requests\Admin\Company;

use App\Http\Requests\AdminCoreRequest;

class PackageUpdateRequest extends AdminCoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pay_date' => 'required',
            'package' => 'required|exists:subscription_plans,id',
            'packageType' => 'required|in:monthly,annual',
        ];
    }
}
