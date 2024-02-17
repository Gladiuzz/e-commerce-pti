@extends('layouts.app')

@section('title', 'Manage product')

@section('css')
@endsection

@section('content')
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Kelola Category</h5>
            <div class="ibox-tools">
            </div>
        </div>
        <div class="ibox-content">
            <form role="form"
                action="{{ !empty($category) ? url('category/update/' . @$product->id) : url('category/store') }}"
                method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" placeholder="Enter Category Name" value="{{ old('name', @$category->name) }}"
                        name="name" class="form-control">
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
