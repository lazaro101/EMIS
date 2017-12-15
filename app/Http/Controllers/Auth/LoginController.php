<?php

namespace app\Http\Controllers\Auth;

use app\Http\Controllers\Controller;
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
    protected $redirectTo = 'Admin/Dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function doLogin(Request $req, Validator $validator){
        
        $validator = Validator::make(
            $req->all(),
            [
                'email' => 'required',
                'password' => 'required'
            ]
            );

        if ($validator->fails()){
            return redirect('/Admin')
            ->withErrors($validator)
            ->withInput();
        }

        $user = $req->input('email');
        $pass = $req->input('password');

        if(Auth::attempt(['email'=> $user,'password'=> $pass, 'deleted' => 0])){
            return redirect('Admin/Dashboard');  
        }
        else{
            return redirect('/Admin');
        }
        
    }
}
