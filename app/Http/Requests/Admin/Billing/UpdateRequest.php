<?php

namespace App\Http\Requests\Admin\Billing;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "company_id" => "required|exists:companies,id",
            "license_number" => "required|exists:licenses,license_number",
            "invoice_number" => "required",
            "transaction_id" => "transactions|exists:transactions,id",
            "amount" => "required|numeric",
            "invoice_date" => "required|date",
            "due_date" => "required|date",
            "status" => "required",
            "item_name" => "required|array"
        ];
    }

    public function messages()
    {
        return [
            "item_name.required" => "At least one item should be added"
        ];
    }
}
