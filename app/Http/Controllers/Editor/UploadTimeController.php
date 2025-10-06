<?php
namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\UploadtimeRequest;
use App\Http\Controllers\Controller;
use App\Models\Payperiod;
use App\Models\Department;
use App\Models\Uploadtime; 
use App\Models\Uploadtimedetail; 
use App\Models\Uploadtimelist;
use Carbon\Carbon; 
use Validator;
use Response;
use App\Post;
use View;
use Excel; 
use File;

class UploadtimeController extends Controller
{
   
  public function index()
  { 
    $payperiod_list = Payperiod::all()->pluck('description', 'id');
    $department_list = Department::all()->pluck('departmentname', 'departmentcode');
    return view ('editor.uploadtime.index', compact('times','payperiod_list','department_list'));
  } 

  public function storeimport(Request $request)
  { 
    Uploadtime::query()->truncate();

    if($request->hasFile('import_file')){
      $path = $request->file('import_file')->getRealPath();
      $data = Excel::load($path, function($reader) {})->get();

      if(!empty($data) && $data->count()){
        foreach ($data->toArray() as $key => $value) {
          if(!empty($value)){
            foreach ($value as $v) {
              $insert[] = ['date' => $v['date'], 'nik' => $v['nik'], 'employeename' => $v['employeename'], 'department' => $v['department'], 'ain' => $v['ain'], 'aout' => $v['aout']];
              // echo "string";
            }
          }
        }

        $uploadtimelist = new Uploadtimelist();
        $original_directory = "uploads/uploadtimelist/";
        if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        } 
        $uploadtimelist->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->import_file->getClientOriginalName();
        $request->import_file->move($original_directory, $uploadtimelist->attachment);
        $uploadtimelist->date = Carbon::now();
        $uploadtimelist->created_by = Auth::id();
        $uploadtimelist->save(); 
        

        if(!empty($insert)){
          Uploadtime::insert($insert);
          return back()->with('success','Insert Record successfully.');
        }
      }
    }
 
    return back()->with('error','Please Check your file, Something is wrong there.');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $itemdata = Uploadtime::orderBy('employeename', 'ASC')->get();

      return Datatables::of($itemdata)  
 
      ->make(true);
    } else {
      exit("No data available");
    }
  }
}
