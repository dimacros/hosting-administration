<?php

namespace App\Mail;

use App\PurchasedDomain;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DomainRenewal extends Mailable
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
        return $this->from('ventas@jypsac.com', 'Grupo JYP S.A.C')
                    ->subject('Recordatorio para renovar el dominio')
                    ->view('emails.domain-renewal');
    }
}
