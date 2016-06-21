<a id="{{ $bloc->template }}" class="blocEdit" rel="{{ $bloc->id }}">
    <img src="{{ asset('newsletter/blocs/'.$bloc->image) }}" alt="{{ $bloc->titre }}" />
    <span>{{ $bloc->titre }}</span>
</a>