<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class FormInvntry extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkgen');
        parent::__construct();
    }

	//-------------------------------------------------Equipment Type---------------------------------------------------//

    public function addEquipmentType(Request $req, Validator $validator){
		$name = ucwords($_POST['name']);
		$records = DB::table('equipment_type')->where('equipment_type_description',$name)->where('deleted',0)->get();
	
		if (count($records)>0){
			return redirect('/Admin/Inventory/EquipmentInventory?tab=type')->with('message',['type'=>'negative','head'=>'Error','text'=>'Existing Name.']);
		} else {
			DB::table('equipment_type')->insert(['equipment_type_description'=>$name]);
			return redirect('/Admin/Inventory/EquipmentInventory?tab=type')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully saved.']);
		}
	}
	public function editEquipmentType(Request $req, Validator $validator){
		$name = ucwords($_POST['name']);
		
		$records = DB::table('equipment_type')->where('equipment_type_description',$name)->where('deleted',0)->get();
	
		if (count($records)>0){
			return redirect('/Admin/Inventory/EquipmentInventory?tab=type')->with('message',['type'=>'negative','head'=>'Error','text'=>'Existing Type.']);
		} else {
			DB::table('equipment_type')->where('equipment_type_id',$req->input('id'))->update([ 'equipment_type_description' => $name ]);
			return redirect('/Admin/Inventory/EquipmentInventory?tab=type')->with('message',['type'=>'success','head'=>'Success','text'=>'Changes have been saved.']);
		}
	}
	public function deleteEquipmentType(Request $req, Validator $validator){
		$ctr = 0;
		$records = DB::table('equipment_inventory')->where('equipment_type_id',$_POST['id'])->where('deleted',0)->get();
		if (count($records)>0) {
			$ctr++;
		} else {
			DB::table('equipment_type')->where('equipment_type_id',$_POST['id'])->update(['deleted' => 1]);
		}

		if ($ctr > 0) {
			return redirect('/Admin/Inventory/EquipmentInventory?tab=type')->with('message',['type'=>'error','head'=>'Error','text'=>'Type cannot be deleted.']);
		} else {
			return redirect('/Admin/Inventory/EquipmentInventory?tab=type')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully deleted.']);			
		}
	}

	//----------------------------------------Equipment Inventory----------------------------------//

    public function addEquipmentInventory(Request $req, Validator $validator){
		$name = ucwords($_POST['name']);
		$records = DB::table('equipment_inventory')->where('equipment_inventory_name',$name)->where('deleted',0)->get();
	
		if (count($records)>0){
			return redirect('/Admin/Maintenance/EquipmentInventory')->with('message',['type'=>'negative','head'=>'Error','text'=>'Existing Name.']);
		} else {
			DB::table('equipment_inventory')->insert([
				'equipment_inventory_name'=>$name,
				'equipment_inventory_description'=> $_POST['description'],
				'equipment_inventory_qty'=> $_POST['quantity'],
				'equipment_type_id'=> $_POST['type'],
				]);
			return redirect('/Admin/Inventory/EquipmentInventory')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully saved.']);
		}
	}
	public function editEquipmentInventory(Request $req, Validator $validator){
		$name = ucwords($_POST['name']);
		DB::table('equipment_inventory')->where('equipment_inventory_id',$_POST['id'])->update([
				'equipment_inventory_name'=>$name,
				'equipment_inventory_description'=> $_POST['description'],
				'equipment_inventory_qty'=> $_POST['quantity'],
				'equipment_type_id'=> $_POST['type'],
			]);

		return redirect('/Admin/Inventory/EquipmentInventory')->with('message',['type'=>'success','head'=>'Success','text'=>'Changes have been saved.']);
	}
	public function deleteEquipmentInventory(Request $req, Validator $validator){
		DB::table('equipment_inventory')->where('equipment_inventory_id',$_POST['id'])->update(['deleted' => 1]);
		return redirect('/Admin/Inventory/EquipmentInventory')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully deleted.']);
	}

	//---------------------------------------TRANSFER---------------------------------------------------------------------
	public function addTransfer(){
		$ifid = DB::table('inventory_transfers')->insertGetId([
			// 'status' => 'Pending',
			'date_received' => date_create($_POST['date'])->format('Y-m-d H:i:s'),
			'date' => date_create('now'),
			'supplier_id' => $_POST['supplier'] 
		]);
		$eq = $_POST['eqid'];
		$uv = $_POST['price'];
		$qty = $_POST['qty'];
		for ($x = 0; $x < count($qty) ; $x++) {
			DB::table('transfer_details')->insert([
				'inventory_transfers_id' => $ifid,
				'equipment_inventory_id' => $eq[$x],
				'unit_value' => $uv[$x],
				'qty' => $qty[$x],
			]);
			if (isset($_POST['addpur'])) {
				DB::table('equipment_inventory')->where('equipment_inventory_id',$eq[$x])->increment('equipment_inventory_qty',$qty[$x]);
			}
		}
		return redirect('/Admin/Inventory/Transfers');
	}
	public function editTransfer(Request $req){
		DB::table('inventory_transfers')->where('inventory_transfers_id',$req->trid)->update([
			'date_received' => date_create($_POST['date'])->format('Y-m-d H:i:s'),
			'supplier_name' => $_POST['supplier'] 
		]);
		if (isset($req->eqid)) {
			$eq = $req->eqid;
			$uv = $req->price;
			$qty = $req->qty;
			for ($x = 0; $x < count($eq); $x++) {
				$td = DB::table('transfer_details')->where('inventory_transfers_id',$req->trid)->where('equipment_inventory_id',$eq[$x])->first();
				$ei = DB::table('equipment_inventory')->where('equipment_inventory_id',$eq[$x])->decrement('equipment_inventory_qty',$td->qty);
				DB::table('transfer_details')->where('inventory_transfers_id',$req->trid)->where('equipment_inventory_id',$eq[$x])->update([
					'unit_value' => $uv[$x],
					'qty' => $qty[$x],
				]);
				DB::table('equipment_inventory')->where('equipment_inventory_id',$eq[$x])->increment('equipment_inventory_qty',$qty[$x]);
			}
		}
		return redirect('/Admin/Inventory/Transfers');
	}
	public function deleteTransfer(Request $req){
		DB::table('inventory_transfers')->where('inventory_transfers_id',$req->id)->update([ 'deleted' => 1 ]);
		DB::table('transfer_details')->where('inventory_transfers_id',$req->id)->update([ 'deleted' => 1 ]);
		return redirect('/Admin/Inventory/Transfers');
	}
	public function receiveTransfer(){
		DB::table('inventory_transfers')->where('inventory_transfers_id',$_POST['trid'])->update([
			'status' => 'Partial'
		]);
		$eqid = $_POST['eqid'];
		$rec = $_POST['rec'];
		$rej = $_POST['rej'];
		$can = $_POST['can'];
		for ($x = 0; $x < count($eqid) ; $x++) {
			DB::table('transfer_details')->where('inventory_transfers_id',$_POST['trid'])->where('equipment_inventory_id',$eqid[$x])->update([
				'received' => $rec[$x],
				'cancelled' => $rej[$x],
				'rejected' => $can[$x],
			]);
		}

		return redirect('/Admin/Inventory/Transfers?form=edit&id='.$_POST['trid']);
	}

	//----------------------------------------------Checklist---------------------------------------
	public function saveChecklist(Request $req){
		if (isset($req->out)){
			$out = $req->out;
			$eqid = $req->eqid;
			for ($x=0; $x < count($out) ; $x++) { 
				DB::table('checklist_catering')->insert([
					'catering_checklist_id' => $req->ccid,
					'equipment_inventory_id' => $eqid[$x],
					'equipment_out' => $out[$x]
				]);
				DB::table('equipment_inventory')->where('equipment_inventory_id',$eqid[$x])->decrement('equipment_inventory_qty',$out[$x]);
			}
			DB::table('catering_checklist')->where('catering_checklist_id',$req->ccid)->update([
				'checklist_status' => 'Pulled out'
			]);
		}
		if (isset($req->in)) {
			$in = $req->in;
			$out = $req->out;
			$eqid = $req->eqid;
			$ld = $req->ld;
			for ($x=0; $x < count($in) ; $x++) { 
				DB::table('checklist_catering')->where('catering_checklist_id',$req->ccid)->where('equipment_inventory_id',$eqid[$x])->update([
					'equipment_in' => $in[$x],
					'lost_damage' => $out[$x] - $in[$x]
				]);
				DB::table('equipment_inventory')->where('equipment_inventory_id',$eqid[$x])->increment('equipment_inventory_qty',$in[$x]);
			}
			DB::table('catering_checklist')->where('catering_checklist_id',$req->ccid)->update([
				'checklist_status' => 'Returned'
			]);
		}
		return redirect('/Admin/Inventory/Checklist');
	}

	//---------------------------------------Supplier--------------------------------------------------------
	public function addSupplier(Request $req){
		DB::table('supplier')->insert([
			'supplier_name' => $req->name,
			'supplier_contact' => $req->contact,
		]);
		return redirect('/Admin/Inventory/Supplier');
	}
	public function editSupplier(Request $req){
		DB::table('supplier')->where('supplier_id',$req->id)->update([ 
			'supplier_name' => $req->name,
			'supplier_contact' => $req->contact
		]);
		return redirect('/Admin/Inventory/Supplier');
	}
	public function deleteSupplier(Request $req){
		DB::table('supplier')->where('supplier_id',$req->id)->update([ 'deleted' => 1]);
		return redirect('/Admin/Inventory/Supplier');
	}
}
