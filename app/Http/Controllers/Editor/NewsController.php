<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\NewsRequest;
use App\Http\Controllers\Controller;
use App\Models\News; 
use Validator;
use Response;
use App\Post;
use View;

class NewsController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [
    'title' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $newss = News::all();
      return view ('editor.news.index', compact('newss'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 
        $itemdata = News::orderBy('date', 'ASC')->get();

        return Datatables::of($itemdata) 

        ->addColumn('action', function ($itemdata) {
          return '<a href="news/'.$itemdata->id.'/edit" title="Edit")"> Edit</a> | <a  href="javascript:void(0)" title="Delete" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->title."'".')"> Delete</a>';
        })

        ->addColumn('attachment', function ($itemdata) {
          if ($itemdata->attachment == null) {
            return '';
          }else{
           return '<a href="../uploads/news/'.$itemdata->attachment.'" target="_blank"/><i class="fa fa-download"></i> Download</a>';
         };  
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

    public function create()
    { 
      return view ('editor.news.form');
    }

    public function store(Request $request)
    { 
      $validator = Validator::make(Input::all(), $this->rules);
      if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
      } else {
       $news = new News; 
       $news->title = $request->input('title');
       $news->date = $request->input('date');
       $news->created_by = Auth::id();
       $news->save();

       if($request->attachment)
       {
        $news = News::FindOrFail($news->id);
        $original_directory = "uploads/news/";
        if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          } 
          $news->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
          $request->attachment->move($original_directory, $news->attachment);
          $news->save(); 
        } 
        return redirect('editor/news'); 
      }
    }

    public function edit($id)
    {
      $news = News::Where('id', $id)->first();    
      return view ('editor.news.form', compact('news'));
    }

    public function update($id, Request $request)
    {
      $news = News::Find($id);
      $news->title = $request->input('title');
      $news->date = $request->input('date');
      $news->created_by = Auth::id();
      $news->save();

      if($request->attachment)
      {
        $news = News::FindOrFail($news->id);
        $original_directory = "uploads/news/";
        if(!File::exists($original_directory))
          {
            File::makeDirectory($original_directory, $mode = 0777, true, true);
          } 
          $news->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
          $request->attachment->move($original_directory, $news->attachment);
          $news->save(); 
        } 
        return redirect('editor/news');  
      }

      public function delete($id)
      {
    //dd($id);
        $post =  News::Find($id);
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
    // $post =  News::where('id', $id["1"])->get();
        $post = News::Find($id["1"]);
        $post->delete(); 
      }

      echo json_encode(array("status" => TRUE));

    }
  }
