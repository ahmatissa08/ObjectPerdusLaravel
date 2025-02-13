@extends('layouts.app')

@section('title', 'Ajouter un Objet')

@section('styles')
@push('styles')
<style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #2c3e50;
        --success-color: #2ecc71;
        --error-color: #e74c3c;
        --background-color: #f8f9fa;
        --text-color: #34495e;
    }

    .form-container {
        max-width: 700px;
        margin: 3rem auto;
        padding: 2.5rem;
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        transition: transform 0.3s ease;
    }

    .form-container:hover {
        transform: translateY(-5px);
    }

    h1.form-title {
        color: var(--secondary-color);
        text-align: center;
        margin-bottom: 2.5rem;
        font-size: 2.4em;
        font-weight: 700;
        letter-spacing: -0.5px;
        position: relative;
    }

    h1.form-title:after {
        content: '';
        display: block;
        width: 60px;
        height: 4px;
        background: var(--primary-color);
        margin: 1rem auto 0;
        border-radius: 2px;
    }

    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.8rem;
        color: var(--text-color);
        font-weight: 600;
        font-size: 0.95em;
        letter-spacing: 0.3px;
    }

    .form-control {
        width: 100%;
        padding: 1rem;
        border: 2px solid #e0e6ed;
        border-radius: 10px;
        font-size: 1em;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #ffffff;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 4px 6px -1px rgba(52, 152, 219, 0.1),
                    0 2px 4px -1px rgba(52, 152, 219, 0.06);
        outline: none;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .error-message {
        color: var(--error-color);
        margin-top: 0.6rem;
        font-size: 0.88em;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .error-message svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }

    .btn-submit {
        background: var(--primary-color);
        color: white;
        padding: 1.2rem 2.5rem;
        border: none;
        border-radius: 10px;
        font-size: 1.1em;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        width: 100%;
        justify-content: center;
    }

    .btn-submit:hover {
        background: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(41, 128, 185, 0.3);
    }

    .image-preview {
        border: 2px dashed #e0e6ed;
        border-radius: 12px;
        padding: 1.5rem;
        margin: 1.5rem 0;
        text-align: center;
    }

    #imagePreview {
        max-width: 250px;
        max-height: 250px;
        border-radius: 8px;
        display: none;
        margin: 1rem auto;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .upload-icon {
        width: 50px;
        height: 50px;
        margin: 0 auto 1rem;
        fill: #bdc3c7;
        transition: fill 0.3s ease;
    }

    .file-input:hover + .image-preview .upload-icon {
        fill: var(--primary-color);
    }

    @media (max-width: 768px) {
        .form-container {
            margin: 1.5rem;
            padding: 1.5rem;
        }

        h1.form-title {
            font-size: 2em;
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

        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
            @error('title')
                <div class="error-message">
                    <svg viewBox="0 0 24 24"><path d="M11 15h2v2h-2zm0-8h2v6h-2zm1-5C6.47 2 2 6.5 2 12a10 10 0 0 0 10 10 10 10 0 0 0 10-10A10 10 0 0 0 12 2m0 18a8 8 0 0 1-8-8 8 8 0 0 1 8-8 8 8 0 0 1 8 8 8 8 0 0 1-8 8"/></svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            @error('description')
                <div class="error-message">
                    <svg viewBox="0 0 24 24"><path d="M11 15h2v2h-2zm0-8h2v6h-2zm1-5C6.47 2 2 6.5 2 12a10 10 0 0 0 10 10 10 10 0 0 0 10-10A10 10 0 0 0 12 2m0 18a8 8 0 0 1-8-8 8 8 0 0 1 8-8 8 8 0 0 1 8 8 8 8 0 0 1-8 8"/></svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" id="type" class="form-control">
                <option value="lost" {{ old('type') == 'lost' ? 'selected' : '' }}>Objet Perdu</option>
                <option value="found" {{ old('type') == 'found' ? 'selected' : '' }}>Objet Retrouvé</option>
            </select>
            @error('type')
                <div class="error-message">
                    <svg viewBox="0 0 24 24"><path d="M11 15h2v2h-2zm0-8h2v6h-2zm1-5C6.47 2 2 6.5 2 12a10 10 0 0 0 10 10 10 10 0 0 0 10-10A10 10 0 0 0 12 2m0 18a8 8 0 0 1-8-8 8 8 0 0 1 8-8 8 8 0 0 1 8 8 8 8 0 0 1-8 8"/></svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="location">Localisation</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}">
            @error('location')
                <div class="error-message">
                    <svg viewBox="0 0 24 24"><path d="M11 15h2v2h-2zm0-8h2v6h-2zm1-5C6.47 2 2 6.5 2 12a10 10 0 0 0 10 10 10 10 0 0 0 10-10A10 10 0 0 0 12 2m0 18a8 8 0 0 1-8-8 8 8 0 0 1 8-8 8 8 0 0 1 8 8 8 8 0 0 1-8 8"/></svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">Image de l'objet</label>
            <input type="file" name="image" id="image" class="form-control file-input" accept="image/*">
            <div class="image-preview">
                <svg class="upload-icon" viewBox="0 0 24 24">
                    <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"/>
                </svg>
                <img id="imagePreview" src="#" alt="Aperçu de l'image">
            </div>
            @error('image')
                <div class="error-message">
                    <svg viewBox="0 0 24 24"><path d="M11 15h2v2h-2zm0-8h2v6h-2zm1-5C6.47 2 2 6.5 2 12a10 10 0 0 0 10 10 10 10 0 0 0 10-10A10 10 0 0 0 12 2m0 18a8 8 0 0 1-8-8 8 8 0 0 1 8-8 8 8 0 0 1 8 8 8 8 0 0 1-8 8"/></svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="category">Catégorie</label>
            <select name="category" id="category" class="form-control">
                <option value="electronique" {{ old('category') == 'electronique' ? 'selected' : '' }}>Électronique</option>
                <option value="vetements" {{ old('category') == 'vetements' ? 'selected' : '' }}>Vêtements</option>
                <option value="accessoires" {{ old('category') == 'accessoires' ? 'selected' : '' }}>Accessoires</option>
                <option value="documents" {{ old('category') == 'documents' ? 'selected' : '' }}>Documents</option>
                <option value="autres" {{ old('category') == 'autres' ? 'selected' : '' }}>Autres</option>
            </select>
            @error('category')
                <div class="error-message">
                    <svg viewBox="0 0 24 24"><path d="M11 15h2v2h-2zm0-8h2v6h-2zm1-5C6.47 2 2 6.5 2 12a10 10 0 0 0 10 10 10 10 0 0 0 10-10A10 10 0 0 0 12 2m0 18a8 8 0 0 1-8-8 8 8 0 0 1 8-8 8 8 0 0 1 8 8 8 8 0 0 1-8 8"/></svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="found_date">Date de l'événement</label>
            <input type="date" name="found_date" id="found_date" class="form-control" value="{{ old('found_date') }}">
            @error('found_date')
                <div class="error-message">
                    <svg viewBox="0 0 24 24"><path d="M11 15h2v2h-2zm0-8h2v6h-2zm1-5C6.47 2 2 6.5 2 12a10 10 0 0 0 10 10 10 10 0 0 0 10-10A10 10 0 0 0 12 2m0 18a8 8 0 0 1-8-8 8 8 0 0 1 8-8 8 8 0 0 1 8 8 8 8 0 0 1-8 8"/></svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <button type="submit" class="btn-submit">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
            </svg>
            Enregistrer
        </button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image Preview
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const uploadIcon = document.querySelector('.upload-icon');

        if(imageInput) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if(file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.style.display = 'block';
                        imagePreview.src = e.target.result;
                        uploadIcon.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Dynamic Date Input
        const dateInput = document.getElementById('found_date');
        if(!dateInput.value) {
            dateInput.value = new Date().toISOString().split('T')[0];
        }

        // Form Validation Feedback
        const formControls = document.querySelectorAll('.form-control');
        formControls.forEach(control => {
            control.addEventListener('input', () => {
                if(control.checkValidity()) {
                    control.classList.remove('invalid');
                    const errorDiv = control.parentElement.querySelector('.error-message');
                    if(errorDiv) errorDiv.style.display = 'none';
                }
            });
        });

        // Form Submission Animation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.style.transform = 'scale(0.95)';
            btn.style.opacity = '0.8';
            btn.innerHTML = 'Enregistrement en cours...';
        });

        // Hover Effects for Form Container
        const formContainer = document.querySelector('.form-container');
        formContainer.addEventListener('mouseenter', () => {
            formContainer.style.transform = 'translateY(-5px)';
        });
        formContainer.addEventListener('mouseleave', () => {
            formContainer.style.transform = 'translateY(0)';
        });
    });
</script>

@endsection
