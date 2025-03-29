<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\ProfileSetting\UpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;


class ProfileSettingsController extends AdminBaseController
{


    public function __construct()
    {
        parent::__construct();
        $this->settingOpen = 'active';
        $this->pageTitle = 'Settings';
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function edit()
    {

        $this->csettingOpen = 'active';
        $this->profileSettingActive = 'active';
        $this->admin = \admin();
        return View::make('admin.profile_settings.edit', $this->data);
    }

    /**
     * @param UpdateRequest $request
     * @return array
     */
    public function update(UpdateRequest $request)
    {
        $admin = \admin();
        $data = $request->all();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $admin->update($data);

        return Reply::success('messages.updateSuccess');
    }


}
