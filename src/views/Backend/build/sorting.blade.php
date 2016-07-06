@extends('newsletter::Backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-12">
        <h1>Changer l'ordre</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <p><a href="{{ url('build/campagne/'.$campagne->id) }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> &nbsp;Composer la campagne</a></p>
            </div>
            <div class="col-md-6">
                @if(!$clipboards->isEmpty())
                    <form action="{{ url('build/clipboard/paste') }}" class="pull-right" method="POST">{!! csrf_field() !!}
                        <div class="input-group">
                            <select name="id" class="form-control">
                                <option>Choisir un contenu à coller</option>
                                @foreach($clipboards as $clipboard)
                                    <option value="{{ $clipboard->id }}">{{ $clipboard->content->content_title }}</option>
                                @endforeach
                            </select>
                            <span class="input-group-btn">
                                <input name="campagne_id" value="{{ $campagne->id }}" type="hidden">
                                <input name="rang" value="{{ $contents->max('rang') }}" type="hidden">
                                <button type="submit" title="Coller" class="btn btn-warning"><i class="fa fa-clipboard"></i></button>
                            </span>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        <div class="panel panel-info">
            <div class="panel-body">
                @if(!$contents->isEmpty())
                    <div id="sortable_list">
                        @foreach($contents as $bloc)
                            <div class="bloc_rang bloc_move" id="bloc_rang_{{ $bloc->id }}" data-rel="{{ $bloc->id }}">
                                <h4>
                                    {{ $bloc->content_title }}
                                    <form action="{{ url('build/clipboard/copy') }}" class="pull-right" method="POST">{!! csrf_field() !!}
                                        <input name="content_id" value="{{ $bloc->id }}" type="hidden">
                                        <button type="submit" title="Copier" class="btn btn-default btn-xs"><i class="fa fa-clone"></i></button>
                                    </form>
                                </h4>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div><!-- end 12 col -->
</div><!-- end row -->

@stop