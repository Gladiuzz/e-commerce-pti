@extends('layouts.app')

@section('title', 'Data Seller')

@section('css')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Data Seller</h5>
            <div class="ibox-tools">
                @if (request()->path() == 'user-seller')
                    <a href="{{ url('/user-seller/create') }}" class="border border-dark rounded bg-dark p-2">
                        <i class="fa fa-plus"></i>
                        Add User
                    </a>
                @endif
            </div>
        </div>
        <div class="ibox-content">
            <p>Nama Penjual : {{ $user->name }}</p>
            <p>Email Penjual : {{ $user->email }}</p>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Keterangan</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Weight</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->product as $item)
                            <tr>
                                <td>{{ $item->name->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->stock }}</td>
                                <td>{{ $item->weight }}</td>
                                <td>{{ $item->productCategory->name }}</td>
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
                buttons: [
                    // { extend: 'copy'},
                    // {extend: 'csv'},
                    // {extend: 'excel', title: 'ExampleFile'},
                    // {extend: 'pdf', title: 'ExampleFile'},

                    // {extend: 'print',
                    //  customize: function (win){
                    //         $(win.document.body).addClass('white-bg');
                    //         $(win.document.body).css('font-size', '10px');

                    //         $(win.document.body).find('table')
                    //                 .addClass('compact')
                    //                 .css('font-size', 'inherit');
                    // }
                    // }
                ]

            });

        });
    </script>
@endsection
