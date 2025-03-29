<?php

namespace App\Http\Requests\Admin\Job;

use App\Classes\Reply;
use App\Http\Requests\AdminCoreRequest;
use App\Models\Job;
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
        $job = Job::find($this->route('job'));
        return admin() && $job;
    }


    public function rules()
    {
        return [
            'position' => 'required',
            'description' => 'required|min:20'
        ];
    }
}
