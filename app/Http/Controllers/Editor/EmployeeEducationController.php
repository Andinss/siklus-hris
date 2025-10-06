<?php

namespace App\Http\Controllers\Editor;

use Auth;
use File;
use Session;
use Carbon\Carbon;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeeducationRequest;
use App\Http\Controllers\Controller;
use App\Models\Employeeeducation; 
use App\Models\Employee;
use App\Models\Educationmajor;
use Intervention\Image\Facades\Image;
use Validator;
use Response;
use App\Post;
use View;

class EmployeeeducationController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'educationname' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index($id)
  {
    $employee = Employee::where('id', $id)->first();
    $educationmajor_list = Educationmajor::all()->pluck('educationmajorname', 'id'); 

    return view ('editor.employeeeducation.index', compact('employee', 'educationmajor_list'));
  }

  public function data(Request $request, $id)
  {   
    if($request->ajax()){ 

        $sql = 'SELECT
          educationmajor.educationmajorname,
          employeeeducation.id,
          employeeeducation.employeeid,
          employeeeducation.educationtypeid,
          employeeeducation.educationname,
          employeeeducation.address,
          employeeeducation.yearfrom,
          employeeeducation.yearto,
          employeeeducation.image,
          employeeeducation.gpa
        FROM
          employeeeducation
        INNER JOIN educationmajor ON employeeeducation.majorid = educationmajor.id
        WHERE employeeeducation.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->where('employeeid', $id)->orderBy('id', 'ASC')->get(); 

      return Datatables::of($itemdata) 

      ->addColumn('action', function ($itemdata) {
        return '<a class="btn btn-xs btn-danger"  href="javascript:void(0)" title="Delete" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->educationname."'".')"> <i class="fa fa-trash"></i></a> <a class="btn btn-xs btn-success"  href="javascript:void(0)" title="Delete" onclick="edit('."'".$itemdata->id."', '".$itemdata->educationname."'".')"> <i class="fa fa-pencil"></i></a>';
      })

      ->addColumn('check', function ($itemdata) {
        return '<label class="control control--checkbox"> <input type="checkbox" class="data-check" value="'."'".$itemdata->id."'".'"> <div class="control__indicator"></div> </label>';
      })

      ->addColumn('image', function ($itemdata) {
          if ($itemdata->image == null) {
            return '';
          }else{
           return '<a href="../../uploads/employeeeducation/'.$itemdata->image.'" target="_blank"/><i class="fa fa-download"></i> Download</a>';
         };  
       })

      ->make(true);
    } else {
      exit("No data available");
    }
  }

  public function store(Request $request, $id)
  { 

     switch($request->save) {
          case 'save': 
            $employee = new Employeeeducation(); 
            $employee->educationname = $request->input('educationname');
            $employee->majorid = $request->input('majorid');
            $employee->yearfrom = $request->input('yearfrom');
            $employee->yearto = $request->input('yearto');
            $employee->gpa = $request->input('gpa');
            $employee->address = $request->input('address');
            $employee->employeeid = $id;
            $employee->created_by = Auth::id();
            $employee->save();
          break;

          case 'update': 
              $employee = Employeeeducation::Find($request->input('id_key')); 
              $employee->educationname = $request->input('educationname');
              $employee->majorid = $request->input('majorid');
              $employee->yearfrom = $request->input('yearfrom');
              $employee->yearto = $request->input('yearto');
              $employee->gpa = $request->input('gpa');
              $employee->address = $request->input('address');
              $employee->employeeid = $id;
              $employee->created_by = Auth::id();
              $employee->save();
          break;
      }

       

      if($request->image)
      {
        $employee = Employeeeducation::FindOrFail($employee->id);

        $original_directory = "uploads/employeeeducation/";

      if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        }

        //$file_extension = $request->image->getClientOriginalExtension();
        $employee->image = Carbon::now()->format("d-m-Yh-i-s").str_replace(" ", "", $request->image->getClientOriginalName());
        $request->image->move($original_directory, $employee->image);

        $thumbnail_directory = $original_directory."thumbnail/";
        if(!File::exists($thumbnail_directory))
          {
           File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
         }
         $thumbnail = Image::make($original_directory.$employee->image);
         $thumbnail->fit(10,10)->save($thumbnail_directory.$employee->image);

         $employee->save(); 
       }

       return back();

 }

 public function edit($id)
  {

    $employeeeducation = Employeeeducation::Find($id);
    echo json_encode($employeeeducation); 
  }

  public function delete($id)
  {
    $post =  Employeeeducation::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
 
}
