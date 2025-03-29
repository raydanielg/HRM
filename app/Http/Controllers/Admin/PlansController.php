<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Plan\StoreRequest;
use App\Http\Requests\Admin\Plan\UpdateRequest;
use App\Models\Plan;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Input;


class PlansController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Plans';
        $this->settingOpen = 'active open';
        $this->licenseTypesActive = 'active';

        $this->middleware(function ($request, $next) {
            if (admin()->type != 'superadmin') {
                echo View::make('admin.errors.noaccess', $this->data);
                die();
            }
            return $next($request);
        });
    }

    public function index()
    {
        $plans = Plan::all();

        return View::make('admin.plans.index', $this->data);
    }

    // DATA TABLE ajax request
    public function ajax_plans()
    {
        $result = Plan::select('id', 'plan_name','stripe_annual_plan_id', 'stripe_monthly_plan_id', 'start_user_count', 'end_user_count', 'monthly_price', 'annual_price', 'status')
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($result)->editColumn('stripe_monthly_plan_id', function ($row) {
            $string = '<ul>';
            $string .= '<li>Monthly - '.$row->stripe_monthly_plan_id.'</li>';
            $string .= '<li>Annual - '.$row->stripe_annual_plan_id.'</li>';
            $string .= '</ul>';
            return $string;
        })->editColumn('start_user_count', function ($row) {
            $string = '<ul>';
            $string .= '<li>Start Users - '.$row->start_user_count.'</li>';
            $string .= '<li>End Users - '.$row->end_user_count.'</li>';
            $string .= '</ul>';
            return $string;
        })->editColumn('monthly_price', function ($row) {
            $string = '<ul>';
            $string .= '<li>Monthly - '.$row->monthly_price.'</li>';
            $string .= '<li>Annual - '.$row->annual_price.'</li>';
            $string .= '</ul>';
            return $string;
        })->editColumn('status', function ($row) {
            $color = ['0' => 'danger', '1' => 'success'];
            $text = ['0' => 'disabled', '1' => 'enabled'];

            return "<span id='status{$row->id}' class='label label-{$color[$row->status]}'>{$text[$row->status]}</span>";

        })->addColumn('edit', function ($row) {
            $string = '<a  class="btn green btn-sm"  href="javascript:;" onclick="showEdit(' . $row->id . ');return false;" ><i class="fa fa-edit"></i> ' . trans('core.edit') . '</a>';

            return $string;
        })
        ->rawColumns(['stripe_monthly_plan_id', 'start_user_count', 'monthly_price', 'status', 'edit'])
        ->make();
    }

    public function create()
    {
        $this->plan = new Plan();

        //Check employee Company
        $this->color = ['Pending' => 'warning', 'Completed' => 'success'];

        return View::make('admin.plans.create', $this->data);
    }

    public function store(StoreRequest $request)
    {
        $plan = new Plan();

        $plan->plan_name = $request->plan_name;
        $plan->start_user_count = $request->start_user_count;
        $plan->end_user_count = $request->end_user_count;
        $plan->monthly_price = $request->monthly_price;
        $plan->annual_price = $request->annual_price;
        $plan->stripe_annual_plan_id = $request->stripe_annual_plan_id;
        $plan->stripe_monthly_plan_id = $request->stripe_monthly_plan_id;
        $plan->status = Input::get('status');
        $plan->save();

        $output['msg'] = trans("messages.updateSuccess");

        return Reply::success(trans("messages.updateSuccess"));
    }

    public function edit($id)
    {
        //Check employee Company
        $this->plan = Plan::find($id);
        $this->color = ['Pending' => 'warning', 'Completed' => 'success'];

        if ($this->plan == null) {
            return View::make('admin.errors.noaccess', $this->data);
        }

        return View::make('admin.plans.edit', $this->data);
    }

    public function update(UpdateRequest $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $plan->plan_name = $request->plan_name;
        $plan->start_user_count = $request->start_user_count;
        $plan->end_user_count = $request->end_user_count;
        $plan->monthly_price = $request->monthly_price;
        $plan->annual_price = $request->annual_price;
        $plan->stripe_annual_plan_id = $request->stripe_annual_plan_id;
        $plan->stripe_monthly_plan_id = $request->stripe_monthly_plan_id;
        $plan->status = Input::get('status');
        $plan->save();

        $output['msg'] = trans("messages.updateSuccess");

        return Reply::success(trans("messages.updateSuccess"));
    }

}
