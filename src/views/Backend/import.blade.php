@extends('newsletter::Backend.layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">

                <form action="{{ url('build/import') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">{!! csrf_field() !!}
                    <div class="panel-heading">
                        <h4>Importer une liste</h4>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="message" class="col-sm-3 control-label">Fichier excel</label>
                            <div class="col-sm-6">
                                <input type="file" required name="file">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message" class="col-sm-3 control-label">Nom de la liste</label>
                            <div class="col-sm-5">
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

                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-6">
                                <button class="btn btn-primary" type="submit">Envoyer</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@stop
