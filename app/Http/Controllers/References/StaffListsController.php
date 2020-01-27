<?php

namespace App\Http\Controllers\References;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User; // model of table
use App\Usertype;
use App\Http\Resources\Reference; //required always for json encoding
use Carbon\Carbon; //data
use Illuminate\Support\Facades\Validator; //validation
use Auth;
use App\Models\References\Department;
use Illuminate\Support\Facades\Hash;
use DB;
 
class StaffListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data['staffs'] = User::select(
            'b_users.*',
            'rd.department_name',
            'rd.department_id',
            'ru.user_type_id'

)
                    ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'b_users.department_id')
                    ->leftJoin('refusertype as ru', 'ru.user_type_id', '=', 'b_users.user_type_id')
                    ->where('b_users.is_deleted', 0)
                    ->where('b_users.user_type_id', 2) // 2 kasi staff ya
                    ->orderBy('user_id', 'asc')
                    ->get();

        $data['departments'] = Department::where('is_deleted', 0)->where('user_type', 1)->orderBy('department_id')->get();


        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *i
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

    $staff = new User();
    $staff->account_no = DB::select("select CreateAccountNo() as account_no")[0]->account_no;
    $staff->id_number = $request->input('id_number');
    $staff->firstname = $request->input('firstname');
    $staff->middlename = $request->input('middlename');
    $staff->lastname = $request->input('lastname');
    $staff->contact_number = $request->input('contact_number');
    $staff->department_id = $request->input('department_id');
    $staff->username = $request->input('username');
    $staff->password = Hash::make($request->input('password'));
    $staff->user_type_id = 2;
    $staff->created_datetime = Carbon::now();
    $staff->created_by = Auth::user()->user_id;

    $staff->save();

    //return json based from the resource data
    return ( new Reference( $staff ))
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
        $staff = User::findOrFail($id);

        return ( new Reference( $staff ) )
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
        $staff = User::findOrFail($id);
        
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
    $staff->user_type_id = $request->input('2');
    $staff->id_number = $request->input('id_number');
    $staff->firstname = $request->input('firstname');
    $staff->middlename = $request->input('middlename');
    $staff->lastname = $request->input('lastname');
    $staff->contact_number = $request->input('contact_number');
    $staff->department_id = $request->input('department_id');
    $staff->username = $request->input('username');
    $staff->password = Hash::make($request->input('password'));
    $staff->created_datetime = Carbon::now();
    $staff->created_by = Auth::user()->user_id;
    $staff->modified_datetime = Carbon::now();
    $staff->modified_by = Auth::user()->user_id;

    $staff->save();

    //return json based from the resource data
    return ( new Reference( $staff ))
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
        $staff = User::findOrFail($id);

        $staff->is_deleted = 1;
        $staff->deleted_datetime = Carbon::now();
        $staff->deleted_by = Auth::user()->user_id;

        //update classification based on the http json body that is sent
        $staff->save();

        return ( new Reference( $staff ) )
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

        // if(ContractInfo::where('staff_id', '=', $id)
        //     ->where('is_deleted', 0)
        //     ->exists()) {
        //     $exists = 'true';
        // }
        return $exists;
    }
}
