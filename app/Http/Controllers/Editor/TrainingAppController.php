<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\TrainingRequest;
use App\Http\Controllers\Controller;
use App\Models\Training; 
use App\Models\Employee; 
use App\Models\Educationtype;
use Validator;
use Response;
use App\Post;
use View;

class TrainingappController extends Controller
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
      return view ('editor.trainingapp.index', compact('trainings'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 

      $sql = 'SELECT
                  training.id,
                  training.notrans,
                  DATE_FORMAT(
                    training.datetrans,
                    "%d-%m-%Y"
                  ) AS datetrans,
                  training.employeeid,
                  employee.employeename,
                  DATE_FORMAT(
                    training.trainingfrom,
                    "%d-%m-%Y"
                  ) AS trainingfrom,
                  DATE_FORMAT(
                    training.trainingto,
                    "%d-%m-%Y"
                  ) AS trainingto,
                  training.educationtypeid,
                  educationtype.educationtypename,
                  training.fasilitator,
                  training.certified,
                  training.days,
                  training.`status`,
                  training.attachment,
                  training.itemcost,
                  FORMAT(training.cost, 0) AS cost,
                  training.trainingproviderid,
                  trainingprovider.trainingprovidercode,
                  trainingprovider.trainingprovidername,
                  training.traininginstructorid,
                  traininginstructor.traininginstructorname,
                  training.trainingvenueid,
                  trainingvenue.trainingvenuecode,
                  trainingvenue.trainingvenuename
                FROM
                  training
                LEFT JOIN employee ON training.employeeid = employee.id
                LEFT JOIN educationtype ON training.educationtypeid = educationtype.id
                LEFT JOIN trainingprovider ON training.trainingproviderid = trainingprovider.id
                LEFT JOIN traininginstructor ON training.traininginstructorid = trainingprovider.id
                LEFT JOIN trainingvenue ON training.trainingvenueid = trainingvenue.id
                WHERE
                  training.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 


        return Datatables::of($itemdata)  

         ->addColumn('action', function ($itemdata) { 
            return '<a href="training/'.$itemdata->id.'/edit" title="Detail No: '."".$itemdata->notrans."".'"  onclick="edit('."'".$itemdata->id."'".')" class="btn btn-detail btn-xs btn-flat"><i class="fa fa-book"></i> Detail</a>';
        })
        
        ->addColumn('approval', function ($itemdata) {
          if ($itemdata->status == 0) {
               return '<a  href="javascript:void(0)" title="Approval" class="btn btn-success btn-xs btn-flat" onclick="approve_id('."'".$itemdata->id."', '".$itemdata->notrans."'".')"><i class="fa fa-check"></i> Approve</a> <a  href="javascript:void(0)" title="Approval" class="btn btn-warning btn-xs btn-flat" onclick="not_approve_id('."'".$itemdata->id."', '".$itemdata->notrans."'".')"><i class="fa fa-close"></i> Not Approve</a>';
          }else{
              return 'Validated!';
          };

        })

       ->addColumn('mstatus', function ($itemdata) {
          if ($itemdata->status == 0) {
            return '<span class="label label-warning"> Open </span>';
          }else if ($itemdata->status == 2){
           return '<span class="label label-danger"> Not Approve </span>';
        }else if ($itemdata->status == 1){
           return '<span class="label label-success"> Approve </span>';
         };

       })
 
        ->addColumn('attachment', function ($itemdata) {
          if ($itemdata->attachment == null) {
            return '';
          }else{
           return '<a href="../uploads/training/'.$itemdata->attachment.'" target="_blank"/><i class="fa fa-download"></i> Download</a>';
         };  
        })
        ->make(true);
      } else {
        exit("No data available");
      }
    }

     public function approve($id, Request $request)
    { 
        $post = Training::Find($id); 
        $post->status = 1;  
        $post->save();

        return response()->json($post);  
    }

    public function notapprove($id, Request $request)
    { 
        $post = Training::Find($id); 
        $post->status = 2;  
        $post->save();

        return response()->json($post);  
    }

  }
