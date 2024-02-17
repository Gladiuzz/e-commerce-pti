@extends('layouts.app')

@section('title', 'Data Contact')

@section('css')
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Data Kontak</h5>
            <div class="ibox-tools">
                {{-- <a href="{{url('/contact/create')}}" class="border border-dark rounded bg-dark p-2">
                <i class="fa fa-plus"></i>
                Add Contact
            </a> --}}
            </div>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Alamat</th>
                            <th>No Telepon</th>
                            <th>Keterangan</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contact as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->address }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->mail }}</td>
                                <td>
                                    {{-- <a href="{{ url('contact/show/'.$item->id) }}"><i class='fa btn btn-info fa-eye'></i></a> --}}
                                    <a href="{{ url('contact/edit/' . $item->id) }}"><i
                                            class='fa btn btn-warning fa-edit'></i></a>
                                    {{-- <a href="{{ url('contact/delete/'.$item->id) }}"><i class='fa fa-trash btn btn-danger'></i></a> --}}
                                </td>
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
                buttons: []

            });

        });
    </script>
@endsection
