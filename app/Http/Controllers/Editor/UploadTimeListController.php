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

class UploadtimelistController extends Controller
{
   
  public function index()
  { 
    return view ('editor.uploadtimelist.index');
  } 
 
  public function data(Request $request)
  {   
    if($request->ajax()){ 
       $sql = 'SELECT
                  uploadtimelist.id,
                  uploadtimelist.attachment,
                  uploadtimelist.attachment AS attachmentname,
                  DATE_FORMAT(uploadtimelist.date, "%d-%m-%Y") AS dateupload,
                  uploadtimelist.created_by,
                  uploadtimelist.created_at,
                  `user`.username
                FROM
                  uploadtimelist
                LEFT JOIN `user` ON uploadtimelist.created_by = `user`.id';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

      return Datatables::of($itemdata)  
      
      ->addColumn('attachment', function ($itemdata) {
          if ($itemdata->attachment == null) {
            return '';
          }else{
           return '<a href="../uploads/uploadtimelist/'.$itemdata->attachment.'" target="_blank"/><i class="fa fa-download"></i> Download</a>';
         };  
        })

      ->make(true);
    } else {
      exit("No data available");
    }
  }
}
