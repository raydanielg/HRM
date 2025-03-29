<?php

namespace App\Http\Requests\Admin\JobApplication;

use App\Classes\Reply;
use App\Http\Requests\AdminCoreRequest;
use App\Models\Admin;
use App\Models\Award;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Lang;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ShowRequest extends AdminCoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $job = JobApplication::find($this->route('job_application'));
        return admin() && $job;
    }


    public function rules()
    {
        return [
        ];
    }
}
