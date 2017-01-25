<form ng-controller="SelectProductController as select" class="row form-horizontal" name="productForm" method="post" action="{{ url('build/content') }}">
    {{ csrf_field() }}
    <div class="col-md-7" id="StyleNewsletterCreate">
        <!-- Bloc content-->
        <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="resetTable">
            <tr>
                <td valign="top" width="375" class="resetMarge contentForm">
                    <div ng-show="select.product" ng-model="select.product">
                        <h3>{[{ select.product.title }]}</h3>
                        <p class="abstract">{[{ select.product.teaser }]}</p>
                        <div class="content" ng-bind-html='select.product.description'></div>
                    </div>
                </td>
                <td valign="top" width="25" class="resetMarge"></td>
                <td valign="top" width="160" class="resetMarge">
                    <a href="{[{ select.product.link }]}">
                        <img class="media-object" style="max-width: 150px;" src="{[{ select.product.image }]}" />
                    </a>
                </td>
            </tr>
        </table>
        <!-- Bloc content-->

    </div>
    <div class="col-md-5 create_content_form">

        <div class="panel panel-success">
            <div class="panel-body">
                <label>Sélectionner le livre</label>
                <select class="form-control" name="product_id" ng-change="select.changed()" ng-model="selected" ng-options="product.title for product in select.products track by product.id"></select>

                <div class="btn-group" style="margin-top: 10px;">
                    <input type="hidden" value="{[{ select.product.id }]}" name="product_id">
                    <input type="hidden" value="{{ $bloc->id }}" name="type_id">
                    <input type="hidden" value="{{ $campagne->id }}" name="campagne">
                    <button type="submit" class="btn btn-sm btn-success">Envoyer</button>
                    <button type="button" class="btn btn-sm btn-default cancelCreate">Annuler</button>
                </div>
            </div>
        </div>

    </div>
</form>