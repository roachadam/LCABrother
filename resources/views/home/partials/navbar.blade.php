<div class="navbar navbar">
    <nav class="nav__mobile"></nav>
    <div class="container">
        <div class="navbar__inner">
            <a href="/" class="navbar__logo">LCABrother</a>
            <nav class="navbar__menu">
                <ul>
                    {{-- <li><a href="{{ url('/') }}" class="{{Request::is('/') ? 'vMenu--active' : ''}}">Home</a></li>
                    <li><a href="{{ url('/about') }}" class="{{Request::is('about*') ? 'vMenu--active' : ''}}">About</a></li>
                    <li><a href="{{ url('/contact') }}" class="{{Request::is('contact*') ? 'vMenu--active' : ''}}">Contact Us</a></li> --}}

                    @auth
                        <li><a href="{{ url('/dash') }}" class="{{Request::is('dash') ? 'vMenu--active' : ''}}">Dash</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="{{Request::is('login*') ? 'vMenu--active' : ''}}">Login</a></li>
                        <li><a href="{{ route('register') }}" class="{{Request::is('register*') ? 'vMenu--active' : ''}}">Register</a></li>
                        @endauth
                </ul>
            </nav>
            <div class="navbar__menu-mob"><a href="" id='toggle'><svg role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z" class=""></path></svg></a></div>
        </div>
    </div>
</div>
