<!-- Modal -->
<div class="modal fade" id="sendModal_{{ $campagne->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('build/send/campagne') }}" class="form-inline" method="POST">{!! csrf_field() !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Envoyer la campagne!</h4>
                </div>
                <div class="modal-body">

                    <p>Etes-vous sûr de vouloir envoyer la campagne : <br/><strong>"{{ $campagne->sujet }}"</strong></p>
                    <br/>
                    <div class="row">
                        <label class="col-sm-6 col-xs-12 control-label text-danger">Spécifier une date d'envoi</label>
                        <div class="col-sm-6 col-xs-12 text-right">
                            <input type="text" class="form-control" id="datePickerNewsletter" value="" name="date">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input name="id" value="{{ $campagne->id }}" type="hidden">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-success">Envoyer</button>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
</div>