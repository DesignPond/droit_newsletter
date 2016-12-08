<table>
    <tr>
        <td align="left" width="65%">
            @if(!empty($analyses))
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
            @endif
        </td>
        <td width="30%">
            <img border="0" alt="Analyses" src="<?php echo asset('newsletter/pictos/analyse.png') ?>">
        </td>
    </tr>
</table>
