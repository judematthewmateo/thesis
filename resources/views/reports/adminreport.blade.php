<!DOCTYPE html>
<html>
    <head>
        <title>Reports</title>
        
        <style type="text/css" scope> 
            body{
                
                
            }
            table {
                font-size: 10pt!important;
                border-collapse: collapse;
                
            }
            tr:last-child td{
                border-bottom: 1px solid gray;
                border: 0px;    
                
            }
            td {
                border-right: 1px solid gray;
                border-left: 1px solid gray;
                padding-left: 5px;
                padding-right: 5px;
               
            }
            th {
                border: 1px solid gray;
                padding-left: 5px;
                padding-right: 5px;
               
            }
            @page {
                margin: 0.4in;
                border: 0px;
            }
            .logo{
			width: 130px;
			height: 130px;
			float: right;
			text-align: right;
            border: 0px;
            margin-top: -9%;
            /* margin-right: -7%;
            
            margin-left: 0%; */
		}
        table td.report_header{
            border: 0px;
			font-size: 11pt;
            
		}
        .top{
			border-top: 1px solid black;
            border-left: 0px !important;
            border-right:0px;
            margin-left: 5px;
          
		}
        .border{
            border: 0px;
        }
        .bottom {
            border-bottom: 1px solid black;
        }
       body{
			font-family: calibri;
		}
                
        </style>
    </head>
    <body>
        <table width="100%" >
        <tr class="border">
			
			<td colspan="4" class="header report_header" style="font-size: 24pt; font-family: Times new roman;">
				<h5><center>Our Lady of Fatima University</center></h5>
               <h6 style="font-size:10px;"><center>Valenzuela City * Quezon City * Antipolo City * Pampanga</center></h6>
			</td>

            <tr>
			<td  class="border">
				<img src="images/login/olfulogo1.png" class="logo">
			</td>
		 </tr>
      </tr> 
		<!-- <tr>
			<td colspan="4" class="border"  >&nbsp;</td>
		</tr> -->
        </table>
    
        <div>
		 &emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <a> Date Prepare :</a>  &emsp;{{date("Y-m-d")}}
        </div>
        
        <table style="font-size: 9pt; width: 100%; margin-top: 5px;">
            <thead>
                <tr>
                    <th style="text-align:left;">Report No.</th>
                    <th style="text-align:left;">Account Number</th>
                    <th style="text-align:left;">Send by</th>
                    <th style="text-align:left;">From Department</th>
                    <th style="text-align:left;">Send date/time</th>
                    <th style="text-align:left;">Status</th>
                    <th style="text-align:left;">Situation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                <tr>
                    <td style="text-align:left; width: 45px; {{$loop->last ? 'border-bottom: 1px solid gray' : ''}}">{{$report->report_id}}</td>
                    <td style="text-align:left; {{$loop->last ? 'border-bottom: 1px solid gray' : ''}}">{{$report->account_no}}</td>
                    <td style="text-align:left; {{$loop->last ? 'border-bottom: 1px solid gray' : ''}}">{{$report->firstname}}</td>
                    <td style="text-align:left; {{$loop->last ? 'border-bottom: 1px solid gray' : ''}}">{{$report->department_name}}</td>
                    <td style="text-align:left; {{$loop->last ? 'border-bottom: 1px solid gray' : ''}}">{{date("F j, Y, g:i a", strtotime($report->send_datetime))}}</td>
                    <td style="text-align:left; {{$loop->last ? 'border-bottom: 1px solid gray' : ''}}">{{$report->status_name}}</td>
                    <td style="text-align:left; {{$loop->last ? 'border-bottom: 1px solid gray' : ''}}">{{$report->situation_name}}</td>
                </tr>
                @endforeach
              </tr>
            
		</tr>
            </tbody>
            
        </table>    
        <table>
        <tr>
			<td class="border">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;***** NOTHING TO FOLLOW *****</td>
            
		</tr>
        </table>
         <br>
         <br>
         <br>

           <table>
		<tr>
			<td class="top" >&emsp;&emsp;&emsp;Prepared by : &emsp;&emsp;</td>
            
		</tr>
				
		
	</table>
    </body>
</html>
