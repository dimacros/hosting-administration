<?php

namespace App\Mail;

use App\PurchasedDomain;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RenovationDomain extends Mailable
{
    use Queueable, SerializesModels;

    public $purchasedDomain;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PurchasedDomain $purchasedDomain)
    {
        $this->purchasedDomain = $purchasedDomain;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.renew-contract-hosting');
    }
}
