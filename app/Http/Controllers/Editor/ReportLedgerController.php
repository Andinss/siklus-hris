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
use App\Models\Department;
use App\Models\Employee;
use Validator;
use Response;
use App\Post;
use View;
use App\Models\User;

class ReportLedgerController extends Controller
{
  
  public function index()
  { 
    return view ('editor.report_ledger.index');
  }

  public function report_print($id1, $id2, $id3, $id4)
  { 
    $userid = Auth::id();
    $datafilter = User::where('id', Auth::id())->first();
    $department_list = Department::all()->pluck('departmentname', 'id');
    $employee_list = Employee::all()->pluck('employeename', 'id');
    $year = $id2;

    $sqldatafilterbefore = 'SELECT
                    `month2`.id,
                    `month2`.monthname
                  FROM
                    `month2`
                  WHERE id = CASE WHEN '.$id1.' = 1 THEN 12 ELSE '.$id1.'-1 END';
    $datafilterbefore = DB::table(DB::raw("($sqldatafilterbefore) as rs_sql"))->first(); 

     $sqlremain_before = 'SELECT SUM(devdtbl.amount) as amount FROM 
                    ( 
                    SELECT
                          SUM(cash_receive_detail.debt) AS amount
                        FROM
                          cash_receive
                        INNER JOIN cash_receive_detail ON cash_receive.id = cash_receive_detail.trans_id
                        WHERE
                          DATE_FORMAT(
                            cash_receive.cash_receive_date,
                            "%c"
                          ) <= '.$id1.' -1
                        AND DATE_FORMAT(
                          cash_receive.cash_receive_date,
                          "%Y"
                        ) = CASE WHEN '.$id1.' -1 = 0 THEN '.$id2.' -1 ELSE '.$id2.' END  AND cash_receive_detail.deleted_at IS NULL
                      UNION ALL
                      SELECT 
                        - SUM(cash_payment_detail.debt) AS amount
                      FROM
                        cash_payment_detail
                      INNER JOIN cash_payment ON cash_payment_detail.trans_id = cash_payment.id
                      JOIN coa ON cash_payment_detail.coa_id = coa.id 
                      WHERE
                        DATE_FORMAT(
                          cash_payment.cash_payment_date,
                          "%c"
                        ) <= '.$id1.' -1
                      AND DATE_FORMAT(
                        cash_payment.cash_payment_date,
                        "%Y"
                      ) = CASE WHEN '.$id1.' -1 = 0 THEN '.$id2.' -1 ELSE '.$id2.' END AND cash_payment_detail.deleted_at IS NULL
                    ) AS devdtbl';
      $remain_before = DB::table(DB::raw("($sqlremain_before) as rs_sql"))->first(); 

      

      if(isset($remain_before->amount)){
        $remain_before_amount = $remain_before->amount;
      }else{
        $remain_before_amount = 0;
      };

    $sql = 'SELECT
              * 
            FROM
              (
              SELECT 
                "-" AS date_trans,
                "-" AS no_trans,
                "-" AS coa_code,
                "Saldo Awal '.$datafilterbefore->monthname.'" AS coa_name,
                '.$remain_before_amount.' AS debt,
                0 AS credit
              UNION ALL
              SELECT
                cash_payment.cash_payment_date AS date_trans,
                cash_payment.cash_payment_no AS no_trans,
                coa.coa_code,
                coa.coa_name,
                0 AS debt,
                cash_payment_detail.debt AS credit 
              FROM
                cash_payment
                JOIN cash_payment_detail ON cash_payment.id = cash_payment_detail.trans_id
                JOIN coa ON cash_payment_detail.coa_id = coa.id 
              WHERE
              DATE_FORMAT(
                cash_payment.cash_payment_date,
                "%c"
              ) = '.$id1.'  AND cash_payment_detail.deleted_at IS NULL AND (DATE_FORMAT(
                cash_payment.cash_payment_date,
                "%d"
              ) BETWEEN '.$id3.' AND '.$id4.')
              UNION ALL
              SELECT
                cash_receive.cash_receive_date AS date_trans,
                cash_receive.cash_receive_no AS no_trans,
                coa.coa_code,
                coa.coa_name,
                cash_receive_detail.debt AS debt,
                cash_receive_detail.credit AS credit 
              FROM
                cash_receive
                JOIN cash_receive_detail ON cash_receive.id = cash_receive_detail.trans_id
                JOIN coa ON cash_receive_detail.coa_id = coa.id 
              WHERE
              DATE_FORMAT(
                cash_receive.cash_receive_date,
                "%c"
              ) = '.$id1.'  AND cash_receive_detail.deleted_at IS NULL AND (DATE_FORMAT(
                cash_receive.cash_receive_date,
                "%d"
              ) BETWEEN '.$id3.' AND '.$id4.') 
              ) AS derivdtbl 
            ORDER BY
              derivdtbl.no_trans, derivdtbl.date_trans';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->orderBy('date_trans', 'ASC')->orderBy('no_trans', 'ASC')->get(); 

      $sqldatafilter = 'SELECT
                          `month2`.id,
                          `month2`.monthname
                        FROM
                          `month2`
                        WHERE id = '.$id1.'';
      $datafilter = DB::table(DB::raw("($sqldatafilter) as rs_sql"))->first(); 




      $sqldatareceive = 'SELECT SUM(devdtbl.amount) as amount FROM 
                    ( 

                    SELECT
                          SUM(cash_receive_detail.debt) AS amount
                        FROM
                          cash_receive
                        INNER JOIN cash_receive_detail ON cash_receive.id = cash_receive_detail.trans_id
                        WHERE
                          DATE_FORMAT(
                            cash_receive.cash_receive_date,
                            "%c"
                          ) = '.$id1.'
                        AND DATE_FORMAT(
                          cash_receive.cash_receive_date,
                          "%Y"
                        ) = '.$id2.'  AND cash_receive_detail.deleted_at IS NULL AND (DATE_FORMAT(
                cash_receive.cash_receive_date,
                "%d"
              ) BETWEEN '.$id3.' AND '.$id4.')  AND cash_receive_detail.deleted_at IS NULL 
                    ) AS devdtbl';
      $datareceive = DB::table(DB::raw("($sqldatareceive) as rs_sql"))->first(); 


       $sqlpayment = 'SELECT 
                        SUM(cash_payment_detail.debt) AS amount
                      FROM
                        cash_payment_detail
                      INNER JOIN cash_payment ON cash_payment_detail.trans_id = cash_payment.id 
                      JOIN coa ON cash_payment_detail.coa_id = coa.id 
                      WHERE
                        DATE_FORMAT(
                          cash_payment.cash_payment_date,
                          "%c"
                        ) = '.$id1.'
                      AND DATE_FORMAT(
                        cash_payment.cash_payment_date,
                        "%Y"
                      ) = '.$id2.' AND cash_payment_detail.deleted_at IS NULL AND (DATE_FORMAT(
                cash_payment.cash_payment_date,
                "%d"
              ) BETWEEN '.$id3.' AND '.$id4.')';
      $payment = DB::table(DB::raw("($sqlpayment) as rs_sql"))->first(); 


      $sqlremain = 'SELECT SUM(devdtbl.amount) as amount FROM 
                    ( 

                    SELECT
                          SUM(cash_receive_detail.debt) AS amount
                        FROM
                          cash_receive
                        INNER JOIN cash_receive_detail ON cash_receive.id = cash_receive_detail.trans_id
                        WHERE
                          DATE_FORMAT(
                            cash_receive.cash_receive_date,
                            "%c"
                          ) = '.$id1.'
                        AND DATE_FORMAT(
                          cash_receive.cash_receive_date,
                          "%Y"
                        ) = '.$id2.'  AND cash_receive_detail.deleted_at IS NULL AND (DATE_FORMAT(
                cash_receive.cash_receive_date,
                "%d"
              ) BETWEEN '.$id3.' AND '.$id4.')  AND cash_receive_detail.deleted_at IS NULL 
                      UNION ALL
                      SELECT 
                        - SUM(cash_payment_detail.debt) AS amount
                      FROM
                        cash_payment_detail
                      INNER JOIN cash_payment ON cash_payment_detail.trans_id = cash_payment.id
                      JOIN coa ON cash_payment_detail.coa_id = coa.id 
                      WHERE
                        DATE_FORMAT(
                          cash_payment.cash_payment_date,
                          "%c"
                        ) = '.$id1.'
                      AND DATE_FORMAT(
                        cash_payment.cash_payment_date,
                        "%Y"
                      ) = '.$id2.'  AND cash_payment_detail.deleted_at IS NULL AND (DATE_FORMAT(
                cash_payment.cash_payment_date,
                "%d"
              ) BETWEEN '.$id3.' AND '.$id4.') 
                    ) AS devdtbl';
      $remain = DB::table(DB::raw("($sqlremain) as rs_sql"))->first(); 

      $remain_amount = $remain->amount + $remain_before->amount;

      // dd($remain_amount);
    
    return view ('editor.report_ledger.print', compact('department_list','payperiod_list','employee_list', 'itemdata','datafilter', 'year', 'remain', 'payment', 'datareceive', 'remain_amount', 'remain_before_amount', 'datafilterbefore'));
  }
}
