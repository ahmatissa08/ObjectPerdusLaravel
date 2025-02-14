@extends('layouts.app')

@section('title', 'Liste des Objets')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-overlay">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Retrouvez l'essentiel</h1>
                <p class="hero-subtitle">Communauté d'entraide pour objets perdus & trouvés</p>
                <form method="GET" action="{{ route('items.index') }}" class="search-form">
                    <div class="search-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text"
                               name="search"
                               placeholder="Rechercher un objet, un lieu..."
                               value="{{ request('search') }}"
                               class="modern-input">
                        <button type="submit" class="search-button">
                            <span>Rechercher</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                    @if(request('type'))<input type="hidden" name="type" value="{{ request('type') }}">@endif
                    @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                    @if(request('date'))<input type="hidden" name="date" value="{{ request('date') }}">@endif
                    @if(request('sort'))<input type="hidden" name="sort" value="{{ request('sort') }}">@endif
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        @if(session('success'))
            <div class="alert-toast">
                <div class="toast-content">
                    <i class="fas fa-check-circle"></i>
                    <div class="toast-message">{{ session('success') }}</div>
                </div>
                <div class="progress-bar"></div>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-header">
                <h2>Filtrer les résultats</h2>
                <div class="result-count">{{ $items->total() }} résultats</div>
            </div>

            <div class="filter-grid">
                <!-- Type Filter -->
                <div class="filter-group">
                    <label>Type d'objet</label>
                    <div class="button-group">
                        <a href="{{ route('items.index', array_merge(request()->query(), ['type' => null])) }}"
                           class="filter-chip {{ !request('type') ? 'active' : '' }}">
                            Tous types
                        </a>
                        <a href="{{ route('items.index', array_merge(request()->query(), ['type' => 'lost'])) }}"
                           class="filter-chip lost {{ request('type') === 'lost' ? 'active' : '' }}">
                            <i class="fas fa-exclamation-triangle"></i> Perdus
                        </a>
                        <a href="{{ route('items.index', array_merge(request()->query(), ['type' => 'found'])) }}"
                           class="filter-chip found {{ request('type') === 'found' ? 'active' : '' }}">
                            <i class="fas fa-hand-holding-heart"></i> Trouvés
                        </a>
                    </div>
                </div>

                <!-- Dynamic Filters -->
                <form method="GET" action="{{ route('items.index') }}" class="filter-form">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label>Catégorie</label>
                            <div class="select-wrapper">
                                <select name="category" onchange="this.form.submit()">
                                    <option value="">Toutes catégories</option>
                                    @foreach(['electronique', 'vetements', 'accessoires', 'documents', 'autres'] as $category)
                                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                                            {{ ucfirst($category) }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="filter-group">
                            <label>Date</label>
                            <div class="date-input-wrapper">
                                <input type="date"
                                       name="date"
                                       value="{{ request('date') }}"
                                       class="modern-date">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <!-- Zone pour afficher un éventuel message d'erreur -->
                            <span id="date-error" class="error-message" style="color: red; display: none;"></span>
                        </div>

                        <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const dateInput = document.querySelector('.modern-date');
                            const dateError = document.getElementById('date-error');

                            if (dateInput) {
                                dateInput.addEventListener('change', function(e) {
                                    const selectedDate = new Date(e.target.value);
                                    const today = new Date();
                                    // On retire l'heure pour ne comparer que la date
                                    today.setHours(0, 0, 0, 0);

                                    if (selectedDate > today) {
                                        dateError.style.display = 'block';
                                        dateError.textContent = "Vous ne pouvez pas sélectionner une date future.";
                                    } else {
                                        dateError.style.display = 'none';
                                        // Si tout est correct, on soumet le formulaire
                                        e.target.form.submit();
                                    }
                                });
                            }
                        });
                        </script>

                        <div class="filter-group">
                            <label>Trier par</label>
                            <div class="select-wrapper">
                                <select name="sort" onchange="this.form.submit()">
                                    <option value="recent" {{ request('sort') === 'recent' ? 'selected' : '' }}>
                                        Nouveautés
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
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Items Grid -->
        @if($items->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-search-minus"></i>
                </div>
                <h3>Aucun résultat trouvé</h3>
                <p>Essayez de modifier vos filtres ou votre recherche</p>
            </div>
        @else
            <div class="items-grid">
                @foreach($items as $item)
                    <article class="item-card">
                        <div class="card-badge {{ $item->type }}">
                            {{ $item->type === 'lost' ? 'Perdu' : 'Trouvé' }}
                        </div>
                        @if($item->image)
                            <div class="card-media">
                                <img src="{{ Storage::url($item->image) }}"
                                     alt="{{ $item->title }}"
                                     loading="lazy"
                                     class="card-image">
                            </div>
                        @endif
                        <div class="card-content">
                            <h3 class="card-title">
                                <a href="{{ route('items.show', $item->id) }}">{{ $item->title }}</a>
                            </h3>
                            <p class="card-excerpt">{{ Str::limit($item->description, 100) }}</p>
                            <div class="card-meta">
                                @if($item->location)
                                    <div class="meta-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $item->location }}</span>
                                    </div>
                                @endif
                                <div class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    <time>{{ $item->created_at->diffForHumans() }}</time>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="modern-pagination">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</main>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/main2.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@endpush
