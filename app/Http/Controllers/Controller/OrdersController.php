<?php

namespace App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SohrModel;
use App\Models\SolnModel;
use App\Models\ProductsModel;
use App\Models\UserModel;
use App\Http\Resources\Reference; 
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Auth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    {
                    $data['sohr'] = SohrModel::select(
                        'sohr.*',
                        'user.fullname',
                        'sumr.seller_name',
                        'sumr.sumr_address'
    )               
                            ->leftJoin('user', 'user.user_hash', '=', 'sohr.user_hash')
                            ->leftJoin('soln', 'soln.soln_hash', '=', 'sohr.sohr_hash')
                            ->leftJoin('sumr', 'sohr.sumr_hash', '=', 'sumr.sumr_hash')
                            ->orderBy('sohr_hash', 'desc')
                            ->get();
    }

    {
                    $data['soln'] = SolnModel::select(
                        'soln.*',
                        'inmr.product_name',
                        'sohr.sohr_hash'
    )
    
                            ->leftJoin('sohr', 'sohr.sohr_hash', '=', 'soln.sohr_hash')
                            ->leftJoin('inmr', 'inmr.inmr_hash', '=', 'soln.inmr_hash')
                            // ->groupBy('soln.sohr_hash')
                            ->orderBy('soln.sohr_hash' , 'desc')
                            ->get();

    }
    //         $data['orders'] = OrdersModel::select(
    //              'soln.*',
    //              'sohr.order_no',
    //              'sohr.sumr_hash',
    //              'sohr.order_subtotal',
    //              'sohr.status',
    //              'inmr.product_name'
     
    //  )
    //                      ->leftJoin('sohr', 'sohr.sohr_hash', '=', 'soln.sohr_hash')
    //                      ->leftJoin('inmr', 'inmr.inmr_hash', '=', 'soln.inmr_hash')
    //                     //  ->leftJoin('refusertype as ru', 'ru.user_type_id', '=', 'b_users.user_type_id')
    //                     //  ->where('b_users.is_deleted', 0)
    //                     //  ->where('b_users.user_type_id', 3)
    //                      ->orderBy('soln_hash', 'asc')
    //                      ->get();
     
    $data['products'] = ProductsModel::orderBy('inmr_hash')->get();
    $data['user'] = UserModel::orderBy('user_hash')->get();
     
          
             return $data;
          
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
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
        //
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
    public function AcceptNewOrder(Request $request ,$id)
    {
        $sohr = SohrModel::findOrFail($id);
        
        $sohr->status_merc = $request->input('selected');
        $sohr->accept_datetime = Carbon::now();
        $sohr->to_pick_datetime = date('Y-m-d', strtotime($request->input('to_pick_datetime')));
        $sohr->is_cancel = 0;
     
        $sohr->save();

    

        return ( new Reference( $sohr ) )
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeclineNewOrder(Request $request ,$id)
    {
        $sohr = SohrModel::findOrFail($id);
        
        $sohr->decline_neworder_remarks = $request->input('decline_neworder_remarks');
        $sohr->decline_neworder_date = Carbon::now();
     
        $sohr->save();

        return ( new Reference( $sohr ) )
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function AcceptIntransit(Request $request ,$id)
    {
        $sohr = SohrModel::findOrFail($id);
        
        $sohr->status_merc = "READY TO PICK UP";
        $sohr->dh_accept_order_datetime = Carbon::now();
        $sohr->save();

        return ( new Reference( $sohr ) )
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function Delivered(Request $request ,$id)
    {
        $sohr = SohrModel::findOrFail($id);
        
        $sohr->status_merc = "COMPLETED";
        // $sohr->stat_transit = 1;
     
        $sohr->save();

        return ( new Reference( $sohr ) )
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

  
}
