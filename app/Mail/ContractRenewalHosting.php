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
        $pdf_document  = 'Recordatorio_'.$this->hostingContract->id.'_';
        $pdf_document .= $this->hostingContract->expiration_date_for_humans.'_días.pdf';
        return $this->from('ventas@jypsac.com', 'Grupo JYP S.A.C')
                    ->subject('Recordatorio para la renovación de Hosting')
                    ->view('emails.zurb1')
                    ->with('hostingContract', $this->hostingContract)
                    ->attachData($this->hostingContract->pdf->output(), $pdf_document,
                        ['mime' => 'application/pdf']
                    );
    }
}
