<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeInvite;
use App\Models\Privilege;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class EmployeeInviteController extends Controller
{
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

    public function showRegistrationFormEmployee(Request $request)
    {
        $token = $request->query('token');

        // Cek apakah token valid
        $invite = EmployeeInvite::where('token', $token)->first();

        if (!$invite) {
            return redirect('/')->with('error', 'Token tidak valid atau sudah kadaluwarsa.');
        }

        return view('editor.employee_invite.create-password', ['email' => $invite->email, 'token' => $token]);
    }

    public function registerEmployee(Request $request)
    {
        $permissions = [
            [
                'module_id' => 5,
                'action_id' => 1
            ],
            [
                'module_id' => 7,
                'action_id' => 1
            ],
            [
                'module_id' => 8,
                'action_id' => 1
            ],
            [
                'module_id' => 9,
                'action_id' => 1
            ],
            [
                'module_id' => 10,
                'action_id' => 1
            ],
            [
                'module_id' => 11,
                'action_id' => 1
            ],
            [
                'module_id' => 13,
                'action_id' => 1
            ],
            [
                'module_id' => 14,
                'action_id' => 1
            ],
            [
                'module_id' => 15,
                'action_id' => 1
            ],
            [
                'module_id' => 16,
                'action_id' => 1
            ],
            [
                'module_id' => 18,
                'action_id' => 1
            ],
            [
                'module_id' => 20,
                'action_id' => 1
            ],
            [
                'module_id' => 21,
                'action_id' => 1
            ],
            [
                'module_id' => 75,
                'action_id' => 1
            ],
        ];

        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required',
        ]);

        // Cek token di database
        $invite = EmployeeInvite::where('token', $request->token)->first();

        if (!$invite || $invite->email !== $request->email) {
            return back()->withErrors(['token' => 'Token tidak valid.']);
        }

        $employee = Employee::where('email', $request->input('email'))->first();

        // Buat akun karyawan
        $user = new User();
        $user->employee_id = $employee->id;
        $user->username = strtolower($employee->nick_name);
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        $user_role = new UserRole();
        $user_role->user_id = $user->id;
        $user_role->role_id = 3;
        $user_role->save();

        foreach($permissions as $key => $value)
        {
            $privilege = new Privilege();
            $privilege->user_id = $user->id;
            $privilege->module_id = $value['module_id'];
            $privilege->action_id = $value['action_id'];
            $privilege->save();
        }

        // Hapus token undangan setelah digunakan
        $invite->delete();

        return redirect('/login')->with('success', 'Password berhasil dibuat. Silakan login.');
    }

    public function getGeolocation()
    {
        return view('editor.employee.attendance.clock_in');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
}
