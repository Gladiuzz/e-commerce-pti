<?php

namespace App\Http\Controllers;

use App\Models\DriverProduct;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionCashOut;
use App\Models\TransactionDetail;
use App\Models\TransactionProduct;
use App\Models\TransactionFee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'seller') {
            $transaction = Transaction::with('transactionProduct')
                ->whereHas('transactionProduct', function ($query) {
                    $query->whereHas('product', function ($value) {
                        $value->where('user_id', Auth::user()->id);
                    });
                })
                ->get();

            $totalTransaction = $transaction
                ->where('status', 'Settlement')
                ->pluck('amount')
                ->sum();

            $data = [
                'transaction' => $transaction,
                'totalTransaction' => $totalTransaction,
            ];

            return view('transaction.index', $data);
        }

        $transaction = Transaction::all();

        $data = [
            'transaction' => $transaction,
        ];

        return view('transaction.index', $data);
    }

    public function paymentSnap(Request $request)
    {
        $cart = session()->get('cart');
        $total_price = 0;

        $timestamp = Date('YmdHis');
        $time_expire = Date('Y-m-d H:m:s +0700');

        // only temporary for gross amount
        $total_quantity = 0;
        foreach ($cart as $key => $value) {
            $total_quantity += $value['qty'];
        }

        $split_courier = intval($request->courier_amount / count($cart));

        // item details
        foreach ($cart as $key => $value) {
            $item_details[] = [
                'id' => $value['product']->id,
                'price' => intval($value['product']->price),
                'quantity' => $value['qty'],
                'name' => $value['product']['name']['name'],
                'merchant_name' => 'pertanian',
            ];
            $total_price += $value['product']->price * $value['qty'];
        }

        $shipping_cost = [
            'id' => 'Shipping_cost',
            'price' => intval($request->courier_amount),
            'quantity' => 1,
            'name' => 'Shipping Cost',
            'merchant_name' => 'pertanian',
        ];
        array_push($item_details, $shipping_cost);

        // Transaction Details Midtrans
        $midtrans_details = [
            'order_id' => 'TP-' . $timestamp,
            'gross_amount' => intval($total_price + $request->courier_amount),
        ];

        // Customer Details Midtrans
        $customer_details = [
            'first_name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'billing_address' => [
                'first_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'address' => $request->full_address,
                // "city" => $input['city_name'],
                'postal_code' => $request->zip_code,
                'contry_code' => 'IDN',
            ],
            'shipping_address' => [
                'first_name' => $request->name,
                // "last_name"=> "UTOMO",
                'phone' => $request->phone_number,
                'address' => $request->full_address,
                // "city"=> $input['city_name'],
                'postal_code' => $request->zip_code,
                'country_code' => 'IDN',
            ],
        ];

        // Custom Expiry Midtrans
        $custom_expiry = [
            'start_time' => $time_expire,
            'unit' => 'hours',
            'duration' => 1,
        ];

        // payload Midtrans
        $payload = [
            'transaction_details' => $midtrans_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
            'expiry' => $custom_expiry,
        ];

        // dd($payload);
        $url = 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        // response API Midtrans
        $responses = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic U0ItTWlkLXNlcnZlci04OW5uV2QtU1pQeGRkVFBLdEdvdWVtUFY=',
        ])->post($url, $payload);

        // return $responses;

        $this->createTransaction($request, $midtrans_details, $cart, $responses['redirect_url']);

        return redirect('/order');
    }

    public function checkStatus(Request $request)
    {
        $url = 'https://api.sandbox.midtrans.com/v2/' . $request->order_id . '/status';

        // response Api
        $responses = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic U0ItTWlkLXNlcnZlci04OW5uV2QtU1pQeGRkVFBLdEdvdWVtUFY=',
        ])->get($url);

        return $responses;
    }

    public function createTransaction($request, $details, $cart, $payment_url)
    {
        $mytime = Carbon::now();
        $expiry_time = $mytime->addHours(1);

        $transaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'trx_id' => $details['order_id'],
            'session_id' => '',
            'url' => $payment_url,
            'transaction_date' => $mytime,
            'amount' => $details['gross_amount'],
            'method' => $request->payment_method == 'cod' ? 'cod' : '',
            'status' => $request->payment_method == 'cod' ? 'Settlement' : 'Pending',
        ]);

        $driver = User::where('id', $request->driver)
        ->first();

        // Add product at cart to Transaction Product Table
        foreach ($cart as $key => $value) {
            TransactionProduct::create([
                'transaction_id' => $transaction->id,
                'product_id' => $value['product']->id,
                'qty' => $value['qty'],
            ]);

            DriverProduct::create([
                'id_product' => $value['product']->id,
                'id_user' => $driver->id,
            ]);

            $product = Product::where('id', '=', $value['product']->id)->first();

            $product->stock = $product->stock - $value['qty'];
            $product->update();
        }

        // create Detail Transaction
        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'driver_id' => $driver->id,
            'no_receipt' => mt_rand(intval(10000000000), intval(99999999999)),
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'full_address' => $request->full_address,
            'city' => 'Subang',
            'province' => 'Jawa Barat',
            'courier_type' => '-',
            'courier_status' => 'Processing',
            'zip_code' => $request->zip_code,
        ]);


        session()->forget('cart');

        // return response()->json($data);
    }

    public function notificationSandbox(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'transaction_time' => 'required',
        //     'transaction_status' => 'required',
        //     'transaction_id' => 'required',
        //     'status_message' => 'required',
        //     'status_code' => 'required',
        //     'signature_key' => 'required',
        //     'payment_type' => 'required',
        //     'order_id' => 'required',
        //     'merchant_id' => 'required',
        //     // "masked_card" => 'required',
        //     'gross_amount' => 'required',
        //     'fraud_status' => 'required',
        //     // "eci" => 'required',
        //     'currency' => 'required',
        //     // "channel_response_message" => 'required',
        //     // "channel_response_code" => 'required',
        //     // "card_type" => 'required',
        //     // "bank" => 'required',
        //     // "approval_code" => 'required'
        // ]);

        // $callback = [
        //     'transaction_time' => $request->transaction_time,
        //     'transaction_status' => $request->transaction_status,
        //     'transaction_id' => $request->transaction_id,
        //     'status_message' => $request->status_message,
        //     'status_code' => $request->status_code,
        //     'signature_key' => $request->signature_key,
        //     'payment_type' => $request->payment_type,
        //     'order_id' => $request->order_id,
        //     'merchant_id' => $request->merchant_id,
        //     'masked_card' => $request->masked_card ?? null,
        //     'gross_amount' => $request->gross_amount,
        //     'fraud_status' => $request->fraud_status,
        //     'eci' => $request->eci ?? null,
        //     'currency' => $request->currency,
        //     'payment_amounts' =>
        //         [
        //             'paid_at' => $request->payment_amounts[0]['paid_at'] ?? null,
        //             'amount' => $request->payment_amounts[0]['amount'] ?? null,
        //         ] ?? null,
        //     'channel_response_message' => $request->channel_response_message ?? null,
        //     'channel_response_code' => $request->channel_response_code ?? null,
        //     'card_type' => $request->card_type ?? null,
        //     // 'bank' => $request->bank ?? ($request->va_numbers[0]['bank'] ?? null),
        //     'approval_code' => $request->approval_code ?? null,
        //     'va_number' => $request->va_number ?? ($request->va_numbers[0]['va_number'] ?? null),
        //     'settlement_time' => $request->settlement_time ?? null,
        //     'acquirer' => $request->acquirer ?? null,
        //     'issuer' => $request->issuer ?? null,
        // ];

        $transaction_update = Transaction::where('trx_id', $request->order_id)
        ->first();


        if ($transaction_update == null) {
            return response()->json([
                'success' => 'false',
                'status' => 400,
                'errors' => 'transaction not found',
            ], 400);
        } else {
            foreach ($transaction_update->transactionProduct as $key => $value) {
                $data = array(
                    'user_id' => $value->product->user_id,
                    'transaction_id' => $transaction_update->id,
                    'status' => 'Pending',
                );
                TransactionCashOut::create($data);

            }
            switch ($request->payment_type) {
                case 'credit_card':
                    $transaction_update->session_id = $request->transaction_id;
                    $transaction_update->method = $request->payment_type;
                    $transaction_update->bank_type = $request->bank;
                    $transaction_update->status = ucfirst($request->transaction_status);
                    $transaction_update->update();
                    break;
                case 'gopay':
                    $transaction_update->session_id = $request->transaction_id;
                    $transaction_update->method = $request->payment_type;
                    $transaction_update->bank_type = 'gopay';
                    $transaction_update->status = ucfirst($request->transaction_status);
                    $transaction_update->update();
                    break;
                case 'qris':
                    $transaction_update->session_id = $request->transaction_id;
                    $transaction_update->method = $request->payment_type;
                    $transaction_update->bank_type = $request->acquirer;
                    $transaction_update->status = ucfirst($request->transaction_status);
                    $transaction_update->update();
                    break;
                case 'shopeepay':
                    $transaction_update->session_id = $request->transaction_id;
                    $transaction_update->method = $request->payment_type;
                    $transaction_update->bank_type = $request->acquirer;
                    $transaction_update->status = ucfirst($request->transaction_status);
                    $transaction_update->update();
                    break;
                case 'bank_transfer':
                    $transaction_update->session_id = $request->transaction_id;
                    $transaction_update->method = $request->payment_type;
                    $transaction_update->bank_type = $request->va_numbers[0]['bank'];
                    $transaction_update->status = ucfirst($request->transaction_status);
                    $transaction_update->update();

                default:
                    # code...
                    break;
            }
            // dd($transaction_update->transactionProduct);




            return response()
            ->json([
                'success' => 'true',
                'data' => $transaction_update,
            ])
            ->withHeaders([
                'Content-Type' => 'application/json',
            ]);
        }
    }

    public function cancelTransaction($id)
    {
        $transaction = Transaction::find($id);
        $transaction->status = 'Cancelled';

        foreach ($transaction->transactionProduct as $key => $value) {
            $product = Product::find($value->product_id);
            $product->stock += $value->qty;
            $product->update();
        }

        $transaction->update();

        $url = 'https://api.sandbox.midtrans.com/v2/' . $transaction->trx_id . '/cancel';

        // response Api
        Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic U0ItTWlkLXNlcnZlci04OW5uV2QtU1pQeGRkVFBLdEdvdWVtUFY=',
        ])->post($url);


        return redirect()->back();
    }

    public function requestCashOut($id)
    {
        $transaction = Transaction::findorFail($id);

        if (auth()->user()->role != 'admin') {
            # code...
            $transaction->transactionCashOut->status = 'Requested';
            $transaction->transactionCashOut->update();

            $msg = 'Pencairan uang telah diminta ke admin';
        } else {
            foreach ($transaction->transactionProduct as $key => $value) {
                $value->product->user->money += $value->product->price * $value->qty;
                $value->product->user->update();
            }
            $transaction->transactionCashOut->status = 'Accepted';
            $transaction->transactionCashOut->update();

            $msg = 'Uang tunai telah ditransfer ke penjual';
        }

        return redirect()
            ->back()
            ->with('success', $msg);
    }

    public function requestAllCashOut()
    {
        $user = Auth::user();

        if ($user->role == 'driver') {
            $transaction = Transaction::with('transactionDetail')
                ->whereHas('transactionDetail', function ($query) use ($user) {
                    $query->where('driver_id', $user->id);
                })
                ->where('status', 'Settlement')
                ->get();
        } else {
            $transaction = Transaction::with('transactionProduct')
                ->whereHas('transactionProduct', function ($query) use ($user) {
                    $query->whereHas('product', function ($query2) use ($user) {
                        $query2->where('user_id', $user->id);
                    });
                })
                ->where('status', 'Settlement')
                ->get();
        }


        foreach ($transaction as $key => $value) {
            if ($user->role == 'driver') {
                TransactionCashOut::where('user_id', $value->transactionDetail->driver_id)->update(['status' => 'Requested']);
            } else {
                foreach ($value->transactionProduct as $key => $values) {
                    TransactionCashOut::where('user_id', $values->product->user_id)->update(['status' => 'Requested']);
                }
            }
        }

        $msg = 'Pencairan uang telah diminta ke admin';

        return redirect('dashboard')->with('success', $msg);
    }

    public function acceptCashOut($id)
    {
        $user = User::findorFail($id);

        $transaction = Transaction::with('transactionCashOut')
            ->whereHas('transactionCashOut', function ($query) use ($user) {
                $query->where('user_id', $user->id);
                $query->where('status','Requested');
            })
            ->get();
        $money = 0;
        if ($transaction->isEmpty()) {
            $msg = 'Seller cant cash out';
            $status = 'error';
        } else {
            foreach ($transaction as $key => $value) {
                $value->transactionCashOut->status = 'Accepted';
                $value->transactionCashOut->update();

                if ($user->role == 'driver') {
                    $user->money += 10000;
                    $money += 10000;
                    $user->update();
                } else {
                    // $user->money += $value->amount;
                    $money += $value->amount;
                    // $user->update();
                }
            }
            // FEE
            $fee = $money * 0.05;

            if($user->role == 'seller'){
                $user->money += $money - $fee;
                $money = $money - $fee;
                $user->update();
            }

            $admin = User::where('role', 'admin')
            ->first();
            $allMoney = $admin->money += $fee;
            $admin->update();

            $fee = TransactionFee::create([
                'user_id' => $user->id,
                'total_fee' => $allMoney,
            ]);

            $msg = 'Cash has been transferred to sellers';
            $status = 'success';
        }

        $word = $this->numberToWords($money);


        return view('transaction.pdf',compact('money','word','user'))->with('_blank');
        // return redirect('')
        //     // ->back()
        //     ->with($status, $msg);
    }

    public function transactionAmount($id){
        $user = User::findorFail($id);

        $transaction = Transaction::with('transactionCashOut')
            ->whereHas('transactionCashOut', function ($query) use ($id) {
                $query->where('user_id', $id);
                $query->where('status','Requested');
            })
            ->pluck('amount');
        $amount = 0;

        # code...
        foreach ($transaction as $key => $value) {
            if ($user->role == 'driver') {
                $amount += 10000;
            } else {
                $amount += $value;
            }
        }

        if($user->role == 'seller'){
            $fee = $amount * 0.05;
            $amount = $amount - $fee;
        }

        return response()->json($amount);
    }

    public function numberToWords($number)
    {
        $numberWords = [
            '', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh',
            'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'
        ];

        $magnitudeWords = ['', 'ribu', 'juta', 'miliar', 'triliun', 'kuadriliun', 'kuantiliun'];

        function convertChunk($num, $numberWords)
        {
            if ($num == 0) {
                return '';
            } elseif ($num < 20) {
                return $numberWords[$num];
            } elseif ($num < 100) {
                return "{$numberWords[$num / 10]} puluh {$numberWords[$num % 10]}";
            } elseif ($num < 200) {
                return "seratus " . convertChunk($num % 100, $numberWords);
            } else {
                return "{$numberWords[$num / 100]} ratus " . convertChunk($num % 100, $numberWords);
            }
        }

        if ($number == 0) {
            return 'nol';
        }

        $words = '';
        $magnitudeIndex = 0;

        while ($number > 0) {
            $chunk = $number % 1000;
            if ($chunk != 0) {
                $chunkWords = convertChunk($chunk, $numberWords);
                $words = "{$chunkWords} {$magnitudeWords[$magnitudeIndex]} {$words}";
            }
            $magnitudeIndex++;
            $number = (int)($number / 1000);
        }

        return trim($words);
    }
}
