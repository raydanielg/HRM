<?php

namespace App\Http\Requests\Admin\Holiday;

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
        return [
            'date.*' => 'required_with:occasion.*',
            'occasion.*' => 'required_with:date.*'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'date.*.required_with' => 'The date field is required when occasion is present.',
            'occasion.*' => 'The occasion field is required when date is present.'
        ];
    }
}
