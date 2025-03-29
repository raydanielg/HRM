<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Noticeboard\EditRequest;
use App\Http\Requests\Admin\Noticeboard\StoreRequest;
use App\Http\Requests\Admin\Noticeboard\UpdateRequest;
use App\Models\Noticeboard;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class NoticeboardsController
 * @package App\Http\Controllers\Admin
 */
class NoticeboardsController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Notice Board';
        $this->noticeBoardOpen = 'active open';
        $this->noticeBoardActive = 'active';
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->noticeboards = Noticeboard::orderBy('created_at', 'DESC')->get();
        return View::make('admin.noticeboards.index', $this->data);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View::make('admin.noticeboards.create', $this->data);
    }

    /**
     * @param CreateRequest $request
     * @return array
     */
    public function store(StoreRequest $request)
    {

        Noticeboard::create($request->toArray());

        return Reply::redirect(route('admin.noticeboards.index'));

    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function ajax_notices()
    {
        $result = Noticeboard::select('id', 'title', 'description', 'status', 'created_at')
            ->orderBy('created_at', 'desc');

        return DataTables::of($result)
            ->editColumn('created_at', function ($row) {
                return date('d-M-Y', strtotime($row->created_at));
            })
            ->editColumn('status', function ($row) {
                $color = [
                    'active' => 'success',
                    'inactive' => 'danger'
                ];
                return '<span class="label label-' . $color[$row->status] . '">' . $row->status . '</span>';
            })->addColumn('edit', function ($row) {
                return '<a  class="btn purple btn-sm margin-bottom-10"  onclick="loadView(\'' . route("admin.noticeboards.edit", $row->id) . '\');"><i class="fa fa-edit"></i> <span class="hidden-sm hidden-xs">' . trans("core.btnViewEdit") . '</span></a>
                          <a href="javascript:;" onclick="del(\'' . $row->id . '\');return false;" class="btn red btn-sm margin-bottom-10">
                        <i class="fa fa-trash"></i> <span class="hidden-sm hidden-xs">' . trans("core.btnDelete") . '</span></a>';
            })
            ->escapeColumns(['edit', 'status'])
            ->rawColumns(['status', 'edit'])
            ->make(true);
    }

    /**
     * @param EditRequest $request
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(EditRequest $request,$id)
    {
        $this->notice = Noticeboard::find($id);

        return View::make('admin.noticeboards.edit', $this->data);
    }


    public function update(UpdateRequest $request, $id)
    {
        $noticeBoard = Noticeboard::findOrFail($id);
        $noticeBoard->update($request->toArray());

        return Reply::success('Updated successfully');
    }

    /**
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        Noticeboard::destroy($id);
        return Reply::success('Deleted successfully');
    }

}
