<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PayrollComponentRequest;
use App\Http\Controllers\Controller;
use App\Models\PayrollComponent;
use App\Models\PayrollComponentDetail;
use Validator;
use Response;
use App\Post;
use View;

class PayrollComponentController extends Controller
{
  public function index()
  {
    return view ('editor.payroll_component.index');
  }

  public function data()
  {
    if (request()->ajax())
    {
        $payrollComponents = PayrollComponent::with(['payrollComponentDetail'])
            ->get();

        return DataTables::of($payrollComponents)
            ->make(true);
    } else {
        exit("No data available");
    }
  }

  public function create()
  {
    return view ('editor.payroll_component.form');
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
        'category_name' => 'required|string',
        'component_name' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->getMessageBag()->toArray()
        ], 422);
    }

    $post = new PayrollComponent();
    $post->category_name = $request->category_name;
    $post->created_by = Auth::id();
    $post->save();

    if ($post && count($request->component_name) > 0) {

        $componentsName = $request->component_name;

        foreach ($componentsName as $key => $value) {
            $postDetail = new PayrollComponentDetail();
            $postDetail->payroll_component_id = $post->id;
            $postDetail->payroll_component_name = $value;
            $postDetail->created_by = Auth::id();
            $postDetail->save();
        }
    }


    return redirect('editor/payroll-component');

  }

  public function edit($id)
  {
    $payrollComponent = PayrollComponent::Find($id);
    $payrollComponentDetails = PayrollComponentDetail::where('payroll_component_id', $id)->get();

    return view('editor.payroll_component.form', compact('payrollComponent', 'payrollComponentDetails'));
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
        'category_name' => 'required|string',
        'component_name' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->getMessageBag()->toArray()
        ], 422);
    }

    $post = PayrollComponent::Find($id);
    $post->category_name = $request->category_name;
    $post->created_by = Auth::id();
    $post->save();

    if ($post && count($request->component_name) > 0) {

        $payrollComponenentDetail = PayrollComponentDetail::where('payroll_component_id', $post->id);

        if ($payrollComponenentDetail->exists()) {
            $payrollComponenentDetail->delete();
        }

        $componentsName = $request->component_name;

        foreach ($componentsName as $key => $value) {
            $postDetail = new PayrollComponentDetail();
            $postDetail->payroll_component_id = $post->id;
            $postDetail->payroll_component_name = $value;
            $postDetail->created_by = Auth::id();
            $postDetail->save();
        }
    }


    return redirect('editor/payroll-component');
  }

  public function delete($id)
  {
    $post = PayrollComponent::Find($id);
    $post->delete();

    if ($post) {

        PayrollComponentDetail::where('payroll_component_id', $post->id)->delete();

    }

    return response()->json($post);
  }
}
