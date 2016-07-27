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

                    <p>Campagne : <br/><strong>"{{ $campagne->sujet }}"</strong></p>
                    <br/>
                    <div class="row">
                        <label class="col-sm-6 col-xs-12 control-label text-primary">Spécifier une date et heure d'envoi</label>
                        <div class="col-sm-6 col-xs-12 text-right">
                            <input type="text" class="form-control" id="datePickerNewsletter" value="" name="date">
                        </div>
                    </div>
                    <hr/>
                    <p class="text-danger">
                        <h4><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Attention</h4>
                        Sans date spécifié l'envoi est prévu avec un délai de 15 minutes pour permettre une éventuelle annulation.
                    </p>

                </div>
                <div class="modal-footer">
                    <input name="id" value="{{ $campagne->id }}" type="hidden">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane" aria-hidden="true"></i> &nbsp;Envoyer</button>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
</div>