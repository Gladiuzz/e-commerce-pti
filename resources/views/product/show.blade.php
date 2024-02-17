@extends('layouts.app')
@section('title', 'Detail Product')


@section('css')

    <link href="{{ asset('css/plugins/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/slick/slick-theme') }}.css" rel="stylesheet">

@endsection

@section('content')
    <div class="ibox product-detail">
        <div class="ibox-content">

            <div class="row">
                <div class="col-md-5">
                    <div class="product-images">
                        @foreach ($image as $item)
                            <img class=" image-product" src="{{ asset('storage/product/image/' . $item->url_image) }}"
                                alt="">
                        @endforeach
                    </div>
                </div>
                <div class="col-md-7 ">
                    <h2 class="font-bold m-b-xs">
                        {{ $product->name->name }}
                    </h2>
                    <div class="m-t-md">
                        <h2 class="product-main-price">Rp.{{ $product->price }} <small class="text-muted"></small> </h2>
                    </div>
                    <hr>

                    <h4>Keterangan Produk</h4>

                    <div class="small text-muted">
                        {!! $product->description !!}
                    </div>
                    <div class="row">
                        <div class="col">
                            <dl class="medium m-t-md">
                                <dt>Weight</dt>
                                <dd>{{ $product->weight }}.</dd>
                            </dl>
                        </div>
                        <div class="col">
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- slick carousel-->
    <script src="{{ asset('js/plugins/slick/slick.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.product-images').slick({
                dots: false
            });

        });
    </script>
@endsection
