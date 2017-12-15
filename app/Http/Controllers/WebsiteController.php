<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Validator; 
use Auth;

class WebsiteController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('checkgen');
        parent::__construct();
    }

    public function addInquiry(Request $req, Validator $validator){
		$eventdate = date_format(date_create($_POST['eventdate']),"Y-m-d");
		$eventid = DB::table('event_details')->insertGetId([
			'event_date' => $eventdate,
			'event_time' => date_format(date_create($_POST['eventtime']),"H:i:s"),
			'event_guest_count' => $_POST['guest'],
			'event_occassion' => $_POST['occassion'],
			'event_address' => $_POST['location'],
		]);
		$clientid = DB::table('client_details')->insertGetId([
			'client_fname' => $_POST['fname'],
			'client_lname' => $_POST['lname'],
			'client_contact1' => $_POST['phone'],
			'client_email' => $_POST['email'],
		]);
		DB::table('event_inquiry')->insert([
			'client_id' => $clientid,
			'event_id' => $eventid,
			'event_inquiry_date'=>date("Y-m-d"),
			'event_inquiry_message'=> $_POST['message'],
		]);

		return redirect('/Contact-Us');
	}
	public function Homepage(){
		$general = DB::table('settings_general')->get();
		return view('website.homepage',['gen' => $general]);
	}
	public function Menus(){
		$general = DB::table('settings_general')->get();
		$category = DB::table('submenu_category as s')->where('s.deleted',0)->get();
		$menu = DB::table('submenu')->join('submenu_category', 'submenu.submenu_category_id', '=', 'submenu_category.submenu_category_id')->where('submenu.deleted',0)->orderby('submenu_name')->get();
		return view('website.menus',['gen' => $general,'category'=>$category,'menu'=>$menu]);
	}
	public function Package(){
		$general = DB::table('settings_general')->get();
		$pk = DB::table('package')->where('deleted',0)->where('package_status',0)->get();
		return view('website.package',['gen' => $general, 'pk' => $pk]);
	}
	public function ContactUs(){
		$general = DB::table('settings_general')->get();
		return view('website.contactus',['gen' => $general]);
	}

	// website ajax
	public function wgetFood(Request $req){
		$foods = DB::table('submenu')->where('submenu_category_id',$req->cat)->where('deleted',0)->get();
		return response()->json($foods);
	}
}
