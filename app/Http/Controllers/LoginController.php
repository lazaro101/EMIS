<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Validator; 
use Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function Login(Request $req, Validator $validator)
    {
        $user = DB::table('users')->where('deleted',0)->get();
        
        if (count($user) == 0) {
            DB::table('users')->insert(
                [
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'role' => 'admin',
                'display_name' => 'admin',
                'email' => '',
                'created_at' => date_create('now'),
                'updated_at' => date_create('now'),
                ]);
            // return view('login');
        }        
        return view('login');
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

        if(Auth::attempt(['username'=> $user,'password'=> $pass, 'deleted' => 0])){
            $set = DB::table('settings_general')->get();
            if (count($set) == 0) {
                return redirect('/Site-Setup');
            } else {
                return redirect('/Admin/Dashboard');  
            }
        }
        else{
            return redirect('/Admin')->with('message',['text'=>'Wrong Username and/or Password.']);
        }    
    }
    public function doRegister(){
        DB::table('users')->insert(
            [
            'username' => $_POST['username'],
            'password' => bcrypt($_POST['password']),
            'remember_token' => $_POST['_token'],
            'role' => 'admin',
            'display_name' => $_POST['username'],
            'email' => '',
            'created_at' => date_create('now'),
            'updated_at' => date_create('now'),
            ]
        );
        return redirect('/Admin');
    }

}
