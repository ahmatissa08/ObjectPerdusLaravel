@extends('layouts.app')

@section('title', 'Détails de l\'Objet')

@section('content')
<article class="item-details">
  <div class="detail-card">
    @if($item->image)
    <div class="media-container">
      <div class="status-badge {{ $item->type }}">
        {{ $item->type === 'lost' ? 'Perdu' : 'Trouvé' }}
      </div>
      <img src="{{ asset('storage/' . $item->image) }}"
           alt="{{ $item->title }}"
           class="item-media"
           loading="lazy">
    </div>
    @endif

    <div class="detail-content">
      <header class="content-header">
        <h1 class="item-title">{{ $item->title }}</h1>
        <div class="meta-info">
          <span class="category-tag">{{ ucfirst($item->category) }}</span>
          <time class="event-date">
            <i class="fas fa-calendar-alt"></i>
            {{ $item->found_date ? \Carbon\Carbon::parse($item->found_date)->format('d/m/Y') : 'Date non spécifiée' }}
          </time>
        </div>
      </header>

      <section class="item-description">
        <p>{{ $item->description }}</p>
      </section>

      <div class="detail-grid">
        @if($item->location)
        <div class="detail-item location">
          <i class="fas fa-map-marker-alt"></i>
          <div>
            <h3>Localisation</h3>
            <p>{{ $item->location }}</p>
          </div>
        </div>
        @endif

        <div class="detail-item owner">
          <i class="fas fa-user-circle"></i>
          <div>
            <h3>Propriétaire</h3>
            <p>{{ $item->user?->name ?? 'Anonyme' }}</p>
          </div>
        </div>
      </div>

      <footer class="card-footer">
        <a href="{{ route('items.index') }}" class="btn btn-back">
          <i class="fas fa-arrow-left"></i>
          Retour aux objets
        </a>
        @auth
        <a href="#contact-form" class="btn btn-contact">
          <i class="fas fa-envelope"></i>
          Contacter
        </a>
        @endauth
      </footer>
    </div>
  </div>
</article>
@push('styles')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/show.js') }}"></script>
@endpush
@endsection

