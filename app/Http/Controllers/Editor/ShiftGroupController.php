<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ShiftGroupRequest;
use App\Http\Controllers\Controller;
use App\Models\ShiftGroup; 
use App\Models\ShiftGroupDetail;
use App\Models\Shift;
use Validator;
use Response;
use App\Post;
use View;

class ShiftGroupController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'shift_group_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    return view ('editor.shift_group.index');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $shift_group = ShiftGroup::orderBy('shift_group_name', 'ASC')->get();

      return DataTables::of($shift_group)  
      ->addColumn('action', function ($shift_group) {
        return '<a href="shift-group/'.$shift_group->id.'/detail" title="'."'".$shift_group->shift_group_name."'".'" title="Pola Shift" class="btn btn-sm btn-outline-primary d-inline-block"> <i class="fas fa-pen"></i> Pola Shift</a> <a  href="javascript:void(0)" title="Hapus" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$shift_group->id."', '".$shift_group->shift_group_name."'".')"> <i class="fas fa-trash-alt"></i> Hapus</a>';
      })
      ->toJson();
    } else {
      exit("No data available");
    }
  }

  public function store(Request $request)
  { 
    $validator = Validator::make(Input::all(), $this->rules);
    if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
      $post = new ShiftGroup(); 
      $post->shift_group_name = $request->shift_group_name; 
      $post->status = $request->status;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function edit($id)
  {
    $shift_group = ShiftGroup::Find($id);
    echo json_encode($shift_group); 
  }

  // public function update($id, Request $request)
  // {
  //   $validator = Validator::make(Input::all(), $this->rules);
  //   if ($validator->fails()) {
  //       return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
  //   } else {
  //     $post = ShiftGroup::Find($id); 
  //     $post->shift_group_name = $request->shift_group_name;
  //     $post->status = $request->status;
  //     $post->updated_by = Auth::id();
  //     $post->save();

  //     return response()->json($post); 
  //   }
  // }


  public function update($id, Request $request)
  { 
      $post = Shiftgroup::Find($id); 
      $post->shift_group_code = $request->shift_group_code;
      $post->shift_group_name = $request->shift_group_name;
      $post->day_shift = $request->day_shift;  
      $post->first_period_id = $request->first_period_id;  
      $post->first_shift_id = $request->first_shift_id;  
      $post->dafault_holiday = $request->input('dafault_holiday');
      $post->status = $request->status;
      $post->off_saturday = $request->has('off_saturday');
      $post->off_friday = $request->has('off_friday');
      $post->off_sunday = $request->has('off_sunday');
      $post->updated_by = Auth::id();
      $post->save();

      // return response()->json($post); 
      return redirect('editor/shift-group');   
  }

  public function delete($id)
  {
    $post =  ShiftGroup::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }

  public function detail($id)
  {
    $shift_list = Shift::all(); 

    $sql = 'SELECT
              *
            FROM
              shift_group';
    $shift_group = DB::table(DB::raw("($sql) as rs_sql"))->where('id', $id)->first();

    return view('editor.shift_group.form', compact('shift_group', 'shift_list'));
  }

  public function data_detail(Request $request, $id)
  {   
   
    if($request->ajax()){ 

          $sql = 'SELECT
                    shift_group_detail.id,
                    shift_group_detail.day,
                    shift_group_detail.shift_group_id,
                    shift_group_detail.shift_id,
                    shift.shift_name,
                    shift.start_time,
                    shift.end_time,
                    shift.start_break,
                    shift.end_break,
                    shift.grace_for_late,
                    shift.absence_type_id,
                    absence_type.absence_type_name
                  FROM
                    shift_group_detail
                  LEFT JOIN shift ON shift_group_detail.shift_id = shift.id
                  LEFT JOIN absence_type ON shift.absence_type_id = absence_type.id
                  WHERE shift_group_detail.shift_group_id = '.$id.' AND shift_group_detail.deleted_at IS NULL
                  ORDER BY shift_group_detail.day ASC';
          $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->orderBy('day', 'ASC')->get(); 

         return DataTables::of($itemdata) 
        ->addColumn('action', function ($itemdata) {
          return '<a  href="javascript:void(0)" title="Delete" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->shift_name."'".')"><i class="fas fa-trash-alt"></i></a>';
        })
        ->toJson();
      } else {
        exit("No data available");
    }
  }

   public function save_detail($id, Request $request)
  { 
      $post = new ShiftGroupDetail;
      $post->shift_group_id = $id;  
      $post->shift_id = $request->shift_id;   
      $post->day = $request->day;   
      $post->save();

      return redirect('editor/shift-group'); 
  }

  public function delete_detail($id)
  {
    $post =  ShiftGroupDetail::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }

}
