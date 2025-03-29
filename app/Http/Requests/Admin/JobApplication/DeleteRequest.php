<?php

namespace App\Http\Requests\Admin\JobApplication;

use App\Http\Requests\AdminCoreRequest;
use App\Models\Job;
use App\Models\JobApplication;

class DeleteRequest extends AdminCoreRequest
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
