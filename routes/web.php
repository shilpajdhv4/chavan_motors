
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/','Auth\LoginController@showLoginForm');

Route::get('branch-login','Auth\BranchLoginController@showLoginForm');
Route::post('branch-login','Auth\BranchLoginController@login')->name('branch-login');

Route::get('bpo-login','Auth\BPOAdminLoginController@showLoginForm');
Route::post('bpo-login','Auth\BPOAdminLoginController@login')->name('bpo-login');

Route::get('bpo-user-login','Auth\BPOUserLogincontroller@showLoginForm');
Route::post('bpo-user-login','Auth\BPOUserLogincontroller@login')->name('bpo-user-login');

Route::get('sales-admin-login','Auth\SalesExecutiveAdminLogincontroller@showLoginForm');
Route::post('sales-admin-login','Auth\SalesExecutiveAdminLogincontroller@login')->name('sales-admin-login');

Route::get('sales-login','Auth\SalesExecutiveLogincontroller@showLoginForm');
Route::post('sales-login','Auth\SalesExecutiveLogincontroller@login')->name('sales-login');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::resource('products','ProductController');
    Route::get('upload_csv','CallDetailController@index');
    Route::post('upload_csv','CallDetailController@saveDesign');
    Route::get('download_uploaded_csv','CallDetailController@getUploadecsv');
    //Add Location
    Route::get('enq_location_list','LocationController@listLocation');
    Route::get('enq_location_add','LocationController@addLocation');
    Route::post('enq_location_save','LocationController@saveLocation');
    Route::get('enq-location-edit','LocationController@editLocation');
    Route::post('enq_location_update','LocationController@updateLocation');
    Route::get('enq-location-delete/{id}','LocationController@deleteLocation');
    
    //Add Branch    
    Route::get('branch_list','BranchController@listBranch');
    Route::get('branch_add','BranchController@addBranch');
    Route::post('branch_save','BranchController@saveBranch');
    Route::get('branch_edit','BranchController@editBranch');
    Route::post('branch_update','BranchController@updateBranch');
    Route::get('branch_delete/{id}','BranchController@deleteBranch');
    
    //BPO Admin
    Route::get('data_set_list','BPOAdminController@getList');
    Route::post('data_set_list','BPOAdminController@saveStatus');
    Route::get('download_set_list','BPOAdminController@downloadDataset');
    
    //BPO User
    Route::get('customer_detail','BPOUserController@getDetail');
    Route::post('update_customer_detail','BPOUserController@updateDetails');
    
    //Branch Admin
    Route::get('call_detail_updated_status','CallDetailController@showCallDetailUpdatedstatus');
    Route::get('assign_data_sales_executive','CallDetailController@assignData');
    Route::post('update_tl_data','CallDetailController@updateAssign');
    
    //Team Leader
    Route::get('get_tl_data','TeamLeaderController@getTeamLeaderData');
    Route::post('update_dse_data1','TeamLeaderController@updateAssign');
    
    //DSE Leader
    Route::get('get_dse_data','DSEController@getDSEdata');
    Route::post('update_dse_data','DSEController@updateDetails');
    
    Route::get('mobile-validate','HomeController@validateMobile');
});
