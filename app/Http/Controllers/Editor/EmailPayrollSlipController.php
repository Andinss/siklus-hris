<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PayrollRequest;
use App\Http\Controllers\Controller;
use App\Models\Payroll; 
use App\Models\Payperiod;
use App\Models\Employee;
use App\Mail\PayrollslipEmail;
use App\Events\PayrollslipEvent;
use App\User;
use App\Post;
use Validator;
use Response;
use View;
use Mail;
use Event;

class EmailpayrollslipController extends Controller
{
  public function index()
  {  
    $payperiod_list = Payperiod::all()->pluck('description', 'id');
    $employee = Employee::all();
    return view ('editor.emailpayrollslip.index', compact('payperiod_list','employee'));
  }

   protected function payrollslip(array $data)
	{
	    $payrollslip = Employee::create([
	        'periodid' => 'abc' 
	    ]); 

	    Event::fire(new PayrollslipEvent('abc'));
	    return $payrollslip;
	}

  public function sendmail(Request $request)
  { 
  		event(new Employee($payrollslip = $this->payrollslip($request->all())));
        $payrollslip = DB::table('employee')->orderBy('id', 'desc')->first();

        dd($payrollslip);
        $tyrSendMail = Mail::to($request['email'])->send(new PayrollslipEmail($payrollslip));

        return redirect($this->redirectTo);
  }
}
