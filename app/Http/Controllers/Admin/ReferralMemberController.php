<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\Admin\ReferralMember\LoginRequest;
use App\Http\Requests\Admin\ReferralMember\UpdateRequest;
use App\Models\Country;
use App\Models\ReferralMember;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

use App\Http\Controllers\AdminBaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Response;

class ReferralMemberController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Referral Members';
        $this->settingOpen = 'active open';
        $this->referralMember = 'active';
        $this->countrieslist = Country::all();

        $this->middleware(function ($request, $next) {
            if (admin()->type != 'superadmin') {
                echo View::make('admin.errors.noaccess', $this->data);
                die();
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->referralDef = ReferralMember::select('id', 'referral_code', 'email', 'name', 'company_name', 'position', 'date_of_agreement', 'created_at', 'status')
            ->orderBy('referral_code', 'asc')->take(5)->get();
        $this->total = ReferralMember::count();
        return View::make('admin.referralmember.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax_members()
    {
        $result = ReferralMember::select('id', 'referral_code', 'email', 'name', 'company_name', 'position', 'date_of_agreement', 'created_at', 'status')
            ->get();

        return DataTables::of($result)
            ->editColumn('status', function ($row) {
                $color = ['active' => 'success', 'inactive' => 'danger'];

                return "<span id='status{$row->id}' class='label label-{$color[$row->status]}' >" . trans("core." . $row->status) . "</span>";
            })
            ->editColumn('created_at', function ($row) {
                return date('d-M-Y', strtotime($row->created_at));
            })
            ->editColumn('date_of_agreement', function ($row) {
                return date('d-M-Y', strtotime($row->date_of_agreement));
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
                return '<a  class="btn purple btn-sm margin-bottom-5"  href="' . route('admin.referral_members.edit', $row->id) . '" >
                <i class="fa fa-edit"></i> ' . trans("core.btnViewEdit") . '
              </a>
              <a  style="width: 94px" href="javascript:;" onclick="del(' . $row->id . ',\'' . $row->referral_code . '\');return false;" class="btn red btn-sm margin-bottom-10">
                        <i class="fa fa-trash"></i> ' . trans("core.btnDelete") . '</a>
                <a  href="javascript:;" onclick="changeStatus(' . $row->id . ');return false;" class="btn ' . $color . ' btn-sm margin-bottom-10">
                         <i class="fa fa-' . $icon . '"></i> ' . $r_status . '</a>';
            })
            ->rawColumns(['status', 'edit'])
            ->make();
    }

    public function create()
    {
        $this->pageTitle = trans('pages.referrals.addTitle');
        return View::make('admin.referralmember.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        $input = Input::all();

        $date = new \DateTime(Input::get('date_of_agreement'));
        $date = $date->format('Y-m-d H:i:s');
        $ref = new ReferralMember();
        $ref->name = Input::get('name');
        $ref->referral_code = strtoupper(substr($ref->name, 0, 4)) . rand(111111, 999999);
        $ref->email = Input::get('email');

        $ref->company_name = Input::get('company_name');
        $ref->company_address = Input::get('company_address');
        $ref->position = Input::get('position');
        $ref->phone = Input::get('phone');
        $ref->country = Input::get('country');
        $ref->date_of_agreement = $date;
        $ref->password = Hash::make(Input::get('password'));
        $ref->status = Input::get('status');
        if (Input::hasFile('agreement')) {
            $path = public_path() . "/uploads/" . $this->folder . "/agreements/";
            File::makeDirectory($path, $mode = 0777, true, true);

            $agreement = Input::file('agreement');
            $extension = $agreement->getClientOriginalExtension();
            $filename = strtolower($ref->name) . "_" . strtolower($ref->referral_code) . '_' .
                Input::get('date_of_agreement') . "." . strtolower($extension);

            File::makeDirectory($path, $mode = 0777, true, true);

            Input::file('agreement')
                ->move($path, $filename);


            $ref->agreement = $filename;
        }
        $ref->save();
        Session::flash('toastrHeading', trans('messages.success'));
        Session::flash('toastrMessage', trans("messages.successAdd"));
        Session::flash('toastrType', 'success');
        return ["status" => "success", "message" => trans("messages.successAdd"),
            'action' => 'redirect', 'url' => route('admin.referral_members.index')];
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->pageTitle = trans('pages.referrals.editTitle');

        $this->ref = ReferralMember::find($id);
        $date = new \DateTime($this->ref->date_of_agreement);
        $this->date = $date->format('d-m-Y');

        return View::make('admin.referralmember.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $date = new \DateTime(Input::get('date_of_agreement'));
        $date = $date->format('Y-m-d H:i:s');
        $ref = ReferralMember::findOrFail($id);
        $ref->referral_code = Input::get('referral_code');
        $ref->email = Input::get('email');
        $ref->name = Input::get('name');
        $ref->company_name = Input::get('company_name');
        $ref->company_address = Input::get('company_address');
        $ref->position = Input::get('position');
        $ref->phone = Input::get('phone');
        $ref->country = Input::get('country');
        $ref->status = Input::get('status');
        $ref->date_of_agreement = $date;
        if (Input::get('password')) {
            $ref->password = Hash::make(Input::get('password'));
        }
        if (Input::hasFile('agreement')) {
            $path = public_path() . "/uploads/" . $this->folder . "/agreements/";
            File::makeDirectory($path, $mode = 0777, true, true);

            $agreement = Input::file('agreement');
            $extension = $agreement->getClientOriginalExtension();
            $filename = strtolower($ref->name) . "_" . strtolower($ref->referral_code) . '_' .
                Input::get('date_of_agreement') . "." . strtolower($extension);

            File::makeDirectory($path, $mode = 0777, true, true);

            Input::file('agreement')
                ->move($path, $filename);


            $ref->agreement = $filename;
        }
        $ref->save();

        return ["status" => "success", "message" => trans("messages.successUpdate"),
            'toastrHeading' => trans('messages.success'), 'toastrMessage' => trans("messages.successUpdate"),
            'toastrType' => 'success', 'action' => 'showToastr'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Request::ajax()) {
            ReferralMember::destroy($id);
            $output['success'] = 'deleted';

            return Response::json($output, 200);
        }
    }

    public function change_status()
    {
        $id = Input::get('id');
        $ref = ReferralMember::findOrFail($id);
        if ($ref->status == "active") {
            $ref->status = 'inactive';
        } else {
            $ref->status = 'active';
        }
        $ref->save();
        return ["status" => "success",
            'toastrHeading' => trans('messages.success'), 'toastrMessage' => trans("messages.statusChanged"),
            'toastrType' => 'success', 'action' => 'showToastr'];
    }
}
