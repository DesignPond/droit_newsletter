<form flow-init flow-file-added="!!{png:1,gif:1,jpg:1,jpeg:1}[$file.getExtension()]"
      ng-controller="CreateController as creation"
      flow-fileError="handleErrorsUpload( $file, $message, $flow )"
      flow-files-submitted="$flow.upload()"
      class="row" name="blocForm" class="form-horizontal"
      method="post" action="<?php echo url('build/content'); ?>">{{ csrf_field() }}

    <div class="col-md-7" id="StyleNewsletterCreate">
        <!-- Bloc content-->
        <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="resetTable">
            <tr>
                <td valign="top" align="center" width="100%" class="resetMarge">
                    <div class="uploadBtn">
                        <span class="btn btn-xs btn-info" ng-hide="$flow.files.length" flow-btn flow-attrs="{accept:'image/*'}">Selectionner image</span>
                        <span class="btn btn-xs btn-warning" ng-show="$flow.files.length" flow-btn flow-attrs="{accept:'image/*'}">Changer</span>
                        <span class="btn btn-xs btn-danger" ng-show="$flow.files.length" ng-click="$flow.cancel()">Supprimer</span>
                    </div>
                    <div class="thumbnail big" ng-hide="$flow.files.length"><img src="http://www.placehold.it/560x160/EFEFEF/AAAAAA&text=choisir+une+image" /></div>
                    <div class="thumbnail big" ng-show="$flow.files.length"><img flow-img="$flow.files[0]" /></div>

                    <p style="visibility: hidden;height: 1px;margin: 0;"><input type="text" class="uploadImage" name="image" value="{[{ $flow.files[0].name }]}"></p>

                    <p class="errorUpload bg-danger text-danger" style="display: none;"></p>
                </td>
            </tr>
            <tr><td colspan="3" height="25"></td></tr>
            <tr>
                <td valign="top" align="center" width="100%" class="resetMarge contentForm">
                    <h2 ng-bind="create.titre"></h2>
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
                    <input bind-content ng-model="create.titre" type="text" value="" name="titre" class="form-control">
                </div>
                <div class="form-group">
                    <label>Ajouter un lien sur l'image</label>
                    <input type="text" value="" name="lien" class="form-control">
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
