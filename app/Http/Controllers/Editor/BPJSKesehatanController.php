<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BPJSKesDetail;
use App\Models\BPJSKesehatan; 
use Validator;
use Response;
use View;

class BPJSKesehatanController extends Controller
{
  public function index()
  {
    return view ('editor.bpjs_kesehatan.index');
  }

  public function create()
  {
    return view ('editor.bpjs_kesehatan.form');
  }

  public function edit($id)
  {
    $bpjs = BPJSKesehatan::find($id);
    $details = BPJSKesDetail::where('bpjs_kesehatan_id', $id)->get();
    
    return view ('editor.bpjs_kesehatan.edit-form', compact('bpjs', 'details'));
  }

  public function data(Request $request)
  {   
    if($request->ajax()){ 

      $item = BPJSKesehatan::all();
      return DataTables::of($item)  
      ->addColumn('action', function ($item) {
        return '<a href="'.url("editor/bpjs-kesehatan/edit/".$item->id).'" title="Edit" class="btn btn-primary btn-xs"> <i class="ti-pencil-alt"></i> Edit</a> <a  href="javascript:void(0)" title="Hapus" class="btn btn-danger btn-xs" onclick="delete_id('."'".$item->id."', '".$item->schema_name."'".')"> <i class="ti-trash"></i> Hapus</a>';
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

    $bpjs = new BPJSKesehatan();
    // $bpjs->basic = $validated['basic'];
    $bpjs->schema_name = $validated['schema_name'];
    $bpjs->total_percentage_company = $request->input('bpjs_sum_perusahaan_percent');
    $bpjs->total_percentage_employee = $request->input('bpjs_sum_karyawan_percent');
    // $bpjs->total_company_guarantee = $request->input('bpjs_sum_perusahaan');
    // $bpjs->total_employee_guarantee = $request->input('bpjs_sum_karyawan');
    // $bpjs->total_bpjs_kesehatan = $validated['bpjs_total'];
    $bpjs->created_by = Auth::id();
    $bpjs->save();

    foreach($request->input('bpjs_jaminan') as $key => $post){

      $bpjstk_detail = new BPJSKesDetail();
      $bpjstk_detail->bpjs_kesehatan_id = $bpjs->id;
      $bpjstk_detail->guarantee = $request->input('bpjs_jaminan')[$key];
      $bpjstk_detail->percentage_company = $request->input('bpjs_ditanggung_perusahaan_persentase')[$key];
      $bpjstk_detail->percentage_employee = $request->input('bpjs_ditanggung_karyawan_persentase')[$key];
      // $bpjstk_detail->nominal_company_guarantee = $request->input('bpjs_ditanggung_perusahaan_rp')[$key];
      // $bpjstk_detail->nominal_employee_guarantee = $request->input('bpjs_ditanggung_karyawan_rp')[$key];
      $bpjstk_detail->save();
    }

    return redirect('editor/bpjs-kesehatan');
  }

  public function update(Request $request, $id)
  {
    $validated = $request->validate([
      // 'basic' => 'required',
      'schema_name'=> 'required',
      // 'bpjs_total'=> 'required'
    ]);

    $bpjs = BPJSKesehatan::find($id);
    // $bpjs->basic = $validated['basic'];
    $bpjs->schema_name = $validated['schema_name'];
    $bpjs->total_percentage_company = $request->input('bpjs_sum_perusahaan_percent');
    $bpjs->total_percentage_employee = $request->input('bpjs_sum_karyawan_percent');
    // $bpjs->total_company_guarantee = $request->input('bpjs_sum_perusahaan');
    // $bpjs->total_employee_guarantee = $request->input('bpjs_sum_karyawan');
    // $bpjs->total_bpjs_kesehatan = $validated['bpjs_total'];
    $bpjs->created_by = Auth::id();
    $bpjs->save();

    foreach($request->input('bpjs_jaminan') as $key => $post){
      $detail[$key] = BPJSKesDetail::Where('bpjstk_id', $id)->first();
      $detail[$key]->delete();

      $bpjstk_detail = new BPJSKesDetail();
      $bpjstk_detail->bpjs_kesehatan_id = $bpjs->id;
      $bpjstk_detail->guarantee = $request->input('bpjs_jaminan')[$key];
      $bpjstk_detail->percentage_company = $request->input('bpjs_ditanggung_perusahaan_persentase')[$key];
      $bpjstk_detail->percentage_employee = $request->input('bpjs_ditanggung_karyawan_persentase')[$key];
      // $bpjstk_detail->nominal_company_guarantee = $request->input('bpjs_ditanggung_perusahaan_rp')[$key];
      // $bpjstk_detail->nominal_employee_guarantee = $request->input('bpjs_ditanggung_karyawan_rp')[$key];
      $bpjstk_detail->save();
    }

    return redirect('editor/bpjs-kesehatan');
  }

  public function delete($id){
    $post = BPJSKesehatan::find($id);
    $detail = BPJSKesDetail::Where('bpjs_kesehatan_id', $id)->first();
    if($detail){
      $detail->delete();
    }
   
    $post->delete();
    
    return response()->json($post, 200);
  }
}
