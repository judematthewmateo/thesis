<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Utilities\Report;
use Mpdf\Mpdf;
use Auth;
use App\User;

class ReportsController extends Controller
{
    public function PrintReport($from_date, $to_date)
    {
        $data['reports'] = Report::select(
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
                    ->orderBy('report_id', 'asc');
        if($from_date != 0 || $to_date != 0)
        {
            $data['reports']->whereRaw('DATE(send_datetime) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")');
        }

        $data['reports'] = $data['reports']->get();

        $data['date_from'] = $from_date;
        $data['date_to'] = $to_date;

        $mpdf = new Mpdf();
        $content = view('reports.adminreport')->with($data);
        $mpdf->WriteHTML($content);
        $mpdf->Output();
    }

    public function ClientReportlogs($from_date, $to_date, $user_id)
    {

        
        // $data['firstname'] = User::findOrFail($user_id)->firstname;
        // $data['lastname'] = User::findOrFail($user_id)->lastname;

        $data['reports'] = Report::select(
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
                    ->where('tb_reports.from_user', $user_id)
                    ->orderBy('report_id', 'asc');
                    
        if($from_date != 0 || $to_date != 0)
        {
            $data['reports']->whereRaw('DATE(send_datetime) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")');
        }

        $data['reports'] = $data['reports']->get();

        // return $data['reports']->get();

        $data['date_from'] = $from_date;
        $data['date_to'] = $to_date;

        $mpdf = new Mpdf();
        $content = view('reports.clientreport')->with($data);
        $mpdf->WriteHTML($content);
        $mpdf->Output();
    }
     public function StaffReportlogs($from_date, $to_date, $user_id)
    {
        $data['reports'] = Report::select(
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
                    ->where('tb_reports.status_id', 2)
                    ->where('tb_reports.accept_user', $user_id)
                    ->orderBy('report_id', 'asc');
                    
        if($from_date != 0 || $to_date != 0)
        {
            $data['reports']->whereRaw('DATE(send_datetime) BETWEEN DATE("'.$from_date.'") AND DATE("'.$to_date.'")');
        }

        $data['reports'] = $data['reports']->get();

        // return $data['reports']->get();

        $data['date_from'] = $from_date;
        $data['date_to'] = $to_date;

        $mpdf = new Mpdf();
        $content = view('reports.staffreport')->with($data);
        $mpdf->WriteHTML($content);
        $mpdf->Output();
    }
}
