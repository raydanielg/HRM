<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\License\UpdateRequest;
use App\Models\ContactRequest;
use App\Models\EmailTemplate;

use App\Models\License;
use App\Models\LicenseType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

use Yajra\DataTables\Facades\DataTables;

class LicenseController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Licenses';
        $this->settingOpen = 'active open';
        $this->licenseActive = 'active';

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
        $this->licensesDef = License::select('license_number', 'licenses.name as name', 'licenses.email', 'licenses.company', 'license_types.name as type', 'expires_on', 'licenses.created_at as created_at', 'licenses.status as status')
            ->join('license_types', 'license_types.id', '=', 'licenses.license_type_id')
            ->orderBy('licenses.created_at', 'desc')->take(5)->get();
        $this->total = License::count();
        return View::make('admin.licenses.index', $this->data);
    }

    // DATA TABLE ajax request
    public function ajax_licenses()
    {
        $result = License::select('license_number', 'licenses.name as name', 'licenses.email', 'licenses.company', 'license_types.name as type', 'expires_on', 'licenses.created_at as created_at', 'licenses.status as status')
            ->join('license_types', 'license_types.id', '=', 'licenses.license_type_id')
            ->get();

        return DataTables::of($result)->editColumn('created_at', function ($row) {
            return date('d-M-Y', strtotime($row->created_at));
        })->editColumn('expires_on', function ($row) {
            return date('d-M-Y', strtotime($row->expires_on));
        })->editColumn('status', function ($row) {
            $color = ['Valid' => 'success', 'Expired' => 'danger', 'Disabled' => 'warning',];

            return "<span id='status{$row->license_number}' class='label label-{$color[$row->status]}'>{$row->status}</span>";
        })->addColumn('edit', function ($row) {
            $string = '<a  class="btn green btn-sm"  href="javascript:;" onclick="showEdit(\'' . $row->license_number . '\');return false;" ><i class="fa fa-edit"></i> ' . trans('core.edit') . '</a>';

            return $string;
        })
        ->rawColumns(['status', 'edit'])
        ->make();
    }

    public function change_status()
    {
        //Check employee Company
        $input = Input::all();
        $check = ContactRequest::find($input ['id']);

        if ($check == null) {
            return View::make('admin.errors.noaccess', $this->data);
        }

        $contact = ContactRequest::findOrFail($input ['id']);
        $contact->status = $input['status'];
        $contact->save();
        $output['status'] = 'success';
        $output['msg'] = trans("messages.updateSuccess");

        return Response::json($output, 200);
    }

    public function edit($license)
    {
        $this->types = LicenseType::pluck('name', 'id');

        //Check employee Company
        $this->license = License::where('license_number', $license)->first();
        $this->color = ['Valid' => 'success', 'Expired' => 'danger', 'Disabled' => 'warning',];

        if ($this->license == null) {
            return View::make('admin.errors.noaccess', $this->data);
        }

        return View::make('admin.licenses.edit', $this->data);
    }

    /**
     * Update the specified emailtemplate in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(UpdateRequest $request, $license)
    {
        $data = Input::all();

        $license = License::where('license_number', $license)->first();

        $license->license_number = $data['license_number'];
        $license->name = $data['name'];
        $license->email = $data['email'];
        $license->company = $data['company'];
        //$license->subdomain = $data['subdomain'];
        $license->license_type_id = $data['license_type_id'];
        $license->expires_on = date('Y-m-d', strtotime($data['expires_on']));
        $license->status = $data['status'];
        $license->save();

        $output['status'] = 'success';
        $output['msg'] = trans("messages.updateSuccess");

        return Response::json($output, 200);
    }


}
