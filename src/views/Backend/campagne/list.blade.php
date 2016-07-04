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
                            <form action="{{ url('build/campagne/send') }}" id="sendCampagneForm" method="POST">{!! csrf_field() !!}
                                <input name="id" value="{{ $campagne->id }}" type="hidden">
                                <a href="javascript:;" data-campagne="{{ $campagne->id }}" class="btn btn-warning btn-sm" id="bootbox">
                                    <i class="fa fa-exclamation"></i> &nbsp;Envoyer la campagne
                                </a>
                            </form>
                        @else
                            Envoyé le {{ $campagne->updated_at->formatLocalized('%d %b %Y') }} à {{ $campagne->updated_at->toTimeString() }}
                        @endif
                    </td>
                    <td class="text-right">
                        <form action="{{ url('build/campagne/'.$campagne->id) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">{!! csrf_field() !!}
                            <button data-action="campagne {{ $campagne->sujet }}" data-what="Supprimer" class="btn btn-danger btn-xs deleteActionNewsletter"><i class="fa fa-remove"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Aucune newsletter en cours</p>
@endif