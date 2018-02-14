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
        $hostingContracts = HostingContract::paginate(6);
        return view('admin.hosting-contracts.all', ['hostingContracts' => $hostingContracts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $customers = Customer::all('id', 'first_name', 'last_name');
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
        'cpanel.user' => 'required_if:create_account,yes|unique:cpanel_accounts,user',
        'cpanel.public_ip' => 'nullable|ip',
        'user_id' => 'required|exists:users,id'
      ]);  
      
      $hostingPlan = HostingPlan::find($request->hosting_plan_id);
      $hostingPlanContracted = new HostingPlanContracted();
      $hostingPlanContracted->hosting_plan_id = $hostingPlan->id;
      $hostingPlanContracted->title = $hostingPlan->title;
      $hostingPlanContracted->description = $hostingPlan->description;
      $hostingPlanContracted->total_price_per_year = $hostingPlan->total_price_per_year;
      $hostingPlanContracted->contract_duration_in_years = $request->contract_period;

      if (! $hostingPlanContracted->save()) {
        return back()->with('status', 'Ocurrió un error al registrar el Plan Hosting.');
      }
       
      if ($request->create_account === 'yes') {
        $cpanelAccount = new CpanelAccount();
        $cpanelAccount->domain_name = $request->cpanel['domain_name'];
        $cpanelAccount->user = $request->cpanel['user'];
        $cpanelAccount->password = $request->cpanel['password'];
        $cpanelAccount->public_ip = $request->cpanel['public_ip'];

        if (! $cpanelAccount->save()) {
          return back()->with('status', 'Ocurrió un error al registrar la cuenta cPanel.');
        }
      }

      $hostingContract = new HostingContract();
      $hostingContract->customer_id = $request->customer_id;
      $hostingContract->hosting_plan_contracted_id = $hostingPlanContracted->id;
      $hostingContract->start_date = $request->start_date;
      $hostingContract->calculateFinishDate($request->contract_period);
      $hostingContract->cpanel_account_id = $cpanelAccount->id??null;
      $hostingContract->status = 'active'; 
      $hostingContract->user_id = $request->user_id;

      if ($hostingContract->save()) {
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
      $request->validate([
        'company_name' => 'required|string',
        'description' => 'required|string',
        'email' => 'required|string|email|unique:domain_providers'
      ]);  

      if (is_null(HostingContract::find($id))) {
        return redirect('dashboard/domain-providers');
      }

      $hostingContract = HostingContract::find($id);
      //$hostingContract->customer_id = $request->customer_id;
      $hostingContract->hosting_plan_contracted_id = $request->hosting_plan_contracted_id;
      //$hostingContract->start_date = $request->start_date;
      $hostingContract->due_date = $request->due_date;
      $hostingContract->public_ip = $request->public_ip;
      $hostingContract->cpanel_user = $request->cpanel_user;
      $hostingContract->cpanel_password = $request->cpanel_password;
      $hostingContract->domain_name = $request->domain_name;
      $hostingContract->user_id = $request->user_id;

      if ($hostingContract->save()) {
        return back()->with('status', 'Los datos del proveedor de dominio fueron actualizados correctamente.');
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
        if(HostingContract::find($id)->delete())
        {
            return back()->with('status', 'El cliente se elimino correctamente.');          
        }
        else {
            return back()->with('status', 'Ocurrió un problema al tratar de eliminar el cliente. Vuelva a intentarlo nuevamente.');     
        }
    }
}
