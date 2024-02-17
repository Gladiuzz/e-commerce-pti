@extends('layouts.app-user')


@section('content')
    <div class="wrapper wrapper-content p-xl">
        <div class="ibox-content p-xl">
            <div class="row">
                <div class="col-sm-6">
                    <address>
                        <strong>Pasar Tani</strong><br>
                        Alamat Pasar Tani<br>
                        Kecamatan dan kota pasar tani <br>
                        {{-- <abbr title="Phone"></abbr> (123) 601-4590 --}}
                    </address>
                </div>

                <div class="col-sm-6 text-right">
                    <h4>Invoice No.</h4>
                    <h4 class="text-navy">{{ $detail->id_trx }}</h4>
                    <address>
                        <strong>{{ $detail->transactionDetail->name }}</strong><br>
                        {{ $detail->transactionDetail->email }} <br>
                        <abbr title="Phone"></abbr> (+62) {{ $detail->transactionDetail->phone_number }}
                    </address>
                    <p>
                        <span><strong>Invoice Date: </strong>{{ $detail->getTanggal() }}</span><br />
                    </p>
                </div>
            </div>

            <div class="table-responsive m-t">
                <table class="table invoice-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detail->transactionProduct as $item)
                            <tr>
                                <td><strong>{{ $loop->iteration }}</strong></td>
                                <td>{{ $item->product->name->name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>@currency($item->product->price * $item->qty)</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div><!-- /table-responsive -->

            <table class="table invoice-total">
                <tbody>
                    <tr>
                        <td><strong>Sub Total :</strong></td>
                        <td>@currency($sub_total)</td>
                    </tr>
                    <tr>
                        <td><strong>biaya pengiriman :</strong></td>
                        <td>@currency($shipping_cost)</td>
                    </tr>
                    <tr>
                        <td><strong>TOTAL :</strong></td>
                        <td>@currency($detail->amount)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
