<!-- Modal -->
<div class="modal fade" id="sendToList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form action="{{ url('build/liste/send') }}" method="POST">{!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Envoyer à la liste hors newsletter</h4>
                </div>
                <div class="modal-body">
                    <input name="campagne_id" value="{{ $campagne->id }}" type="hidden">

                    @if(!$listes->isEmpty())
                        <select class="form-control" name="list_id">
                            <option value="">Liste</option>
                            @foreach($listes as $liste)
                                <option value="{{ $liste->id }}">{{ $liste->title }}</option>
                            @endforeach
                        </select>
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </div>
        </form>
    </div>
</div>