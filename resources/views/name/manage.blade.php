@extends('layouts.app')

@section('title', 'Manage Name Product')

@section('css')
@endsection

@section('content')
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Kelola Nama Produk</h5>
            <div class="ibox-tools">
            </div>
        </div>
        <div class="ibox-content">
            <form role="form"
                action="{{ !empty($name) ? url('product-name/update/' . @$name->id) : url('product-name/store') }}"
                method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" placeholder="Enter Name" value="{{ old('name', @$name->name) }}" name="name"
                        class="form-control">
                <div>
                <div class="form-group">
                    <label>Batasan Harga</label>
                    <input type="number" placeholder="Enter Batasan Harga" value="{{ old('batasan_harga', @$name->batasan_harga) }}" name="batasan_harga"
                        class="form-control">
                <div>
                <div class="mt-3">
                    <button class="btn btn-sm btn-primary w-100" type="submit"><strong>Simpan</strong></button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
@endsection
