<?php

namespace App\Http\Requests\Admin\SmtpSetting;

use App\Http\Requests\AdminCoreRequest;

class UpdateSmtpSetting extends AdminCoreRequest
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

    }

}
