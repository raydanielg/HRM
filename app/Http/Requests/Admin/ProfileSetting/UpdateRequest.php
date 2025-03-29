<?php

namespace App\Http\Requests\Admin\ProfileSetting;

use App\Classes\Reply;
use App\Http\Requests\AdminCoreRequest;
use Illuminate\Foundation\Http\FormRequest;
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
        //name and email change
        if($this->type == 'login')
        {
            return [
                'name' => 'required',
                'email' => 'required|email'
            ];
        } else { // else type is password or may be if users send value of type something else then in that case we just break that operation by passing that in this block
            return [
                'password'              => 'required|confirmed',
                'password_confirmation' => 'required|min:5'
            ];
        }
    }
}
