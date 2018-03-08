<?php

namespace App\Console\Commands;

use App\{PurchasedDomain, HostingContract};
use Illuminate\Console\Command;

class SendRenewalEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:renewal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar correo electrónico para renovar hosting, dominio o producto comprado.';
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
      $purchasedDomains = PurchasedDomain::whereIn('status', ['active','suspended'])->with([
        'acquiredDomain:id,domain_name', 'domainProvider:id,company_name',
        'customer:id,first_name,last_name,company_name'
      ])->get();  

      $hostingContracts = HostingContract::whereIn('status', ['active','suspended'])->with('customer:id,first_name,last_name,company_name')->get();

      if ( $purchasedDomains->isNotEmpty() )
      {
        foreach ($purchasedDomains as $purchasedDomain)
        { 
          if ( $purchasedDomain->isDayToSendRenewalEmail() ) {
            $purchasedDomain->sendRenewalEmail();
            $this->info('¡Correo electrónico enviado exitosamente!');
          }
          elseif ( $purchasedDomain->isExpired() ) {
            $purchasedDomain->status = 'finished';
            $purchasedDomain->save();
            $this->info('El dominio comprado ha expirado.');
          }
        }
      }

      if ( $hostingContracts->isNotEmpty() )
      {
        foreach ($hostingContracts as $hostingContract)
        { 
          if ( $hostingContract->isDayToSendRenewalEmail() ) {
            $hostingContract->sendRenewalEmail();
            $this->info('¡Correo electrónico enviado exitosamente!');
          }
          elseif ( $hostingContract->isExpired() ) {
            $hostingContract->status = 'finished';
            $hostingContract->save();
            $this->info('El contrato hosting ha vencido.');
          }
        }
      }
    }
}
