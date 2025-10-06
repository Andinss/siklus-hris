<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\LeavecategoryRequest;
use App\Http\Controllers\Controller;
use App\Models\Leavecategory; 
use App\Models\Absencetype; 
use Validator;
use Response;
use App\Post;
use View;

class LeavecategoryController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [ 
    'leavecategoryname' => 'required'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $leavecategorys = Leavecategory::all();
      $absencetype_list = Absencetype::all()->pluck('absencetypename', 'id'); 

      return view ('editor.leavecategory.index', compact('leavecategorys', 'absencetype_list'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 
        // $itemdata = Leavecategory::orderBy('leavecategoryname', 'ASC')->get();

        $sql = 'SELECT
                  leavecategory.id,
                  leavecategory.leavecategorycode,
                  leavecategory.leavecategoryname,
                  leavecategory.color,
                  leavecategory.`status`,
                  leavecategory.created_by,
                  leavecategory.updated_by,
                  leavecategory.deleted_by,
                  leavecategory.created_at,
                  leavecategory.updated_at,
                  leavecategory.deleted_at,
                  leavecategory.absencetypeid,
                  absencetype.absencetypename 
                FROM
                  leavecategory
                  LEFT JOIN absencetype ON leavecategory.absencetypeid = absencetype.id';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

        return Datatables::of($itemdata) 

        ->addColumn('action', function ($itemdata) {
          return '<a href="javascript:void(0)" title="Edit"  onclick="edit('."'".$itemdata->id."'".')"> Edit</a> | <a  href="javascript:void(0)" title="Delete" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->leavecategoryname."'".')"> Delete</a>';
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
        $post = new Leavecategory(); 
        $post->leavecategorycode = $request->leavecategorycode;
        $post->leavecategoryname = $request->leavecategoryname; 
        $post->absencetypeid = $request->absencetypeid; 
        $post->status = $request->status;
        $post->created_by = Auth::id();
        $post->save();

        return response()->json($post); 
      }
    }

    public function edit($id)
    {
      $leavecategory = Leavecategory::Find($id);
      echo json_encode($leavecategory); 
    }

    public function update($id, Request $request)
    {
      $validator = Validator::make(Input::all(), $this->rules);
      if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
      } else {
        $post = Leavecategory::Find($id); 
        $post->leavecategorycode = $request->leavecategorycode;
        $post->leavecategoryname = $request->leavecategoryname; 
        $post->absencetypeid = $request->absencetypeid; 
        $post->status = $request->status;
        $post->updated_by = Auth::id();
        $post->save();

        return response()->json($post); 
      }
    }

    public function delete($id)
    {
    //dd($id);
      $post =  Leavecategory::Find($id);
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
    // $post =  Leavecategory::where('id', $id["1"])->get();
      $post = Leavecategory::Find($id["1"]);
      $post->delete(); 
    }

    echo json_encode(array("status" => TRUE));

  }
}
