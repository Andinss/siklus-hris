<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use DataTables; 
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Http\Controllers\Controller;
use App\Models\Event; 
use App\Models\Employee; 
use App\Models\SkType;
use App\Models\Setupvariable; 
use App\Models\Location; 
use Validator;
use Response;
use App\Post;
use View;

class EventController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [
    'eventno' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
    'eventname' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $events = Event::all();
      return view ('editor.event.index', compact('events'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 

        $sql = 'SELECT
                  event.id,
                  event.no_trans,
                  DATE_FORMAT(event.date_trans, "%d-%m-%Y") AS date_trans,
                  DATE_FORMAT(event.date_from, "%d-%m-%Y") AS date_from,
                  DATE_FORMAT(event.date_to, "%d-%m-%Y") AS date_to,
                  event.participant, 
                  event.event_name, 
                  event.time_from, 
                  event.status, 
                  event.description,
                  event.attachment 
                FROM
                  event 
                WHERE
                  event.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 


        return DataTables::of($itemdata) 

        ->addColumn('action', function ($itemdata) { 
            return '<a href="event/'.$itemdata->id.'/qrcode" title="Detail No: '."".$itemdata->no_trans."".'"  onclick="qrcode('."'".$itemdata->id."'".')" class="btn btn-sm btn-outline-secondary d-inline-block"><i class="fa fa-qrcode"></i> QR Code</a> <a href="event/'.$itemdata->id.'/edit" title="Detail No: '."".$itemdata->no_trans."".'"  onclick="edit('."'".$itemdata->id."'".')" class="btn btn-sm btn-outline-primary d-inline-block"><i class="fas fa-pen"></i> Edit</a> <a href="javascript:void(0)" title="Delete" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->no_trans."'".')"> <i class="fas fa-trash-alt"></i> Delete</a>';
        })
        ->addColumn('approval', function ($itemdata) {
        return '<a href="javascript:void(0)" title="Approval" class="btn btn-sm btn-success d-inline-block" onclick="approve_id('."'".$itemdata->id."', '".$itemdata->no_trans."'".')"><i class="fa fa-check"></i> Approve</a> <a  href="javascript:void(0)" title="Approval" class="btn btn-sm btn-warning d-inline-block" onclick="not_approve_id('."'".$itemdata->id."', '".$itemdata->no_trans."'".')"><i class="fas fa-times"></i> Not Approve</a>';
        })
        ->addColumn('attachment', function ($itemdata) {
          if ($itemdata->attachment == null) {
            return '';
          }else{
           return '<a href="'.asset("assets/uploads/event/".$itemdata->attachment).'" target="_blank"/><i class="fa fa-download"></i> Download</a>';
         };  
        })
        ->toJson();
      } else {
        exit("No data available");
      }
    }

    public function create()
    {    
      $event_list = Event::all()->pluck('no_trans', 'id'); 
      $location_list = Location::all()->pluck('location_name', 'id'); 

      return view ('editor.event.form', compact('location_list'));
    }

    public function store(Request $request)
    { 
        DB::insert("INSERT INTO event (code_trans, no_trans, date_trans)
                    SELECT 'EVENT',
                    IFNULL(CONCAT('EVENT','/',RIGHT((RIGHT(MAX(event.no_trans),3))+1001,3)), CONCAT('EVENT','/','001')), DATE(NOW())  
                    FROM
                    event
                    WHERE code_trans='EVENT'");

       $lastInsertedID = DB::table('event')->max('id');  

       $date_array = explode("-",$request->input('date_trans')); // split the array
       $var_day = $date_array[0]; //day seqment
       $var_month = $date_array[1]; //month segment
       $var_year = $date_array[2]; //year segment
       $new_date_format = "$var_year-$var_month-$var_day"; // join them together


       $event = Event::where('id', $lastInsertedID)->first(); 
       $event->date_trans = $new_date_format;
       $event->time_from = $request->input('time_from');  
       $event->participant = $request->input('participant');  
       $event->event_name = $request->input('event_name');  
       $event->description = $request->input('description');  
       $event->status = 0;  
       $event->created_by = Auth::id();
       $event->save();

       if($request->attachment)
       {
        $event = Event::FindOrFail($event->id);
        $original_directory = "uploads/event/";
        if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          } 
          $event->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
          $request->attachment->move($original_directory, $event->attachment);
          $event->save(); 
        } 
        return redirect('editor/event'); 
    }

    public function edit($id)
    { 

      $event = Event::Where('id', $id)->first();  
      $location_list = Location::all()->pluck('location_name', 'id'); 

      return view ('editor.event.form', compact('event', 'location_list'));
    }

    public function update($id, Request $request)
    {
      
       $date_array = explode("-",$request->input('date_trans')); // split the array
       $var_day = $date_array[0]; //day seqment
       $var_month = $date_array[1]; //month segment
       $var_year = $date_array[2]; //year segment
       $new_date_format = "$var_year-$var_month-$var_day"; // join them together


       $event = Event::FindOrFail($id); 
       $event->date_trans = $new_date_format;
       $event->time_from = $request->input('time_from');  
       $event->participant = $request->input('participant');  
       $event->event_name = $request->input('event_name');  
       $event->description = $request->input('description');  
       $event->status = 0;  
       $event->created_by = Auth::id();
       $event->save();

      if($request->attachment)
      {
        $event = Event::FindOrFail($event->id);
        $original_directory = "uploads/event/";
        if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          } 
          $event->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
          $request->attachment->move($original_directory, $event->attachment);
          $event->save(); 
        } 
        return redirect('editor/event');  
      }

      public function qrcode($id)
      { 

          $event = Event::Where('id', $id)->first(); 

          return view ('editor.event.qrcode', compact('event'));
      }

      public function cancel($id, Request $request)
      {
        $mutation = Event::Find($id); 
        $mutation->status = 9; 
        $mutation->created_by = Auth::id();
        $mutation->save(); 
      
        return response()->json($mutation); 

      }

      public function delete($id)
      {
        $post =  Event::Find($id);
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
 
  }
