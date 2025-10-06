<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BPJSTK;
use App\Models\BPJSTKDetail;
use Illuminate\Support\Facades\DB;
use Validator;
use Response;
use View;

class BPJSTKController extends Controller
{
  public function index()
  {
    return view ('editor.bpjs_tk.index');
  }

  public function create()
  {
    return view ('editor.bpjs_tk.form');
  }

  public function edit($id)
  {
    $bpjstk = BPJSTK::find($id);
    $details = BPJSTKDetail::where('bpjstk_id', $id)->get();
    return view ('editor.bpjs_tk.edit-form', compact('bpjstk', 'details'));
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 

      $sql = "SELECT * FROM bpjstk ORDER BY id DESC";
      $item = DB::table(DB::raw("($sql) as rs_sql"))->get();
      return DataTables::of($item)  
      ->addColumn('action', function ($item) {
        return '<a href="'.url("editor/bpjs-tk/edit/".$item->id).'" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Edit</a> <a  href="javascript:void(0)" title="Hapus" class="btn btn-danger btn-xs" onclick="delete_id('."'".$item->id."', '".$item->schema_name."'".')"> <i class="ti-trash"></i> Hapus</a>';
      })
      ->toJson();
    } else {
      exit("No data available");
    }
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      // 'basic' => 'required',
      'schema_name'=> 'required',
      // 'bpjs_total'=> 'required'
    ]);

    $bpjstk = new BPJSTK();
    // $bpjstk->basic = $validated['basic'];
    $bpjstk->schema_name = $validated['schema_name'];
    $bpjstk->total_percentage_company = $request->input('bpjs_sum_perusahaan_percent');
    $bpjstk->total_percentage_employee = $request->input('bpjs_sum_karyawan_percent');
    // $bpjstk->total_company_guarantee = $request->input('bpjs_sum_perusahaan');
    // $bpjstk->total_employee_guarantee = $request->input('bpjs_sum_karyawan');
    // $bpjstk->total_bpjstk = $validated['bpjs_total'];
    $bpjstk->created_by = Auth::id();
    $bpjstk->save();

    foreach($request->input('bpjs_jaminan') as $key => $post){

      $bpjstk_detail = new BPJSTKDetail();
      $bpjstk_detail->bpjstk_id = $bpjstk->id;
      $bpjstk_detail->guarantee = $request->input('bpjs_jaminan')[$key];
      $bpjstk_detail->percentage_company = $request->input('bpjs_ditanggung_perusahaan_persentase')[$key];
      $bpjstk_detail->percentage_employee = $request->input('bpjs_ditanggung_karyawan_persentase')[$key];
      // $bpjstk_detail->nominal_company_guarantee = $request->input('bpjs_ditanggung_perusahaan_rp')[$key];
      // $bpjstk_detail->nominal_employee_guarantee = $request->input('bpjs_ditanggung_karyawan_rp')[$key];
      $bpjstk_detail->save();
    }

    return redirect('editor/bpjs-tk');
  }

  public function update(Request $request, $id)
  {
    $validated = $request->validate([
      // 'basic' => 'required',
      'schema_name'=> 'required',
      // 'bpjs_total'=> 'required'
    ]);

    $bpjstk = BPJSTK::find($id);
    // $bpjstk->basic = $validated['basic'];
    $bpjstk->schema_name = $validated['schema_name'];
    $bpjstk->total_percentage_company = $request->input('bpjs_sum_perusahaan_percent');
    $bpjstk->total_percentage_employee = $request->input('bpjs_sum_karyawan_percent');
    // $bpjstk->total_company_guarantee = $request->input('bpjs_sum_perusahaan');
    // $bpjstk->total_employee_guarantee = $request->input('bpjs_sum_karyawan');
    // $bpjstk->total_bpjstk = $validated['bpjs_total'];
    $bpjstk->created_by = Auth::id();
    $bpjstk->save();

    
    foreach($request->input('bpjs_jaminan') as $key => $post){
      $detail[$key] = BPJSTKDetail::Where('bpjstk_id', $id)->first();
      $detail[$key]->delete();

      $bpjstk_detail = new BPJSTKDetail();
      $bpjstk_detail->bpjstk_id = $bpjstk->id;
      $bpjstk_detail->guarantee = $request->input('bpjs_jaminan')[$key];
      $bpjstk_detail->percentage_company = $request->input('bpjs_ditanggung_perusahaan_persentase')[$key];
      $bpjstk_detail->percentage_employee = $request->input('bpjs_ditanggung_karyawan_persentase')[$key];
      // $bpjstk_detail->nominal_company_guarantee = $request->input('bpjs_ditanggung_perusahaan_rp')[$key];
      // $bpjstk_detail->nominal_employee_guarantee = $request->input('bpjs_ditanggung_karyawan_rp')[$key];
      $bpjstk_detail->save();
    }

    return redirect('editor/bpjs-tk');
  }

  public function delete($id){
    $post = BPJSTK::find($id);
    $detail = BPJSTKDetail::Where('bpjstk_id', $id)->first();
    if($detail){
      $detail->delete();
    }
    $post->delete();

    return response()->json($post, 200);
  }
}
