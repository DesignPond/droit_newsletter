<table border="0" width="160" align="center" cellpadding="0" cellspacing="0">
    <tr align="center" style="margin: 0;padding: 0;">
        <td style="margin: 0;padding: 0;page-break-before: always;" valign="top">
            @foreach($categories as $categorie)
               <a target="_blank" href="{{ url('jurisprudence') }}#{{ $bloc->reference }}">
                   <img width="130" border="0" alt="{{ $categorie->title }}" src="{{ asset('newsletter/pictos/'.$categorie->image) }}">
               </a>
            @endforeach
        </td>
    </tr>
</table>