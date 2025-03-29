<?php

namespace App\Http\Controllers\Front;

use App\Classes\Files;
use App\Classes\Reply;
use App\Http\Controllers\FrontBaseController;
use App\Http\Requests\Front\Job\StoreRequest;
use App\Models\Admin;
use App\Models\EmailTemplate;
use App\Models\Job;

use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;


class JobFrontController extends FrontBaseController
{

    public function __construct()
    {

        parent::__construct();
        $this->pageTitle = Lang::get('core.jobTitle');
    }

    public function index()
    {

        $this->jobActive = 'active';
        $this->jobs = Job::where('jobs.status', '=', 'active')->get();
        $this->job_block_color = ['brown', 'light-green', 'dark'];
        $this->job_block_icon = ['bell-o', 'globe', 'thumbs-o-up'];

        return View::make('front.jobs.index', $this->data);
    }

    //	show Job  Page
    public function show($id)
    {
        $this->jobActive = 'active';
        $this->jobs = Job::where('status', '=', 'active')
            ->get();
        $this->job_detail = Job::find($id);
        $this->job_block_color = ['brown', 'light-green', 'dark'];
        $this->job_block_icon = ['bell-o', 'globe', 'thumbs-o-up'];

        return View::make('front.jobs.show', $this->data);
    }

    //	show Job  Page
    public function store(StoreRequest $request)
    {
        $this->jobActive = 'active';
        $this->jobs = Job::where('status', '=', 'active')->get();

        $this->job_block_color = ['brown', 'light-green', 'dark'];
        $this->job_block_icon = ['bell-o', 'globe', 'thumbs-o-up'];

        $data = Input::all();
        if ($request->hasFile('resume')) {
            $file = new Files();
            $filename = $file->upload(Input::file('resume'), 'job_applications', null, null, false);
            $data['resume'] = $filename;
        }

        JobApplication::create($data);



        return Reply::redirect(route('jobs.index'), "messages.successApplyJob");

    }


}
