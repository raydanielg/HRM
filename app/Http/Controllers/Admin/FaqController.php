<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Faq\StoreRequest;
use App\Http\Requests\Admin\Faq\UpdateRequest;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Plan;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Input;


class FaqController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'FAQ';
        $this->faqOpen = 'active open';
        $this->faqActive = 'active';
        $this->faqCategories = FaqCategory::all();

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

        return View::make('admin.faq.index', $this->data);
    }

    // DATA TABLE ajax request
    public function ajaxFaqs()
    {
        $result = Faq::select('faq.id', 'faq_category.name as name', 'title', 'content_text')
            ->join('faq_category', 'faq_category.id', '=', 'faq.faq_category_id')
            ->orderBy('faq.created_at', 'desc')
            ->get();

        return DataTables::of($result)
            ->addColumn('edit', function ($row) {
            $string = '<a  class="btn green btn-sm"  href="javascript:;" onclick="showEdit(' . $row->id . ');return false;" ><i class="fa fa-edit"></i> ' . trans('core.edit') . '</a>'.
                '<a class="btn red btn-sm" href="javascript:;" onclick="del(\'' .
                $row->id . '\',\'' . addslashes($row->title) .
                '\')"><i class="fa fa-trash"></i><span class="hidden-sm hidden-xs"> ' .
                trans("core.btnDelete") . '</span></a>';
            return $string;
        })
        ->rawColumns(['edit'])
        ->make();
    }

    public function create()
    {
        $this->faq = new Faq();

        return View::make('admin.faq.create', $this->data);
    }

    public function store(StoreRequest $request)
    {
        $faq = new Faq();

        $faq->title = $request->title;
        $faq->content_text = $request->content_text;
        $faq->faq_category_id = $request->faq_category_id;
        $faq->save();

        $output['msg'] = trans("messages.updateSuccess");

        return Reply::success(trans("messages.updateSuccess"));
    }

    public function edit($id)
    {
        //Check employee Company
        $this->faq = Faq::find($id);

        return View::make('admin.faq.edit', $this->data);
    }

    public function update(UpdateRequest $request, $id)
    {
        $faq = Faq::find($id);

        $faq->title = $request->title;
        $faq->content_text = $request->content_text;
        $faq->faq_category_id = $request->faq_category_id;
        $faq->save();

        $output['msg'] = trans("messages.updateSuccess");

        return Reply::success(trans("messages.updateSuccess"));
    }

    public function destroy($id)
    {
        Faq::where('id', $id)
            ->delete();

        $output['success'] = 'deleted';

        return Response::json($output, 200);
    }

}
