<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use DB;
use Validator; 
use Auth;

class FormMntnc extends Controller
{
	
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkgen');
        parent::__construct();
    }

	//------------------------------------------Package-----------------------------------------------------------//

    public function addPackage(Request $req, Validator $validator){

		$name = ucwords($_POST['name']);
		$lastID = DB::table('package')->insertGetId(
				[
					'package_name' => $name,
					'package_inclusions' => $_POST['inclusions'],
					'package_price' => $_POST['price'],
				]
		);

		$qty = $_POST['pkgQty'];
		$ctgry = $_POST['pkgCtgry'];
		for ($x = 0; $x < count($_POST['pkgQty']) ; $x++) {
			DB::table('package_choice')->insert([
					'package_id' => $lastID,
					'qty' => $qty[$x],
					'submenu_category_id' => $ctgry[$x]
				]);
		}
		foreach ($req->pkgChc as $key) {
			$scid = DB::table('submenu')->select('submenu_category_id')->where('submenu_id',$key)->first();
			$pcid = DB::table('package_choice')->where('package_id',$lastID)->where('submenu_category_id',$scid->submenu_category_id)->first();
			DB::table('food_choice')->insert([
				'package_choice_id' => $pcid->package_choice_id,
				'submenu_category_id' => $scid->submenu_category_id,
				'submenu_id' => $key
			]);
		}
		return redirect('/Admin/Maintenance/Package')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully saved.']);
	}
	public function editPackage(Request $req, Validator $validator){
		$name = ucwords($_POST['name']);
		DB::table('package')->where('package_id',$_POST['id'])->update(
				[
					'package_name' => $name,
					'package_inclusions' => $_POST['inclusions'],
					'package_price' => $_POST['price'],
				]
		);
		DB::table('package_choice')->where('package_id', '=', $_POST['id'])->delete();
		$qty = $_POST['pkgQty'];
		$ctgry = $_POST['pkgCtgry'];
		for ($x = 0; $x < count($_POST['pkgQty']) ; $x++) {
			DB::table('package_choice')->insert([
					'package_id' => $_POST['id'],
					'qty' => $qty[$x],
					'submenu_category_id' => $ctgry[$x]
				]);
		}

		foreach ($req->pkgChc as $key) {
			$scid = DB::table('submenu')->select('submenu_category_id')->where('submenu_id',$key)->first();
			$pcid = DB::table('package_choice')->where('package_id',$_POST['id'])->where('submenu_category_id',$scid->submenu_category_id)->first();
			DB::table('food_choice')->insert([
				'package_choice_id' => $pcid->package_choice_id,
				'submenu_category_id' => $scid->submenu_category_id,
				'submenu_id' => $key
			]);
		}

		return redirect('/Admin/Maintenance/Package')->with('message',['type'=>'success','head'=>'Success','text'=>'Changes have been saved.']);
	}
	public function deletePackage(Request $req, Validator $validator){
		DB::table('package')->where('package_id','=',$_POST['id'])->update(
					[
						'deleted' => 1
					]
				);
		return redirect('/Admin/Maintenance/Package')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully deleted.']);
	}

	//-------------------------------------------------SUBMENU CATEGORY---------------------------------------------------//

    public function addSubmenuCategory(Request $req, Validator $validator){
		$name = ucwords($_POST['categoryName']);
		// $validator = Validator::make($req->all(), [
  //           'categoryName' => 'required|max:20|unique:submenu_category,submenu_category_name'
  //       ]);
  //       if ($validator->fails()) {
  //           return redirect('/Admin/Maintenance/SubmenuCategory')
  //                       ->withErrors($validator)
  //                       ->withInput();
  //       }
		$records = DB::table('submenu_category')->where('submenu_category_name',$name)->where('deleted',0)->get();
	
		if (count($records)>0){
			return redirect('/Submenu?tab=category')->with('message',['type'=>'negative','head'=>'Error','text'=>'Existing Category.']);
		} else {
			DB::table('submenu_category')->insert(['submenu_category_name'=>$name]);
			return redirect('/Admin/Maintenance/Submenu?tab=category')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully saved.']);
		}
	}
	public function editSubmenuCategory(Request $req, Validator $validator){
		$name = ucwords($_POST['categoryName']);
		
		$records = DB::table('submenu_category')->where('submenu_category_name',$name)->where('deleted',0)->get();
	
		if (count($records)>0){
			return redirect('/Submenu?tab=category')->with('message',['type'=>'negative','head'=>'Error','text'=>'Existing Category.']);
		} else {
			DB::table('submenu_category')->where('submenu_category_id',$req->input('categoryId'))->update([ 'submenu_category_name' => $name ]);
			return redirect('/Admin/Maintenance/Submenu?tab=category')->with('message',['type'=>'success','head'=>'Success','text'=>'Changes have been saved.']);
		}
	}
	public function deleteSubmenuCategory(Request $req, Validator $validator){
		$ctr = 0;
		$records = DB::table('submenu')->where('submenu_category_id',$_POST['id'])->where('deleted',0)->get();
		if (count($records)>0) {
			$ctr++;
		} else {
			DB::table('submenu_category')->where('submenu_category_id','=',$_POST['id'])->update(['deleted' => 1]);
		}

		if ($ctr > 0) {
			return redirect('/Admin/Maintenance/Submenu?tab=category')->with('message',['type'=>'error','head'=>'Error','text'=>'Category cannot be deleted.']);
		} else {
			return redirect('/Admin/Maintenance/Submenu?tab=category')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully deleted.']);			
		}
	}

	//------------------------------------------SUBMENU-----------------------------------------------------------//

	public function addSubmenu(Request $req, Validator $validator){
		$name = ucwords($_POST['submenuName']);
		
		$records = DB::table('submenu')->where('submenu_name',$name)->where('deleted',0)->get();
	
		if (count($records)>0){
			return redirect('/Submenu')->with('message',['type'=>'negative','head'=>'Error','text'=>'Existing Food Name.']);
		} else {
			$image = $req->submenuImage;
			if(!empty($image)){
				$upload = 'public/image/FoodImages';
		        $filename = time().'.'.$req->submenuImage->getClientOriginalExtension();
		        $req->submenuImage->move(public_path('/image/FoodImages'), $filename);
			} else {
				$filename = "preview.png";
			}
			DB::table('submenu')->insert([
				'submenu_name'=>$name,
				'submenu_description'=>$_POST['submenuDesc'],
				'submenu_price'=>$_POST['submenuPrice'],
				'submenu_img'=> $filename,
				'submenu_category_id'=>$_POST['submenuCtgry'],
				]);
			return redirect('/Admin/Maintenance/Submenu')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully saved.']);
		}
	}
	public function editSubmenu(Request $req, Validator $validator){
		$name = ucwords($req->submenuName);
		$image = $req->submenuImage;
		if(!empty($image)){
			$upload = 'public/image/FoodImages';
	        $filename = time().'.'.$req->submenuImage->getClientOriginalExtension();
	        $req->submenuImage->move(public_path('/image/FoodImages'), $filename);
	        DB::table('submenu')->where('submenu_id','=',$_POST['submenuId'])->update([
					'submenu_img'=> $filename,
				]);
		} else {
			if (empty($req->tempImage)) {
				DB::table('submenu')->where('submenu_id','=',$_POST['submenuId'])->update([
					'submenu_img'=> 'preview.png',
				]);
			}
		}
		DB::table('submenu')->where('submenu_id','=',$_POST['submenuId'])->update([
			'submenu_name'=>$name,
			'submenu_description'=>$_POST['submenuDesc'],
			'submenu_price'=>$_POST['submenuPrice'],
			'submenu_category_id'=>$_POST['submenuCtgry'],
		]);
		return redirect('/Admin/Maintenance/Submenu')->with('message',['type'=>'success','head'=>'Success','text'=>'Changes have been saved.']);
	}
	public function deleteSubmenu(Request $req, Validator $validator){
			DB::table('submenu')->where('submenu_id','=',$_POST['id'])->update([
				'deleted' => 1
			]);
		return redirect('/Admin/Maintenance/Submenu')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully deleted.']);
	}

	//------------------------------------------SERVICES---------------------------------------------------------------------//

	public function addServices(Request $req, Validator $validator){
		$name = ucwords($_POST['serviceName']);
		
		$records = DB::table('services')->where('services_name',$name)->where('deleted',0)->get();
	
		if (count($records)>0){
			return redirect('/Services')->with('message',['type'=>'negative','head'=>'Error','text'=>'Existing Service Name.']);
		} else {
			DB::table('services')->insert([
				'services_name'=>$name,
				'services_description'=>$_POST['serviceDescription'],
				]);
			return redirect('/Admin/Maintenance/Services?tab=category')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully saved.']);
		}

	}
	public function editServices(Request $req, Validator $validator){
		$name = ucwords($_POST['serviceName']);
		// $records = DB::table('services')->where('services_name',$_POST['serviceName'])->where('deleted',0)->get();
	
		// if (count($records)>0){
		// 	return redirect('/Services')->with('message',['type'=>'negative','head'=>'Error','text'=>'Existing Service Name.']);
		// } else {
			DB::table('services')->where('services_id','=',$_POST['serviceId'])->update(
						[
							'services_name' => $name,
							'services_description' => $_POST['serviceDescription'],
						]
					);
			return redirect('/Admin/Maintenance/Services?tab=category')->with('message',['type'=>'success','head'=>'Success','text'=>'Changes have been saved.']);
		// }
	}
	public function deleteServices(Request $req, Validator $validator){
		$ctr = 0;
		$records = DB::table('services_contact')->where('services_id',$_POST['id'])->where('deleted',0)->get();
		if (count($records)>0) {
			$ctr++;
		} else {
			DB::table('services')->where('services_id','=',$_POST['id'])->update(['deleted' => 1]);
		}

		if ($ctr > 0) {
			return redirect('/Admin/Maintenance/Services?tab=category')->with('message',['type'=>'error','head'=>'Error','text'=>'Service Type cannot be deleted.']);
		} else {
			return redirect('/Admin/Maintenance/Services?tab=category')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully deleted.']);		
		}
	}

	//------------------------------------------SERVICE CONTACT-----------------------------------------------------------//

	public function addServiceContact(Request $req, Validator $validator){
		
		$records = DB::table('services_contact')->where('services_contact_name',$_POST['contactName'])->where('deleted',0)->get();
	
		if (count($records)>0){
			return redirect('/ServiceContact')->with('message',['type'=>'negative','head'=>'Error','text'=>'Existing Service Name.']);
		} else {
			DB::table('services_contact')->insert([
					'services_contact_name'=>$_POST['contactName'],
					'services_contact_owner'=>$_POST['contactOwner'],
					'street'=>$_POST['street'],
					'barangay'=>$_POST['barangay'],
					'city'=>$_POST['city'],
					'province'=>$_POST['province'],	
					'services_contact_number1'=>$_POST['contactNumber1'],
					'services_contact_number2'=>$_POST['contactNumber2'],
					'services_contact_price'=>$_POST['contactPrice'],
					'price_type'=>$_POST['pricetype'],
					'services_id'=>$_POST['contactCtgry'],
				]);
			return redirect('/Admin/Maintenance/Services')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully saved.']);
		}
	}
	public function editServiceContact(Request $req, Validator $validator){
			DB::table('services_contact')->where('services_contact_id','=',$_POST['contactId'])->update(
						[
						'services_contact_name'=>$_POST['contactName'],
						'services_contact_owner'=>$_POST['contactOwner'],
						'street'=>$_POST['street'],
						'barangay'=>$_POST['barangay'],
						'city'=>$_POST['city'],
						'province'=>$_POST['province'],	
						'services_contact_number1'=>$_POST['contactNumber1'],
						'services_contact_number2'=>$_POST['contactNumber2'],
						'services_contact_price'=>$_POST['contactPrice'],
						'price_type' => $_POST['pricetype'],
						'services_id'=>$_POST['contactCtgry'],
						]
					);
			return redirect('/Admin/Maintenance/Services')->with('message',['type'=>'success','head'=>'Success','text'=>'Changes have been saved.']);
	}
	public function deleteServiceContact(Request $req, Validator $validator){
		DB::table('services_contact')->where('services_contact_id','=',$_POST['id'])->update(
					[
						'deleted' => 1
					]
				);
		
		return redirect('/Admin/Maintenance/Services')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully deleted.']);
	}

	//------------------------------------------PROFESSION-----------------------------------------------------------//

    public function addProfession(Request $req, Validator $validator){
		$name = ucwords($_POST['professionName']);
		
		$records = DB::table('staff_profession')->where('staff_profession_description',$name)->where('deleted',0)->get();
	
		if (count($records)>0){
			return redirect('/Admin/Maintenance/Staff')->with('message',['type'=>'negative','head'=>'Error','text'=>'Existing Profession.']);
		} else {
			DB::table('staff_profession')->insert([
				'staff_profession_description'=>$name
				]);
			return redirect('/Admin/Maintenance/Staff?tab=profession')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully saved.']);
		}
	}
	public function editProfession(Request $req, Validator $validator){
		$name = ucwords($_POST['professionName']);
		
		$records = DB::table('staff_profession')->where('staff_profession_description',$name)->where('deleted',0)->get();
	
		if (count($records)>0){
			return redirect('/Admin/Maintenance/Staff?tab=profession')->with('message',['type'=>'negative','head'=>'Error','text'=>'Existing Category.']);
		} else {
			DB::table('staff_profession')->where('staff_profession_id','=',$_POST['professionId'])->update(
						[
							'staff_profession_description' => $name
						]
					);
			return redirect('/Admin/Maintenance/Staff?tab=profession')->with('message',['type'=>'success','head'=>'Success','text'=>'Changes have been saved.']);
		}
	}
	public function deleteProfession(Request $req, Validator $validator){
		$ctr = 0;	 
		$records = DB::table('staff')->where('staff_profession_id',$_POST['id'])->where('deleted',0)->get();
		if (count($records)>0) {
			$ctr++;
		} else {
			DB::table('staff_profession')->where('staff_profession_id','=',$_POST['id'])->update(['deleted' => 1]);
		}

		if ($ctr > 0) {
			return redirect('/Admin/Maintenance/Staff?tab=profession')->with('message',['type'=>'error','head'=>'Error','text'=>'Profession cannot be deleted.']);
		} else {
			return redirect('/Admin/Maintenance/Staff?tab=profession')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully deleted.']);			
		}
	}

	//------------------------------------------STAFF-----------------------------------------------------------//

	public function uploadProfile(Request $req, Validator $validator){
		$image = $req->profilepic;
		if(!empty($image)){
			$upload = 'public/image/ProfilePictures';
	        $filename = time().'.'.$req->profilepic->getClientOriginalExtension();
	        $req->profilepic->move(public_path('/image/ProfilePictures'), $filename);
		} else {
			$filename = "preview.png";
		}
	}

	public function addStaff(Request $req, Validator $validator){
		$birthdate = date_format(date_create($_POST['birthdate']),"Y-m-d");
		$age = date_diff(date_create($birthdate), date_create('now'))->y;

		$image = $req->profilepic;
		if(!empty($image)){
	        $filename = time().'.'.$req->profilepic->getClientOriginalExtension();
	        $req->profilepic->move(public_path('/image/ProfilePictures'), $filename);
		} else {
			$filename = "preview.png";
		}
		DB::table('staff')->insert([
				'staff_lname'=>$_POST['lname'],
				'staff_fname'=>$_POST['fname'],
				'staff_img'=>$filename,
				'staff_birthdate'=>$birthdate,
				'staff_age'=>$age,
				'staff_gender'=>$_POST['gender'],
				'street'=>$_POST['street'],
				'barangay'=>$_POST['barangay'],
				'city'=>$_POST['city'],
				'province'=>$_POST['province'],
				'staff_contact'=>$_POST['number'],
				'staff_rate'=>$_POST['rate'],
				'staff_profession_id'=>$_POST['profession'],

			]);
		return redirect('/Admin/Maintenance/Staff')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully saved.']);
	}
	public function editStaff(Request $req, Validator $validator){
		$birthdate = date_format(date_create($_POST['birthdate']),"Y-m-d");
		$age = date_diff(date_create($birthdate), date_create('now'))->y;

		$image = $req->profilepic;
		if(!empty($image)){
			$upload = 'public/image/ProfilePictures';
	        $filename = time().'.'.$req->profilepic->getClientOriginalExtension();
	        $req->profilepic->move(public_path('/image/ProfilePictures'), $filename);
	        
			DB::table('staff')->where('staff_id','=',$_POST['id'])->update([
					'staff_img'=>$filename,
					]);
		} else {
			if (empty($req->tempImage)) {
				DB::table('staff')->where('staff_id','=',$_POST['id'])->update([
					'staff_img'=> 'preview.png',
				]);
			}
		}
		DB::table('staff')->where('staff_id','=',$_POST['id'])->update([
			'staff_lname'=>$_POST['lname'],
			'staff_fname'=>$_POST['fname'],
			'staff_birthdate'=>$birthdate,
			'staff_age'=>$age,
			'staff_gender'=>$_POST['gender'],
			'street'=>$_POST['street'],
			'barangay'=>$_POST['barangay'],
			'city'=>$_POST['city'],
			'province'=>$_POST['province'],
			'staff_contact'=>$_POST['number'],
			'staff_rate'=>$_POST['rate'],
			'staff_profession_id'=>$_POST['profession'],
		]);
		return redirect('/Admin/Maintenance/Staff')->with('message',['type'=>'success','head'=>'Success','text'=>'Changes have been saved.']);
	}
	public function deleteStaff(Request $req, Validator $validator){
		DB::table('staff')->where('staff_id','=',$_POST['id'])->update(
					[
						'deleted' => 1
					]
				);
		return redirect('/Admin/Maintenance/Staff')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully deleted.']);
	}

	//-------------------------------LOCATION---------------------------------//

	public function addLocation(Request $req, Validator $validator){

		$image = $req->uploadpic;
		if(!empty($image)){
	        $filename = time().'.'.$req->uploadpic->getClientOriginalExtension();
	        $req->uploadpic->move(public_path('/image/LocationImages'), $filename);
		} else {
			$filename = "preview.png";
		}
		DB::table('location')->insert([
				'location_name'=>$_POST['locname'],
				'location_owner'=>$_POST['ownername'],
				'location_contact1'=>$_POST['contactNumber1'],
				'location_contact2'=>$_POST['contactNumber2'],
				'location_rate'=>$_POST['rate'],
				'street'=>$_POST['street'],
				'city'=>$_POST['city'],
				'barangay'=>$_POST['barangay'],
				'province'=>$_POST['province'],
				'location_img'=>$filename,
				'location_max'=>$_POST['cap'],
			]);
		return redirect('/Admin/Maintenance/Location')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully saved.']);
	}
	public function editLocation(Request $req, Validator $validator){
		$image = $req->uploadpic;
		if(!empty($image)){
			$upload = 'public/image/LocationImages';
	        $filename = time().'.'.$req->uploadpic->getClientOriginalExtension();
	        $req->uploadpic->move(public_path('/image/LocationImages'), $filename);
			DB::table('location')->where('location_id','=',$_POST['locid'])->update([
				'location_img'=>$filename,
			]);
		} else {
			if (empty($req->tempImage)) {
				DB::table('location')->where('location_id','=',$_POST['locid'])->update([
					'location_img'=> 'preview.png',
				]);
			}
		}
		DB::table('location')->where('location_id','=',$_POST['locid'])->update([
			'location_name'=>$_POST['locname'],
			'location_owner'=>$_POST['ownername'],
			'location_contact1'=>$_POST['contactNumber1'],
			'location_contact2'=>$_POST['contactNumber2'],
			'location_rate'=>$_POST['rate'],
			'street'=>$_POST['street'],
			'city'=>$_POST['city'],
			'barangay'=>$_POST['barangay'],
			'province'=>$_POST['province'],
			'location_max'=>$_POST['cap'],
		]);
		return redirect('/Admin/Maintenance/Location')->with('message',['type'=>'success','head'=>'Success','text'=>'Changes have been saved.']);
	}
	public function deleteLocation(Request $req, Validator $validator){
		DB::table('location')->where('location_id','=',$_POST['id'])->update(
					[
						'deleted' => 1
					]
				);
		
		return redirect('/Admin/Maintenance/Location')->with('message',['type'=>'success','head'=>'Success','text'=>'Successfully deleted.']);
	}


}
