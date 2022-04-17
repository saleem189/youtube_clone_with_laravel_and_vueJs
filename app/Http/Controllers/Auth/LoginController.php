<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;

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
    public function redirectTo(){
        $role = Auth()->user()->role_id;
        switch($role){
            case 1:
                return route('home');
            case 2:
                // dd($role,"this is admin");
                return route('dashboard'); 
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

    public function logout(Request $request) {
        $details = [
            'title' => 'Food App Testing loged out email',
            'body' => 'You have Loged Out our Site Thankyou for joinig us'
        ];
        Mail::to(auth()->user()->email)->send(new \App\Mail\MyTestMail($details));
        Auth::logout();


        return redirect('/login');

    }


    


}
