@extends('layouts.app')

@section('title', 'Manage product')

@section('css')
@endsection

@section('content')
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Manage Product</h5>
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
            <form role="form"
                action="{{ !empty($product) ? url('product/update/' . @$product->id) : url('product/store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Product Name</label>
                    <select class="form-control" name="name_id">
                        @foreach ($name as $item)
                            <option value="{{ $item->id }}"
                                {{ old('name_id', @$item->id == @$product->name_id ? 'selected' : '') }} data-harga={{$item->batasan_harga}}>{{ $item->name }} - Rekomendasi Harga {{$item->batasan_harga}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label>Keterangan Produk</label>
                    <textarea placeholder="Enter Description" name="description" class="form-control">{{ old('description', @$product->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Detail Pembelian Produk</label>
                    <textarea placeholder="Enter Purchase Detail" name="purchase_detail" class="form-control">{{ old('purchase_detail', @$product->purchase_detail) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Informasi Kedaluwarsa</label>
                    <textarea placeholder="Enter Expired Information" name="expired_information" class="form-control">{{ old('expired_information', @$product->expired_information) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Musim Panen</label>
                    <textarea placeholder="Enter Harvest Season" name="harvest_season" class="form-control">{{ old('harvest_season', @$product->harvest_season) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" placeholder="Enter price" value="{{ old('price', @$product->price) }}"
                        name="price" class="form-control" id="priceInput"/>
                    <span id="priceWarning" style="color: red; display: none;">Harga melebihi batas</span>
                </div>
                <div class="form-group">
                    <label>Weight</label>
                    <input type="number" placeholder="Enter weight" value="{{ old('weight', @$product->weight) }}"
                        name="weight" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" placeholder="Enter stock" value="{{ old('stock', @$product->stock) }}"
                        name="stock" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Kategori</label>
                    <select class="form-control" name="category_id">
                        {{-- <option value="" selected disabled>Choose Category</option> --}}
                        @foreach ($category as $item)
                            <option value="{{ $item->id }}"
                                {{ old('category_id', @$item->id == @$product->category_id ? 'selected' : '') }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Upload Image</label>
                        <input class="form-control" value="{{ old('url_image', @$product->productImage[0]->url_image) }}"
                            type="file" name="url_image">
                    </div>
                    {{-- <input type="number" placeholder="Enter stock" value="{{old('stock', @$product->stock)}}" name="stock" class="form-control"></div> --}}
                    <div class="mt-3">
                        <button class="btn btn-sm btn-primary w-100" id="submitButtonId" type="submit"><strong>Simpan</strong></button>
                    </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var priceInput = document.getElementById("priceInput");
        var priceWarning = document.getElementById("priceWarning");
    
        var nameSelect = document.querySelector("select[name='name_id']");
        var hargaAttribute = nameSelect.options[nameSelect.selectedIndex].getAttribute("data-harga");
        var batasanHarga = parseInt(hargaAttribute);
    
        priceInput.addEventListener("input", function() {
            var enteredPrice = parseInt(this.value);
            
            if (enteredPrice > batasanHarga) {
                priceWarning.style.display = "inline";
                // You can also disable the submit button to prevent form submission.
                // Replace "submitButtonId" with the ID of your submit button.
                document.getElementById("submitButtonId").disabled = true;
            } else {
                priceWarning.style.display = "none";
                // If you disabled the submit button above, you can enable it here.
                document.getElementById("submitButtonId").disabled = false;
            }
        });
    });
    </script>
    
@endsection
