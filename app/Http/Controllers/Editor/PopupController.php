<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PopupRequest;
use App\Http\Controllers\Controller;
use App\Models\Popup; 
use Validator;
use Response;
use App\Post;
use View;

class PopupController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'popupname' => 'required|min:2'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    $popup = Popup::all();
    return view ('editor.popup.index', compact('popup'));
  }

  public function edit($id)
    {
      $popup = Popup::find($id);
      return view ('editor.popup.form', compact('popup'));
    }

    public function update($id, Request $request)
    {
      $popup = Popup::find($id);
      $popup->popup_name = $request->input('popup_name');
      $popup->description = $request->input('description');
      $popup->date_popup = $request->input('date');
      $popup->save();
      return redirect()->action('Editor\PopupController@index');
    }
}
