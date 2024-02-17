@extends('layouts.app')

@section('title', 'Data Product')

@section('css')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">

@endsection

@section('content')
    @if (session()->has('success'))
        <script>
            window.onload = function() {
                swal.fire("Berhasil di Hapus");
            };
        </script>
    @endif
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Data Produk</h5>
            <div class="ibox-tools">
                <a href="{{ url('/product/create') }}" class="border border-dark rounded bg-dark p-2">
                    <i class="fa fa-plus"></i>
                    Tambah Produk
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Keterangan</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $item)
                            <tr>
                                <td>{{ $item->name->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>@currency($item->price)</td>
                                <td>{{ $item->stock }}</td>
                                <td>
                                    <a href="{{ url('product/show/' . $item->id) }}"><i
                                            class='fa btn btn-info fa-eye'></i></a>
                                    <a href="{{ url('product/edit/' . $item->id) }}"><i
                                            class='fa btn btn-warning fa-edit'></i></a>
                                    <a href="#" data-toggle="modal" data-target="#hapus{{ $item->id }}"> <i
                                            class='fa fa-trash btn btn-danger'></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Modal -->
            @foreach ($product as $item)
                <div class="modal fade" id="hapus{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Hapus Kategori</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Apakah anda ingin Menghapus
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">batal</button>
                                <a href="{{ url('product/delete/' . $item->id) }}" class="btn btn-danger">Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

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
