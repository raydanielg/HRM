<?php

namespace App\Http\Requests\Admin\Expense;

use App\Classes\Reply;
use App\Http\Requests\AdminCoreRequest;
use App\Models\Expense;
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
        $expense = Expense::find($this->route('expense'));
        return admin() && $expense;
    }


    public function rules()
    {
        return [
            'item_name' => 'required',
            'price' => 'required|regex:/^\d*(\.\d{2})?$/',
            'bill'     => 'mimes:pdf,doc,docx,png,jpg,jpeg,bmp|max:4000'
        ];
    }
}
