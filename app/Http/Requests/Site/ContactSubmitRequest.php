<?php

namespace App\Http\Requests\Site;

use App\Http\Requests\SiteCoreRequest;

class ContactSubmitRequest extends SiteCoreRequest
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
            "name"     => "required",
            "email" => "email|required",
            "category" => "required",
            "details" => "required|min:10",
            "tts"  => "honeypot",
            "tts_time" => "required|honeytime:5"
        ];
    }

}
