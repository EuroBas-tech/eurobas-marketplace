<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalSellerMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
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
        $seller_id = $this->seller_id;
        return $this->subject(sellerTranslate('welcome_to_EuroBas_Your_seller_account_is_approved'))->view('email-templates.seller-approved-notify',['seller_id' => $seller_id]);
    }
}
