@extends('layouts.app-user')

@section('content')
    <div id="inSlider" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#inSlider" data-slide-to="0" class="active"></li>
            <li data-target="#inSlider" data-slide-to="1"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <div class="container">
                    <div class="carousel-caption">
                        <center>
                            <h1>Pasar Tani<br />
                                <i> SELAMAT DATANG DI TOKO KAMI, AYO BELI PRODUK KAMI<br />
                                    KARENA YANG LAIN BELUM TENTU PRODUKNYA BERKUALITAS<br />
                                    SELAMAT BERBELANJA SEMOGA MEMUASKAN
                            </h1>
                            </i>
                            <p>
                        </center>
                        <br>
                        <br>
                        <br>
                        <a class="btn btn-lg btn-primary" href="/pendaftaran" role="button">Informasi Pendaftaran Bagi
                            Penjual</a>

                        </p>
                    </div>
                    {{-- <div class="carousel-image wow zoomIn">
                    <img src="{{asset('landing-page/img/laptop.png')}}" alt="laptop"/>
                </div> --}}
                </div>
                <!-- Set background for slide in css -->
                <div class="header-back one"></div>

            </div>
            <div class="carousel-item">
                <div class="container">
                    <div class="carousel-caption blank">
                        <h1>We create meaningful <br /> interfaces that inspire.</h1>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam.</p>
                        <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
                    </div>
                </div>
                <!-- Set background for slide in css -->
                <div class="header-back two"></div>
            </div>
        </div>
    </div>

    <section id="product" class="container services" style="margin-top:24em">>
        <h1>Produk</h1>
        <hr />
        <div class="row">
            @foreach ($product as $item)
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">
                            @if (count($item->productImage) > 0)
                                <div class="product-images-index m-0">
                                    @foreach ($item->productImage as $value)
                                        <img class=" image-product"
                                            src="{{ asset('storage/product/image/' . $value->url_image) }}" alt="">
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

                                <small><a href="{{ url('/product-user/search/?seller=' . $item->user->name) }}"
                                        class="text-navy seller-name">{{ $item->user->name }}</a></small>

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
            <div class="col-md-12">
                <a href="/product-user/all" class="w-100 btn btn-outline-warning">Lihat Produk</a>
            </div>
        </div>
    </section>

    <section id="product" class="container services">
        <h3 class="mt-2">Product Dengan Stock Terbanyak</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productStok->sortByDesc(function ($items) {
            return $items->sum('stock');
        }) as $name => $items)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $name }}</td>
                            <td>{{ $items->sum('stock') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>

        <section id="category" class="container services">
            <h1>Kategori</h1>
            <hr />
            <div class="row">
                @foreach ($category as $item)
                    <div class="col-md-3">
                        <a href="{{ url('/product-user/' . $item->name) }}">
                            <div class="widget style1 widget-custom">
                                <div class="row vertical-align">
                                    <div class="col d-flex justify-content-center align-items-center">
                                        <h3 class="m-0">{{ $item->name }}</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endsection
