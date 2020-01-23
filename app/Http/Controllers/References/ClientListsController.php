<?php

namespace App\Http\Controllers\References;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User; // model of table
use App\Http\Resources\Reference; //required always for json encoding
use Carbon\Carbon; //data
use Illuminate\Support\Facades\Validator; //validation
use Auth;
use App\Models\References\Department;
use App\Usertype;
use Illuminate\Support\Facades\Hash;
use DB;
 
class ClientListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
     {
       $data['clients'] = User::select(
            'b_users.*',
            'rd.department_name',
            'ru.user_type_id'

)
                    ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'b_users.department_id')
                    ->leftJoin('refusertype as ru', 'ru.user_type_id', '=', 'b_users.user_type_id')
                    ->where('b_users.is_deleted', 0)
                    ->where('b_users.user_type_id', 3)
                    ->orderBy('user_id', 'asc')
                    ->get();

        $data['departments'] = Department::where('is_deleted', 0)->where('user_type', 0)->orderBy('department_id')->get();

     
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       Validator::make($request->all(),
        [
            'id_number' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'department_id' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]
    )->validate();

    $client = new User();
    $client->account_no = DB::select("select CreateAccountNo() as account_no")[0]->account_no;
    $client->id_number = $request->input('id_number');
    $client->firstname = $request->input('firstname');
    $client->middlename = $request->input('middlename');
    $client->lastname = $request->input('lastname');
    $client->contact_number = $request->input('contact_number');
    $client->department_id = $request->input('department_id');
    $client->username = $request->input('username');
    $client->password = Hash::make($request->input('password'));
    $client->created_datetime = Carbon::now();
    $client->created_by = Auth::user()->user_id;

    $client->save();

    //return json based from the resource data
    return ( new Reference( $client ))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = User::findOrFail($id);

        return ( new Reference( $client ) )
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Staff::findOrFail($id);
        
        Validator::make($request->all(),
        [
            'id_number' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'department_id' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]
    )->validate();

    $client = new User();
    $client->account_no = DB::select("select CreateAccountNo() as account_no")[0]->account_no;
    $client->id_number = $request->input('id_number');
    $client->firstname = $request->input('firstname');
    $client->middlename = $request->input('middlename');
    $client->lastname = $request->input('lastname');
    $client->contact_number = $request->input('contact_number');
    $client->department_id = $request->input('department_id');
    $client->username = $request->input('username');
    $client->password = Hash::make($request->input('password'));
    $client->created_datetime = Carbon::now();
    $client->created_by = Auth::user()->user_id;

    $client->save();

    //return json based from the resource data
    return ( new Reference( $client ))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function delete($id)
    {   
        $client = Client::findOrFail($id);

        $client->is_deleted = 1;
        $client->deleted_datetime = Carbon::now();
        $client->deleted_by = Auth::user()->user_id;

        //update classification based on the http json body that is sent
        $client->save();

        return ( new Reference( $client ) )
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function checkIfUsed($id)
    {
        $exists = 'false';

        // if(ContractInfo::where('client_id', '=', $id)
        //     ->where('is_deleted', 0)
        //     ->exists()) {
        //     $exists = 'true';
        // }
        return $exists;
    }
}
