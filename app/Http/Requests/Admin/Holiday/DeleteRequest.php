<?php

namespace App\Http\Requests\Admin\Holiday;

use App\Classes\Reply;
use App\Http\Requests\AdminCoreRequest;
use App\Models\Award;
use App\Models\Holiday;
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
        $holiday = Holiday::find($this->route('holiday'));
        return admin() && $holiday;
    }


    public function rules()
    {
        return [
        ];
    }
}
