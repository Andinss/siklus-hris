<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\LoanRequest;
use App\Http\Controllers\Controller;
use App\Models\Loan; 
use App\Models\Loandetail;
use App\Models\Loantype;
use App\Models\Employee;
use App\Models\Year;
use App\Models\Month;
use Validator;
use Response;
use App\Post;
use View;

class LoanController extends Controller
{
  /**
    * @var array
    */
  protected $rules =
  [ 
  'transdate' => 'required'
  ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
      $loans = Loan::all();
      return view ('editor.loan.index', compact('loans'));
    }

    public function data(Request $request)
    {   
      if($request->ajax()){ 

        $sql = 'SELECT
                  loan.id,
                  loan.codetrans,
                  loan.notrans,
                  DATE_FORMAT(loan.datetrans, "%d-%m-%Y") AS datetrans,
                  DATE_FORMAT(loan.loanapproved, "%d-%m-%Y") AS loanapproved,
                  loantype.loantypename,
                  loan.loantypeid,
                  loan.employeeid,
                  employee.nik,
                  employee.employeename,
                  FORMAT(loan.requestamount, 0) AS requestamount,
                  FORMAT(loan.approvedamount, 0) AS approvedamount,
                  FORMAT(loan.paid, 0) AS paid,
                  FORMAT(loan.remain, 0) AS remain,
                  loan.remark AS remark,
                  loan.status
                FROM
                  loan
                LEFT JOIN loantype ON loan.loantypeid = loantype.id
                LEFT JOIN employee ON loan.employeeid = employee.id';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->orderBy('status', 'asc')->orderBy('id', 'asc')->get(); 

        return Datatables::of($itemdata) 

        ->addColumn('check', function ($itemdata) {
          return '<label class="control control--checkbox"> <input type="checkbox" class="data-check" value="'."'".$itemdata->id."'".'"> <div class="control__indicator"></div> </label>';
        })

        ->addColumn('action', function ($itemdata) {
          return '<a href="loan/detail/'.$itemdata->id.'" title="'."'".$itemdata->notrans."'".'"  onclick="edit('."'".$itemdata->id."'".')"> '.$itemdata->notrans.'</a>';
        })

        ->addColumn('mstatus', function ($itemdata) {
          if ($itemdata->status < 2) {
            return '<span class="label label-success"> Active </span>';
          }elseif($itemdata->status == 2){
            return '<span class="label label-warning"> Clear </span>';
          }else{
           return '<span class="label label-danger"> Cancel </span>';
         };

       })
        ->make(true);
      } else {
        exit("No data available");
      }
    }
 
  public function detail($id)
    {
      $employee_list = Employee::all()->pluck('employeename', 'id'); 
      $loantype_list = Loantype::all()->pluck('loantypename', 'id'); 
      $month_list = Month::all()->pluck('monthname', 'id'); 
      $year_list = Year::all()->pluck('yearname', 'yearname'); 

      //dd($used_list);
      // $loan = Loan::Find($id); 
      $sqlm = 'SELECT
              loan.id,
              loan.codetrans,
              loan.notrans,
              loan.datetrans,
              loan.loanapproved,
              loan.loantypeid,
              loan.employeeid,
              FORMAT(loan.requestamount,0) AS requestamount,
              FORMAT(loan.approvedamount,0) AS approvedamount,
              loan.paid,
              loan.remain,
              loan.period,
              loan.remark,
              loan.`status`
            FROM
              loan
            WHERE loan.id = '.$id.'';
      $loan = DB::table(DB::raw("($sqlm) as rs_sql"))->first();
      return view ('editor.loan.form', compact('employee_list', 'loan', 'loantype_list', 'month_list', 'year_list'));
    }


    public function generate($id, Request $request)
    { 

      $post = Loan::Find($id); 
      $post->loantypeid = $request->loantypeid; 
      $post->employeeid = $request->employeeid; 
      $post->requestamount = str_replace(',', '', $request->requestamount); 
      $post->approvedamount = str_replace(',', '', $request->approvedamount); 
      $post->remark = $request->remark;  
      $post->loanapproved = $request->loanapproved;  
      $post->period = $request->period;  
      $post->updated_by = Auth::id();
      $post->save();

      $sql_year = 'SELECT
                    id,
                    YEAR (loanapproved) AS vyear,
                    MONTH(loanapproved) AS vmonth,
                    period
                  FROM
                    loan
                  WHERE
                    id = '.$id.''; 
      $year = DB::table(DB::raw("($sql_year) as rs_sql"))->first();  

      for($i = 0; $i <= $year->period - 1; $i++) {

        $val_month = ($year->vmonth) + ($i); 
        $val_year = $year->vyear;

        if($val_month < 13){
          $val_month = ($year->vmonth) + ($i);
        };

        if($val_month > 12 && $val_month < 25){
          $val_month = $val_month - 12;
          $val_year = $year->vyear + 1;
        };

        if($val_month >= 25 && $val_month < 37){
          $val_month = $val_month - 24;
          $val_year = $year->vyear + 2;
        };

        if($val_month >= 37 && $val_month < 49){
          $val_month = $val_month - 36;
          $val_year = $year->vyear + 3;
        };

        if($val_month >= 49 && $val_month < 61){
          $val_month = $val_month - 48;
          $val_year = $year->vyear + 4;
        };


        if($val_month >= 61 && $val_month < 73){
          $val_month = $val_month - 60;
          $val_year = $year->vyear + 5;
        };

        if($val_month >= 73 && $val_month < 85){
          $val_month = $val_month - 72;
          $val_year = $year->vyear + 6;
        };


        if($val_month >= 85 && $val_month < 97){
          $val_month = $val_month - 84;
          $val_year = $year->vyear + 6;
        };

        if($val_month >= 97 && $val_month < 109){
          $val_month = $val_month - 96;
          $val_year = $year->vyear + 7;
        };

        if($val_month >= 109 && $val_month < 121){
          $val_month = $val_month - 108;
          $val_year = $year->vyear + 8;
        };

        if($val_month >= 121 && $val_month < 133){
          $val_month = $val_month - 120;
          $val_year = $year->vyear + 9;
        };

        if($val_month >= 133 && $val_month < 145){
          $val_month = $val_month - 132;
          $val_year = $year->vyear + 10;
        };

        if($val_month >= 145 && $val_month < 157){
          $val_month = $val_month - 144;
          $val_year = $year->vyear + 11;
        };

        if($val_month >= 157 && $val_month < 169){
          $val_month = $val_month - 156;
          $val_year = $year->vyear + 12;
        };

        if($val_month >= 169 && $val_month < 181){
          $val_month = $val_month - 168;
          $val_year = $year->vyear + 13;
        };

        if($val_month >= 181 && $val_month < 193){
          $val_month = $val_month - 180;
          $val_year = $year->vyear + 14;
        };

        if($val_month >= 193 && $val_month < 205){
          $val_month = $val_month - 192;
          $val_year = $year->vyear + 15;
        };

        DB::insert("INSERT INTO loandet (transid, year, month, amount)
        SELECT id, ".$val_year.", ".$val_month.", ROUND(loan.approvedamount / period) AS amount
        FROM
          loan
        WHERE id= '".$id."' AND CONCAT(".$val_year.", '_', ".$val_month.") NOT IN (SELECT 
          CONCAT(loandet.`year`, '_',
          loandet.`month`) AS x
        FROM
          loandet WHERE loandet.transid = ".$id." AND  loandet.deleted_at IS NULL)");

      };

      $sql_remain = 'SELECT
                      loandet.id,
                      loandet.`year`,
                      loandet.`month`,
                      loandet.amount
                    FROM
                      loandet
                    WHERE
                      transid = '.$id.''; 
      $rs_remain = DB::table(DB::raw("($sql_remain) as rs_sql"))->get(); 

      foreach ($rs_remain as $key => $val_remain) {
      
          DB::update("UPDATE loandet,
                     (
                      SELECT
                        SUM(
                          loandet.amount - loandet.paid
                        ) AS remain
                      FROM
                        loandet
                      WHERE
                        (loandet.`month` = ".$val_remain->month." OR loandet.`month` > ".$val_remain->month.")
                      AND (
                        loandet.`year` = ".$val_remain->year."
                        OR loandet.`year` > ".$val_remain->year."
                      ) 
                      AND transid = ".$id." AND deleted_at IS NULL
                    ) AS remain
                    SET loandet.remain = remain.remain
                    WHERE
                      loandet.id = ".$val_remain->id." "); 


          // DB::update("UPDATE loandet,
          //            (
          //             SELECT
          //               SUM(
          //                 loandet.amount - loandet.paid
          //               ) AS remain
          //             FROM
          //               loandet
          //             WHERE transid = ".$id." AND deleted_at IS NULL
          //             HAVING
          //             SUM(
          //                 loandet.paid
          //               ) = 0
          //           ) AS remain
          //           SET loandet.remain = remain.remain
          //           WHERE
          //             loandet.id = ".$val_remain->id.""); 

      };

    }


    public function slip($id)
    {
       $loan = \DB::select(\DB::raw("
           SELECT
              loan.id,
              loan.codetrans,
              loan.notrans,
              loan.datetrans,
              loan.departmentid,
              loan.departmentcode,
              loan.datefrom,
              loan.dateto,
              employee.employeename,
              department.departmentname,
              loan.timefrom,
              loan.timeto,
              loan.loanin,
              loan.loanout,
              loan.periodid,
              loan.remark,
              loan.planwork,
              loan.actualwork,
              loan.location
            FROM
              loan
            INNER JOIN loandet ON loan.id = loandet.transid
            INNER JOIN employee ON loandet.employeeid = employee.id
            INNER JOIN department ON employee.departmentid = department.id WHERE loan.id = ".$id."

        "));


      return view ('editor.loan.slip', compact('loan'));
    }


    public function store(Request $request)
    { 

      $userid= Auth::id();
      $codetrans = $request->input('codetrans'); 

       DB::insert("INSERT INTO loan (codetrans, notrans, datetrans, created_by, created_at)
      SELECT '".$codetrans."',
      IFNULL(CONCAT('".$codetrans."','-',DATE_FORMAT(NOW(), '%d%m%y'),RIGHT((RIGHT(MAX(RIGHT(loan.notrans,5)),5))+100001,5)), CONCAT('".$codetrans."','-',DATE_FORMAT(NOW(), '%d%m%y'),'00001')), DATE(NOW()), '".$userid."', DATE(NOW()) 
      FROM
      loan
      WHERE codetrans= '".$codetrans."'");

      $lastInsertedID = DB::table('loan')->max('id');
      //return redirect()->action('Editor\LoanController@edit', $lastInsertedID->id);
      return redirect('editor/loan/detail/'.$lastInsertedID.''); 
    }

    public function saveheader($id, Request $request)
    { 
        $post = Loan::Find($id); 
        $post->loantypeid = $request->loantypeid; 
        $post->employeeid = $request->employeeid; 
        $post->requestamount = str_replace(',', '', $request->requestamount); 
        $post->approvedamount = str_replace(',', '', $request->approvedamount); 
        $post->remark = $request->remark;  
        $post->loanapproved = $request->loanapproved;  
        $post->period = $request->period;  
        $post->updated_by = Auth::id();
        $post->save();

        return response()->json($post); 
      
    }

    public function update($id, Request $request)
    { 
        $post = Loan::Find($id); 
        $post->loantypeid = $request->input('loantypeid'); 
        $post->employeeid = $request->input('employeeid'); 
        $post->requestamount = str_replace(",", "", $request->input('requestamount')); 
        $post->approvedamount = str_replace(",", "", $request->input('approvedamount')); 
        $post->period = $request->input('period');   
        $post->updated_by = Auth::id();
        $post->save();

        return redirect('editor/loan');   
      
    }


     public function savedetail($id, Request $request)
    { 
        $post = new Loandetail;
        $post->transid = $id;  
        $post->year = $request->year;   
        $post->month = $request->month;   
        // $post->paid = $request->paid;   
        $post->amount = $request->amount;   
        $post->bonus = $request->bonus;   
        // $post->remain = $request->remain;   
        $post->save();

        // return response()->json($post); 
      
    }

    public function deletedet($id)
    {
    //dd($id);
      $post =  Loandetail::where('id', $id);
      $post->delete(); 

      return response()->json($post); 
    }

    public function deletebulk(Request $request)
    {

     $idkey = $request->idkey;   
 
     foreach($idkey as $key => $id)
     {
    // $post =  Loan::where('id', $id["1"])->get();
      $post = Loan::Find($id["1"]);
      $post->delete(); 
    }

    echo json_encode(array("status" => TRUE));

  }

  public function editdetail($id)
  {
    $loandetail = Loandetail::Find($id);
    echo json_encode($loandetail); 
  }

  public function updatedetail($id, Request $request)
  {
    $post = Loandetail::Find($id); 
    // $post->remain = $request->remain; 
    $post->month = $request->month;
    // $post->paid = $request->paid;
    $post->amount = $request->amount;
    $post->bonus = $request->bonus;
    $post->year = $request->year;
    $post->save();


        return redirect('editor/loan');   
    
    // return response()->json($post); 
  }

  public function datadetail(Request $request, $id)
    {   
     
    if($request->ajax()){ 

        $sql = 'SELECT
                  loandet.id AS id,
                  loandet.idtrans,
                  loandet.transid,
                  loandet.`year`,
                  `month`.monthname,
                  loandet.`month`,
                  FORMAT(loandet.amount,0) AS amount,
                  FORMAT(loandet.bonus,0) AS bonus,
                  FORMAT(loandet.paid,0) AS paid,
                  FORMAT(loandet.remain,0) AS remain,
                  FORMAT(IFNULL(loandet.amount,0) - IFNULL(loandet.paid,0),0) AS val_remain
                FROM
                  loandet
                LEFT JOIN `month` ON loandet.`month` = `month`.id
                WHERE loandet.transid = '.$id.' AND loandet.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get(); 

       return Datatables::of($itemdata) 

      ->addColumn('action', function ($itemdata) {
        return '<a  href="javascript:void(0)" title="Edit" class="btn btn-primary btn-xs" onclick="edit('."'".$itemdata->id."', '".$itemdata->monthname."'".')"><i class="fa fa-pencil"></i></a> | <a  href="javascript:void(0)" title="Delete" class="btn btn-danger btn-xs" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->monthname."'".')"><i class="fa fa-trash"></i></a>';
      })
   
      ->make(true);
    } else {
      exit("No data available");
    }
    }
}
