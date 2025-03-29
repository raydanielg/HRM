<?php

namespace App\Http\Requests\Admin\Payroll;

use App\Http\Requests\AdminCoreRequest;
use App\Models\Payroll;

class DeleteRequest extends AdminCoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $payroll = Payroll::find($this->route('payroll'));
        return admin() && $payroll;
    }


    public function rules()
    {
        return [

        ];
    }
}
