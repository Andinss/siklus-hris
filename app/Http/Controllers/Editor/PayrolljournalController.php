<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PayrollRequest;
use App\Http\Controllers\Controller;
use App\Models\Payroll; 
use App\Models\Payperiod;
use App\Models\Department;
use App\Models\User;
use Validator;
use Response;
use App\Post;
use View;
use Excel;


//Editor
use
    App\Editor,
    App\Editor\Field,
    App\Editor\Format,
    App\Editor\Mjoin,
    App\Editor\Options,
    App\Editor\Upload,
    App\Editor\Validate;

class PayrolljournalController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'payrollname' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index()
  {
    $payrolls = Payroll::all();
    $payperiod_list = Payperiod::all()->pluck('description', 'id');
    $department_list = Department::all()->pluck('departmentname', 'departmentcode');

    return view ('editor.payrolljournal.index', compact('payrolls','payperiod_list','department_list'));
  }

  public function storeexport(Request $request, $id, $type)
  {
 
    $sql = 'SELECT
              payperiod.description AS Period,
              "IDR" AS Currency,
              FORMAT(SUM(payroll.netto),0) AS Debt,
              FORMAT(SUM(payroll.netto),0) AS Credit,
              NOW() AS DateProcess
            FROM
              payroll
            INNER JOIN payperiod ON payroll.periodid = payperiod.id
            WHERE payperiod.id = '.$id.'
            GROUP BY
              payperiod.id,
              payperiod.description';

    $data = DB::table(DB::raw("($sql) as rs_sql"))->get();

    $data = collect($data)->map(function($x){ return (array) $x; })->toArray();
    return Excel::create('payroll_journal_'.$id.'', function($excel) use ($data) {
      $excel->sheet('mySheet', function($sheet) use ($data)
      {
        $sheet->fromArray($data);
      });
    })->download($type);
  }
}
