<div class="edit_content" ng-controller="EditController as edit"
     flow-init
     flow-fileError="handleErrorsUpload( $file, $message, $flow )"
     flow-file-added="!!{png:1,gif:1,jpg:1,jpeg:1}[$file.getExtension()]"
     flow-complete="netedited = true"
     flow-files-submitted="$flow.upload()">

    <!-- Bloc content-->
    <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="resetTable">
        <tr bgcolor="ffffff">
            <td colspan="3" height="35">
                <div class="pull-right btn-group btn-group-xs">
                    <button class="btn btn-warning editContent" ng-click="edit.editContent({{ $bloc->id }}) && !$flow.files.length" data-id="{{ $bloc->id }}" type="button">éditer</button>
                    <button class="btn btn-danger deleteContent deleteContentBloc" data-id="{{ $bloc->id }}" data-action="{{ $bloc->titre }}" type="button">&nbsp;×&nbsp;</button>
                </div>
            </td>
        </tr><!-- space -->
        <tr>
            <td valign="top" align="center" width="100%" class="resetMarge">
                <div class="uploadBtn" ng-if="!notedited">
                    <span class="btn btn-xs btn-info" ng-if="edit.onedit( {{ $bloc->id }} )" flow-btn flow-attrs="{accept:'image/*'}">Changer image</span>
                    <span class="btn btn-xs btn-warning" ng-show="$flow.files.length" flow-btn flow-attrs="{accept:'image/*'}">Changer</span>
                    <span class="btn btn-xs btn-danger" ng-show="$flow.files.length" ng-click="$flow.cancel()">Supprimer</span>
                </div>
                <div class="thumbnail big" ng-hide="$flow.files.length">
                    <img flow-img="$flow.files[0]" ng-if="notedited"/>
                    <a target="_blank" href="{{ isset($bloc->lien) && !empty($bloc->lien) ? $bloc->lien : url('/') }}">
                        <img style="max-width: 557px;" alt="{{ $bloc->titre or '' }}" src="{{ asset(config('newsletter.path.upload').$bloc->image) }}" />
                    </a>
                </div>
                <div class="thumbnail big" ng-show="$flow.files.length"><img flow-img="$flow.files[0]" /></div>
                <p class="errorUpload bg-danger text-danger" style="display: none;"></p>
            </td>
        </tr>
        <tr bgcolor="ffffff">
            <td align="center" valign="top" width="560" class="resetMarge">
                @if( $bloc->titre )
                    <h2 ng-bind="edit.titre">{{ $bloc->titre }}</h2>
                @endif
            </td>
        </tr><!-- space -->
        <tr bgcolor="ffffff"><td colspan="3" height="35" class="blocBorder"></td></tr><!-- space -->
    </table>
    <!-- Bloc content-->

    <div class="edit_content_form" id="edit_{{ $bloc->id }}">
        <form name="editForm" method="post" action="{{ url('build/content/'.$bloc->id) }}"> {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">
            <div class="panel panel-orange">
                <div class="panel-body">
                    <div class="form-group">
                        <label>Titre</label>
                        <input type="text" value="{{ $bloc->titre }}" bind-content ng-model="edit.titre" name="titre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Ajouter un lien sur l'image</label>
                        <input type="text" value="{{ $bloc->lien }}" name="lien" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="hidden" value="{{ $bloc->id }}" name="id">
                        <input type="hidden" value="{{ $bloc->type_id }}" name="type_id">
                        <p style="visibility: hidden;height: 1px;margin: 0;" ng-if="$flow.files.length">
                            <input type="text" class="uploadImage" name="image" value="{[{ $flow.files[0].name }]}">
                        </p>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-sm btn-warning">Envoyer</button>
                            <button type="button" data-id="{{ $bloc->id }}" class="btn btn-sm btn-default cancelEdit">Annuler</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
