<?php

namespace app\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests;

use DB;
use Validator;
use Auth;
use Response;
use PDF;

class FormTrans extends Controller
{
    	
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkgen');
        parent::__construct();
    }

	public function addReservation(Request $req, Validator $validator){
		$clientid = DB::table('client_details')->insertGetId([
			'client_fname' => $_POST['fname'],
			'client_lname' => $_POST['lname'],
			'client_contact1' => $_POST['cpnum1'],
			'client_contact2' => $_POST['cpnum2'],
			'client_telephone1' => $_POST['telnum1'],
			'client_telephone2' => $_POST['telnum2'],
			'client_email' => $_POST['email'],
		]);
		$eventid = DB::table('event_details')->insertGetId([
			'event_name' => $_POST['eventname'],
			'event_date' => date_format(date_create($_POST['eventdate']),"Y-m-d"),
			'event_time' => date_create($_POST['eventtime'])->format('H:i:s'),
			'event_setup' => date_create($_POST['setuptime'])->format('H:i:s'),
			'event_end' => date_create($_POST['endtime'])->format('H:i:s'),
			'event_occassion' => $_POST['occassion'],
			'event_motif' => $_POST['motif'],
			'event_guest_count' => $_POST['guestcount'],
			'event_setup_notes' => $_POST['eventnotes'],
		]);
		if (isset($_POST['loctype'])) {
			DB::table('event_details')->where('event_id',$eventid)->update([
				'event_loctype' => $_POST['loctype'],
				'event_location' => $_POST['location'],
				'event_hrs' => $_POST['hrs']
			]);
			$locprice = DB::table('location')->where('location_id',$_POST['location'])->first();
			$loctot = $locprice->location_rate * $_POST['hrs'];
		} else {
			DB::table('event_details')->where('event_id',$eventid)->update([
				'event_loctype' => 0,
				'event_address' => $_POST['venue']
			]);
		}
		$logsid = DB::table('reservation_logs')->insertGetId([
			'created_by' => Auth::user()->username,
			'created_at' => date_create('now'),
			'updated_by' => Auth::user()->username,
			'updated_at' => date_create('now'),
		]);
		$reservationid = DB::table('event_reservation')->insertGetId([
			'client_id' => $clientid ,
			'event_id' => $eventid ,
			'reservation_logs_id' => $logsid,
		]);
		if (isset($_POST['pkgid'])) {
			$pkg = DB::table('package')->where('package_id',$_POST['pkgid'])->first();
			$pkgtotal = $pkg->package_price*$_POST['guestcount'];
		}
		$aototal = 0;
		$sertot = 0;
		$exttot = 0;

		$cmid = DB::table('catering_menu')->insertGetId([
			'event_reservation_id' => $reservationid,
			'package_id' => $_POST['pkgid']
		]);
		if (isset($_POST['menu'])) {
			foreach ($_POST['menu'] as $menu) {
				DB::table('menu_catering')->insert([ 
					'catering_menu_id' => $cmid,
					'submenu_id' => $menu
				]);
			}
		}
		if (isset($_POST['addons'])) {
			foreach ($_POST['addons'] as $addons) {
				DB::table('addons_food')->insert([ 
					'catering_menu_id' => $cmid,
					'submenu_id' => $addons
				]);
				$var = DB::table('submenu')->where('submenu_id',$addons)->first();
				$aototal += $var->submenu_price*$_POST['guestcount']; 
			}
		}
		$csid = DB::table('catering_services')->insertGetId([
			'event_reservation_id' => $reservationid,
		]);
		if (isset($_POST['serviceContact'])) {
			for ($x=0; $x < count($req->serviceContact) ; $x++) { 
				DB::table('services_catering')->insert([ 
					'catering_services_id' => $csid,
					'services_contact_id' => $req->serviceContact[$x],
					'total' => $req->sctot[$x]
				]);
				$sertot += $req->sctot[$x]; 
			}
		}
		$cstid = DB::table('catering_staff')->insertGetId([
			'event_reservation_id' => $reservationid,
		]);
		if (isset($_POST['staff'])) {
			foreach ($_POST['staff'] as $staff) {
				DB::table('staff_catering')->insert([ 
					'catering_staff_id' => $cstid,
					'staff_id' => $staff
				]);
			}
		}
		$ccid = DB::table('catering_checklist')->insertGetId([
			'event_reservation_id' => $reservationid,
		]);
		if (isset($_POST['eqid'])) {
			$eqid = $req->eqid;
			$qty = $req->qty;
			for ($x = 0; $x < count($eqid); $x++) {
				DB::table('checklist_catering')->insert([
					'catering_checklist_id' => $ccid,
					'equipment_inventory_id' => $eqid[$x],
					'quantity' => $qty[$x]
				]);
			}
			DB::table('catering_checklist')->where('catering_checklist_id',$ccid)->update([ 'checklist_status' => 'Unchecked' ]);
		}
		if (isset($_POST['extraCost'])) {
			foreach ($_POST['extraCost'] as $ec) {
				DB::table('extra_cost')->where('extra_cost_id',$ec)->update([
					'event_reservation_id' => $reservationid 
				]);
				$cost = DB::table('extra_cost')->where('extra_cost_id',$ec)->first();  
				$exttot += $cost->total; 
			}
		}
		if (isset($_POST['reminder'])) {
			foreach ($_POST['reminder'] as $task) {
				DB::table('reminder')->where('reminder_id',$task)->update([
					'event_reservation_id' => $reservationid
				]);
			}
		}
		$pdetid = DB::table('payment_details')->insertGetId([
			'menu_total' => $pkgtotal,
			'addons_total' => $aototal,
			'services_total' => $sertot,
			'extra_cost_total' => $exttot
		]);
		$pid = DB::table('payment')->insertGetId([
			'payment_details_id' => $pdetid,
			'grand_total' => $pkgtotal + $aototal + $sertot + $exttot,
			'payment_status' => 'Pending'
		]);
		DB::table('event_reservation')->where('event_reservation_id',$reservationid)->update([
			'payment_id' => $pid
		]);
		return redirect('/Admin/Transaction/Event-Reservation');
	}
	public function editReservation(Request $req, Validator $validator){
		$aototal = 0;
		$sertot = 0;
		$exttot = 0;
		$loctot = 0;
		$evres = DB::table('event_reservation')->where('event_reservation_id',$_POST['eventrsrvtnid'])->first();
		DB::table('event_reservation')->where('event_reservation_id',$_POST['eventrsrvtnid'])->update([
			'status' => $_POST['status']
		]);
		DB::table('client_details')->where('client_id',$evres->client_id)->update([
			'client_fname' => $_POST['fname'],
			'client_lname' => $_POST['lname'],
			'client_contact1' => $_POST['cpnum1'],
			'client_contact2' => $_POST['cpnum2'],
			'client_telephone1' => $_POST['telnum1'],
			'client_telephone2' => $_POST['telnum2'],
			'client_email' => $_POST['email'],
		]);
		DB::table('event_details')->where('event_id',$evres->event_id)->update([
			'event_name' => $_POST['eventname'],
			'event_date' => date_format(date_create($_POST['eventdate']),"Y-m-d"),
			'event_time' => date_create($_POST['eventtime'])->format('H:i:s'),
			'event_setup' => date_create($_POST['setuptime'])->format('H:i:s'),
			'event_end' => date_create($_POST['endtime'])->format('H:i:s'),
			'event_occassion' => $_POST['occassion'],
			'event_motif' => $_POST['motif'],
			'event_guest_count' => $_POST['guestcount'],
			'event_setup_notes' => $_POST['eventnotes'],
		]);
		if (isset($_POST['loctype'])) {
			DB::table('event_details')->where('event_id',$evres->event_id)->update([
				'event_loctype' => $_POST['loctype'],
				'event_location' => $_POST['location'],
				'event_hrs' => $_POST['hrs']
			]);
			$locprice = DB::table('location')->where('location_id',$_POST['location'])->first();
			$loctot = $locprice->location_rate * $_POST['hrs'];
		} else {
			DB::table('event_details')->where('event_id',$evres->event_id)->update([
				'event_loctype' => 0,
				'event_address' => $_POST['venue']
			]);
		}
		DB::table('reservation_logs')->where('reservation_logs_id',$evres->reservation_logs_id)->update([
			'updated_by' => Auth::user()->username,
			'updated_at' => date_create('now'),
		]);
		$pkg = DB::table('package')->where('package_id',$_POST['pkgid'])->first();
		$pkgtotal = $pkg->package_price*$_POST['guestcount'];

		DB::table('catering_menu')->where('catering_menu_id',$_POST['cmid'])->update([
			'package_id' => $_POST['pkgid']
		]);
		if (isset($_POST['menu'])) {
			DB::table('menu_catering')->where('catering_menu_id',$_POST['cmid'])->delete();
			foreach ($_POST['menu'] as $menu) {
				DB::table('menu_catering')->insert([ 
					'catering_menu_id' => $_POST['cmid'],
					'submenu_id' => $menu
				]);
			}
		}
		DB::table('addons_food')->where('catering_menu_id',$_POST['cmid'])->delete();
		if (isset($_POST['addons'])) {
			foreach ($_POST['addons'] as $addons) {
				DB::table('addons_food')->insert([ 
					'catering_menu_id' => $_POST['cmid'],
					'submenu_id' => $addons
				]);
				$var = DB::table('submenu')->where('submenu_id',$addons)->first();
				$aototal += $var->submenu_price*$_POST['guestcount']; 
			}
		}
			DB::table('services_catering')->where('catering_services_id',$_POST['csid'])->delete();
		if (isset($_POST['serviceContact'])) {
			for ($x=0; $x < count($req->serviceContact) ; $x++) { 
				DB::table('services_catering')->insert([ 
					'catering_services_id' => $_POST['csid'],
					'services_contact_id' => $req->serviceContact[$x],
					'total' => $req->sctot[$x]
				]);
				// $ser = DB::table('services_contact')->where('services_contact_id',$req->serviceContact[$x])->first();  
				$sertot += $req->sctot[$x]; 
			}
		}
			DB::table('staff_catering')->where('catering_staff_id',$_POST['cstid'])->delete();
		if (isset($_POST['staff'])) {
			foreach ($_POST['staff'] as $staff) {
				DB::table('staff_catering')->insert([ 
					'catering_staff_id' => $_POST['cstid'],
					'staff_id' => $staff
				]);
			}
		}
		// 	DB::table('checklist_catering')->where('catering_checklist_id',$_POST['ccid'])->delete();
		// if (isset($_POST['eqid'])) {
		// 	$eqid = $req->eqid;
		// 	$qty = $req->qty;
		// 	for ($x = 0; $x < count($eqid); $x++) {
		// 		DB::table('checklist_catering')->insert([
		// 			'catering_checklist_id' => $_POST['ccid'],
		// 			'equipment_inventory_id' => $eqid[$x],
		// 			'quantity' => $qty[$x]
		// 		]);
		// 	}
		// 	DB::table('catering_checklist')->where('catering_checklist_id',$_POST['ccid'])->update([ 'checklist_status' => 'Unchecked']);
		// }
		if (isset($_POST['extraCost'])) {
			foreach ($_POST['extraCost'] as $ec) {
				DB::table('extra_cost')->where('extra_cost_id',$ec)->update([
					'event_reservation_id' => $_POST['eventrsrvtnid']
				]);
			}
		}
		$ext = DB::table('extra_cost')->where('event_reservation_id',$_POST['eventrsrvtnid'])->where('deleted',0)->get();
		foreach($ext as $ext){
			$exttot += $ext->total;
		}
		if (isset($_POST['reminder'])) {
			foreach ($_POST['reminder'] as $task) {
				DB::table('reminder')->where('reminder_id',$task)->update([
					'event_reservation_id' => $_POST['eventrsrvtnid']
				]);
			}
		}
		DB::table('payment')->where('payment_id',$evres->payment_id)->update([
			'grand_total' => $pkgtotal + $aototal + $sertot + $exttot + $loctot,
		]);
		$pay = DB::table('payment')->where('payment_id',$evres->payment_id)->first();
		DB::table('payment_details')->where('payment_details_id',$pay->payment_details_id)->update([
			'menu_total' => $pkgtotal,
			'addons_total' => $aototal,
			'services_total' => $sertot,
			'extra_cost_total' => $exttot,
			'location_total' => $loctot
		]);
		return redirect('/Admin/Transaction/Event-Reservation');
	}
	public function deleteReservation(Request $req){
		DB::table('event_reservation as er')->where('er.event_reservation_id',$req->id)->join('payment as p','p.payment_id','=','er.payment_id')->update([ 'er.deleted' => 1, 'p.deleted' => 1 ]);
		return redirect('/Admin/Transaction/Event-Reservation');
	}
	public function cancelReservation(){
		DB::table('event_reservation')->where('event_reservation_id',$_GET['id'])->update(['status' => 'Cancelled']);

		// DB::table('reservation_logs')->where('reservation_logs_id',$_GET['log'])->update([
		// 	'updated_by' => Auth::user()->username,
		// 	'updated_at' => date_create('now'),
		// ]);
		return redirect('/Admin/Transaction/Event-Reservation');
	}
	public function saveCateringMenu(Request $req){
		$pkg = DB::table('package')->where('package_id',$req->pkgid)->first();
		$mfc = DB::table('submenu as s')->join('submenu_category as sc','s.submenu_category_id','=','sc.submenu_category_id')->whereIn('s.submenu_id',$req->mf)->get();
		if ($req->af != "") {
			$afc = DB::table('submenu as s')->join('submenu_category as sc','s.submenu_category_id','=','sc.submenu_category_id')->whereIn('s.submenu_id',$req->af)->get();
		} else {
			$afc = "";
		}
		return response()->json([$pkg,$mfc,$afc]);
	}

	public function saveCateringServices(Request $req){
		DB::table('services_catering')->where('catering_services_id',$req->csid)->delete();
		foreach ($req->sc as $services) {
			DB::table('services_catering')->insert([
				'catering_services_id' => $req->csid,
				'services_contact_id' => $services,
			]);
		}
		$cs = DB::table('services_catering as sc')->join('services_contact as scon','scon.services_contact_id','=','sc.services_contact_id')->where('sc.catering_services_id',$req->csid)->get();
		return response()->json($cs);
	}
	public function removeService(Request $req){
		DB::table('services_catering')->where('catering_services_id',$req->csid)->where('services_contact_id',$req->scid)->delete();
		// $srvc = DB::table('services_contact')->where('services_contact_id',$req->scid)->first();
		// DB::table('catering_services')->where('catering_services_id',$req->csid)->decrement('services_total',$srvc->services_contact_price);
		return response()->json();
	}

	public function saveCateringStaff(Request $req){
		DB::table('staff_catering')->where('catering_staff_id',$req->cstid)->delete();
		foreach ($req->stc as $staff) {
			DB::table('services_catering')->insert([
				'catering_services_id' => $req->cstid,
				'services_contact_id' => $staff,
			]);
		}
		$cst = DB::table('staff_catering as sc')->join('staff as st','st.staff_id','=','sc.staff_id')->where('sc.catering_staff_id',$req->cstid)->get();
		return response()->json($cst);
	}
	public function addCateringInventory($id,$log){
		$cd = DB::table('catering_details as cd')->join('event_reservation as er','er.catering_details_id','=','cd.catering_details_id')->where('er.event_reservation_id',$id)->get();
		foreach ($cd as $cd) {
			$cdid = $cd->catering_details_id;
			$ciid = $cd->catering_inventory_id;
		}
		DB::table('inventory_catering')->where('catering_inventory_id',$ciid)->delete();
		$inv = $_POST['Inventory'];
		$eq = $_POST['QTY'];
		$euq = $_POST['EU'];
		$erq = $_POST['ER'];
		for ($x = 0; $x < count($_POST['Inventory']) ; $x++) {
			DB::table('inventory_catering')->insert([
				'catering_inventory_id' => $ciid,
				'inventory_id' => $inv[$x] ,
				'equipment_qty' => $eq[$x] ,
				'equipment_used_qty' => $euq[$x] ,
				'equipment_return_qty' => $erq[$x] ,
			]);
			// echo $_POST['QTY'][2];
		}
		return redirect('/Admin/Transaction/Event-Reservation?eventdetails=edit&id='.$id);
	}
	public function addExtraCost(Request $req){
		if ($req->comment == null) {
			$comment = "None";
		} else {
			$comment = $req->comment;
		}
		$ecid = DB::table('extra_cost')->insertGetId([
			'cost_type' => $req->type,
			'amount' => $req->amount,
			'comments' => $comment,
		]);
		if ($req->type == "Flat Cost") {
			DB::table('extra_cost')->where('extra_cost_id',$ecid)->update([
				'total' => $req->amount,
			]);
			$total = $req->amount;
		} else {
			DB::table('extra_cost')->where('extra_cost_id',$ecid)->update([
				'guest_count' => $req->count,
				'total' =>$req->amount * $req->count,
			]);
			$total = $req->amount * $req->count;
		}
		$extra = DB::table('extra_cost')->where('extra_cost_id',$ecid)->first();
		return response()->json($extra);
	}
	public function editExtraCost(Request $req){
		DB::table('extra_cost')->where('extra_cost_id',$req->ecid)->update([
			'cost_type' => $req->type,
			'amount' => $req->amount,
			'comments' => $req->comment,
		]);
		if ($req->type == "Flat Cost") {
			DB::table('extra_cost')->where('extra_cost_id',$req->ecid)->update([
				'total' => $req->amount,
			]);
			$total = $req->amount;
		} else {
			DB::table('extra_cost')->where('extra_cost_id',$req->ecid)->update([
				'guest_count' => $req->count,
				'total' =>$req->amount * $req->count,
			]);
			$total = $req->amount * $req->count;
		}
		$extra = DB::table('extra_cost')->where('extra_cost_id',$req->ecid)->first();
		// $extra = $req->amount;
		return response()->json($extra);
	}
	public function deleteExtra(Request $req){
		DB::table('extra_cost')->where('extra_cost_id',$req->ecid)->delete();
		return response()->json();
	}
	public function addTask(Request $req){
		$rid = DB::table('reminder')->insertGetId([
			'description' => $req->desc,
			'date' =>  date_create($req->date)->format('Y-m-d'),
			'time' => date_create($req->time)->format('H:i:s'),
		]);
		$var = DB::table('reminder')->where('reminder_id',$rid)->first();
		return response()->json($var);
	}
	public function editTask(Request $req){
		DB::table('reminder')->where('reminder_id',$req->id)->update([
			'description' => $req->desc,
			'date' =>  date_create($req->date)->format('Y-m-d'),
			'time' => date_create($req->time)->format('H:i:s'),
		]);
		$var = DB::table('reminder')->where('reminder_id',$req->id)->first();
		return response()->json($var);
	}
	public function deleteTask(Request $req){
		DB::table('reminder')->where('reminder_id',$req->rid)->delete();
		return response()->json();
	}
	public function removeStaff(Request $req){
		DB::table('staff_catering')->where('catering_staff_id',$req->csid)->where('staff_id',$req->sid)->delete();
		return response()->json();
	}

	//--------------------------------------------------------------------------------------------
	public function addFoodOrder(){
		$clientid = DB::table('client_details')->insertGetId([
			'client_fname' => $_POST['fname'],
			'client_lname' => $_POST['lname'],
			'client_contact1' => $_POST['cpnum1'],
			'client_contact2' => $_POST['cpnum2'],
			'client_telephone1' => $_POST['telnum1'],
			'client_telephone2' => $_POST['telnum2'],
			'client_email' => $_POST['email'],
		]);
		$foid = DB::table('food_order')->insertGetId([ 
			'fo_client_id' => $clientid,
			'food_order_date' => date_format(date_create($_POST['date']),"Y-m-d") ,  
			'food_order_time' => date_format(date_create($_POST['time']),"H:i:s") ,  
			'food_order_address' => $_POST['address'] ,  
			'status' => $_POST['status'] ,  
		]);
		$total = 0;
		$qty = $_POST['qty'];
		$submenu = $_POST['submenu'];
		$subtotal = $_POST['subtotal'];
		for ($x = 0; $x < count($_POST['qty']) ; $x++) {
			DB::table('food_order_menu')->insert([
					'food_order_id' => $foid,
					'submenu_id' => $submenu[$x],
					'qty' => $qty[$x],
					'subtotal' => $subtotal[$x]
				]);
			$total = $total + $subtotal[$x];
		}
		DB::table('food_order')->where('food_order_id',$foid)->update([ 
			'total' => $total,  
			]);
		return redirect('/Admin/Transaction/Food-Order')->with('message',1);
	}
	public function editFoodOrder(){
		$fo = DB::table('food_order')->where('food_order_id',$_POST['foodorderid'])->get();
		foreach ($fo as $key => $fo) {
			$clientid = $fo->fo_client_id;
		}
		DB::table('client_details')->where('client_id',$clientid)->update([
			'client_fname' => $_POST['fname'],
			'client_lname' => $_POST['lname'],
			'client_contact1' => $_POST['cpnum1'],
			'client_contact2' => $_POST['cpnum2'],
			'client_telephone1' => $_POST['telnum1'],
			'client_telephone2' => $_POST['telnum2'],
			'client_email' => $_POST['email'],
		]);
		DB::table('food_order_menu')->where('food_order_id',$_POST['foodorderid'])->delete();
		$total = 0;
		$qty = $_POST['qty'];
		$submenu = $_POST['submenu'];
		$subtotal = $_POST['subtotal'];
		for ($x = 0; $x < count($_POST['qty']) ; $x++) {
			DB::table('food_order_menu')->insert([
					'food_order_id' => $_POST['foodorderid'],
					'submenu_id' => $submenu[$x],
					'qty' => $qty[$x],
					'subtotal' => $subtotal[$x]
				]);
			$total = $total + $subtotal[$x];
		}
		DB::table('food_order')->where('food_order_id',$_POST['foodorderid'])->update([ 
			'food_order_date' => date_format(date_create($_POST['date']),"Y-m-d") ,  
			'food_order_time' => date_format(date_create($_POST['time']),"H:i:s") ,  
			'food_order_address' => $_POST['address'] ,  
			'total' => $total,  
			'status' => $_POST['status'] ,  
		]);
		return redirect('/Admin/Transaction/Food-Order')->with('message',2);
	}
	public function deleteFoodOrder(){
		DB::table('food_order')->where('food_order_id',$_POST['id'])->update([ 'deleted' => 1 ]);
		return redirect('/Admin/Transaction/Food-Order')->with('message',3);
	}

	//----------------------------------------------------------------------------------------------
	public function htmltopdfview(Request $request)
    {
        $products = DB::table('submenu_category')->get();
        view()->share('products',$products);
        if($request->has('download')){
            $pdf = PDF::loadView('htmltopdfview');
            return $pdf->download('htmltopdfview.pdf');
        }
        return view('htmltopdfview');
    }

    public function Pay(Request $req){
    	DB::table('payment')->where('payment_id',$req->pid)->increment('amt_paid',$req->amount);
    	$var = DB::table('payment')->where('payment_id',$req->pid)->first();
    	if ($var->amt_paid == $var->grand_total) {
    		// DB::table('event_reservation')->where('payment_id',$req->pid)->update([ 'status' => 'Completed' ]);
	    	DB::table('payment')->where('payment_id',$req->pid)->update([
	    		'payment_status' => 'Paid'
	    	]);
    	} else {
    		if ($var->amt_paid >= $var->grand_total / 2) {
    			DB::table('event_reservation')->where('payment_id',$req->pid)->update([ 'status' => 'Booked' ]);
    		}
    		DB::table('payment')->where('payment_id',$req->pid)->update([
	    		'payment_status' => 'Partial'
	    	]);
    	}
    	return redirect('/Admin/Transaction/Payments');
    }
}
