<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Object Perdus') }}</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @stack('styles')
</head>
<body>
  <div id="app">
    <header class="site-header">
      <div class="container">
        <div class="header-inner">
          <a href="{{ url('/') }}" class="site-logo">
            {{ config('app.name', 'Object Perdu') }}
          </a>
          <nav class="main-nav" id="main-nav">
            <ul class="nav-list">
              <li><a href="{{ url('/') }}">Accueil</a></li>
              <li><a href="{{ route('items.index') }}">Objets</a></li>
              @guest
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
              @else
                <li class="nav-item">
                  <a href="#" class="dropdown-toggle">{{ Auth::user()->name }}</a>
                  <ul class="dropdown-menu">
                    <li>
                      <a href="{{ route('logout') }}"
                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                      </a>
                    </li>
                  </ul>
                </li>
              @endguest
            </ul>
          </nav>
          <button class="nav-toggle" id="nav-toggle" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
          </button>
        </div>
      </div>
    </header>

    <main class="site-main">
      @yield('content')
    </main>

    <footer class="site-footer">
      <div class="container">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Object Perdus') }}. Tous droits réservés.</p>
      </div>
    </footer>
  </div>

  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>

  <!-- Scripts -->
  <script src="{{ asset('js/app3.js') }}" defer></script>
    @stack('scripts')
</body>
</html>

