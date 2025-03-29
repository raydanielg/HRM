<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Files;
use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Feature\StoreRequest;
use App\Http\Requests\Admin\Feature\UpdateRequest;
use App\Models\Feature;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Input;


class FeaturesController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Features';
        $this->featureOpen = 'active open';
        $this->featureActive = 'active';

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
        return View::make('admin.features.index', $this->data);
    }

    // DATA TABLE ajax request
    public function ajaxFeatures()
    {
        $result = Feature::select('id', 'title', 'description', 'image')
            ->get();

        return DataTables::of($result)
            ->addColumn('edit', function ($row) {
                $string = '<a  class="btn green btn-sm"  href="javascript:;" onclick="showEdit(' . $row->id . ');return false;" ><i class="fa fa-edit"></i> ' . trans('core.edit') . '</a>' .
                    '<a class="btn red btn-sm" href="javascript:;" onclick="del(\'' .
                    $row->id . '\',\'' . addslashes($row->title) .
                    '\')"><i class="fa fa-trash"></i><span class="hidden-sm hidden-xs"> ' .
                    trans("core.btnDelete") . '</span></a>';
                return $string;
            })
            ->editColumn('image', function ($row) {
                return "<img src='" . $row->image_url . "' height='200px'>";
            })
            ->rawColumns(['edit', 'image'])
            ->make();
    }

    public function create()
    {

        return View::make('admin.features.create', $this->data);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->all();

        $file = new Files();
        $filename = $file->upload(Input::file('image'), 'features', null, 400, false);
        $data['image'] = $filename;

        Feature::create($data);

        return Reply::success(trans("messages.updateSuccess"));
    }

    public function edit($id)
    {
        //Check employee Company
        $this->feature = Feature::find($id);

        return View::make('admin.features.edit', $this->data);
    }

    public function update(UpdateRequest $request, $id)
    {

        $data = $request->all();
        $feature = Feature::find($id);


        if ($request->hasFile('image')) {
            $file = new Files();
            $filename = $file->upload(Input::file('image'), 'features', null, 400, false);
            $data['image'] = $filename;
        }
        $feature->update($data);

        return Reply::success(trans("messages.updateSuccess"));
    }

    public function destroy($id)
    {
        Feature::where('id', $id)->delete();

        $output['success'] = 'deleted';

        return Response::json($output, 200);
    }

}
