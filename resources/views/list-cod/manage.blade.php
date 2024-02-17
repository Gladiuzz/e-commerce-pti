@extends('layouts.app')

@section('title', 'Manage Driver Product')

@section('css')
@endsection

@section('content')
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Kelola Driver Produk</h5>
            <div class="ibox-tools">
            </div>
        </div>
        <div class="ibox-content">
            <form role="form"
                action="{{ !empty($driver) ? url('driver-product/update/' . @$driver->id) : url('driver-product/store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Produk</label>
                    <select class="form-control" name="id_product" @if (Auth::user()->role == 'driver') disabled @endif>
                        @foreach ($product as $item)
                            <option value="{{ $item->id }}"
                                {{ old('id_product', @$item->id == @$driver->id_product ? 'selected' : '') }}>
                                {{ $item->product->name->name }} - {{ $item->id }}</option>
                        @endforeach
                    </select>
                    <div>
                        <div class="form-group mt-3">
                            <label for="example-text-input" class="form-control-label">Driver</label>
                            <select class="form-control" name="id_user" @if (Auth::user()->role == 'driver') disabled @endif>
                                @foreach ($user as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('id_user', @$item->id == @$driver->id_user ? 'selected' : '') }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                            <div>
                                @if (Auth::user()->role == 'driver')
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">File</label>
                                        <input class="form-control" name="file" value="{{ old('file', @$driver->file) }}"
                                            type="file">
                                    </div>
                                @endif
                                <div class="mt-3">
                                    <button class="btn btn-sm btn-primary w-100"
                                        type="submit"><strong>Simpan</strong></button>
                                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
@endsection
