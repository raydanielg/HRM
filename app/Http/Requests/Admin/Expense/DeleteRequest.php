<?php

namespace App\Http\Requests\Admin\Expense;

use App\Classes\Reply;
use App\Http\Requests\AdminCoreRequest;
use App\Models\Award;
use App\Models\Expense;
use Illuminate\Support\Facades\Lang;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteRequest extends AdminCoreRequest
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
        ];
    }
}
