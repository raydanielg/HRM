<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Files;
use App\Classes\Reply;
use App\Events\CompanyCreated;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Company\PackageUpdateRequest;
use App\Http\Requests\Admin\Company\StoreRequest;
use App\Http\Requests\Admin\Company\UpdateRequest;
use App\Models\Admin;
use App\Models\BrowseHistory;
use App\Models\Company;
use App\Models\Country;

use App\Models\Employee;

use App\Models\Plan;
use App\Models\Setting;
use App\Models\StripeInvoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

use Intervention\Image\Facades\Image;


use Yajra\DataTables\Facades\DataTables;

class CompaniesController extends AdminBaseController
{


    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Company';
        $this->companyOpen = 'active';
        $this->companyActive = 'active';
        //$this->superadmindashboardActive = 'active';

        $this->middleware(function ($request, $next) {
            if (admin()->type == 'admin') {
                $this->csettingOpen = 'active';
                $this->csettingActive = 'active';
            }
            return $next($request);
        });

        $this->countries = Country::where('currency_symbol', '!=', 'null')->groupBy('currency_code')->get();
        $this->countrieslist = Country::all();
    }

    public function index()
    {
        if (admin()->type == 'admin') {
            return View::make('admin.errors.noaccess', $this->data);
        }

        return View::make('admin.companies.index', $this->data);
    }

    public function ajax_company()
    {
        $result = Company::select('companies.id', 'logo', 'company_name', 'license_expired',
            'companies.created_at', 'companies.status as status', 'companies.package_type as plan_type', 'subscription_plans.plan_name as plan_name',
            \DB::raw('MAX(`admins`.`last_login`) as last_login'),
            \DB::raw('MAX(`admins`.`number_of_logins`) as number_of_logins'),
            \DB::raw('COUNT(DISTINCT(`employees`.`employeeID`)) as employee_count'))
            ->leftjoin('admins', 'admins.company_id', '=', 'companies.id')
            ->leftJoin("employees", "employees.company_id", "=", "companies.id")
            ->leftJoin("subscription_plans", "subscription_plans.id", "=", "companies.subscription_plan_id")
            ->groupBy('companies.id');

        if (Input::get('days') != '') {
            $result->whereRaw('admins.last_login>=DATE(NOW()) - INTERVAL ' . Input::get('days') . ' DAY');
        }

        return DataTables::of($result)
            ->editColumn('created_at', function ($row) {
                return date('d-M-Y', strtotime($row->created_at));
            })
            ->editColumn('company_name', function ($row) {
                $string = $row->company_name;
                $string .= "<br/>";

                return $string;
            })
            ->editColumn('plan_name', function ($row) {
                $package = '<div class="w-100 text-center">';
                $package .= '<div class="m-b-5">' . ucwords($row->plan_name). ' ('.ucfirst($row->plan_type).')' . '</div>';

                $package .= '<a href="javascript:;" class="btn btn-circle btn-success btn-xs package-update-button"
                      data-toggle="tooltip" data-company-id="'.$row->id.'" data-original-title="Change"><i class="fa fa-edit" aria-hidden="true"></i> Change </a>';
                $package .= '</div>';
                return $package;
            })
            ->removeColumn("license_expired", "plan_type")
            ->addColumn("number_of_logins", function ($row) {
                return $row->number_of_logins;
            })
            ->editColumn('status', function ($row) {
                $color = ['active' => 'success', 'inactive' => 'danger'];
                $string = "<span  id='status{$row->id}' class='margin-bottom-10 text-capitalize label label-{$color[$row->status]}'>" . $row->status . "</span><br><br>";
                if ($row->license_expired == 1) {
                    $string .= "<span class='margin-bottom-10 text-capitalize label label-danger'>" . trans('core.expire') . "</span><br><br>";
                }

                return $string;
            })
            ->editColumn('last_login', function ($row) {
                if (isset($row->last_login)) {
                    return Carbon::createFromTimestamp(strtotime($row->last_login))->diffForHumans();
                }

                $string = "<span  class='margin-bottom-10 text-capitalize label label-danger'>Never</span>";

                return $string;
            })
            ->editColumn('logo', function ($row) {
                return "<img src='" . $row->logo_image_url . "' height='20px'>";
            })
            ->addColumn('edit', function ($row) {
                if ($row->status == 'active') {
                    $r_status = 'Disable';
                    $color = 'blue-ebonyclay';
                    $icon = 'ban';
                } else {
                    $r_status = 'Enable';
                    $color = 'green';
                    $icon = 'check';
                }

                $string = '<a class="btn purple btn-sm margin-bottom-10" onclick="loadView(\'' . route("admin.companies.edit", $row->id) . '\');"  ><i class="fa fa-edit"></i> ' . trans('core.edit') . '</a>
                         <a href="javascript:;" onclick="del(' . $row->id . ');return false;" class="btn red btn-sm margin-bottom-10">
                         <i class="fa fa-trash"></i> ' . trans('core.btnDelete') . '</a>
                         <a  href="javascript:;" onclick="blockUnblock(' . $row->id . ',\'' . $row->status . '\',\'' . addslashes($row->company_name) . '\');return false;" class="btn ' . $color . ' btn-sm margin-bottom-10">
                         <i class="fa fa-' . $icon . '"></i> ' . $r_status . '</a>
                         <a  href="' . route("admin.companies.browse_history", ["id" => $row->id]) . '" class="btn blue btn-sm margin-bottom-10">
                         <i class="fa fa-globe"></i> ' . trans("core.browse_history") . '</a>
                         ';

                return $string;
            })
            ->rawColumns(['company_name', 'last_login', 'logo', 'status', 'edit', 'plan_name'])
            ->make(true);
    }

    /**
     * Show the form for creating a new company
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.companies.create', $this->data);
    }


    public function store(StoreRequest $request)
    {

        $data = $request->all();


        $currencyArray = explode(':', $request->currency);
        $data['currency'] = $currencyArray[1];
        $data['currency_symbol'] = $currencyArray[0];
        $data['timezone'] = Input::get('timezone') . '=' . Input::get('timezoneIndex');

        unset($data["timezoneIndex"]);

        $adminData = $data;
        unset($data['password']);
        $company = Company::create($data);
        if ($request->hasFile('logo')) {
            $file = new Files();
            $filename = $file->upload(Input::file('logo'), 'company_logo', null, 200, false);
            $company->logo = $filename;
            $company->save();
        }
        $admin = Admin::create($data);
        $admin->email = $request->email;
        $admin->password = Hash::make($adminData['password']);
        $admin->company_id = $company->id;
        $admin->email_verified = 'yes';
        $admin->save();

        event(new CompanyCreated($company));

        return Reply::redirect(route('admin.companies.index'),'messages.updateSuccess');

    }


    public function edit($id)
    {
        $this->company = Company::find($id);

        return View::make('admin.companies.edit', $this->data);
    }

    public function update(UpdateRequest $request, $id)
    {
        if (admin()->type == 'admin') {
            $id = $this->company_id;
        }
        $data = $request->all();
        $company = Company::findOrFail($id);

        if ($request->hasFile('logo')) {
            $file = new Files();
            $filename = $file->upload(Input::file('logo'), 'company_logo', null, 200, false);
            $company->logo = $filename;
            $company->save();
        }

        $currencyArray = explode(':', $request->currency);
        $data['currency'] = $currencyArray[1];
        $data['currency_symbol'] = $currencyArray[0];
        $data['timezone'] = Input::get('timezone') . '=' . Input::get('timezoneIndex');

        unset($data["timezoneIndex"]);

        $company->update($data);

        return Reply::success('messages.updateSuccess');
    }

    public function change_company()
    {
        $company = Company::findOrFail(Input::get('company_id'));
        Company::where('id', '<>', $company->id)->update(['active' => '0']);

        $company->active = '1';
        $company->save();

        $output['success'] = 'success';
        Session::flash('success', trans("messages.companyChange") . $company->company_name);

        return Response::json($output, 200);
    }

    public function change_status()
    {
        $id = Input::get('id');
        $status = Input::get('status');
        $company = Company::find($id);
        $company->status = ($status == 'inactive') ? 'active' : 'inactive';
        $company->save();
        return Reply::success(trans("messages.statusChange") . $company->status);

    }

    public function destroy($id)
    {
        Company::destroy($id);

        $output['success'] = 'deleted';
        
        return Reply::success('messages.successDelete');
    }

    public function browse_history($id)
    {
        $company = Company::findOrFail($id);

        $this->data["selected_company"] = $company;

        return view("admin.companies.browse_history", $this->data);
    }

    public function ajax_browse_history($id)
    {
        $result = BrowseHistory::join("admins", "admins.id", "=", "browse_history.admin_id")
            ->leftJoin("browse_history as bh", function ($query) {
                $query->on("browse_history.created_at", "<", "bh.created_at");
                $query->on("browse_history.company_id", "=", "bh.company_id");
            })
            ->where("browse_history.company_id", $id)
            ->groupBy("browse_history.id")
            ->select('browse_history.id as id', 'admins.name as admin', 'browse_history.ip', 'browse_history.route', 'browse_history.url', 'browse_history.created_at', \DB::raw("bh.created_at as time_spent_date"))->get();


        return DataTables::of($result)->editColumn('created_at', function ($row) {
            return date('d-M-Y', strtotime($row->created_at));
        })
            ->addColumn('time_spent', function ($row) {
                if ($row->time_spent_date != null) {
                    return Carbon::parse($row->created_at)->diffForHumans(Carbon::parse($row->time_spent_date), true);
                } else {
                    return "Last Viewed Page";
                }
            })->make(true);
    }

    /**
     * @param $companyId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function editPackage($companyId) {
        $this->packages = Plan::all();

        $this->company = Company::find($companyId);

        $this->currentPackage = Plan::find($this->company->subscription_plan_id);

        $this->lastInvoice = StripeInvoice::where('company_id', $companyId)->orderBy('created_at', 'desc')->first();

        $packageInfo = [];

        foreach($this->packages as $package) {
            $packageInfo[$package->id] = [
                'monthly' => $package->monthly_price,
                'annual' => $package->annual_price
            ];
        }
        $this->packageInfo = $packageInfo;

        $modal = view('admin.companies.editPackage', $this->data)->render();

        return response(['status' => 'success', 'data' => $modal], 200);
    }

    public function updatePackage(PackageUpdateRequest $request, $companyId)
    {
        $company = Company::find($companyId);

        try {
            $package = Plan::find($request->package);
            $company->subscription_plan_id = $package->id;
            $company->package_type = $request->packageType;
            $company->status = 'active';

            $payDate = $request->pay_date ? Carbon::parse($request->pay_date): Carbon::now();

            $company->licence_expire_on = ($company->package_type == 'monthly') ?
                $payDate->copy()->addMonth()->format('Y-m-d') :
                $payDate->copy()->addYear()->format('Y-m-d');

            $nextPayDate = $request->next_pay_date ? Carbon::parse($request->next_pay_date) : $company->licence_expire_on;

            $stripeInvoice = StripeInvoice::where('company_id', $companyId)->orderBy('created_at', 'desc')->first();

            if($company->isDirty('subscription_plan_id') || $company->isDirty('package_type') || (!$stripeInvoice)) {
                $stripeInvoice = new StripeInvoice();

            }

            $stripeInvoice->company_id = $company->id;
            $stripeInvoice->subscription_plan_id = $company->subscription_plan_id;
            $stripeInvoice->amount = $request->amount ?: $package->{$request->packageType.'_price'};
            $stripeInvoice->pay_date = $payDate;
            $stripeInvoice->next_pay_date = $nextPayDate;
            $stripeInvoice->save();

            $company->save();

            return response(['status' => 'success', 'message' => 'Package Updated Successfully.'], 200);
        } catch (\Exception $e) {
            return response(['status' => 'fail', 'message' => 'Some unknown error occur. Please try again.'], 500);
        }
    }
}
