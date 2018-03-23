<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Support\Facades\Auth;
use App\Customer;
use App\HostingContract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HostingContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexForCustomer()
    {
      $customer = Customer::where('user_id', Auth::id())->first();
      $hostingContracts = HostingContract::with([
        'customer:id,first_name,last_name,company_name', 'cpanelAccount',
        'hostingPlanContracted:id,title'])->where('customer_id', $customer->id)->paginate(15);
      return view('customer.hosting-contracts', ['hostingContracts' => $hostingContracts]);
    }
}
