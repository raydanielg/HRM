<?php

namespace App\Http\Requests\Admin\Job;

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
            'position' => 'required',
            'description' => 'required|min:20'
        ];
    }

}
