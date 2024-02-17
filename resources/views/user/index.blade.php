@extends('layouts.app')

@section('title', 'Data Seller')

@section('css')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="ibox ">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="ibox-title">
            <h5>Data User</h5>
            <div class="ibox-tools">
                @if (request()->path() == 'user-driver' || request()->path() == 'user-seller')
                    <a href="{{ url('/' . request()->path() . '/create') }}" class="border border-dark rounded bg-dark p-2">
                        <i class="fa fa-plus"></i>
                        Tambah User
                    </a>
                @endif
            </div>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            @if (Request::path() == 'user-seller' || Request::path() == 'user-driver' || Auth::user()->role == 'admin')
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->role }}</td>
                                <td>{{ $item->status }}</td>
                                @if (Request::path() == 'user-seller' || Request::path() == 'user-driver' || Auth::user()->role == 'admin')
                                    <td>
                                        @if (Request::path() == 'user-seller' || Request::path() == 'user-driver')
                                            @if ($item->transactionCashOut->isNotEmpty())
                                                @if ($item->transactionCashOut[0]->status != 'Accepted')
                                                    <a class="cashout" data-id="{{$item->id}}" data-href="{{ route('accept.cash.out', ['id' => $item->id]) }}">
                                                    {{-- <a class="" href="{{ route('accept.cash.out', ['id' => $item->id]) }}"> --}}
                                                        <i class='fa btn btn-info fa-edit'>Accepted Cash Out</i>
                                                    </a>
                                                @else
                                                @endif
                                            @endif
                                        @endif

                                        <a href="#" class="update-status" data-id="{{$item->id}}"><i
                                                class='fa btn btn-info {{$item->status == 'active' ? 'fa-times text-danger' : 'fa-check'}}'></i></a>
                                        <a href="{{ url(request()->path() . '/edit/' . $item->id) }}"><i
                                                class='fa btn btn-warning fa-edit'></i></a>
                                        <a href="{{ url(request()->path() . '/delete/' . $item->id) }}"><i
                                                class='fa fa-trash btn btn-danger'></i></a>
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

            function formatRupiah(angka) {
                var rupiah = '';
                var angkarev = angka.toString().split('').reverse().join('');
                for (var i = 0; i < angkarev.length; i++) {
                    if (i % 3 === 0) {
                        rupiah += angkarev.substr(i, 3) + '.';
                    }
                }
                return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
            }

            $('.update-status').click(function(evt){
                evt.preventDefault();
                var itemId = $(this).data("id");
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                Swal.fire({
                    title: 'Do you want to change the status ?',
                    icon : 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Active',
                }).then((result) => {
                    if (result.isConfirmed) {
                    $.ajax({
                        url: '/users/update-status/',
                        method: 'POST',
                        data:{
                        id:itemId,
                        },
                        headers : {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            if(response == 'success'){
                                Swal.fire('Status Changes!', '', 'success').then(() => {
                                location.reload()
                                })
                            }else{
                                Swal.fire('Failed!', 'Got something wrong!', 'error')
                            }
                        },
                        error: function(xhr, status, error) {
                        console.log(error);
                        }
                    });
                    }
                })
            })

            $(".cashout").click(function() {
                const id = $(this).data("id");
                const href = $(this).data("href");

                $.ajax({
                    url: `transaction/get-amount/${id}`,
                    method: 'get',
                    success: (resp) => {
                        console.log(resp);
                        if (resp) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: `Mencairkan total uang ${formatRupiah(resp)}`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Cairkan'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.open(href, '_blank');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Pencairan Berhasil!',
                                    }).then((res) => {
                                        if(res.isConfirmed){
                                            location.reload();
                                        }
                                    })
                                }
                            })
                        }
                    },
                    error: (err) => {
                        console.log(err);
                    }
                });
            });
        });
    </script>
@endsection
