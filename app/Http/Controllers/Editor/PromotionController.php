<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PromotionRequest;
use App\Http\Controllers\Controller;
use App\Models\Promotion; 
use App\Models\Employee; 
use App\Models\Position;
use App\Models\Department;
use Validator;
use Response;
use App\Post;
use View;

class PromotionController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [
    'promotionno' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
    'promotionname' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $promotions = Promotion::all();
      return view ('editor.promotion.index', compact('promotions'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 

        $sql = 'SELECT
                  promotion.id,
                  promotion.notrans,
                  promotion.datetrans,
                  employee.employeename,
                  promotion.skno,
                  promotion.placementdate,
                  promotion.requestdate,
                  promotion.accepdate,
                  position.positionname AS curpositionname,
                  position_1.positionname AS nexpositionname,
                  department.departmentname AS curdepartmentname,
                  department_1.departmentname AS nexdepartmentname,
                  promotion.requestby,
                  promotion.accepby,
                  promotion.attachment,
                  promotion.`status`,
                  promotion.created_by,
                  promotion.updated_by,
                  promotion.deleted_by,
                  promotion.created_at,
                  promotion.updated_at,
                  promotion.deleted_at 
                FROM
                  promotion
                  LEFT JOIN employee ON promotion.employeeid = employee.id
                  LEFT JOIN position ON promotion.currentpositionid = position.id
                  LEFT JOIN position AS position_1 ON promotion.nextpositionid = position_1.id
                  LEFT JOIN department ON promotion.currentdepartmentid = department.id
                  LEFT JOIN department AS department_1 ON promotion.nextdepartmentid = department_1.id 
                WHERE
                  promotion.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 


        return Datatables::of($itemdata) 


        ->addColumn('action', function ($itemdata) {
          return '<a href="promotion/'.$itemdata->id.'/edit" title="'."'".$itemdata->notrans."'".'"  onclick="edit('."'".$itemdata->id."'".')"> '.$itemdata->notrans.'</a>';
        })

        ->addColumn('approval', function ($itemdata) {
        return '<a  href="javascript:void(0)" title="Approval" class="btn btn-success btn-xs" onclick="approve_id('."'".$itemdata->id."', '".$itemdata->notrans."'".')"><i class="fa fa-check"></i> Approve</a> <a  href="javascript:void(0)" title="Approval" class="btn btn-warning btn-xs" onclick="not_approve_id('."'".$itemdata->id."', '".$itemdata->notrans."'".')"><i class="fa fa-close"></i> Not Approve</a>';
      })

        ->addColumn('mstatus', function ($itemdata) {
          if ($itemdata->status == 0) {
            return '<span class="label label-success"> <i class="fa fa-check"></i> Active </span>';
          }else if ($itemdata->status == 9){
           return '<span class="label label-danger"> <i class="fa fa-minus-square"></i> Cancel </span>';
        };

       })
        ->make(true);
      } else {
        exit("No data available");
      }
    }

    public function datahistory(Request $request)
    {   
      if($request->ajax()){ 

        $sql = 'SELECT
                  promotion.id,
                  promotion.notrans,
                  promotion.datetrans,
                  employee.employeename,
                  promotion.skno,
                  promotion.placementdate,
                  promotion.requestdate,
                  promotion.accepdate,
                  position.positionname AS curpositionname,
                  position_1.positionname AS nexpositionname,
                  promotion.requestby
                FROM
                  promotion
                LEFT JOIN employee ON promotion.employeeid = employee.id
                LEFT JOIN position ON promotion.currentpositionid = position.id
                LEFT JOIN position AS position_1 ON promotion.nextpositionid = position_1.id,
                 `user`
                WHERE
                  `user`.id = '.Auth::id().' AND promotion.employeeid = user.employeeid
                AND
                  promotion.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 


        return Datatables::of($itemdata) 

        ->make(true);
      } else {
        exit("No data available");
      }
    }

    public function create()
    { 
      $department_list = Department::all()->pluck('departmentname', 'departmentcode');
      $position_list = Position::all()->pluck('positionname', 'id'); 
      $employee_list = Employee::all()->pluck('employeename', 'id'); 

      return view ('editor.promotion.form', compact('department_list', 'position_list', 'employee_list'));
    }

    public function store(Request $request)
    { 
        DB::insert("INSERT INTO promotion (codetrans, notrans, datetrans)
                    SELECT 'MUTA',
                    IFNULL(CONCAT('MUTA','-',DATE_FORMAT(NOW(), '%d%m%y'),RIGHT((RIGHT(MAX(promotion.notrans),3))+1001,3)), CONCAT('MUTA','-',DATE_FORMAT(NOW(), '%d%m%y'),'001')), DATE(NOW())  
                    FROM
                    promotion
                    WHERE codetrans='MUTA'");

       $lastInsertedID = DB::table('promotion')->max('id');  

       // dd($lastInsertedID);

       $promotion = Promotion::where('id', $lastInsertedID)->first(); 
       $promotion->employeeid = $request->input('employeeid');
       $promotion->skno = $request->input('skno');
       $promotion->placementdate = Carbon::now();
       $promotion->requestdate = Carbon::now();
       $promotion->accepdate = Carbon::now();
       $promotion->currentpositionid = $request->input('currentpositionid'); 
       $promotion->nextpositionid = $request->input('nextpositionid'); 
       $promotion->currentdepartmentid = $request->input('currentdepartmentid'); 
       $promotion->nextdepartmentid = $request->input('nextdepartmentid'); 
       $promotion->requestby = $request->input('requestby'); 
       $promotion->accepby = $request->input('accepby'); 
       $promotion->knowby = $request->input('knowby'); 
       $promotion->created_by = Auth::id();
       $promotion->save();

       if($request->attachment)
       {
        $promotion = Document::FindOrFail($promotion->id);
        $original_directory = "uploads/promotion/";
        if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          } 
          $promotion->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
          $request->attachment->move($original_directory, $promotion->attachment);
          $promotion->save(); 
        } 
        return redirect('editor/promotion'); 
     
    }

    public function edit($id)
    {
      $department_list = Department::all()->pluck('departmentname', 'departmentcode');
      $position_list = Position::all()->pluck('positionname', 'id'); 
      $employee_list = Employee::all()->pluck('employeename', 'id'); 
      $promotion = Promotion::Where('id', $id)->first();   

      // dd($promotion); 
      return view ('editor.promotion.form', compact('promotion','department_list', 'position_list', 'employee_list'));
    }

    public function update($id, Request $request)
    {
      $promotion = Promotion::Find($id);
      $promotion->employeeid = $request->input('employeeid');
      $promotion->skno = $request->input('skno');
      $promotion->placementdate = Carbon::now();
      $promotion->requestdate = Carbon::now();
      $promotion->accepdate = Carbon::now();
      $promotion->currentpositionid = $request->input('currentpositionid'); 
      $promotion->nextpositionid = $request->input('nextpositionid'); 
      $promotion->currentdepartmentid = $request->input('currentdepartmentid'); 
      $promotion->nextdepartmentid = $request->input('nextdepartmentid'); 
      $promotion->requestby = $request->input('requestby'); 
      $promotion->accepby = $request->input('accepby'); 
      $promotion->knowby = $request->input('knowby'); 
      $promotion->status =  0; 
      $promotion->created_by = Auth::id();
      $promotion->save();

      if($request->attachment)
      {
        $promotion = Document::FindOrFail($promotion->id);
        $original_directory = "uploads/promotion/";
        if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          } 
          $promotion->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
          $request->attachment->move($original_directory, $promotion->attachment);
          $promotion->save(); 
        } 
        return redirect('editor/promotion');  
      }

      public function cancel($id, Request $request)
      {
        $mutation = Promotion::Find($id); 
        $mutation->status = 9; 
        $mutation->created_by = Auth::id();
        $mutation->save(); 
      
        return response()->json($mutation); 
      }

      public function delete($id)
      {
    //dd($id);
        $post =  Document::Find($id);
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

    public function slip($id)
    {
        $sql = 'SELECT
                  mutation.id,
                  mutation.notrans,
                  mutation.datetrans,
                  employee.employeename,
                  mutation.skno,
                  mutation.placementdate,
                  mutation.requestdate,
                  mutation.accepdate,
                  location.locationname AS curlocationname,
                  location_1.locationname AS nexlocationname,
                  mutation.requestby,
                  mutation.accepby,
                  mutation.attachment,
                  mutation.`status`,
                  mutation.created_by,
                  mutation.updated_by,
                  mutation.deleted_by,
                  mutation.created_at,
                  mutation.updated_at,
                  mutation.deleted_at 
                FROM
                  mutation
                  LEFT JOIN employee ON mutation.employeeid = employee.id
                  LEFT JOIN location ON mutation.currentlocationid = location.id
                  LEFT JOIN location AS location_1 ON mutation.nextlocationid = location_1.id
                WHERE
                  mutation.id = '.$id.''; 
        $mutation = DB::table(DB::raw("($sql) as rs_sql"))->first();

      return view ('editor.promotion.slip', compact('mutation'));
    }
  }
