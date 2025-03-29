<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class SiteCoreRequest extends FormRequest
{

    /**
     * CoreRequest constructor.
     */
    public function __construct()
    {
        parent::__construct();

    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'status' => 'fail',
            'errors' => $validator->getMessageBag()->toArray()
        ];
        throw new HttpResponseException(response()->json($response, 200));
    }

}