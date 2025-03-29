<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Update\StoreRequest;
use App\Http\Requests\Admin\Update\UpdateRequest;
use App\Models\Update;


class AdminUpdatesController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = trans("pages.updates.indexTitle");
        $this->updatesActive = "active";
    }

    public function index()
    {
        if (admin()->type == "superadmin") {
            $this->data["updates"] = Update::orderBy("created_at", "desc")->paginate(10);
        } else {
            $this->data["updates"] = Update::leftJoin("updates_read", function ($query) {
                $query->on("updates_read.update_id", "=", "updates.id");
                $query->on("admin_id", "=", \DB::raw(admin()->id));

            })
                ->where("status", "Published")
                ->orderBy("created_at", "desc")
                ->paginate(10);
        }

        return view("admin.updates.index", $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->pageTitle = trans("pages.updates.createTitle");
        if (admin()->type != 'superadmin') {
            \App::abort("404");
        }

        return view("admin.updates.create", $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if (admin()->type != 'superadmin') {
            \App::abort("404");
        }

        $data = \Input::all();

        $update = new Update();
        $update->title = $data["title"];
        $update->excerpt = $data["excerpt"];
        $update->description = $data["description"];
        $update->status = $data["status"];
        $update->save();

        return ["status" => "success"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            // Mark this post as read
            \DB::table("updates_read")->insert(["admin_id" => admin()->id,
                "update_id" => $id]);
        } catch (\Exception $e) {
        }

        $this->data["update"] = Update::findOrFail($id);
        $this->pageTitle = $this->data["update"]->title;

        return view("admin.updates.show", $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (admin()->type != 'superadmin') {
            \App::abort("404");
        }

        $this->data["update"] = Update::findOrFail($id);
        $this->pageTitle = trans("pages.updates.editTitle");

        return view("admin.updates.edit", $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        if (admin()->type != 'superadmin') {
            \App::abort("404");
        }

        $data = \Input::all();

        $update = Update::findOrFail($id);
        $update->title = $data["title"];
        $update->excerpt = $data["excerpt"];
        $update->description = $data["description"];
        $update->status = $data["status"];
        $update->save();

        return ["status" => "success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (admin()->type != 'superadmin') {
            \App::abort("404");
        }

        $update = Update::findOrFail($id);
        $update->delete();

        return ["status" => "success"];
    }

}
