<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Contact;
use App\Models\ProductCategory;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionProduct;
use App\Models\DriverProduct;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\SumController;
use App\Models\TransactionCashOut;

class DashboardController extends Controller
{
    private $sumController;

    public function __construct(SumController $sumController)
    {
        $this->sumController = $sumController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $year_now = Carbon::now()->format('Y');
        $month_now = Carbon::now()->format('m');

        $chart = [];
        if (Auth::user()->role == 'seller') {
            $transaction = Transaction::where('status', 'Settlement')
                ->whereHas('transactionProduct', function ($query) {
                    $query->whereHas('product', function ($value) {
                        $value->where('user_id', Auth::user()->id);
                    });
                })
                ->get();

            $totalPenjualan = $this->sumController->sum($transaction);

            for ($i = 0; $i < 12; $i++) {
                $transaction_query = $transaction->filter(function ($transaction) use ($year_now, $i) {
                    return substr($transaction->created_at, 0, 7) === $year_now . '-0' . strval($i);
                });
                $totalTransaction = $this->sumController->sum($transaction_query);
                $chart[] = $totalTransaction;
            }

            $cash_out = TransactionCashOut::select('user_id', 'status')
                ->where('user_id', auth()->user()->id)
                //->where('status','Accepted')
                ->groupBy('user_id', 'status')
                ->first();

            return view('home', compact('chart', 'totalPenjualan', 'cash_out'));
        }else if(Auth::user()->role == 'driver'){
            $driverProduct = DriverProduct::where('id_user',Auth::user()->id)
            ->where('file','!=','null')
            ->count();

            $cash_out = TransactionCashOut::select('user_id', 'status')
            ->where('user_id', auth()->user()->id)
            //->where('status','Accepted')
            ->groupBy('user_id', 'status')
            ->first();

            $data = array(
                'driverProduct' => $driverProduct,
                'cash_out' => $cash_out,
            );


            return view('home', $data);
        }

        $transaction = Transaction::where('status', 'Settlement')->get();
        $transaction_month = Transaction::where('status', 'Settlement')
            ->whereMonth('created_at', $month_now)
            ->get();

        $totalPenjual = User::where('role', 'seller')->count();
        $totalBulanan = $this->sumController->sum($transaction_month);
        $totalPenjualan = $this->sumController->sum($transaction);

        for ($i = 0; $i < 12; $i++) {
            $transaction_query = $transaction->filter(function ($transaction) use ($year_now, $i) {
                return substr($transaction->created_at, 0, 7) === $year_now . '-0' . strval($i);
            });
            $totalTransaction = $this->sumController->sum($transaction_query);
            $chart[] = $totalTransaction;
        }

        $productAll = Product::all();

        $productTransaction = [];
        foreach ($productAll as $key => $value) {
            $count = 0;
            $transaction = TransactionProduct::where('product_id',$value->id)->get('qty');

            if($transaction->isNotEmpty()){
                foreach ($transaction as $key => $counter) {
                    $count += $counter->qty;
                }
            }

            $productTransaction[] = [
                'name' => $value->name->name,
                'count' => $count,
            ];
        }

        $product = Product::get(['name_id', 'stock'])->groupBy('name.name');

        return view('home', compact('chart', 'totalPenjualan', 'totalBulanan', 'totalPenjual', 'product','productTransaction'));
    }
}
