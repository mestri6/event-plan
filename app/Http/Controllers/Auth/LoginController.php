<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


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
    // protected $redirectTo = RouteServiceProvider::HOME;
    public function authenticated()
    {
        if (auth()->user()->role == 'Admin'){
           return redirect()->route('admin.dashboard');
        } elseif(auth()->user()->role == 'Mua'){
            return redirect()->route('mua.dashboard');
        } elseif(auth()->user()->role == 'Wo'){
            return redirect()->route('wo.dashboard');
        } elseif(auth()->user()->role == 'Customer'){
            return redirect()->route('customer.dashboard');
        }
        else {
            return abort(404);
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
