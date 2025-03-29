<?php

namespace App\Mail;

use App\Models\Setting;
use App\Traits\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SupportSent extends BaseMail
{
    public $data;
    public $setting;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        parent::__construct();
        $this->setting = Setting::first();
        $this->data = $data;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New contact request received.')
            ->with(['logo_image_url' => $this->setting->logo_image_url])
            ->view('emails.site.support_sent')
            ->with($this->data);
    }
}
