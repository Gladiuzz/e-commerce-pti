<?php

namespace App\Http\Controllers;

use App\Models\DriverProduct;
use App\Models\TransactionProduct;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class DriverProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'driver'){
            $driverProduct = DriverProduct::where('id_user',Auth::user()->id)->get();
        }else{
            $driverProduct = DriverProduct::whereHas('transactionProduct.product',function($query){
                $query->where('user_id',Auth::user()->id);
            })
            ->get();
        }

        $data = array(
            'driverProduct' => $driverProduct
        );
        return view('list-cod.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = TransactionProduct::whereHas('transaction',function($query){
            $query->where('method','cod');
        })->whereHas('product', function($value){
            $value->where('user_id',Auth::user()->id);
        })->get();
        $user = User::where('role','driver')->get();
        // dd($product);
        $data = array(
            'product' => $product,
            'user' => $user
        );

        return view('list-cod.manage',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        DriverProduct::create($data);
        $transaction = Transaction::where('id',$request->id_product)->update(['status' => 'Settlement']);
        $transactionDetail = TransactionDetail::where('transaction_id',$request->id_product)->update(['courier_status' => 'Delivered']);


        return redirect('/driver-product');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DriverProduct  $driverProduct
     * @return \Illuminate\Http\Response
     */
    public function show(DriverProduct $driverProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DriverProduct  $driverProduct
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $driver = DriverProduct::findorFail($id);
        if(Auth::user()->role == 'seller'){
            $product = TransactionProduct::whereHas('transaction',function($query){
                $query->where('method','cod');
            })
            ->whereHas('product', function($value){
                $value->where('user_id',Auth::user()->id);
            })->get();
        }else{
            $product = TransactionProduct::whereHas('transaction',function($query){
                $query->where('method','cod');
            })
            ->get();    
        }

        $user = User::where('role','driver')->get();
        // dd($product);
        $data = array(
            'product' => $product,
            'user' => $user,
            'driver' => $driver
        );

        return view('list-cod.manage', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DriverProduct  $driverProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $file = $request->file('file');
        $driverProduct = DriverProduct::findorFail($id);

        if(!empty($file)){
            $file_name = time(). "_" . $file->getClientOriginalName();
            $file->storeAs('public/driver/', $file_name);
            $driverProduct->file = $file_name;
            $driverProduct->update();
            // $transactionDetail = TransactionDetail::where('id',$id)->update(['courier_status' => 'Success']);
        }else{
            $driverProduct->update($data);
        }
        

        return redirect('/driver-product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DriverProduct  $driverProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $driverProduct = DriverProduct::find($id);
        $driverProduct->delete();

        return redirect('driver-product');
    }
}
