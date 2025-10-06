<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\RewardRequest;
use App\Http\Controllers\Controller;
use App\Models\Reward; 
use App\Models\Employee; 
use App\Models\SkType;
use App\Models\RewardType;
use Validator;
use Response;
use App\Models\Post;
use View;

class RewardController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [
      'reward_no' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
      'reward_name' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $rewards = Reward::all();
      return view ('editor.reward.index', compact('rewards'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 

        $sql = 'SELECT
                  reward.id,
                  reward.no_trans,
                  DATE_FORMAT( reward.date_trans, "%d/%m/%Y" ) AS date_trans,
                  reward.employee_id,
                  employee.employee_name,
                  reward_type.reward_type_name,
                  DATE_FORMAT( reward.date_from, "%d/%m/%Y" ) AS date_from,
                  DATE_FORMAT( reward.date_to, "%d/%m/%Y" ) AS date_to,
                  reward.sk_type_id,
                  reward.status, 
                  reward.description,
                  reward.attachment 
                FROM
                  reward
                  LEFT JOIN employee ON reward.employee_id = employee.id
                  LEFT JOIN reward_type ON reward.reward_type_id = reward_type.id
                WHERE
                  reward.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

        return DataTables::of($itemdata) 
        ->addColumn('action', function ($itemdata) {
          return '<a href="reward/'.$itemdata->id.'/edit" title="Detail No: '."".$itemdata->no_trans."".'"  onclick="edit('."'".$itemdata->id."'".')" class="btn btn-sm btn-outline-primary d-inline-block"><i class="fas fa-pen"></i> Edit</a> <a href="javascript:void(0)" title="Delete" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->no_trans."'".')"> <i class="fas fa-trash-alt"></i> Delete</a>';
        })
        ->addColumn('approval', function ($itemdata) {
        return '<a  href="javascript:void(0)" title="Approval" class="btn btn-sm btn-success" onclick="approve_id('."'".$itemdata->id."', '".$itemdata->no_trans."'".')"><i class="fas fa-check"></i> Approve</a> <a href="javascript:void(0)" title="Approval" class="btn btn-sm btn-warning" onclick="not_approve_id('."'".$itemdata->id."', '".$itemdata->no_trans."'".')"><i class="fas fa-times"></i> Not Approve</a>';
      })
       ->addColumn('attachment', function ($itemdata) {
          if ($itemdata->attachment == null) {
            return '';
          }else{
           return '<a href="'.asset("assets/uploads/reward/".$itemdata->attachment).'" target="_blank"/><i class="fa fa-download"></i> Download</a>';
         };  
        })
        ->toJson();
      } else {
        exit("No data available");
      }
    }

    public function datahistory(Request $request)
    {   
      if($request->ajax()){ 

        $sql = 'SELECT
                  reward.id,
                  reward.no_trans,
                  DATE_FORMAT(reward.date_trans, "%d-%m-%Y") AS date_trans,
                  reward.description,
                  employee.employee_name,
                  reward_type.reward_type_name
                FROM
                  reward
                INNER JOIN employee ON reward.employee_id = employee.id
                INNER JOIN reward_type ON reward.reward_type_id = reward_type.id,
                 `user`
                WHERE
                  `user`.id = '.Auth::id().' AND reward.employee_id = user.employee_id
                AND
                  reward.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

        return Datatables::of($itemdata) 

        ->make(true);
      } else {
        exit("No data available");
      }
    }

    public function create()
    {  
      $employee_list = Employee::all()->pluck('employee_name', 'id'); 
      $sktype_list = Sktype::all()->pluck('sk_type_name', 'id'); 
      $reward_type_list = RewardType::all()->pluck('reward_type_name', 'id'); 

      return view ('editor.reward.form', compact('employee_list', 'sktype_list', 'reward_type_list'));
    }

    public function store(Request $request)
    { 
        DB::insert("INSERT INTO reward (code_trans, no_trans, date_trans)
                    SELECT 'REWARD',
                    IFNULL(CONCAT('REWARD','-',DATE_FORMAT(NOW(), '%d%m%y'),RIGHT((RIGHT(MAX(reward.no_trans),3))+1001,3)), CONCAT('REWARD','-',DATE_FORMAT(NOW(), '%d%m%y'),'001')), DATE(NOW())  
                    FROM
                    reward
                    WHERE code_trans='REWARD'");

       $lastInsertedID = DB::table('reward')->max('id');  

       $date_array = explode("-",$request->input('date_trans')); // split the array
       $var_day = $date_array[0]; //day seqment
       $var_month = $date_array[1]; //month segment
       $var_year = $date_array[2]; //year segment
       $new_date_format = "$var_year-$var_month-$var_day"; // join them together

       $reward = Reward::where('id', $lastInsertedID)->first(); 
       $reward->date_trans = $new_date_format; 
       $reward->employee_id = $request->input('employee_id'); 
       $reward->reward_type_id = $request->input('reward_type_id');  
       $reward->description = $request->input('description');  
       $reward->created_by = Auth::id();
       $reward->save();

       if($request->attachment)
       {
        $reward = Reward::FindOrFail($reward->id);
        $original_directory = "uploads/reward/";
        if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          } 
          $reward->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
          $request->attachment->move($original_directory, $reward->attachment);
          $reward->save(); 
        } 
        return redirect('editor/reward'); 
     
    }

    public function edit($id)
    {
      $employee_list = Employee::all()->pluck('employee_name', 'id'); 
      $sktype_list = Sktype::all()->pluck('sk_type_name', 'id'); 
      $reward_type_list = RewardType::all()->pluck('reward_type_name', 'id'); 
      $reward = Reward::Where('id', $id)->first();   

      return view ('editor.reward.form', compact('reward','sktype_list', 'employee_list', 'reward_type_list'));
    }

    public function update($id, Request $request)
    {

       $date_array = explode("-",$request->input('date_trans')); // split the array
       $var_day = $date_array[0]; //day seqment
       $var_month = $date_array[1]; //month segment
       $var_year = $date_array[2]; //year segment
       $new_date_format = "$var_year-$var_month-$var_day"; // join them together
      
       $reward = Reward::FindOrFail($id); 
       $reward->date_trans = $new_date_format; 
       $reward->employee_id = $request->input('employee_id'); 
       $reward->reward_type_id = $request->input('reward_type_id');  
       $reward->description = $request->input('description');  
       $reward->created_by = Auth::id();
       $reward->save();

      if($request->attachment)
      {
        $reward = Reward::FindOrFail($reward->id);
        $original_directory = "uploads/reward/";
        if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          } 
          $reward->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
          $request->attachment->move($original_directory, $reward->attachment);
          $reward->save(); 
        } 
        return redirect('editor/reward');  
      }

      public function cancel($id, Request $request)
      {
        $post = Reward::Find($id); 
        $post->status = 9; 
        $post->created_by = Auth::id();
        $post->save(); 
      
        return response()->json($post); 

      }

      public function delete($id)
      {
        $post =  Reward::Find($id);
        $post->delete(); 

        return response()->json($post); 
      }

      public function deletebulk(Request $request)
      {

       $idkey = $request->idkey;    

       foreach($idkey as $key => $id)
       {
        $post = Document::Find($id["1"]);
        $post->delete(); 
      }

      echo json_encode(array("status" => TRUE));

    }
  }
