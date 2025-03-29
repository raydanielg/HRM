<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\LeaveType\DeleteRequest;
use App\Http\Requests\Admin\LeaveType\StoreRequest;
use App\Http\Requests\Admin\LeaveType\UpdateRequest;
use App\Models\Leavetype;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class LeavetypesController
 * @package App\Http\Controllers\Admin
 */
class LeavetypesController extends AdminBaseController
{


    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'LeaveType';
        $this->attendanceOpen = 'active';
        $this->leaveTypeActive = 'active';
        $this->pageTitle = trans('pages.awards.indexTitle');

    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->leaveTypes = Leavetype::all();
        return View::make('admin.leavetypes.index', $this->data);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function ajaxLeaveType()
    {
        $result = Leavetype::select('id', 'leaveType', 'num_of_leave');

        return DataTables::of($result)
            ->addColumn('edit', function ($row) {
                return '<a  class="btn purple btn-sm margin-bottom-10"  onclick="showEdit(' . $row->id . ',\'' . $row->leaveType . '\',\'' . $row->num_of_leave . '\')"><i class="fa fa-edit"></i> <span class="hidden-sm hidden-xs">' . trans("core.btnViewEdit") . '</span></a>
                          <a href="javascript:;" onclick="del(' . $row->id . ',\'' . $row->leaveType . '\')" class="btn red btn-sm margin-bottom-10">
                        <i class="fa fa-trash"></i> <span class="hidden-sm hidden-xs">' . trans("core.btnDelete") . '</span></a>';
            })
            ->removeColumn('id')
            ->rawColumns(['edit'])
            ->escapeColumns(['edit'])
            ->make(true);
    }

    /**
     * @param CreateRequest $request
     * @return array
     */
    public function store(StoreRequest $request)
    {
        Leavetype::create($request->toArray());

        return Reply::success('Leave Type added successfully');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $this->leavetype = Leavetype::find($id);
        return View::make('admin.leavetypes.edit', $this->data);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('admin.leavetypes.create');
    }

    /**
     * @param UpdateRequest $request
     * @param $id
     * @return array
     */
    public function update(UpdateRequest $request, $id)
    {
        $leavetype = Leavetype::findOrFail($id);
        $leavetype->update($request->toArray());
        return Reply::success('Leavetype updated successfully');
    }

    /**
     * @param DeleteRequest $request
     * @param $id
     * @return array
     */
    public function destroy(DeleteRequest $request, $id)
    {
        Leavetype::destroy($id);

        return Reply::success('messages.leaveTypeDeleteMessage');


    }

}
