<form ng-controller="SelectController as select" class="row form-horizontal" name="arretForm" method="post" action="{{ url('build/content') }}">{{ csrf_field() }}
    <div class="col-md-7" id="StyleNewsletterCreate">
        <!-- Bloc content-->
        <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="resetTable">
            <tr>
                <td valign="top" width="375" class="resetMarge contentForm">
                    <div ng-show="select.arret" ng-model="select.arret">
                        <h3>{[{ select.arret.reference }]} <span ng-show="select.arret.reference">du</span> {[{ select.date | date: 'fullDate' }]}</h3>
                        <p class="abstract">{[{ select.arret.abstract }]}</p>
                        <div class="content" ng-bind-html='select.arret.pub_text'></div>
                        <p><a href="{{ asset(config('newsletter.path.arret').'{[{ select.arret.file }]}') }}">Télécharger en pdf</a></p>
                    </div>
                </td>
                <td width="25" class="resetMarge"></td><!-- space -->
                <td align="center" valign="top" width="160" class="resetMarge">
                    <!-- Categories -->
                    <div class="resetMarge" ng-repeat="categorie in select.categories">
                        <a target="_blank" href="{{ url('jurisprudence#'.$bloc->reference) }}">
                            <img ng-show="categorie.image" width="130" border="0" alt="{[{ categorie.title }]}" ng-src="{{ asset(config('newsletter.path.categorie').'{[{ categorie.image }]}') }}">
                        </a>
                    </div>
                </td>
            </tr>
        </table>
        <!-- Bloc content-->

    </div>
    <div class="col-md-5 create_content_form">

        <div class="panel panel-success">
            <div class="panel-body">
                <label>Sélectionner l'arrêt</label>
                <select class="form-control" name="arret_id" ng-change="select.changed()" ng-model="selected" ng-options="arret.reference for arret in select.arrets track by arret.id">
                    <option value="">Choisir</option>
                </select>

                <div class="btn-group" style="margin-top: 10px;">
                    <input type="hidden" value="{[{ select.arret.id }]}" name="arret_id">
                    <input type="hidden" value="{{ $bloc->id }}" name="type_id">
                    <input type="hidden" value="{{ $campagne->id }}" name="campagne">
                    <button type="submit" class="btn btn-sm btn-success">Envoyer</button>
                    <button type="button" class="btn btn-sm btn-default cancelCreate">Annuler</button>
                </div>
            </div>
        </div>

    </div>
</form>