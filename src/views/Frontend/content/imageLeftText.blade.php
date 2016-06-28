<div class="row">
    <div class="col-md-3">
        <a target="_blank" href="{{ isset($bloc->lien) && !empty($bloc->lien) ? $bloc->lien : url('/') }}">
            <img style="max-width: 130px; max-height: 200px;" alt="{{ $bloc->titre }}" src="{{ asset(config('newsletter.path.upload').$bloc->image.'') }}" />
        </a>
    </div>
    <div class="col-md-9">
        <div class="bloc-content">
            <h2>{{ $bloc->titre }}</h2>
            {!! $bloc->contenu !!}
        </div><!--END POST-->
    </div>
</div>
