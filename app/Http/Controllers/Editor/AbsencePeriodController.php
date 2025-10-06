<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\AbsencePeriodRequest;
use App\Http\Controllers\Controller;
use App\Models\AbsencePeriod;
use Response;
use App\Post;
use Illuminate\Support\Facades\Validator;
use View;
use Yajra\DataTables\Facades\DataTables;

class AbsencePeriodController extends Controller
{
  public function index()
  {
    return view ('editor.absence_period.index');
  }

  public function data()
  {
    if (request()->ajax()) {
        $query = AbsencePeriod::query();

        return DataTables::of($query)
            ->addColumn('action', function ($itemdata) {
                return '<a href="javascript:void(0)" onclick="delete_id(' . "'" . $itemdata->id . "', '" . $itemdata->absence_group_name . "'" . ')" title="Hapus" class="btn btn-sm btn-danger"> <i class="fas fa-trash-alt"></i> Hapus</a>';
            })
            ->toJson();
    } else {
        exit("No Data available");
    }
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
        'absence_group_name' => 'required|string',
        'begin_date' => 'required|date',
        'end_date' => 'required|date',
        'day_in' => 'required|integer',
        'status' => 'required|integer'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->getMessageBag()->toArray()
        ], 422);
    }

    $absencePeriod = new AbsencePeriod();
    $absencePeriod->absence_group_name = $request->absence_group_name;
    $absencePeriod->begin_date = $request->begin_date;
    $absencePeriod->end_date = $request->end_date;
    $absencePeriod->day_in = $request->day_in;
    $absencePeriod->status = $request->status;
    $absencePeriod->save();

    return response()->json($absencePeriod);
  }

  public function edit($id)
  {
    $absencePeriod = AbsencePeriod::find($id);
    return response()->json($absencePeriod);
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
        'absence_group_name' => 'required|string',
        'begin_date' => 'required|date',
        'end_date' => 'required|date',
        'day_in' => 'required|integer',
        'status' => 'required|integer'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->getMessageBag()->toArray()
        ], 422);
    }

    $absencePeriod = AbsencePeriod::find($id);
    $absencePeriod->absence_group_name = $request->absence_group_name;
    $absencePeriod->begin_date = $request->begin_date;
    $absencePeriod->end_date = $request->end_date;
    $absencePeriod->day_in = $request->day_in;
    $absencePeriod->status = $request->status;
    $absencePeriod->save();

    return response()->json($absencePeriod);
  }

  public function delete($id)
  {
    $absencePeriod = AbsencePeriod::find($id);
    $absencePeriod->delete();

    return response()->json($absencePeriod);
  }
}
