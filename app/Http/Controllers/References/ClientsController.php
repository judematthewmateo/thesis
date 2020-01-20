<?php

namespace App\Http\Controllers\References;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Utilities\Client; // model of table
use App\Http\Resources\Reference; //required always for json encoding
use Carbon\Carbon; //data
use Illuminate\Support\Facades\Validator; //validation
use Auth;
use App\Models\References\Department;
 
class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data['clients'] = Client::select(
            'tb_clients.*',
            'rd.department_name'
)
                    ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'tb_clients.department_id')
                    ->where('tb_clients.is_deleted', 0)
                    ->orderBy('client_id', 'desc')
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
           
            'client_name' => 'required'
        ]
    )->validate();

    $client = new Staff();
  
    $client->client_name = $request->input('client_name');
    $client->client_desc = $request->input('client_desc');
    $client->sort_key = $request->input('sort_key');
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
        $client = Staff::findOrFail($id);

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
                'client_name' => 'required'
            ]
        )->validate();

        
      
        $client->client_name = $request->input('client_name');
        $client->client_desc = $request->input('client_desc');
        $client->sort_key = $request->input('sort_key');
        $client->modified_datetime = Carbon::now();
        $client->modified_by = Auth::user()->user_id;


        //update  based on the http json body that is sent
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
