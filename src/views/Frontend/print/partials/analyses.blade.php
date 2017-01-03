@if(!$arret->analyses->isEmpty())
    <div class="analyse">
        <div class="arret-content">
            <h4>{{ $arret->analyses->count() > 1 ? 'Des analyses' : 'Une analyse' }} existe pour cet arrêt</h4>

            @foreach($arret->analyses as $analyse)
                <!-- Authors -->
                @if(!$analyse->authors->isEmpty())
                    @foreach($analyse->authors as $author)
                        <h3 style="text-align: left;font-family: sans-serif;">Par {{ $author->name }}</h3>
                        <p style="font-family: sans-serif;">{{  $author->occupation }}</p>
                    @endforeach
                @endif
                <!-- End Authors -->
                <p class="abstract">{!! $analyse->abstract !!}</p>
            @endforeach

        </div>
    </div>
@endif