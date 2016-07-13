<table border="0" width="160" align="center" cellpadding="0" cellspacing="0">
    <tr align="center" style="margin: 0;padding: 0;">
        <td style="margin: 0;padding: 0;page-break-before: always;" valign="top">
            @foreach($categories as $categorie)
                @if($bloc->groupe_id == 0 || (isset($bloc) && isset($bloc->groupe) && $bloc->groupe_id > 0 && $categorie->id != $bloc->groupe->categorie_id))
                    <a target="_blank" href="{{ config('newsletter.link.arret') }}#{{ $bloc->reference }}">
                       <img width="130" border="0" alt="{{ $categorie->title }}" src="{{ asset(config('newsletter.path.categorie').$categorie->image) }}">
                    </a>
                @endif
            @endforeach
        </td>
    </tr>
</table>