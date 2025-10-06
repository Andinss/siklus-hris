<?php

namespace App\Http\Controllers\Editor;

use Auth;
use DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ShiftRequest;
use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\AbsenceType;
use App\Models\Employee;
use App\Models\Holiday;
use Validator;
use Response;
use App\Post;
use Carbon\Carbon;
use View;

class ShiftController extends Controller
{
  /**
    * @var array
    */
    protected $rules =
    [
        'shift_name' => 'required'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  public function index()
  {
    $shifts = Shift::all();
    $absence_type_list = AbsenceType::where('code', 'DW')->orWhere('code', 'OD')->get();

    return view ('editor.shift.index', compact('shifts', 'absence_type_list'));
  }

  public function data(Request $request)
  {
    if($request->ajax()){
      // $itemdata = Shift::orderBy('shift_name', 'ASC')->get();

      $sql = 'SELECT
                shift.id,
                shift.shift_code,
                shift.shift_name,
                shift.start_time,
                shift.end_time,
                shift.start_break,
                shift.end_break,
                shift.absence_type_id,
                shift.premi,
                CONCAT(shift.grace_for_late, " Minute(s)") AS grace_for_late,
                shift.remark,
                shift.status
              FROM
                shift
              WHERE shift.deleted_at IS NULL';
        $itemdata = DB::table(DB::raw("($sql) as rs_sql"))->get();

      return DataTables::of($itemdata)

       ->addColumn('action', function ($itemdata) {
        return '<a href="#" onclick="edit('."'".$itemdata->id."'".')" title="Edit" class="btn btn-sm btn-outline-primary d-inline-block"> <i class="fas fa-pen"></i> Edit</a> <a  href="javascript:void(0)" title="Hapus" class="btn btn-sm btn-outline-danger d-inline-block" onclick="delete_id('."'".$itemdata->id."', '".$itemdata->shift_name."'".')"> <i class="fas fa-trash-alt"></i> Hapus</a>';
      })
      ->addColumn('check', function ($itemdata) {
        return '<label class="control control--checkbox"> <input type="checkbox" class="data-check" value="'."'".$itemdata->id."'".'"> <div class="control__indicator"></div> </label>';
      })
      ->toJson();
    } else {
      exit("No data available");
    }
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
    $post = new Shift();
    $post->shift_code = $request->shift_code;
    $post->shift_name = $request->shift_name;
    $post->start_time = $request->start_time;
    $post->end_time = $request->end_time;
    $post->start_break = $request->start_break;
    $post->end_break = $request->end_break;
    $post->absence_type_id = $request->absence_type_id;
    $post->grace_for_late = $request->grace_for_late;
    $post->premi = $request->premi;
    $post->remark = $request->remark;
    $post->status = $request->status;
    $post->created_by = Auth::id();
    $post->save();

    return response()->json($post);
  }
  }

  public function edit($id)
  {
    $shift = Shift::Find($id);
    echo json_encode($shift);
  }

  public function update($id, Request $request)
  {
    $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
    $post = Shift::Find($id);
    $post->shift_code = $request->shift_code;
    $post->shift_name = $request->shift_name;
    $post->start_time = $request->start_time;
    $post->end_time = $request->end_time;
    $post->start_break = $request->start_break;
    $post->end_break = $request->end_break;
    $post->absence_type_id = $request->absence_type_id;
    $post->grace_for_late = $request->grace_for_late;
    $post->premi = $request->premi;
    $post->remark = $request->remark;
    $post->status = $request->status;
    $post->updated_by = Auth::id();
    $post->save();

    return response()->json($post);
  }
  }

  public function delete($id)
  {
    //dd($id);
    $post =  Shift::Find($id);
    $post->delete();

    return response()->json($post);
  }

  public function deletebulk(Request $request)
  {

   $idkey = $request->idkey;

  //$count = count($idkey);

//    $i = 0;
// dd($idkey[$i]);

//    $idkey = (object) $idkey;
// dd($idkey);

   foreach($idkey as $key => $id)
   {
    // $post =  Shift::where('id', $id["1"])->get();
    $post = Shift::Find($id["1"]);
    $post->delete();
  }

  echo json_encode(array("status" => TRUE));

}

    public function list()
    {
        $shifts = Shift::all();

        return response()->json($shifts);
    }

    public function shiftKaryawan($id)
    {
        try {
            $employee = Employee::with([
                'shiftEmployee',
                'shiftGroupEmployee',
                'shiftGroupEmployee.shiftGroupDetail',
                'shiftGroupEmployee.shiftGroupDetail.shift',
            ])->find($id);

            if (empty($employee)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found'
                ], 404);
            }

            if (empty($employee->shiftGroupEmployee)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please Insert Shift Group Employee before proceed'
                ], 400);
            }

            // Mapping of day numbers to names
            $shiftStatus = $this->checkShiftStatus($employee->shiftGroupEmployee->shiftGroupDetail);

            return response()->json([
                'status' => true,
                'message' => 'Data found',
                'data' => $shiftStatus
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => "Internal Server Error",
                'error' => $th->getMessage()
            ], 500);
        }
    }

    private function checkShiftStatus($shiftGroupDetails) {
        // Mapping of day numbers to names
        $daysMap = [
            1 => "Senin",
            2 => "Selasa",
            3 => "Rabu",
            4 => "Kamis",
            5 => "Jum'at",
            6 => "Sabtu",
            7 => "Minggu",
        ];

        // Get today's day number
        $todayNum = date('N');

        $todayName = $daysMap[$todayNum];

        // Find the shift detail for today
        $shiftDetail = $shiftGroupDetails->filter(function ($detail) use ($todayNum) {
            return $detail['day'] === intval($todayNum);
        })->first(); // Ambil elemen pertama jika ditemukan


        $checkHolidayExist = Holiday::where('holiday_date', Carbon::now()->format('Y-m-d'))
            ->where('exception_shift_id', $shiftDetail->shift->shift_code)
            ->first();

        if ($checkHolidayExist) {
            return response()->json([
                'success' => false,
                'message' => "Anda tidak dapat melakukan check-in/check-out karena Anda terdaftar untuk bekerja pada hari libur.",
                'data' => null
            ], 403);
        }

        if ($shiftDetail) {
            // Ambil shift_code
            $shiftCode = $shiftDetail->shift->shift_code;

            // Tentukan status berdasarkan shift_code
            if ($shiftCode === "OFF") {
                $status = "Hari Libur";
            } elseif ($shiftCode === "M" || $shiftCode === "D") {
                $status = "Hari Kerja";
            } else {
                $status = "Status Tidak Diketahui";
            }
        } else {
            // Jika tidak ada data untuk hari ini
            $status = "Tidak Ada Data untuk Hari Ini";
        }

        // Return hasil dengan nama hari
        return [
            'day' => $todayName,
            'status' => $status,
            'shift_id' => $shiftDetail->shift->id,
            'day_in' => $shiftDetail->shift->start_time ?? '00:00:00',
            'day_out' => $shiftDetail->shift->end_time ?? '00:00:00'
        ];
    }
}
