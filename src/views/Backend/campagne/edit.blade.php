@extends('newsletter::Backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-8">

        <div class="options" style="margin-bottom: 10px;">
            <div class="btn-toolbar">
                <a href="{{ url('build/newsletter') }}" class="btn btn-info"><i class="fa fa-chevron-left"></i> &nbsp;Retour aux newsletter</a>
                <a href="{{ url('build/campagne/'.$campagne->id) }}" class="btn btn-inverse pull-right"> Composer la campagne  &nbsp;<i class="fa fa-chevron-right"></i></a>
            </div>
        </div>

        <div class="panel panel-primary">

            <form action="{{ url('build/campagne/'.$campagne->id) }}" method="POST" class="form-horizontal">
                <input type="hidden" name="_method" value="PUT">{!! csrf_field() !!}
                <div class="panel-body event-info">
                    <h4>&Eacute;diter la campagne</h4>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Sujet</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="sujet" value="{{ $campagne->sujet }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Auteurs</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="auteurs" value="{{ $campagne->auteurs }}">
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-3">{!! Form::hidden('id', $campagne->id ) !!}</div>
                        <div class="col-sm-6">
                            <button class="btn btn-primary" type="submit">Éditer</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>

    </div>
</div>

@stop
