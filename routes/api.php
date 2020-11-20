<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
    Route::get('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');

});

 
Route::middleware('auth:api')->group(function () {

    Route::get('dashboard/index/{payment_type}', 'References\DashboardController@index');
    Route::get('dashboard/payment/{payment_type}/{is_string}', 'References\DashboardController@getPaymentLine');



    //List Departments
    Route::get('products', 'Controller\ProductsController@index');
    Route::get('sohr', 'Controller\OrdersController@index');
    Route::post('soln', 'Controller\OrdersController@index');
    Route::put('products/delete/{id}', 'Controller\ProductsController@delete');
    Route::put('products/{id}', 'Controller\ProductsController@update');
    Route::get('products/{id}', 'Controller\ProductsController@show');
    Route::put('acceptneworder/delete/{id}', 'Controller\OrdersController@AcceptNewOrder');
    Route::put('declineneworder/delete/{id}', 'Controller\OrdersController@DeclineNewOrder');
    Route::put('acceptintransit/{id}', 'Controller\OrdersController@AcceptIntransit');
    Route::put('delivered/delete/{id}', 'Controller\OrdersController@Delivered');


    //List single department
    Route::get('department/{id}', 'References\DepartmentsController@show');
    //Create new department
    Route::post('products', 'Controller\ProductsController@create');
    //Update department
    Route::put('department/{id}', 'References\DepartmentsController@update');
    //Delete department
    
    //Check if department was used
    Route::get('departmentcheck/{id}', 'References\DepartmentsController@checkIfUsed');
    // END departments

     //List parts
    Route::get('parts', 'References\PartsController@index');
    //List single parts
    Route::get('part/{id}', 'References\PartsController@show');
    //Create new parts
    Route::post('part', 'References\PartsController@create');
    //Update parts
    Route::put('part/{id}', 'References\PartsController@update');
    //Delete parts
    Route::put('part/delete/{id}', 'References\PartsController@delete');
    //Check if parts was used
    Route::get('partcheck/{id}', 'References\PartsController@checkIfUsed');
    // END parts


    Route::get('staffreports', 'Utilities\ReportsController@StaffReport');

    Route::get('clientreports', 'Utilities\ReportsController@ClientReport');
   
    Route::get('dashboards', 'Utilities\ReportsController@Dashboard');


    // pag send ng report
    Route::post('clientreport', 'Utilities\ReportsController@create');

    Route::put('clientreport/delete/{id}', 'Utilities\ReportsController@CancelReport');

    Route::put('clientreport/{id}', 'Utilities\ReportsController@UpdateReport');

    Route::get('clientreport/{id}', 'Utilities\ReportsController@show');

    Route::get('staffreport/{id}', 'Utilities\ReportsController@show');

    Route::put('staffaccept/delete/{id}', 'Utilities\ReportsController@AcceptingReport');

    Route::put('staffmarkdone/delete/{id}', 'Utilities\ReportsController@Markdone');


  
   Route::get('staffs', 'References\StafflistsController@index');

    Route::get('staff/{id}', 'References\StafflistsController@show');

    Route::post('staff', 'References\StafflistsController@create');
  
    Route::put('staff/{id}', 'References\StafflistsController@update');
    
    Route::put('staff/delete/{id}', 'References\StafflistsController@delete');
  
    Route::get('staffcheck/{id}', 'References\StafflistsController@checkIfUsed');


    Route::get('clientlists', 'References\ClientlistsController@index');

    Route::get('clientlist/{id}', 'References\ClientlistsController@show');

    Route::post('clientlist', 'References\ClientlistsController@create');

    Route::put('clientlist/{id}', 'References\ClientlistsController@update');
    
    Route::put('clientlist/delete/{id}', 'References\ClientlistsController@delete');
  
    Route::get('clientlistcheck/{id}', 'References\ClientlistsController@checkIfUsed');

    
});

// Route::get('reports/printreport/{from}/{to}', 'Reports\ReportsController@PrintReport');
// Route::get('reports/clientreportlogs/{from}/{to}/{user_id}', 'Reports\ReportsController@ClientReportlogs');
// Route::get('reports/staffreportlogs/{from}/{to}/{user_id}', 'Reports\ReportsController@StaffReportlogs');