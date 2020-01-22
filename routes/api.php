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

    // Route::get('users', 'Utilities\UsersController@index');
    
    // Route::get('user/{id}', 'Utilities\UsersController@show');

    // Route::post('user', 'Utilities\UsersController@create');
  
    // Route::put('user/{id}', 'Utilities\UsersController@update');
    
    // Route::put('user/delete/{id}', 'Utilities\UsersController@delete');
  
    // Route::get('usercheck/{id}', 'Utilities\UsersController@checkIfUsed');

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
    

     Route::get('clients', 'References\ClientlistsController@index');
  
  

    
});