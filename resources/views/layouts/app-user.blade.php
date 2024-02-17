<!DOCTYPE html>
<html lang="en">
@include('includes.head-user')

<body id="page-top" class="landing-page">

@include('includes.navbar-user')


{{-- <section class="container services"> --}}
    @yield('content')
{{-- </section> --}}


@if(!empty($contact))
<section id="contact" class="gray-section contact">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Contact Us</h1>
                {{-- <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p> --}}
            </div>
        </div>
        <div class="row m-b-lg justify-content-center">
            <div class="col-lg-3 ">
                <address>
                    <strong><span class="navy">Pasar Tani, Inc.</span></strong><br/>
                    {{$contact->address}}<br/>
                    {{-- San Francisco, CA 94107<br/> --}}
                    <abbr title="Phone">P:</abbr> {{$contact->phone}}
                </address>
            </div>
            <div class="col-lg-4">
                <p class="text-color">
                    {{$contact->description}}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="mailto:{{$contact->mail}}" class="btn btn-primary">Send us mail</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center m-t-lg m-b-lg">
                <p><strong>&copy; 2023 Pasar Tani</strong><br/> consectetur adipisicing elit. Aut eaque, laboriosam veritatis, quos non quis ad perspiciatis, totam corporis ea, alias ut unde.</p>
            </div>
        </div>
    </div>
</section>
@endif

<div id="right-sidebar" class="animated fadeInRight">
    <div class="sidebar-container p-3">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <h3><i class="fa fa-shopping-cart"></i> Cart</h3>
                    {{-- <p class="my-auto close clos-button">
                        <i class="fa fa-times text-danger"></i>
                    </p> --}}
                </div>
                <hr/>
            </div>
            <div class="box-product-cart col-12">
                @foreach ((array)session()->get('cart') as $key => $item)
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>{{ $item['product']->name->name }}</h4>
                            <p class="my-auto">
                                <a href="#" class="remove-cart" data-id="{{ $item['product']->id }}"><i class="fa fa-trash text-danger"></i></a>
                            </p>
                        </div>
                        <div class="small m-t-xs text-muted">{{ $item['product']->productCategory->name }}</div>
                        <div class="small m-t-xs">Quantity {{ $item['qty'] }}</div>
                        <div class="small m-t-xs"><a href="{{url('/product-user/search?seller='.$item['product']->user->name)}}">Seller : {{ $item['product']->user->name }}</a></div>
                        <div class="medium m-t-xs">@currency($item['product']->price * $item['qty'])</div>
                        <hr/>
                    </div>
                @endforeach

            </div>
            <div class="col-12 fixed-bottom mb-3">
                <a href="/checkout" class="btn btn-sm btn-outline-primary w-100">Checkout</a>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('landing-page/js/classie.js')}}"></script>
<script src="{{asset('landing-page/js/cbpAnimatedHeader.js')}}"></script>
<script src="{{asset('landing-page/js/wow.min.js')}}"></script>
<script src="{{asset('landing-page/js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/plugins/slick/slick.min.js')}}"></script>
@yield('script')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{asset('js/popper.min.js')}}"></script>

<!-- Custom and plugin javascript -->
<script src="{{asset('js/inspinia.js')}}"></script>
<script src="{{asset('js/plugins/pace/pace.min.js')}}"></script>


<script>
    $(document).ready(function(){
        $('.right-sidebar-toggle').click(()=>{
            $("#right-sidebar").toggleClass('sidebar-open')
        })

        $('.close-button').click((e)=>{
            // e.stopPropagation();
            $("#right-sidebar").removeClass('sidebar-open')
        })

        // remove product from cart ajax
        $('.remove-cart').click(function() {
            var id = $(this).data('id');

            $.ajax({
                method: 'delete',
                url: '{{ route('delete.cart.product') }}',
                data: {_token: '{{ csrf_token() }}', product_id: id},
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                dataType: "json",
                success: function (response) {
                    location.reload();
                },
                error: function(xhr, eror, status) {
                    console.log('gagal');
                },
            })
        })
    });
</script>
</body>
</html>
