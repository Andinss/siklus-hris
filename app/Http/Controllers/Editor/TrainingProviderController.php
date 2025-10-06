<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\TrainingProviderRequest;
use App\Http\Controllers\Controller;
use App\Models\TrainingProvider; 
use Validator;
use Response;
use App\Post;
use View;

class TrainingProviderController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'training_provider_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    return view ('editor.training_provider.index');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $training_provider = TrainingProvider::orderBy('training_provider_name', 'ASC')->get();

      return DataTables::of($training_provider)  
      ->addColumn('action', function ($training_provider) {
        return '<a href="#" onclick="edit('."'".$training_provider->id."'".')" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"> <i class="fas fa-pen"></i> Edit</a> <a  href="javascript:void(0)" title="Hapus" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$training_provider->id."', '".$training_provider->training_provider_name."'".')"> <i class="fas fa-trash-alt"></i> Hapus</a>';
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
      $post = new TrainingProvider(); 
      $post->training_provider_name = $request->training_provider_name; 
      $post->status = $request->status;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function edit($id)
  {
    $training_provider = TrainingProvider::Find($id);
    echo json_encode($training_provider); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make($request->all(), $this->rules);
    if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
      $post = TrainingProvider::Find($id); 
      $post->training_provider_name = $request->training_provider_name;
      $post->status = $request->status;
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function delete($id)
  {
    $post =  TrainingProvider::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
}
