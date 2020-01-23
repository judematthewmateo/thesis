<?php

namespace App\Http\Controllers\Utilities;

use Illuminate\Http\Request;
use App\Models\Utilities\Report; // model of table
use App\Models\References\Department;
use App\Http\Controllers\Controller;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['reports'] = Report::select(
            'tb_reports.*',
            'bu.firstname' , 
             'rd.department_name',
            'bu.account_no',
            'rs.status_name'
            
 )
                    ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'tb_reports.department_id')
                    ->leftJoin('b_users as bu', 'bu.user_id', '=', 'tb_reports.user_id')
                    ->leftJoin('report_status as rs', 'rs.status_id', '=', 'tb_reports.status_id')
                    ->where('tb_reports.is_deleted', 0)
                    ->where('tb_reports.status_id', 0)
                    
                    ->orderBy('report_id', 'asc')
                    ->get();

        

       
       
        $data['departments'] = Department::where('is_deleted', 0)->where('user_type', 1)
        
        ->orderBy('department_id')->get();

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
            'report_name' => 'required',
            'department_id' => 'required'
        ]
    )->validate();

    $report = new Report();
    $report->report_name = $request->input('report_name');
    $report->department_id = $request->input('department_id');
    $report->situation = $request->input('situation');
    $report->send_datetime = Carbon::now();
    $report->user_id = Auth::user()->user_id;

    $report->save();

    //return json based from the resource data
    return ( new Reference( $report ))
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

      
    }

    /**
     * Update the specified resource in storage for deleting.
     * preventing force delete rather update the is_deleted = true
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
  
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
    public function CurriculumSubjects($id)
    {
        $reports = Report::select('b_users.*',
            'b_users.*',
            'rd.department_name',
            'ru.user_type_id'

)
                    ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'b_users.department_id')
                    ->leftJoin('refusertype as ru', 'ru.user_type_id', '=', 'b_users.user_type_id')
                    
                    ->where('b_users.is_deleted', 0)
                    ->where('b_users.user_type_id', 1)
                    ->orderBy('user_id', 'desc')
                    ->get();
        
        return Reference::collection($reports);

    }

   
}
