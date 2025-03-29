<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompanySignedUp extends BaseMail
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
        return $this->from($this->data['fromEmail'], $this->data['fromName'])
            ->subject('Account created')
            ->view('emails.site.company_signed_up')
            ->with(['logo_image_url' => $this->setting->logo_image_url])
            ->with($this->data);
    }
}
