<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\DocumentRequest;
use App\Http\Controllers\Controller;
use App\Models\Document; 
use Validator;
use Response;
use App\Post;
use View;

class DocumentController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [
    'documentno' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
    'documentname' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
  ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $documents = Document::all();
      return view ('editor.document.index', compact('documents'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 
        $itemdata = Document::orderBy('documentname', 'ASC')->get();

        return DataTables::of($itemdata) 

        ->addColumn('action', function ($itemdata) {
          return '<a href="document/'.$itemdata->id.'/edit" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"> <i class="fas fa-pen"></i> Edit</a> <a href="javascript:void(0)" title="Hapus" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->documentname."'".')" class="btn btn-sm btn-outline-danger d-inline-block"> <i class="fas fa-trash-alt"></i> Hapus</a>';
        })
        ->addColumn('attachment', function ($itemdata) {
          if ($itemdata->attachment == null) {
            return '';
          }else{
           return '<a href="'.asset("assets/uploads/document/".$itemdata->attachment).'" target="_blank"/><i class="fas fa-download"></i> Download</a>';
         };  
       })
       ->toJson();
      } else {
        exit("No data available");
      }
    }

    public function create()
    { 

      return view ('editor.document.form');
    }

    public function store(Request $request)
    {  

       $date_array = explode("-",$request->input('documentdate')); // split the array
       $var_day = $date_array[0]; //day seqment
       $var_month = $date_array[1]; //month segment
       $var_year = $date_array[2]; //year segment
       $new_date_format = "$var_year-$var_month-$var_day"; // join them together

       $expired_date_array = explode("-",$request->input('expireddate')); // split the array
       $var_day_ex = $expired_date_array[0]; //day seqment
       $var_month_ex = $expired_date_array[1]; //month segment
       $var_year_ex = $expired_date_array[2]; //year segment
       $new_expired_date_format = "$var_year_ex-$var_month_ex-$var_day_ex"; // join them together
 
       $document = new Document; 
       $document->documentno = $request->input('documentno');
       $document->documentname = $request->input('documentname');
       $document->documentdate = $new_date_format;
       $document->expireddate = $new_expired_date_format;
       $document->dayprocess = $request->input('dayprocess');
       $document->amount = $request->input('amount'); 
       $document->created_by = Auth::id();
       $document->save();

       if($request->attachment)
       {
        $document = Document::FindOrFail($document->id);
        $original_directory = "uploads/document/";
        if(!File::exists($original_directory))
        {
          File::makeDirectory($original_directory, $mode = 0777, true, true);
        } 
        $document->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
        $request->attachment->move($original_directory, $document->attachment);
        $document->save(); 
      } 
      return redirect('editor/document'); 
  }

  public function edit($id)
  {
    $document = Document::Where('id', $id)->first();    

    return view ('editor.document.form', compact('document'));
  }

  public function update($id, Request $request)
  {
      $date_array = explode("-",$request->input('documentdate')); // split the array
      $var_day = $date_array[0]; //day seqment
      $var_month = $date_array[1]; //month segment
      $var_year = $date_array[2]; //year segment
      $new_date_format = "$var_year-$var_month-$var_day"; // join them together

      $expired_date_array = explode("-",$request->input('expireddate')); // split the array
      $var_day_ex = $expired_date_array[0]; //day seqment
      $var_month_ex = $expired_date_array[1]; //month segment
      $var_year_ex = $expired_date_array[2]; //year segment
      $new_expired_date_format = "$var_year_ex-$var_month_ex-$var_day_ex"; // join them together

      $document = Document::Find($id);
      $document->documentno = $request->input('documentno');
      $document->documentname = $request->input('documentname');
      $document->documentdate = $new_date_format;
      $document->expireddate = $new_expired_date_format;
      $document->dayprocess = $request->input('dayprocess');
      $document->amount = $request->input('amount'); 
      $document->created_by = Auth::id();
      $document->save();

    if($request->attachment)
    {
      $document = Document::FindOrFail($document->id);
      $original_directory = "uploads/document/";
      if(!File::exists($original_directory))
      {
        File::makeDirectory($original_directory, $mode = 0777, true, true);
      } 
      $document->attachment = Carbon::now()->format("d-m-Y h-i-s").$request->attachment->getClientOriginalName();
      $request->attachment->move($original_directory, $document->attachment);
      $document->save(); 
    } 
    return redirect('editor/document');  
  }

  public function delete($id)
  {
    //dd($id);
    $post =  Document::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }

  public function deletebulk(Request $request)
  {

   $idkey = $request->idkey;   

   foreach($idkey as $key => $id)
   {
    $post = Document::Find($id["1"]);
    $post->delete(); 
  }

  echo json_encode(array("status" => TRUE));

}
}
