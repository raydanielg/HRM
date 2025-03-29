<?php

namespace App\Http\Requests\Front\Job;

use App\Classes\Reply;
use App\Http\Requests\FrontCoreRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class StoreRequest extends FrontCoreRequest
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
        Validator::extend('resume_validation', function ($attr, $value) {
            return $value->getClientMimeType() === 'application/pdf' || $value->getClientMimeType() === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $value->getClientMimeType() === 'application/msword';
        });

        return [
            'resume' => 'required|resume_validation|max:4000',
            'name' => 'required',
            'email'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'resume.resume_validation' => 'The field resume must be a file of type pdf, doc, docx.'
        ];
    }

}
