<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\RecruitmentRequest;
use App\Http\Controllers\Controller;
use App\Models\Recruitment; 
use App\Models\Employee; 
use App\Models\Location;
use App\Models\Department;
use App\Models\Position;
use App\Models\Staffstatus;
use App\Models\Employeestatus;
use App\Models\Positiongroup;
use App\Models\Golongan;
use App\Models\Educationlevel;
use App\Models\Maritalstatus;
use Validator;
use Response;
use App\Post;
use View;

class RecruitmentController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [
    'recruitmentno' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
    'recruitmentname' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $recruitments = Recruitment::all();
      return view ('editor.recruitment.index', compact('recruitments'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 

        $sql = 'SELECT
                  recruitment.id,
                  recruitment.codetrans,
                  recruitment.notrans,
                  recruitment.datetrans,
                  recruitment.recfrom,
                  recruitment.recto,
                  position.positionname,
                  recruitment.costcenter,
                  recruitment.vacancyno,
                  recruitment.employeestatusid,
                  recruitment.staffstatusid,
                  staffstatus.staffstatusname,
                  recruitment.attachment,
                  recruitment.requirement,
                  employeestatus.employeestatusname,
                  recruitment.status
                FROM
                  recruitment
                LEFT JOIN position ON recruitment.positionid = position.id
                LEFT JOIN staffstatus ON recruitment.staffstatusid = staffstatus.id
                LEFT JOIN employeestatus ON recruitment.staffstatusid = employeestatus.id
                WHERE
                  recruitment.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 


        return Datatables::of($itemdata) 

        ->addColumn('attachment', function ($itemdata) {
          if ($itemdata->attachment == null) {
            return '';
          }else{
           return '<a href="../uploads/recruitment/'.$itemdata->attachment.'" target="_blank"/><i class="fa fa-download"></i> Download</a>';
         };  
        }) 
        
        ->addColumn('action', function ($itemdata) { 
            return '<a href="recruitment/'.$itemdata->id.'/edit" title="Detail No: '."".$itemdata->notrans."".'"  onclick="edit('."'".$itemdata->id."'".')" class="btn btn-detail btn-xs btn-flat"><i class="fa fa-book"></i> Detail</a>';
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
                  recruitment.id,
                  recruitment.notrans,
                  recruitment.datetrans,
                  employee.employeename,
                  recruitment.skno,
                  recruitment.placementdate,
                  recruitment.requestdate,
                  recruitment.accepdate,
                  location.locationname AS curlocationname,
                  location_1.locationname AS nexlocationname,
                  recruitment.requestby
                FROM
                  recruitment
                LEFT JOIN employee ON recruitment.employeeid = employee.id
                LEFT JOIN location ON recruitment.currentlocationid = location.id
                LEFT JOIN location AS location_1 ON recruitment.nextlocationid = location_1.id,
                 `user`
                WHERE
                  `user`.id = '.Auth::id().' AND recruitment.employeeid = user.employeeid
                AND
                  recruitment.deleted_at IS NULL';
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
      $location_list = Location::all()->pluck('locationname', 'id'); 
      $employee_list = Employee::all()->pluck('employeename', 'id'); 
      $employeestatus_list = Employeestatus::all()->pluck('employeestatusname', 'id'); 
      $staffstatus_list = Staffstatus::all()->pluck('staffstatusname', 'id'); 
      $position_list = Position::all()->pluck('positionname', 'id'); 
      $positiongroup_list = Positiongroup::all()->pluck('positiongroupname', 'id'); 
      $golongan_list = Golongan::all()->pluck('golonganname', 'id'); 
      $department_list = Department::all()->pluck('departmentname', 'id'); 
      $educationlevel_list = Educationlevel::all()->pluck('educationlevelname', 'id'); 
      $maritalstatus_list = Maritalstatus::all()->pluck('maritalstatusname', 'maritalstatusname'); 
      $assign_list = Employee::all()->pluck('employeename', 'employeename'); 

      $sql = 'SELECT "Laki-Laki" AS a
              UNION ALL
              SELECT "Prempuan" AS a
              UNION ALL
              SELECT "Laki-Laki atau Prempuan" AS a';
      $gender_list = DB::table(DB::raw("($sql) as rs_sql"))->get()->pluck('a', 'a'); 

      $sql_requesttype = 'SELECT "Penambahan" AS a
              UNION ALL
              SELECT "Penggantian" AS a ';
      $requesttype_list = DB::table(DB::raw("($sql_requesttype) as rs_sql"))->get()->pluck('a', 'a'); 

      return view ('editor.recruitment.form', compact('department_list', 'location_list', 'employee_list', 'employeestatus_list', 'staffstatus_list', 'position_list', 'gender_list', 'positiongroup_list', 'golongan_list', 'department_list', 'educationlevel_list', 'requesttype_list', 'maritalstatus_list', 'assign_list'));
    }

    public function store(Request $request)
    { 
        DB::insert("INSERT INTO recruitment (codetrans, notrans, datetrans)
                    SELECT 'MUTA',
                    IFNULL(CONCAT('MUTA','-',DATE_FORMAT(NOW(), '%d%m%y'),RIGHT((RIGHT(MAX(recruitment.notrans),3))+1001,3)), CONCAT('MUTA','-',DATE_FORMAT(NOW(), '%d%m%y'),'001')), DATE(NOW())  
                    FROM
                    recruitment
                    WHERE codetrans='MUTA'");

       $lastInsertedID = DB::table('recruitment')->max('id');  

       // dd($lastInsertedID);

        $recruitment = Recruitment::where('id', $lastInsertedID)->first(); 
        $recruitment->datetrans = $request->input('datetrans');
        $recruitment->recfrom = $request->input('recfrom');
        $recruitment->recto = $request->input('recto');   
        $recruitment->positionid = $request->input('positionid');   
        $recruitment->staffstatusid = $request->input('staffstatusid');   
        $recruitment->employeestatusid = $request->input('employeestatusid');   
        $recruitment->costcenter = $request->input('costcenter');   
        $recruitment->vacancyno = $request->input('vacancyno');   
        $recruitment->requirement = $request->input('requirement');   
        $recruitment->jobdesc = $request->input('jobdesc');   
        $recruitment->placement = $request->input('placement');   
        $recruitment->location = $request->input('location');   
        $recruitment->city = $request->input('city');   
        $recruitment->contactperson = $request->input('contactperson');   
        $recruitment->email = $request->input('email');   
        $recruitment->phone = $request->input('phone'); 
        $recruitment->requestby = $request->input('requestby'); 
        $recruitment->acceptby = $request->input('acceptby'); 
        $recruitment->knowby = $request->input('knowby'); 
        $recruitment->gender = $request->input('gender'); 
        $recruitment->workstart = $request->input('workstart'); 
        $recruitment->departmentid = $request->input('departmentid'); 
        $recruitment->positiongroupid = $request->input('positiongroupid'); 
        $recruitment->golonganid = $request->input('golonganid'); 
        $recruitment->requesttype = $request->input('requesttype'); 
        $recruitment->maritalstatus = $request->input('maritalstatus'); 
        $recruitment->costallocation = $request->input('costallocation'); 
        $recruitment->quantity = $request->input('quantity'); 
        $recruitment->rangeage = $request->input('rangeage'); 
        $recruitment->recruitmentreason = $request->input('recruitmentreason');   
        $recruitment->status = 1; 
        $recruitment->created_by = Auth::id();
        $recruitment->save();

       if($request->attachment)
       {
        $recruitment = Recruitment::FindOrFail($recruitment->id);
        $original_directory = "uploads/recruitment/";
        if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          } 
          $recruitment->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
          $request->attachment->move($original_directory, $recruitment->attachment);
          $recruitment->save(); 
        } 
        return redirect('editor/recruitment'); 
     
    }

    public function edit($id)
    {
      $department_list = Department::all()->pluck('departmentname', 'departmentcode');
      $location_list = Location::all()->pluck('locationname', 'id'); 
      $position_list = Position::all()->pluck('positionname', 'id'); 
      $employeestatus_list = Employeestatus::all()->pluck('employeestatusname', 'id'); 
      $staffstatus_list = Staffstatus::all()->pluck('staffstatusname', 'id'); 
      $positiongroup_list = Positiongroup::all()->pluck('positiongroupname', 'id'); 
      $golongan_list = Golongan::all()->pluck('golonganname', 'id'); 
      $department_list = Department::all()->pluck('departmentname', 'id'); 
      $educationlevel_list = Educationlevel::all()->pluck('educationlevelname', 'id'); 
      $maritalstatus_list = Maritalstatus::all()->pluck('maritalstatusname', 'maritalstatusname'); 
      $assign_list = Employee::all()->pluck('employeename', 'employeename'); 



      $sql = 'SELECT "Laki-Laki" AS a
              UNION ALL
              SELECT "Prempuan" AS a
              UNION ALL
              SELECT "Laki-Laki atau Prempuan" AS a';
      $gender_list = DB::table(DB::raw("($sql) as rs_sql"))->get()->pluck('a', 'a'); 

      $sql_requesttype = 'SELECT "Penambahan" AS a
              UNION ALL
              SELECT "Penggantian" AS a ';
      $requesttype_list = DB::table(DB::raw("($sql_requesttype) as rs_sql"))->get()->pluck('a', 'a'); 

      $recruitment = Recruitment::Where('id', $id)->first();   

      // dd($recruitment); 
      return view ('editor.recruitment.form', compact('recruitment','department_list', 'location_list', 'position_list', 'employeestatus_list', 'staffstatus_list', 'gender_list', 'positiongroup_list', 'golongan_list', 'department_list', 'educationlevel_list', 'requesttype_list', 'maritalstatus_list', 'assign_list'));
    }

    public function update($id, Request $request)
    {
      $recruitment = Recruitment::Find($id);
      $recruitment->datetrans = $request->input('datetrans');
      $recruitment->recfrom = $request->input('recfrom');
      $recruitment->recto = $request->input('recto');   
      $recruitment->positionid = $request->input('positionid');   
      $recruitment->staffstatusid = $request->input('staffstatusid');   
      $recruitment->employeestatusid = $request->input('employeestatusid');   
      $recruitment->costcenter = $request->input('costcenter');   
      $recruitment->vacancyno = $request->input('vacancyno');   
      $recruitment->requirement = $request->input('requirement');   
      $recruitment->jobdesc = $request->input('jobdesc');   
      $recruitment->placement = $request->input('placement');   
      $recruitment->location = $request->input('location');   
      $recruitment->city = $request->input('city');   
      $recruitment->contactperson = $request->input('contactperson');   
      $recruitment->email = $request->input('email');   
      $recruitment->phone = $request->input('phone');   
      $recruitment->requestby = $request->input('requestby'); 
      $recruitment->acceptby = $request->input('acceptby'); 
      $recruitment->knowby = $request->input('knowby'); 
      $recruitment->gender = $request->input('gender'); 
      $recruitment->workstart = $request->input('workstart'); 
      $recruitment->departmentid = $request->input('departmentid'); 
      $recruitment->positiongroupid = $request->input('positiongroupid'); 
      $recruitment->golonganid = $request->input('golonganid'); 
      $recruitment->requesttype = $request->input('requesttype'); 
      $recruitment->maritalstatus = $request->input('maritalstatus'); 
      $recruitment->costallocation = $request->input('costallocation'); 
      $recruitment->quantity = $request->input('quantity'); 
      $recruitment->rangeage = $request->input('rangeage');   
      $recruitment->recruitmentreason = $request->input('recruitmentreason');   
      $recruitment->status = 1; 
      $recruitment->created_by = Auth::id();
      $recruitment->save();

      if($request->attachment)
      {
        $recruitment = Recruitment::FindOrFail($recruitment->id);
        $original_directory = "uploads/recruitment/";
        if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          } 
          $recruitment->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
          $request->attachment->move($original_directory, $recruitment->attachment);
          $recruitment->save(); 
        } 
        return redirect('editor/recruitment');  
      }

      public function delete($id)
      {
    //dd($id);
        $post =  Recruitment::Find($id);
        $post->delete(); 

        return response()->json($post); 
      }

      public function cancel($id, Request $request)
      {
        $recruitment = Recruitment::Find($id); 
        $recruitment->status = 9; 
        $recruitment->created_by = Auth::id();
        $recruitment->save(); 
      
        return response()->json($recruitment); 

      }

      public function deletebulk(Request $request)
      {

       $idkey = $request->idkey;    

       foreach($idkey as $key => $id)
       {
    // $post =  Recruitment::where('id', $id["1"])->get();
        $post = Recruitment::Find($id["1"]);
        $post->delete(); 
      }

      echo json_encode(array("status" => TRUE));

    }

    public function slip($id)
    {
        $sql = 'SELECT
                  recruitment.id,
                  recruitment.notrans,
                  recruitment.datetrans,
                  employee.employeename,
                  recruitment.skno,
                  recruitment.placementdate,
                  recruitment.requestdate,
                  recruitment.accepdate,
                  location.locationname AS curlocationname,
                  location_1.locationname AS nexlocationname,
                  recruitment.requestby,
                  recruitment.accepby,
                  recruitment.attachment,
                  recruitment.`status`,
                  recruitment.created_by,
                  recruitment.updated_by,
                  recruitment.deleted_by,
                  recruitment.created_at,
                  recruitment.updated_at,
                  recruitment.deleted_at 
                FROM
                  recruitment
                  LEFT JOIN employee ON recruitment.employeeid = employee.id
                  LEFT JOIN location ON recruitment.currentlocationid = location.id
                  LEFT JOIN location AS location_1 ON recruitment.nextlocationid = location_1.id
                WHERE
                  recruitment.id = '.$id.''; 
        $recruitment = DB::table(DB::raw("($sql) as rs_sql"))->first();

      return view ('editor.recruitment.slip', compact('recruitment'));
    }
  }
