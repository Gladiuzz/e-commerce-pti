@extends('layouts.app-user')

@section('content')
    <form action="{{ route('payment') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="container-fluid align-items-center justify-content-center mt-5">
            <div class="row mx-2 my-5">
                <div class="col-md-6 col-sm-12 my-5">
                    <div class="card-fluid rounded">
                        <div class="card-header bg-dark text-white">
                            Detail Tagihan
                        </div>
                        <div class="card-body border border-dark ">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputName4">Name</label>
                                        <input type="text" name="name" value="{{ Auth::user()->name }}"
                                            class="form-control name_customer" required id="inputName4">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPhone">Nomor</label>
                                        <input type="number" name="phone_number" value="{{ Auth::user()->phone }}"
                                            class="form-control phone_customer" required id="inputPhone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail">Email</label>
                                    <input type="email" value="{{ Auth::user()->email }}"
                                        class="form-control email_customer" name="email" id="inputEmail" required
                                        placeholder="yourmail@mail.com">
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Alamat</label>
                                    <textarea class="form-control address_customer" name="full_address" id="inputAdress" required rows="3">{{ Auth::user()->address }}</textarea>
                                </div>
                                <div class="form-row">
                                    {{-- <div class="form-group col-md-6">
                                        <label for="province">Province</label>
                                        <select class="form-control" name="province" id="province" required>
                                            <option value="">Select Province</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="city">Kota</label>
                                        <select class="form-control" name="city" id="city" required>
                                            <option value="">Select Kota</option>
                                        </select>
                                    </div> --}}
                                    <div class="form-group col-md-12">
                                        <label for="city">Driver</label>
                                        <select class="form-control" name="driver" required>
                                            @foreach ($driver as $item)
                                            <option value="{{ $item->id }}">Driver {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputZip">Kode Pos</label>
                                        <input type="number" class="form-control zip_code_customer" name="zip_code"
                                            required id="inputZip">
                                    </div>
                                </div>
                                {{-- <div class="form-group" id="courier">
                                    <div class="col" id="label-courier">
                                        <label>Select Kurir</label>
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                    <label for="inputAddress">Metode Pembayaran</label>
                                    <select class="form-control" name="payment_method" required>
                                        <option value="online">Online</option>
                                        <option value="cod">Cash On Delivery (COD)</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 my-5">
                    <div class="card-fluid rounded">
                        <div class="card-header card-checkout bg-dark text-white">
                            Pesanan Kamu
                        </div>
                        <div class="card-body border border-dark ">
                            <?php $total = 0; ?>
                            @foreach ((array) session()->get('cart') as $cart => $item)
                                <?php $total += $item['product']->price * $item['qty']; ?>
                                <div class="row detail-order mb-2 parent_checkout">
                                    <div class="col-md-3">
                                        {{-- <div class="image-checkout img-thumbnail">
                                    <div class="image-imitation"></div>
                                </div> --}}
                                        <img src="{{ asset('storage/product/image/' . $item['product']->productImage[0]->url_image) }}"
                                            class="image-checkout img-thumbnail" alt="...">
                                    </div>
                                    <div class="col-md-6 text-left">
                                        <h4>Product Name </h4>
                                        <p>{{ $item['product']->name->name }}</p>
                                        <h4>Quantity </h4>
                                        <p>{{ $item['qty'] }}</p>
                                        {{-- <h4 id="ongkir">Ongkir  </h4><p id="price-ongkir">Rp.</p> --}}
                                        {{-- <input type="hidden" class="courier_service" name="courier_service"> --}}
                                    </div>
                                    <div class="col-md-3 text-right subcheckout">
                                        <h5>Price : @currency($item['product']->price * $item['qty'])</h5>
                                    </div>

                                </div>
                            @endforeach
                            <hr class="border border-dark">
                            <div class="row" id="ongkir">
                                <div class="col-md-6 col-sm-6">
                                    <h4 class="text-left">biaya pengiriman</h4>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <h4 class="text-right" id="price-ongkir">@currency(10000)</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <h4 class="text-left">TOTAL</h4>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <h4 class="text-right total" data-price="{{ $total }}">@currency($total + 10000)</h4>
                                    <input type="hidden" class="total_value" name="total_price"
                                        value="{{ $total + 10000 }}">
                                    <input type="hidden" class="total_value" name="courier_amount"
                                        value="10000">
                                </div>
                                <div id="hidden"></div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2 btn-block payment_btn mt-3" target="_blank"
                        id="btn-pay">Pesan Sekarang</button>
                </div>
            </div>
        </div>

    </form>
@endsection

@section('script')
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        // $('#btn-pay').css('display', 'none');
        $(document).ready(function() {
            // $("#province").select2();
            // $("#city").select2();
            // $("#label-courier").hide();
            // $("#price-ongkir").hide();
            // $("#ongkir").hide();

            // Get Province
            getProvince();

            // Get City
            getCity();

            // get Courier
            getCourier()

            function checkCourier() {
                $('input[name="courier_amount"]').change(function() {
                    $("#price-ongkir").show();
                    $("#ongkir").show();
                    $("#btn-pay").show();
                    var total_calculation;
                    var value = $('input[name="courier_amount"]:checked').val();
                    var price = $('input[name=total_price]').val()
                    var ongkir = (value / 1000).toFixed(3);
                    $('#price-ongkir').text('Rp.' + ongkir)
                    value = parseInt(value) + parseInt(price)
                    console.log(value)
                    $('.total').text(formatRupiah(value));
                })
            }

            function formatRupiah(angka) {
                var rupiah = '';
                var angkarev = angka.toString().split('').reverse().join('');
                for (var i = 0; i < angkarev.length; i++) {
                    if (i % 3 === 0) {
                        rupiah += angkarev.substr(i, 3) + '.';
                    }
                }
                return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
            }

            function getProvince() {
                // $("#province").empty().append('<option value="">Select Province</option>')
                $.ajax({
                    url: '{{ route('getProvince') }}',
                    method: 'get',
                    success: (resp) => {
                        if (resp) {
                            resp.data.rajaongkir.results.forEach(element => {
                                $('#province').append(
                                    `<option value="${element.province_id}">${element.province}</option>`
                                )
                            });
                        }
                    },
                    error: (err) => {
                        console.log(err)
                    }
                });
            }

            function getCity() {
                $('select[name=province]').change(() => {
                    $("#city").empty().append('<option value="">Select City</option>')
                    let province = $('select[name=province]').val()
                    let url = '{{ route('getcity', ':id') }}';
                    url = url.replace(':id', province);
                    $.ajax({
                        url: url,
                        method: 'get',
                        success: (resp) => {
                            if (resp) {
                                resp.data.rajaongkir.results.forEach(element => {
                                    $('#city').append(
                                        `<option value="${element.city_id}">${element.type} ${element.city_name}</option>`
                                    )
                                });
                            }
                        },
                        error: (err) => {
                            console.log(err)
                        }
                    });
                });
            }

            function getCourier() {
                $('select[name=city]').change(() => {
                    $("#courier").empty()
                    $('#courier').append(`
                    <div class="col pl-0" id="label-courier">
                        <label >Select Courier</label>
                    </div>
                    `)
                    // $("#label-courier").show();
                    let city = $('select[name=city]').val();
                    let city_name = $('#city option:selected').text();
                    let province_name = $('#province option:selected').text();
                    let url = '{{ route('courier', ':id') }}';
                    url = url.replace(':id', city);
                    $.ajax({
                        url: url,
                        method: 'get',
                        success: (resp) => {
                            if (resp) {
                                resp.data.rajaongkir.results[0].costs.forEach(element => {
                                    $('#courier').append(`
                                        <div class="col ml-2">
                                            <input class="form-check-input" type="radio" name="courier_amount" value="${element.cost[0].value}" id="${element.service}">
                                            <label class="form-check-label" for="${element.service}">
                                                JNE - ${element.service} (${element.cost[0].etd} Hari) : Rp.${(element.cost[0].value/1000).toFixed(3)}
                                            </label>
                                        </div>
                                    `)
                                    $('#hidden').append(`
                                        <div class="col ml-2">
                                            <input class="form-check-input" type="hidden" name="city_name" value="${city_name}">
                                            <input class="form-check-input" type="hidden" name="province_name" value="${province_name}">
                                        </div>
                                    `)
                                });

                                checkCourier()
                            }
                        },
                        error: (err) => {
                            console.log(err)
                        }
                    });
                });
            }
        });
    </script>
@endsection
