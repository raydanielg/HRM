<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Manager\ManagerStoreRequest;
use App\Http\Requests\Admin\Manager\ManagerUpdateRequest;
use App\Http\Requests\Admin\Manager\StoreRequest;
use App\Http\Requests\Admin\Manager\UpdateRequest;
use App\Models\Admin;
use App\Models\Department;
use App\Models\DepartmentManager;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use Yajra\DataTables\Facades\DataTables;

class AdminManagersController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = trans("menu.managers");
        $this->departmentOpen = 'active open';
        $this->peopleMenuActive = 'active';
        $this->managersActive = 'active';
    }

    public function index()
    {


        $this->department = Department::company($this->company_id)->get();
        return View::make('admin.managers.index', $this->data);
    }

    // Datatable ajax request
    public function ajax_managers()
    {
        $result = Admin::managers($this->company_id)
            ->select('admins.id', 'name', 'email')
            ->get();

        return DataTables::of($result)
            ->addColumn('dept', function ($row) {
                $f = Admin::find($row->id);
                $stringDept = '<ul>';
                if (count($row->DepartmentManager) > 0) {
                    foreach ($row->DepartmentManager as $de) {
                        $stringDept .= "<li>" . $de->department->name . "</li>";
                    }
                }
                $stringDept .= '</ul>';

                return $stringDept;
            })
            ->addColumn('edit', function ($row) {
                if ($row->id == admin()->id) {
                    $string = '<a style="width: 75px;" class="btn purple btn-sm margin-bottom-10"  href="javascript:;" onclick="showEdit(' .
                        $row->id . ');return false;" >
										          <i class="fa fa-edit"></i> ' . trans('core.edit') . '</a>';
                } else {
                    $string = '<a style="width: 75px;" class="btn purple btn-sm margin-bottom-10"  href="javascript:;" onclick="showEdit(' .
                        $row->id . ');return false;" ><i class="fa fa-edit"></i> ' .
                        trans('core.edit') . '</a>
			                                         <a style="width: 75px;" href="javascript:;" onclick="del(' .
                        $row->id . ');return false;" class="btn red btn-sm margin-bottom-10">
			                                         <i class="fa fa-trash"></i> ' . trans('core.btnDelete') . '</a>';
                }

                return $string;
            })
            ->rawColumns(['dept', 'edit'])
            ->make();
    }


    /**
     * Store a newly created Admin in storage.
     *
     * @return Response
     */
    public function store(ManagerStoreRequest $request)
    {
        $data = Input::all();

        if (admin()->company->admin_add == 1) {
            $this->admin_name = $data['name'];
            $this->admin_email = $data['email'];
            $this->admin_password = $data['password'];

            //---- NEW ADMIN ADD EMAIL-----

            $emailInfo = ['from_email' => $this->setting->email,
                'from_name' => $this->setting->name, 'to' => $data['email'],
                'active_company' => admin()->company];

            $fieldValues = ['NAME' => $data['name'], 'EMAIL' => $data['email'],
                'PASSWORD' => $data['password'],
                'COMPANY_NAME' => admin()->company->company_name

            ];

            EmailTemplate::prepareAndSendEmail('NEW_ADMIN', $emailInfo, $fieldValues);

            //---- NEW ADMIN ADD EMAIL CLOSE-----
        }

        $data['password'] = Hash::make($data['password']);
        $data['company_id'] = $this->company_id;
        $data['manager'] = 1;

        DB::beginTransaction();
        try {

            $insert = Admin::create($data);
            foreach (Input::get('departments') as $department_id) {
                $department = new DepartmentManager();
                $department->department_id = $department_id;
                $department->manager_id = $insert->id;
                $department->save();
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        DB::commit();
        $output['status'] = 'success';

        return Response::json($output, 200);
    }


    public function edit($id)
    {
        // Check employee Company
        $check = Admin::company($this->company_id)->find($id);

        if ($check == null) {
            return View::make('admin.errors.noaccess', $this->data);
        }

        $admin = Admin::find($id);
        $department = Department::company($this->company_id)->get();
        return View::make('admin.managers.edit', compact('admin', 'department'));
    }


    public function update(ManagerUpdateRequest $request, $id)
    {
        //Check employee Company
        $check = Admin::company($this->company_id)->find($id);

        if ($check == null) {
            return View::make('admin.errors.noaccess', $this->data);
        }

        $admin = Admin::findOrFail($id);
        $data = Input::all();

        $admin->name = $data['name'];
        $admin->email = $data['email'];

        if ($data['password'] != '') {
            $admin->password = Hash::make($data['password']);
        }

        $admin->save();
        DB::beginTransaction();
        try {
            //$dept = DepartmentManager::whereIn('department_id',Input::get('departments'))->get();
            DepartmentManager::where('manager_id', '=', $id)->delete();
            foreach (Input::get('departments') as $department_id) {
                $department = new DepartmentManager();
                $department->manager_id = $id;
                $department->department_id = $department_id;
                $department->save();
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();

        return [
            'status' => 'success'
        ];
    }


    public function destroy($id)
    {
        // Check employee Company
        $check = Admin::company($this->company_id)->find($id);

        if ($check == null) {
            return View::make('admin.errors.noaccess', $this->data);
        }

        Admin::destroy($id);

        $output['success'] = 'deleted';

        return Response::json($output, 200);
    }

}
