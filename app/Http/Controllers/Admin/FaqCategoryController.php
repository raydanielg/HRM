<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\FaqCategory\StoreRequest;
use App\Http\Requests\Admin\FaqCategory\UpdateRequest;
use App\Models\FaqCategory;
use App\Models\Plan;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Input;


class FaqCategoryController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'FAQ Category';
        $this->faqCategoryOpen = 'active open';
        $this->faqCategoryActive = 'active';

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

        return View::make('admin.faq_category.index', $this->data);
    }

    // DATA TABLE ajax request
    public function ajaxFaqCategories()
    {
        $result = FaqCategory::select('id', 'name', 'status')
            ->orderBy('created_at', 'desc')
            ->get();

        return DataTables::of($result)
            ->editColumn('status', function ($row) {
            $color = ['inactive' => 'danger', 'active' => 'success'];
            $text = ['inactive' => 'Inactive', 'active' => 'Active'];

            return "<span id='status{$row->id}' class='label label-{$color[$row->status]}'>{$text[$row->status]}</span>";

        })->addColumn('edit', function ($row) {
            $string = '<a  class="btn green btn-sm"  href="javascript:;" onclick="showEdit(' . $row->id . ');return false;" ><i class="fa fa-edit"></i> ' . trans('core.edit') . '</a>' .
                '<a class="btn red btn-sm margin-bottom-5" href="javascript:;" onclick="del(\'' .
                    $row->id . '\',\'' . addslashes($row->name) .
                    '\')"><i class="fa fa-trash"></i><span class="hidden-sm hidden-xs"> ' .
                    trans("core.btnDelete") . '</span></a>';

            return $string;
        })
        ->rawColumns(['status', 'edit'])
        ->make();
    }

    public function create()
    {
        $this->faqCategory = new FaqCategory();
        $this->faqCategory->status = 'active';

        return View::make('admin.faq_category.create', $this->data);
    }

    public function store(StoreRequest $request)
    {
        $faqCategory = new FaqCategory();

        $faqCategory->name = $request->name;
        $faqCategory->status = $request->status;
        $faqCategory->save();

        $output['msg'] = trans("messages.updateSuccess");

        return Reply::success(trans("messages.updateSuccess"));
    }

    public function edit($id)
    {
        //Check employee Company
        $this->faqCategory = FaqCategory::find($id);

        return View::make('admin.faq_category.edit', $this->data);
    }

    public function update(UpdateRequest $request, $id)
    {
        $faqCategory = FaqCategory::find($id);

        $faqCategory->name = $request->name;
        $faqCategory->status = $request->status;
        $faqCategory->save();

        $output['msg'] = trans("messages.updateSuccess");

        return Reply::success(trans("messages.updateSuccess"));
    }

    public function destroy($id)
    {
        FaqCategory::where('id', $id)
            ->delete();

        $output['success'] = 'deleted';

        return Response::json($output, 200);
    }

}
