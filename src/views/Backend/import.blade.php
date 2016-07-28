@extends('newsletter::Backend.layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-primary">

                <form action="{{ url('build/import') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">{!! csrf_field() !!}
                    <div class="panel-heading">
                        <h4>Importer une liste</h4>
                    </div>
                    <div class="panel-body">
                        <p>Les emails seront importé dans la liste d'envoi de la newsletter choisie et synchronisés sur le service externe.</p>
                        <hr/>
                        <div class="form-group">
                            <label for="message" class="col-sm-3 control-label">Nom de la liste</label>
                            <div class="col-sm-8">
                                <select class="form-control" required name="newsletter_id">
                                    <option value="">Choix de la newsletter</option>
                                    @if(!empty($newsletters))
                                        @foreach($newsletters as $list)
                                            <option value="{{ $list->id }}">{{ $list->titre }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message" class="col-sm-3 control-label">Fichier excel</label>
                            <div class="col-sm-8">
                                <input type="file" required name="file">
                            </div>
                        </div>

                        <hr/>
                        <p><strong>Format du fichier excel:</strong></p>
                        <p>Dans la première case de la colonne mettre "email" puis continuer avec la liste des emails.</p>
                        <table class="table table-condensed table-bordered" style="width: auto;">
                            <tr><th>email</th></tr>
                            <tr><td>nom.prenom@domaine.ch</td></tr>
                            <tr><td>nom.prenom@domaine.ch</td></tr>
                            <tr><td>etc...</td></tr>
                        </table>

                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-8 text-right">
                                <button class="btn btn-primary" type="submit">Envoyer</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@stop
