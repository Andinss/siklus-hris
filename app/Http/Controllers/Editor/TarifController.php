<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\TarifRequest;
use App\Http\Controllers\Controller;
use App\Models\Tarif; 
use Validator;
use Response;
use App\Post;
use View;

class TarifController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'tarif' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    $tarifs = Tarif::all();
    return view ('editor.tarif.index', compact('tarifs'));
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $itemdata = Tarif::orderBy('tarif', 'ASC')->get();

      return DataTables::of($itemdata) 
      ->addColumn('action', function ($tarif) {
        return '<a href="#" onclick="edit('."'".$tarif->id."'".')" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Edit</a> <a  href="javascript:void(0)" title="Hapus" class="btn btn-danger btn-xs" onclick="delete_id('."'".$tarif->id."', '".$tarif->tarif_name."'".')"> <i class="ti-trash"></i> Hapus</a>';
      })
      ->addColumn('check', function ($itemdata) {
        return '<label class="control control--checkbox"> <input type="checkbox" class="data-check" value="'."'".$itemdata->id."'".'"> <div class="control__indicator"></div> </label>';
      })
      ->toJson();
    } else {
      exit("No data available");
    }
  }

  public function store(Request $request)
  { 
    $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
    $post = new Tarif(); 
    $post->description = $request->description; 
    $post->tarif = $request->tarif; 
    $post->status = $request->status;
    $post->from = $request->from;
    $post->to = $request->to; 
    $post->created_by = Auth::id();
    $post->save();

    return response()->json($post); 
  }
  }

  public function edit($id)
  {
    $tarif = Tarif::Find($id);
    echo json_encode($tarif); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
    $post = Tarif::Find($id); 
    $post->description = $request->description; 
    $post->tarif = $request->tarif;
    $post->status = $request->status;
    $post->from = $request->from;
    $post->to = $request->to; 
    $post->updated_by = Auth::id();
    $post->save();

    return response()->json($post); 
  }
  }

  public function delete($id)
  {
    //dd($id);
    $post =  Tarif::Find($id);
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
    // $post =  Tarif::where('id', $id["1"])->get();
    $post = Tarif::Find($id["1"]);
    $post->delete(); 
  }

  echo json_encode(array("status" => TRUE));

}
}
