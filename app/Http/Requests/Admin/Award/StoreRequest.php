<?php

namespace App\Http\Requests\Admin\Award;

use App\Http\Requests\AdminCoreRequest;

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


    public function rules()
    {
        return [
            'award_name'  => 'required',
            'employee_id' => 'required',
            'gift'       => 'required',
        ];
    }

}
