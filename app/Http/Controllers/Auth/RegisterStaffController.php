<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Utilities\Staff;
use App\Http\Resources\Reference; //required always for json encoding
use Carbon\Carbon; //data
use Illuminate\Support\Facades\Validator; //validation


 
class RegisterStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $registerstaff = RegisterStaff::where('is_deleted', 0)->get();                           
        // return Reference::collection($registerstaff);
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
                'username' => 'required|string|max:255|unique:tb_users',
                'password' => 'required|string|min:6|confirmed',
                'contact_number' => '|min:11|max:11|confirmed',
              
            ]
        )->validate();

        $registerstaff = new RegisterStaff();
        $registerstaff->account_no = DB::select("select CreateAccountNo() as account_no")[0]->account_no;
        $registerstaff->username = $request->input('username');
        $registerstaff->password = Hash::make($request->input('password'));
        $registerstaff->staff_name = $request->input('staff_name');
        $registerstaff->contact_number = $request->input('contact_number');
        $registerstaff->department_id = $request->input('department_id');
        $registerstaff->user_type_id = $request->input('user_type_id');
         $registerstaff->id_number = $request->input('id_number');
        $registerstaff->created_datetime = Carbon::now();
        $registerstaff->created_by = Auth::user()->id;

        $registerstaff->save();

        //return json based from the resource data
        return ( new Reference( $registerstaff ))
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
        $registerstaff = RegisterStaff::findOrFail($id);

        return ( new Reference( $registerstaff ) )
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
        // $department = Department::findOrFail($id);
        
        // Validator::make($request->all(),
        //     [
        //         'department_code' => 'required',
        //         'department_name' => 'required'
        //     ]
        // )->validate();

        
        // $department->department_code = $request->input('department_code');
        // $department->department_name = $request->input('department_name');
        // $department->department_desc = $request->input('department_desc');
        // $department->sort_key = $request->input('sort_key');
        // $department->modified_datetime = Carbon::now();
        // $department->modified_by = Auth::user()->user_id;


        // //update  based on the http json body that is sent
        // $department->save();

        // return ( new Reference( $department ) )
        //     ->response()
        //     ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function delete($id)
    {   
        // $department = Department::findOrFail($id);

        // $department->is_deleted = 1;
        // $department->deleted_datetime = Carbon::now();
        // $department->deleted_by = Auth::user()->user_id;

        // //update classification based on the http json body that is sent
        // $department->save();

        // return ( new Reference( $department ) )
        //     ->response()
        //     ->setStatusCode(200);
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

        // if(ContractInfo::where('department_id', '=', $id)
        //     ->where('is_deleted', 0)
        //     ->exists()) {
        //     $exists = 'true';
        // }
        return $exists;
    }
}
