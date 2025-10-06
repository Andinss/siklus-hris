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
use App\Models\CashTransfer;  
use App\Models\Coa;
use App\Models\Paytype; 
use App\Modelss\Company;
use Validator;
use Response;
use App\Post;
use View;

class CashTransferController extends Controller
{
 public function index(Request $request)
 {
  // $cashtransfers = CashTransfer::all();
  return view ('editor.cashtransfer.index', compact('cashtransfers'), [
            'status' => strtoupper($request->input('status'))
        ]);
}

public function data(Request $request)
{   
  if($request->ajax()){ 

    DB::statement(DB::raw('set @rownum=0'));
    $sql = 'SELECT
              @rownum  := @rownum  + 1 AS rownum,
              cashtransfer.id AS id,
              cashtransfer.cashtransferno,
              cashtransfer.cashtransferdate AS cashtransferdate1,
              DATE_FORMAT(cashtransfer.cashtransferdate, "%d-%m-%Y") AS cashtransferdate,  
              cashtransfer.attachment,
              cashtransfer.remark,
              cashtransfer.`status`,
              FORMAT(cashtransfer.amount,0) AS amount,
              cashtransfer.accountfromid,
              cash_from.coaname AS cash_from,
              cash_to.coaname AS cash_to
            FROM
              cashtransfer
            LEFT JOIN coa AS cash_from ON cashtransfer.accountfromid = cash_from.id
            LEFT JOIN coa AS cash_to ON cashtransfer.accounttoid = cash_to.id 
            ORDER BY cashtransfer.cashtransferdate DESC';
            
    $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

    return Datatables::of($itemdata) 

    ->addColumn('check', function ($itemdata) {
      return '<label class="control control--checkbox"> <input type="checkbox" class="data-check" value="'."'".$itemdata->id."'".'"> <div class="control__indicator"></div> </label>';
    })

    ->addColumn('action', function ($itemdata) {
      return '<a href="cashtransfer/detail/'.$itemdata->id.'" title="'."'".$itemdata->cashtransferno."'".'"  onclick="edit('."'".$itemdata->id."'".')"> '.$itemdata->cashtransferno.'</a>';
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
       return '<a href="uploads/cashtransfer/'.$itemdata->attachment.'" target="_blank"/><i class="fa fa-download"></i> Download</a>';
     };  
   })

    ->addColumn('slip', function ($itemdata) { 
     return '<a href="cashtransfer/detail/'.$itemdata->id.'" title="'."'".$itemdata->cashtransferno."'".'"  onclick="edit('."'".$itemdata->id."'".')" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a> <a href="cashtransfer/slip/'.$itemdata->id.'" target="_blank" class="btn btn-default btn-xs"/><i class="fa fa-print"></i></a>'; 
   })
    ->make(true);
  } else {
    exit("No data available");
  }
}

public function detail($id)
{ 
  $account_list = Coa::all()->pluck('coaname', 'id');

  $paytype_list = Paytype::all()->pluck('paytype_name', 'paytype_id'); 

  $cashtransfer = CashTransfer::where('id', $id)->first();
  return view ('editor.cashtransfer.form', compact('account_list', 'paytype_list','currency_list', 'cashtransfer'));
}

public function store(Request $request)
{ 

  $userid= Auth::id();
  $codetrans = $request->input('codetrans'); 

  DB::insert("INSERT INTO cashtransfer (cashtransferno, cashtransferdate, created_by, created_at)
    SELECT 
    IFNULL(CONCAT('".$codetrans."','-',DATE_FORMAT(NOW(), '%y%m%d'),RIGHT((RIGHT(MAX(RIGHT(cashtransfer.cashtransferno,5)),5))+100001,5)), CONCAT('".$codetrans."','-',DATE_FORMAT(NOW(), '%y%m%d'),'00001')), DATE(NOW()), '".$userid."', DATE(NOW()) 
    FROM
    cashtransfer");

  $lastInsertedID = DB::table('cashtransfer')->max('id'); 
  return redirect('editor/cashtransfer/detail/'.$lastInsertedID.''); 
}

public function saveheader($id, Request $request)
{ 
  $post = CashTransfer::find($id); 
  $post->accountid = $request->accountid;  
  $post->remark = $request->remark;   
  $post->updated_by = Auth::id();
  $post->save();

  if($request->attachment)
  {
    $cashtransfer = CashTransfer::FindOrFail($cashtransfer->id);

    $original_directory = "uploads/cashtransfer/";

    if(!File::exists($original_directory))
      {
        File::makeDirectory($original_directory, $mode = 0777, true, true);
      } 
      $cashtransfer->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
      $request->attachment->move($original_directory, $cashtransfer->attachment); 
      if(!File::exists($thumbnail_directory))
        {
         File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
       } 
       $cashtransfer->save(); 
     } 
     return response()->json($post);  
   }

   public function update($id, Request $request)
   {  

    $date_array = explode("-",$request->input('cashtransferdate')); // split the array
    $var_day = $date_array[0]; //day seqment
    $var_month = $date_array[1]; //month segment
    $var_year = $date_array[2]; //year segment
    $new_date_format = "$var_year-$var_month-$var_day"; // join them together


    $cashtransfer = CashTransfer::Find($id);
    $cashtransfer->cashtransferdate = $new_date_format; 
    $cashtransfer->accountfromid = $request->input('accountfromid'); 
    $cashtransfer->accounttoid = $request->input('accounttoid');  
    $cashtransfer->amount = $request->input('amount'); 
    $cashtransfer->remark = $request->input('remark');   
    
    $cashtransfer->updated_by = Auth::id(); 
    $cashtransfer->save();

    if($request->attachment)
    {
      $cashtransfer = CashTransfer::FindOrFail($cashtransfer->id);

      $original_directory = "uploads/cashtransfer/";

      if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        } 

        $cashtransfer->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
        $request->attachment->move($original_directory, $cashtransfer->attachment);


        $cashtransfer->save(); 
      } 

      return redirect('editor/cashtransfer'); 
    }  

    public function cancel($id, Request $request)
    { 
      $post = CashTransfer::find($id);  
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
      $post = CashTransfer::find($id);  
      $post->status = 1;   
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post);  
    }

    public function slip($id)
    {  
 
      $sql = 'SELECT 
              cashtransfer.id AS id,
              cashtransfer.cashtransferno,
              DATE_FORMAT(cashtransfer.cashtransferdate, "%d-%m-%Y") AS cashtransferdate,
              cashtransfer.attachment,
              cashtransfer.remark,
              cashtransfer.`status`,
              FORMAT(cashtransfer.amount,0) AS amount,
              cashtransfer.accountfromid,
              cash_from.coaname AS cash_from,
              cash_to.coaname AS cash_to
            FROM
              cashtransfer
            LEFT JOIN coa AS cash_from ON cashtransfer.accountfromid = cash_from.id
            LEFT JOIN coa AS cash_to ON cashtransfer.accounttoid = cash_to.id
            WHERE cashtransfer.id = '.$id.'';
      $cashtransfer = DB::table(DB::raw("($sql) as rs_sql"))->first(); 
 
      //dd($cashtransfer_detail);
      return view ('editor.cashtransfer.slip', compact('cashtransfer', 'company'));
    }
 
  }
