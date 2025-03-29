<?php
/**
 * Created by PhpStorm.
 * User: DEXTER
 * Date: 24/05/17
 * Time: 11:29 PM
 */

namespace App\Traits;

use App\Models\Setting;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Support\Facades\Config;

trait Settings{

    public function setStripeConfigs(){
        $settings = Setting::first();

        Config::set('services.stripe.key', $settings->stripe_key);
        Config::set('services.stripe.secret', $settings->stripe_secret);
        Config::set('services.stripe.webhook_secret', $settings->stripe_webhook_secret);

    }

    public function setMailConfigs(){
        $smtpSetting = Setting::first();

        Config::set('mail.driver', $smtpSetting->mail_driver);
        Config::set('mail.host', $smtpSetting->mail_host);
        Config::set('mail.port', $smtpSetting->mail_port);
        Config::set('mail.username', $smtpSetting->mail_username);
        Config::set('mail.password', $smtpSetting->mail_password);
        Config::set('mail.encryption', $smtpSetting->mail_encryption);
        Config::set('app.url', url('/') );
        Config::set('app.name', $smtpSetting->main_name);

        (new MailServiceProvider(app()))->register();
    }

}
