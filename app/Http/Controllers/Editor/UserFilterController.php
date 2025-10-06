<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Userlog;
use App\Models\Container;
use App\Models\Itembrand;
use App\Models\Itemcategory;
use Carbon\Carbon;
use Validator;
use Response;
use App\Post;
use View;
// use App\Notifications\ToDb;
use Illuminate\Notifications\Notifiable;


class UserFilterController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [
        'userfiltername' => ''
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  public function index()
  {
    $userfilters = User::all();
    $item_category = Itemcategory::orderBy('item_category_name', 'ASC')->get();
    $container = Container::orderBy('container_name', 'ASC')->get();

    return view ('editor.userfilter.index', compact('userfilters', 'item_category', 'container'));
  }


  public function dataUser(Request $request)
  {
        $limit = !empty($request->get('per_page')) ? $request->get('per_page') : 10 ;

        // $each = explode('|', $request->get('sort'));

        $sql =  User::orderBy('id', 'desc')->paginate($limit);
        $count = User::all();
        if($request->get('filter')):
          $sql =  User::where('username', 'like', '%'.$request->get('filter').'%')->orWhere('first_name', 'like', '%'.$request->get('filter').'%')->orWhere('last_name', 'like', '%'.$request->get('filter').'%')->orWhere('email', 'like', '%'.$request->get('filter').'%')->paginate($limit);
        endif;
        $user  = $sql;
        $total = $count->count();
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
            'first_name' => $value->first_name,
            'last_name' => $value->last_name,
            'username' => $value->username,
            'email' => $value->email,
            'register' => $value->created_at,
            'status' => $value->flag_user == 1 ? 'active' : 'diactive'
            ];
        endforeach;
        $response = Response::make($data, 200);
        $response->header('Content-Type', 'application/json');
        return $response;
  }

  public function data(Request $request)
  {
    if($request->ajax()){
      // $itemdata = User::orderBy('userfilter_name', 'ASC')->get();
      $sql = 'SELECT
                `user`.id,
                `user`.username,
                `user`.grfrom,
                `user`.grto,
                `user`.item_category_id,
                item_category.item_category_name,
                `user`.container_id,
                container.container_no,
                `user`.search
              FROM
                `user`
                LEFT JOIN item_category ON `user`.item_category_id = item_category.id
                LEFT JOIN container ON `user`.container_id = container.id';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return Datatables::of($itemdata)

      ->addColumn('action', function ($itemdata) {
        return '<a href="javascript:void(0)" title="Edit"  onclick="edit('."'".$itemdata->id."'".')"> Edit</a>';
      })

      ->make(true);
    } else {
      exit("No data available");
    }
  }

  public function edit($id)
  {
    $userfilter = User::Find($id);
    echo json_encode($userfilter);
  }

  public function update($id, Request $request)
  {
    //data
    $post = User::Find($id);
    $post->grfrom = $request->grfrom;
    $post->grto = $request->grto;
    $post->item_category_id = $request->item_category_id;
    $post->container_id = $request->container_id;
    $post->search = $request->search;
    $post->updated_by = Auth::id();
    $post->save();

    return response()->json($post);
  }

}
