<div class="navbar-wrapper">
    <nav class="navbar navbar-default navbar-fixed-top navbar-expand-md {{ Request::path() == 'product-user/1' ? 'navbar-scroll' : '' }} "
        role="navigation">
        <div class="container">
            {{-- <a class="navbar-brand" href="/">Pasar Tani</a> --}}
            <div class="navbar-header page-scroll">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbar">
                <ul class="nav navbar-nav text-dark">
                    <li><a class="nav-link page-scroll" href="/">Home</a></li>
                    <li><a class="nav-link page-scroll" href="#product">Produk</a></li>
                    <li><a class="nav-link page-scroll" href="#contact">Kontak</a></li>
                    @if (!Auth::user())
                        <li><a class="nav-link page-scroll" href="/login">Login</a></li>
                    @else
                        <li><a class="nav-link page-scroll" href="/order">Order</a></li>
                        <li><a href="/ubah-profil-pelanggan"><i class="fa fa-user"></i></a></li>
                        <li><a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"
                                class="nav-link page-scroll">Logout</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                            {{-- <button class="border-0 bg-transparent font-weight-bold logout">Log out</button> --}}
                        </form>
                    @endif
                    <li><a class="right-sidebar-toggle"><i class="fa fa-shopping-cart"></i></a></li>
                    <li>
                        <form role="search" class="pt-3" action="{{ url('/product-user/search') }}">
                            {{-- @csrf --}}
                            <div class="form-group bg-transparent d-flex">
                                <input class="form-control border-dark mr-2" type="search" name="search"
                                    placeholder="Search Product" id="search" aria-label="Search">
                                <button class="btn btn-dark" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
