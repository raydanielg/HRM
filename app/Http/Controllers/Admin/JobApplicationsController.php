<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\JobApplication\StoreRequest;
use App\Http\Requests\Admin\JobApplication\UpdateRequest;
use App\Http\Requests\Admin\JobApplication\ShowRequest;
use App\Http\Requests\Admin\JobApplication\DeleteRequest;
use App\Models\Employee;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

use Yajra\DataTables\Facades\DataTables;

class JobApplicationsController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = trans('core.jobApplications');
        $this->jobsOpen = 'active';
        $this->jobsApplicationActive = 'active';
    }

    public function index()
    {
        return View::make('admin.job_applications.index', $this->data);
    }

    public function ajax_jobs_applications()
    {
        $result = JobApplication::join('jobs', 'jobs.id', '=', 'job_applications.job_id')
            ->join('employees', 'employees.id', '=', 'job_applications.submitted_by')
            ->manager(admin()->id)
            ->select('job_applications.id', 'jobs.position', 'job_applications.name', 'job_applications.email', 'job_applications.phone', 'job_applications.created_at', 'full_name', 'job_applications.status','job_applications.submitted_by')
            ->get();

        return DataTables::of($result)->editColumn('status', function ($row) {
            $color = ['selected' => 'success', 'rejected' => 'danger', 'pending' => 'warning'];

            $string = "<span  id='status{$row->id}' class='margin-bottom-5 label label-{$color[$row->status]}'>" . trans('core.' . ($row->status)) . "</span>";

            return $string;
        })->addColumn('edit', function ($row) {
            $string = '';
            $display_accept = '';
            $display_reject = '';

            if ($row->status == 'rejected') {
                $display_reject = 'style="display:none"';
            } elseif ($row->status == 'selected') {
                $display_accept = 'style="display:none"';
            }
            $accept = '<a ' . $display_accept . ' id="accept' . $row->id . '"  data-container="body" data-placement="top" data-original-title="Approve" href="javascript:;" onclick="changeStatus(' . $row->id . ',\'selected\');return false;" class="btn green btn-sm tooltips margin-bottom-10"><i class="fa fa-check"></i></a>';
            $reject = '<a ' . $display_reject . ' id="reject' . $row->id . '" data-placement="top" data-original-title="Reject"  href="javascript:;" onclick="changeStatus(' . $row->id . ',\'rejected\');return false;" class="btn red btn-sm tooltips margin-bottom-10"><i class="fa fa-close"></i></a>';

            $string .= '' . $accept . $reject . '';

            $string .= '
						 			<a  class="btn blue-ebonyclay btn-sm margin-bottom-5"  href="javascript:;" onclick="showView(' . $row->id . ');return false;" ><i class="fa fa-eye"></i> ' . trans('core.btnView') . '</a>
	                  	 			<a   href="javascript:;" onclick="del(' . $row->id . ');return false;" class="btn red btn-sm margin-bottom-5">
                        			<i class="fa fa-trash"></i> ' . trans('core.btnDelete') . '</a>';

            return $string;
        })->editColumn('full_name', function ($row) {
            $employee = Employee::find($row->submitted_by);
            return $employee->decryptToCollection()->full_name;
        })
            ->rawColumns(['edit', 'status'])
            ->make();
    }

    public function change_status()
    {
        $job_application = JobApplication::findOrFail(request()->id);
        $job_application->status = request()->status;
        $job_application->save();


        return Reply::success('messages.updateSuccess');
    }

    public function create()
    {
        return View::make('admin.job_applications.create');
    }

    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $data = Input::all();

        JobApplication::create($data);

        return Redirect::route('admin.job_applications.index');
    }


    public function show(ShowRequest $request, $id)
    {

        $this->job_application = JobApplication::findOrFail($id);
        $this->color = ['selected' => 'success', 'rejected' => 'danger', 'pending' => 'warning'];

        return View::make('admin.job_applications.show', $this->data);
    }

    public function getDownload($resume)
    {

        $file = public_path() . "/uploads/" . $this->folder . "/job_applications/" . $resume;

        return Response::download($file);
    }

    public function edit($id)
    {
        $check = JobApplication::find($id);
        if ($check == null) {
            return View::make('admin.errors.noaccess', $this->data);
        }
        $jobapplication = JobApplication::find($id);

        return View::make('admin.job_applications.edit', compact('jobapplication'));
    }

    /**
     * Update the specified JobApplication in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $check = JobApplication::find($id);

        if ($check == null) {
            return View::make('admin.errors.noaccess', $this->data);
        }

        $jobapplication = JobApplication::findOrFail($id);
        $data = Input::all();

        $jobapplication->update($data);

        return Redirect::route('admin.job_applications.index');
    }

    /**
     * Remove the specified jobapplication from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(DeleteRequest $request,$id)
    {

        JobApplication::destroy($id);
        return Reply::success('messages.jobDeleteMessage');
    }

}
