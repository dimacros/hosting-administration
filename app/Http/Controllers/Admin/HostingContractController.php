<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\{HostingContract, Customer, HostingPlan, HostingPlanContracted, CpanelAccount};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HostingContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hostingContracts = HostingContract::with([
          'customer:id,first_name,last_name,company_name',
          'hostingPlanContracted:id,title'])->where('active', 1)->paginate(15);

        $hostingPlans = HostingPlan::all('id', 'title');

        return view('admin.hosting-contracts.index')
          ->with('hostingContracts', $hostingContracts)->with('hostingPlans', $hostingPlans);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $customers = Customer::all('id', 'first_name', 'last_name', 'company_name');
      $hostingPlans = HostingPlan::all('id', 'title');
      $cpanelAccounts = CpanelAccount::all('id', 'domain_name');
      return view('admin.hosting-contracts.create')
        ->with('customers', $customers)->with('hostingPlans', $hostingPlans)
        ->with('cpanelAccounts', $cpanelAccounts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'hosting_plan_id' => 'required|exists:hosting_plans,id',
        'customer_id' => 'required|exists:customers,id',
        'start_date' => 'required|date',
        'contract_period' => 'required|in:1,2,3',
        'has_cpanel_account' => 'required|in:yes,no',
        'cpanel_id' => 'required_if:has_cpanel_account,yes|nullable|exists:cpanel_accounts,id',
        'cpanel.domain_name' => 'required_if:has_cpanel_account,no|nullable| unique:cpanel_accounts,domain_name',
        'cpanel.user' => 'required_if:has_cpanel_account,no|nullable|
          unique:cpanel_accounts,user',
        'cpanel.public_ip' => 'nullable|ip'
      ]);  

      DB::beginTransaction();
      try 
      { 
        $lastCustomerPurchase = HostingContract::getLatestCustomerPurchase($request->customer_id);
        if ( $lastCustomerPurchase ) 
        {
          // Do stuff when lastCustomerPurchase exists.
          $lastCustomerPurchase->active = 0;
          $lastCustomerPurchase->save();
        }

        $hostingPlan = HostingPlan::find($request->hosting_plan_id);
        $hostingPlanContracted = new HostingPlanContracted();
        $hostingPlanContracted->hosting_plan_id = $hostingPlan->id;
        $hostingPlanContracted->title = $hostingPlan->title;
        $hostingPlanContracted->description = $hostingPlan->description;
        $hostingPlanContracted->total_price_per_year = $hostingPlan->total_price_per_year;
        $hostingPlanContracted->contract_duration_in_years = $request->contract_period;
        $hostingPlanContractedIsSaved = $hostingPlanContracted->save();

        if ($request->has_cpanel_account === 'yes') 
        {
          $cpanelAccount = CpanelAccount::findOrFail($request->cpanel_id);
          $cpanelAccountIsSaved = true;
        }
        else 
        {
          $cpanelAccount = new CpanelAccount();
          $cpanelAccount->domain_name = $request->cpanel['domain_name'];
          $cpanelAccount->user = $request->cpanel['user'];
          $cpanelAccount->password = $request->cpanel['password'];
          $cpanelAccount->public_ip = $request->cpanel['public_ip'];
          $cpanelAccountIsSaved = $cpanelAccount->save();
        }

        $hostingContract = new HostingContract();
        $hostingContract->hosting_plan_contracted_id = $hostingPlanContracted->id;
        $hostingContract->customer_id = $request->customer_id;
        $hostingContract->cpanel_account_id = $cpanelAccount->id;
        $hostingContract->start_date = $request->start_date;
        $hostingContract->finish_date = 
        $hostingContract->calculateFinishDate($request->contract_period);
        $hostingContract->total_price = $hostingPlanContracted->real_total_price;
        $hostingContract->status = 'active'; 
        $hostingContract->active = 1;
        $hostingContract->user_id = $request->user()->id;
        $hostingContractIsSaved = $hostingContract->save();

        if ( $cpanelAccountIsSaved && $hostingPlanContracted && $hostingContractIsSaved ) 
        {
          DB::commit();
          return back()->with('status', 'El contrato hosting fue registrado con éxito.');
        }
      }
      catch(\Throwable $e)
      {
        DB::rollBack();
        throw $e;
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $hostingContract = HostingContract::findOrFail($id);
      return view('admin.hosting-contracts.show')->with('hostingContract', $hostingContract);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      return view('admin.hosting-contracts.edit')
        ->with('hostingContract', HostingContract::findOrFail($id) )
        ->with('customers', Customer::all('id', 'first_name', 'last_name', 'company_name') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'hosting_plan_contracted_id' => 'required|exists:hosting_plans_contracted,id',
        'hosting_plan_contracted_title' => 'required',
        'hosting_plan_contracted_description' => 'required',
        'customer_id' => 'required|exists:customers,id',
        'start_date' => 'required|date',
        'finish_date' => 'required|date|after:start_date',
        'total_price' => 'required|numeric'
      ]); 

      $hostingPlanContracted = HostingPlanContracted::findOrFail($request->hosting_plan_contracted_id);
      $hostingPlanContracted->title = $request->hosting_plan_contracted_title;
      $hostingPlanContracted->description = $request->hosting_plan_contracted_description;
      
      $hostingContract = HostingContract::findOrFail($id);
      $hostingContract->customer_id = $request->customer_id;
      $hostingContract->start_date = $request->start_date;
      $hostingContract->finish_date = $request->finish_date;
      $hostingContract->total_price = $request->total_price;
      $hostingContract->user_id = $request->user()->id;

      if( $hostingPlanContracted->save() && $hostingContract->save() ) {
        return back()->with('status', 'Se actualizó con éxito los nuevos datos del cliente.');
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $hostingContract = HostingContract::findOrFail($id);
      $hostingContract->finish_date = $hostingContract->now->toDateString();
      $hostingContract->total_price = 0;
      $hostingContract->status = 'suspended';
      if( $hostingContract->save() ) {
        return back()->with('status', 'El contrato hosting del cliente "'.$hostingContract->customer->full_name.'" fue suspendido con éxito');
      }
    }

    public function cpanelAccountUpdate(Request $request, $id) 
    {
      $request->validate([
        'domain_name' => 'required|unique:cpanel_accounts,domain_name,'.$id,
        'user' => 'required|unique:cpanel_accounts,user,'.$id,
        'password' => 'nullable',
        'public_ip' => 'nullable|ip'
      ]);  

      $cpanelAccount = CpanelAccount::findOrFail($id);
      $cpanelAccount->domain_name = $request->domain_name;
      $cpanelAccount->user = $request->user;
      $cpanelAccount->password = $request->password;
      $cpanelAccount->public_ip = $request->public_ip;

      if ( $cpanelAccount->save() ) {
        return back()->with('status', 
          'Los datos de la cuenta cPanel fueron actualizados con éxito.'
        );
      }
    }
}
