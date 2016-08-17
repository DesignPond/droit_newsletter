@if(!$campagnes->isEmpty())
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th class="col-md-2">Sujet</th>
            <th class="col-md-3">Auteurs</th>
            <th class="col-md-3"></th>
            <th class="col-md-3"></th>
            <th class="col-md-1"></th>
        </tr>
        </thead>
            @foreach($campagnes as $campagne)
                <tr class="campagne_{{ $campagne->status == 'brouillon' ? 'brouillon' : 'send' }}">
                    <td><strong><a href="{{ url('build/campagne/'.$campagne->id.'/edit') }}">{{ $campagne->sujet }}</a></strong></td>
                    <td>{{ $campagne->auteurs }}</td>
                    <td>
                        <div class="btn-group">
                            @if($campagne->status == 'envoyé')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('build/campagne/'.$campagne->id) }}">Composer</a></li>
                                        <li><a href="{{ url('build/statistics/'.$campagne->id) }}">Statistiques</a></li>
                                        <li><a href="javascript:;" class="sendEmailNewsletter" data-campagne="{{ $campagne->id }}">Envoyer par email</a></li>
                                        <li><a href="javascript:;" data-toggle="modal" data-target="#sendToList">Envoyer à une liste</a></li>
                                    </ul>
                                </div>
                            @else
                                <a class="btn btn-info btn-sm" href="{{ url('build/campagne/'.$campagne->id) }}">Composer</a>
                                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sendToList">Envoyer à une liste</a>
                            @endif

                            @include('newsletter::Backend.template.partials.send', ['campagne' => $campagne])
                        </div>
                    </td>
                    <td>
                        @if($campagne->status == 'brouillon')

                            <a href="javascript:;" data-toggle="modal" data-target="#sendModal_{{ $campagne->id }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-exclamation"></i> &nbsp;Envoyer la campagne
                            </a>

                            @include('newsletter::Backend.campagne.partials.send',['campagne' => $campagne])

                        @else
                            <p><strong>Envoyé le:</strong> <br/>{{ $campagne->updated_at->formatLocalized('%d %b %Y') }} à {{ $campagne->updated_at->toTimeString() }}</p>
                            @if($campagne->send_at && $campagne->send_at > \Carbon\Carbon::now())
                                <p><strong>Envoi prévu à:</strong> <br/>{{ $campagne->send_at->formatLocalized('%d %b %Y') }} à {{ $campagne->send_at->toTimeString() }}</p>
                                <div class="btn-group btn-group-sm">
                                    <a class="btn btn-info" target="_blank" href="{{ url('build/campagne/preview/'.$campagne->id) }}">Voir le preview</a>
                                    <a class="btn btn-warning" href="{{ url('build/campagne/cancel/'.$campagne->id) }}">Annuler l'envoi</a>
                                </div>
                            @endif
                        @endif
                    </td>
                    <td class="text-right">
                        <form action="{{ url('build/campagne/'.$campagne->id) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">{!! csrf_field() !!}
                            <button type="submit" data-action="campagne {{ $campagne->sujet }}" data-what="Supprimer" class="btn btn-danger btn-xs deleteNewsAction"><i class="fa fa-remove"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Aucune newsletter en cours</p>
@endif