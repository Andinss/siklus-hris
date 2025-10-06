<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\SubpositionRequest;
use App\Http\Controllers\Controller;
use App\Models\Subposition; 
use App\Models\Position;
use Validator;
use Response;
use App\Post;
use View;

class SubpositionController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'subpositionname' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    $positions = Subposition::all();
    $position_list = Position::all()->pluck('positionname', 'id'); 

    return view ('editor.subposition.index', compact('positions', 'position_list'));
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      // $itemdata = Subposition::orderBy('subpositionname', 'ASC')->get();
      $sql = 'SELECT
          subposition.id,
          subposition.subpositionname,
          subposition.status,
          position.positionname 
        FROM
          position
          RIGHT JOIN subposition ON position.id = subposition.positionid
        WHERE subposition.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

      return Datatables::of($itemdata) 

      ->addColumn('action', function ($itemdata) {
        return '<a href="javascript:void(0)" title="Edit"  onclick="edit('."'".$itemdata->id."'".')"> Edit</a> | <a  href="javascript:void(0)" title="Delete" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->subpositionname."'".')"> Delete</a>';
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
    $post = new Subposition(); 
    $post->subpositionname = $request->subpositionname; 
    $post->positionid = $request->positionid; 
    $post->status = $request->status;
    $post->created_by = Auth::id();
    $post->save();

    return response()->json($post); 
  }
  }

  public function edit($id)
  {
    $subposition = Subposition::Find($id);
    echo json_encode($subposition); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
    $post = Subposition::Find($id); 
    $post->positionid = $request->positionid; 
    $post->subpositionname = $request->subpositionname; 
    $post->status = $request->status;
    $post->updated_by = Auth::id();
    $post->save();

    return response()->json($post); 
  }
  }

  public function delete($id)
  {
    //dd($id);
    $post =  Subposition::Find($id);
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
    // $post =  Subposition::where('id', $id["1"])->get();
    $post = Subposition::Find($id["1"]);
    $post->delete(); 
  }

  echo json_encode(array("status" => TRUE));

}
}
