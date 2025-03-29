<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Models\ContactRequest;
use App\Models\EmailTemplate;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

use Yajra\DataTables\Facades\DataTables;

class ContactRequestController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();

        $this->pageTitle = 'Contact Request';
        $this->settingOpen = 'active open';
        $this->contactRequestActive = 'active';

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
        $this->contactDef = ContactRequest::select('id', 'name', 'email', 'category', 'details', 'created_at', 'status')
            ->orderBy('id', 'desc')->take(5)->get();
        $this->total = ContactRequest::count();
        return View::make('admin.contact_requests.index', $this->data);
    }

    // DATA TABLE ajax request
    public function ajax_contact_requests()
    {
        $result = ContactRequest::select('id', 'name', 'email', 'category', 'details', 'created_at', 'status')
            ->get();

        return DataTables::of($result)->editColumn('created_at', function ($row) {
            return date('d-M-Y', strtotime($row->created_at));
        })->editColumn('status', function ($row) {
            $color = ['Pending' => 'warning', 'Completed' => 'success'];

            return "<span id='status{$row->id}' class='label label-{$color[$row->status]}'>{$row->status}</span>";
        })->addColumn('edit', function ($row) {
            if ($row->status == 'Completed') {
                $status = '<a data-container="body" data-placement="top" data-original-title="Pending" href="javascript:;" onclick="changeStatus(' . $row->id . ',\'Pending\');return false;" class="btn yellow btn-sm tooltips"><i class="fa fa-close"></i> Pending</a>';
            } elseif ($row->status == 'Pending') {
                $status = '<a  data-container="body" data-placement="top" data-original-title="Completed" href="javascript:;" onclick="changeStatus(' . $row->id . ',\'Completed\');return false;" class="btn green btn-sm tooltips"><i class="fa fa-check"></i> Completed</a>';
            }

            $string = '<a  class="blue-ebonyclay btn btn-sm "  href="javascript:;" onclick="showView(' . $row->id . ');return false;" ><i class="fa fa-eye"></i> ' . trans('core.btnView') . '</a>';

            return "<p>" . $status . "<p>" . $string;
        })
            ->rawColumns(['status', 'edit'])
            ->make();
    }

    public function change_status()
    {
        //Check employee Company
        $input = Input::all();

        $contact = ContactRequest::findOrFail($input ['id']);
        $contact->status = $input['status'];
        $contact->save();

        $output['status'] = 'success';
        $output['msg'] = trans("messages.updateSuccess");

        return Response::json($output, 200);
    }

    public function show($id)
    {
        //Check employee Company
        $this->request = ContactRequest::find($id);
        $this->color = ['Pending' => 'warning', 'Completed' => 'success'];

        if ($this->request == null) {
            return View::make('admin.errors.noaccess', $this->data);
        }

        return View::make('admin.contact_requests.show', $this->data);
    }

    /**
     * Update the specified emailtemplate in storage.
     *
     * @param  int $id
     * @return Response
     */

}
