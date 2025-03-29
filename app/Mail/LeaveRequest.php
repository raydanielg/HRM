<?php

namespace App\Mail;

class LeaveRequest extends BaseMail
{
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        parent::__construct();
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
            ->replyTo($this->data['replyTo'])
            ->subject('Leave Request - ' . $this->data['active_company']->company_name)
            ->view('emails.front.leave_request')
            ->with($this->data);
    }
}
