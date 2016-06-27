@extends('newsletter::Backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-6">
        <h3>Liste des newsletter</h3>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ url('build/newsletter/create') }}" class="btn btn-success" id="addNewsletter"><i class="fa fa-plus"></i> &nbsp;Newsletter</a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        @if(!$newsletters->isEmpty())
            @foreach($newsletters as $newsletter)

                <div class="panel panel-info">
                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-7">
                                <h3>{{ $newsletter->titre }}</h3>
                            </div>
                            <div class="col-md-3">
                                <p><i class="fa fa-user"></i> &nbsp; {{ $newsletter->from_name }}</p>
                                <p><i class="fa fa-envelope"></i> &nbsp; {{ $newsletter->from_email }}</p>
                            </div>
                            <div class="col-md-2 text-right">
                                <div class="btn-group-vertical" role="group">
                                    <a href="{{ url('build/newsletter/'.$newsletter->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> &nbsp;Editer</a>
                                    <a href="{{ url('build/campagne/create/'.$newsletter->id) }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> &nbsp;Campagne</a>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                @if(!$newsletter->campagnes->isEmpty())
                                    <table class="table table-bordered table-striped">
                                       <thead>
                                           <tr>
                                               <th class="col-md-2">Sujet</th>
                                               <th class="col-md-3">Auteurs</th>
                                               <th class="col-md-1">Status</th>
                                               <th class="col-md-1"></th>
                                               <th class="col-md-2"></th>
                                               <th class="col-md-2"></th>
                                               <th class="col-md-1" style="width: 40px;"></th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                            @foreach($newsletter->campagnes as $campagne)
                                                <tr>
                                                    <td><strong><a href="{{ url('build/campagne/'.$campagne->id.'/edit') }}">{{ $campagne->sujet }}</a></strong></td>
                                                    <td>{{ $campagne->auteurs }}</td>
                                                    <td>
                                                        @if($campagne->status == 'brouillon')
                                                            <span class="label label-default">Brouillon</span>
                                                        @else
                                                            <span class="label label-success">Envoyé</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-info btn-sm btn-block" href="{{ url('build/campagne/'.$campagne->id) }}">Composer</a>
                                                        @if($campagne->status == 'envoyé')
                                                            <a class="btn btn-primary btn-sm btn-block" href="{{ url('build/statistics/'.$campagne->id) }}">Stats</a>
                                                            <a href="javascript:;" class="btn btn-default btn-sm btn-block sendEmailNewsletter" data-campagne="{{ $campagne->id }}">Envoyer par email</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($campagne->status == 'brouillon')
                                                            <form action="{{ url('build/campagne/send') }}" id="sendCampagneForm" method="POST">
                                                                {!! csrf_field() !!}
                                                                <input name="id" value="{{ $campagne->id }}" type="hidden">
                                                                <a href="javascript:;" data-campagne="{{ $campagne->id }}" class="btn btn-sm btn-warning btn-block" id="bootbox-demo-3">
                                                                    <i class="fa fa-exclamation"></i> &nbsp;Envoyer la campagne
                                                                </a>
                                                            </form>
                                                        @else
                                                           Envoyé le {{ $campagne->updated_at->formatLocalized('%d %b %Y') }} à {{ $campagne->updated_at->toTimeString() }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#sendToList">Envoyer à une liste</button>
                                                        @include('newsletter::Backend.template.partials.send', ['campagne' => $campagne])
                                                    </td>
                                                    <td class="text-right">
                                                        <form action="{{ url('build/campagne/'.$campagne->id) }}" method="POST">
                                                            <input type="hidden" name="_method" value="DELETE">{!! csrf_field() !!}
                                                            <button data-action="campagne {{ $campagne->sujet }}" data-what="Supprimer" class="btn btn-danger btn-xs deleteAction"><i class="fa fa-remove"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                       </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ url('build/newsletter/'.$newsletter->id) }}" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">{!! csrf_field() !!}
                                    <button data-what="supprimer" data-action="newsletter {{ $newsletter->titre }}" class="btn btn-xs btn-danger btn-delete deleteAction">Supprimer la newsletter</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

            @endforeach
        @endif

    </div>
</div>

@stop
