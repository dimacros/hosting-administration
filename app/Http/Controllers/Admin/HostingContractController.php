<?php
namespace App\Http\Controllers\Admin;

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
        $hostingContracts = HostingContract::where('status', 'active')
        ->with('Customer:id,first_name,last_name,company_name')
        ->with('HostingPlanContracted:id,title')
        ->with('CpanelAccount')->take(10)->get();
        return view('admin.hosting-contracts.index', ['hostingContracts' => $hostingContracts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $customers = Customer::all('id', 'first_name', 'last_name', 'company_name');
      $hosting_plans = HostingPlan::all('id', 'title');
      return view('admin.hosting-contracts.create', ['customers' => $customers, 'hosting_plans' => $hosting_plans]);
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
        'customer_id' => 'required|exists:customers,id',
        'hosting_plan_id' => 'required|exists:hosting_plans,id',
        'start_date' => 'required|date',
        'contract_period' => 'required|in:1,2,3',
        'create_account' => 'required|in:yes,no',
        'cpanel.domain_name' => 'required_if:create_account,yes|nullable|url| unique:cpanel_accounts,domain_name',
        'cpanel.user' => 'required_if:create_account,yes|nullable|unique:cpanel_accounts,user',
        'cpanel.public_ip' => 'nullable|ip',
        'user_id' => 'required|exists:users,id'
      ]);  
 
      $hostingPlan = HostingPlan::findOrFail($request->hosting_plan_id);
      
      $cpanelAccount = new CpanelAccount();
      $cpanelAccount->domain_name = $request->cpanel['domain_name'];
      $cpanelAccount->user = $request->cpanel['user'];
      $cpanelAccount->password = $request->cpanel['password'];
      $cpanelAccount->public_ip = $request->cpanel['public_ip'];
      $cpanelAccount->save();

      $hostingContract = new HostingContract();
      $hostingContract->customer_id = $request->customer_id;
      $hostingContract->start_date = $request->start_date;
      $hostingContract->finish_date = $hostingContract->calculateFinishDate($request->contract_period);
      $hostingContract->total_price = (
        $request->contract_period * $hostingPlan->total_price_per_year
      );
      $hostingContract->cpanel_account_id = $cpanelAccount->id;
      $hostingContract->status = 'active'; 
      $hostingContract->user_id = $request->user_id;
      $hostingContract->save();

      $hostingPlanContracted = new HostingPlanContracted();
      $hostingPlanContracted->hosting_plan_id = $hostingPlan->id;
      $hostingPlanContracted->hosting_contract_id = $hostingContract->id;
      $hostingPlanContracted->title = $hostingPlan->title;
      $hostingPlanContracted->description = $hostingPlan->description;
      $hostingPlanContracted->total_price_per_year = $hostingPlan->total_price_per_year;
      $hostingPlanContracted->contract_duration_in_years = $request->contract_period;

      if ($hostingPlanContracted->save()) {
        return back()->with('status', 'El contrato hosting fue registrado con éxito.');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
