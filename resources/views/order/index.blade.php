@extends('layouts.app')

@section('title', 'Data order')

@section('css')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Data order</h5>
            <div class="ibox-tools">
                @if (request()->path() == 'order/success')
                <a href="{{ url('/order/generate') }}" class="border border-dark rounded text-dark bg-white p-2">
                    <i class="fa fa-download"></i>
                    Generate Data
                </a>
                @endif
            </div>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th>Date Order</th>
                            <th>Transaction Id</th>
                            <th> Nama Penerima</th>
                            <th>Alamat</th>
                            <th>Province</th>
                            <th>Kota</th>
                            <th>Metode Pembayaran</th>
                            <th>status</th>
                            @if (request()->path() != 'order/success')
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order as $item)
                            <tr class="gradeX">
                                <td>{{ $item->transaction->getTanggal() }}</td>
                                <td>{{ $item->transaction->trx_id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->full_address }}</td>
                                <td>{{ $item->province }}</td>
                                <td>{{ $item->city }}</td>
                                <td>{{ $item->transaction->method }}</td>
                                <td>{{ $item->courier_status }}</td>
                                @if (request()->path() != 'order/success')
                                    <td>
                                        <a href="{{ url('order/edit/' . $item->id) }}"><i
                                                class='fa btn btn-warning fa-edit'></i></a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
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
@endsection
