{{-- resources/views/partials/error-message.blade.php --}}
@error($field)
<div class="error-message">
    <svg viewBox="0 0 24 24" width="16" height="16">
        <path d="M11 15h2v2h-2zm0-8h2v6h-2zm1-5C6.47 2 2 6.5 2 12a10 10 0 0 0 10 10 10 10 0 0 0 10-10A10 10 0 0 0 12 2m0 18a8 8 0 0 1-8-8 8 8 0 0 1 8-8 8 8 0 0 1 8 8 8 8 0 0 1-8 8"/>
    </svg>
    <span>{{ $message }}</span>
</div>
@enderror
