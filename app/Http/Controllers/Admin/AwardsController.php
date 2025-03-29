<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Award\DeleteRequest;
use App\Http\Requests\Admin\Award\EditRequest;
use App\Http\Requests\Admin\Award\StoreRequest;
use App\Http\Requests\Admin\Award\UpdateRequest;
use App\Models\Award;

use App\Models\Employee;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class AwardsController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->awardsOpen = 'active';
        $this->awardsActive = 'active';
        $this->hrMenuActive = 'active';
        $this->addAwardsActive = 'active';
        $this->pageTitle = trans('pages.awards.indexTitle');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {

        $this->awardsActive = 'active';
        return View::make('admin.awards.index', $this->data);
    }


    /**
     * @return mixed
     * @throws \Exception
     */
    public function ajax_awards()
    {
        $result = Award::select('awards.id', 'awards.employee_id', 'full_name', 'award_name', 'gift', 'month', 'awards.year', 'awards.created_at')
            ->join('employees', 'awards.employee_id', '=', 'employees.id')
            ->get();

        return DataTables::of($result)->addColumn('For Month', function ($row) {
            return ucfirst($row->month) . ' ' . $row->year;
        })->addColumn('edit', function ($row) {
            return '<a  class="btn purple btn-sm margin-bottom-10"  onclick="loadView(\'' . route("admin.awards.edit", $row->id) . '\');"><i class="fa fa-edit"></i> <span class="hidden-sm hidden-xs">' . trans("core.btnViewEdit") . '</span></a>
                          <a href="javascript:;" onclick="del(\'' . $row->id . '\',\'' . $row->award_name . '\');return false;" class="btn red btn-sm margin-bottom-10">
                        <i class="fa fa-trash"></i> <span class="hidden-sm hidden-xs">' . trans("core.btnDelete") . '</span></a>';
        })->editColumn('full_name', function ($row) {
            $employee = Employee::find($row->employee_id);
            return $employee->decryptToCollection()->full_name;
        })->removeColumn('year')
            ->removeColumn('eid')
            ->rawColumns(['For Month', 'edit'])
            ->make();
    }

    public function create()
    {
        $this->pageTitle = trans('pages.awards.createTitle');
        $this->addAwardsActive = 'active';
        $this->employees = Employee::manager()
            ->select('full_name', 'employees.id','employeeID')
            ->where('status', '=', 'active')->get();

        return View::make('admin.awards.create', $this->data);
    }

    /**
     * @param StoreRequest $request
     * @return mixed
     */
    public function store(StoreRequest $request)
    {

        Award::create($request->toArray());
        return Reply::redirect(route('admin.awards.index'), "messages.awardAddMessage");
    }


    /**
     * @param EditRequest $request
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(EditRequest $request, $id)
    {
        $this->pageTitle = trans('pages.awards.editTitle');

        $this->award = Award::find($id);

        $this->employees = Employee::manager()
            ->select('full_name', 'employees.id','employeeID')
            ->where('status', '=', 'active')->get();


        return View::make('admin.awards.edit', $this->data);
    }

    /**
     * @param UpdateRequest $request
     * @param $id
     * @return array|\Illuminate\Contracts\View\View
     */
    public function update(UpdateRequest $request, $id)
    {
        $award = Award::findOrFail($id);
        $award->update($request->toArray());

        return Reply::success("messages.updateSuccess");
    }

    /**
     * @param DeleteRequest $request
     * @param $id
     * @return array
     */
    public function destroy(DeleteRequest $request, $id)
    {
        Award::destroy($id);
        return Reply::success("messages.awardDeleteMessage");
    }

}
