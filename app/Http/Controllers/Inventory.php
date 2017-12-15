<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class Inventory extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkgen');
        parent::__construct();
    }

	public function EquipmentType(){
		$query = DB::table('equipment_type');
		// $query = DB::table('submenu_category as sc')->leftjoin('submenu as s','sc.submenu_category_id','=','s.submenu_category_id')->select(DB::raw('count(s.deleted) as subcount, sc.submenu_category_name,sc.submenu_category_id'))->groupBy('submenu_category_name','submenu_category_id');
		if (isset($_GET['srch']) && !empty($_GET['srch'])) {
			$query->where('equipment_type_description','like',$_GET['srch'].'%');
		}
		$type = $query->where('deleted',0)->get();
		return view('maintenance.equipmenttype',['type' => $type]);
	}
	public function retrieveEquipmentType(Request $req){
		$var = DB::table('equipment_type')->where('equipment_type_id',$req->ID)->where('deleted',0)->get();
		return response()->json($var);
	}
	public function validateEquipmentType(Request $req){
		$var = DB::table('equipment_type')->where('equipment_type_description',$req->value)->where('deleted',0)->get();
		return response()->json($var);
	}

	public function Inventory(){
		$equipment = DB::table('equipment_inventory as ei')->join('equipment_type as et','ei.equipment_type_id','=','et.equipment_type_id')->where('ei.deleted',0)->get();
		$type = DB::table('equipment_type')->where('deleted',0)->get();
		return view('maintenance.inventory',['equipment' => $equipment,'type' => $type]);
	}
	public function retrieveEquipment(Request $req){
		$var = DB::table('equipment_inventory')->where('equipment_inventory_id',$req->ID)->where('deleted',0)->get();
		return response()->json($var);
	}
	public function validateEquipmentInventory(Request $req){
		$var = DB::table('equipment_inventory')->where('equipment_inventory_name',$req->value)->where('deleted',0)->get();
		return response()->json($var);
	}


	public function Transfers(Request $req){
		if(isset($_GET['form']) && $_GET['form'] == 'new'){
			$supplier = DB::table('supplier')->where('deleted',0)->get();
			return view('inventory.addtransfers',['supplier' => $supplier ]);
		} elseif (isset($_GET['form']) && $_GET['form'] == 'edit') {
			$invtr = DB::table('inventory_transfers')->where('inventory_transfers_id',$_GET['id'])->get();
			$trdet = DB::table('transfer_details')->join('equipment_inventory as ei','ei.equipment_inventory_id','=','transfer_details.equipment_inventory_id')->where('transfer_details.inventory_transfers_id',$req->id)->get();
			return view('inventory.edittransfer',[ 'invtr' => $invtr, 'trdet' => $trdet]);
		} else {
			$invtr = DB::table('inventory_transfers as it')->leftjoin('transfer_details as td','it.inventory_transfers_id','=','td.inventory_transfers_id')->select(DB::raw('SUM(qty) as quantity, it.inventory_transfers_id, it.date, it.date_received, s.supplier_name'))->join('supplier as s','s.supplier_id','=','it.supplier_id')->groupBy('it.inventory_transfers_id','date_received','date','supplier_name','it.inventory_transfers_id')->where('it.deleted',0)->get();
			return view('inventory.transfers',['invtr' => $invtr, ]);
		}
	}

	public function Checklist(){
		$chklst = DB::table('catering_checklist as cc')->join('event_reservation as er','er.event_reservation_id','=','cc.event_reservation_id')->join('event_details as ed','ed.event_id','=','er.event_id')->where('er.deleted',0)->get();
		$elist = DB::table('equipment_inventory as ei')->join('equipment_type as et','et.equipment_type_id','=','ei.equipment_type_id')->where('ei.deleted',0)->get();
		return view('inventory.checklist',[ 'chklst' => $chklst, 'elist' => $elist ]);
	}
	public function getChecklist(Request $req){
		$var = DB::table('checklist_catering as cc')->join('equipment_inventory as ei','ei.equipment_inventory_id','=','cc.equipment_inventory_id')->where('cc.catering_checklist_id',$req->ccid)->get();
		return response()->json($var);
	}


	public function Supplier(){
		$list = DB::table('supplier')->where('deleted',0)->get();
		return view('inventory.supplier',['list' => $list]);
	}
	public function retrieveSupplier(Request $req){
		$var = DB::table('supplier')->where('supplier_id',$req->ID)->first();
		return response()->json($var);
	}
}
