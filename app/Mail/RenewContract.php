<?php

namespace App\Mail;

use Carbon\Carbon;
use App\HostingContract;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RenewContract extends Mailable
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
      $pdfDocument = 'Recordatorio_'.Carbon::today()->format('d-m-Y').'.pdf';
      return $this->from('ventas@jypsac.com', 'Grupo JYP S.A.C')->subject('Recordatorio para la renovación de Hosting')->view('emails.renew-contract')->with('hostingContract', $this->hostingContract)->attachData($this->hostingContract->toPDF()->output(), $pdfDocument, ['mime' => 'application/pdf']);
    }
}
