@extends('layouts.app')

@section('title', 'Manage product')

@section('css')
@endsection

@section('content')
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Manage Order</h5>
            <div class="ibox-tools">
                {{-- <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-wrench"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#" class="dropdown-item">Config option 1</a>
                </li>
                <li><a href="#" class="dropdown-item">Config option 2</a>
                </li>
            </ul>
            <a class="close-link">
                <i class="fa fa-times"></i>
            </a> --}}
            </div>
        </div>
        <div class="ibox-content">
            <form role="form" action="{{ url('order/update/' . $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- temporary for get previous url --}}
                <input type="hidden" name="url" value="/order/delivered">
                {{--  --}}
                <div class="form-group">
                    <label>Receipt Number</label>
                    <input type="number" placeholder="Enter Receipt Number"
                        value="{{ old('no_receipt', @$order->no_receipt) }}" name="no_receipt" class="form-control">
                </div>
                <div>
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Status</label>
                        <select class="form-control" name="status">
                            <option value="" {{ old('status', @$order->courier_status == '' ? 'selected' : '') }}>
                                Choose Status</option>
                            <option value="Processing"
                                {{ old('status', @$order->courier_status == 'Processing' ? 'selected' : '') }}>Processing
                            </option>
                            <option value="Cancelled"
                                {{ old('status', @$order->courier_status == 'Cancelled' ? 'selected' : '') }}>Cancelled
                            </option>
                            <option value="Delivered"
                                {{ old('status', @$order->courier_status == 'Delivered' ? 'selected' : '') }}>Delivered
                            </option>
                            <option value="Success"
                                {{ old('status', @$order->courier_status == 'Success' ? 'selected' : '') }}>Success</option>
                        </select>
                    </div>
                    {{-- <input type="number" placeholder="Enter stock" value="{{old('stock', @$product->stock)}}" name="stock" class="form-control"></div> --}}
                    <div class="mt-3">
                        <button class="btn btn-sm btn-primary w-100" type="submit"><strong>Simpan</strong></button>
                    </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
@endsection
