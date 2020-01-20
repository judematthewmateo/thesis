<?php

namespace App\Http\Controllers\References;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Utilities\Staff; // model of table
use App\Http\Resources\Reference; //required always for json encoding
use Carbon\Carbon; //data
use Illuminate\Support\Facades\Validator; //validation
use Auth;
use App\Models\References\Department;
 
class StaffsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data['staffs'] = Staff::select(
            'tb_staffs.*',
            'rd.department_name'
)
                    ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'tb_staffs.department_id')
                    ->where('tb_staffs.is_deleted', 0)
                    ->orderBy('staff_id', 'desc')
                    ->get();

        $data['departments'] = Department::where('is_deleted', 0)->orderBy('department_id')->get();

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
           
            'staff_name' => 'required'
        ]
    )->validate();

    $staff = new Staff();
  
    $staff->staff_name = $request->input('staff_name');
    $staff->staff_desc = $request->input('staff_desc');
    $staff->sort_key = $request->input('sort_key');
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
        $staff = Staff::findOrFail($id);

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
        $staff = Staff::findOrFail($id);
        
        Validator::make($request->all(),
            [
                'staff_name' => 'required'
            ]
        )->validate();

        
      
        $staff->staff_name = $request->input('staff_name');
        $staff->staff_desc = $request->input('staff_desc');
        $staff->sort_key = $request->input('sort_key');
        $staff->modified_datetime = Carbon::now();
        $staff->modified_by = Auth::user()->user_id;


        //update  based on the http json body that is sent
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


    public function delete($id)
    {   
        $staff = Client::findOrFail($id);

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
