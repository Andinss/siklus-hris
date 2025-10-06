<?php

namespace App\Http\Controllers\Editor;

use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\AbsenceLocationRequest;
use App\Http\Controllers\Controller;
use App\Models\AbsenceLocation;
use App\Models\AbsenceLocationEmployee;
use App\Models\Department;
use Response;
use App\Post;
use Illuminate\Support\Facades\Validator;
use View;
use Yajra\DataTables\Facades\DataTables;

class AbsenceLocationController extends Controller
{
    /**
     * @var array
     */
    protected $rules =
    [

    ];

  public function index()
  {
    return view ('editor.absence_location.index');
  }

  public function data()
  {
    if (request()->ajax())
    {
        $absenceLocation = AbsenceLocation::latest()->get();

        return DataTables::of($absenceLocation)
            ->addColumn('action', function ($itemdata) {
                return '<a href="javascript:void(0)" title="Hapus" onclick="delete_id(' . "'" . $itemdata->id . "', '" . $itemdata->location_name . "'" . ')" class="btn btn-danger btn-xs mr-2"> <i class="ti-trash"></i> Hapus</a>
                    <a href="'.route('editor.absence-location.edit', $itemdata->id).'" title="Edit" class="btn btn-warning btn-xs mr-2"> <i class="ti-pencil"></i> Edit</a>';
            })
            ->toJson();
    } else {
        exit("No data available");
    }
  }

  public function create()
  {
    $departments = Department::select('id', 'department_name')->get();

    return view ('editor.absence_location.form', compact('departments'));
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
        'location_name' => 'required|string',
        'location_address' => 'required|string',
        'location_latitude' => 'required|string',
        'location_longitude' => 'required|string',
        'location_radius' => 'required|integer',
        'location_description' => 'nullable|string'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->getMessageBag()->toArray()
        ], 422);
    } else {

        DB::transaction(function() use ($request) {
            $absenceLocation = new AbsenceLocation();
            $absenceLocation->location_name = $request->location_name;
            $absenceLocation->location_address = $request->location_address;
            $absenceLocation->location_latitude = $request->location_latitude;
            $absenceLocation->location_longitude = $request->location_longitude;
            $absenceLocation->location_radius = $request->location_radius;
            $absenceLocation->location_description = $request->location_description;
            $absenceLocation->save();

            foreach($request->employees as $employee) {
                AbsenceLocationEmployee::create([
                    'absence_location_id' => $absenceLocation->id,
                    'employee_id' => $employee['id']
                ]);
            }
        });

        return response()->json(['status' => true, 'message' => 'Location and employees saved successfully']);
    }
  }

  public function edit($id)
  {
    // Mengambil data lokasi berdasarkan ID
    $absenceLocation = AbsenceLocation::with([
        'employees',
        'employees.departement',
        'employees.position'
    ])->findOrFail($id);
    // dd($absenceLocation);

    // Mengambil semua data divisi
    $departments = Department::all();

    return view('editor.absence_location.edit', compact('absenceLocation', 'departments'));
  }

  public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'location_name' => 'required|string',
            'location_address' => 'required|string',
            'location_latitude' => 'required|string',
            'location_longitude' => 'required|string',
            'location_radius' => 'required|integer',
            'location_description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 422);
        } else {

            // Update data lokasi absensi
            $absenceLocation = AbsenceLocation::findOrFail($id);
            $absenceLocation->location_name = $request->location_name;
            $absenceLocation->location_address = $request->location_address;
            $absenceLocation->location_latitude = $request->location_latitude;
            $absenceLocation->location_longitude = $request->location_longitude;
            $absenceLocation->location_radius = $request->location_radius;
            $absenceLocation->location_description = $request->location_description;
            $absenceLocation->save();

            // Update data karyawan yang terhubung dengan lokasi absensi
            $employeeIds =  array_map(function($employee) {
                return $employee['id'];
            }, $request->employees); // Ambil data karyawan yang dipilih
            $absenceLocation->employees()->sync($employeeIds); // Sinkronisasi dengan tabel pivot

            return response()->json(['status' => true, 'message' => 'Location and employees saved successfully']);
        }
    }

    public function delete($id)
    {
        $absenceLocation = AbsenceLocation::findOrFail($id);
        $absenceLocation->delete();

        $absenceLocation->employees()->sync([]);

        return response()->json(['status' => true, 'message' => 'Location and employees removed successfully']);
    }
}
