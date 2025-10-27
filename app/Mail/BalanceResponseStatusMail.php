<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BalanceResponseStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $seller_id;

    public function __construct($seller_id)
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
        $seller_id = $this->seller_id;
        return $this->subject(sellerTranslate('balance_response_status_notify_seller'))->view('email-templates.balance-response-notify-seller',['id'=>$seller_id]);
    }
}
