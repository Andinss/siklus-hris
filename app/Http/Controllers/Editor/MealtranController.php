<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\MealtranRequest;
use App\Http\Controllers\Controller;
use App\Models\Payperiod;
use App\Models\Department;
use App\Models\Mealtran; 
use App\Models\Mealtrandet; 
use Validator;
use Response;
use App\Post;
use View;

class MealtranController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'periodid' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    $department_list = Department::all()->pluck('departmentname', 'id');
    $payperiod_list = Payperiod::all()->pluck('description', 'id');
    $mealtrans = Mealtran::all();
    return view ('editor.mealtran.index', compact('mealtrans','payperiod_list', 'department_list'));
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 
      $sql = 'SELECT
                mealtran.id,
                mealtran.departmentid,
                mealtran.periodid,
                department.departmentname,
                payperiod.description, 
                mealtran.status
              FROM
                mealtran
              LEFT JOIN department ON mealtran.departmentid = department.id
              LEFT JOIN payperiod ON mealtran.periodid = payperiod.id
              WHERE mealtran.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

      return Datatables::of($itemdata) 

      ->addColumn('action', function ($itemdata) {
        return '<a href="javascript:void(0)" title="Edit"  onclick="edit('."'".$itemdata->id."'".')"> Edit</a> | <a  href="javascript:void(0)" title="Delete" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->description."'".')"> Delete</a>';
      })

      ->addColumn('actiondetail', function ($itemdata) {
        return '<a href="mealtran/'.$itemdata->id.'/'.$itemdata->departmentid.'/editdetail" title="Detail" class="btn btn-primary btn-xs btn-flat"><i class="fa fa-folder"></i> Detail</a>';
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
    $post = new Mealtran(); 
    $post->periodid = $request->periodid; 
    $post->departmentid = $request->departmentid; 
    $post->status = $request->status;
    $post->created_by = Auth::id();
    $post->save();

    return response()->json($post); 
  }
  }

  public function edit($id)
  {
    $mealtran = Mealtran::Find($id);
    echo json_encode($mealtran); 
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
    $post = Mealtran::Find($id); 
    $post->periodid = $request->periodid; 
    $post->departmentid = $request->departmentid; 
    $post->status = $request->status;
    $post->updated_by = Auth::id();
    $post->save();

    return response()->json($post); 
  }
  }

  public function editdetail($id, $id2)
  {
    $mealtran = Mealtran::Find($id);
    $sql = 'SELECT
            employee.identityno,
            employee.employeename,
            employee.departmentid,
            mealtrandet.*,
            location.locationname
            FROM
            mealtrandet
            INNER JOIN employee ON mealtrandet.employeeid = employee.id
            LEFT JOIN location ON employee.locationid = location.idlocation
            WHERE mealtrandet.transid = '.$id.' AND employee.departmentid = '.$id2.'';
    $mealtran_detail = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

    return view ('editor.mealtran.form', compact('mealtran', 'mealtran_detail'));
  }

  public function updatedetail($id, $id2, Request $request)
  {
     foreach($request->input('detail') as $key => $detail_data)
    {
      $mealtran_detail = Mealtrandet::Find($key); 
      $mealtran_detail->day1 = $detail_data['day1']; 
      $mealtran_detail->day2 = $detail_data['day2'];
      $mealtran_detail->day3 = $detail_data['day3'];
      $mealtran_detail->day4 = $detail_data['day4'];
      $mealtran_detail->day5 = $detail_data['day5'];
      $mealtran_detail->tday = $detail_data['tday'];
      $mealtran_detail->perday = $detail_data['perday'];
      $mealtran_detail->addmeal = $detail_data['addmeal'];
      $mealtran_detail->tpotabsence = $detail_data['tpotabsence'];
      $mealtran_detail->amountpajak = $detail_data['amountpajak'];
      $mealtran_detail->amount = $detail_data['amount'];
      $mealtran_detail->save();
    } 

    return redirect()->action('Editor\MealtranController@index'); 
  }

  public function delete($id)
  {
    //dd($id);
    $post =  Mealtran::Find($id);
    $post->delete(); 

    return response()->json($post); 
  }

  public function generate($id)
  {  
    //dd("generate");
    //return response()->json($post); 
     DB::insert("INSERT INTO mealtrandet (employeeid, transid) SELECT
                  employee.id,
                  mealtran.id
                FROM
                  mealtran
                LEFT OUTER JOIN mealtrandet ON mealtran.id = mealtrandet.transid
                CROSS JOIN employee
                WHERE
                  (
                    mealtrandet.employeeid IS NULL
                  )
                AND mealtran.periodid = (
                  SELECT
                    `user`.periodid
                  FROM
                    `user`
                  WHERE
                    `user`.id = 1
                )
                AND employee.`status` = 0
                AND mealtran.departmentid = employee.departmentid");

      DB::update("UPDATE mealtrandet,
                   mealtran,
                   potabsence,
                   employee
                  SET mealtrandet.rateextrapudding = employee.extrapudding,
                   mealtrandet.perday = employee.mealtransrate,
                   mealtrandet.ratemealincity = employee.ratemealincity,
                   mealtrandet.ratemealoutcity = employee.ratemealoutcity,
                   mealtrandet.ratetunjmalam = ifnull(employee.ratetunjanganmalam, 0),
                   mealtrandet.employeestatus = employee.`status`,
                   mealtrandet.ratepotabsence = potabsence.potabsence
                  WHERE
                    employee.id = mealtrandet.employeeid
                  AND mealtran.id = mealtrandet.transid
                  AND mealtran.periodid = (
                    SELECT
                      `user`.periodid
                    FROM
                      `user`
                    WHERE
                      `user`.id = 1
                  )
                  AND employee.`status` = 0");
  }
}
