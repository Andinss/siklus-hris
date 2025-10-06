<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\TrainingRequest;
use App\Http\Controllers\Controller;
use App\Models\Training; 
use App\Models\TrainingType; 
use App\Models\Employee; 
use App\Models\EducationType;
use App\Models\TrainingProvider;
use App\Models\TrainingInstructor;
use App\Models\TrainingVenue;
use App\Models\TrainingDet;
use Validator;
use Response;
use App\Post;
use View;

class TrainingController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [
    'trainingno' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
    'trainingname' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $trainings = Training::all();
      return view ('editor.training.index', compact('trainings'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 

        $sql = 'SELECT
                  training.id,
                  training.no_trans,
                  DATE_FORMAT(
                    training.date_trans,
                    "%d-%m-%Y"
                  ) AS date_trans,
                  training.employee_id,
                  employee.employee_name,
                  DATE_FORMAT(
                    training.training_from,
                    "%d-%m-%Y"
                  ) AS training_from,
                  DATE_FORMAT(
                    training.training_to,
                    "%d-%m-%Y"
                  ) AS training_to,
                  training.time_in,
                  training.time_out,
                  training.education_type_id,
                  education_type.education_type_name,
                  training.training_type_id,
                  training.training_section,
                  training.audience_type,
                  training.provider_type,
                  training_type.training_type_name,
                  training.fasilitator,
                  training.certified,
                  training.days,
                  training.status,
                  training.attachment,
                  FORMAT(training.cost, 0) AS cost,
                  training.training_provider_id,
                  training_provider.training_provider_name,
                  training.training_instructor_id,
                  training_instructor.training_instructor_name,
                  training.training_venue_id,
                  training.training_venue,
                  training_venue.training_venue_name
                FROM
                  training
                LEFT JOIN employee ON training.employee_id = employee.id
                LEFT JOIN education_type ON training.education_type_id = education_type.id
                LEFT JOIN training_provider ON training.training_provider_id = training_provider.id
                LEFT JOIN training_instructor ON training.training_instructor_id = training_provider.id
                LEFT JOIN training_venue ON training.training_venue_id = training_venue.id
                LEFT JOIN training_type ON training.training_type_id = training_type.id
                WHERE
                  training.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

        return DataTables::of($itemdata)  
        ->addColumn('action', function ($itemdata) { 
            if ($itemdata->status == 1 || $itemdata->status == 2) {
                return '<a href="training/'.$itemdata->id.'/edit" title="Detail No: '."".$itemdata->no_trans."".'"  onclick="edit('."'".$itemdata->id."'".')" class="btn btn-sm btn-outline-primary d-inline-block"><i class="fas fa-pen"></i> Edit</a> <a href="javascript:void(0)" title="Delete" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->no_trans."'".')"> <i class="fas fa-trash-alt"></i> Delete</a>';
              }else{
                return '<a href="training/'.$itemdata->id.'/edit" title="Detail No: '."".$itemdata->no_trans."".'"  onclick="edit('."'".$itemdata->id."'".')" class="btn btn-sm btn-outline-primary d-inline-block"><i class="fas fa-pen"></i> Edit</a> <a href="javascript:void(0)" title="Delete" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->no_trans."'".')"> <i class="fas fa-trash-alt"></i> Delete</a>';
            };  
         })
         
        ->addColumn('approval', function ($itemdata) {
          return '<a  href="javascript:void(0)" title="Approval" class="btn btn-sm btn-success d-inline-block" onclick="approve_id('."'".$itemdata->id."', '".$itemdata->no_trans."'".')"><i class="fas fa-check"></i> Approve</a> <a href="javascript:void(0)" title="Approval" class="btn btn-sm btn-warning d-inline-block" onclick="not_approve_id('."'".$itemdata->id."', '".$itemdata->no_trans."'".')"><i class="fas fa-times"></i> Not Approve</a>';
        })
        ->addColumn('attachment', function ($itemdata) {
          if ($itemdata->attachment == null) {
            return '';
            }else{
             return '<a href="'.asset("assets/uploads/training/".$itemdata->attachment).'" target="_blank"/><i class="fa fa-download"></i> Download</a>';
           };  
          })
        ->toJson();
      } else {
        exit("No data available");
      }
    }


    public function dataparticipant(Request $request, $id)
    {   
      if($request->ajax()){ 

        $sql = 'SELECT
                  training_det.id,
                  employee.nik,
                  employee.employee_name
                FROM
                  training_det
                INNER JOIN employee ON training_det.employee_id = employee.id
                WHERE training_det.trans_id = '.$id.' AND training_det.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 


        return Datatables::of($itemdata) 

        ->addColumn('action', function ($itemdata) {
          return '<a  href="javascript:void(0)" title="Delete" class="btn btn-danger btn-xs" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->employee_name."'".')"><i class="fa fa-trash"></i></a>';
        })

        ->make(true);
      } else {
        exit("No data available");
      }
    }

    public function create()
    {   
      return view ('editor.training.form');
    }

    public function store(Request $request)
    { 
        DB::insert("INSERT INTO training (code_trans, no_trans, date_trans)
                    SELECT 'TRAINING',
                    IFNULL(CONCAT('TRAINING','-',DATE_FORMAT(NOW(), '%Y%m%d'),RIGHT((RIGHT(MAX(training.no_trans),3))+1001,3)), CONCAT('TRAINING','-',DATE_FORMAT(NOW(), '%Y%m%d'),'001')), DATE(NOW())  
                    FROM
                    training
                    WHERE code_trans='TRAINING'");

       $lastInsertedID = DB::table('training')->max('id');   


      return redirect('editor/training/'.$lastInsertedID.'/edit'); 
     
    }

    public function savedetail($id, Request $request)
    { 
        $post = new TrainingDet;
        $post->trans_id = $id;  
        $post->employee_id = $request->employee_id;   
        $post->save();

        return response()->json($post); 
    }

    public function edit($id)
    {
      
      $employee_list = Employee::all()->pluck('employee_name', 'id'); 
      $education_type_list = EducationType::all()->pluck('education_type_name', 'id'); 
      $training_provider_list = TrainingProvider::all()->pluck('training_provider_name', 'id'); 
      $training_instructor_list = TrainingInstructor::all()->pluck('training_instructor_name', 'id'); 
      $training_venue_list = TrainingVenue::all()->pluck('training_venue_name', 'id'); 
      $training_type_list = TrainingType::all()->pluck('training_type_name', 'id'); 
      $training = Training::Where('id', $id)->first();   
 
      return view ('editor.training.form', compact('training','education_type_list', 'employee_list', 'training_provider_list', 'training_instructor_list', 'training_venue_list', 'training_type_list'));
    }

    public function update($id, Request $request)
    { 

        $date_array_from = explode("-",$request->input('training_from')); // split the array
        $var_day_from = $date_array_from[0]; //day seqment
        $var_month_from = $date_array_from[1]; //month segment
        $var_year_from = $date_array_from[2]; //year segment
        $date_format_from = "$var_year_from-$var_month_from-$var_day_from"; // join them together

        $date_array_to = explode("-",$request->input('training_to')); // split the array
        $var_day_to = $date_array_to[0]; //day seqment
        $var_month_to = $date_array_to[1]; //month segment
        $var_year_to = $date_array_to[2]; //year segment
        $date_format_to = "$var_year_to-$var_month_to-$var_day_to"; // join them together
       
       $training = Training::FindOrFail($id); 
       $training->employee_id = $request->input('employee_id'); 
       $training->education_type_id = $request->input('education_type_id'); 
       $training->training_type_id = $request->input('training_type_id'); 
       $training->training_from = $date_format_from; 
       $training->training_to = $date_format_to;  
       $training->cost = str_replace(",","",$request->input('cost'));   
       $training->time_in = $request->input('time_in');  
       $training->time_out = $request->input('time_out');  
       $training->training_venue = $request->input('training_venue');  
       $training->days = $request->input('days');  
       $training->certified = $request->input('certified');  
       $training->fasilitator = $request->input('fasilitator'); 
       $training->training_provider_id = $request->input('training_provider_id');  
       $training->training_instructor_id = $request->input('training_instructor_id');  
       $training->training_venue_id = $request->input('training_venue_id');  
       $training->provider_type = $request->input('provider_type');  
       $training->audience_type = $request->input('audience_type');  
       $training->status = 0;  
       $training->created_by = Auth::id();
       $training->save();

      if($request->attachment)
      {
        $training = Training::FindOrFail($training->id);
        $original_directory = "uploads/training/";
        if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          } 
          $training->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
          $request->attachment->move($original_directory, $training->attachment);
          $training->save(); 
        } 
        return redirect('editor/training');  
      }

      public function cancel($id, Request $request)
      {
        $post = Training::Find($id); 
        $post->status = 9; 
        $post->created_by = Auth::id();
        $post->save(); 
      
        return response()->json($post); 
      }

      public function delete($id)
      {
        $post =  Training::Find($id);
        $post->delete(); 

        return response()->json($post); 
      }

       public function deletedet($id)
      {
        $post =  Trainingdet::Find($id);
        $post->delete(); 

        return response()->json($post); 
      }

  }
