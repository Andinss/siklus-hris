<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AbsenceLocation;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\Time;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AbsenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function data(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'size' => 'nullable|integer',
            'page' => 'nullable|integer',
            'sort' => 'nullable|string',
            'direction' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Ambil parameter dari request atau gunakan nilai default
        $size = $request->get('size', 10);       // Default 10 item per halaman
        $page = $request->get('page', 1);        // Default halaman pertama
        $sort = $request->get('sort', 'id');     // Default sort by 'id'
        $direction = $request->get('direction', 'asc'); // Default ascending order

        // Lakukan query dengan pagination dan sorting
        $absence = Time::orderBy($sort, $direction)->paginate($size, ['*'], 'page', $page);
        $absence->getCollection()->transform(function ($item) {
            if ($item->photo_path !== null) $item->photo_path = url('storage/' . $item->photo_path);  // Ubah menjadi URL lengkap
            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $absence->items(),  // Data pada halaman saat ini
            'pagination' => [
                'current_page' => $absence->currentPage(),
                'per_page' => $absence->perPage(),
                'total' => $absence->total(),
                'last_page' => $absence->lastPage(),
                'next_page_url' => $absence->nextPageUrl(),
                'prev_page_url' => $absence->previousPageUrl(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function clockIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'employee_id' => 'required|exists:employee,id',
            // 'nik' => 'required',
            'location_latitude' => 'required|numeric',
            'location_longitude' => 'required|numeric',
            'photo' => [
                'required',
                'regex:/^data:image\/(jpeg|png|jpg|gif);base64,/', // Validates image in base64 format
                function ($attribute, $value, $fail) {

                    $base64String = preg_replace('/^data:image\/\w+;base64,/', '', $value);
                    $decodedImage = base64_decode($base64String);

                    if (!$decodedImage) {
                        return $fail('The photo is not a valid base64 encoded image.');
                    }

                    if (strlen($decodedImage) > 5242880) {
                        return $fail('The photo must not exceed 5MB.');
                    }
                },
            ]
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $photo = $request->input('photo');

        $employee = Employee::with([
            'shiftEmployee',
            'shiftGroupEmployee',
            'shiftGroupEmployee.shiftGroupDetail',
            'shiftGroupEmployee.shiftGroupDetail.shift',
        ])->find(Auth::user()->employee_id);

        if (empty($employee)) {
            return response()->json([
                'success' => false,
                'message' => "You don't have data employee.",
                'data' => null,
            ], 403);
        }

        $faceVerification = $this->faceRecognition($photo, $employee);

        if ($faceVerification['success']) {
            $employeeLatitude = $request->input('location_latitude');
            $employeeLongitude = $request->input('location_longitude');

            // Retrieve the office location for this employee from the database
            $officeLocation = AbsenceLocation::whereHas('locationEmployees', function ($query) use ($request) {
                $query->where('employee_id', Auth::user()->employee_id);
            })->first();

            // Check if the employee is registered to an office location
            if (empty($officeLocation)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Karyawan ini tidak terdaftar di lokasi absensi mana pun.'
                ], 404);
            }

            if (empty($employee->shiftGroupEmployee)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please Insert Shift Group Employee before proceed',
                    'data' => null,
                ], 403);
            }

            $todayNum = date('N');

            $shiftDetail = $employee->shiftGroupEmployee->shiftGroupDetail->filter(function ($detail) use ($todayNum) {
                return $detail['day'] === intval($todayNum);
            })->first();

            if (empty($shiftDetail)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada Shift untuk hari ini.',
                    'data' => null
                ], 404);
            }

            $checkHolidayExist = Holiday::where('holiday_date', Carbon::now()->format('Y-m-d'))
                ->where('exception_shift_id', $shiftDetail->shift->shift_code)
                ->first();

            if ($checkHolidayExist) {
                return response()->json([
                    'success' => false,
                    'message' => "Anda tidak dapat melakukan check-in/check-out karena Anda terdaftar untuk bekerja pada hari libur.",
                    'data' => null,
                ], 403);
            }

            $base64Photo = preg_replace('/^data:image\/\w+;base64,/', '', $photo);
            $photoData = base64_decode($base64Photo);
            $photoUploadPath = 'absence/' . uniqid() . '.png';

            Storage::disk('public')->put($photoUploadPath, $photoData);

            $officeLatitude = $officeLocation->location_latitude;
            $officeLongitude = $officeLocation->location_longitude;

            // Allowed radius (in meters)
            $allowedRadius = $officeLocation->location_radius;

            // Calculate the distance between the employee and the office
            $distance = $this->calculateDistance($employeeLatitude, $employeeLongitude, $officeLatitude, $officeLongitude);

            // Check if the employee is within the allowed radius
            $isWithinRadius = $distance <= $allowedRadius;

            // Periksa apakah absensi sudah ada untuk hari ini
            $existingAbsence = Time::where('date_in', Carbon::now()->format('Y-m-d'))
            ->where('employee_id', Auth::user()->employee_id)
            ->exists();

            if ($existingAbsence) {
                return response()->json([
                    'success' => false,
                    'message' => 'Check-in hanya bisa dilakukan sekali per hari.',
                    'data' => null
                ], 400);
            }

            [$timeClockIn, $graceForLate] = $this->checkTimeClockIn($employee->shiftGroupEmployee->shiftGroupDetail);
            $timeClockIn = Carbon::parse($timeClockIn);

            $lateIn = null;
            $lateInCounter = null;

            // Pemeriksaan jika terlambat melakukan absensi
            if (Carbon::now()->gt($timeClockIn)) {

                // Pemeriksaan keterlambatan apakah melebihi toleransi terlambat
                if (Carbon::now()->diffInMinutes($timeClockIn) > $graceForLate) {
                    $lateIn = Carbon::now()->diffInMinutes($timeClockIn) - $graceForLate;
                    $lateInCounter = 1;
                }
            }

            $absence = Time::updateOrCreate(
                [
                    'date_in' => Carbon::now()->format('Y-m-d'),
                    'employee_id' => Auth::user()->employee_id,
                    'nik' => $employee->nik,
                ],
                [
                    'shift_group_id' => $employee->shiftGroupEmployee->id,
                    'shift_id' => $shiftDetail->shift->id,
                    'day_in' => $shiftDetail->shift->start_time,
                    'day_out' => $shiftDetail->shift->end_time,
                    'actual_in' => Carbon::now()->format('H:i:s'),
                    'location_latitude_in' => $request->location_latitude,
                    'location_longitude_in' => $request->location_longitude,
                    'photo_path_in' => $photoUploadPath,
                    'counter_radius' => $isWithinRadius ? 0 : 1,
                    'present' => 1,
                    'late_in_counter' => $lateInCounter,
                    'late_in' => $lateIn
                ]
            );

            $absence->photo_path = Storage::url($absence->photo_path);

            $message = $isWithinRadius
                ? 'Berhasil Melakukan Absensi Masuk.'
                : 'Anda berada di luar area absensi yang diizinkan.';

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $absence
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => $faceVerification['message'],
            ], 403);
        }
    }

    public function clockOut(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'employee_id' => 'required|exists:employee,id',
            // 'nik' => 'required|exists:employee,nik',
            'location_latitude' => 'required|numeric',
            'location_longitude' => 'required|numeric',
            'photo' => [
                'required',
                'regex:/^data:image\/(jpeg|png|jpg|gif);base64,/', // Validates image in base64 format
                function ($attribute, $value, $fail) {

                    $base64String = preg_replace('/^data:image\/\w+;base64,/', '', $value);
                    $decodedImage = base64_decode($base64String);

                    if (!$decodedImage) {
                        return $fail('The photo is not a valid base64 encoded image.');
                    }

                    if (strlen($decodedImage) > 5242880) {
                        return $fail('The photo must not exceed 5MB.');
                    }
                },
            ]
        ]);

        $dateNow = Carbon::now()->format('Y-m-d');
        $timeNow = Carbon::now()->format('H:i:s');

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // $absen = Time::where('date_in', $dateNow)
        //     ->where('employee_id', $request->employee_id)
        //     ->where('nik', $request->nik)
        //     ->where('actual_in', '!=', null)
        //     ->first();

        // if (!empty($absen)) {

            $photo = $request->input('photo');

            $employee = Employee::with([
                'shiftEmployee',
                'shiftGroupEmployee',
                'shiftGroupEmployee.shiftGroupDetail',
                'shiftGroupEmployee.shiftGroupDetail.shift',
            ])->find(Auth::user()->employee_id);

            if (empty($employee)) {
                return response()->json([
                    'success' => false,
                    'message' => "You don't have data employee.",
                    'data' => null,
                ], 403);
            }

            $faceVerification = $this->faceRecognition($photo, $employee);

            if ($faceVerification['success']) {
                $employeeLatitude = $request->input('location_latitude');
                $employeeLongitude = $request->input('location_longitude');

                // Retrieve the office location for this employee from the database
                $officeLocation = AbsenceLocation::whereHas('locationEmployees', function ($query) use ($request) {
                    $query->where('employee_id', Auth::user()->employee_id);
                })->first();

                // Check if the employee is registered to an office location
                if (empty($officeLocation)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Karyawan ini tidak terdaftar di lokasi absensi mana pun.'
                    ], 404);
                }

                if (empty($employee->shiftGroupEmployee)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please Insert Shift Group Employee before proceed',
                        'data' => null,
                    ], 403);
                }

                $todayNum = date('N');

                $shiftDetail = $employee->shiftGroupEmployee->shiftGroupDetail->filter(function ($detail) use ($todayNum) {
                    return $detail['day'] === intval($todayNum);
                })->first();

                if (empty($shiftDetail)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada Shift untuk hari ini.',
                        'data' => null
                    ], 404);
                }

                $checkHolidayExist = Holiday::where('holiday_date', Carbon::now()->format('Y-m-d'))
                    ->where('exception_shift_id', $shiftDetail->shift->shift_code)
                    ->first();

                if ($checkHolidayExist) {
                    return response()->json([
                        'success' => false,
                        'message' => "Anda tidak dapat melakukan check-in/check-out karena Anda terdaftar untuk bekerja pada hari libur.",
                        'data' => null,
                    ], 403);
                }

                $base64Photo = preg_replace('/^data:image\/\w+;base64,/', '', $photo);
                $photoData = base64_decode($base64Photo);
                $photoUploadPath = 'absence/' . uniqid() . '.png';

                Storage::disk('public')->put($photoUploadPath, $photoData);

                $existingAbsenceClockIn = Time::where('date_in', $dateNow)
                    ->where('employee_id', Auth::user()->employee_id)
                    ->where('nik', $employee->nik)
                    ->first();

                $officeLatitude = $officeLocation->location_latitude;
                $officeLongitude = $officeLocation->location_longitude;

                // Allowed radius (in meters)
                $allowedRadius = $officeLocation->location_radius;

                // Calculate the distance between the employee and the office
                $distance = $this->calculateDistance($employeeLatitude, $employeeLongitude, $officeLatitude, $officeLongitude);

                // Check if the employee is within the allowed radius
                $isWithinRadius = $distance <= $allowedRadius;

                // Periksa apakah absensi sudah ada untuk hari ini
                $existingAbsence = Time::where('date_out', Carbon::now()->format('Y-m-d'))
                    ->where('employee_id', Auth::user()->employee_id)
                    ->exists();

                if ($existingAbsence) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Check-out hanya bisa dilakukan sekali per hari.',
                        'data' => null
                    ], 400);
                }

                // Periksa apakah absensi keluar sudah diizinkan
                $timeClockOut = Carbon::parse($this->checkTimeClockOut($employee->shiftGroupEmployee->shiftGroupDetail));
                $earlyOutCounter = null;

                if (Carbon::now()->lessThan($timeClockOut)) {
                    $earlyOutCounter = 1;
                }

                if (empty($existingAbsenceClockIn)) {
                    $absence = Time::updateOrCreate(
                        [
                            'date_out' => $dateNow,
                            'employee_id' => Auth::user()->employee_id,
                            'nik' => $employee->nik,
                        ],
                        [
                            'shift_group_id' => $employee->shiftGroupEmployee->id,
                            'shift_id' => $shiftDetail->shift->id,
                            'day_in' => $shiftDetail->shift->start_time,
                            'day_out' => $shiftDetail->shift->end_time,
                            'actual_out' => $timeNow,
                            'location_latitude_out' => $request->location_latitude,
                            'location_longitude_out' => $request->location_longitude,
                            'photo_path_out' => $photoUploadPath,
                            'counter_radius' => $isWithinRadius ? 0 : 1,
                            'early_out_counter' => $earlyOutCounter
                        ]
                    );

                } else {
                    $existingAbsenceClockIn->update(
                        [
                            'date_out' => $dateNow,
                            'employee_id' => Auth::user()->employee_id,
                            'nik' => $employee->nik,
                            'shift_group_id' => $employee->shiftGroupEmployee->id,
                            'shift_id' => $shiftDetail->shift->id,
                            'day_in' => $shiftDetail->shift->start_time,
                            'day_out' => $shiftDetail->shift->end_time,
                            'actual_out' => $timeNow,
                            'location_latitude_out' => $request->location_latitude,
                            'location_longitude_out' => $request->location_longitude,
                            'photo_path_out' => $photoUploadPath,
                            'counter_radius' => $isWithinRadius ? 0 : 1,
                            'early_out_counter' => $earlyOutCounter
                        ],
                    );

                    $absence = $existingAbsenceClockIn;
                }

                $absence->photo_path = Storage::url($absence->photo_path);

                $message = $isWithinRadius
                    ? 'Berhasil Melakukan Absensi Keluar.'
                    : 'Anda berada di luar area absensi yang diizinkan.';

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'data' => $absence,
                    'similiarity' => $faceVerification['similarity']
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $faceVerification['message']
                ], 403);
            }

        // } else {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Silahkan lakukan absen masuk terlebih dahulu'
        //     ], 400);
        // }

    }

    public function detailProfile($id)
    {
        try {
            // $employee = Employee::findOrFail($id);

            $absence = Time::with(['employee'])
                ->where(function ($query) {
                    $query->where('date_in', Carbon::now()->format("Y-m-d"))
                    ->orWhere('date_out', Carbon::now()->format('Y-m-d'));
                })
                ->where('employee_id', $id)->firstOrFail();

            return response()->json([
                'success' => true,
                'message' => 'Data ditemukan',
                'data' => [
                    'employee' => $absence->employee,
                    'actual_in' => $absence->actual_in,
                    'actual_out' => $absence->actual_out
                ]
                ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan lakukan Check-in atau Check-out terlebih dahulu.',
                'data' => [
                    'actual_in' => null,
                    'actual_out' => null
                ]
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function riwayatAbsensi(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'start_date' => 'required|date',
                'end_date' => 'required|date'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $startDate = $request->start_date;
            $endDate = $request->end_date;

            $absence = Time::where('employee_id', $id)
                ->whereBetween('created_at', [$startDate, $endDate])->get();

            $officeLocation = AbsenceLocation::whereHas('locationEmployees', function ($query) use ($id) {
                $query->where('employee_id', $id);
            })->first();

            // Check if the employee is registered to an office location
            if (!$officeLocation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Karyawan ini tidak terdaftar di lokasi absensi mana pun.'
                ], 404);
            }

            $totalAttendance = 0;
            $totalOnTime = 0;
            $totalLate = 0;

            // Proses setiap data absensi
            $absenceList = $absence->map(function ($record) use (&$totalAttendance, &$totalOnTime, &$totalLate) {
                // Hitung kehadiran
                if ($record->actual_in && $record->actual_out) {
                    $totalAttendance++;

                    // Hitung tepat waktu atau terlambat
                    if ($record->actual_in <= $record->day_in) {
                        $totalOnTime++;
                    } else {
                        $totalLate++;
                    }
                }

                // Format data absensi
                return [
                    'date' => $record->created_at->format('Y-m-d'),
                    'day_in' => $record->day_in,
                    'actual_in' => $record->actual_in,
                    'day_out' => $record->day_out,
                    'actual_out' => $record->actual_out,
                    'status' => $record->actual_in <= $record->day_in ? 'On Time' : 'Late',
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Data ditemukan',
                'data' => [
                    'absence_list' => $absenceList,
                    'total_attendance' => $totalAttendance,
                    'total_on_time' => $totalOnTime,
                    'total_late' => $totalLate,
                    'location_address' => $officeLocation->location_address
                ]
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    protected function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius in meters

        // Konversi derajat ke radian dan Hitung perbedaan antara koordinat
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        // Hitung jarak menggunakan rumus Haversine
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    protected function faceRecognition($base64String, $employee)
    {
        $employeeImagePath = public_path('uploads/employee/'. $employee->image);

        if (!file_exists($employeeImagePath)) {
            return [
                'success' => false,
                'message' => "Employee $employee->employee_name photo not found for comparison.",
            ];
        }

        // Decode base64 input and save as temp image
        $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $base64String);

        // Face verification using Compreface
        $comprefaceUrl = env('COMPREFACE_BASE_URL');

        // Cek apakah URL aktif
        // $urlCheckResponse = Http::get($comprefaceUrl);

        // if (!$urlCheckResponse->successful()) {
        //     return [
        //         'success' => false,
        //         'message' => 'The CompreFace URL is not reachable or active.',
        //     ];
        // }

        $response = Http::withHeaders([
            'x-api-key' => env('COMPREFACE_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post("{$comprefaceUrl}?face_plugins=landmarks, gender, age, pose", [
            'source_image' => base64_encode(file_get_contents($employeeImagePath)),
            'target_image' => $imageData,
        ]);

        $data = $response->json();

        // Hasil Response dari Aplikasi CompreFace
        if ($response->successful() && isset($data['result'][0]['face_matches'][0]['similarity'])) {
            $similarity = $data['result'][0]['face_matches'][0]['similarity'];
            $confidenceThreshold = 0.8;

            return [
                'success' => $similarity >= $confidenceThreshold,
                'similarity' => $similarity,
                'message' => $similarity >= $confidenceThreshold
                    ? 'Face matched with high confidence!'
                    : 'Face does not match with high enough confidence.',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Face verification failed or no similarity found.',
            ];
        }
    }

    private function checkTimeClockOut($shiftGroupDetails)
    {
        $todayNum = date('N');

        $shiftDetail = $shiftGroupDetails->filter(function ($detail) use ($todayNum) {
            return $detail['day'] === intval($todayNum);
        })->first();

        return $shiftDetail->shift->end_time;
    }

    private function checkTimeClockIn($shiftGroupDetails)
    {
        $todayNum = date('N');

        $shiftDetail = $shiftGroupDetails->filter(function ($detail) use ($todayNum) {
            return $detail['day'] === intval($todayNum);
        })->first();

        return [
            $shiftDetail->shift->start_time,
            $shiftDetail->shift->grace_for_late
        ];
    }
}
