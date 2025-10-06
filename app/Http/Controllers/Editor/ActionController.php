<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use App\Http\Requests\ActionRequest;
use App\Http\Controllers\Controller;
use App\Models\Action;
use Response;

class ActionController extends Controller
{
    public function index()
    {
    	$actions = Action::paginate(15);
    	return view ('editor.action.index', compact('actions'));
    }

    public function data(Request $request)
      {
        $limit = $request->get('limit') ?? 15;

        $each = explode('|', $request->get('sort'));


        $sql =  Action::orderBy($each[0], $each[1])->paginate($limit);


        if($request->get('filter')):
          $sql = Action::where('name', 'like', '%'.$request->get('filter').'%')->paginate($limit);
        endif;
        $user  = $sql;
        $total = count($user);
        $data = [];
        $data['total'] = $total;
        $data['per_page'] = $limit;
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
    	return view ('editor.action.form');
    }

    public function store(ActionRequest $request)
    {
    	$action = new Action;
    	$action->name = $request->input('name');
    	$action->description = $request->input('description');
    	$action->save();

    	return redirect()->action('Editor\ActionController@index');
    }

    public function edit($id)
    {
    	$action = Action::find($id);
    	return view ('editor.action.form', compact('action'));
    }

    public function update($id, Request $request)
    {
    	$action = Action::find($id);
    	$action->description = $request->input('description');
    	$action->save();
    	return redirect()->action('Editor\ActionController@index');
    }

    public function delete($id)
    { 
        $post =  Action::Find($id);
        $post->delete(); 

        return response()->json($post); 
    }
}
