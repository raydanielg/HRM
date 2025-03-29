<?php

namespace App\Mail;

use App\Traits\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BaseMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, Settings;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(env('APP_ENV') === 'codecanyon') {
            $this->setMailConfigs();
        }
    }


}
