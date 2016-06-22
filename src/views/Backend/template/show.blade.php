@extends('newsletter::Backend.layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="options" style="margin-bottom: 10px;">
                <a href="{{ url('build/newsletter') }}" class="btn btn-info"><i class="fa fa-arrow-left"></i>  &nbsp;&nbsp;Retour aux newsletter</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">

                <form action="{{ url('build/newsletter/'.$newsletter->id) }}" data-validate="parsley" method="POST" enctype="multipart/form-data" class="validate-form form-horizontal">
                    <input type="hidden" name="_method" value="PUT">{!! csrf_field() !!}

                    <div class="panel-heading">
                        <h4>&Eacute;diter la newsletter</h4>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="message" class="col-sm-3 control-label">Titre</label>
                            <div class="col-sm-5">
                                <input type="text" required class="form-control" name="titre" value="{{ $newsletter->titre }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message" class="col-sm-3 control-label">Nom de la liste</label>
                            <div class="col-sm-5">
                                <select class="form-control" required name="list_id">
                                    <option value="">Choix de la liste</option>
                                    @if(!empty($lists))
                                        @foreach($lists as $list)
                                            <option {{ $newsletter->list_id == $list->ID ? 'selected' :'' }} value="{{ $list->ID }}">{{ $list->Name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        @if(config('newsletter.multi') && isset($sites))
                            <div class="form-group">
                                <label for="message" class="col-sm-3 control-label">Site</label>
                                <div class="col-sm-3">
                                    @if(!$sites->isEmpty())
                                        <select class="form-control" name="site_id">
                                            <option value="">Appartient au site</option>
                                            @foreach($sites as $site)
                                                <option {{ $newsletter->site_id == $site->id ? 'selected' : '' }} value="{{ $site->id }}">{{ $site->nom }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="message" class="col-sm-3 control-label">Envoyé par</label>
                            <div class="col-sm-5">
                                <input type="text" required class="form-control" name="from_name" value="{{ $newsletter->from_name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message" class="col-sm-3 control-label">Email d'envoi</label>
                            <div class="col-sm-5">
                                <input type="text" required class="form-control" name="from_email" value="{{ $newsletter->from_email }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message" class="col-sm-3 control-label">Email de retour</label>
                            <div class="col-sm-5">
                                <input type="text" required class="form-control" name="return_email" value="{{ $newsletter->return_email }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message" class="col-sm-3 control-label">Lien de désinscription</label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <span class="input-group-addon">{{ url('/') }}/</span>
                                    <input type="text" required class="form-control" name="unsuscribe" value="{{ $newsletter->unsuscribe }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message" class="col-sm-3 control-label">Couleur principale</label>
                            <div class="col-sm-3">
                                <input type="text" required class="form-control colorpicker" name="color" value="{{ $newsletter->color }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message" class="col-sm-3 control-label">Bannière avec logos</label>
                            <div class="col-sm-6">
                                @if($newsletter->banniere_logos)
                                    <p><img style="border: 1px solid #ddd;" src="{{ asset($newsletter->banniere_logos) }}" alt="Logos" /></p>
                                @endif
                                <input type="file" name="logos">
                                <p class="help-block">Taille max 600x130px</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message" class="col-sm-3 control-label">Bannière de titre</label>
                            <div class="col-sm-6">
                                @if($newsletter->banniere_header)
                                    <p><img style="border: 1px solid #ddd;" src="{{ asset($newsletter->banniere_header) }}" alt="Header" /></p>
                                @endif
                                <input type="file" name="header">
                                <p class="help-block">Taille max 600x160px</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message" class="col-sm-3 control-label">Logo soutien</label>
                            <div class="col-sm-6">
                                <div class="well">
                                    @if($newsletter->logo_soutien)
                                        <p><img style="border: 1px solid #ddd;" src="{{ asset($newsletter->logo_soutien) }}" alt="Soutien" /></p>
                                    @endif
                                    <input type="file" name="soutien">
                                    <p class="help-block">Taille max 105x50px</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer">
                       <div class="row">
                          <div class="col-sm-3"></div>
                          <div class="col-sm-6">
                              <input type="hidden" name="id" value="{{ $newsletter->id }}">
                              <button class="btn btn-primary" type="submit">Envoyer</button>
                          </div>
                       </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@stop
