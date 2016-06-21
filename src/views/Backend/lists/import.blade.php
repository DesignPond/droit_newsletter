@extends('newsletter::Backend.lists.index')
@section('list')
    @parent

    <div class="panel panel-primary">
        <form action="{{ url('build/liste') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">{!! csrf_field() !!}

            <div class="panel-body">
                <h4>Importer une liste</h4>

                <div class="form-group">
                    <label for="type" class="col-sm-3 control-label">Titre de la liste</label>
                    <div class="col-sm-8">
                        <input type="text" value="{{ old('title') }}" required name="title" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="message" class="col-sm-3 control-label">Fichier excel</label>
                    <div class="col-sm-8">
                        <input type="file" required name="file">
                    </div>
                </div>

            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-3"><input type="hidden" value="" name="newsletter_id"></div>
                    <div class="col-sm-8 text-right">
                        <button class="btn btn-primary" type="submit">Envoyer</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection