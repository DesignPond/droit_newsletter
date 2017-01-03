@if(isset($bloc->groupe) && !$bloc->groupe->arrets->isEmpty())

    <h1>{{ $bloc->groupe->categorie->title }}</h1>
    <hr>

    @foreach($bloc->groupe->arrets as $arret)
        <div class="arret">
            <?php $arret->load('categories');  ?>
            <div class="arret-content">
                <h2>{{ $arret->reference }} du {{ $arret->pub_date->formatLocalized('%d %B %Y') }}</h2>
                <p>{!! $arret->abstract !!}</p>
                {!! $arret->pub_text !!}
            </div>
            <div class="arret-categories">
                @if(!$arret->categories->isEmpty())
                    @foreach($arret->categories as $categorie)
                        <a class="thumb" target="_blank" href="{{ config('newsletter.link.arret') }}#{{ $bloc->reference }}">
                            <img style="max-width: 100px;" border="0" alt="{{ $categorie->title }}" src="{{ asset(config('newsletter.path.categorie').$categorie->image) }}">
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

        @include('newsletter::Frontend.print.partials.analyses', ['arret' => $arret])

        <hr/>
    @endforeach

@endif


