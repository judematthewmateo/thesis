<?php

namespace App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductsModel;
use App\Http\Resources\Reference; 
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = ProductsModel::where('is_deleted', 0)->orderBy('inmr_hash', 'desc')->get();
        return Reference::collection($products);;
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
                'product_name' => 'required',
                'product_details' => 'required',
                'onhand_qty' => 'required',
                'available_qty' => 'required',
                'cost_amt' => 'required'

            ]
        )->validate();

        $products = new ProductsModel();
        $products->product_name = $request->input('product_name');
        $products->product_details = $request->input('product_details');
        $products->onhand_qty = $request->input('onhand_qty');
        $products->available_qty = $request->input('available_qty');
        $products->cost_amt = $request->input('cost_amt');
        $products->create_datetime = Carbon::now();
        $products->sumr_hash = Auth::user()->sumr_hash;
    
        $products->save();

        //return json based from the resource data
        return ( new Reference( $products ))
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
        $products = ProductsModel::findOrFail($id);

        return ( new Reference( $products ) )
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        
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
        $products = ProductsModel::findOrFail($id);
        
        Validator::make($request->all(),
            [
                'product_name' => 'required',
                'product_details' => 'required',
                'onhand_qty' => 'required',
                'available_qty' => 'required',
                'cost_amt' => 'required'
                
            ]
        )->validate();
        $products = new ProductsModel();
        $products->file('picture')->store('image_path');
        $products->product_name = $request->input('product_name');
        $products->product_details = $request->input('product_details');
        $products->onhand_qty = $request->input('onhand_qty');
        $products->available_qty = $request->input('available_qty');
        $products->cost_amt = $request->input('cost_amt');
        $products->update_datetime = Carbon::now();
        $products->sumr_hash = $request->input('update_id');;

        //update  based on the http json body that is sent
        $products->save();

        return ( new Reference( $products ) )
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
    public function delete($id)
    {   
        $products = ProductsModel::findOrFail($id);

        $products->is_deleted = 1;

        //update classification based on the http json body that is sent
        $products->save();

        return ( new Reference( $products ) )
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $this->validate($request,[
    //         'product_code' => 'required|string|max:25'
    //     ]);

    //     //return ['message' => "App\Http\Controllers\API\ProductController@store"];
    //     //return $request->all();

    //     if($request->photo != "profile.png"){
    //         $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

    //         Image::make($request->photo)->save(public_path('images/products/').$name);
    //         $request->merge(['photo' => $name]);
    //     }

    //     return Inmr::create([
    //         'co_no' => $request['co_no'],
    //         'product_code' => $request['product_code'],
    //         'description' => $request['description'],
    //         'cost_price' => $request['cost_price'],
    //         'sale_price' => $request['sale_price'],
    //         'photo' => $request['photo'],
    //     ]);
    // }
    
}
