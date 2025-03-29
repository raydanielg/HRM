<?php

namespace App\Http\Requests\Front\Expense;

use App\Classes\Reply;
use App\Http\Requests\FrontCoreRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExpenseStore extends FrontCoreRequest
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
            'item_name' => 'required',
            'purchase_date' => 'required',
            'price' => 'required|regex:/^\d*(\.\d{2})?$/',
            'bill'     => 'mimes:pdf,doc,docx,png,jpg,jpeg,bmp|max:4000'
        ];
    }

}
