<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PayperiodRequest;
use App\Http\Controllers\Controller;
use App\Models\Payperiod; 
use App\Models\Year;
use App\Models\Payrolltype;
use Validator;
use Response;
use App\Post;
use View;

class PayperiodController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'begindate' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  { 
    $payperiods = Payperiod::all();
    $year_list = Year::all()->pluck('yearname', 'yearname');
    $payrolltype_list = Payrolltype::all()->pluck('payrolltypename', 'id');
    $lastperiod_list = Payperiod::all()->pluck('description', 'id');

    return view ('editor.payperiod.index', compact('payperiods', 'year_list', 'payrolltype_list', 'lastperiod_list'));
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $sql = 'SELECT
              payperiod.id,
              payperiod.description,
              payperiod.dateperiod,
              payperiod.begindate,
              payperiod.enddate,
              payperiod.benefitbegindate,
              payperiod.benefitenddate,
              payperiod.paydate,
              payperiod.`status`,
              payperiod.`month`,
              payperiod.`year`,
              payrolltype.payrolltypename,
              lastperiod.description AS lastperiod
            FROM
              payperiod
            LEFT JOIN payrolltype ON payperiod.payrolltypeid = payrolltype.id
            LEFT JOIN (SELECT * FROM payperiod) AS lastperiod ON payperiod.lastperiodid = lastperiod.id
            WHERE payperiod.deleted_at IS NULL';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

      return Datatables::of($itemdata) 

      ->addColumn('action', function ($itemdata) {
        return '<a href="javascript:void(0)" title="Edit"  onclick="edit('."'".$itemdata->id."'".')"> Edit</a> | <a  href="javascript:void(0)" title="Delete" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->description."'".')"> Delete</a>';
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
    $post = new Payperiod(); 
    $post->description = $request->description; 
    $post->dateperiod = $request->dateperiod; 
    $post->begindate = $request->begindate; 
    $post->enddate = $request->enddate; 
    $post->benefitbegindate = $request->benefitbegindate; 
    $post->benefitenddate = $request->benefitenddate; 
    $post->paydate = $request->paydate; 
    // $post->month = $request->month; 
    // $post->year = $request->year;  
    $post->payrolltypeid = $request->payrolltypeid; 
    $post->lastperiodid = $request->lastperiodid; 
    $post->status = $request->status;
    $post->created_by = Auth::id();
    $post->save();

    return response()->json($post); 
  }
  }

  public function edit($id)
  {
    $payperiod = Payperiod::Find($id);
    echo json_encode($payperiod); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
    $post = Payperiod::Find($id);  
    $post->description = $request->description; 
    $post->dateperiod = $request->dateperiod; 
    $post->begindate = $request->begindate; 
    $post->enddate = $request->enddate; 
    $post->benefitbegindate = $request->benefitbegindate; 
    $post->benefitenddate = $request->benefitenddate; 
    $post->paydate = $request->paydate; 
    // $post->month = $request->month; 
    // $post->year = $request->year;  
    $post->payrolltypeid = $request->payrolltypeid; 
    $post->lastperiodid = $request->lastperiodid; 
    $post->status = $request->status;
    $post->updated_by = Auth::id();
    $post->save();

    return response()->json($post); 
  }
  }

  public function delete($id)
  {
    //dd($id);
    $post =  Payperiod::Find($id);
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
    // $post =  Payperiod::where('id', $id["1"])->get();
    $post = Payperiod::Find($id["1"]);
    $post->delete(); 
  }

  echo json_encode(array("status" => TRUE));

}
}
