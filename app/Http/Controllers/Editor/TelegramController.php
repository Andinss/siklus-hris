<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Datatables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Notifications\Notification;
use App\Models\Employee; 
use Validator;
use Response;
use App\Post;
use GuzzleHttp\Psr7;
use View;

class TelegramController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [ 
        'popupname' => 'required|min:2'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function index($notifiable)
  {
     $sql = 'SELECT
                `leave`.id ,
                `leave`.code_trans ,
                `leave`.no_trans ,
                 date_format(`leave`.date_trans , "%d-%m-%Y") AS date_trans,
                `leave`.employee_id ,
                `leave`.disease_id ,
                `leave`.dockter_id ,
                `leave`.hospital_id ,
                 date_format(`leave`.leave_from , "%d-%m-%Y") AS leave_from,
                 date_format(`leave`.leave_to , "%d-%m-%Y") AS leave_to,
                DATEDIFF(`leave`.leave_from, `leave`.leave_to) AS days,
                `leave`.used ,
                `leave`.plafond ,
                `leave`.absence_type_id ,
                `leave`.leave_category_id ,
                `leave`.attachment ,
                `leave`.medicine ,
                `leave`.remark ,
                `leave`.`status`
              FROM
                `leave`
              WHERE `leave`.id ='.$notifiable.'';
      $leave = DB::table(DB::raw("($sql) as rs_sql"))->first(); 
    
    return view ('editor.telegram.index', compact('leave'));
  } 

  public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function send_message($notifiable)
    {
      $url = url('/invoice/' . $notifiable);


      return TelegramMessage::create()
          ->to('husnimbr') // Optional.
          ->content("*HELLO!* One of your invoices has been paid!"); // Markdown supported.
          // ->button('View Invoice', $url); // Inline Button
    }
}
