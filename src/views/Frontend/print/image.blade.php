<table>
    <tr>
        <td>
            <a target="_blank" href="{{ isset($bloc->lien) && !empty($bloc->lien) ? $bloc->lien : url('/') }}">
                <img alt="{{ $bloc->titre }}" src="{{ asset(config('newsletter.path.upload').$bloc->image) }}" />
            </a>
            <h2>{{ $bloc->titre }}</h2>
        </td>
    </tr>
</table>
