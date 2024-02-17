@extends('layouts.app-user')

@section('content')
    <form action="{{ route('add.cart') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <section class="product-detail container mt-5">
            <div class="row">
                <div class="col-md-5">
                    <div class="product-images">
                        @foreach ($product->productImage as $item)
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
                        <h2 class="product-main-price">@currency($product->price) <small class="text-muted"></small> </h2>
                    </div>
                    <hr>

                    <h4>Keterangan Produk</h4>

                    <div class="small text-muted">
                        {!! $product->description !!}
                    </div>
                    <h4>Keterangan Pembelian</h4>

                    <div class="small text-muted">
                        {!! $product->purchase_detail !!}
                    </div>
                    <h4>Informasi Kedaluwarsa</h4>

                    <div class="small text-muted">
                        {!! $product->expired_information !!}
                    </div>

                    <h4>Musim panen</h4>

                    <div class="small text-muted">
                        {!! $product->harvest_season !!}
                    </div>
                    <h4>Nama Penjual</h4>
                    <div>
                        <a href="{{ url('/product-user/search/?seller=' . $product->user->name) }}"
                            class="text-navy seller-name">{{ $product->user->name }}</a>
                    </div>


                    <div class="row">
                        <div class="col">
                            <dl class="medium m-t-md">
                                <dt>Weight</dt>
                                <dd>{{ $product->weight }}.</dd>
                            </dl>
                            <dl class="medium m-t-md">
                                <dt>Stok</dt>
                                <dd>{{ $product->stock }}.</dd>
                            </dl>
                        </div>
                    </div>
                    <dl class="medium font-family">
                        {{-- <input type="text" name="" id="" disabled> --}}
                        <h4 class="m-t-md font-family">Jumlah</h4>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-outline btn-dark btn_plus"><i
                                    class="fa fa-plus"></i></button>
                            <input type="number" class="border border-dark qty" value="1" min="1"
                                max="10" name="qty" id="qty" disabled style="width: 2.5rem">
                            <button type="button" class="btn btn-outline btn-dark btn_minus"><i
                                    class="fa fa-minus"></i></button>
                        </div>
                        {{-- <input class="touchspin1 w-50" type="text" value="" name="demo1"> --}}
                    </dl>
                    <hr>
                    <input type="hidden" name="session_stock" value="{{ $product->stock }}" class="session_stock">
                    <a href="#" data-id="{{ $product->id }}" class="btn btn-primary add-cart">Tambah Product</a>
                </div>
            </div>
        </section>

    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.btn_plus').click(function() {
                var input = $(".qty");
                $(".qty").attr('maxlength', 10);
                if ($(".qty").val() == $('.session_stock').val()) {
                    console.log('max');
                } else {
                    $(".qty").val(function(i, oldval) {
                        // console.log($(".qty").val());
                        return ++oldval;
                    });

                }
                // console.log(input.val());
            });

            $('.btn_minus').click(function() {
                var input = $(".qty");
                $(".qty").prop('min', 1);
                if ($(".qty").val() == 1) {
                    console.log('min is 1');
                } else if ($(".qty").val() == 0) {
                    Swal.fire(
                        'Oops...',
                        'Quantity has run out',
                        'error'
                    );
                } else {
                    $(".qty").val(function(i, oldval) {
                        // console.log($(".qty").val());
                        return --oldval;
                    });

                }
                // console.log(input.val());
            })


            $('.add-cart').click(function() {
                console.log('test');
                var id = $(this).data('id');
                var qty = $(".qty").val();

                $.ajax({
                    method: 'POST',
                    url: '{{ route('add.cart') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: id,
                        qty: qty
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response['status'] == 'denied') {
                            Swal.fire(
                                'Oops...',
                                response['message'],
                                'error'
                            );
                        } else {
                            console.log(response);
                            location.reload();
                        }

                    },
                    error: function(xhr, eror, status) {
                        console.log(status);
                    }
                })
            })
        });
    </script>
@endsection
