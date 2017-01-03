<div class="arret">
    <div class="arret-categories">
        <a class="thumb" target="_blank" href="{{ isset($bloc->lien) && !empty($bloc->lien) ? $bloc->lien : url('/') }}">
            <img style="width: 100px;" alt="{{ $bloc->titre }}" src="{{ asset(config('newsletter.path.upload').$bloc->image.'') }}" />
        </a>
    </div>
    <div class="arret-content">
        <h2>{{ $bloc->titre }}</h2>
        {!! $bloc->contenu !!}
    </div>
</div><hr>