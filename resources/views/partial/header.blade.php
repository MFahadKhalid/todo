<header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            @auth
          <li><a href="{{ route('index') }}" class="nav-link px-2 text-white">Welcome , <i class="fa fa-user"></i>  {{ auth()->user()->name }}</a></li>
                
            @endauth
        </ul>

        {{-- <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
        </form> --}}

        <div class="text-end">
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-warning">Sign-up</a>
            @endguest
            @auth
            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"  class="btn btn-warning"><i class="fa fa-sign-out"></i> Signout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
            @endauth
        </div>
      </div>
    </div>
  </header>
