<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PeriodRequest;
use App\Http\Controllers\Controller;
use App\Models\Period; 
use App\Models\Year;
use App\Models\PayrollType;
use App\Models\ShiftGroup;
use App\Models\Shift;
use App\Models\PeriodShift;
use Validator;
use Response;
use App\Post;
use View;

class PeriodController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'begin_date' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  { 
    $periods = Period::all();
    $year_list = Year::all()->pluck('year_name', 'year_name');
    $payroll_type_list = PayrollType::all()->pluck('payroll_type_name', 'id');
    $last_period_list = Period::all()->pluck('description', 'id');

    return view ('editor.period.index', compact('periods', 'year_list', 'payroll_type_list', 'last_period_list'));
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $sql = 'SELECT
              period.id,
              period.description,
              period.day_in,
              period.date_period,
              period.begin_date,
              period.end_date,
              period.benefit_begin_date,
              period.benefit_end_date,
              period.pay_date,
              period.`status`,
              period.`month`,
              period.`year`,
              payroll_type.payroll_type_name,
              last_period.description AS last_period
            FROM
              period
            LEFT JOIN payroll_type ON period.payroll_type_id = payroll_type.id
            LEFT JOIN (SELECT * FROM period) AS last_period ON period.last_period_id = last_period.id
            WHERE period.deleted_at IS NULL';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

      return DataTables::of($itemdata) 
       ->addColumn('action', function ($itemdata) {
        return '<a href="period/'.$itemdata->id.'/detail" title="'."'".$itemdata->description."'".'" title="Atur Shift" class="btn btn-sm btn-outline-secondary d-inline-block"> <i class="fas fa-pen"></i> Atur Shift</a>  <a href="#" onclick="edit('."'".$itemdata->id."'".')" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"> <i class="fas fa-pen"></i> Edit</a> <a href="javascript:void(0)" title="Hapus" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->description."'".')"> <i class="fas fa-trash-alt"></i> Hapus</a>';
      })
      ->addColumn('check', function ($itemdata) {
        return '<label class="control control--checkbox"> <input type="checkbox" class="data-check" value="'."'".$itemdata->id."'".'"> <div class="control__indicator"></div> </label>';
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
      $date_array_from = explode("-",$request->begin_date); // split the array
      $var_day_from = $date_array_from[0]; //day seqment
      $var_month_from = $date_array_from[1]; //month segment
      $var_year_from = $date_array_from[2]; //year segment
      $date_format_from = "$var_year_from-$var_month_from-$var_day_from"; // join them together


      $date_array_to = explode("-",$request->end_date); // split the array
      $var_day_to = $date_array_to[0]; //day seqment
      $var_month_to = $date_array_to[1]; //month segment
      $var_year_to = $date_array_to[2]; //year segment
      $date_format_to = "$var_year_to-$var_month_to-$var_day_to"; // join them together


      $date_array_pay = explode("-",$request->pay_date); // split the array
      $var_day_pay = $date_array_pay[0]; //day seqment
      $var_month_pay = $date_array_pay[1]; //month segment
      $var_year_pay = $date_array_pay[2]; //year segment
      $date_format_pay = "$var_year_pay-$var_month_pay-$var_day_pay"; // join them together

      $post = new Period(); 
      $post->description = $request->description; 
      $post->day_in = $request->day_in; 
      $post->begin_date = $date_format_from; 
      $post->end_date = $date_format_to; 
      $post->pay_date = $date_format_pay;  
      $post->status = $request->status;
      $post->created_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function edit($id)
  {
    // $period = Period::Find($id);
    $sql = 'SELECT
            period.id,
            period.description,
            period.day_in,
            period.date_period,
            DATE_FORMAT(period.begin_date,"%d-%m-%Y") AS begin_date,
            DATE_FORMAT(period.end_date,"%d-%m-%Y") AS end_date, 
            DATE_FORMAT(period.pay_date,"%d-%m-%Y") AS pay_date,
            period.`status`,
            period.`month`,
            period.`year`,
            payroll_type.payroll_type_name,
            last_period.description AS last_period
          FROM
            period
          LEFT JOIN payroll_type ON period.payroll_type_id = payroll_type.id
          LEFT JOIN (SELECT * FROM period) AS last_period ON period.last_period_id = last_period.id
          WHERE period.deleted_at IS NULL AND period.id = '.$id.'';
    $period = DB::table(DB::raw("($sql) as rs_sql"))->first(); 
    echo json_encode($period); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make($request->all(), $this->rules);
    if ($validator->fails()) {
        return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
    } else {

      $date_array_from = explode("-",$request->begin_date); // split the array
      $var_day_from = $date_array_from[0]; //day seqment
      $var_month_from = $date_array_from[1]; //month segment
      $var_year_from = $date_array_from[2]; //year segment
      $date_format_from = "$var_year_from-$var_month_from-$var_day_from"; // join them together


      $date_array_to = explode("-",$request->end_date); // split the array
      $var_day_to = $date_array_to[0]; //day seqment
      $var_month_to = $date_array_to[1]; //month segment
      $var_year_to = $date_array_to[2]; //year segment
      $date_format_to = "$var_year_to-$var_month_to-$var_day_to"; // join them together


      $date_array_pay = explode("-",$request->pay_date); // split the array
      $var_day_pay = $date_array_pay[0]; //day seqment
      $var_month_pay = $date_array_pay[1]; //month segment
      $var_year_pay = $date_array_pay[2]; //year segment
      $date_format_pay = "$var_year_pay-$var_month_pay-$var_day_pay"; // join them together

      
      $post = Period::Find($id);  
      $post->description = $request->description; 
      $post->day_in = $request->day_in; 
      $post->begin_date = $date_format_from; 
      $post->end_date = $date_format_to; 
      $post->pay_date = $date_format_pay;  
      $post->status = $request->status;
      $post->updated_by = Auth::id();
      $post->save();

      return response()->json($post); 
    }
  }

  public function delete($id)
  {
    $post =  Period::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }

  public function deletebulk(Request $request)
  {

    $idkey = $request->idkey;   

    foreach($idkey as $key => $id)
    {
      $post = Period::Find($id["1"]);
      $post->delete(); 
    }

    echo json_encode(array("status" => TRUE));

  }

  public function detail($id)
  {
    $shift_group_list = ShiftGroup::all(); 

    $sql = 'SELECT
              *
            FROM
              period';
    $period = DB::table(DB::raw("($sql) as rs_sql"))->where('id', $id)->first();

    return view('editor.period.form', compact('period', 'shift_group_list'));
  }

  public function data_detail(Request $request, $id)
  {   
   
    if($request->ajax()){ 

          $sql = 'SELECT
                    period_shift.id,
                    period_shift.day,
                    period_shift.shift_group_id, 
                    shift_group.shift_group_name
                  FROM
                    period_shift
                  LEFT JOIN shift_group ON period_shift.shift_group_id = shift_group.id 
                  WHERE period_shift.period_id = '.$id.' AND period_shift.deleted_at IS NULL
                  ORDER BY period_shift.day ASC';
          $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->orderBy('day', 'ASC')->get(); 

         return Datatables::of($itemdata) 

        ->addColumn('action', function ($itemdata) {
          return '<a  href="javascript:void(0)" title="Delete" class="btn btn-sm btn-danger d-inline-block" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->shift_group_name."'".')"><i class="fas fa-trash-alt"></i></a>';
        })

        ->addColumn('lbl_shift', function ($itemdata) {
          if($itemdata->shift_group_name == 'OFF'){
            return '<b style="color: red">'.$itemdata->shift_group_name.'</b>';
          }else{
            return ''.$itemdata->shift_group_name.'';  
          }
          
        })
      

        ->make(true);
      } else {
        exit("No data available");
    }
  }

   public function save_detail($id, Request $request)
  { 
      $post = new PeriodShift;
      $post->period_id = $id;  
      $post->shift_group_id = $request->shift_group_id;   
      $post->day = $request->day;   
      $post->save();

      return response()->json($post); 
  }

  public function delete_detail($id)
  {
    $post =  PeriodShift::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }
}
