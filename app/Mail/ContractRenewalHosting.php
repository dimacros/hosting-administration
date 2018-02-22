<?php

namespace App\Mail;

use App\HostingContract;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContractRenewalHosting extends Mailable
{
    use Queueable, SerializesModels;

    protected $hostingContract;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(HostingContract $hostingContract)
    {
        $this->hostingContract = $hostingContract; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $code = 'Recordatorio_'.str_pad($this->hostingContract->id, 5, "0", STR_PAD_LEFT);
        $days = $this->hostingContract->expiration_date_for_humans.'_días';
        return $this->from('ventas@jypsac.com', 'Grupo JYP S.A.C')
                    ->subject('Recordatorio para la renovación de Hosting')
                    ->view('emails.zurb1')
                    ->with('hostingContract', $this->hostingContract)
                    ->attachData($this->hostingContract->pdf->output(), $code.'_'.$days.'.pdf',
                        ['mime' => 'application/pdf']
                    );
    }
}
