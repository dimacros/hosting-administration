<?php

namespace App\Jobs;

use App\{PurchasedDomain, HostingContract};
use App\Notifications\ContractRenewal;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendingEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function renewContract() {
      $hostingContracts = HostingContract::whereIn('status', ['active','suspended'])->with('customer:id,first_name,last_name,company_name')->get(); 

      if ($hostingContracts->isNotEmpty() ) {
        foreach ($hostingContracts as $hostingContract) { 

          if ( in_array($hostingContract->days_to_expire, [3, 7, 15, 30]) ) {
            $hostingContract->sendRenewalNotification();
            $hostingContract->notifications_sent += 1;
            $hostingContract->save();
          }
          
          if ( $hostingContract->days_to_expire === -1 ) {
            $hostingContract->status = 'finished';
            $hostingContract->save();
          }

        }
      }     
    }

    public function renewDomain() {
      $purchasedDomains = PurchasedDomain::whereIn('status', ['active','suspended'])->with(['domainProvider:id,company_name','customer:id,first_name,last_name,company_name'])->get();  

      if ( $purchasedDomains->isNotEmpty() )
      {
        foreach ($purchasedDomains as $purchasedDomain)
        { 
          if ( in_array($purchasedDomain->days_to_expire, [3, 7, 15, 30]) ) {
            $purchasedDomain->sendRenewalNotification();
          }
          
          if ( $purchasedDomain->days_to_expire === -1 ) {
            $purchasedDomain->status = 'finished';
            $purchasedDomain->save();
          }
        }
      }
    }   
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() 
    {
      $this->renewContract();
      $this->renewDomain();
    }
}
