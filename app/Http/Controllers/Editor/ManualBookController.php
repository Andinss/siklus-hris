<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\ManualBookRequest;
use App\Http\Controllers\Controller; 
use App\Models\ManualBook;  
use App\Models\UserLog;   
use App\Models\Module;   
use Validator;
use Response;
use App\Post;
use View;

class ManualBookController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'manual_book_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  { 
    return view ('editor.manual_book.index');
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $manual_book_data = ManualBook::all();

      return Datatables::of($manual_book_data) 

      ->addColumn('action', function ($manual_book_data) {
        return '<a href="manual-book/edit/'.$manual_book_data->id.'" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Edit</a> <a  href="javascript:void(0)" title="Delete" class="btn btn-danger btn-xs" onclick="delete_id('."'".$manual_book_data->id."', '".$manual_book_data->manual_book_name."'".')"> <i class="ti-trash"></i> Hapus</a>';
      })
 

      ->addColumn('mstatus', function ($manual_book_data) {
        if ($manual_book_data->status == 0) {
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

    $module_list = Module::all()->pluck('description', 'name');

    return view ('editor.manual_book.form', compact('module_list'));
  }

  public function store(Request $request)
  {  
    $manual_book = new ManualBook(); 
    $manual_book->manual_book_name = $request->input('manual_book_name');    
    $manual_book->content = $request->input('content');  
    $manual_book->module_name = $request->input('module_name');    
    $manual_book->created_by = Auth::id();
    $manual_book->save();

    $userLog = UserLog::create([
                'user_id' => Auth::id(),
                'scope' => 'CUSTOMER TYPE',
                'data' => json_encode([
                    'action' => 'create',
                    'manual_book_id' => $manual_book->id 
                ])
            ]);

    return redirect()->action('Editor\ManualBookController@index'); 
  }

  public function edit($id)
  {
    $manual_book = ManualBook::find($id);  
    $module_list = Module::all()->pluck('description', 'name');

    return view ('editor.manual_book.form', compact('manual_book', 'module_list'));
  }

  public function update($id, Request $request)
  {
     
    $manual_book = ManualBook::Find($id);  
    $manual_book->manual_book_name = $request->input('manual_book_name');  
    $manual_book->content = $request->input('content');  
    $manual_book->module_name = $request->input('module_name');  
    $manual_book->updated_by = Auth::id();
    $manual_book->save();

    $userLog = UserLog::create([
                'user_id' => Auth::id(),
                'scope' => 'CUSTOMER TYPE',
                'data' => json_encode([
                    'action' => 'update',
                    'manual_book_id' => $manual_book->id 
                ])
            ]);

    return redirect()->action('Editor\ManualBookController@index'); 
  }

  public function show($id)
  {
    $manual_book = ManualBook::where('module_name', $id)->first();  

    return view ('editor.manual_book.show', compact('manual_book'));
  }

  public function delete($id)
  {
    $post =  ManualBook::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }

}
