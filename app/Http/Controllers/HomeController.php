<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Contact;
use App\Models\ProductCategory;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\SumController;
use App\Models\TransactionCashOut;

class HomeController extends Controller
{
    private $sumController;

    public function __construct(SumController $sumController)
    {
        $this->sumController = $sumController;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    function indexUser()
    {
        $product = Product::with('productImage', 'productCategory')
            ->take(4)
            ->get();
        $productRating = Product::orderBy('stock', 'desc')
            ->take(4)
            ->get();

        $productStok = Product::get(['name_id', 'stock'])->groupBy('name.name');
        $contact = Contact::first();
        $category = ProductCategory::all();
        return view('landing-page.index', compact('product', 'contact', 'category', 'productRating', 'productStok'));
    }

    function productUser($category_name)
    {
        // Temporary

        $category = ProductCategory::where('name', $category_name)->first();
        if ($category) {
            $product = Product::where('category_id', $category->id)->get();
        } else {
            $product = Product::all();
        }
        $contact = Contact::first();
        return view('landing-page.product-user', compact('product', 'contact'));
    }

    function searchProduct(Request $request)
    {
        // Temporary
        if ($request->search) {
            $product = Product::whereHas('name', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })->get();
        } elseif ($request->rating) {
            $product = Product::orderBy('stock', 'desc')->get();
        } else {
            $product = Product::whereHas('user', function ($query) use ($request) {
                $query->where('name', $request->seller);
            })->get();
        }

        $contact = Contact::first();
        return view('landing-page.product-user', compact('product', 'contact'));
    }

    public function pendaftaran()
    {
        return view('landing-page.pendaftaranpenjual');
    }

    function showProductUser($category, $id)
    {
        $product = Product::with('productImage', 'productCategory')->find($id);
        $contact = Contact::first();
        return view('landing-page.show', compact('product', 'contact'));
    }

    function showTransactionHistoryUser()
    {
        $history = Transaction::with('transactionDetail')
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'DESC')
            ->get();

        return view('landing-page.order', compact('history'));
    }

    public function cancelTransaction($id)
    {
        $transaction = TransactionDetail::find($id);

        $transaction->courier_status = 'Cancelled';

        $transaction->update();

        return redirect('/order');
    }

    public function detailOrder($id)
    {
        $detail = Transaction::find($id);

        $sub_total = 0;

        foreach ($detail->transactionProduct as $key => $value) {
            $sub_total += $value->product->price * $value->qty;
        }

        $shipping_cost = $detail->amount - $sub_total;

        $data = [
            'detail' => $detail,
            'sub_total' => $sub_total,
            'shipping_cost' => $shipping_cost,
        ];

        return view('landing-page.invoice', $data);
    }

    public function productReceived($id)
    {
        $transactionDetail = TransactionDetail::findorFail($id);
        $transactionDetail->courier_status = 'Success';
        $transactionDetail->update();

        // $admin = User::where('role', 'admin')
        // ->first();
        // $admin->money = $transactionDetail->transaction->amount * 0.05;
        // $admin->update();

        $data_driver = array(
            'user_id' => $transactionDetail->driver_id,
            'transaction_id' => $transactionDetail->transaction_id,
            'status' => 'Pending',
        );
        TransactionCashOut::create($data_driver);

        return redirect('order');
    }

    function registerDriver(){
        return view('auth.register');
    }
}
