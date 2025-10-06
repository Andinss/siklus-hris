<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use App\Http\Requests\ModuleRequest;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Models\Module;
use Response;

class ModuleController extends Controller
{
    public function index()
    {
    	// if (Input::has('page'))
      //      {
      //        $page = Input::get('page');
      //      }
      //   else
      //      {
      //        $page = 1;
      //      }
      //   $no = 15*$page-14;
      //   $modules = Module::paginate(15);
    	// return view ('editor.module.index', compact('modules'))->with('number',$no);
      return view('editor.module.index');
    }

    public function data(Request $request)
    {

      $limit = !empty($request->get('per_page')) ? $request->get('per_page') : 10 ;

      $each = explode('|', $request->get('sort'));

      $sql =  Module::orderBy($each[0], $each[1])->paginate($limit);
      $count = Module::all();

      if($request->get('filter')):
        $sql = Module::where('name', 'like', '%'.$request->get('filter').'%')->paginate($limit);
      endif;
      $total = $count->count('*');
      $user  = $sql;
      $data = [];
      $data['total'] = $total;
      $data['per_page'] = (int) $limit;
      $data['current_page'] = (int) ($request->get('page'));
      $data['last_page'] = ceil($data['total'] / $data['per_page']);
      $data['from'] = (($data['current_page'] * $data['per_page']) - ($data['per_page'] - 1));
      $data['to'] = ($data['per_page'] * $data['current_page']);
      foreach($user as $key => $value):
        $data['data'][$key] = [
          'id' => $value->id,
          'name' => $value->name,
          'description' => $value->description
          ];
      endforeach;
      $response = Response::make($data, 200);
      $response->header('Content-Type', 'application/json');
      return $response;
    }

    public function create()
    {
    	return view ('editor.module.form');
    }

    public function store(ModuleRequest $request)
    {
    	$module = new Module;
    	$module->name = $request->input('name');
    	$module->description = $request->input('description');
    	$module->save();

    	return redirect('editor/module');
    }

    public function edit($id)
    {
    	$module = Module::find($id);
    	return view ('editor.module.form', compact('module'));
    }

    public function update($id, Request $request)
    {
    	$module = Module::find($id);
    	$module->description = $request->input('description');
    	$module->save();
    	return redirect('editor/module');
    }

     public function delete($id)
    { 
        $post =  Module::Find($id);
        $post->delete(); 

        return response()->json($post); 
    }
}
