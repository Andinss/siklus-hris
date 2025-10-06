<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PunishmentRequest;
use App\Http\Controllers\Controller;
use App\Models\Punishment; 
use App\Models\Employee; 
use App\Models\SkType;
use App\Models\Setupvariable; 
use Validator;
use Response;
use App\Post;
use View;

class PunishmentController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [
    'punishmentno' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
    'punishmentname' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $punishments = Punishment::all();
      return view ('editor.punishment.index', compact('punishments'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 

        $sql = 'SELECT
                  punishment.id,
                  punishment.no_trans,
                  DATE_FORMAT(punishment.date_trans, "%d-%m-%Y") AS date_trans,
                  punishment.employee_id,
                  employee.employee_name,
                  DATE_FORMAT(punishment.date_from, "%d-%m-%Y") AS date_from,
                  DATE_FORMAT(punishment.date_to, "%d-%m-%Y") AS date_to,
                  DATE_FORMAT(punishment.period_date, "%d-%m-%Y") AS period_date,
                  punishment.sk_type_id,
                  punishment.status, 
                  punishment.description,
                  sk_type.sk_type_name,
                  sk_type.slip,
                  punishment.attachment 
                FROM
                  punishment
                  LEFT JOIN employee ON punishment.employee_id = employee.id
                  LEFT JOIN sk_type ON punishment.sk_type_id = sk_type.id
                WHERE
                  punishment.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 


        return DataTables::of($itemdata) 

        ->addColumn('action', function ($itemdata) { 
            return '<a href="punishment/'.$itemdata->id.'/edit" title="Detail No: '."".$itemdata->no_trans."".'"  onclick="edit('."'".$itemdata->id."'".')" class="btn btn-sm btn-outline-primary d-inline-block"><i class="fas fa-pen"></i> Edit</a> <a href="javascript:void(0)" title="Delete" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->no_trans."'".')"> <i class="fas fa-trash-alt"></i> Delete</a>';
        })
        ->addColumn('approval', function ($itemdata) {
        return '<a  href="javascript:void(0)" title="Approval" class="btn btn-sm btn-success" onclick="approve_id('."'".$itemdata->id."', '".$itemdata->no_trans."'".')"><i class="fas fa-check"></i> Approve</a> <a  href="javascript:void(0)" title="Approval" class="btn btn-sm btn-warning" onclick="not_approve_id('."'".$itemdata->id."', '".$itemdata->no_trans."'".')"><i class="fas fa-times"></i> Not Approve</a>';
       })
        ->addColumn('attachment', function ($itemdata) {
          if ($itemdata->attachment == null) {
            return '';
          }else{
           return '<a href="'.asset("assets/uploads/punishment/".$itemdata->attachment).'" target="_blank"/><i class="fas fa-download"></i> Download</a>';
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
                  punishment.id,
                  punishment.no_trans,
                  punishment.date_trans,
                  employee.nik,
                  employee.employee_name,
                  punishment.date_from,
                  punishment.date_to,
                  sktype.sk_type_name
                FROM
                  punishment
                INNER JOIN employee ON punishment.employee_id = employee.id
                INNER JOIN sktype ON punishment.sk_type_id = sktype.id,
                 `user`
                WHERE
                  `user`.id = '.Auth::id().' AND punishment.employee_id = user.employee_id
                AND
                  punishment.deleted_at IS NULL AND DATE_FORMAT(now(), "%Y-%m-%d") BETWEEN punishment.date_from AND punishment.date_to';
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
      $sktype_list = SkType::all()->pluck('sk_type_name', 'id'); 
      $punishment_list = Punishment::all()->pluck('no_trans', 'id'); 

      return view ('editor.punishment.form', compact('employee_list', 'sktype_list', 'punishment_list'));
    }

    public function store(Request $request)
    { 
        DB::insert("INSERT INTO punishment (code_trans, no_trans, date_trans)
                    SELECT 'FORM/HR/GEN',
                    IFNULL(CONCAT('FORM/HR/GEN','/',RIGHT((RIGHT(MAX(punishment.no_trans),3))+1001,3)), CONCAT('FORM/HR/GEN','/','001')), DATE(NOW())  
                    FROM
                    punishment
                    WHERE code_trans='FORM/HR/GEN'");

       $lastInsertedID = DB::table('punishment')->max('id'); 

        $date_array_from = explode("-",$request->input('date_from')); // split the array
        $var_day_from = $date_array_from[0]; //day seqment
        $var_month_from = $date_array_from[1]; //month segment
        $var_year_from = $date_array_from[2]; //year segment
        $date_format_from = "$var_year_from-$var_month_from-$var_day_from"; // join them together


        $date_array_to = explode("-",$request->input('date_to')); // split the array
        $var_day_to = $date_array_to[0]; //day seqment
        $var_month_to = $date_array_to[1]; //month segment
        $var_year_to = $date_array_to[2]; //year segment
        $date_format_to = "$var_year_to-$var_month_to-$var_day_to"; // join them together


        // $date_array_period = explode("-",$request->input('period_date')); // split the array
        // $var_day_period = $date_array_period[0]; //day seqment
        // $var_month_period = $date_array_period[1]; //month segment
        // $var_year_period = $date_array_period[2]; //year segment
        // $date_format_period = "$var_year_period-$var_month_period-$var_day_period"; // join them together 

       $punishment = Punishment::where('id', $lastInsertedID)->first(); 
       $punishment->employee_id = $request->input('employee_id'); 
       $punishment->ref_no = $request->input('ref_no'); 
       // $punishment->period_date = $date_format_period; 
       $punishment->sk_type_id = $request->input('sk_type_id'); 
       $punishment->date_from = $date_format_from; 
       $punishment->date_to = $date_format_to;  
       $punishment->punishment_id = $request->input('punishment_id');  
       $punishment->violations_committed = $request->input('violations_committed');  
       $punishment->cooperation_agreement = $request->input('cooperation_agreement');  
       $punishment->status = 0;  
       $punishment->created_by = Auth::id();
       $punishment->save();

       if($request->attachment)
       {
        $punishment = Punishment::FindOrFail($punishment->id);
        $original_directory = "uploads/punishment/";
        if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          } 
          $punishment->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
          $request->attachment->move($original_directory, $punishment->attachment);
          $punishment->save(); 
        } 
        return redirect('editor/punishment'); 
    }

    public function edit($id)
    {
      $employee_list = Employee::all()->pluck('employee_name', 'id'); 
      $sktype_list = SkType::all()->pluck('sk_type_name', 'id'); 
      $punishment_list = Punishment::all()->pluck('no_trans', 'id'); 

      $punishment = Punishment::Where('id', $id)->first();   

      return view ('editor.punishment.form', compact('punishment','sktype_list', 'employee_list', 'punishment_list'));
    }

    public function update($id, Request $request)
    {

        $date_array_from = explode("-",$request->input('date_from')); // split the array
        $var_day_from = $date_array_from[0]; //day seqment
        $var_month_from = $date_array_from[1]; //month segment
        $var_year_from = $date_array_from[2]; //year segment
        $date_format_from = "$var_year_from-$var_month_from-$var_day_from"; // join them together


        $date_array_to = explode("-",$request->input('date_to')); // split the array
        $var_day_to = $date_array_to[0]; //day seqment
        $var_month_to = $date_array_to[1]; //month segment
        $var_year_to = $date_array_to[2]; //year segment
        $date_format_to = "$var_year_to-$var_month_to-$var_day_to"; // join them together


        $date_array_period = explode("-",$request->input('period_date')); // split the array
        $var_day_period = $date_array_period[0]; //day seqment
        $var_month_period = $date_array_period[1]; //month segment
        $var_year_period = $date_array_period[2]; //year segment
        $date_format_period = "$var_year_period-$var_month_period-$var_day_period"; // join them together

      
       $punishment = Punishment::FindOrFail($id); 
       $punishment->employee_id = $request->input('employee_id'); 
       $punishment->ref_no = $request->input('ref_no'); 
       $punishment->period_date = $date_format_period; 
       $punishment->sk_type_id = $request->input('sk_type_id'); 
       $punishment->date_from = $date_format_from; 
       $punishment->date_to = $date_format_to;  
       $punishment->punishment_id = $request->input('punishment_id');  
       $punishment->violations_committed = $request->input('violations_committed');  
       $punishment->cooperation_agreement = $request->input('cooperation_agreement');
       $punishment->description = $request->input('description');
       $punishment->status = 0;  
       $punishment->created_by = Auth::id();
       $punishment->save();

      if($request->attachment)
      {
        $punishment = Punishment::FindOrFail($punishment->id);
        $original_directory = "uploads/punishment/";
        if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          } 
          $punishment->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
          $request->attachment->move($original_directory, $punishment->attachment);
          $punishment->save(); 
        } 
        return redirect('editor/punishment');  
      }

      public function cancel($id, Request $request)
      {
        $mutation = Punishment::Find($id); 
        $mutation->status = 9; 
        $mutation->created_by = Auth::id();
        $mutation->save(); 
      
        return response()->json($mutation); 

      }

      public function delete($id)
      {
    //dd($id);
        $post =  Punishment::Find($id);
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

    public function teguran($id)
       { 
        $sql = 'SELECT
                  punishment.id,
                  punishment.no_trans,
                  DATE_FORMAT(punishment.date_trans, "%d-%m-%Y") AS date_trans,
                  punishment.employee_id,
                  employee.nik,
                  employee.employee_name,
                  DATE_FORMAT(employee.joindate, "%d-%m-%Y") AS joindate,
                  DATE_FORMAT(punishment.date_from, "%d-%m-%Y") AS date_from,
                  DATE_FORMAT(punishment.date_to, "%d-%m-%Y") AS date_to,
                  punishment.sk_type_id,
                  punishment.status, 
                  punishment.description,
                  position.positionname,
                  department.departmentname,
                  punishment.violations_committed,
                  punishment.cooperation_agreement,
                  sktype.sk_type_name,
                  sktype.slip,
                  positiongroup.positiongroupname,
                  punishment.attachment 
                FROM
                  punishment
                  LEFT JOIN employee ON punishment.employee_id = employee.id
                  LEFT JOIN sktype ON punishment.sk_type_id = sktype.id
                  LEFT JOIN department ON employee.departmentid = department.id
                  LEFT JOIN position ON employee.positionid = position.id
                  LEFT JOIN positiongroup ON employee.positiongroupid = positiongroup.id
                WHERE
                punishment.id ='.$id.'';
        $punishment = DB::table(DB::raw("($sql) as rs_sql"))->first(); 

        $setupvariable = Setupvariable::first();

        return view ('editor.punishment.teguran', compact('punishment', 'setupvariable'));
      }

      public function sp1($id)
       { 
        $sql = 'SELECT
                  punishment.id,
                  punishment.no_trans,
                  DATE_FORMAT(punishment.date_trans, "%d-%m-%Y") AS date_trans,
                  punishment.employee_id,
                  employee.nik,
                  employee.employee_name,
                  DATE_FORMAT(employee.joindate, "%d-%m-%Y") AS joindate,
                  DATE_FORMAT(punishment.date_from, "%d-%m-%Y") AS date_from,
                  DATE_FORMAT(punishment.date_to, "%d-%m-%Y") AS date_to,
                  DATE_FORMAT(punishment.period_date, "%d-%m-%Y") AS period_date,
                  punishment.sk_type_id,
                  punishment.status, 
                  punishment.description,
                  position.positionname,
                  department.departmentname,
                  punishment.violations_committed,
                  punishment.cooperation_agreement,
                  sktype.sk_type_name,
                  sktype.slip,
                  positiongroup.positiongroupname,
                  punishment.attachment 
                FROM
                  punishment
                  LEFT JOIN employee ON punishment.employee_id = employee.id
                  LEFT JOIN sktype ON punishment.sk_type_id = sktype.id
                  LEFT JOIN department ON employee.departmentid = department.id
                  LEFT JOIN position ON employee.positionid = position.id
                  LEFT JOIN positiongroup ON employee.positiongroupid = positiongroup.id

                WHERE
                punishment.id ='.$id.'';
        $punishment = DB::table(DB::raw("($sql) as rs_sql"))->first(); 

        $setupvariable = Setupvariable::first();

        return view ('editor.punishment.sp1', compact('punishment', 'setupvariable'));
      }

      public function sp2($id)
       { 
        $sql = 'SELECT
                  punishment.id,
                  punishment.no_trans,
                  DATE_FORMAT(punishment.date_trans, "%d-%m-%Y") AS date_trans,
                  punishment.employee_id,
                  employee.nik,
                  employee.employee_name,
                  DATE_FORMAT(employee.joindate, "%d-%m-%Y") AS joindate,
                  DATE_FORMAT(punishment.date_from, "%d-%m-%Y") AS date_from,
                  DATE_FORMAT(punishment.date_to, "%d-%m-%Y") AS date_to,
                  DATE_FORMAT(punishment.period_date, "%d-%m-%Y") AS period_date,
                  punishment.sk_type_id,
                  punishment.status, 
                  punishment.description,
                  position.positionname,
                  department.departmentname,
                  punishment.violations_committed,
                  punishment.cooperation_agreement,
                  sktype.sk_type_name, 
                  sktype.slip,
                  punishment.attachment 
                FROM
                  punishment
                  LEFT JOIN employee ON punishment.employee_id = employee.id
                  LEFT JOIN sktype ON punishment.sk_type_id = sktype.id
                  LEFT JOIN department ON employee.departmentid = department.id
                  LEFT JOIN position ON employee.positionid = position.id
                WHERE
                punishment.id ='.$id.'';
        $punishment = DB::table(DB::raw("($sql) as rs_sql"))->first(); 

        $setupvariable = Setupvariable::first();

        return view ('editor.punishment.sp2', compact('punishment', 'setupvariable'));
      }


      public function sp3($id)
       { 
        $sql = 'SELECT
                  punishment.id,
                  punishment.no_trans,
                  DATE_FORMAT(punishment.date_trans, "%d-%m-%Y") AS date_trans,
                  punishment.employee_id,
                  employee.nik,
                  employee.employee_name,
                  DATE_FORMAT(employee.joindate, "%d-%m-%Y") AS joindate,
                  DATE_FORMAT(punishment.date_from, "%d-%m-%Y") AS date_from,
                  DATE_FORMAT(punishment.date_to, "%d-%m-%Y") AS date_to,
                  DATE_FORMAT(punishment.period_date, "%d-%m-%Y") AS period_date,
                  punishment.sk_type_id,
                  punishment.status, 
                  punishment.description,
                  position.positionname,
                  department.departmentname,
                  punishment.violations_committed,
                  punishment.cooperation_agreement,
                  sktype.sk_type_name,
                  sktype.slip,
                  punishment.attachment 
                FROM
                  punishment
                  LEFT JOIN employee ON punishment.employee_id = employee.id
                  LEFT JOIN sktype ON punishment.sk_type_id = sktype.id
                  LEFT JOIN department ON employee.departmentid = department.id
                  LEFT JOIN position ON employee.positionid = position.id
                WHERE
                punishment.id ='.$id.'';
        $punishment = DB::table(DB::raw("($sql) as rs_sql"))->first(); 

        $setupvariable = Setupvariable::first();

        return view ('editor.punishment.sp3', compact('punishment', 'setupvariable'));
      }
  }
