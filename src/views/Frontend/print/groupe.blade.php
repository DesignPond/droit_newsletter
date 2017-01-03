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
        </div>

        @include('newsletter::Frontend.print.partials.analyses', ['arret' => $arret])

        <hr/>
    @endforeach

@endif


