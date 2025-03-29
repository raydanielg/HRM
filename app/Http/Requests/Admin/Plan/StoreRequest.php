<?php

namespace App\Http\Requests\Admin\Plan;

use App\Classes\Reply;
use App\Http\Requests\AdminCoreRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends AdminCoreRequest
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
            'plan_name' => 'required',
            'start_user_count' => 'required',
            'end_user_count' => 'required',
            'monthly_price' => 'required',
            'annual_price' => 'required',
            'stripe_monthly_plan_id' => 'required',
            'stripe_annual_plan_id' => 'required'
        ];
    }

}
