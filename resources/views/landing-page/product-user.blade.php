@extends('layouts.app-user')

@section('content')
    <section id="product" class="mt-5 container services">
        <h1>List Product</h1>
        <hr />
        <div class="row">
            @if (count($product) > 0)
                @foreach ($product as $item)
                    <div class="col-md-3">
                        <div class="ibox">
                            <div class="ibox-content product-box">
                                @if (count($item->productImage) > 0)
                                    <div class="product-images-index m-0">
                                        @foreach ($item->productImage as $value)
                                            <img class=" image-product"
                                                src="{{ asset('storage/product/image/' . $value->url_image) }}"
                                                alt="">
                                        @endforeach
                                    </div>
                                @else
                                    <div class="product-imitation">
                                        [ Lihat Produk ]
                                    </div>
                                @endif
                                <div class="product-desc">
                                    <span class="product-price">
                                        @currency($item->price)
                                    </span>
                                    {{-- Buat Category --}}
                                    <small class="text-muted">{{ $item->productCategory->name }}</small>
                                    <a href="#" class="product-name"> {{ $item->name->name }}</a>



                                    <div class="small m-t-xs">
                                        {{ $item->description }}
                                    </div>
                                    <div class="m-t text-righ">
                                        <a href="/product-user/{{ $item->productCategory->name }}/{{ $item->id }}"
                                            class="btn btn-xs btn-outline btn-primary">Lihat Produk <i
                                                class="fa fa-long-arrow-right"></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-md-3">
                    <h1>Data Kosong</h1>
                </div>
            @endif
            {{-- <div class="col-md-12">
            <a href="/product-user" class="w-100 btn btn-outline-warning">More Product</a>
        </div> --}}
        </div>
    </section>

@endsection
