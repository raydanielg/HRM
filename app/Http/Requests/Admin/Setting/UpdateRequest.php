<?php

namespace App\Http\Requests\Admin\Setting;

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
        if($this->get('type') == 'stripeSetting') {
            return [
                'stripe_key' => 'required',
                'stripe_secret' => 'required',
                'stripe_webhook_secret' => 'required'
            ];
        }

        if($this->get('type') == 'smtpSetting') {

            if($this->mail_driver == 'smtp') { // if type is smtp
                return [
                    'mail_driver' => 'required',
                    'mail_host' => 'required',
                    'mail_port' => 'required',
                    'mail_username' => 'required',
                    'mail_password' => 'required',
                ];
            }
            return [
                'mail_driver' => 'required',
            ];
        }

        return [
            'main_name' => 'required',
            'email' => 'required|email',
            'name' => 'required',
            'logo'      => 'image|mimes:jpeg,jpg,png,bmp,gif,svg|max:1000'
        ];
    }
}
