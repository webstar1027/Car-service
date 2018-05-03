<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function postSign (Request $request) {

      $email = $request->email;
      $password = $request->password;
      $correctCredentials = Auth::attempt(['email' => $email, 'password' => $password]) ? true : false;

        //$roleRedirectHelper = new RoleRedirectHelper;

        if($correctCredentials)
        {
            return redirect('/shopowner');           
        }

        return redirect('/shopowner/login')->with('error', 'Invalid credentials.');
    }
}
