@if(!empty($analyses))
    <div class="analyse">
        <div class="arret-content">
        <h4>Analyses</h4>
            @foreach($analyses as $analyse)

                <h3>Commentaire de {{ $analyse->authors }}</h3>
                @if(!$analyse->analyses_arrets->isEmpty())
                    <ul>
                        @foreach($analyse->analyses_arrets as $arret)
                            <li>
                                <a href="#{{ $arret->reference }}">{{ $arret->reference.' du '.$arret->pub_date->formatLocalized('%d %B %Y') }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <p>{!! $analyse->abstract !!}</p>

            @endforeach
        </div>
        <div class="arret-categories">
            <img border="0" alt="Analyses" src="<?php echo asset('newsletter/pictos/analyse.png') ?>">
        </div>
    </div><hr>
@endif

