<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;

// Route::get('image-upload','ImageController@imageUpload');
// Route::post('image-upload','ImageController@imageUploadPost');

Route::get('/', 'WebsiteController@Homepage');
Route::get('/Menus', 'WebsiteController@Menus');
Route::get('/Package', 'WebsiteController@Package');
Route::get('/Contact-Us', 'WebsiteController@ContactUs');

Route::post('/inquiry', 'WebsiteController@addInquiry');
//-----------------------------------------------------------
Route::post('/doLogin', 'LoginController@doLogin');
Route::post('/doRegister', 'LoginController@doRegister');
Route::get('/Admin', 'LoginController@Login');
//-----------------------------------------------------------
Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/Site-Setup', function(){
	return view('setup-site-form');
});
Route::get('Admin/Dashboard', 'HomeController@dashboard');

Route::get('Admin/Reports', 'HomeController@reports');
Route::get('Admin/Reports/Sales_Monthly', 'HomeController@Sales_Monthly');
Route::get('Admin/Reports/Sales_Weekly', 'HomeController@Sales_Weekly');
Route::get('Admin/Reports/Sales_Report', 'HomeController@Sales_Report');
Route::get('Admin/Reports/Inventory_Report', 'HomeController@Inventory_Report');
Route::get('/getSalesReports', 'HomeController@getSalesReports');
Route::get('/getInventoryReports', 'HomeController@getInventoryReports');

Route::get('Admin/Settings', 'HomeController@settings');
Route::get('Admin/Settings/General', 'HomeController@general');
Route::get('Admin/Settings/Site', 'HomeController@site');
Route::post('/editGeneral', 'CheckSettings@editGeneral');

Route::get('Admin/Settings/Users', 'HomeController@Users');
Route::get('/retrieveUsers', 'HomeController@retrieveUsers');
Route::get('/validateUsers', 'HomeController@validateUsers');
Route::post('/addUsers', 'HomeController@addUsers');
Route::post('/editUsers', 'HomeController@editUsers');
Route::post('/deleteUsers', 'HomeController@deleteUsers');


Route::get('Admin/Transaction/Events', 'Transaction@Events');
Route::get('/getEvents', 'Transaction@getEvents');

Route::get('htmltopdfview',array('as'=>'htmltopdfview','uses'=>'FormTrans@htmltopdfview'));

Route::get('Admin/Transaction/Event-Inquiries', 'Transaction@EventInquiries');
Route::post('/editInquiry', 'Transaction@editInquiry');
Route::post('/deleteInquiry', 'Transaction@deleteInquiry');

Route::get('Admin/Transaction/Payments', 'Transaction@Payments');
Route::post('/Pay', 'FormTrans@Pay');

Route::get('Admin/Transaction/Event-Reservation', 'Transaction@EventReservation');
Route::post('/addReservation', 'FormTrans@addReservation');
Route::post('/editReservation', 'FormTrans@editReservation');
Route::get('/cancelReservation', 'FormTrans@cancelReservation');
Route::get('/deleteReservation', 'FormTrans@deleteReservation');
Route::get('/saveCateringMenu', 'FormTrans@saveCateringMenu');
Route::get('/saveCateringServices', 'FormTrans@saveCateringServices');
Route::get('/saveCateringStaff', 'FormTrans@saveCateringStaff');
Route::post('/addCateringInventory/{id}/{log}', ['uses' => 'FormTrans@addCateringInventory']);
Route::get('/addExtraCost', 'FormTrans@addExtraCost');
Route::get('/editExtraCost', 'FormTrans@editExtraCost');
Route::get('/deleteExtra','FormTrans@deleteExtra');
Route::get('/addTask', 'FormTrans@addTask');
Route::get('/editTask', 'FormTrans@editTask');
Route::get('/deleteTask', 'FormTrans@deleteTask');
Route::get('/removeService', 'FormTrans@removeService');
Route::get('/removeStaff', 'FormTrans@removeStaff');

Route::get('/getFood', 'Transaction@getFood');
Route::get('/getPackageFood', 'Transaction@getPackageFood');
Route::get('/getCategory', 'Transaction@getCategory');
Route::get('/getPackage', 'Transaction@getPackage');
Route::get('/getService', 'Transaction@getService');
Route::get('/getServiceContact', 'Transaction@getServiceContact');
Route::get('/getMenuCatering', 'Transaction@getMenuCatering');
Route::get('/getServicesCatering', 'Transaction@getServicesCatering');
Route::get('/getInventoryCatering', 'Transaction@getInventoryCatering');
Route::get('/getTask', 'Transaction@getTask');
Route::get('/getExtraCost', 'Transaction@getExtraCost');
Route::get('/getStaff', 'Transaction@getStaff');
Route::get('/getEquipments', 'Transaction@getEquipments');
Route::get('/getPayment', 'Transaction@getPayment');
Route::get('/getEventNow', 'Transaction@getEventNow');

Route::get('Admin/Transaction/Food-Order', 'Transaction@FoodOrder');
Route::post('/addFoodOrder', 'FormTrans@addFoodOrder');
Route::post('/editFoodOrder', 'FormTrans@editFoodOrder');
Route::post('/deleteFoodOrder', 'FormTrans@deleteFoodOrder');
//------------------------------INVENTORY-------------------------------------------------------//

Route::get('Admin/Inventory/EquipmentInventory', 'Inventory@Inventory');
Route::get('/retrieveEquipment', 'Inventory@retrieveEquipment');
Route::get('/validateEquipmentInventory', 'Inventory@validateEquipmentInventory');
Route::post('/addEquipmentInventory', 'FormInvntry@addEquipmentInventory');
Route::post('/editEquipmentInventory', 'FormInvntry@editEquipmentInventory');
Route::post('/deleteEquipmentInventory', 'FormInvntry@deleteEquipmentInventory');

Route::get('Admin/Maintenance/EquipmentType', 'Inventory@EquipmentType');
Route::get('/retrieveEquipmentType', 'Inventory@retrieveEquipmentType');
Route::get('/validateEquipmentType', 'Inventory@validateEquipmentType');
Route::post('/addEquipmentType', 'FormInvntry@addEquipmentType');
Route::post('/editEquipmentType', 'FormInvntry@editEquipmentType');
Route::post('/deleteEquipmentType', 'FormInvntry@deleteEquipmentType');

Route::get('Admin/Inventory/Transfers', 'Inventory@Transfers');
Route::post('/addTransfer', 'FormInvntry@addTransfer');
Route::post('/editTransfer', 'FormInvntry@editTransfer');
Route::post('/deleteTransfer', 'FormInvntry@deleteTransfer');
Route::post('/receiveTransfers', 'FormInvntry@receiveTransfer');

Route::get('Admin/Inventory/Supplier', 'Inventory@Supplier');
Route::get('/retrieveSupplier', 'Inventory@retrieveSupplier');
Route::post('/addSupplier', 'FormInvntry@addSupplier');
Route::post('/editSupplier', 'FormInvntry@editSupplier');
Route::post('/deleteSupplier', 'FormInvntry@deleteSupplier');

Route::get('Admin/Inventory/Checklist', 'Inventory@Checklist');
Route::get('/getChecklist', 'Inventory@getChecklist');
Route::post('/saveChecklist', 'FormInvntry@saveChecklist');


//-----------------------------MAINTENANCE----------------------------------------------------//

	Route::get('Admin/Maintenance/Submenu', 'Maintenance@Submenu');
	Route::get('/retrieveSubmenu', 'Maintenance@retrieveSubmenu');
	Route::get('/validateSubmenu', 'Maintenance@validateSubmenu');
	Route::get('/changeSubmenuStatus', 'Maintenance@changeSubmenuStatus');
	Route::post('/addSubmenu', 'FormMntnc@addSubmenu');
	Route::post('/editSubmenu', 'FormMntnc@editSubmenu');
	Route::post('/deleteSubmenu', 'FormMntnc@deleteSubmenu');

	// Route::get('Admin/Maintenance/SubmenuCategory', 'Maintenance@SubmenuCategory');
	Route::get('/retrieveCategory', 'Maintenance@retrieveSubmenuCategory');
	Route::get('/validateCategory', 'Maintenance@validateSubmenuCategory');
	Route::post('/addSubmenuCategory', 'FormMntnc@addSubmenuCategory');
	Route::post('/editSubmenuCategory', 'FormMntnc@editSubmenuCategory');
	Route::post('/deleteSubmenuCategory', 'FormMntnc@deleteSubmenuCategory');

	Route::get('Admin/Maintenance/Package', 'Maintenance@Package');
	Route::get('/retrievePackage', 'Maintenance@retrievePackage');
	Route::get('/retrieveSelected', 'Maintenance@retrieveSelected');
	Route::get('/validatePackage', 'Maintenance@validatePackage');
	Route::get('/changePackageStatus', 'Maintenance@changePackageStatus');
	Route::post('/addPackage', 'FormMntnc@addPackage');
	Route::post('/editPackage', 'FormMntnc@editPackage');
	Route::post('/deletePackage', 'FormMntnc@deletePackage');

	Route::get('Admin/Maintenance/Services', 'Maintenance@Services');
	Route::get('/retrieveServices', 'Maintenance@retrieveServices');
	Route::get('/validateServices', 'Maintenance@validateServices');
	Route::post('/addServices', 'FormMntnc@addServices');
	Route::post('/editServices', 'FormMntnc@editServices');
	Route::post('/deleteServices', 'FormMntnc@deleteServices');

	// Route::get('Admin/Maintenance/ServiceContact', 'Maintenance@ServiceContact');
	Route::get('/retrieveServiceContact', 'Maintenance@retrieveServiceContact');
	Route::get('/validateServiceContact', 'Maintenance@validateServiceContact');
	Route::post('/addServiceContact', 'FormMntnc@addServiceContact');
	Route::post('/editServiceContact', 'FormMntnc@editServiceContact');
	Route::post('/deleteServiceContact', 'FormMntnc@deleteServiceContact');

	Route::get('Admin/Maintenance/Profession', 'Maintenance@Profession');
	Route::get('/retrieveProfession', 'Maintenance@retrieveProfession');
	Route::get('/validateProfession', 'Maintenance@validateProfession');
	Route::post('/addProfession', 'FormMntnc@addProfession');
	Route::post('/editProfession', 'FormMntnc@editProfession');
	Route::post('/deleteProfession', 'FormMntnc@deleteProfession');

	Route::get('Admin/Maintenance/Staff', 'Maintenance@Staff');
	Route::get('/retrieveStaff', 'Maintenance@retrieveStaff');
	// Route::get('/validateCategory', 'Maintenance@validateSubmenuCategory');
	Route::post('/addStaff', 'FormMntnc@addStaff');
	Route::post('/editStaff', 'FormMntnc@editStaff');
	Route::post('/deleteStaff', 'FormMntnc@deleteStaff');

	Route::get('Admin/Maintenance/Location', 'Maintenance@Location');
	Route::get('/retrieveLocation', 'Maintenance@retrieveLocation');
	Route::get('/validateLocation', 'Maintenance@validateLocation');
	Route::post('/addLocation', 'FormMntnc@addLocation');
	Route::post('/editLocation', 'FormMntnc@editLocation');
	Route::post('/deleteLocation', 'FormMntnc@deleteLocation');

Route::get('/dashboardTable-add', 'HomeController@dashboardTable');
//website ajax
	Route::get('/wgetFood', 'WebsiteController@wgetFood');
	Route::get('/dashboardOut', 'HomeController@dashboardOUt');
	Route::get('/dashboardIn', 'HomeController@dashboardIn');
Route::get('/login', function(){
	return redirect('/Admin');
});
