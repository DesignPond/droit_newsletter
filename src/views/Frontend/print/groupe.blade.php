@if(isset($bloc->groupe) && !$bloc->groupe->arrets->isEmpty())
    <table>
        <tr>
            <td width="65%">
                <h2>{{ $bloc->groupe->categorie->title }}</h2>
            </td>
            <td width="30%" style="text-align: center;">
                <img style="max-width: 130px;" border="0" src="{{ asset(config('newsletter.path.categorie').$bloc->groupe->categorie->image) }}" alt="{{ $bloc->groupe->categorie->title }}" />
            </td>
        </tr>
        <tr><td height="10" colspan="2"></td></tr>

        @foreach($bloc->groupe->arrets as $arret)
            <?php $arret->load('categories');  ?>

            <tr>
                <td align="left" width="65%">
                    <h2>{{ $arret->reference }} du {{ $arret->pub_date->formatLocalized('%d %B %Y') }}</h2>
                    <p>{!! $arret->abstract !!}</p>
                    {!! $arret->pub_text !!}
                </td>
                <td width="30%">

                    @if(!$arret->categories->isEmpty())
                        @foreach($arret->categories as $categorie)
                            <a class="thumb" target="_blank" href="{{ config('newsletter.link.arret') }}#{{ $bloc->reference }}">
                                <img style="max-width: 130px;" border="0" alt="{{ $categorie->title }}" src="{{ asset(config('newsletter.path.categorie').$categorie->image) }}">
                            </a>
                        @endforeach
                    @endif

                </td>
            </tr>

        @endforeach
    </table>
@endif


