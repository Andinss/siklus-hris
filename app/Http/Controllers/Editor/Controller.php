<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Illuminate\Support\Facades\DB;
use App\Models\Branch;
use View;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
  	{	
  		$this->middleware(function ($request, $next) {
  			$userid = auth()->id();
  			// return $next($request);
  			// dd($userid);
  			$sql_branch_filter = 'SELECT
                        user_branch.user_id,
                        branch.id,
                        branch.branch_name,
                        branch.description,
                        branch.field_name 
                      FROM
                        branch
                      LEFT JOIN user_branch ON branch.id = user_branch.branch_id 
                      INNER JOIN user ON user_branch.user_id = user.id 
                      WHERE `user`.id = '.$userid.'';
	    	$this->branch_global = DB::table(DB::raw("($sql_branch_filter) as rs_sql"))->get(); 
	    	View::share([ 'branch_global' => $this->branch_global ]); 
	    return $next($request);
      });
  		

    	$branch = Branch::all();
  		$sql = 'SELECT
  					"EMKL Cost" AS type,
  					"" AS po_number,
  					"" AS container_no,
  					"" AS po_date,
  					"" AS tarik,
  					"" AS currency_name,
	             	"" AS currency_name_to,
	             	"" AS totalmodal,
	             	"" AS totalmodal_to,
	                emkl_cost_log.id,
	                DATE_FORMAT(emkl_cost_log.datefrom, "%d-%m-%Y") AS datefrom,
	                DATE_FORMAT(emkl_cost_log.dateto, "%d-%m-%Y") AS dateto,
	                FORMAT(emkl_cost_log.emkl, 0) AS emkl,
	                FORMAT(emkl_cost_log.`plugin`, 0) AS plugin,
	                FORMAT(emkl_cost_log.ls, 0) AS ls,
	                FORMAT(emkl_cost_log.kalog, 0) AS kalog,
	                DATE_FORMAT(emkl_cost_log.datefrom_to, "%d-%m-%Y") AS datefrom_to,
	                DATE_FORMAT(emkl_cost_log.dateto_to, "%d-%m-%Y") AS dateto_to,
	                FORMAT(emkl_cost_log.emkl_to, 0) AS emkl_to,
	                FORMAT(emkl_cost_log.`plugin_to`, 0) AS plugin_to,
	                FORMAT(emkl_cost_log.ls_to, 0) AS ls_to,
	                FORMAT(emkl_cost_log.kalog_to, 0) AS kalog_to,
	                `user`.username,
	                `user`.read_notif,
	                emkl_cost_log.updated_at AS updated_at_short, ';
			       foreach ($branch as $key => $branchs) {
			          $sql .= "NULL AS " . $branchs->field_name . ", ";
			          $sql .= "NULL AS " . $branchs->field_name . "_to, ";
			        };
	              $sql .= ' DATE_FORMAT(emkl_cost_log.updated_at, "%d-%m-%Y %H:%i") AS updated_at FROM
	              emkl_cost_log
	              JOIN `user`
	              ON emkl_cost_log.updated_by = `user`.id  

				 UNION ALL

	             SELECT
	             	"Branch Allocation" AS type,
	             	purchase_order.po_number,
	             	container.container_no,
	             	DATE_FORMAT(purchase_order.doc_date, "%d-%m-%Y") AS po_date,
	             	purchase_order_detail_log.tarik AS tarik,
	             	currency.currency_name,
	             	currency_to.currency_name AS currency_name_to,
	             	purchase_order_detail_log.totalmodal,
	             	purchase_order_detail_log.totalmodal_to,
	             	purchase_order_detail_log.id,
	             	"" AS datefrom,
	             	"" AS dateto,
	             	"" AS emkl,
	             	"" AS plugin,
	             	"" AS ls,
	             	"" AS kalog,
	             	"" AS datefrom_to,
	             	"" AS dateto_to,
	             	"" AS emkl_to,
	             	"" AS plugin_to,
	             	"" AS ls_to,
	             	"" AS kalog_to, 
	             	`user`.username,
	                `user`.read_notif,
	                purchase_order_detail_log.updated_at AS updated_at_short, ';
			       foreach ($branch as $key => $branchs) {
			          $sql .= "IFNULL(purchase_order_detail_log." . $branchs->field_name . ",0) AS " . $branchs->field_name . ", ";
			          $sql .= "IFNULL(purchase_order_detail_log." . $branchs->field_name . "_to,0) AS " . $branchs->field_name . "_to, ";
			        };
				      $sql .= ' DATE_FORMAT(purchase_order_detail_log.updated_at, "%d-%m-%Y %H:%i") AS updated_at FROM
			              purchase_order_detail_log INNER JOIN purchase_order_detail ON purchase_order_detail_log.purchase_order_detail_id = purchase_order_detail.id
			              INNER JOIN purchase_order ON purchase_order_detail.purchase_order_id = purchase_order.id
			              LEFT JOIN container ON purchase_order.container_id = container.id
			              LEFT JOIN currency ON purchase_order_detail_log.currency_id = currency.id
			              LEFT JOIN currency AS currency_to ON purchase_order_detail_log.currency_id_to = currency_to.id
			              JOIN `user`
		              ON purchase_order_detail_log.updated_by = `user`.id';

    	$this->notif = DB::table(DB::raw("($sql) as rs_sql"))->orderBy('updated_at_short','DESC')->get(); 

        View::share([ 'notif' => $this->notif ]); 

        // $this->branch_global = Branch::all();


    	$this->notif_limit = DB::table(DB::raw("($sql) as rs_sql"))->orderBy('updated_at_short','DESC')->limit(5)->get(); 

        View::share([ 'notif_limit' => $this->notif_limit ]); 

  	}
}
