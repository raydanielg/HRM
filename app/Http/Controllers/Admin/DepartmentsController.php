<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Department\DeleteRequest;
use App\Http\Requests\Admin\Department\EditRequest;
use App\Http\Requests\Admin\Department\StoreRequest;
use App\Http\Requests\Admin\Department\UpdateRequest;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Venturecraft\Revisionable\Revision;

class DepartmentsController extends AdminBaseController
{

    protected $messages = [];

    public function __construct()
    {
        parent::__construct();

        $this->departmentOpen = 'active open';
        $this->peopleMenuActive = 'active';
        $this->pageTitle = trans("pages.departments.indexTitle");
        $this->messages['name.required'] = Lang::get('messages.nameRequired');
        $this->messages['designation.0.required'] = Lang::get('messages.designation0required');
    }

    /**
     * Display a listing of departments
     */
    public function index()
    {

        $this->departments = Department::select('department.id as id', 'name')
            ->company($this->company_id)
            ->manager(admin()->id)
            ->get();
        $this->departmentActive = 'active';
        $employeeCount = [];

        foreach ($this->departments as $dept) {
            $employeeCount[$dept->id] = Employee::join('designation', 'employees.designation', '=', 'designation.id')
                ->join('department', 'designation.department_id', '=', 'department.id')
                ->where('department.id', '=', $dept->id)
                ->where('department.company_id', '=', $this->company_id)
                ->count();
        }

        $this->employeeCount = $employeeCount;

        return View::make('admin.departments.index', $this->data);
    }


    public function create()
    {
        return View::make('admin.departments.create', $this->data);
    }


    /**
     * @param StoreRequest $request
     * @return array
     */
    public function store(StoreRequest $request)
    {

        $input = $request->all();

        $department = Department::create($request->toArray());

        foreach ($input['designation'] as $index => $value) {

            if ($value == '') {
                continue;
            }

            Designation::firstOrCreate([
                'department_id' => $department->id,
                'designation' => $value
            ]);
        }
        return Reply::redirect(route('admin.departments.index'));

    }


    public function edit(EditRequest $request, $id)
    {

        $this->department = Department::find($id);

        return View::make('admin.departments.edit', $this->data);
    }


    /**
     * Update the specified department in storage.
     */
    public function update(UpdateRequest $request, $id)
    {

        $department = Department::findOrFail($id);
        $input = $request->all();

        $department->update($request->toArray());

        foreach ($input['designation'] as $index => $value) {

            if (isset($input['designationID'][$index]) &&
                ($input['designationID'][$index] != null ||
                    $input['designationID'][$index] == '')
            ) {

                if ($value == '' || $value == null) {
                    Designation::destroy($input['designationID'][$index]);
                } else {
                    $design = Designation::find($input['designationID'][$index]);
                    $design->designation = $value;
                    $design->save();
                }

            } else {
                Designation::firstOrCreate(['department_id' => $department->id, 'designation' => $value]);
            }
        }

        return Reply::redirect(route('admin.departments.index'));

    }

    /**
     * @param DeleteRequest $request
     * @param $id
     * @return array
     */
    public function destroy(DeleteRequest $request, $id)
    {

        Department::destroy($id);
        return Reply::redirect(route('admin.departments.index'));

    }

    public function ajax_designation()
    {
        if (Request::ajax()) {
            $input = Input::get('department_id');
            $designation = Designation::where('department_id', '=', $input)
                ->get();

            return Response::json($designation, 200);
        }
    }
}
