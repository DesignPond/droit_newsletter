@extends('newsletter::Backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-info">

            <form action="{{ url('build/campagne') }}" data-validate="parsley" method="POST" class="validate-form form-horizontal">
                {!! csrf_field() !!}
                <div class="panel-body event-info">
                    <h4>Ajouter une campagne</h4>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Sujet</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="sujet" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Auteurs</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="auteurs" value="">
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <input type="hidden" name="newsletter_id" value="{{ $newsletter }}">
                            <button class="btn btn-primary" type="submit">Envoyer</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@stop
