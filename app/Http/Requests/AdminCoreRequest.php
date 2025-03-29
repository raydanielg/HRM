<?php

namespace App\Http\Requests;

use App\Classes\Reply;
use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class AdminCoreRequest extends FormRequest
{
    protected $user;
    protected $companyId;

    /**
     * CoreRequest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if (auth()->check()) {
            $this->user = admin();

            if ($this->user->type == 'admin') {
                $this->companyId = $this->user->company_id;
            } elseif ($this->user->type == 'superadmin') { // IF THE LOGGED IN USER IS A SUPERADMIN
                $company = Company::where('active', '=', '1')->first();
                $this->companyId = $company->id;
            }
        }

    }


    protected function failedValidation(Validator $validator)
    {
        $response = Reply::failedToastr($validator);
        throw new HttpResponseException(response()->json($response, 200));
    }
}
