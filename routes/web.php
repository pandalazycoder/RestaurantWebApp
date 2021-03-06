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

//// normal business logic
//Route::get('/', function () {
//    return view('welcome');
//});

// just other business logic to disable register and foreget password
Route::get('/', 'HomeController@index');

Auth::routes(['register' => false, 'reset' => false]);


Route::get('/home', 'HomeController@index')->name('home');

// middleware to allow access for login user with the right role only

Route::middleware(['auth', 'VerifyAdmin'])->group(function () {
    Route::get('/management', function () {
        return view('management.index');
    });
    Route::resource('management/category', 'Management\CategoryController');
    Route::resource('management/menu', 'Management\MenuController');
    Route::resource('management/table', 'Management\TableController');
    Route::resource('management/user', 'Management\UserController');

    Route::get('/report', 'Report\ReportController@index');
    Route::get('/report/show', 'Report\ReportController@show');
    Route::get('/report/show/export', 'Report\ReportController@exportToExcel');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/cashier', 'Cashier\CashierController@index');
    Route::get('/cashier/getMenuByCategory/{category_id}', 'Cashier\CashierController@getMenuByCategory');
    Route::get('/cashier/gettable', 'Cashier\CashierController@getTable');
    Route::post('/cashier/orderFood', 'Cashier\CashierController@orderFood');
    Route::get('/cashier/getSaleDetailsByTable/{table_id}', 'Cashier\CashierController@getSaleDetailsByTable');
    Route::post('/cashier/confirmOrderStatus', 'Cashier\CashierController@confirmOrderStatus');
    Route::post('/cashier/deleteSaleDetail', 'Cashier\CashierController@deleteSaleDetail');
    Route::post('/cashier/savePayment', 'Cashier\CashierController@savePaymentInfo');
    Route::get('/cashier/showReceipt/{saleID}', 'Cashier\CashierController@showReceipt');

});

