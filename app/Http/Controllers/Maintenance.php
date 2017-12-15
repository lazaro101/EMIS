<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Validator; 
use Auth;

class Maintenance extends Controller
{
	
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkgen');
        parent::__construct();
    }

	public function Package(){
		$query = DB::table('package as p')->leftjoin('package_choice as pc','p.package_id','=','pc.package_id')->select(DB::raw('count(pc.submenu_category_id) as subcount, p.package_id,p.package_name,p.package_inclusions,p.package_price,p.package_status'))->groupBy('package_id','package_name','package_inclusions','package_price','package_status');
		if (isset($_GET['srch'])) {
			$query->where('package_name','like',$_GET['srch'].'%');
		}
		$package = $query->where('deleted','=',0)->orderby('package_name')->get();
		return view('maintenance.package',['package' => $package]);
	}
	public function retrievePackage(Request $req){
		$var = DB::table('package')->where('package_id',$req->ID)->where('deleted',0)->get();
		$var1 = DB::table('package_choice')->where('package_id',$req->ID)->orderby('submenu_category_id')->get();
		return response()->json([$var,$var1]);
	}
	public function retrieveSelected(Request $req){
		$var = DB::table('food_choice')->where('package_choice_id',$req->pcid)->where('submenu_category_id',$req->scid)->get();
		// $var = $req->scid;
		return response()->json($var);
	}
	public function validatePackage(Request $req){
		$var = DB::table('package')->where('package_name',$req->value)->where('deleted',0)->count();
		return response()->json($var);
	}
	public function changePackageStatus(Request $req){
		DB::table('package')->where('package_id',$req->id)->update([ 'package_status' => $req->status ]);
		return response()->json();
	}

	public function Submenu(){
		$submenu = DB::table('submenu')->join('submenu_category', 'submenu.submenu_category_id', '=', 'submenu_category.submenu_category_id')->where('submenu.deleted',0)->orderby('submenu_name')->get();
		$category = DB::table('submenu_category as sc')->leftjoin('submenu as s','sc.submenu_category_id','=','s.submenu_category_id')->select(DB::raw('count(case when s.deleted = 0 then 1 else null end) as subcount, sc.submenu_category_name,sc.submenu_category_id'))->groupBy('submenu_category_name','submenu_category_id')->where('sc.deleted',0)->get();
		$ctgry = DB::table('submenu_category')->where('deleted','=',0)->orderby('submenu_category_name')->get();
		return view('maintenance.submenu',['category' => $category,'ctgry' => $ctgry,'ctgry1' => $ctgry,'submenu' => $submenu]);
	}
	public function retrieveSubmenu(Request $req){
		$var = DB::table('submenu')->where('submenu_id',$req->ID)->where('deleted',0)->get();
		return response()->json($var);
	}
	public function validateSubmenu(Request $req){
		$var = DB::table('submenu')->where('submenu_name',$req->value)->where('deleted',0)->get();
		return response()->json($var);
	}
	public function retrieveSubmenuCategory(Request $req){
		$var = DB::table('submenu_category')->where('submenu_category_id',$req->ID)->where('deleted',0)->get();
		return response()->json($var);
	}
	public function validateSubmenuCategory(Request $req){
		$var = DB::table('submenu_category')->where('submenu_category_name',$req->value)->where('deleted',0)->get();
		return response()->json($var);
	}
	public function changeSubmenuStatus(Request $req){
		DB::table('submenu')->where('submenu_id',$req->id)->update([ 'submenu_status' => $req->status ]);
		return response()->json();
	}


	public function Services(){
		$contact = DB::table('services_contact')->join('services', 'services_contact.services_id', '=', 'services.services_id')->where('services_contact.deleted','=',0)->orderby('services_contact_name')->get();
		$service = DB::table('services')->where('deleted','=',0)->orderby('services_name')->get();
		return view('maintenance.services',['contact' => $contact,'service' => $service]);
	}
	public function retrieveServices(Request $req){
		$var = DB::table('services')->where('services_id',$req->ID)->where('deleted',0)->get();
		return response()->json($var);
	}
	public function validateServices(Request $req){
		$var = DB::table('services')->where('services_name',$req->value)->where('deleted',0)->get();
		return response()->json($var);
	}
	public function retrieveServiceContact(Request $req){
		$var = DB::table('services_contact')->where('services_contact_id',$req->ID)->where('deleted',0)->get();
		return response()->json($var);
	}
	public function validateServiceContact(Request $req){
		$var = DB::table('services_contact')->where('services_contact_name',$req->value)->where('deleted',0)->get();
		return response()->json($var);
	}
	public function validateEditServiceContact(Request $req){
		$var = DB::table('services_contact')->where('services_contact_id',"<>",$req->id)->where('services_contact_name',$req->dup)->where('deleted',0)->get();
		return response()->json($var);
	}


	public function Staff(){
		$emp = DB::table('staff')->join('staff_profession', 'staff.staff_profession_id', '=', 'staff_profession.staff_profession_id')->where('staff.deleted',0)->orderby('staff.staff_fname')->get();
		$prof = DB::table('staff_profession as sp')->leftjoin('staff as s','sp.staff_profession_id','=','s.staff_profession_id')->select(DB::raw('count(case when s.deleted = 0 then 1 else null end) as subcount, sp.staff_profession_id,sp.staff_profession_description'))->groupBy('staff_profession_id','staff_profession_description')->where('sp.deleted','=',0)->orderby('staff_profession_description')->get();
		return view('maintenance.staff',['employee' => $emp,'prof' => $prof]);
	}
	public function retrieveStaff(Request $req){
		$var = DB::table('staff')->join('staff_profession', 'staff.staff_profession_id', '=', 'staff_profession.staff_profession_id')->where('staff.staff_id',$req->ID)->where('staff.deleted',0)->get();
		return response()->json($var);
	}
	public function retrieveProfession(Request $req){
		$var = DB::table('staff_profession')->where('staff_profession_id',$req->ID)->where('deleted',0)->get();
		return response()->json($var);
	}
	public function validateProfession(Request $req){
		$var = DB::table('staff_profession')->where('staff_profession_description',$req->value)->where('deleted',0)->get();
		return response()->json($var);
	}

	public function Location(){
		$query = DB::table('location');
		if (isset($_GET['name']) && !empty($_GET['name'])) {
			$query->where('location_name','like','%'.$_GET['name'].'%');
		}
		if (isset($_GET['owner']) && !empty($_GET['owner'])) {
			$query->where('location_owner','like','%'.$_GET['owner'].'%');
		}
		if (isset($_GET['cap']) && !empty($_GET['cap'])) {
			$query->where('location_max','>=',$_GET['cap']);
		}
		if (isset($_GET['min']) && !empty($_GET['min'])) {
			$query->where('location_rate','>=',$_GET['min']);
		}
		if (isset($_GET['max']) && !empty($_GET['max'])) {
			$query->where('location_max','<=',$_GET['max']);
		}
		if (isset($_GET['location']) && !empty($_GET['location'])) {
			$query->orwhere('street','like',$_GET['location'].'%');
		}
		$Location = $query->where('deleted',0)->orderby('location_name')->get();
		return view('maintenance.location',['location' => $Location]);
	}
	public function retrieveLocation(Request $req){
		$var = DB::table('location')->where('location_id',$req->ID)->where('deleted',0)->get();
		return response()->json($var);
	}
	public function validateLocation(Request $req){
		$var = Location::where('location_name',$req->value)->where('deleted',0)->get();
		return response()->json($var);
	}


}

