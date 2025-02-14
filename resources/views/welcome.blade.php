<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Plateforme collaborative pour retrouver les objets perdus. Signalez et recherchez des objets égarés en temps réel avec notre communauté.">

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="Objet Perdu & Retrouvé - Plateforme Collaborative">
  <meta property="og:description" content="Rejoignez notre communauté pour retrouver vos objets perdus et aider les autres à retrouver les leurs.">
  <!-- <meta property="og:image" content="https://example.com/og-image.jpg"> -->

  <!-- Preload Resources -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="dns-prefetch" href="//fonts.googleapis.com">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Poppins:wght@600&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/main.css') }}" media="print" onload="this.media='all'">

  <title>Objet Perdu & Retrouvé | Plateforme Collaborative</title>

  <noscript>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  </noscript>
</head>
<body>
  <a href="#main-content" class="skip-link">Aller au contenu principal</a>

  <header class="header" id="header">
    <div class="container">
      <nav class="nav" aria-label="Navigation principale">
        <a href="{{ url('/img/dall.jpg') }}" class="logo" aria-label="Accueil">
          <svg class="logo-icon" aria-hidden="true" viewBox="0 0 24 24" width="24" height="24">
            <path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"/>
          </svg>
          Objet Perdu
        </a>

        <button class="mobile-menu-toggle" id="mobile-menu" aria-expanded="false" aria-controls="nav-list">
          <span class="sr-only">Menu navigation</span>
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </button>

        <ul class="nav-list" id="nav-list" role="menubar">
          <li role="none">
            <a href="{{ route('items.index') }}" class="nav-link" role="menuitem">Explorer</a>
          </li>
          @guest
            <li role="none">
              <a href="{{ route('login') }}" class="nav-link" role="menuitem">Connexion</a>
            </li>
            <li role="none">
              <a href="{{ route('register') }}" class="nav-link btn-secondary" role="menuitem">S'inscrire</a>
            </li>
          @else
            <li role="none">
              <a href="{{ route('items.create') }}" class="nav-link btn-primary" role="menuitem">+ Ajouter</a>
            </li>
            <li role="none">
              <a href="{{ route('logout') }}" class="nav-link" role="menuitem"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Déconnexion
              </a>
            </li>
          @endguest
        </ul>
      </nav>
    </div>
  </header>

  <main id="main-content">
    <section class="hero" role="region" aria-labelledby="hero-heading">
      <div class="hero-media">
        <picture>
          <source srcset="{{ asset('img/dall.jpg') }}" type="image/webp">
          <img src="{{ asset('img/dall.jpg') }}" alt="" role="presentation" loading="eager">
        </picture>
      </div>

      <div class="container">
        <div class="hero-content fade-in">
          <h1 id="hero-heading" class="text-gradient">Retrouvez ce qui compte</h1>
          <p class="hero-subtitle">La plateforme collaborative pour retrouver vos objets perdus.</p>
          <div class="hero-actions">
            <a href="{{ route('items.index') }}" class="btn btn-lg btn-primary">Commencer l'exploration</a>
            <a href="#how-it-works" class="btn btn-lg btn-outline">Comment ça marche ?</a>
          </div>
        </div>
      </div>
    </section>

    <section class="recent-items" aria-labelledby="recent-items-heading">
      <div class="container">
        <h2 id="recent-items-heading" class="section-title">Objets récemment ajoutés</h2>

        @if(isset($recentItems) && $recentItems->count() > 0)
          <div class="items-grid">
            @foreach($recentItems as $item)
              <article class="item-card">
                <div class="item-card-content">
                  <h3 class="item-title">
                    <a href="{{ route('items.show', $item->id) }}">{{ $item->title }}</a>
                  </h3>
                  <p class="item-description">{{ \Illuminate\Support\Str::limit($item->description, 100) }}</p>
                  <dl class="item-meta">
                    <div class="meta-item">
                      <dt class="sr-only">Date d'ajout</dt>
                      <dd class="item-date">
                        <time datetime="{{ $item->created_at->format('Y-m-d') }}">
                          {{ $item->created_at->format('d/m/Y') }}
                        </time>
                      </dd>
                    </div>
                    @if($item->location)
                    <div class="meta-item">
                      <dt class="sr-only">Localisation</dt>
                      <dd class="item-location">
                        <svg aria-hidden="true" class="icon" viewBox="0 0 24 24">
                          <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5 14.5 7.62 14.5 9 13.38 11.5 12 11.5z"/>
                        </svg>
                        {{ $item->location }}
                      </dd>
                    </div>
                    @endif
                  </dl>
                </div>
              </article>
            @endforeach
          </div>
        @else
          <p class="no-items">Aucun objet récent disponible.</p>
        @endif
      </div>
    </section>
  </main>

  <footer class="footer" role="contentinfo">
    <div class="container">
      <div class="footer-content">
        <div class="footer-brand">
          <a href="/" class="logo">
            <svg class="logo-icon" aria-hidden="true" viewBox="0 0 24 24">
              <path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"/>
            </svg>
            Objet Perdu
          </a>
          <p class="footer-text">Plateforme collaborative depuis 2023</p>
        </div>
        <nav class="footer-nav" aria-label="Navigation secondaire">
          <div class="footer-nav-group">
            <h4 class="nav-group-title">Services</h4>
            <ul class="nav-group-list">
              <li><a href="{{ route('items.index') }}">Rechercher un objet</a></li>
              <li><a href="{{ route('items.create') }}">Signaler une perte</a></li>
              <li><a href="#faq">FAQ</a></li>
            </ul>
          </div>
          <div class="footer-nav-group">
            <h4 class="nav-group-title">Légal</h4>
            <ul class="nav-group-list">
              <li><a href="#privacy">Confidentialité</a></li>
              <li><a href="#terms">Conditions d'utilisation</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div>
        </nav>
      </div>
      <div class="footer-bottom">
        <p class="copyright">&copy; 2023 Objet Perdu. Tous droits réservés.</p>
      </div>
    </div>
  </footer>

  <!-- Formulaire de déconnexion caché -->
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
  </form>

  <!-- Scripts -->
  <script defer src="{{ asset('js/app.js') }}"></script>
  <script>
    // Gestion du menu mobile
    const mobileMenu = document.getElementById('mobile-menu');
    const navList = document.getElementById('nav-list');

    mobileMenu.addEventListener('click', () => {
      const isExpanded = mobileMenu.getAttribute('aria-expanded') === 'true';
      mobileMenu.setAttribute('aria-expanded', !isExpanded);
      navList.dataset.visible = !isExpanded;
    });

    // Gestion de la fermeture du menu au clic externe
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.nav')) {
        mobileMenu.setAttribute('aria-expanded', 'false');
        navList.dataset.visible = 'false';
      }
    });

    // Smooth scroll polyfill
    if (!('scrollBehavior' in document.documentElement.style)) {
      import('smoothscroll-polyfill').then((module) => {
        module.polyfill();
      });
    }
  </script>
</body>
</html>
