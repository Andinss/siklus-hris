<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PtkpRequest;
use App\Http\Controllers\Controller;
use App\Models\Ptkp; 
use Validator;
use Response;
use App\Post;
use View;

class PtkpController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [ 
    'tax_status' => 'required'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $ptkps = Ptkp::all();
      return view ('editor.ptkp.index', compact('ptkps'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 
        $itemdata = Ptkp::orderBy('tax_status', 'ASC')->get();

        return DataTables::of($itemdata) 

        ->addColumn('action', function ($itemdata) {
        return '<a href="#" onclick="edit('."'".$itemdata->id."'".')" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"><i class="fas fa-pen"></i> Edit</a> <a  href="javascript:void(0)" title="Hapus" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->tax_status."'".')"><i class="fas fa-trash-alt"></i> Hapus</a>';
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
        $post = new Ptkp(); 
        $post->tax_status = $request->tax_status;
        $post->ptkp = $request->ptkp; 
        $post->status = $request->status;
        $post->created_by = Auth::id();
        $post->save();

        return response()->json($post); 
      }
    }

    public function edit($id)
    {
      $ptkp = Ptkp::Find($id);
      echo json_encode($ptkp); 
    }

    public function update($id, Request $request)
    {
      $validator = Validator::make($request->all(), $this->rules);
      if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
      } else {
        $post = Ptkp::Find($id); 
        $post->tax_status = $request->tax_status;
        $post->ptkp = $request->ptkp; 
        $post->status = $request->status;
        $post->updated_by = Auth::id();
        $post->save();

        return response()->json($post); 
      }
    }

    public function delete($id)
    {
      $post =  Ptkp::Find($id);
      $post->delete(); 

      return response()->json($post); 
    }

    public function deletebulk(Request $request)
    {

     $idkey = $request->idkey;    

     foreach($idkey as $key => $id)
     {
      $post = Ptkp::Find($id["1"]);
      $post->delete(); 
    }

    echo json_encode(array("status" => TRUE));

  }
}
