<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/products/"><span class="fa fa-archive"></span>&nbsp;Products</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="/suppliers/"><span class="fa fa-address-card">&nbsp;</span>Suppliers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/inventories/"><span class="fa fa-list-alt">&nbsp;</span>Inventories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/returns/"><span class="fa fa-exchange">&nbsp;</span>Returns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/customers/"><span class="fa fa-users">&nbsp;</span>Customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/sales/">&#8369; Sales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cart/{{ Auth::user()->id }}" id="anchorCart"><span class="fa fa-shopping-cart">&nbsp;</span>Cart</a>
                    </li>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li> --}}
                @else
                <li class="nav-item dropdown">

                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                        <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/register">Create user</a>
                        
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>