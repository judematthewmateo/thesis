<?php

namespace App\Http\Controllers\Utilities;

use Illuminate\Http\Request;
use App\Models\Utilities\Client; // model of table
use App\Http\Controllers\Controller;
use App\Models\References\Department;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['reports'] = Client::select(
            'tb_reports.*',
            'rd.department_name'
 )
                    ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'tb_reports.department_id')
                    ->where('tb_reports.is_deleted', 0)
                    ->where('tb_reports.is_received', 0)
                    ->orderBy('report_id', 'desc')
                    ->get();

        // $data['products'] = Product::leftJoin('refunit', 'refunit.unit_id', 'refproduct.unit_id')
        //             ->leftJoin('refcategory', 'refcategory.category_id', 'refproduct.category_id')
        //             ->leftJoin('refsupplier', 'refsupplier.supplier_id', 'refproduct.supplier_id')
        //             ->where('refproduct.is_deleted', 0)
        //             ->orderBy('refproduct.product_id')
        //             ->get();

         $data['departments'] = Department::where('is_deleted', 0)->orderBy('department_id')->get();

        return $data;

        // $report = Staff::where('is_deleted', 0)->orderBy('report_id', 'desc')->get();
        // return Reference::collection($report);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        // Validator::make($request->all(),
        //     [
        //         'username' => 'required|string|max:255|unique:b_users',
        //         'password' => 'required|string|min:6|confirmed',
                
        //     ]
        // )->validate();

        // $user = new User();

        // // $user->account_no = DB::raw('CreateAccountNo()');
        // // ganito dapat yung pagselect mo sa function kung gusto mo mareturn
        // $user->account_no = DB::select("select CreateAccountNo() as account_no")[0]->account_no;
        // $user->username = $request->input('username');
        // $user->password = $request->input('password');
        // $user->department_id = $request->input('department');
        // $user->firstname = $request->input('firstname');
        // $user->middlename = $request->input('middlename');
        // $user->lastname = $request->input('lastname');
        // $user->created_datetime = Carbon::now();
        // $user->created_by = Auth::user()->id;

        // $user->save();  

        // //return json based from the resource data
        // return ( new Reference( $user ))
        //         ->response()
        //         ->setStatusCode(201);
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
              $data['report'] = Client::select(
                                                'tb_reports.*',
                                                'rd.department_name'
                                                
            )
                                                ->leftJoin('refdepartment as rd', 'rd.department_id', '=', 'tb_reports.department_id')
                                                ->findOrFail($id);

          
        return $data;
         
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

        // // $user = User::findOrFail($id);

        // Validator::make($request->all(),
        //     [
        //         'username' => 'required|string|max:255|unique:b_users,username,'.$id,
        //         'password' => 'required|string|min:6|confirmed',
               
                
        //     ]
        // )->validate();
        //  $user = User::findOrFail($id);
        // $user->username = $request->input('username');
        // $user->password = $request->input('password');
        // $user->department_id = $request->input('department');
        // $user->firstname = $request->input('firstname');
        // $user->middlename = $request->input('middlename');
        // $user->lastname = $request->input('lastname');
        // $user->modified_datetime = Carbon::now();
        // $user->modified_by = Auth::user()->id;

        // $user->save();

        // //return json based from the resource data
        // return ( new Reference( $user ))
        //         ->response()
        //         ->setStatusCode(201);
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
        // $staff = Staff::findOrFail($id);
        // $staff->is_deleted = 1;
        // $staff->deleted_datetime = Carbon::now();
        // $staff->deleted_by = Auth::user()->id;

        // //update classification based on the http json body that is sent
        // $staff->save();

        // return ( new Reference( $user ) )
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

     public function GetReport($report_id)
    {
        $report = Client::leftJoin('refunit', 'refunit.unit_id', 'refproduct.unit_id')
                        ->where('refproduct.is_deleted', 0);
                    
        return $report;
    }
}
