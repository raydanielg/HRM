<?php

namespace App\Http\Requests\Admin\EmailTemplate;

use App\Http\Requests\AdminCoreRequest;
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
            'subject' => 'required',
            'body' => 'required'
        ];
    }

}
