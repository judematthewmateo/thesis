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
    Route::get('departments', 'References\DepartmentsController@index');
    //List single department
    Route::get('department/{id}', 'References\DepartmentsController@show');
    //Create new department
    Route::post('department', 'References\DepartmentsController@create');
    //Update department
    Route::put('department/{id}', 'References\DepartmentsController@update');
    //Delete department
    Route::put('department/delete/{id}', 'References\DepartmentsController@delete');
    //Check if department was used
    Route::get('departmentcheck/{id}', 'References\DepartmentsController@checkIfUsed');
    // END departments



    Route::get('reports', 'Utilities\ReportsController@index');
    // Route::get('reports/{id}', 'Utilities\ReportsController@index');

    // pag send ng report
    Route::post('client', 'Utilities\ReportsController@create');
    


  
   Route::get('staffs', 'References\StafflistsController@index');

    Route::get('staff/{id}', 'References\StafflistsController@show');

    Route::post('staff', 'References\StafflistsController@create');
  
    Route::put('staff/{id}', 'References\StafflistsController@update');
    
    Route::put('staff/delete/{id}', 'References\StafflistsController@delete');
  
    Route::get('staffcheck/{id}', 'References\StafflistsController@checkIfUsed');


    Route::get('clients', 'References\ClientlistsController@index');

    Route::get('client/{id}', 'References\ClientlistsController@show');

    Route::post('client', 'References\ClientlistsController@create');

    Route::put('client/{id}', 'References\ClientlistsController@update');
    
    Route::put('client/delete/{id}', 'References\ClientlistsController@delete');
  
    Route::get('clientcheck/{id}', 'References\ClientlistsController@checkIfUsed');

    
});