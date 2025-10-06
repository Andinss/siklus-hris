<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\LeavingRequest;
use App\Http\Controllers\Controller;
use App\Models\Leaving; 
use App\Models\Employee; 
use App\Models\Absencetype;
use Validator;
use Response;
use App\Post;
use View;

class LeavingappController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [
    'leavingno' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
    'leavingname' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $leavings = Leaving::all();
      return view ('editor.leavingapp.index', compact('leavings'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 

        $sql = 'SELECT 
                  leaving.id,
                  leaving.codetrans,
                  leaving.notrans,
                  leaving.datetrans,
                  leaving.employeeid,
                  employee.employeename,
                  leaving.leavingfrom,
                  leaving.leavingto,
                  DATEDIFF(leaving.leavingto, leaving.leavingfrom) AS days,
                  -- leaving.days,
                  leaving.used,
                  leaving.plafond,
                  leaving.absencetypeid,
                  absencetype.absencetypename,
                  leaving.attachment,
                  leaving.remark,
                  leaving.`status` 
                FROM
                  leaving
                  LEFT JOIN employee ON leaving.employeeid = employee.id
                  LEFT JOIN absencetype ON leaving.absencetypeid = absencetype.id
                WHERE
                  leaving.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

        return Datatables::of($itemdata) 
 
       ->addColumn('mstatus', function ($itemdata) {
          if ($itemdata->status == 0) {
            return '<span class="label label-warning"> Open </span>';
          }else if ($itemdata->status == 2){
           return '<span class="label label-danger"> Not Approve </span>';
        }else if ($itemdata->status == 1){
           return '<span class="label label-success"> Approve </span>';
         };

       })

       ->addColumn('btn_attachment', function ($itemdata) {
          if ($itemdata->attachment == "") {
            return 'No Attachment';
          }else{
           return '<a href="../uploads/leaving/'.$itemdata->attachment.'" target="_blank"><i class="fa fa-download"></i> Download </a>';
        };
       })

      ->addColumn('approval', function ($itemdata) {
          if ($itemdata->status == 0) {
              return '<a  href="javascript:void(0)" title="Approval" class="btn btn-success btn-xs btn-flat" onclick="approve_id('."'".$itemdata->id."', '".$itemdata->notrans."'".')"><i class="fa fa-check"></i> Approve</a> <a  href="javascript:void(0)" title="Approval" class="btn btn-warning btn-flat btn-xs" onclick="not_approve_id('."'".$itemdata->id."', '".$itemdata->notrans."'".')"><i class="fa fa-close"></i> Not Approve</a>';
          }else{
              return 'Validated!';
          };

        })

        ->make(true);
      } else {
        exit("No data available");
      }
    } 

     public function approve($id, Request $request)
    { 
        $post = Leaving::Find($id); 
        $post->status = 1;  
        $post->save();

        return response()->json($post);  
    }

    public function notapprove($id, Request $request)
    { 
        $post = Leaving::Find($id); 
        $post->status = 2;  
        $post->save();

        return response()->json($post);  
    }

  }
