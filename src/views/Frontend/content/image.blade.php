<div class="bloc-content">
    <a target="_blank" href="{{ isset($bloc->lien) && !empty($bloc->lien) ? $bloc->lien : url('/') }}">
        <img style="max-width: 560px;" alt="{{ $bloc->titre }}" src="{{ asset(config('newsletter.path.upload').$bloc->image) }}" />
    </a>
    <h2>{{ $bloc->titre }}</h2>
</div>
