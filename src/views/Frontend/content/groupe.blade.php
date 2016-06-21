@if(!$bloc->groupe->arrets->isEmpty())

    <div class="row">
        <div class="col-md-9">
            <h3>{{ $bloc->groupe->categorie->title }}</h3>
        </div>
        <div class="col-md-3">
            <img width="130" border="0" src="{{ asset('newsletter/pictos/'.$bloc->groupe->categorie->image) }}" alt="{{ $bloc->groupe->categorie->title }}" />
        </div>
    </div>

    @foreach($bloc->groupe->arrets as $arret)
        <?php $arret->load('categories');  ?>
        <div class="row">
            <div class="col-md-9">
                <h2>{{ $arret->reference }} du {{ $arret->pub_date->formatLocalized('%d %B %Y') }}</h2>
                <p>{!! $arret->abstract !!}</p>
                {!! $arret->pub_text !!}
            </div>
            <div class="col-md-3">
                @if(!$arret->categories->isEmpty())
                    @foreach($arret->categories as $categorie)
                        <a target="_blank" href="{{ url('jurisprudence') }}#{{ $bloc->reference }}">
                            <img style="max-width: 130px;" border="0" alt="{{ $categorie->title }}" src="{{ asset('newsletter/pictos/'.$categorie->image) }}">
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
@endif


