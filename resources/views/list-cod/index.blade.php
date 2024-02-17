@extends('layouts.app')

@section('title', 'Data Pengiriman')

@section('css')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Data Pengiriman</h5>
            <div class="ibox-tools">
                @if (Auth::user()->role == 'seller')
                    <a href="{{ url('/driver-product/create') }}" class="border border-dark rounded bg-dark p-2">
                        <i class="fa fa-plus"></i>
                        Tambah Data
                    </a>
                @endif
            </div>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Nama Driver </th>
                            <th>status</th>
                            {{-- @if (Auth::user()->role == 'driver') --}}
                            <th>Action</th>
                            {{-- @endif --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($driverProduct as $item)
                            <tr class="gradeX">
                                <td>{{ $item->transactionProduct->product->name->name }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->transactionProduct->transaction->transactionDetail->full_address }}</td>
                                {{-- @if (Auth::user()->role == 'driver') --}}
                                <td>
                                    <a target="_blank" href="{{ asset(Storage::url('driver/' . $item->file)) }}"><i
                                            class='fa btn btn-info fa-eye'></i></a>
                                    <a href="{{ url('driver-product/edit/' . $item->id) }}"><i
                                            class='fa btn btn-warning fa-edit'></i></a>
                                    @if (Auth::user()->role == 'seller')
                                        <a href="{{ url('driver-product/delete/' . $item->id) }}"><i
                                                class='fa btn btn-danger fa-trash'></i></a>
                                    @endif
                                </td>
                                {{-- @endif --}}
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
