<?php

namespace App\Http\Controllers;

use App\Models\TransactionFee;
use Illuminate\Http\Request;

class TransactionFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fee = TransactionFee::all();

        return view('fee.index',compact('fee'));
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
     * @param  \App\Models\TransactionFee  $transactionFee
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionFee $transactionFee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransactionFee  $transactionFee
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionFee $transactionFee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransactionFee  $transactionFee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionFee $transactionFee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionFee  $transactionFee
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionFee $transactionFee)
    {
        //
    }
}
