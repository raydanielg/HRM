<?php

namespace App\Http\Requests\Admin\ReferralMember;

use App\Classes\Reply;
use App\Http\Requests\AdminCoreRequest;
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

    protected function failedValidation(Validator $validator)
    {
        $response = Reply::failedOnly($validator);
        throw new HttpResponseException(response()->json($response, 200));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|unique:referral_member,email,'.$this->referral_member.',id',
            "referral_code" => 'required|unique:referral_member,referral_code,'.$this->referral_member.',id',
            'name'=>'required',
            'agreement' => 'mimes:pdf,doc,docx,png,jpg,jpeg|max:4000',
        ];
    }
}
