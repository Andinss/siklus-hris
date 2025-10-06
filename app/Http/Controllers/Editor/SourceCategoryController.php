<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\SourcecategoryRequest;
use App\Http\Controllers\Controller;
use App\Models\Sourcecategory; 
use Validator;
use Response;
use App\Post;
use View;

class SourcecategoryController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'sourcecategoryname' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    $sourcecategorys = Sourcecategory::all();
    return view ('editor.sourcecategory.index', compact('sourcecategorys'));
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $itemdata = Sourcecategory::orderBy('sourcecategoryname', 'ASC')->get();

      return Datatables::of($itemdata) 

      ->addColumn('action', function ($itemdata) {
        return '<a href="javascript:void(0)" title="Edit"  onclick="edit('."'".$itemdata->id."'".')"> Edit</a> | <a  href="javascript:void(0)" title="Delete" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->sourcecategoryname."'".')"> Delete</a>';
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
      $post = new Sourcecategory(); 
      $post->sourcecategoryname = $request->sourcecategoryname; 
      $post->status = $request->status;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function edit($id)
  {
    $sourcecategory = Sourcecategory::Find($id);
    echo json_encode($sourcecategory); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make(Input::all(), $this->rules);
    if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {
        $post = Sourcecategory::Find($id); 
        $post->sourcecategoryname = $request->sourcecategoryname;
        $post->status = $request->status;
        $post->updated_by = Auth::id();
        $post->save();

        return response()->json($post); 
    }
  }

  public function delete($id)
  {
    $post =  Sourcecategory::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }

  public function deletebulk(Request $request)
  {

   $idkey = $request->idkey;    

   foreach($idkey as $key => $id)
   {
    $post = Sourcecategory::Find($id["1"]);
    $post->delete(); 
  }

  echo json_encode(array("status" => TRUE));

}
}
