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
use App\Models\CashReceive; 
use App\Models\CashReceiveDetail;
use App\Models\Coa;
use App\Models\PayType; 
use App\Models\Company;
use Validator;
use Response;
use App\Post;
use View;

class CashReceiveController extends Controller
{
  public function index(Request $request)
  {
    return view ('editor.cash_receive.index');
  }
  public function data(Request $request)
  {   
  if($request->ajax()){ 
    $company_id = Auth::user()->company_id;
    $status =  $request->input('status');

    DB::statement(DB::raw('set @rownum=0'));
    $sql = 'SELECT
            @rownum  := @rownum  + 1 AS rownum,
            cash_receive.id AS id,
            cash_receive.cash_receive_no,
            DATE_FORMAT(cash_receive.cash_receive_date, "%d-%m-%Y") AS cash_receive_date,
            cash_receive.cash_receive_date AS cash_receive_date1,
            cash_receive.attachment,
            cash_receive.remark,
            cash_receive.`status`,
            cash_receive.coa_id,
            coa.coa_name,
            cash_receive.pay_type_id,
            pay_type.pay_type_name
            FROM
            cash_receive
            LEFT JOIN coa ON cash_receive.coa_id = coa.id
            LEFT JOIN pay_type ON cash_receive.pay_type_id = pay_type.id 
            ORDER BY cash_receive.cash_receive_date DESC';
            
    $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

    return Datatables::of($itemdata) 

    ->addColumn('action', function ($itemdata) {
      return '<a href="cash-receive/detail/'.$itemdata->id.'" title="Detail No: '."".$itemdata->cash_receive_no."".'"  onclick="edit('."'".$itemdata->id."'".')" class="btn btn-detail btn-xs btn-primary"><i class="fa fa-book"></i> Detail</a> <a href="cash-receive/slip/'.$itemdata->id.'" title="Detail No: '."".$itemdata->cash_receive_no."".'"  onclick="edit('."'".$itemdata->id."'".')" class="btn btn-detail btn-xs btn-warning"><i class="fa fa-book"></i> Print</a>';
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
       return '<a href="uploads/cash_receive/'.$itemdata->attachment.'" target="_blank"/><i class="fa fa-download"></i> Download</a>';
     };  
   })

    ->make(true);
  } else {
    exit("No data available");
  }
}

public function detail($id)
{ 
  $coa_list = Coa::all()->pluck('coa_name', 'id');
  $pay_type__list = PayType::all()->pluck('pay_type_name', 'id'); 

  $cash_receive = CashReceive::where('id', $id)->first();
  return view ('editor.cash_receive.form', compact('coa_list', 'pay_type__list','currency_list', 'cash_receive'));
}

public function store(Request $request)
{ 

  $userid= Auth::id();
  $codetrans = $request->input('code_trans'); 

  DB::insert("INSERT INTO cash_receive (cash_receive_no, cash_receive_date, created_by, created_at)
    SELECT 
    IFNULL(CONCAT('".$codetrans."','-',DATE_FORMAT(NOW(), '%d%m%y'),RIGHT((RIGHT(MAX(RIGHT(cash_receive.cash_receive_no,5)),5))+100001,5)), CONCAT('".$codetrans."','-',DATE_FORMAT(NOW(), '%d%m%y'),'00001')), DATE(NOW()), '".$userid."', DATE(NOW()) 
    FROM
    cash_receive");

  $lastInsertedID = DB::table('cash_receive')->max('id'); 

  return redirect('editor/cash-receive/detail/'.$lastInsertedID.''); 
}

public function saveheader($id, Request $request)
{ 
  $post = CashReceive::find($id); 
  $post->coa_id = $request->coaid;  
  $post->remark = $request->remark;   
  $post->updated_by = Auth::id();
  $post->save();

  if($request->attachment)
  {
    $cash_receive = CashReceive::FindOrFail($cash_receive->id);

    $original_directory = "uploads/cash_receive/";

    if(!File::exists($original_directory))
      {
        File::makeDirectory($original_directory, $mode = 0777, true, true);
      } 
      $cash_receive->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
      $request->attachment->move($original_directory, $cash_receive->attachment); 
      if(!File::exists($thumbnail_directory))
        {
         File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
       } 
       $cash_receive->save(); 
     } 
     return response()->json($post);  
   }

   public function update($id, Request $request)
   {  
    $date_array = explode("-",$request->input('cash_receive_date')); // split the array
    $var_day = $date_array[0]; //day seqment
    $var_month = $date_array[1]; //month segment
    $var_year = $date_array[2]; //year segment
    $new_date_format = "$var_year-$var_month-$var_day"; // join them together

    $cash_receive = CashReceive::Find($id);
    $cash_receive->cash_receive_date = $new_date_format; 
    $cash_receive->coa_id = $request->input('coaid'); 
    $cash_receive->pay_type_id = $request->input('pay_type_id');  
    $cash_receive->remark = $request->input('remark');    
    $cash_receive->updated_by = Auth::id(); 
    $cash_receive->save();

    if($request->attachment)
    {
      $cash_receive = CashReceive::FindOrFail($cash_receive->id);

      $original_directory = "uploads/cash_receive/";

      if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        } 

        $cash_receive->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
        $request->attachment->move($original_directory, $cash_receive->attachment);


        $cash_receive->save(); 
      } 

      return redirect('editor/cash-receive'); 
    }  

    public function cancel($id, Request $request)
    { 
      $post = CashReceive::find($id);  
      if($post->status == 9)
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
      $post = CashReceive::find($id);  
      $post->status = 1;   
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post);  
    }

    public function savedetail($id, Request $request)
    { 
      
      $post = new CashReceiveDetail;
      $post->trans_id = $id;  
      $post->description = $request->description; 
      $post->coa_id = $request->coa_id;  
      $post->debt = $request->debt;  
      $post->save(); 

      return response()->json($post);  
    }

    public function updatedetail($id, Request $request)
    { 
      $post = CashReceiveDetail::where('id', $request->cp_d_id)->first();  
      $post->description = $request->description; 
      $post->coa_id = $request->coa_id;  
      $post->debt = $request->debt;  
      $post->save();

      return response()->json($post); 

    }

    public function deletedet($id)
    { 
      $post =  CashReceiveDetail::where('id', $id)->delete(); 
      return response()->json($post); 
    }


    public function datadetail(Request $request, $id)
    {   

      if($request->ajax()){ 

        $sql = 'SELECT
                  cash_receive_detail.id AS cp_d_id,
                  cash_receive_detail.trans_id,
                  cash_receive_detail.description,
                  cash_receive_detail.coa_id,
                  coa.coa_name,
                  FORMAT(cash_receive_detail.debt,0) AS debt,
                  FORMAT(cash_receive_detail.credit,0) AS credit,
                  cash_receive_detail.debt AS debt_show,
                  cash_receive_detail.credit AS credit_show
                FROM
                  cash_receive_detail
                LEFT JOIN coa ON cash_receive_detail.coa_id = coa.id
                WHERE cash_receive_detail.deleted_at IS NULL AND cash_receive_detail.trans_id = '.$id.'';
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

    //Report
    public function reportdetail()
    { 
      return view ('editor.cash_receive.reportdetail', compact(''));
    }

     public function datareportdetail(Request $request)
    {   

      if($request->ajax()){ 
        $userid = Auth::id();
        $sql = 'SELECT 
                  cash_receive.cash_receive_no,
                  cash_receive.cash_receive_date,
                  pay_type.pay_type_name,
                  cash_receive.currency,
                  FORMAT(SUM(
                    IFNULL(cash_receive_detail.credit, 0) - IFNULL(
                      cash_receive_detail.debt,
                      0
                    )
                  ),0) AS amount
                FROM
                  cash_receive
                INNER JOIN cash_receive_detail ON cash_receive.id = cash_receive_detail.trans_id 
                LEFT JOIN pay_type_ ON cash_receive.pay_type_id = pay_type.id, users
                WHERE cash_receive.cash_receive_date BETWEEN users.date_from AND users.date_to AND users.id = '.$userid.'
                GROUP BY 
                  cash_receive.cash_receive_no,
                  cash_receive.cash_receive_date,
                  pay_type.pay_type_name,
                  cash_receive.currency';
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
                cash_receive.id AS id,
                cash_receive.cash_receive_no,
                DATE_FORMAT(cash_receive.cash_receive_date, "%d-%m-%Y") AS cash_receive_date,
                cash_receive.attachment,
                cash_receive.remark,
                cash_receive.`status`,
                cash_receive.coa_id,
                coa.coa_name,
                cash_receive.pay_type_id,
                pay_type.pay_type_name
                FROM
                cash_receive
                LEFT JOIN coa ON cash_receive.coa_id = coa.id
                LEFT JOIN pay_type ON cash_receive.pay_type_id = pay_type.id
                WHERE cash_receive.id = '.$id.'';
        $cash_receive = DB::table(DB::raw("($sql) as rs_sql"))->first(); 

        $sql_detail = 'SELECT
                        cash_receive_detail.id AS cp_d_id,
                        cash_receive_detail.trans_id,
                        cash_receive_detail.description,
                        cash_receive_detail.coa_id,
                        coa.coa_name,
                        FORMAT(cash_receive_detail.debt,0) AS debt,
                        FORMAT(cash_receive_detail.credit,0) AS credit,
                        cash_receive_detail.debt AS debt_show,
                        cash_receive_detail.credit AS credit_show
                      FROM
                        cash_receive_detail
                      LEFT JOIN coa ON cash_receive_detail.coa_id = coa.id
                      WHERE cash_receive_detail.deleted_at IS NULL AND cash_receive_detail.trans_id = '.$id.'';
        $cash_receive_detail = DB::table(DB::raw("($sql_detail) as rs_sql_detail"))->get(); 

        return view ('editor.cash_receive.slip', compact('cash_receive','cash_receive_detail', 'company'));
      }
  }
