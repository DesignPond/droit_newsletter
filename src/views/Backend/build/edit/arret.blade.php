<div class="edit_content">

    <button class="btn btn-danger btn-xs deleteContent deleteContentBloc pull-right" data-id="{{ $bloc->id }}" data-action="{{ $bloc->arret->reference }}" type="button">&nbsp;×&nbsp;</button>

    <!-- Arret -->
    @include('newsletter::Email.send.arret')
    <!-- End Arret -->

</div>
