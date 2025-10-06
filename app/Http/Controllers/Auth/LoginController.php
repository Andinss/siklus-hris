<?php

namespace App\Http\Controllers\Auth;

use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserLog;
use App\Models\Preference;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/editor';
    protected $redirectPath = '/editor';
    protected $redirectAfterLogout = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //Session::put($request->branch_id);
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        $preference = Preference::Where('id', 1)->first();

        return view('auth.login', compact('preference'));
    }

    public function login(Request $request)
    {

        Session::put('branch_id', $request->branch_id);
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $log = new UserLog();
            $arrToJson = ['action' => 'login', 'user_id' => Auth::id()];
            $log->user_id = Auth::id();
            $log->scope = 'AUTHENTICATION';
            $log->data = json_encode($arrToJson);

            $log->save();
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.

        //Session::put($request->branch_id);
        session(['branch_id' => $request->branch_id]);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    public function logout(Request $request)
    {
        $log = new UserLog;
        $arrToJson = ['action' => 'logout', 'user_id' => Auth::id()];
        $log->user_id = Auth::id();
        $log->scope = 'AUTHENTICATION';
        $log->data = json_encode($arrToJson);

        $log->save();

        $request->session()->flush();
        $request->session()->regenerate();
        return redirect($this->redirectAfterLogout);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        return redirect('/');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => Lang::get('auth.failed'),
            ]);
    }
}
