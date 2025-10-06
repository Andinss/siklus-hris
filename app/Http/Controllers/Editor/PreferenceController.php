<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Carbon\Carbon;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PreferenceRequest;
use App\Http\Controllers\Controller;
use App\Models\Preference; 
use Validator;
use Response;
use App\Post;
use View;

class PreferenceController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [
    'preferenceno' => 'required|min:2|max:32|regex:/^[a-z ,.\'-]+$/i',
    'preferencename' => 'required|min:2|max:128|regex:/^[a-z ,.\'-]+$/i'
  ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function __construct() {

    $preference = Preference::Where('id', 1)->first();    
    View::share ( 'preference', $preference, compact('preference') );
  }  

  public function edit($id)
  {
    $preference = Preference::Where('id', $id)->first();    

    return view ('editor.preference.form', compact('preference'));
  }

  public function update($id, Request $request)
  { 

      $preference = Preference::Find($id);
      $preference->company_name = $request->input('company_name');
      $preference->address = $request->input('address');
      $preference->phone = $request->input('phone');
      $preference->email = $request->input('email'); 
      $preference->created_by = Auth::id();
      $preference->save();

    if($request->logo)
    {
      $preference = Preference::FindOrFail($preference->id);
      $original_directory = "uploads/preference/";
      if(!File::exists($original_directory))
      {
        File::makeDirectory($original_directory, $mode = 0777, true, true);
      } 
      $preference->logo = Carbon::now()->format("d-m-Y h-i-s").$request->logo->getClientOriginalName();
      $request->logo->move($original_directory, $preference->logo);
      $preference->save(); 
    } 
    // return redirect('editor/preference');  

    return back();
  }
 
}
