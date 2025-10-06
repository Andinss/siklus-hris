<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use File;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\ItemRequest;
use App\Http\Controllers\Controller; 
use App\Models\UserLog;
use App\Models\User; 
use App\Models\Role;
use Validator;
use Response;
use App\Models\Post;
use View;
use DateTime;
use Mail;
use Sendinblue\Mailin;



class UserLogController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [
        'item_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  public function index()
  {

    $roles = Role::all();
    return view ('editor.userlog.index', compact('roles'));
  }

  public function dataApi(Request $request)
  {
  
    $limit = !empty($request->get('per_page')) ? $request->get('per_page') : 10 ;

    $userLogs = UserLog::select('user.username', 'user.email', 'user.first_name', 'user.last_name', 'user_log.scope', 'user_log.data', 'user_log.created_at', 'user_log.updated_at', 'user_log.id', 'roles.id as id_role', 'roles.name')
    ->join('user', 'user_log.user_id', '=', 'user.id')
    ->join('users_roles', 'users_roles.user_id', '=', 'user.id')
    ->join('roles', 'users_roles.role_id', '=', 'roles.id')
    ->orderBy('user_log.id', 'desc');
  
    if(!empty($request->get('filter_date')) OR !empty($request->get('keyword'))):
      $filterBetween = explode("|", $request->get('filter_date'));
      $start = date('Y-m-d', strtotime($filterBetween[0]));
      $end = date('Y-m-d', strtotime($filterBetween[1]));
      $userLogs->where('user.username', 'like', '%'.$request->get('keyword'))
      ->orWhere('user.email', $request->get('keyword'))
      ->orWhere('roles.name', 'like', '%'.$request->get('keyword').'%')
      ->whereBetween(DB::raw("date_format(user_log.created_at, '%Y-%m-%d')"), [$start, $end]);
    endif;

    $paginateResults = $userLogs->paginate($limit);
    $results = $paginateResults->items();
    $total = $userLogs->count();
    $data['total'] = $total;
    $data['per_page'] = (int) $limit;
    $data['current_page'] = (int) ($request->get('page'));
    $data['last_page'] = ceil($data['total'] / $data['per_page']);
    $data['from'] = (($data['current_page'] * $data['per_page']) - ($data['per_page'] - 1));
    $data['to'] = ($data['per_page'] * $data['current_page']);
    $data['data'] = [];
    foreach($results as $key => $userLog):
      $date = $userLog->created_at;
      $data['data'][$key] = [
        'username' => $userLog->username,
        'email'=> $userLog->email,
        'first_name' => $userLog->first_name,
        'last_name' => $userLog->last_name,
        'role' => $userLog->name,
        'desc' => $this->generateWordLog($userLog),
        'date' => $date
      ];
    endforeach;

    return Response()->json($data);
  }


  private function generateWordLog($params)
  {
    $word = null;
    $title = strtolower($params->scope);
    switch($params->scope)
    {
         

        case "AUTHENTICATION":
           $json = json_decode($params->data);
           $data = User::find($json->user_id);

          if($data):
            if($json->action == 'login'):
              $word = $params->username.' logged in '. date('d M Y H:i:s', strtotime($params->created_at));
            elseif($json->action == 'logout'):
              $word = $params->username.' logout in '.$data->username.' '. $title.' for '. $params->updated_at;
            endif;
          endif;
        break;

    }
    return $word;


  }

  public function data(Request $request)
  {
    if($request->ajax()){
       $sql = 'SELECT
                  item.id,
                  item.item_code,
                  item.item_name,
                  item_category.item_category_name,
                  item.item_category_id,
                  item_brand.item_brand_name,
                  item.item_brand_id,
                  item.image,
                  item.description,
                  item.status
                FROM
                  item
                  LEFT JOIN item_brand ON item.item_brand_id = item_brand.id
                  LEFT JOIN item_category ON item.item_category_id = item_category.id
              WHERE
              item.deleted_at IS NULL';
      $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return Datatables::of($itemdata)

      ->addColumn('action', function ($itemdata) {
        return '<a href="item/edit/'.$itemdata->id.'" title="Edit"> <i class="ti-pencil-alt"></i></a> | <a  href="javascript:void(0)" title="Delete" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->item_code."', '".$itemdata->item_name."'".')"> <i class="ti-trash"></i></a>';
      })

       ->addColumn('image', function ($itemdata) {
          if ($itemdata->image == null) {
            return '<a class="fancybox" rel="group" href="../uploads/placeholder/placeholder.png"><img src="../uploads/placeholder/placeholder.png" class="img-thumbnail img-responsive" /></a>';
          }else{
           return '<a class="fancybox" rel="group" href="../uploads/item/'.$itemdata->image.'"><img src="../uploads/item/thumbnail/'.$itemdata->image.'" class="img-thumbnail img-responsive" /></a>';
         };
       })

      ->addColumn('mstatus', function ($itemdata) {
        if ($itemdata->status == 0) {
          return '<span class="label label-success"> Active </span>';
        }else{
         return '<span class="label label-danger"> Not Active </span>';
       };

     })
      ->make(true);
    } else {
      exit("No data available");
    }
  }


  public function data_filter()
  {
    $item = Item::all();
    if(isset($item))
    {
      for($i = 0; $i < $item->count(); $i++)
        {
          $json[$i] =
          [
          'Id' => $item[$i]->id,
          'Name' => $item[$i]->item_name,
          ];
        }
    }else{
      $json =
      [
        'message' => 'Data is not avaliable!',
      ];
    }
    return response()->json($json);
  }

  public function create()
  {
    $users = User::all();
    return view ('editor.userlog.form', compact('users'));
  }

  public function store(Request $request)
  {
      $getUser = Auth::user();
      $fname = $getUser->first_name;
      $lname = $getUser->last_name;
      $fullName = $fname." ".$lname;

      $data = array(
        'body' => json_decode($request->input('content'))
      );
        Mail::send(['html' => 'mail'], $data, function($message)use($request, $getUser, $fullName) {
           $message->to($request->input('email'), 'Tutorials Point')
           ->subject('User Log For '.$getUser->username)
           ->from($getUser->username, $fullName);
    });

    return redirect()->action('Editor\UserLogController@index');
  }

  public function edit($id)
  {
    $item = Item::find($id);
    $item_category_list = ItemCategory::all()->pluck('item_category_name', 'id');
    $item_brand_list = ItemBrand::all()->pluck('item_brand_name', 'id');

    return view ('editor.item.form', compact('item', 'item_category_list', 'item_brand_list'));
  }

  public function update($id, Request $request)
  {

    $item = Item::Find($id);
    $item->item_code = $request->input('item_code');
    $item->item_name = $request->input('item_name');
    $item->item_category_id = $request->input('item_category_id');
    $item->item_brand_id = $request->input('item_brand_id');
    $item->description = $request->input('description');
    $item->updated_by = Auth::id();
    $item->save();

    if($request->image)
    {
    $item = Item::FindOrFail($item->id);
    $original_directory = "uploads/item/";

    if(!File::exists($original_directory))
      {
        File::makeDirectory($original_directory, $mode = 0777, true, true);
      }

      //$file_extension = $request->image->getClientOriginalExtension();
      $item->image = Carbon::now()->format("d-m-Y h-i-s").str_replace(" ", "", $request->image->getClientOriginalName());
      $request->image->move($original_directory, $item->image);

      $thumbnail_directory = $original_directory."thumbnail/";
      if(!File::exists($thumbnail_directory))
        {
         File::makeDirectory($thumbnail_directory, $mode = 0777, true, true);
       }
       $thumbnail = Image::make($original_directory.$item->image);
       $thumbnail->fit(10,10)->save($thumbnail_directory.$item->image);

       $item->save();
     }

    return redirect()->action('Editor\ItemController@index');
  }

  public function delete($id)
  {
    $post =  Item::Find($id);
    $post->delete();

    return response()->json($post);
  }

  function fetch(Request $request)
  {
   if($request->get('query'))
   {
    $query = $request->get('query');
    $data = DB::table('item')
      ->where('item_name', 'LIKE', "%{$query}%")
      ->get();
    $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
    foreach($data as $row)
    {
     $output .= '
     <li><a href="#">'.$row->item_name.'</a></li>
     ';
    }
    $output .= '</ul>';
    echo $output;
   }
  }

}
