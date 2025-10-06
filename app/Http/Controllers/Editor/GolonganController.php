<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\GolonganRequest;
use App\Http\Controllers\Controller;
use App\Models\Golongan; 
use App\Models\Payrolltype;
use Validator;
use Response;
use App\Post;
use View;

class GolonganController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'golonganname' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    $golongans = Golongan::all();
    $payrolltype_list = Payrolltype::all()->pluck('payrolltypename', 'id');
    return view ('editor.golongan.index', compact('golongans', 'payrolltype_list'));
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $itemdata = Golongan::orderBy('golonganname', 'ASC')->get();

      $sql = 'SELECT
                golongan.id,
                golongan.golonganname,
                payrolltype.payrolltypename, 
                FORMAT(golongan.meal, 0) AS meal,
                FORMAT(golongan.transport, 0) AS transport,
                golongan.`status`
              FROM
                golongan
              LEFT JOIN payrolltype ON golongan.payrolltypeid = payrolltype.id';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

      return Datatables::of($itemdata) 

      ->addColumn('action', function ($itemdata) {
        return '<a href="javascript:void(0)" title="Edit"  onclick="edit('."'".$itemdata->id."'".')"> Edit</a> | <a  href="javascript:void(0)" title="Delete" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->golonganname."'".')"> Delete</a>';
      })

      ->addColumn('check', function ($itemdata) {
        return '<label class="control control--checkbox"> <input type="checkbox" class="data-check" value="'."'".$itemdata->id."'".'"> <div class="control__indicator"></div> </label>';
      })

      ->addColumn('mstatus', function ($itemdata) {
        if ($itemdata->status == 0) {
          return '<span class="label label-success"> Active </span>';
            }else{
             return '<span class="label label-danger"> Not Active </span>';
           };
         })
      ->make(true);
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
    $post = new Golongan(); 
    $post->golonganname = $request->golonganname; 
    $post->meal = str_replace(",", "", $request->meal); 
    $post->transport = str_replace(",", "", $request->transport); 
    $post->status = $request->status;
    $post->payrolltypeid = $request->payrolltypeid;
    $post->created_by = Auth::id();
    $post->save();

    return response()->json($post); 
  }
  }

  public function edit($id)
  {
    // $golongan = Golongan::Find($id);
    $sql = 'SELECT
            golongan.id,
            golongan.golonganname,
            FORMAT(golongan.meal, 0) AS meal,
            FORMAT(golongan.transport, 0) AS transport,
            golongan.`status`
          FROM
            golongan
          WHERE golongan.id = '.$id.'';
    $golongan = DB::table(DB::raw("($sql) as rs_sql"))->first(); 
    echo json_encode($golongan); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
    $post = Golongan::Find($id); 
    $post->golonganname = $request->golonganname;
    $post->meal = str_replace(",", "", $request->meal);
    $post->transport = str_replace(",", "", $request->transport);
    $post->status = $request->status;
    $post->payrolltypeid = $request->payrolltypeid;
    $post->updated_by = Auth::id();
    $post->save();

    return response()->json($post); 
  }
  }

  public function delete($id)
  {
    //dd($id);
    $post =  Golongan::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }

  public function deletebulk(Request $request)
  {

   $idkey = $request->idkey;   

  //$count = count($idkey);
   
//    $i = 0;
// dd($idkey[$i]);

//    $idkey = (object) $idkey;
// dd($idkey);

   foreach($idkey as $key => $id)
   {
    // $post =  Golongan::where('id', $id["1"])->get();
    $post = Golongan::Find($id["1"]);
    $post->delete(); 
  }

  echo json_encode(array("status" => TRUE));

}
}
