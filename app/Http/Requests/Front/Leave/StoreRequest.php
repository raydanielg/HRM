<?php

namespace App\Http\Requests\Front\Leave;

use App\Http\Requests\FrontCoreRequest;

class StoreRequest extends FrontCoreRequest
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
        if($this->get('leaveformType') == 'date_range') {
            return [
                'start_date' => 'required',
                'end_date' => 'required'
            ];
        }

        return [
//            'date.*' => 'required|unique:leave_applications,start_date,NULL,id,employee_id,' . $user->id
            'date.*' => 'required',
            'leaveType.0' => 'required'
        ];

    }

    public function messages()
    {
        return [
            'date.*.required'  => 'Date field is required',
            'date.*.unique'  => 'You have already applied leave for this date',
            'leaveType.*.required'  => 'Leave type field is required',
        ];
    }
}
