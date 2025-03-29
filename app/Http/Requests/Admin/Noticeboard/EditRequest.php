<?php

namespace App\Http\Requests\Admin\Noticeboard;

use App\Classes\Reply;
use App\Http\Requests\AdminCoreRequest;
use App\Models\Award;
use App\Models\Noticeboard;
use Illuminate\Support\Facades\Lang;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditRequest extends AdminCoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $noticeboard = Noticeboard::find($this->route('noticeboard'));
        return admin() && ($noticeboard);
    }


    public function rules()
    {
        return [
        ];
    }
}
