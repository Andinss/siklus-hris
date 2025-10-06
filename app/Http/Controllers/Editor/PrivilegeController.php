<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Privilege;
use App\Models\User;
use App\Models\Module;
use App\Models\Action;

use Response;

class PrivilegeController extends Controller
{
    public function index()
    {
    	// $users = User::has('privilege')->paginate(15);
    	// return view ('editor.privilege.index', compact('users'));
      return view('editor.privilege.index');
    }

    public function data(Request $request)
    {

      $limit = !empty($request->get('per_page')) ? $request->get('per_page') : 10 ;

      $each = explode('|', $request->get('sort'));

      $privilege = User::has('privilege')->orderBy('id', 'desc')->paginate($limit);
      $count =  User::has('privilege');
      if($request->get('filter')):
        $privilege = User::has('privilege')->where('user.username', 'like', '%'.$request->get('filter').'%')->paginate($limit);
      endif;
      $total = $count->count("*");
      $data = [];
      $data['total'] = $total;
      $data['per_page'] = $limit;
      $data['current_page'] = (int) ($request->get('page'));
      $data['last_page'] = ceil($data['total'] / $data['per_page']);
      $data['from'] = (($data['current_page'] * $data['per_page']) - ($data['per_page'] - 1));
      $data['to'] = ($data['per_page'] * $data['current_page']);
      foreach($privilege as $key => $value):
        $data['data'][$key]['id'] = $value->id;
        $data['data'][$key]['username'] = $value->username;
        $data['data'][$key]['email'] = $value->email;
        $data['data'][$key]['register'] = $value->created_at;
        $data['data'][$key]['status'] = $value->flag_user == 1 ? 'Active' : 'Deactive';
      endforeach;
      $response = Response::make($data, 200);
      $response->header('Content-Type', 'application/json');
      return $response;

    }


    public function create()
    {
    	$username_list = User::doesntHave('privilege')->pluck('username', 'id');
    	$module_list = Module::pluck('name', 'id');
    	$action_list = Action::pluck('name', 'id');
    	return view ('editor.privilege.form', compact('username_list', 'module_list', 'action_list'));
    }

    public function store(Request $request)
    {
    	if($request->input('privilege'))
    	{
    		foreach($request->input('privilege') as $module_id => $action_list)
    		{
    			foreach($action_list as $action_id => $value)
    			{
	    			$privilege = new Privilege;
	    			$privilege->user_id = $request->input('user_id');
	    			$privilege->module_id = $module_id;
	    			$privilege->action_id = $action_id;
	    			$privilege->save();
    			}
    		}
    	}

    	return redirect('editor/privilege');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $module_list = Module::pluck('name', 'id');
        $action_list = Action::pluck('name', 'id');
        return view ('editor.privilege.form', compact('user', 'module_list', 'action_list'));
    }

    public function update($id, Request $request)
    {
        if($request->input('privilege'))
        {
            Privilege::where('user_id', $id)->delete();
            foreach($request->input('privilege') as $module_id => $action_list)
            {
                foreach($action_list as $action_id => $value)
                {
                    $privilege = new Privilege;
                    $privilege->user_id = $id;
                    $privilege->module_id = $module_id;
                    $privilege->action_id = $action_id;
                    $privilege->save();
                }
            }
        }

        return redirect('editor/privilege');
    }

    public function delete($id)
    {
        Privilege::where('user_id', $id)->delete();
        return redirect('editor/privilege');
    }
}
