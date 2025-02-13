@extends('layouts.app')

@section('title', 'Liste des Objets')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-overlay">
        <div class="container">
            <h1 class="hero-title">Retrouvez ce qui compte</h1>
            <p class="hero-subtitle">Des objets perdus ou trouvés près de chez vous</p>
            <form method="GET" action="{{ route('items.index') }}" class="search-form">
                <input type="text"
                       name="search"
                       placeholder="Rechercher un objet..."
                       value="{{ request('search') }}">
                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('date'))
                    <input type="hidden" name="date" value="{{ request('date') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</section>

<div class="main-content">
    <div class="container">
        <!-- Toast Notification -->
        @if(session('success'))
            <div class="alert-toast">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Filter Bar -->
        <div class="filter-bar">
            <!-- Type Filters -->
            <div class="type-filter">
                <a href="{{ route('items.index', array_merge(request()->query(), ['type' => null])) }}"
                   class="filter-btn {{ !request('type') ? 'active' : '' }}">
                    Tout voir
                </a>
                <a href="{{ route('items.index', array_merge(request()->query(), ['type' => 'lost'])) }}"
                   class="filter-btn lost {{ request('type') === 'lost' ? 'active' : '' }}">
                    Perdus
                </a>
                <a href="{{ route('items.index', array_merge(request()->query(), ['type' => 'found'])) }}"
                   class="filter-btn found {{ request('type') === 'found' ? 'active' : '' }}">
                    Trouvés
                </a>
            </div>

            <!-- Advanced Filters -->
            <form method="GET" action="{{ route('items.index') }}" class="filter-form">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif

                <div class="filter-group">
                    <select name="category" class="custom-select" onchange="this.form.submit()">
                        <option value="">Toutes catégories</option>
                        @foreach(['electronique', 'vetements', 'accessoires', 'documents', 'autres'] as $category)
                            <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <input type="date"
                           name="date"
                           class="custom-select"
                           value="{{ request('date') }}"
                           onchange="this.form.submit()">
                </div>

                <div class="filter-group">
                    <select name="sort" class="custom-select" onchange="this.form.submit()">
                        <option value="recent" {{ request('sort') === 'recent' ? 'selected' : '' }}>
                            Plus récents
                        </option>
                        <option value="old" {{ request('sort') === 'old' ? 'selected' : '' }}>
                            Plus anciens
                        </option>
                        <option value="date_asc" {{ request('sort') === 'date_asc' ? 'selected' : '' }}>
                            Date ↑
                        </option>
                        <option value="date_desc" {{ request('sort') === 'date_desc' ? 'selected' : '' }}>
                            Date ↓
                        </option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Items Grid -->
        <div class="items-container">
            @forelse($items as $item)
                <div class="item-card">
                    <div class="card-header">
                        <span class="item-type {{ $item->type }}">
                            {{ $item->type === 'lost' ? 'Perdu' : 'Trouvé' }}
                        </span>
                        <time class="item-date">
                            {{ $item->created_at->diffForHumans() }}
                        </time>
                    </div>
                    <div class="card-body">
                        <h2>
                            <a href="{{ route('items.show', $item->id) }}" class="item-title">
                                {{ $item->title }}
                            </a>
                        </h2>
                        @if($item->image)
                            <img src="{{ Storage::url($item->image) }}"
                                 alt="{{ $item->title }}"
                                 class="item-image">
                        @endif
                        <p class="item-description">
                            {{ Str::limit($item->description, 120) }}
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="item-meta">
                            @if($item->location)
                                <div class="item-location">
                                    <i class="fas fa-map-marker-alt"></i> {{ $item->location }}
                                </div>
                            @endif
                            @if($item->found_date)
    <div class="item-found-date">
        <i class="fas fa-calendar-alt"></i>
        {{ \Carbon\Carbon::parse($item->found_date)->format('d/m/Y') }}
    </div>
@endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="no-results">
                    <i class="fas fa-search-minus"></i>
                    <p>Aucun résultat trouvé pour votre recherche</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $items->onEachSide(1)->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/main2.css') }}">
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
      /** Toast Auto-dismiss **/
      const toast = document.querySelector('.alert-toast');
      if (toast) setTimeout(() => toast.remove(), 5000);

      /** Intersection Observer pour animer les cartes **/
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add('visible');
              observer.unobserve(entry.target); // Arrête l'observation une fois visible
            }
          });
        },
        { threshold: 0.1 }
      );
      document.querySelectorAll('.item-card').forEach((card) => observer.observe(card));

      /** Active state pour les filtres de type **/
      document.querySelectorAll('.type-filter .filter-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
          document.querySelectorAll('.filter-btn').forEach((b) => b.classList.remove('active'));
          btn.classList.add('active');
        });
      });

      /** Validation et gestion des erreurs de formulaire **/
      document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', function (e) {
          let isValid = true;
          // Validation des champs requis
          this.querySelectorAll('[required]').forEach((input) => {
            if (!input.value.trim()) {
              isValid = false;
              const errorElement = input.nextElementSibling;
              if (errorElement && errorElement.classList.contains('error-message')) {
                errorElement.textContent = 'Ce champ est obligatoire';
                errorElement.style.display = 'block';
                input.parentElement.classList.add('has-error');
                input.style.animation = 'shake 0.3s';
              }
            }
          });
          // Validation des fichiers
          this.querySelectorAll('input[type="file"]').forEach((input) => {
            if (input.files.length > 0) {
              const file = input.files[0];
              const maxSize = input.getAttribute('data-max-size') || 2048; // en KB
              if (file.size > maxSize * 1024) {
                isValid = false;
                showError(`Le fichier ne doit pas dépasser ${maxSize}KB`);
              }
              const allowedTypes = input.accept.split(',');
              if (!allowedTypes.includes(file.type)) {
                isValid = false;
                showError('Type de fichier non autorisé');
              }
            }
          });
          if (!isValid) {
            e.preventDefault();
            showError('Veuillez corriger les erreurs dans le formulaire');
          }
        });
      });

      /** Gestion des erreurs API **/
      document.querySelectorAll('[data-ajax]').forEach((element) => {
        element.addEventListener('click', async function (e) {
          e.preventDefault();
          try {
            const response = await fetch(this.href);
            if (!response.ok) throw new Error(response.statusText);
            const data = await response.json();
            // Traitement des données...
          } catch (error) {
            showError(`Erreur de connexion: ${error.message}`);
          }
        });
      });

      /** Réinitialisation des erreurs lors de la saisie **/
      document.querySelectorAll('input, select, textarea').forEach((input) => {
        input.addEventListener('input', function () {
          this.parentElement.classList.remove('has-error');
          const errorElement = this.nextElementSibling;
          if (errorElement && errorElement.classList.contains('error-message')) {
            errorElement.style.display = 'none';
          }
        });
      });

      /** Fonction d'affichage d'erreur **/
      function showError(message, type = 'error') {
        const toastEl = document.createElement('div');
        toastEl.className = `alert-toast ${type}`;
        toastEl.innerHTML = `<i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'}"></i> ${message}`;
        document.body.appendChild(toastEl);
        setTimeout(() => toastEl.remove(), 5000);
      }
    });
  </script>
@endpush
