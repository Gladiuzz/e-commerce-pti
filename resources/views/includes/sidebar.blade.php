<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="{{ asset('img/profile_small.jpg') }}" />
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{ Auth::user()->name }}</span>
                        <span class=" text-xs block">{{ Auth::user()->role }}<b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <li>
                                <button class="border-0 dropdown-item p-2 bg-transparent logout">Log out</button>
                            </li>
                        </form>
                    </ul>
                </div>
                <div class="logo-element">
                    T+
                </div>
            </li>
            <li class="{{ Request::path() == '/dashboard' ? 'active' : '' }}">
                <a href="/dashboard"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            @if (Auth::user()->role == 'admin')
                <li class="{{ Request::path() == 'transaction' ? 'active' : '' }}">
                    <a href="/transaction"><i class="fa fa-shopping-cart"></i> <span
                            class="nav-label">Transaction</span> </a>
                </li>
                <li class="{{ Request::path() == 'fee' ? 'active' : '' }}">
                    <a href="/fee"><i class="fa fa-money"></i> <span class="nav-label">Data Pajak Penarikan</span> </a>
                </li>
                <li class="{{ Request::path() == 'category' ? 'active' : '' }}">
                    <a href="/category"><i class="fa fa-tags"></i> <span class="nav-label">Kategori</span> </a>
                </li>
                <li class="{{ Request::path() == 'product-name' ? 'active' : '' }}">
                    <a href="/product-name"><i class="fa fa-tags"></i> <span class="nav-label"> Nama Produk</span> </a>
                </li>
                <li class="{{ Request::path() == 'monitoring' ? 'active' : '' }}">
                    <a href="/monitoring"><i class="fa fa-desktop"></i> <span class="nav-label">Monitoring
                            Penjual</span>
                    </a>
                </li>
                <li class="{{ Request::path() == 'contact' ? 'active' : '' }}">
                    <a href="/contact"><i class="fa fa-phone"></i> <span class="nav-label">Kelola Kontak</span> </a>
                </li>
                <li class="{{ Request::path() == '/user' ? 'active' : '' }}">
                    <a href="/user"><i class="fa fa-user"></i> <span class="nav-label">Kelola User</span><span
                            class="fa arrow"></span> </a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="/user-customer">Customer</a></li>
                        <li><a href="/user-seller">Seller</a></li>
                        <li><a href="/user-driver">Driver</a></li>
                    </ul>
                </li>
            @elseif(Auth::user()->role == 'driver')
                <li class="{{ Request::path() == '/list-cod' ? 'active' : '' }}">
                    <a href="/driver-product"><i class="fa fa-list"></i> <span class="nav-label">Data Pengiriman</span> </a>
                </li>
            @else
                <li class="{{ Request::path() == 'transaction' ? 'active' : '' }}">
                    <a href="/transaction"><i class="fa fa-shopping-cart"></i> <span
                            class="nav-label">Transaction</span> </a>
                </li>
                <li class="{{ Request::path() == 'order' ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-money"></i> <span class="nav-label">Kelola Order</span><span
                            class="fa arrow"></span> </a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="/order/processing">Order Processing</a></li>
                        <li><a href="/order/cancelled">Order Cancelled</a></li>
                        <li><a href="/order/delivered">Order Delivered</a></li>
                        <li><a href="/order/success">Order Success</a></li>
                    </ul>
                </li>
                <li class="{{ Request::path() == '/list-cod' ? 'active' : '' }}">
                    <a href="/driver-product"><i class="fa fa-list"></i> <span class="nav-label">list-cod</span> </a>
                </li>
                <li class="{{ Request::path() == '/product' ? 'active' : '' }}">
                    <a href="/product"><i class="fa fa-dropbox"></i> <span class="nav-label">Produk</span> </a>
                </li>
                <li class="{{ Request::path() == '/user-seller' ? 'active' : '' }}">
                    <a href="#"><i class="fa fa-user"></i> <span class="nav-label">User</span><span
                            class="fa arrow"></span> </a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="/user-customer">Customer</a></li>
                    </ul>
                    {{-- <ul class="nav nav-second-level collapse">
                        <li><a href="/user-driver">Driver</a></li>
                    </ul> --}}
                </li>
            @endif
        </ul>

    </div>
</nav>
