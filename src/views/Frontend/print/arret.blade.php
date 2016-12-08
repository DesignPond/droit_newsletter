<table>
    <tr>
        <td align="left" width="65%">
            <h2>{{ $bloc->arret->reference }} du {{ $bloc->arret->pub_date->formatLocalized('%d %B %Y') }}</h2>
            <p>{!! $bloc->arret->abstract !!}</p>

            {!! $bloc->arret->pub_text !!}
        </td>
        <td width="30%">
            @if(!$bloc->arret->categories->isEmpty() )
                @foreach($bloc->arret->categories as $categorie)
                    <a class="thumb" target="_blank" href="{{ url(config('newsletter.link.arret')) }}#{{ $bloc->reference }}">
                        <img style="max-width: 130px;" border="0"  alt="{{ $categorie->title }}" src="{{ asset(config('newsletter.path.categorie').$categorie->image) }}">
                    </a>
                @endforeach
            @endif
        </td>
    </tr>
</table>
