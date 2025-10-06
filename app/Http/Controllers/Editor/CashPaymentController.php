<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use File;
use Session;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use App\Models\CashPayment; 
use App\Models\CashPaymentDetail;
use App\Models\Coa;
use App\Models\PayType;   
use App\Models\Employee;   
use Validator;
use Response;
use App\Post;
use View;

class CashPaymentController extends Controller
{
 public function index(Request $request)
 {
  return view ('editor.cash_payment.index');
}

public function data(Request $request)
{   
  if($request->ajax()){ 
    $company_id = Auth::user()->company_id;
    $status =  $request->input('status');
    
    DB::statement(DB::raw('set @rownum=0'));
    $sql = 'SELECT
            @rownum  := @rownum  + 1 AS rownum,
            cash_payment.id AS id,
            cash_payment.cash_payment_no,
            DATE_FORMAT(cash_payment.cash_payment_date, "%d-%m-%Y") AS cash_payment_date,
            cash_payment.cash_payment_date AS cash_payment_date1,
            cash_payment.attachment,
            cash_payment.remark,
            cash_payment.`status`,
            cash_payment.coa_id,
            coa.coa_name,
            cash_payment.pay_type_id,
            pay_type.pay_type_name,
            employee.employee_name
            FROM
            cash_payment
            LEFT JOIN coa ON cash_payment.coa_id = coa.id
            LEFT JOIN pay_type ON cash_payment.pay_type_id = pay_type.id 
            LEFT JOIN employee ON cash_payment.employee_id = employee.id
            ORDER BY cash_payment.cash_payment_date DESC';

    $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->orderBy('cash_payment_date1', 'DESC')->get(); 

    return Datatables::of($itemdata) 

   ->addColumn('action', function ($itemdata) {
      return '<a href="cash-payment/detail/'.$itemdata->id.'" title="Detail No: '."".$itemdata->cash_payment_no."".'"  onclick="edit('."'".$itemdata->id."'".')" class="btn btn-detail btn-xs btn-primary"><i class="fa fa-book"></i> Detail</a> <a href="cash-payment/slip/'.$itemdata->id.'" target="_blank" title="Detail No: '."".$itemdata->cash_payment_no."".'"  onclick="edit('."'".$itemdata->id."'".')" class="btn btn-detail btn-xs btn-warning"><i class="fa fa-book"></i> Print</a>';
    })

    ->addColumn('mstatus', function ($itemdata) {
      if ($itemdata->status == 0) {
        return '<span class="label label-success"> Active </span>';
      }elseif ($itemdata->status == 1){
       return '<span class="label label-warning"> Close </span>';
     }else{
       return '<span class="label label-danger"> Cancel </span>';
     }; 
   })
    
    ->addColumn('attachment', function ($itemdata) {
      if ($itemdata->attachment == null) {
        return '';
      }else{
       return '<a href="uploads/cash_payment/'.$itemdata->attachment.'" target="_blank"/><i class="fa fa-download"></i> Download</a>';
     };  
   })

    ->addColumn('slip', function ($itemdata) { 
     return '<a href="cash_payment/detail/'.$itemdata->id.'" title="'."'".$itemdata->cash_payment_no."'".'" class="btn btn-default btn-xs" onclick="edit('."'".$itemdata->id."'".')"><i class="fa fa-pencil"></i> </a> <a href="cash_payment/slip/'.$itemdata->id.'" target="_blank" class="btn btn-default btn-xs"/><i class="fa fa-print"></i></a>'; 
   })
    ->make(true);
  } else {
    exit("No data available");
  }
}

public function detail($id)
{ 
  $coa_list = Coa::all()->pluck('coa_name', 'id');
  $pay_type_list = Paytype::all()->pluck('pay_type_name', 'id'); 
  $employee_list = Employee::all()->pluck('employee_name', 'id'); 

  $cash_payment = CashPayment::where('id', $id)->first();
  return view ('editor.cash_payment.form', compact('coa_list', 'pay_type_list','currency_list', 'cash_payment','sales_list', 'employee_list'));
}

public function store(Request $request)
{ 

  $userid= Auth::id();
  $code_trans = $request->input('code_trans'); 

  DB::insert("INSERT INTO cash_payment (cash_payment_no, cash_payment_date, created_by, created_at)
    SELECT 
    IFNULL(CONCAT('".$code_trans."','-',DATE_FORMAT(NOW(), '%Y%m%d'),RIGHT((RIGHT(MAX(RIGHT(cash_payment.cash_payment_no,5)),5))+100001,5)), CONCAT('".$code_trans."','-',DATE_FORMAT(NOW(), '%Y%m%d'),'00001')), DATE(NOW()), '".$userid."', DATE(NOW()) 
    FROM
    cash_payment");

  $lastInsertedID = DB::table('cash_payment')->max('id'); 

  return redirect('editor/cash-payment/detail/'.$lastInsertedID.''); 
}

public function saveheader($id, Request $request)
{ 
  $post = CashPayment::find($id); 
  $post->coa_id = $request->coa_id;  
  $post->remark = $request->remark;   
  $post->updated_by = Auth::id();
  $post->save();

  if($request->attachment)
  {
    $cash_payment = CashPayment::FindOrFail($cash_payment->id);

    $original_directory = "uploads/cash_payment/";

    if(!File::exists($original_directory))
      {
        File::makeDirectory($original_directory, $mode = 0777, true, true);
      } 
      $cash_payment->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
      $request->attachment->move($original_directory, $cash_payment->attachment); 
      if(!File::exists($thumbnail_directory))
        {
         File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
       } 
       $cash_payment->save(); 
     } 
     return response()->json($post);  
   }

   public function update($id, Request $request)
   {  

    $date_array = explode("-",$request->input('cash_payment_date')); // split the array
    $var_day = $date_array[0]; //day seqment
    $var_month = $date_array[1]; //month segment
    $var_year = $date_array[2]; //year segment
    $new_date_format = "$var_year-$var_month-$var_day"; // join them together


    $cash_payment = CashPayment::Find($id);
    $cash_payment->cash_payment_date = $new_date_format; 
    $cash_payment->coa_id = $request->input('coa_id'); 
    $cash_payment->pay_type_id = $request->input('pay_type_id');  
    $cash_payment->employee_id = $request->input('employee_id');  
    $cash_payment->remark = $request->input('remark');  
    $cash_payment->updated_by = Auth::id(); 
    $cash_payment->save();

    if($request->attachment)
    {
      $cash_payment = CashPayment::FindOrFail($cash_payment->id);

      $original_directory = "uploads/cash_payment/";

      if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        } 

        $cash_payment->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
        $request->attachment->move($original_directory, $cash_payment->attachment);


        $cash_payment->save(); 
      } 

      return redirect('editor/cash-payment'); 
    }  

    public function cancel($id, Request $request)
    { 
      $post = CashPayment::find($id);  
      if($post->status > 0)
      {
        $post->status = 0;
      }else
      { 
        $post->status = 9;  
      }; 
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post); 

    }

    public function close($id, Request $request)
    { 
      $post = CashPayment::find($id);  
      $post->status = 1;   
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post);  
    }

    public function savedetail($id, Request $request)
    { 
      $post = new CashPaymentDetail;
      $post->trans_id = $id;  
      $post->description = $request->description; 
      $post->coa_id = $request->coa_id;  
      $post->debt = $request->debt;  
      $post->credit = $request->credit; 
      $post->save();

      return response()->json($post);  
    }

    public function updatedetail($id, Request $request)
    { 

      $post = CashPaymentDetail::where('id', $request->trans_id)->first();  
      $post->description = $request->description; 
      $post->coa_id = $request->coa_id;  
      $post->debt = $request->debt;  
      $post->credit = $request->credit;  
      $post->save();


      return response()->json($post); 

    }

    public function deletedet($id)
    { 
      //dd($id);
      $post =  CashPaymentDetail::where('id', $id)->delete(); 

      return response()->json($post); 
    }


    public function datadetail(Request $request, $id)
    {   

      if($request->ajax()){ 

        $sql = 'SELECT
                  cash_payment_detail.id AS cp_d_id,
                  cash_payment_detail.trans_id,
                  cash_payment_detail.description,
                  cash_payment_detail.coa_id,
                  coa.coa_name,
                  FORMAT(cash_payment_detail.debt,0) AS debt,
                  FORMAT(cash_payment_detail.credit,0) AS credit,
                  cash_payment_detail.debt AS debt_show,
                  cash_payment_detail.credit AS credit_show
                FROM
                  cash_payment_detail
                LEFT JOIN coa ON cash_payment_detail.coa_id = coa.id
                WHERE cash_payment_detail.deleted_at IS NULL AND cash_payment_detail.trans_id = '.$id.'';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

        return Datatables::of($itemdata) 

        ->addColumn('action', function ($itemdata) {
          return '<a  href="javascript:void(0)" title="Edit" class="btn btn-primary btn-xs" onclick="update_id(this, '."'".$itemdata->cp_d_id."', '".$itemdata->debt_show."', '".$itemdata->credit_show."', '".$itemdata->coa_id."'".')"><i class="fa fa-pencil"></i></a> <a  href="javascript:void(0)" title="Delete" class="btn btn-danger btn-xs" onclick="delete_id('."'".$itemdata->cp_d_id."', '".$itemdata->coa_name."'".')"><i class="fa fa-trash"></i></a>';
        })

        ->make(true);
      } else {
        exit("No data available");
      }
    }

    public function reportdetail()
    { 
      return view ('editor.cash_payment.reportdetail', compact(''));
    }

     public function datareportdetail(Request $request)
    {   

      if($request->ajax()){ 
        $userid = Auth::id();
        $sql = 'SELECT
                  employee.employee_name,
                  cash_payment.cash_payment_no,
                  cash_payment.cash_payment_date,
                  pay_type.pay_type_name,
                  cash_payment.currency,
                  FORMAT(SUM(
                    IFNULL(cash_payment_detail.credit, 0) - IFNULL(
                      cash_payment_detail.debt,
                      0
                    )
                  ),0) AS amount
                FROM
                  cash_payment
                INNER JOIN cash_payment_detail ON cash_payment.id = cash_payment_detail.trans_id
                LEFT JOIN employee ON employee.employee_id = cash_payment.employee_id
                LEFT JOIN pay_type ON cash_payment.pay_type_id = pay_type.id, users
                WHERE cash_payment.cash_payment_date BETWEEN users.date_from AND users.date_to AND users.id = '.$userid.'
                GROUP BY
                  employee.employee_name,
                  cash_payment.cash_payment_no,
                  cash_payment.cash_payment_date,
                  pay_type.pay_type_name,
                  cash_payment.currency';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

        return Datatables::of($itemdata)  

        ->make(true);
      } else {
        exit("No data available");
      }
    }

    public function slip($id)
      {  
 

        $sql = 'SELECT
                  cash_payment.id AS id,
                  cash_payment.cash_payment_no,
                  DATE_FORMAT(
                    cash_payment.cash_payment_date,
                    "%d-%m-%Y"
                  ) AS cash_payment_date,
                  cash_payment.attachment,
                  cash_payment.remark,
                  cash_payment.`status`,
                  cash_payment.coa_id,
                  coa.coa_name,
                  cash_payment.pay_type_id,
                  pay_type.pay_type_name,
                  employee.employee_name,
                  employee.nik
                FROM
                  cash_payment
                LEFT JOIN coa ON cash_payment.coa_id = coa.id
                LEFT JOIN pay_type ON cash_payment.pay_type_id = pay_type.id
                LEFT JOIN employee ON cash_payment.employee_id = employee.id
                WHERE cash_payment.id = '.$id.'';
        $cash_payment = DB::table(DB::raw("($sql) as rs_sql"))->first(); 

        $sql_detail = 'SELECT
                        cash_payment_detail.id AS cp_d_id,
                        cash_payment_detail.trans_id,
                        cash_payment_detail.description,
                        cash_payment_detail.coa_id,
                        coa.coa_name,
                        FORMAT(cash_payment_detail.debt,0) AS debt,
                        FORMAT(cash_payment_detail.credit,0) AS credit,
                        cash_payment_detail.debt AS debt_show,
                        cash_payment_detail.credit AS credit_show
                      FROM
                        cash_payment_detail
                      LEFT JOIN coa ON cash_payment_detail.coa_id = coa.id
                      WHERE cash_payment_detail.deleted_at IS NULL AND cash_payment_detail.trans_id = '.$id.'';
        $cash_payment_detail = DB::table(DB::raw("($sql_detail) as rs_sql_detail"))->get(); 

        return view ('editor.cash_payment.slip', compact('cash_payment','cash_payment_detail', 'company'));
      }
  }
