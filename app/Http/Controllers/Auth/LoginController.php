<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    #protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectTo()
    {
        $role = Auth::user()->role;

        if($role == 'player')
        {
            return '/player/dashboard';
        }
        elseif($role == 'agent')
        {
            return '/agent/dashboard';
        }
        elseif($role == 'club')
        {
            return '/club/dashboard';
        }
        elseif($role == 'sponsor')
        {
            return '/sponsor/dashboard';
        }
        elseif($role == 'user')
        {
            return '/user/dashboard';
        }
        else
        {
            return redirect(RouteServiceProvider::LOGOUTROUTE);
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
