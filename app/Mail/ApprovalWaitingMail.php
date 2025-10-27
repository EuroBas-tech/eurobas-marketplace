<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalWaitingMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $massg;
    protected $seller_id;

    public function __construct($seller_id = null)
    {
        $this->seller_id = $seller_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $massg = $this->massg;
        $seller_id = $this->seller_id;
        return $this->subject(sellerTranslate('thank_you_for_registering_with_EuroBas.com'))->view('email-templates.seller-register-notify',['seller_id' => $seller_id]);
    }
}
