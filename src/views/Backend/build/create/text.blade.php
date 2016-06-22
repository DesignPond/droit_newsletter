<form flow-init flow-file-added="!!{png:1,gif:1,jpg:1,jpeg:1}[$file.getExtension()]"
      flow-files-submitted="$flow.upload()"
      class="row" name="blocForm" class="form-horizontal"
      method="post" action="{{ url('build/content') }}">{{ csrf_field() }}

    <div class="col-md-7" id="StyleNewsletterCreate">
        <!-- Bloc content-->
        <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="resetTable">
            <tr>
                <td valign="top" align="left" width="100%" class="resetMarge contentForm">
                    <h2 ng-bind="create.titre"></h2>
                    <div ng-bind-html="create.contenu | to_trusted"></div>
                </td>
            </tr>
        </table>
        <!-- Bloc content-->
    </div>
    <div class="col-md-5 create_content_form">

        <div class="panel panel-success">
            <div class="panel-body">
                <div class="form-group">
                    <label>Titre</label>
                    <input bind-content ng-model="create.titre" type="text" value="" required name="titre" class="form-control">
                </div>
                <div class="form-group">
                    <label>Texte</label>
                    <textarea bind-content redactor ng-model="create.contenu" required name="contenu" class="form-control" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <div class="btn-group">
                        <input type="hidden" value="{{ $bloc->id }}" name="type_id">
                        <input type="hidden" value="{{ $campagne->id }}" name="campagne">
                        <button type="submit" class="btn btn-sm btn-success">Envoyer</button>
                        <button type="button" class="btn btn-sm btn-default cancelCreate">Annuler</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
