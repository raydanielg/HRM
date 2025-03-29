<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\LicenseType\UpdateRequest;
use App\Models\ContactRequest;
use App\Models\EmailTemplate;

use App\Models\LicenseType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

use Yajra\DataTables\Facades\DataTables;

class LicenseTypesController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'License Types';
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
        return View::make('admin.license_types.index', $this->data);
    }

    // DATA TABLE ajax request
    public function ajax_license_types()
    {
        $result = LicenseType::select('id', 'name', 'free_users', 'price', 'type', 'status')
            ->orderBy('created_at', 'desc')->get();

        return DataTables::of($result)->editColumn('created_at', function ($row) {
            return date('d-M-Y', strtotime($row->created_at));
        })->editColumn('free_users', function ($row) {
            if ($row->type != 'Cloud') {
                return '-';
            }

            return $row->free_users;
        })->editColumn('status', function ($row) {
            $color = ['Disabled' => 'danger', 'Enabled' => 'success'];

            return "<span id='status{$row->id}' class='label label-{$color[$row->status]}'>{$row->status}</span>";
        })->addColumn('edit', function ($row) {
            $string = '<a  class="btn green btn-sm"  href="javascript:;" onclick="showEdit(' . $row->id . ',\'license\');return false;" ><i class="fa fa-edit"></i> ' . trans('core.edit') . '</a>';

            return $string;
        })
        ->rawColumns(['free_users', 'status', 'edit'])
        ->make();
    }

    public function ajax_license_types_country()
    {
        $result = LicenseType::select('license_country_pricing.id', 'name', 'country', 'currency_code', 'currency_symbol', 'license_country_pricing.price')
            ->join('license_country_pricing', 'license_country_pricing.license_type_id', '=', 'license_types.id')
            ->orderBy('license_country_pricing.id', 'asc')->get();

        return DataTables::of($result)->addColumn('edit', function ($row) {
            $string = '<a  class="btn green btn-sm"  href="javascript:;" onclick="showEdit(' . $row->id . ',\'country\');return false;" ><i class="fa fa-edit"></i> ' . trans('core.edit') . '</a>';

            return $string;
        })->make();
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

    public function edit($id)
    {
        //Check employee Company
        $this->license = LicenseType::find($id);
        $this->color = ['Pending' => 'warning', 'Completed' => 'success'];

        if ($this->license == null) {
            return View::make('admin.errors.noaccess', $this->data);
        }

        return View::make('admin.license_types.edit', $this->data);
    }

    public function edit_country($id)
    {
        //Check employee Company
        $this->license = DB::table('license_country_pricing')
            ->select('license_country_pricing.id', 'name', 'country', 'currency_code', 'currency_symbol', 'license_country_pricing.price')
            ->join('license_types', 'license_country_pricing.license_type_id', '=', 'license_types.id')
            ->where('license_country_pricing.id', $id)->first();

        if ($this->license == null) {
            return View::make('admin.errors.noaccess', $this->data);
        }

        return View::make('admin.license_types.edit_country', $this->data);
    }

    /**
     * Update the specified emailtemplate in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $license = LicenseType::findOrFail($id);
        $data = Input::all();

        if ($license->type == 'Cloud') {
            $license->free_users = Input::get('free_users');
        }

        $license->price = Input::get('price');
        $license->status = Input::get('status');
        $license->save();

        $output['status'] = 'success';
        $output['msg'] = trans("messages.updateSuccess");

        return Response::json($output, 200);
    }

    public function update_country(UpdateRequest $request, $id)
    {
        $data = Input::all();

        $data = ['country' => Input::get('country'), 'currency_code' => Input::get('currency_code'),
            'currency_symbol' => Input::get('currency_symbol'), 'price' => Input::get('price')];

        DB::table('license_country_pricing')->where('license_country_pricing.id', $id)->update($data);

        $output['status'] = 'success';
        $output['msg'] = trans("messages.updateSuccess");

        return Response::json($output, 200);
    }


}
