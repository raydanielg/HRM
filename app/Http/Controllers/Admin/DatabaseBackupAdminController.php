<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;

use App\Models\DatabaseBackup;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

use Yajra\DataTables\Facades\DataTables;


class DatabaseBackupAdminController extends AdminBaseController
{


    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'BackUp';
        $this->settingOpen = 'active open';
        $this->backUpActive = 'active';

        $this->middleware(function ($request, $next) {
            if (admin()->type != 'superadmin') {
                echo View::make('admin.errors.noaccess', $this->data);
                die();
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of users
     *
     * @return Response
     */
    public function index()
    {
        // Site Settings

        return View::make('admin.database_backups.index', $this->data);

    }

    public function ajax_database_backups()
    {
        $backups = DatabaseBackup::select('id', 'filename', 'created_at')
            ->latest('created_at')->get();

        return DataTables::of($backups)
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->addColumn('Action', function ($row) {

                return '<a class="btn btn-sm btn-success" href="' . URL::route('admin.download_backup', [$row->id]) . '"><span class="fa fa-download"></span> Download</a> <a class="btn btn-sm btn-danger" onclick="deleteBackup(' . $row->id . ')"><span class="fa fa-trash"></span> Delete</a>';

            })
            ->make();
    }


    public function store()
    {

        Artisan::call('backup:run');
        sleep(2);
        #Read the folder and get the file name of latest created backup
        $files = \File::allFiles(storage_path() . '/app/backups/');
        $filename = $files[count($files) - 1]->getfilename();

        $databaseBackup = new DatabaseBackup();
        $databaseBackup->filename = $filename;
        $databaseBackup->save();

        return [
            "status" => "success",
            "toastrHeading" => Lang::get("messages.success"),
            "toastrMessage" => Lang::get("messages.backupTaken"),
            "action" => "showToastr"
        ];
    }

    public function download_backup($id)
    {

        $databaseBackup = DatabaseBackup::find($id);
        $file = storage_path() . '/app/backups/' . $databaseBackup->filename;
        return Response::download($file);

    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {


        $databaseBackup = DatabaseBackup::find($id);
        \File::delete(storage_path() . '/app/backups/' . $databaseBackup->filename);
        $databaseBackup->delete();

        return [
            "status" => "success",
            "toastrHeading" => Lang::get("messages.success"),
            "toastrMessage" => Lang::get("messages.backupDeleted"),
            "action" => "showToastr"
        ];
    }

}
