@extends('layouts.app-user')

@section('content')
    <section class="mt-5 container services">
        <div class="row">
            <div class="col-md-12">

                <div class="ibox">
                    <div class="ibox-title">
                        <h1>Order</h1>
                        <span class="float-right">(<strong>{{ count($history) }}</strong>) items</span>
                        <h5>Items in your history order</h5>
                    </div>
                    @foreach ($history as $key => $item)
                        <h3 class="mt-3 px-3">#{{ $key + 1 }} {{ $item->trx_id }}</h3>
                        <div class="ibox-content border-warning">
                            <div class="table-responsive">
                                <table class="table shoping-cart-table">
                                    <tbody>
                                        <tr>
                                            <td class="desc">
                                                <h3>
                                                    @if ($item->transactionDetail->courier_status == 'Cancelled')
                                                        <a href="#" class="text-danger">
                                                            {{ $item->transactionDetail->courier_status }}
                                                        </a>
                                                    @elseif($item->status == 'Cancelled' || $item->status == 'Expired')
                                                        <a href="#" class="text-danger">
                                                            {{ $item->status }}
                                                        </a>
                                                    @elseif($item->status == 'Pending')
                                                        <a href="#" class="text-gray">
                                                            {{ $item->status }}
                                                        </a>
                                                    @elseif($item->status == 'Settlement')
                                                        <a href="#" class="text-navy">
                                                            {{ $item->transactionDetail->courier_status }}
                                                        </a>
                                                    @endif
                                                </h3>
                                                <p class="small">
                                                    Receipt Name : {{ $item->transactionDetail->name }} <br />
                                                    Address : {{ $item->transactionDetail->full_address }} -
                                                    {{ $item->transactionDetail->city }} -
                                                    {{ $item->transactionDetail->province }}
                                                    {{ $item->transactionDetail->zip_code }}<br />
                                                    Phone Number/Email : {{ $item->transactionDetail->phone_number }} -
                                                    {{ $item->transactionDetail->email }}
                                                </p>

                                                <div class="m-t-sm">
                                                    <a href="/order/invoice/{{ $item->id }}"
                                                        class="text-success mr-5"><i class="fa fa-clipboard"></i>
                                                        Invoice</a>
                                                    @if ($item->status == 'Pending')
                                                        @if ($item->method != 'cod')
                                                            <a href="{{ $item->url }}" class="text-success mr-5"><i
                                                                    class="fa fa-money"></i> Bayar</a>
                                                        @endif
                                                        <a href="/order-cancel/{{ $item->id }}" class="text-danger"><i
                                                                class="fa fa-close"></i> Cancel Orderan</a>
                                                    @endif
                                                    @if ($item->transactionDetail->courier_status == 'Delivered')
                                                        <a href="/received-product/{{ $item->transactionDetail->id }}"
                                                            class="text-success mr-5"><i class="fa fa-dropbox"></i> Produk
                                                            Diterima</a>
                                                    @endif
                                                    {{-- <a href="#" class="text-info collapse-link"><i class="fa fa-eye"></i> Detail Product</a> --}}
                                                </div>
                                            </td>

                                            <td>
                                                @currency($item->amount)
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="ibox collapsed m-b-none">
                            <div class="ibox-title border-info border-detail-product">
                                <h5>Product Detail</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                </div>
                            </div>
                            @foreach ($item->transactionProduct as $product)
                                <div class="ibox-content border-0">
                                    <table class="table shoping-cart-table">
                                        <tbody>
                                            <tr>
                                                @foreach ($product->product->productImage as $img)
                                                    <td width="90">
                                                        <img class="img-fluid"
                                                            src={{ asset('storage/product/image/' . $img->url_image) }}
                                                            alt="">
                                                        {{-- <div class="cart-product-imitation">
                                            </div> --}}
                                                    </td>
                                                @endforeach
                                                <td class="desc">
                                                    <h3>
                                                        <a href="#" class="text-info">
                                                            {{ $product->product->name->name }}
                                                        </a>
                                                    </h3>
                                                    <p class="small">
                                                        Quantity : {{ $product->qty }} <br />
                                                        Weight : {{ $product->product->weight }}<br />
                                                        Price : @currency($product->product->price)<br />
                                                    </p>
                                                    <dl class="small m-b-none">
                                                        <dt>Description</dt>
                                                        <dd>{{ $product->product->description }}</dd>
                                                    </dl>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
@endsection
