<?php

namespace App\Http\Requests\Admin\Job;

use App\Http\Requests\AdminCoreRequest;
use App\Models\Job;

class DeleteRequest extends AdminCoreRequest
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
