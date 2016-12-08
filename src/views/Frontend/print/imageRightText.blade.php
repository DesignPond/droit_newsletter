<table>
    <tr>
        <td align="left" width="65%">
            <div class="bloc-content">
                <h2>{{ $bloc->titre }}</h2>
                {!! $bloc->contenu !!}
            </div><!--END POST-->
        </td>
        <td width="30%">
            <a class="thumb" target="_blank" href="{{ isset($bloc->lien) && !empty($bloc->lien) ? $bloc->lien : url('/') }}">
                <img style="max-width: 130px; max-height: 200px;" alt="{{ $bloc->titre }}" src="{{ asset(config('newsletter.path.upload').$bloc->image.'') }}" />
            </a>
        </td>
    </tr>
</table>