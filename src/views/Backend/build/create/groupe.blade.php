<form class="row form-horizontal" name="arretForm" method="post" action="<?php echo url('build/content'); ?>">{{ csrf_field() }}

    <div class="col-md-7" id="StyleNewsletterCreate"></div>
    <div class="col-md-5 create_content_form">
        <div class="panel panel-success">
            <div class="panel-body">

                <label for="categories" class="control-label">Catégorie</label>
                <select name="categorie_id" class="form-control chooseCategorie" style="margin-bottom: 10px; margin-top: 10px;"></select>

                <label>Sélectionner des arrêts</label>

                <div ng-controller="MultiSelectionController as selectarret">

                    <div class="listArrets forArrets" ng-init="typeItem='arrets'">
                        <div ng-repeat="(listName, list) in selectarret.models.lists">
                            <ul class="list-arrets" dnd-list="list">
                                <li ng-repeat="item in list"
                                    dnd-draggable="item"
                                    dnd-moved="list.splice($index, 1); logEvent('Container moved', event); selectarret.dropped(item)"
                                    dnd-effect-allowed="move"
                                    dnd-selected="models.selected = item"
                                    ng-class="{'selected': models.selected === item}" >
                                    {[{ item.reference }]}
                                    <input type="hidden" name="arrets[]" ng-if="item.isSelected" value="{[{ item.itemId }]}" />
                                </li>
                            </ul>
                        </div>
                        <div view-source="simple"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="btn-group" style="margin-top: 10px;">
                    <input type="hidden" value="{{ $bloc->id }}" name="type_id">
                    <input type="hidden" value="{{ $campagne->id }}" name="campagne">
                    <button type="submit" class="btn btn-sm btn-success">Envoyer</button>
                    <button type="button" class="btn btn-sm btn-default cancelCreate">Annuler</button>
                </div>

            </div>
        </div>
    </div>
</form>