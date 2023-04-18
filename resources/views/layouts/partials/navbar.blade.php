<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center my-3" href="{{ url('/') }}">
      <div class="text-primary">
        {{ config('app.name', 'Laravel') }}
      </div>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">


      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav">
        <!-- Authentication Links -->
        @guest
          <li class="nav-item">
            <a class="nav-link @if (request()->routeIs('login')) active @endif"
              href="{{ route('login') }}">{{ __('Login') }}</a>
          </li>
          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link @if (request()->routeIs('register')) active @endif"
                href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
          @endif
        @else
          <li class="nav-item">
            <a class="nav-link @if (request()->routeIs('admin.posts*')) active @endif"
              href="{{ route('admin.posts.index') }}">{{ __('Posts') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if (request()->routeIs('admin.categories*')) active @endif"
              href="{{ route('admin.categories.index') }}">{{ __('Categorie') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if (request()->routeIs('profile*')) active @endif"
              href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
              onclick="
                event.preventDefault();
                document.getElementById('logout-form').submit();
              ">
              {{ __('Logout') }}
            </a>



            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
