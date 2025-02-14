@extends('layouts.app')

@section('title', 'Ajouter un Objet')

@section('styles')
@push('styles')
<style>
    :root {
        --primary: hsl(215, 80%, 55%);
        --primary-hover: hsl(215, 80%, 45%);
        --surface: hsl(0, 0%, 100%);
        --surface-dark: hsl(240, 6%, 98%);
        --text-primary: hsl(240, 8%, 20%);
        --text-secondary: hsl(240, 6%, 40%);
        --error: hsl(0, 72%, 55%);
        --radius-2xl: 1.5rem;
        --radius-xl: 1rem;
        --shadow-lg: 0 12px 32px -8px rgba(0, 0, 0, 0.15);
        --glass: linear-gradient(145deg, rgba(255,255,255,0.15), rgba(255,255,255,0.05));
    }

    .form-container {
        max-width: 760px;
        margin: 4rem auto;
        padding: 3rem;
        background: var(--surface);
        border-radius: var(--radius-2xl);
        box-shadow: var(--shadow-lg);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.2);
        position: relative;
        overflow: hidden;
    }

    .form-container::before {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--glass);
        pointer-events: none;
    }

    .form-title {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(45deg, var(--primary), hsl(215, 80%, 45%));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
        padding-bottom: 1.5rem;
    }

    .form-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), transparent);
        border-radius: 2px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
    }

    .form-group {
        margin-bottom: 1.75rem;
        position: relative;
    }

    .form-label {
        display: block;
        margin-bottom: 0.75rem;
        font-size: 0.9375rem;
        font-weight: 500;
        color: var(--text-primary);
        transition: transform 0.3s ease;
    }

    .form-control {
        width: 100%;
        padding: 1.125rem;
        border: 2px solid hsl(240, 6%, 90%);
        border-radius: var(--radius-xl);
        font-size: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: var(--surface);
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(66, 153, 225, 0.15);
        padding-left: 1.5rem;
    }

    .file-upload {
        border: 2px dashed hsl(240, 6%, 90%);
        border-radius: var(--radius-xl);
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .file-upload:hover {
        border-color: var(--primary);
        background: rgba(66, 153, 225, 0.03);
    }

    .upload-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 1.5rem;
        color: hsl(240, 6%, 80%);
        transition: color 0.3s ease;
    }

    #imagePreview {
        width: 100%;
        height: 240px;
        object-fit: cover;
        border-radius: var(--radius-xl);
        display: none;
        box-shadow: var(--shadow-lg);
        transition: transform 0.3s ease;
    }

    #imagePreview.loaded {
        display: block;
        animation: fadeIn 0.4s ease;
    }

    .btn-submit {
        background: var(--primary);
        color: white;
        padding: 1.25rem 2.5rem;
        border-radius: var(--radius-xl);
        font-weight: 600;
        width: 100%;
        position: relative;
        overflow: hidden;
        transition: all 0.4s ease;
    }

    .btn-submit::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg,
            transparent,
            rgba(255,255,255,0.15),
            transparent);
        transform: rotate(45deg);
        transition: all 0.6s ease;
    }

    .btn-submit:hover::after {
        left: 50%;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .form-container {
            margin: 2rem 1rem;
            padding: 2rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-title {
            font-size: 2rem;
        }
    }
</style>
@endpush
@endsection

@section('content')
<div class="form-container">
    <h1 class="form-title">Ajouter un Objet</h1>

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">
            <!-- Colonne gauche -->
            <div>
                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" name="title" id="title" class="form-control"
                           value="{{ old('title') }}" required autofocus>
                    @include('partials.error-message', ['field' => 'title'])
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control"
                              rows="5" required>{{ old('description') }}</textarea>
                    @include('partials.error-message', ['field' => 'description'])
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <div class="file-upload" onclick="document.getElementById('image').click()">
                        <svg class="upload-icon" viewBox="0 0 24 24">
                            <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"/>
                        </svg>
                        <img id="imagePreview" src="#" alt="Aperçu">
                        <span class="upload-text">Cliquez pour téléverser</span>
                    </div>
                    <input type="file" name="image" id="image" hidden accept="image/*">
                    @include('partials.error-message', ['field' => 'image'])
                </div>
            </div>

            <!-- Colonne droite -->
            <div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="lost" {{ old('type') == 'lost' ? 'selected' : '' }}>Perdu</option>
                        <option value="found" {{ old('type') == 'found' ? 'selected' : '' }}>Trouvé</option>
                    </select>
                    @include('partials.error-message', ['field' => 'type'])
                </div>

                <div class="form-group">
                    <label for="category">Catégorie</label>
                    <select name="category" id="category" class="form-control" required>
                        @foreach(['electronique', 'vetements', 'accessoires', 'documents', 'autres'] as $category)
                            <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                    @include('partials.error-message', ['field' => 'category'])
                </div>

                <div class="form-group">
                    <label for="location">Localisation</label>
                    <input type="text" name="location" id="location" class="form-control"
                           value="{{ old('location') }}" required>
                    @include('partials.error-message', ['field' => 'location'])
                </div>

                <div class="form-group">
                    <label for="found_date">Date</label>
                    <input type="date" name="found_date" id="found_date"
                           class="form-control" value="{{ old('found_date') }}" required>
                    @include('partials.error-message', ['field' => 'found_date'])
                </div>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
            </svg>
            Enregistrer
        </button>
    </form>
</div>
@endsection

@section('scripts')
@push('styles')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Image Preview
        const imageInput = document.getElementById('image');
        const preview = document.getElementById('imagePreview');
        const uploadBox = document.querySelector('.file-upload');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.src = e.target.result;
                    preview.classList.add('loaded');
                    uploadBox.style.borderColor = 'var(--primary)';
                    uploadBox.style.background = 'rgba(66, 153, 225, 0.05)';
                }
                reader.readAsDataURL(file);
            }
        });

        // Date Validation
        const dateInput = document.getElementById('found_date');
        dateInput.addEventListener('change', () => {
            const selectedDate = new Date(dateInput.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (selectedDate > today) {
                dateInput.setCustomValidity('Date invalide');
                dateInput.classList.add('invalid');
            } else {
                dateInput.setCustomValidity('');
                dateInput.classList.remove('invalid');
            }
        });

        // Form Submission
        const form = document.querySelector('form');
        form.addEventListener('submit', (e) => {
            const btn = e.target.querySelector('button[type="submit"]');
            btn.style.pointerEvents = 'none';
            btn.innerHTML = `
                <div class="spinner"></div>
                Enregistrement...
            `;
        });
    });
</script>
@endpush
@endsection
