<div class="arret">
    <a target="_blank" href="{{ isset($bloc->lien) && !empty($bloc->lien) ? $bloc->lien : url('/') }}">
        <img style="max-width: 400px; max-height: 250px;" alt="{{ $bloc->titre }}" src="{{ asset(config('newsletter.path.upload').$bloc->image) }}" />
    </a>
    <h2>{{ $bloc->titre }}</h2>
</div><hr>