
<div class="arret">
    <div class="arret-content">
        <h2>{{ $bloc->arret->reference }} du {{ $bloc->arret->pub_date->formatLocalized('%d %B %Y') }}</h2>
        <p>{!! $bloc->arret->abstract !!}</p>
        {!! $bloc->arret->pub_text !!}
    </div>
    <div class="arret-categories">
        @if(!$bloc->arret->categories->isEmpty() )
            @foreach($bloc->arret->categories as $categorie)
                <a class="thumb" target="_blank" href="{{ url(config('newsletter.link.arret')) }}#{{ $bloc->reference }}">
                    <img style="width: 120px;" border="0"  alt="{{ $categorie->title }}" src="{{ asset(config('newsletter.path.categorie').$categorie->image) }}">
                </a>
            @endforeach
        @endif
    </div>
</div>  <hr/>