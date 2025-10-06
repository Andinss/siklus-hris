<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PayrollSetting; 
use Illuminate\Http\Request;
use Validator;
use Response;
use App\Post;
use View;

class PayrollSlipController extends Controller
{
  public function index()
  {
    $id = 1;
    $payrollSetting =  PayrollSetting::Find($id);
    return view ('editor.payroll_slip.index', compact('payrollSetting'));
  }

  
  public function store(Request $request)
  {
    $id = 1;
    $payrollSetting =  PayrollSetting::Find($id);
    $payrollSetting->company_name = $request->input('company_name');
    $payrollSetting->pic = $request->input('pic_name');
    $payrollSetting->address = $request->input('address');
    $payrollSetting->save();

    if($request->file('logo')){
      $payrollSetting = PayrollSetting::FindOrFail($id);
      $targetFile = 'uploads/payroll_setting/';
      if(!File::exists($targetFile)){
        File::makeDirectory($targetFile, $mode = 0777, true, true);
      }
      $payrollSetting->logo = Carbon::now()->format("d-m-Y h-i-s").$request->logo->getClientOriginalName();
      $request->logo->move($targetFile, $payrollSetting->logo);
      $payrollSetting->save();
    }

    if($request->file('signature')){
      $payrollSetting = PayrollSetting::FindOrFail($id);
      $targetFile = 'uploads/payroll_setting/';
      if(!File::exists($targetFile)){
        File::makeDirectory($targetFile, $mode = 0777, true, true);
      }
      $payrollSetting->signature = Carbon::now()->format("d-m-Y h-i-s").$request->signature->getClientOriginalName();
      $request->signature->move($targetFile, $payrollSetting->signature);
      $payrollSetting->save();
    }

    return back();
  }
}
