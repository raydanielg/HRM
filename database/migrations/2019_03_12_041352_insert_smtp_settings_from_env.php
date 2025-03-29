<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertSmtpSettingsFromEnv extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('APP_ENV') !== 'demo') {
            $settings = \App\Models\Setting::first();
            if($settings){
                $settings->mail_driver = env('MAIL_DRIVER');
                $settings->mail_host = env('MAIL_HOST');
                $settings->mail_port = env('MAIL_PORT');
                $settings->mail_username = env('MAIL_USERNAME');
                $settings->mail_password = env('MAIL_PASSWORD');
                $settings->mail_encryption = env('MAIL_ENCRYPTION');
                $settings->save();
            }

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
