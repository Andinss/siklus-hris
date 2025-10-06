<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\BranchRequest;
use App\Http\Controllers\Controller;
use App\Models\Branch;

class BranchController extends Controller
{
    public function index()
    {
    	if (Input::has('page'))
     {
       $page = Input::get('page');    
   }
   else
   {
       $page = 1;
   }
   $no = 15*$page-14; 
   $branchs = Branch::paginate(15);
   return view ('editor.branch.index', compact('branchs'))->with('number',$no);
}

public function create()
{ 
    return view ('editor.branch.form');

}

public function store(BranchRequest $request)
{
   $branch = new Branch;
   $branch->branch_name = $request->input('branch_name');
   $branch->branch_desc = $request->input('branch_desc');
   $branch->created_by = Auth::id();
   $branch->save();

   return redirect()->action('Editor\BranchController@index');
}

public function edit($id)
{
   $branch = Branch::Find($id); 
   return view ('editor.branch.form', compact('branch'));
}

public function update($id, BranchRequest $request)
{
   $branch = Branch::Find($id);
   $branch->branch_name = $request->input('branch_name');
   $branch->branch_desc = $request->input('branch_desc');
   $branch->updated_by = Auth::id();
   $branch->save();

   return redirect()->action('Editor\BranchController@index');
}

public function delete($id)
{
   Branch::Find($id)->delete();
   return redirect()->action('Editor\BranchController@index');
}
}
