<div class="arret">
    <div class="arret-content">
        <h2>{{ $bloc->arret->reference }} du {{ $bloc->arret->pub_date->formatLocalized('%d %B %Y') }}</h2>
        <p>{!! $bloc->arret->abstract !!}</p>
        {!! $bloc->arret->pub_text !!}
    </div>
</div>

@include('newsletter::Frontend.print.partials.analyses', ['arret' => $bloc->arret])

<hr/>