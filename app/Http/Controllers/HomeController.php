<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('checkgen');
        parent::__construct();
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('home');
    }
    public function dashboard()
    {
        $currentDateTime = date('Y-m-d H:i:s');
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i');
        $outDate = date('Y-m-d H:i', strtotime($currentDateTime) + 60 * 60 * 8);
        $inDate = date('H:00', strtotime($currentDateTime) - 60 * 60 * 2);
        $inDateTemp = date('H:00', strtotime($inDate) + 60 * 60 * 1);
        $fivedays = date('Y-m-d',strtotime($currentDate.'+ 6 days'));
        //dd($fivedays);
        // dd($inDate);

        $out = DB::table('event_details')->select('event_id','event_name',DB::raw("CONCAT(event_date,' ',event_time) AS event_dateTime"))->where('event_date', '=', $currentDate)->get();
        //dd($out);
        $in = DB::table('event_details')
            ->select('event_name','event_id')
            ->where('event_date', '=', $currentDate)
            ->where('event_end', '<=', $inDate)
            ->get();
        //dd($in);

        $incoming = DB::table('event_reservation')->join('event_details','event_reservation.event_id','=','event_details.event_id')->where('event_details.event_date','>=',$currentDate)->where('event_details.event_date','<',$fivedays)->orderby('event_details.event_date')->where('event_reservation.status','Booked')->get();
        //dd($incoming);

        $dtask = DB::table('reminder as r')->join('event_reservation as er','er.event_reservation_id','=','r.event_reservation_id')->join('event_details as ed','ed.event_id','=','er.event_id')->where('r.deleted',0)->select('reminder_id','r.description','date','time','event_name')->whereDate('date',date('Y-m-d'))->orderby('date')->get();
        $atask = DB::table('reminder as r')->join('event_reservation as er','er.event_reservation_id','=','r.event_reservation_id')->join('event_details as ed','ed.event_id','=','er.event_id')->where('r.deleted',0)->select('reminder_id','r.description','date','time','event_name')->orderby('date')->get();
        $inq = DB::table('event_inquiry')->whereDate('event_inquiry_date',date('Y-m-d'))->where('deleted',0)->count();
        $eve = DB::table('event_reservation as er')->where('er.deleted',0)->join('event_details as ed','ed.event_id','=','er.event_id')->whereDate('ed.event_date',date('Y-m-d'))->count();
        $fo = DB::table('food_order')->where('deleted',0)->whereDate('food_order_date',date('Y-m-d'))->count();
        $elist = DB::table('equipment_inventory as ei')->join('equipment_type as et','et.equipment_type_id','=','ei.equipment_type_id')->where('ei.deleted',0)->get();
        return view('dashboard',['dtask' => $dtask, 'atask' => $atask, 'inq' => $inq, 'eve' => $eve, 'fo' => $fo, 'out' => $out, 'in' => $in, 'incoming' => $incoming, 'elist' => $elist]);
    }
    public function reports(){
        $cntres = DB::table('event_reservation as er')->where('er.deleted',0)->join('reservation_logs as rl','rl.reservation_logs_id','=','er.reservation_logs_id')->count();
        return view('reports',['cntres' => $cntres]);
    }
    public function Sales_Monthly(){

        return view('reports.salesmonthly');
    }
    public function Sales_Report(){
        if (isset($_GET['print']) && $_GET['print'] == 'pdf') {
            $month = date('m');
            $eve = DB::table('event_reservation as er')->join('client_details as cd','cd.client_id','=','er.client_id')->join('event_details as ed','ed.event_id','=','er.event_id')->join('payment as p','p.payment_id','=','er.payment_id')->join('payment_details as pd','pd.payment_details_id','=','p.payment_details_id')->where('er.deleted',0)->where('er.status','Completed')->orderby('event_date','ASC');
            $fo = DB::table('food_order as fo')->join('client_details as cd','cd.client_id','=','fo.fo_client_id')->orderby('food_order_date','ASC')->where('fo.deleted',0)->where('fo.status','Completed');
            if (isset($_GET['start'])  || isset($_GET['end']) ) {
                $event = $eve->whereBetween('event_date',[ date('Y-m-d', strtotime($_GET['start'])),date('Y-m-d', strtotime($_GET['end'])) ])->get();
                $foodorder = $fo->whereBetween('food_order_date',[ date('Y-m-d', strtotime($_GET['start'])),date('Y-m-d', strtotime($_GET['end'])) ])->get();
            } else {
                $event = $eve->whereMonth('event_date',$month)->get();
                $foodorder = $fo->whereMonth('food_order_date',$month)->get();
            }
            view()->share('event',$event);
            view()->share('foodorder',$foodorder);
            $pdf = PDF::loadView('pdf.salesreport');
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream("SalesReport_".date('mdy').".pdf");
        } else {
            $month = date('m');
            $eve = DB::table('event_reservation as er')->join('client_details as cd','cd.client_id','=','er.client_id')->join('event_details as ed','ed.event_id','=','er.event_id')->join('payment as p','p.payment_id','=','er.payment_id')->join('payment_details as pd','pd.payment_details_id','=','p.payment_details_id')->where('er.deleted',0)->where('er.status','Completed')->orderby('event_date','ASC');
            $fo = DB::table('food_order as fo')->join('client_details as cd','cd.client_id','=','fo.fo_client_id')->orderby('food_order_date','ASC')->where('fo.deleted',0)->where('fo.status','Completed');
            if (isset($_GET['start'])  || isset($_GET['end']) ) {
                $event = $eve->whereBetween('event_date',[ date('Y-m-d', strtotime($_GET['start'])),date('Y-m-d', strtotime($_GET['end'])) ])->get();
                $foodorder = $fo->whereBetween('food_order_date',[ date('Y-m-d', strtotime($_GET['start'])),date('Y-m-d', strtotime($_GET['end'])) ])->get();
            } else {
                $event = $eve->whereMonth('event_date',$month)->get();
                $foodorder = $fo->whereMonth('food_order_date',$month)->get();
            }
            return view('reports.salesreport',['event' => $event, 'foodorder' => $foodorder]);
        }
    }
    public function getSalesReports(Request $req){
        // $var1 =  DB::table('food_order')->select('food_order_date as date','total as value')->where('status','Completed')->where('deleted',0);
        $var = DB::table('event_reservation as er')->select('ed.event_date as date',DB::raw('SUM(p.grand_total) as value'))->join('payment as p','p.payment_id','=','er.payment_id')->join('event_details as ed','ed.event_id','=','er.event_id')->where('er.deleted',0)->where('er.status','Completed')->orderBy('date','asc')->groupBy('date')->get();
        // ->whereBetween('ed.event_date',[ date('Y-m-d', strtotime($_GET['start'])),date('Y-m-d', strtotime($_GET['end'])) ])
        return response()->json($var);
    }
    public function Inventory_Report(){
        if (isset($_GET['print']) && $_GET['print'] == 'pdf') {
            $month = date('m');
            $general = DB::table('settings_general')->get();
            $inven = DB::table('inventory_transfers as it')->join('transfer_details as td','it.inventory_transfers_id','=','td.inventory_transfers_id')->join('equipment_inventory as ei','ei.equipment_inventory_id','=','td.equipment_inventory_id')->join('supplier as s','s.supplier_id','=','it.supplier_id');
            if (isset($_GET['start'])  || isset($_GET['end']) ) {
                $inv = $inven->whereBetween('date',[ date('Y-m-d', strtotime($_GET['start'])),date('Y-m-d', strtotime($_GET['end'])) ])->get();
            } else {
                $inv = $inven->whereMonth('date',$month)->get();
            }
            view()->share('general',$general);
            view()->share('inv',$inv);
            $pdf = PDF::loadView('pdf.inventoryreport', $general);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream("InventoryReport_".date('mdy').".pdf");
        } else {
            $month = date('m');
            $inven = DB::table('inventory_transfers as it')->join('transfer_details as td','it.inventory_transfers_id','=','td.inventory_transfers_id')->join('equipment_inventory as ei','ei.equipment_inventory_id','=','td.equipment_inventory_id')->join('supplier as s','s.supplier_id','=','it.supplier_id');
            if (isset($_GET['start'])  || isset($_GET['end']) ) {
                $inv = $inven->whereBetween('date',[ date('Y-m-d', strtotime($_GET['start'])),date('Y-m-d', strtotime($_GET['end'])) ])->get();
            } else {
                $inv = $inven->whereMonth('date',$month)->get();
            }

            return view('reports.inventoryreport',['inv' => $inv]);
        }
    }
    public function getInventoryReports(Request $req){
        $var = DB::table('inventory_transfers as it')->join('transfer_details as td','it.inventory_transfers_id','=','td.inventory_transfers_id')->join('equipment_inventory as ei','ei.equipment_inventory_id','=','td.equipment_inventory_id')->select('date_received as date',DB::raw('sum(qty) * sum(unit_value) as value'))->groupBy('date_received')->get();
// ->whereBetween('date',[ date('Y-m-d', strtotime($_GET['start'])),date('Y-m-d', strtotime($_GET['end'])) ])
        return response()->json($var);
    }


    public function settings()
    {
        return view('settings');
    }
    public function general()
    {
        $general = DB::table('settings_general')->orderby('settings_general_id','DESC')->first();
        return view('settings.general',['gen' => $general]);
    }
    public function site(){
        return view('settings.site');
    }

    //-------------------------------USERS---------------------------------------//

    public function Users(){
        if (!isset($_GET['srch'])) {
            $user = DB::table('users')->where('deleted','=',0)->orderby('username')->get();
        } else {
            $user = DB::table('users')->where('deleted','=',0)->where('username','like',$_GET['srch'].'%')->orderby('username')->get();
        }
        return view('settings.users',['user' => $user]);
    }
    public function retrieveUsers(Request $req){
        $var = DB::table('users')->where('id',$req->ID)->where('deleted',0)->get();
        return response()->json($var);
    }
    public function validateUsers(Request $req){
        $var = DB::table('users')->where('username',$req->value)->where('deleted',0)->get();
        return response()->json($var);
    }
    public function addUsers(Request $req, Validator $validator){
        // $validator = Validator::make(
  //           $req->all(),
  //           [
  //               'username' => 'required',
  //               'password' => 'required',
  //               'email' => 'required',
  //               'disname' => 'required',
  //           ]
  //           );

        // if ($validator->fails()){
        //     return redirect('/Admin/Maintenance/Users')
        //     ->withErrors($validator)
        //     ->withInput();
        //     die();
        // }
        // else {
            DB::table('users')->insert(
                    [
                    'username' => $_POST['username'],
                    'password' => bcrypt($_POST['password1']),
                    'remember_token' => $_POST['_token'],
                    'role' => 'admin',
                    'display_name' => $_POST['disname'],
                    'email' => $_POST['email'],
                    'created_at' => date_create('now'),
                    'updated_at' => date_create('now'),
                    ]
                );
            return redirect('/Admin/Settings/Users');
        // }

    }

    public function deleteUsers(Request $req, Validator $validator){
        DB::table('users')->where('id','=',$_POST['id'])->update(
                    [
                        'deleted' => 1
                    ]
                );

        return redirect('/Admin/Settings/Users')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully deleted.']);
    }

    public function dashboardOut(Request $req){
        $equipment = DB::table('equipment_inventory')->where('equipment_inventory_id',$req->id)->first();
        return response()->json($equipment);
    }

    public function dashboardTable(Request $req){
      $equipment = DB::table('equipment_inventory')->where('equipment_inventory_id',$req->iddd)->first();
      return response()->json($equipment);
    }

     public function dashboardIn(Request $req){
        $equipment = DB::table('equipment_inventory')->where('deleted',0)->get();
        return response()->json($equipment);
    }
}
