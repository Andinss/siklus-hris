<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ApplicantRequest;
use App\Http\Controllers\Controller;
use App\Models\Applicant; 
use App\Models\Employee; 
use App\Models\Location;
use App\Models\Department;
use App\Models\Position;
use App\Models\Staffstatus;
use App\Models\Employeestatus;
use App\Models\Religion;
use App\Models\Maritalstatus;
use App\Models\City;
use App\Models\Recruitment;
use App\Models\Sourcecategory;
use App\Models\Sourcemedia;
use App\Models\Educationlevel;
use App\Models\Educationmajor;
use Validator;
use Response;
use App\Post;
use View;

class ApplicantController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [
    'applicantno' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
    'applicantname' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $applicants = Applicant::all();
      return view ('editor.applicant.index', compact('applicants'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 

        $sql = 'SELECT
        applicant.id,
        applicant.codetrans,
        applicant.notrans,
        applicant.datetrans,
        applicant.firstname,
        applicant.middlename,
        applicant.lastname,
        applicant.placebirth,
        applicant.datebirth,
        applicant.religionid,
        applicant.maritalstatus,
        applicant.addresstype,
        applicant.address,
        applicant.subdistrict,
        applicant.district,
        applicant.cityid,
        applicant.country,
        applicant.zipcode,
        applicant.phone,
        applicant.idcardnumber,
        applicant.sourcemedia,
        applicant.region,
        recruitment.notrans AS notransrec,
        position.positionname,
        applicant.applydate,
        applicant.source,
        applicant.progress,
        applicant.attachment,
        applicant.photo,
        applicant.remark,
        applicant.prescreeningdate,
        applicant.psychotestdate,
        applicant.technicaltestdate,
        applicant.interviewhrdate,
        applicant.interviewuserdate,
        applicant.`status`
        FROM
        applicant
        LEFT JOIN recruitment ON applicant.recruitmentid = recruitment.id
        LEFT JOIN position ON recruitment.positionid = position.id
        WHERE
        applicant.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 


        return Datatables::of($itemdata) 

        ->addColumn('attachment', function ($itemdata) {
          if ($itemdata->attachment == null) {
            return '';
          }else{
           return '<a href="../uploads/applicant/'.$itemdata->attachment.'" target="_blank"/><i class="fa fa-download"></i> Download</a>';
         };  
       })

        ->addColumn('photo', function ($itemdata) {
          if ($itemdata->photo == null) {
            return '';
          }else{
           return '<a href="../uploads/applicant/'.$itemdata->photo.'" target="_blank"/><i class="fa fa-download"></i> Download</a>';
         };  
       })

        ->addColumn('selection', function ($itemdata) {
          return '<a href="javascript:void(0)" title="Change Selection" class="btn btn-primary btn-xs" onclick="edit('."'".$itemdata->id."'".')"><i class="fa fa-binoculars"></i></a> <a href="javascript:void(0)" title="Set to Employee" class="btn btn-success btn-xs" onclick="employee('."'".$itemdata->id."'".')"><i class="fa fa-check"></i></a> <a href="applicant/'.$itemdata->id.'/edit" title="Detail No: '."".$itemdata->notrans."".'" class="btn btn-detail btn-xs btn-flat"><i class="fa fa-book"></i> Detail</a>'; 
        })

        ->addColumn('action', function ($itemdata) {
          return '<a href="applicant/'.$itemdata->id.'/edit" title="'."'".$itemdata->notrans."'".'"> '.$itemdata->notrans.'</a>';
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

        ->addColumn('lastprogress', function ($itemdata) {
          if ($itemdata->interviewuserdate != '') {
            return '<span class="label label-warning"> Interview User </span>';
          }else if ($itemdata->interviewhrdate != ''){
           return '<span class="label label-warning"> Interview HRD </span>';
         }else if ($itemdata->technicaltestdate != ''){
           return '<span class="label label-warning"> Technical Test </span>';
         }else if ($itemdata->psychotestdate != ''){
           return '<span class="label label-warning"> Psychotest </span>';
         }else if ($itemdata->prescreeningdate != ''){
           return '<span class="label label-warning"> Pree Scaning </span>';
         };
       })

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
      $religion_list = Religion::all()->pluck('religionname', 'id'); 
      $maritalstatus_list = Maritalstatus::all()->pluck('maritalstatusname', 'maritalstatusname'); 
      $city_list = City::all()->pluck('cityname', 'id'); 
      $sourcecategory_list = Sourcecategory::all()->pluck('sourcecategoryname', 'id'); 
      $sourcemedia_list = Sourcemedia::all()->pluck('sourcemedianame', 'id'); 
      $educationlevel_list = Educationlevel::all()->pluck('educationlevelname', 'id'); 
      $educationmajor_list = Educationmajor::all()->pluck('educationmajorname', 'id'); 
      $recruitment_list = Recruitment::select(DB::raw("CONCAT(notrans,' [',datetrans, ']') AS name"),'id')->pluck('name', 'id'); 

      $sql = 'SELECT "Laki-Laki" AS a
              UNION ALL
              SELECT "Prempuan" AS a
              UNION ALL
              SELECT "Laki-Laki atau Prempuan" AS a';
      $gender_list = DB::table(DB::raw("($sql) as rs_sql"))->get()->pluck('a', 'a'); 

      return view ('editor.applicant.form', compact('department_list', 'location_list', 'employee_list', 'employeestatus_list', 'staffstatus_list', 'position_list', 'religion_list', 'maritalstatus_list', 'city_list', 'recruitment_list', 'sourcecategory_list', 'sourcemedia_list', 'gender_list', 'educationlevel_list', 'educationmajor_list'));
    }

    public function store(Request $request)
    { 
      DB::insert("INSERT INTO applicant (codetrans, notrans, datetrans)
        SELECT 'APPL',
        IFNULL(CONCAT('APPL','-',DATE_FORMAT(NOW(), '%d%m%y'),RIGHT((RIGHT(MAX(applicant.notrans),3))+1001,3)), CONCAT('APPL','-',DATE_FORMAT(NOW(), '%d%m%y'),'001')), DATE(NOW())  
        FROM
        applicant
        WHERE codetrans='APPL'");

      $lastInsertedID = DB::table('applicant')->max('id');  

       // dd($lastInsertedID);

      $applicant = Applicant::where('id', $lastInsertedID)->first(); 
      $applicant->datetrans = $request->input('datetrans');
      $applicant->positionid = $request->input('positionid');
      $applicant->firstname = $request->input('firstname');   
      $applicant->middlename = $request->input('middlename');   
      $applicant->lastname = $request->input('lastname');   
      $applicant->placebirth = $request->input('placebirth');   
      $applicant->datebirth = $request->input('datebirth');   
      $applicant->religionid = $request->input('religionid');   
      $applicant->maritalstatus = $request->input('maritalstatus');   
      $applicant->address = $request->input('address');    
      $applicant->rt = $request->input('rt');   
      $applicant->rw = $request->input('rw');   
      $applicant->subdistrict = $request->input('subdistrict');   
      $applicant->district = $request->input('district');   
      $applicant->cityid = $request->input('cityid');   
      $applicant->country = $request->input('country');   
      $applicant->zipcode = $request->input('zipcode');   
      $applicant->phone = $request->input('phone'); 
      $applicant->idcardnumber = $request->input('idcardnumber'); 
      $applicant->region = $request->input('region'); 
      $applicant->recruitmentid = $request->input('recruitmentid'); 
      $applicant->applydate = $request->input('applydate'); 
      $applicant->source = $request->input('source'); 
      $applicant->positionid = $request->input('positionid'); 
      $applicant->educationlevelid = $request->input('educationlevelid'); 
      $applicant->educationmajorid = $request->input('educationmajorid'); 
      $applicant->sourcecategoryid = $request->input('sourcecategoryid'); 
      $applicant->sourcemediaid = $request->input('sourcemediaid'); 
      $applicant->sourcemedia = $request->input('sourcemedia'); 
      $applicant->experience = $request->input('experience'); 
      $applicant->resume = $request->input('resume'); 
      $applicant->remark = $request->input('remark'); 
      $applicant->created_by = Auth::id();
      $applicant->save();

      if($request->attachment)
      {
        $applicant = Applicant::FindOrFail($applicant->id);
        $original_directory = "uploads/applicant/";
        if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        } 
        $applicant->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
        $request->attachment->move($original_directory, $applicant->attachment);
        $applicant->save(); 
      } 

      if($request->photo)
      {
        $applicant = Applicant::FindOrFail($applicant->id);
        $original_directory = "uploads/applicant/";
        if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        } 
        $applicant->photo = Carbon::now()->format("d-m-Y h-i-s").$request->photo->getClientOriginalName();
        $request->photo->move($original_directory, $applicant->photo);
        $applicant->save(); 
      } 
      return redirect('editor/applicant'); 
      
    }

    public function edit($id)
    {
      $department_list = Department::all()->pluck('departmentname', 'departmentcode');
      $location_list = Location::all()->pluck('locationname', 'id'); 
      $employee_list = Employee::all()->pluck('employeename', 'id'); 
      $employeestatus_list = Employeestatus::all()->pluck('employeestatusname', 'id'); 
      $staffstatus_list = Staffstatus::all()->pluck('staffstatusname', 'id'); 
      $position_list = Position::all()->pluck('positionname', 'id'); 
      $religion_list = Religion::all()->pluck('religionname', 'id'); 
      $maritalstatus_list = Maritalstatus::all()->pluck('maritalstatusname', 'maritalstatusname'); 
      $city_list = City::all()->pluck('cityname', 'id'); 
      $recruitment_list = Recruitment::all()->pluck('notrans', 'id'); 
      $sourcecategory_list = Sourcecategory::all()->pluck('sourcecategoryname', 'id'); 
      $sourcemedia_list = Sourcemedia::all()->pluck('sourcemedianame', 'id'); 
      $educationlevel_list = Educationlevel::all()->pluck('educationlevelname', 'id'); 
      $educationmajor_list = Educationmajor::all()->pluck('educationmajorname', 'id'); 

      $sql = 'SELECT "Laki-Laki" AS a
              UNION ALL
              SELECT "Prempuan" AS a
              UNION ALL
              SELECT "Laki-Laki atau Prempuan" AS a';
      $gender_list = DB::table(DB::raw("($sql) as rs_sql"))->get()->pluck('a', 'a'); 

      $applicant = Applicant::Where('id', $id)->first();   

      // dd($applicant); 
      return view ('editor.applicant.form', compact('applicant','department_list', 'location_list', 'employee_list', 'employeestatus_list', 'staffstatus_list', 'position_list', 'religion_list', 'maritalstatus_list', 'city_list', 'recruitment_list', 'sourcecategory_list', 'sourcemedia_list', 'gender_list', 'educationlevel_list', 'educationmajor_list'));
    }


    public function editprogress($id)
    { 
      $applicant = Applicant::Where('id', $id)->first();   

      echo json_encode($applicant); 
    }

    public function viewprogress($id)
    { 
      $applicant = Applicant::Where('id', $id)->first();   

      echo json_encode($applicant); 
    }

    public function update($id, Request $request)
    {
      $applicant = Applicant::Find($id);
      $applicant->datetrans = $request->input('datetrans');
      $applicant->positionid = $request->input('positionid');
      $applicant->firstname = $request->input('firstname');   
      $applicant->middlename = $request->input('middlename');   
      $applicant->lastname = $request->input('lastname');   
      $applicant->placebirth = $request->input('placebirth');   
      $applicant->datebirth = $request->input('datebirth');   
      $applicant->religionid = $request->input('religionid');   
      $applicant->maritalstatus = $request->input('maritalstatus');   
      $applicant->address = $request->input('address');   
      $applicant->rt = $request->input('rt');   
      $applicant->rw = $request->input('rw');   
      $applicant->subdistrict = $request->input('subdistrict');   
      $applicant->district = $request->input('district');   
      $applicant->cityid = $request->input('cityid');   
      $applicant->country = $request->input('country');   
      $applicant->zipcode = $request->input('zipcode');   
      $applicant->phone = $request->input('phone'); 
      $applicant->idcardnumber = $request->input('idcardnumber'); 
      $applicant->region = $request->input('region'); 
      $applicant->recruitmentid = $request->input('recruitmentid'); 
      $applicant->applydate = $request->input('applydate'); 
      $applicant->source = $request->input('source'); 
      $applicant->positionid = $request->input('positionid'); 
      $applicant->sourcecategoryid = $request->input('sourcecategoryid'); 
      $applicant->sourcemediaid = $request->input('sourcemediaid'); 
      $applicant->sourcemedia = $request->input('sourcemedia'); 
      $applicant->remark = $request->input('remark'); 
      $applicant->experience = $request->input('experience'); 
      $applicant->resume = $request->input('resume'); 
      $applicant->educationlevelid = $request->input('educationlevelid'); 
      $applicant->educationmajorid = $request->input('educationmajorid');
      $applicant->status = 0; 
      $applicant->created_by = Auth::id();
      $applicant->save();

      if($request->attachment)
      {
        $applicant = Applicant::FindOrFail($applicant->id);
        $original_directory = "uploads/applicant/";
        if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        } 
        $applicant->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
        $request->attachment->move($original_directory, $applicant->attachment);
        $applicant->save(); 
      } 

      if($request->photo)
      {
        $applicant = Applicant::FindOrFail($applicant->id);
        $original_directory = "uploads/applicant/";
        if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        } 
        $applicant->photo = Carbon::now()->format("d-m-Y h-i-s").$request->photo->getClientOriginalName();
        $request->photo->move($original_directory, $applicant->photo);
        $applicant->save(); 
      } 
      return redirect('editor/applicant');  
    }

    public function updateprogress($id, Request $request)
    { 
      $post = Applicant::Find($id); 
      $post->prescreeningdate = $request->prescreeningdate;
      $post->prescreeningpic = $request->prescreeningpic;
      $post->prescreeningnote = $request->prescreeningnote; 

      $post->psychotestdate = $request->psychotestdate;
      $post->psychotestpic = $request->psychotestpic;
      $post->psychotestnote = $request->psychotestnote; 

      $post->technicaltestdate = $request->technicaltestdate;
      $post->technicaltestpic = $request->technicaltestpic;
      $post->technicaltestnote = $request->technicaltestnote; 

      $post->interviewhrdate = $request->interviewhrdate;
      $post->interviewhrpic = $request->interviewhrpic;
      $post->interviewhrnote = $request->interviewhrnote; 

      $post->interviewuserdate = $request->interviewuserdate;
      $post->interviewuserpic = $request->interviewuserpic;
      $post->interviewusernote = $request->interviewusernote; 
      $post->updated_by = Auth::id();
      $post->save();
      
      DB::update("UPDATE applicant SET prescreeningdate = null WHERE id=".$id." AND prescreeningdate = '0000-00-00'");
      DB::update("UPDATE applicant SET psychotestdate = null WHERE id=".$id." AND psychotestdate = '0000-00-00'");
      DB::update("UPDATE applicant SET technicaltestdate = null WHERE id=".$id." AND technicaltestdate = '0000-00-00'");
      DB::update("UPDATE applicant SET interviewhrdate = null WHERE id=".$id." AND interviewhrdate = '0000-00-00'");
      DB::update("UPDATE applicant SET interviewuserdate = null WHERE id=".$id." AND interviewuserdate = '0000-00-00'");


      return response()->json($post); 
    } 

    public function delete($id)
    {
    //dd($id);
      $post =  Applicant::Find($id);
      $post->delete(); 

      return response()->json($post); 
    }

    public function cancel($id, Request $request)
    {
      $applicant = Applicant::Find($id); 
      $applicant->status = 9; 
      $applicant->created_by = Auth::id();
      $applicant->save(); 
      
      return response()->json($applicant); 

    }

    public function deletebulk(Request $request)
    {

     $idkey = $request->idkey;    

     foreach($idkey as $key => $id)
     {
    // $post =  Applicant::where('id', $id["1"])->get();
      $post = Applicant::Find($id["1"]);
      $post->delete(); 
    }

    echo json_encode(array("status" => TRUE));

  }

  public function slip($id)
  {
    $sql = 'SELECT
    applicant.id,
    applicant.notrans,
    applicant.datetrans,
    employee.employeename,
    applicant.skno,
    applicant.placementdate,
    applicant.requestdate,
    applicant.accepdate,
    location.locationname AS curlocationname,
    location_1.locationname AS nexlocationname,
    applicant.requestby,
    applicant.accepby,
    applicant.attachment,
    applicant.`status`,
    applicant.created_by,
    applicant.updated_by,
    applicant.deleted_by,
    applicant.created_at,
    applicant.updated_at,
    applicant.deleted_at 
    FROM
    applicant
    LEFT JOIN employee ON applicant.employeeid = employee.id
    LEFT JOIN location ON applicant.currentlocationid = location.id
    LEFT JOIN location AS location_1 ON applicant.nextlocationid = location_1.id
    WHERE
    applicant.id = '.$id.''; 
    $applicant = DB::table(DB::raw("($sql) as rs_sql"))->first();

    return view ('editor.applicant.slip', compact('applicant'));
  }
}
