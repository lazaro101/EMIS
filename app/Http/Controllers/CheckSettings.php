<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use DB; 

class CheckSettings extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }

    public function editGeneral(){
        DB::table('settings_general')->insert([
            'catering_name' => $_POST['cname'],
            'contact_fname' => $_POST['fname'],
            'contact_lname' => $_POST['lname'],
            'contact_cell' => $_POST['cnum'],
            'contact_tele' => $_POST['tnum'],
            'contact_email' => $_POST['email'],
            'address' => $_POST['address'],
            'barangay' => $_POST['brgny'],
            'city' => $_POST['city'],
            'province' => $_POST['province'],
            'updated_at' => date_create('now')
        ]);
        return redirect('Admin/Settings/General');
    }
}
