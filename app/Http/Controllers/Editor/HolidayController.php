<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\HolidayRequest;
use App\Http\Controllers\Controller;
use App\Models\Holiday;
use App\Models\Shift;
use Validator;
use Response;
use App\Post;
use View;

class HolidayController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [
    'holiday_name' => 'required'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
      $holidays = Holiday::all();
      $shift_lists = Shift::all();

      return view ('editor.holiday.index', compact('holidays', 'shift_lists'));
    }

    public function data(Request $request)
    {
      if($request->ajax()){
        $itemdata = Holiday::orderBy('holiday_name', 'ASC')->get();

        return DataTables::of($itemdata)

        ->addColumn('action', function ($itemdata) {
        return '<a href="#" onclick="edit('."'".$itemdata->id."'".')" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"> <i class="fas fa-pen"></i> Edit</a> <a href="javascript:void(0)" title="Hapus" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->holiday_name."'".')"> <i class="fas fa-trash-alt"></i> Hapus</a>';
      })
        ->toJson();
      } else {
        exit("No data available");
      }
    }

    public function store(Request $request)
    {

      $date_array = explode("-",$request->holiday_date); // split the array
      $var_day = $date_array[0]; //day seqment
      $var_month = $date_array[1]; //month segment
      $var_year = $date_array[2]; //year segment
      $date_trans = "$var_year-$var_month-$var_day"; // join them together

      $validator = Validator::make($request->all(), [
        'holiday_name' => 'required',
        'holiday_date' => 'required|date',
      ]);
      if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
      } else {
        $shiftId = $request->shift_id === ""
            ? null
            : $request->shift_id;

        $post = new Holiday();
        $post->exception_shift_id = $shiftId;
        $post->holiday_name = $request->holiday_name;
        $post->holiday_date = $request->holiday_date;
        $post->status = $request->status ?? 0;
        $post->created_by = Auth::id();
        $post->save();

        return response()->json($post);
      }
    }

    public function edit($id)
    {
      $holiday = Holiday::Find($id);
      echo json_encode($holiday);
    }

    public function update($id, Request $request)
    {
      $validator = Validator::make($request->all(), [
        'holiday_name' => 'required',
        'holiday_date' => 'required|date',
      ]);
      if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
      } else {

        $shiftId = $request->shift_id === ""
            ? null
            : $request->shift_id;

        $date_array = explode("-",$request->holiday_date); // split the array
        $var_day = $date_array[0]; //day seqment
        $var_month = $date_array[1]; //month segment
        $var_year = $date_array[2]; //year segment
        $date_trans = "$var_year-$var_month-$var_day"; // join them together


        $post = Holiday::Find($id);
        $post->exception_shift_id = $shiftId;
        $post->holiday_name = $request->holiday_name;
        $post->holiday_date = $request->holiday_date;
        $post->status = $request->status ?? 0;
        $post->updated_by = Auth::id();
        $post->save();

        return response()->json($post);
      }
    }

    public function delete($id)
    {
      $post =  Holiday::Find($id);
      $post->delete();

      return response()->json($post);
    }

    public function deletebulk(Request $request)
    {

     $idkey = $request->idkey;

     foreach($idkey as $key => $id)
     {
      $post = Holiday::Find($id["1"]);
      $post->delete();
    }

    echo json_encode(array("status" => TRUE));

  }
}
