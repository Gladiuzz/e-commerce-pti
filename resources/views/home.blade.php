@extends('layouts.app')

@section('title', 'Dashboard')

@section('css')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                @if(Auth::user()->role == 'driver')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 mx-0">
                                <div class="widget style1 yellow-bg">
                                    <div class="row">
                                        <div class="col-4 text-center">
                                            <i class="fa fa-address-card fa-4x"></i>
                                        </div>
                                        <div class="col-8 text-right">
                                            <span> Jumlah Upload Bukti COD</span>
                                            <h3 class="font-bold">{{ $driverProduct }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (auth()->user()->role == 'driver' && $cash_out != null)
                            <div class="col-lg-3 mx-0">
                                <div class="widget style1 blue-bg">
                                    <div class="row">
                                        <div class="col-4 text-center">
                                            <i class="fa fa-address-card fa-4x"></i>
                                        </div>
                                        <div class="col-8 text-right">
                                            <span> Cash Out</span>
                                                @if ($cash_out->status != 'Accepted')
                                                    <a href="{{ url('transaction/get-all-cashout') }}"><i
                                                            class='fa btn btn-secondary'>Cash Out</i></a>
                                                    {{-- <a href="{{ route('accept.cash.out', ['id'=>$item->id]) }}"><i class='fa btn btn-info fa-edit'>Accepted Cash Out</i></a> --}}
                                                @else
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="card-body">
                        <div class="row">
                            @if (Auth::user()->role == 'admin')
                                <div class="col-lg-3 mx-0">
                                    <div class="widget style1 yellow-bg">
                                        <div class="row">
                                            <div class="col-4 text-center">
                                                <i class="fa fa-address-card fa-4x"></i>
                                            </div>
                                            <div class="col-8 text-right">
                                                <span> Total Penjual</span>
                                                <h3 class="font-bold">{{ $totalPenjual }} Penjual</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 mx-0">
                                    <div class="widget style1 lazur-bg">
                                        <div class="row">
                                            <div class="col-4 text-center">
                                                <i class="fa fa-credit-card fa-4x"></i>
                                            </div>
                                            <div class="col-8 text-right">
                                                <span> Penjualan Bulan Ini</span>
                                                <h3 class="font-bold">@currency($totalBulanan)</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-3 mx-0">
                                <div class="widget style1 navy-bg">
                                    <div class="row">
                                        <div class="col-4 text-center">
                                            <i class="fa fa-credit-card fa-4x"></i>
                                        </div>
                                        <div class="col-8 text-right">
                                            @if (Auth::user()->role == 'seller')
                                                <span> Total Penjualan</span>
                                            @else
                                                <span> Penjualan Tahun Ini</span>
                                            @endif
                                            <h3 class="font-bold mb-2">@currency($totalPenjualan)</h3>
                                            @if (auth()->user()->role == 'seller' && $cash_out != null)
                                                @if ($cash_out->status != 'Accepted')
                                                    <a href="{{ url('transaction/get-all-cashout') }}"><i
                                                            class='fa btn btn-secondary'>Cash Out</i></a>
                                                    {{-- <a href="{{ route('accept.cash.out', ['id'=>$item->id]) }}"><i class='fa btn btn-info fa-edit'>Accepted Cash Out</i></a> --}}
                                                @else
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (Auth::user()->role == 'seller')
                            <h3>Grafik Penjualan</h3>
                        @else
                            <h3>Grafik Penjualan Seller Tahun Ini</h3>
                        @endif
                        <div class="canvas">
                            <canvas id="lineChart" height="50"></canvas>
                        </div>
                        @if (Auth::user()->role == 'admin')
                            <hr />
                            <h3 class="mt-2">Product Dengan Stock Terbanyak</h3>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product->sortByDesc(function ($items) {
                                            return $items->sum('stock');
                                        }) as $name => $items)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $name }}</td>
                                                <td>{{ $items->sum('stock') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr />
                            <h3 class="mt-2">Product Terjual</h3>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Terjual</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productTransaction as $items)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $items['name'] }}</td>
                                                <td>{{ $items['count'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.dataTables-example').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                        extend: 'copy'
                    },
                    {
                        extend: 'csv'
                    },
                    {
                        extend: 'excel',
                        title: 'ExampleFile'
                    },
                    {
                        extend: 'pdf',
                        title: 'ExampleFile'
                    },

                    {
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ]

            });

        });
    </script>
    @if(Auth::user()->role != 'driver')
    <script>
        $(document).ready(function() {
            var array = JSON.parse('@json($chart)');

            var lineData = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                    'November', 'December'
                ],
                datasets: [{
                    label: "Penjualan",
                    backgroundColor: 'rgba(26,179,148,0.5)',
                    borderColor: "rgba(26,179,148,0.7)",
                    pointBackgroundColor: "rgba(26,179,148,1)",
                    pointBorderColor: "#fff",
                    data: array
                }]
            };

            var lineOptions = {
                responsive: true
            };

            var ctx = document.getElementById("lineChart").getContext("2d");
            new Chart(ctx, {
                type: 'line',
                data: lineData,
                options: lineOptions
            });
        });
    </script>
    @endif
@endsection
