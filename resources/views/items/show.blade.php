@extends('layouts.app')

@section('title', 'Détails de l\'Objet')

@section('content')
<div class="item-details">
  <div class="card">
    @if($item->image)
      <div class="card-image">
        <img src="{{ asset('storage/' . $item->image) }}" alt="Image de l'objet">
      </div>
    @endif
    <div class="card-content">
      <h1>{{ $item->title }}</h1>
      <p class="description">{{ $item->description }}</p>
      <ul class="details-list">
        <li><strong>Type :</strong> {{ $item->type == 'lost' ? 'Objet Perdu' : 'Objet Retrouvé' }}</li>
        @if($item->location)
          <li><strong>Localisation :</strong> {{ $item->location }}</li>
        @endif
        <li><strong>Ajouté par :</strong> {{ $item->user ? $item->user->name : 'Anonyme' }}</li>
        <li><strong>Date de l'événement :</strong> {{ $item->found_date ? $item->found_date : 'Non spécifiée' }}</li>
        <li><strong>Catégorie :</strong> {{ ucfirst($item->category) }}</li>
      </ul>
      <a href="{{ route('items.index') }}" class="btn btn-primary">Retour à la liste</a>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/show.js') }}"></script>
@endpush
