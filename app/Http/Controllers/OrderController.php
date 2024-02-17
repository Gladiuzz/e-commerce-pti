<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\TransactionCashOut;
use Illuminate\Http\Request;
use Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $current_path = $request->path();

        $order_default = TransactionDetail::whereHas('transaction',function($query){
            $query->where('status', 'Settlement');
            $query->orWhere('method','cod');
            $query->whereHas('transactionProduct',function($value){
                $value->whereHas('product',function($prod){
                    $prod->where('user_id',Auth::user()->id);
                });
            });
        })->get();

        switch ($current_path) {
            case 'order/processing':
                $order = $order_default->where('courier_status','Processing');
                break;
            case 'order/cancelled':
                $order = $order_default->where('courier_status','Cancelled');
                break;
            case 'order/delivered':
                $order = $order_default->where('courier_status','Delivered');
                break;
            case 'order/success':
                $order = $order_default->where('courier_status','Success');
                break;

            default:
                # code...
                break;
        }


        $data = array(
            'order' => $order
        );

        return view('order.index', $data);
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
        $order = TransactionDetail::find($id);
        $previous_url = url()->previous();
        $data = array(
            'order' => $order,
            'previous' => $previous_url,
        );

        return view('order.manage', $data);
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
        $this->validate($request, [
            'status' => ['required'],
            'no_receipt' => ['required'],
        ]);

        $input = $request->all();

        $order = TransactionDetail::where('no_receipt', $input['no_receipt'])->first();
        if (!empty($order)) {
            $order->courier_status = $input['status'];

            $order->update();

            switch ($input['status']) {
                case 'Delivered':
                    return redirect()->to("/order/delivered");
                    break;
                case 'Success':
                    // $data_driver = array(
                    //     'user_id' => $order->driver_id,
                    //     'transaction_id' => $order->transaction_id,
                    //     'status' => 'Pending',
                    // );
                    // TransactionCashOut::create($data_driver);
                    return redirect()->to("/order/success");
                    break;
                case 'Cancelled':
                    return redirect()->to("/order/cancelled");
                    break;
                default:
                    # code...
                    break;
            }
        } else {
            return redirect()->back();
        }

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

    public function generate(){
        $order_default = TransactionDetail::whereHas('transaction',function($query){
            $query->where('status', 'Settlement');
            $query->orWhere('method','cod');
            $query->whereHas('transactionProduct',function($value){
                $value->whereHas('product',function($prod){
                    $prod->where('user_id',Auth::user()->id);
                });
            });
        })->get();

        $order = $order_default->where('courier_status','Success');

        $data = array(
            'order' => $order
        );

        return view('order.pdf', $data);
    }
}
