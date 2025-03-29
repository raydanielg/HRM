<?php

namespace App\Http\Requests\Admin\Award;

use App\Classes\Reply;
use App\Http\Requests\AdminCoreRequest;
use App\Models\Award;
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
        $award = Award::find($this->route('award'));
        return admin() && (admin()->company_id == $award->company_id);
    }

    protected function failedValidation(Validator $validator)
    {
        $response = Reply::failedToastr($validator);
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
            'award_name'  => 'required',
            'employee_id' => 'required',
            'gift'       => 'required',
        ];
    }
}
