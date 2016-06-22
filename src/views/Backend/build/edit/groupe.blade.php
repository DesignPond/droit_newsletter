<div class="edit_content" ng-controller="EditController as edit">

    <div class="pull-right btn-group btn-group-xs">
        <button class="btn btn-success finishEdit" ng-click="edit.finishEdit({{ $bloc->groupe_id }})" data-id="{{ $bloc->id }}" type="button">Terminer</button>
        <button class="btn btn-warning editContent" ng-click="edit.editContent({{ $bloc->id }})" data-id="{{ $bloc->id }}" type="button">éditer</button>
        <button class="btn btn-danger btn-xs deleteContent deleteContentBloc" data-id="{{ $bloc->id }}" data-action="groupe" type="button">&nbsp;×&nbsp;</button>
    </div>

    @if(!$bloc->groupe->arrets->isEmpty())

        <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="resetTable">
            <tr bgcolor="ffffff"><td colspan="3" height="35"></td></tr><!-- space -->
            <tr bgcolor="ffffff" class="blocBorder">
                <td width="400" align="left" class="resetMarge contentForm" valign="top">
                    <h3 style="text-align: left;font-family: sans-serif;">{{ $bloc->groupe->categorie->title }}</h3>
                </td>
                <td width="160" align="center" valign="top" class="resetMarge">
                    <img width="130" border="0" src="{{ asset(config('newsletter.path.categorie').$bloc->groupe->categorie->image) }}" alt="{{ $bloc->groupe->categorie->title }}" />
                </td>
            </tr><!-- space -->
        </table>

        <!-- Bloc content-->
        <div id="sortGroupe_{{ $bloc->groupe_id }}" style="width: 560px;" class="sortGroupe" data-group="{{ $bloc->groupe_id }}">

            @foreach($bloc->groupe->arrets as $arret)
                <!-- Bloc content-->
                <table id="groupe_rang_{{ $arret->id }}" border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="resetTable groupe_rang">
                    <tr bgcolor="ffffff"><td colspan="3" height="35"></td></tr><!-- space -->
                    <tr>
                        <td valign="top" width="375" class="resetMarge contentForm">
                            <div>
                                <h3 style="text-align: left;font-family: sans-serif;">{{ $arret->dumois ? 'Arrêt du mois : ' : '' }}{{ $arret->reference }} du {{ $arret->pub_date->formatLocalized('%d %B %Y') }}</h3>
                                <p class="abstract">{!! $arret->abstract !!}</p>
                                <div>{!! $arret->pub_text !!}</div>
                                <p><a href="{{ asset(config('newsletter.path.arret').$arret->file) }}">Télécharger en pdf</a></p>
                            </div>
                        </td>
                        <td width="25" height="1" class="resetMarge" valign="top" style="font-size: 1px; line-height: 1px;margin: 0;padding: 0;"></td><!-- space -->
                        <td align="center" valign="top" width="160" class="resetMarge">
                            <!-- Categories -->
                            <div class="resetMarge">
                                @if(!$arret->categories->isEmpty() )
                                    @include('newsletter::Email.send.partials.categories',['categories' => $arret->categories])
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr bgcolor="ffffff"><td colspan="3" height="35" class="blocBorder"></td></tr><!-- space -->
                    <tr>
                        <td colspan="3">
                            <!-- Analyses -->
                            @include('newsletter::Email.send.partials.analyses', ['arret' => $arret])
                            <!-- End Analyses -->
                        </td>
                    </tr>
                </table>
                <!-- Bloc content-->
            @endforeach

        </div>
    @endif
</div>
