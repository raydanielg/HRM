<?php

namespace App\Mail;

use App\Models\Setting;
use App\Traits\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestEmailSent extends BaseMail
{
    public $setting;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setting = Setting::first();
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Test Email')
            ->with(['logo_image_url' => $this->setting->logo_image_url])
            ->view('emails.site.test_email');
    }
}
