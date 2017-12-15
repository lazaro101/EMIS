<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator; 
use Auth;
use PDF;

class Transaction extends Controller
{
    	
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkgen');
        parent::__construct();
    }

    public function getEventNow(Request $req){
    	$var = DB::table('event_reservation as er')->join('event_details as ed','ed.event_id','=','er.event_id')->whereDate('ed.event_date',date_create($req->date)->format("Y-m-d"))->where('er.deleted',0)->count();
    	return response()->json($var);
    }
	public function getCategory(){
		$category = DB::table('submenu_category')->where('deleted','=',0)->orderby('submenu_category_name')->get();
		return response()->json($category);
	}
	public function getService(){
		$var = DB::table('services')->where('deleted','=',0)->orderby('services_name')->get();
		return response()->json($var);
	}
	public function getStaff(Request $req){
		$date = date_format(date_create($req->date),"Y-m-d");
		$var = DB::table('staff as s')->join('staff_profession as sp','s.staff_profession_id','=','sp.staff_profession_id')->where('s.deleted','=',0)->leftjoin('staff_catering as sc','sc.staff_id','=','s.staff_id')->leftjoin('catering_staff as cs','cs.catering_staff_id','=','sc.catering_staff_id')->leftjoin('event_reservation as er','er.event_reservation_id','=','cs.event_reservation_id')->leftjoin('event_details as ed','ed.event_id','=','er.event_id')->groupBy('s.staff_id','sp.staff_profession_description','s.staff_fname','s.staff_lname')->select('s.staff_id','sp.staff_profession_description','s.staff_fname','s.staff_lname',DB::raw('count(case when ed.event_date = "'.$date.'" then 1 else null end) as cnt'))->orderBy('s.staff_lname')->get();
		return response()->json($var);
	}
	public function getEquipments(){
		$var = DB::table('equipment_inventory as ei')->join('equipment_type as et','et.equipment_type_id','=','ei.equipment_type_id')->where('ei.deleted',0)->get();
		return response()->json($var);
	}
	public function getServiceContact(Request $req){
		if ($req->srch != "") {
			$var = DB::table('services_contact')->where('services_contact_name','LIKE',$req->srch.'%')->where('deleted','=',0)->orderby('services_contact_name')->get();	
		} elseif($req->id == "") {	
			$var = DB::table('services_contact')->where('deleted','=',0)->orderby('services_contact_name')->get();
		} else {
			$var = DB::table('services_contact')->where('services_id',$req->id)->where('deleted','=',0)->orderby('services_contact_name')->get();
		}
		return response()->json($var);
	}
	public function getPackage(){
		$package = DB::table('package')->where('deleted',0)->where('package_status',0)->orderby('package_name')->get();
		return response()->json($package);
	}
	public function getFood(Request $req){
		// $var = $req->ctgry_id;
		$var = DB::table('submenu')->where('submenu_category_id',$req->ctgry_id)->where('deleted',0)->where('submenu_status',0)->get();
		return response()->json($var);
	}
	public function getPackageFood(Request $req){
		$var1 = DB::table('package_choice')->where('package_id',$req->ID)->orderby('submenu_category_id')->get();
		return response()->json($var1);
	}
	public function getMenuCatering(Request $req){
		$pkg = DB::table('package')->where('package_id',$req->pkgid)->first();
		$mfc = DB::table('submenu as s')->join('submenu_category as sc','s.submenu_category_id','=','sc.submenu_category_id')->whereIn('s.submenu_id',$req->mf)->get();
		if ($req->af != "") {
			$afc = DB::table('submenu as s')->join('submenu_category as sc','s.submenu_category_id','=','sc.submenu_category_id')->whereIn('s.submenu_id',$req->af)->get();
		} else {
			$afc = "";
		}
		return response()->json([$pkg,$mfc,$afc]);
	}
	public function getServicesCatering(Request $req){
		$var1 = DB::table('services_catering')->join('services_contact','services_contact.services_contact_id','=','services_catering.services_contact_id')->where('catering_services_id',$req->ID)->orderby('services_id')->get();
		return response()->json($var1);
	}
	public function getInventoryCatering(Request $req){
		$var1 = DB::table('inventory_catering')->join('equipment_inventory','equipment_inventory.equipment_inventory_id','=','inventory_catering.inventory_id')->where('catering_inventory_id',$req->ID)->get();
		return response()->json($var1);
	}
	public function getTask(Request $req){
		$var1 = DB::table('reminder')->where('reminder_id',$req->ID)->get();
		return response()->json($var1);
	}
	public function getExtraCost(Request $req){
		$var1 = DB::table('extra_cost')->where('extra_cost_id',$req->ID)->get();
		return response()->json($var1);
	}
	public function getPayment(Request $req){
		$var1 = DB::table('payment as p')->join('payment_details as pd','pd.payment_details_id','=','p.payment_id')->where('p.payment_id',$req->id)->first();
		return response()->json($var1);
	}

	public function Events(){
		return view('transaction.events');
	}
	public function EventInquiries(){
		$query = DB::table('event_inquiry')->join('client_details','event_inquiry.client_id','=','client_details.client_id')->join('event_details','event_inquiry.event_id','=','event_details.event_id');
		if (isset($_GET['date']) && $_GET['date'] != "") {
			$query->where('event_inquiry_date','LIKE',date_create($_GET['date'])->format("Y-m-d").'%');
		}
		if (isset($_GET['status']) && $_GET['status'] != "" && $_GET['status'] != "All") {
			$query->where('status','=',$_GET['status']);
		}
		if (isset($_GET['name']) && $_GET['name'] != "") {
			$query->where('client_details.client_fname','like','%'.$_GET['name'].'%');
		}
		if (isset($_GET['eventdate']) && $_GET['eventdate'] != "") {
			$query->where('event_details.event_date','=',date_format(date_create($_GET['eventdate']),"Y-m-d"));
		}
		if (isset($_GET['occassion']) && $_GET['occassion'] != "") {
			$query->where('event_details.event_occassion','like','%'.$_GET['occassion'].'%');
		}
		if (isset($_GET['location']) && $_GET['location'] != "") {
			$query->where('event_details.event_location','like','%'.$_GET['location'].'%');
		}

		$inquiry = $query->where('event_inquiry.deleted','=',0)->orderby('event_inquiry_date')->get();
		return view('transaction.eventinquiries',['inquiry' => $inquiry]);
	}
	public function editInquiry(Request $req, Validator $validator){
		DB::table('event_inquiry')->where('event_inquiry_id',$_POST['id'])->update(['status'=>$_POST['status']]);
		if ($_POST['status'] == 'Approved') {
			return redirect('/Admin/Transaction/Event-Reservation?eventdetails=new&id='.$_POST['id']);
		} else {
			return redirect('/Admin/Transaction/Event-Inquiries');
		}
	}
	public function deleteInquiry(){
		DB::table('event_inquiry')->where('event_inquiry_id',$_POST['id'])->update([ 'deleted' => 1]);
		return redirect('/Admin/Transaction/Event-Inquiries');
	}

	public function EventReservation(){
		if (isset($_GET['eventdetails']) && $_GET['eventdetails'] == 'new') {
			if (isset($_GET['id'])) {
				$event = DB::table('event_inquiry')->join('client_details','client_details.client_id','=','event_inquiry.client_id')->join('event_details','event_details.event_id','=','event_inquiry.event_id')->where('event_inquiry_id',$_GET['id'])->first();
			} else {
				$event = "";
			}
			DB::table('catering_services')->where('event_reservation_id',NULL)->delete();
			$package = DB::table('package')->where('package_status',0)->where('deleted',0)->get();
			$stype = DB::table('services')->where('deleted',0)->get();
			$location = DB::table('location')->where('deleted',0)->get();
			return view('transaction.addreservation',['package' => $package, 'stype' => $stype, 'location' => $location, 'event' => $event]);
		} elseif (isset($_GET['eventdetails']) && $_GET['eventdetails'] == 'edit') {
			$package = DB::table('package')->where('package_status',0)->where('deleted',0)->get();
			$stype = DB::table('services')->where('deleted',0)->get();
			$location = DB::table('location')->where('deleted',0)->get();
			$rsrvtn = DB::table('event_reservation as er')->where('er.event_reservation_id',$_GET['id'])->join('client_details as cd','cd.client_id','=','er.client_id')->join('event_details as ed','ed.event_id','=','er.event_id')->join('reservation_logs as rl','rl.reservation_logs_id','=','er.reservation_logs_id')->join('catering_menu as cm','cm.event_reservation_id','=','er.event_reservation_id')->leftjoin('package as p','p.package_id','=','cm.package_id')->join('catering_services as cs','cs.event_reservation_id','=','er.event_reservation_id')->join('catering_staff as cst','cst.event_reservation_id','=','er.event_reservation_id')->join('catering_checklist as cc','cc.event_reservation_id','=','er.event_reservation_id')->join('payment','payment.payment_id','=','er.payment_id')->join('payment_details as pd','pd.payment_details_id','=','payment.payment_details_id')->first();

			$menu = DB::table('menu_catering as mc')->where('mc.catering_menu_id',$rsrvtn->catering_menu_id)->join('submenu as s','s.submenu_id','=','mc.submenu_id')->join('submenu_category as sc','sc.submenu_category_id','=','s.submenu_category_id')->get();
			$addons = DB::table('addons_food as af')->where('af.catering_menu_id',$rsrvtn->catering_menu_id)->join('submenu as s','s.submenu_id','=','af.submenu_id')->join('submenu_category as sc','sc.submenu_category_id','=','s.submenu_category_id')->get();
			$services = DB::table('services_catering as sca')->where('sca.catering_services_id',$rsrvtn->catering_services_id)->join('services_contact as sc','sc.services_contact_id','=','sca.services_contact_id')->get();
			$checklist = DB::table('checklist_catering as cc')->where('cc.catering_checklist_id',$rsrvtn->catering_checklist_id)->join('equipment_inventory as ei','ei.equipment_inventory_id','=','cc.equipment_inventory_id')->get();
			$staff = DB::table('staff_catering as sc')->where('sc.catering_staff_id',$rsrvtn->catering_staff_id)->join('staff as s','s.staff_id','=','sc.staff_id')->join('staff_profession as sp','sp.staff_profession_id','=','s.staff_profession_id')->get();
			$extra = DB::table('extra_cost')->where('event_reservation_id',$_GET['id'])->get();
			$task = DB::table('reminder')->where('event_reservation_id',$_GET['id'])->get();

			return view('transaction.editreservation',['rsrvtn' => $rsrvtn, 'location' => $location,'package' => $package, 'stype' => $stype,'menu' => $menu, 'addons' => $addons,'services' => $services, 'staff' => $staff, 'checklist' => $checklist, 'extra' => $extra, 'task' => $task]);
		} elseif((isset($_GET['eventdetails']) && $_GET['eventdetails'] == 'eventpdf')){
			$general = DB::table('settings_general')->orderBy('settings_general_id','DESC')->get();

			$package = DB::table('package')->where('package_status',0)->where('deleted',0)->get();
			$stype = DB::table('services')->where('deleted',0)->get();
			$location = DB::table('location')->where('deleted',0)->get();
			$rsrvtn = DB::table('event_reservation as er')->where('er.event_reservation_id',$_GET['id'])->join('client_details as cd','cd.client_id','=','er.client_id')->join('event_details as ed','ed.event_id','=','er.event_id')->join('reservation_logs as rl','rl.reservation_logs_id','=','er.reservation_logs_id')->join('catering_menu as cm','cm.event_reservation_id','=','er.event_reservation_id')->leftjoin('package as p','p.package_id','=','cm.package_id')->join('catering_services as cs','cs.event_reservation_id','=','er.event_reservation_id')->join('catering_staff as cst','cst.event_reservation_id','=','er.event_reservation_id')->join('catering_checklist as cc','cc.event_reservation_id','=','er.event_reservation_id')->join('payment','payment.payment_id','=','er.payment_id')->join('payment_details as pd','pd.payment_details_id','=','payment.payment_details_id')->first();

			$menu = DB::table('menu_catering as mc')->where('mc.catering_menu_id',$rsrvtn->catering_menu_id)->join('submenu as s','s.submenu_id','=','mc.submenu_id')->join('submenu_category as sc','sc.submenu_category_id','=','s.submenu_category_id')->get();
			$addons = DB::table('addons_food as af')->where('af.catering_menu_id',$rsrvtn->catering_menu_id)->join('submenu as s','s.submenu_id','=','af.submenu_id')->join('submenu_category as sc','sc.submenu_category_id','=','s.submenu_category_id')->get();
			$services = DB::table('services_catering as sca')->where('sca.catering_services_id',$rsrvtn->catering_services_id)->join('services_contact as sc','sc.services_contact_id','=','sca.services_contact_id')->get();
			$checklist = DB::table('checklist_catering as cc')->where('cc.catering_checklist_id',$rsrvtn->catering_checklist_id)->join('equipment_inventory as ei','ei.equipment_inventory_id','=','cc.equipment_inventory_id')->get();
			$staff = DB::table('staff_catering as sc')->where('sc.catering_staff_id',$rsrvtn->catering_staff_id)->join('staff as s','s.staff_id','=','sc.staff_id')->join('staff_profession as sp','sp.staff_profession_id','=','s.staff_profession_id')->get();
			$extra = DB::table('extra_cost')->where('event_reservation_id',$_GET['id'])->get();
			$task = DB::table('reminder')->where('event_reservation_id',$_GET['id'])->get();
			
	        view()->share('general',$general);
			$pdf = PDF::loadView('pdf.event', ['rsrvtn' => $rsrvtn, 'location' => $location,'package' => $package, 'stype' => $stype,'menu' => $menu, 'addons' => $addons,'services' => $services, 'staff' => $staff, 'checklist' => $checklist, 'extra' => $extra, 'task' => $task]);
			// return $pdf->download('invoice.pdf');
			return $pdf->stream("Event_060697_4.pdf");
		} else {
			$query = DB::table('event_reservation')->join('event_details','event_details.event_id','=','event_reservation.event_id');
			if (isset($_GET['date']) && $_GET['date'] != "") {
				$query->where('event_details.event_date',date_create($_GET['date'])->format('Y-m-d'));
			}
			if (isset($_GET['status']) && $_GET['status'] != "" && $_GET['status'] != "All") {
				$query->where('event_reservation.status',$_GET['status']);
			}
			if (isset($_GET['name']) && $_GET['name'] != "") {
				$query->where('event_details.event_name','like','%'.$_GET['name'].'%');
			}
			$events = $query->where('event_reservation.deleted',0)->orderby('event_date','DESC')->get();
			return view('transaction.eventreservation',['events' => $events]);
		}
		return redirect('/Admin/Dashboard');
	}
	public function getEvents(){
		$events = DB::table('event_reservation')->join('event_details','event_details.event_id','=','event_reservation.event_id')->orderby('event_date')->where('event_reservation.deleted',0)->get();
		return response()->json($events);
	}
	public function addReservation($new = null){
		if (isset($new)) {
			$event = DB::table('event_inquiry')->join('client_details','client_details.client_id','=','event_inquiry.client_id')->join('event_details','event_details.event_id','=','event_inquiry.event_id')->where('event_inquiry_id',$new)->get();
			return view('transaction.addreservation',['event' => $event]);
		}
		return view('transaction.addreservation');
	}

	public function FoodOrder(){
		if (isset($_GET['orderdetails']) && $_GET['orderdetails'] == 'new') {
			$menu = DB::table('submenu')->join('submenu_category', 'submenu.submenu_category_id', '=', 'submenu_category.submenu_category_id')->where('submenu.deleted',0)->orderby('submenu_name')->get();
			return view('transaction.addfoodorder',['menu' => $menu]);
		} elseif(isset($_GET['orderdetails']) && $_GET['orderdetails'] == 'edit') {
			$fo = DB::table('food_order as fo')->join('client_details as cd','cd.client_id','=','fo.fo_client_id')->where('fo.food_order_id',$_GET['id'])->get();
			$fom = DB::table('food_order_menu as fom')->join('submenu as s','s.submenu_id','=','fom.submenu_id')->where('fom.food_order_id',$_GET['id'])->get();
			$menu = DB::table('submenu')->join('submenu_category', 'submenu.submenu_category_id', '=', 'submenu_category.submenu_category_id')->where('submenu.deleted',0)->orderby('submenu_name')->get();

			return view('transaction.editfoodorder',['fo' => $fo ,'fom' => $fom ,'menu' => $menu]);
		} else {
			$tbldata = DB::table('food_order as fo')->join('client_details as cd','cd.client_id','=','fo.fo_client_id')->where('fo.deleted',0)->get();
			return view('transaction.foodorder',['tbldata' => $tbldata]);				
		}
	}
	public function Payments(){
		$pmt = DB::table('payment as p')->join('event_reservation as er','er.payment_id','=','p.payment_id')->join('client_details as c','c.client_id','=','er.client_id')->where('p.deleted',0)->join('event_details as ed','ed.event_id','=','er.event_id')->get();
		return view('transaction.payments',['pmt' => $pmt]);
	}
}
