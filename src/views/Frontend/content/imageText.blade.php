<div class="bloc-content">
    <a target="_blank" href="{{ isset($bloc->lien) && !empty($bloc->lien) ? $bloc->lien : url('/') }}">
        <img style="max-width: 560px;" alt="{{ $bloc->titre or '' }}" src="{{ asset('files/'.$bloc->image) }}" />
    </a>
    @if(!empty($bloc->titre))
        <h2>{{ $bloc->titre }}</h2>
    @endif
    {!! $bloc->contenu !!}
 </div>
