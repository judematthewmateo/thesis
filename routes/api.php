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


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// }); 
Route::middleware('auth:api')->group(function () {

    Route::get('dashboard/index/{payment_type}', 'References\DashboardController@index');
    Route::get('dashboard/payment/{payment_type}/{is_string}', 'References\DashboardController@getPaymentLine');

    Route::get('users', 'Utilities\UsersController@index');
    //List single category
    Route::get('user/{id}', 'Utilities\UsersController@show');
    //Create new category
    Route::post('user', 'Utilities\UsersController@create');
    //Update category
    Route::put('user/{id}', 'Utilities\UsersController@update');
    //Delete category
    Route::put('user/delete/{id}', 'Utilities\UsersController@delete');
    //Check if category was used
    Route::get('usercheck/{id}', 'Utilities\UsersController@checkIfUsed');

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
    
 
});