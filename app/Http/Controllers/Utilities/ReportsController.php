<?php

namespace App\Http\Controllers\Utilities;

use Illuminate\Http\Request;
use App\Models\Utilities\Report; // model of table
use App\Models\References\Department;
use App\Models\References\Part;
use App\Http\Controllers\Controller;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use App\User;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ClientReport()
    {

        
        $data['reports'] = Report::select(
            'tb_reports.*',
            'bu.firstname' , 
            'rdf.department_name',
            'bu.account_no',
            'rs.status_name'
            
 )
                    ->leftJoin('refdepartment as rdf', 'rdf.department_id', '=', 'tb_reports.from_department')
                    ->leftJoin('b_users as bu', 'bu.user_id', '=', 'tb_reports.from_user')
                    ->leftJoin('report_status as rs', 'rs.status_id', '=', 'tb_reports.status_id')
                    ->where('tb_reports.is_cancel', 0)
                    ->where('tb_reports.from_user', Auth::user()->user_id)
                    ->orderBy('report_id', 'asc')
                    ->get();

        $data['departments'] = Department::where('is_deleted', 0)->where('user_type', 1)
        ->orderBy('department_id')->get();
        $data['parts'] = Part::where('is_deleted', 0)
        ->orderBy('department_id')->get();
        return $data;


    }

    public function StaffReport()
    {

        
        $data['reports'] = Report::select(
            'tb_reports.*',
            'bu.firstname' , 
            'rdf.department_name',
            'bu.account_no',
            'rs.status_name'
            
 )
                    ->leftJoin('refdepartment as rdf', 'rdf.department_id', '=', 'tb_reports.from_department')
                    ->leftJoin('b_users as bu', 'bu.user_id', '=', 'tb_reports.from_user')
                    ->leftJoin('report_status as rs', 'rs.status_id', '=', 'tb_reports.status_id')
                    ->where('tb_reports.need_department', Auth::user()->department_id)
                    ->where('tb_reports.is_cancel', 0)
                    ->orderBy('report_id', 'asc')
                    ->get();

        return $data;


    }

    public function Dashboard()
    {

        
        $data['dashboards'] = Report::select(
            'tb_reports.*',
            'bu.firstname' , 
            'rdf.department_name',
            'bu.account_no',
            'rs.status_name',
            'rsituation.situation_name'
            
 )
                    ->leftJoin('refdepartment as rdf', 'rdf.department_id', '=', 'tb_reports.from_department')
                    ->leftJoin('b_users as bu', 'bu.user_id', '=', 'tb_reports.from_user')
                    ->leftJoin('report_status as rs', 'rs.status_id', '=', 'tb_reports.status_id')
                    ->leftJoin('report_situation as rsituation', 'rsituation.situation_id', '=', 'tb_reports.situation_id')
                    ->where('tb_reports.is_cancel', 0)
                    ->orderBy('report_id', 'asc')
                    ->get();

        $data['departments'] = Department::where('is_deleted', 0)->where('user_type', 1) ->orderBy('department_id')->get();
        $data['accounts'] = count(User::where('is_deleted', 0)->get());
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
            'need_department' => 'required'
        ]
    )->validate();
    

    $report = new Report();
    $report->report_name = $request->input('report_name');
    $report->need_department = $request->input('need_department');
    $report->what_part = $request->input('what_part');
    $report->situation_id = $request->input('situation_id');
    $report->report_remarks = $request->input('report_remarks');
    $report->send_datetime = Carbon::now();
    $report->from_user = Auth::user()->user_id;
    $report->from_department = Auth::user()->department_id;
    $report->status_id = 0;
    $report->save();

    $data = Report::select(
            'tb_reports.*',
            'bu.firstname' , 
            'rdf.department_name',
            'bu.account_no',
            'rs.status_name'
            
         )
                    ->leftJoin('refdepartment as rdf', 'rdf.department_id', '=', 'tb_reports.from_department')
                    ->leftJoin('b_users as bu', 'bu.user_id', '=', 'tb_reports.from_user')
                    ->leftJoin('report_status as rs', 'rs.status_id', '=', 'tb_reports.status_id')
                    ->findOrFail($report->report_id);

    
    //return json based from the resource data
    return ( new Reference( $data ))
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
           
         $report = Report::findOrFail($id);

        return ( new Reference( $report ) )
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
    public function UpdateReport(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        
        Validator::make($request->all(),
        [
            'report_name' => 'required',
            'need_department' => 'required',
            'what_part' => 'required'
        ]
    )->validate();
    


    $report->report_name = $request->input('report_name');
    $report->need_department = $request->input('need_department');
    $report->what_part = $request->input('what_part');
    $report->situation_id = $request->input('situation_id');
    $report->report_remarks = $request->input('report_remarks');


    $report->save();


        return ( new Reference( $report ) )
            ->response()
            ->setStatusCode(200);
      
    }

    /**
     * Update the specified resource in storage for deleting.
     * preventing force delete rather update the is_deleted = true
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function CancelReport($id)
    {
        $report = Report::findOrFail($id);

        $report->is_cancel = 1;
        $report->status_id = 3;
        $report->cancel_datetime = Carbon::now();
     
        $report->save();

        return ( new Reference( $report ) )
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

      public function AcceptingReport($id)
      
    {
        $report = Report::findOrFail($id);

        $report->status_id = 1;
        $report->accept_datetime = Carbon::now();
        $report->accept_department = Auth::user()->department_id;
        $report->accept_user = Auth::user()->user_id;
        //update classification based on the http json body that is sent
        $report->save();

        $data = Report::select(
            'tb_reports.*',
            'bu.firstname' , 
            'rdf.department_name',
            'bu.account_no',
            'rs.status_name'
            
         )
                    ->leftJoin('refdepartment as rdf', 'rdf.department_id', '=', 'tb_reports.from_department')
                    ->leftJoin('b_users as bu', 'bu.user_id', '=', 'tb_reports.from_user')
                    ->leftJoin('report_status as rs', 'rs.status_id', '=', 'tb_reports.status_id')
                    ->findOrFail($report->report_id);

    
    //return json based from the resource data
    return ( new Reference( $data ))
            ->response()
            ->setStatusCode(201);

            

            /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    }

     public function Markdone($id)
      
    {
        $report = Report::findOrFail($id);

        $report->status_id = 2;
        $report->done_datetime = Carbon::now();

        //update classification based on the http json body that is sent
        $report->save();

        return ( new Reference( $report ) )
            ->response()
            ->setStatusCode(200);

            /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    }
    public function destroy($id)
    {
        //
    }
    
   
}
