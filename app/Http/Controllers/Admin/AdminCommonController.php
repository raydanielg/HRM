<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminBaseController;
use Illuminate\Support\Facades\Response;
use Lang;

class AdminCommonController extends AdminBaseController
{

    private $expense_path = '';
    private $resume = '';
    private $offerLetter = '';
    private $joiningLetter = '';
    private $contract = '';
    private $IDProof = '';
    private $job_applications = '';

    public function __construct()
    {
        parent::__construct();

        $this->expense_path = public_path() . '/uploads/' . $this->folder . '/expense/bills/';
        $this->resume = public_path() . '/uploads/' . $this->folder . '/employee_documents/resume/';
        $this->offerLetter = public_path() . '/uploads/' . $this->folder . '/employee_documents/offerLetter/';
        $this->joiningLetter = public_path() . '/uploads/' . $this->folder . '/employee_documents/joiningLetter/';
        $this->contract = public_path() . '/uploads/' . $this->folder . '/employee_documents/contract/';
        $this->IDProof = public_path() . '/uploads/' . $this->folder . '/employee_documents/IDProof/';
        $this->job_applications = public_path() . '/uploads/' . $this->folder . '/job_applications/';
    }

    public function view_file($type, $filename)
    {
        switch ($type) {
            case 'expense':
                $path_file = $this->expense_path;
                break;
            case 'resume':
                $path_file = $this->resume;
                break;
            case 'offerLetter':
                $path_file = $this->offerLetter;
                break;
            case 'joiningLetter':
                $path_file = $this->joiningLetter;
                break;
            case 'contract':
                $path_file = $this->contract;
                break;
            case 'IDProof':
                $path_file = $this->IDProof;
                break;
            case 'job_applications':
                $path_file = $this->job_applications;
                break;
        }

        $path = $path_file . $filename;

        return Response::make(file_get_contents($path), 200, ['Content-Type' => \File::mimeType($path),
            //$content_types,
            'Content-Disposition' => 'inline; ' . $filename,]);
    }

    public function image_upload()
    {
        $file = \Input::file("file");

        $mime = $file->getMimeType();

        if ($mime == "image/jpeg" || $mime == "image/png" || $mime = "image/gif") {

            $filename = time() . "." . $file->getClientOriginalExtension();

            $file->move(public_path() . "/summernote_images/", $filename);

            return \URL::asset("summernote_images/" . $filename);
        } else {
            \App::abort("500");
        }
    }
}
