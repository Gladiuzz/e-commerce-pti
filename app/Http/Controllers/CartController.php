<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = session()->get('cart');

        $data = array(
            'cart' => $cart
        );

        // return view('cart', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $product_id = $request->product_id;

        $product = Product::where('id', $product_id)
        ->first();

        $cart = session()->get('cart');

        // add product to cart
        if (!$cart) {
            $cart = [
                $product_id => [
                    'product' => $product,
                    'qty' => $request->qty,
                ]
            ];

            session()->put('cart', $cart);
            return response()->json($this->totalCalculation($cart, $product_id, $product));


        } else if(isset($cart[$product_id]) && $cart[$product_id]['qty'] == $product->stock) {
            return response()->json(['message' => 'You have entered all stock in this product', 'status' => 'denied']);
        } else if(isset($cart[$product_id]) && $cart[$product_id]['product']) {
            $cart[$product_id]['qty'] += $request->qty;

            session()->put('cart', $cart);
            return response()->json($this->totalCalculation($cart, $product_id, $product));

        }

        $cart[$product_id] = [
            'product' => $product,
            'qty' => $request->qty,
        ];

        session()->put('cart', $cart);
        return response()->json($this->totalCalculation($cart, $product_id, $product));
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
    public function destroy(Request $request)
    {
        $id = $request->product_id;
        if ($id) {
            $cart = session()->get('cart');

            if (isset($cart[$id])) {
                unset($cart[$id]);

                session()->put('cart', $cart);
            }
        }

        return response()->json(['cart' => $cart]);
    }

    // Temporary product price and total price from cart
    public function totalCalculation($cart, $product_id, $product)
    {
        $product_amount = $product->price * $cart[$product_id]['qty'];
        $total_price = 0;

        foreach ((array)session()->get('cart') as $key => $value) {
            $amount = $value['product']->price;
            $total_price += $amount * $value['qty'];
        }

        session()->put('product_price', $product_amount);
        session()->put('total_price', $total_price);

        $data = array(
            'product' => $product,
            'product_amount' => $product_amount,
            'total_price' => $total_price,
            'amount' => $amount,
        );


        return response()->json($data);
    }
}
