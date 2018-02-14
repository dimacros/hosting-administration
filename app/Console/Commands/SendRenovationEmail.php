<?php

namespace App\Console\Commands;

use App\{PurchasedDomain};
use App\Mail\RenovationDomain;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;

class SendRenovationEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:renovation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar correo electrónico para la renovación de contrato.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $purchasedDomains = PurchasedDomain::with('domainProvider:id,company_name')->get();
      $sendInDays = [3,7,9,12,15,30];
      foreach ($purchasedDomains as $purchasedDomain):
       if ( in_array($purchasedDomain->expiration_date_for_humans, $sendInDays) ) {
          Mail::to('programador@dimacros.net')->send(new RenovationDomain($purchasedDomain));
          $this->info('¡Correo electrónico enviado exitosamente!');
       }
       elseif ($purchasedDomain->expiration_date_for_humans < 0) {

       }

      endforeach;

       
    }
}
