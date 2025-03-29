<?php

namespace App\Http\Requests\Admin\Job;

use App\Classes\Reply;
use App\Http\Requests\AdminCoreRequest;
use App\Models\Admin;
use App\Models\Award;
use App\Models\Job;
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
        $job = Job::find($this->route('job'));
        return admin() && $job;
    }


    public function rules()
    {
        return [
        ];
    }
}
