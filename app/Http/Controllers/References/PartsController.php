<?php

namespace App\Http\Controllers\References;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\References\Part; // model of table
use App\Http\Resources\Reference; //required always for json encoding
use Carbon\Carbon; //data
use Illuminate\Support\Facades\Validator; //validation
use Auth;
 
class PartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $part = Part::where('is_deleted', 0)->orderBy('part_id', 'desc')->get();
        return Reference::collection($part);
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
            'part_code' => 'required',
            'part_name' => 'required'
        ]
    )->validate();

    $part = new Part();
    
    $part->part_code = $request->input('part_code');
    $part->part_name = $request->input('part_name');
    $part->part_desc = $request->input('part_desc');
    $part->department_id = $request->input('department_id');
    $part->created_datetime = Carbon::now();
    $part->created_by = Auth::user()->user_id;

    $part->save();

    //return json based from the resource data
    return ( new Reference( $part ))
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
        $part = Part::findOrFail($id);

        return ( new Reference( $part ) )
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
        $part = Part::findOrFail($id);
        
        Validator::make($request->all(),
        [
            'part_code' => 'required',
            'part_name' => 'required'
        ]
    )->validate();

    $part = new Part();
    
    $part->part_code = $request->input('part_code');
    $part->part_name = $request->input('part_name');
    $part->part_desc = $request->input('part_desc');
    $part->department_id = $request->input('department_id');
    $part->created_datetime = Carbon::now();
    $part->created_by = Auth::user()->user_id;
    $part->tech_id = 1;

    $part->save();

    //return json based from the resource data
    return ( new Reference( $part ))
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
        $part = Part::findOrFail($id);

        $part->is_deleted = 1;
        $part->deleted_datetime = Carbon::now();
        $part->deleted_by = Auth::user()->user_id;

        //update classification based on the http json body that is sent
        $part->save();

        return ( new Reference( $part ) )
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

        // if(ContractInfo::where('department_id', '=', $id)
        //     ->where('is_deleted', 0)
        //     ->exists()) {
        //     $exists = 'true';
        // }
        return $exists;
    }
}
